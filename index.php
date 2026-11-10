<?php

require_once __DIR__ . '/config/config.php';
require_once __DIR__ . '/class/Customer.php';
require_once __DIR__ . '/class/Camera.php';
require_once __DIR__ . '/class/Rental.php';

$database = new Database();
$db = $database->getConnection();

$customerModel = new Customer($db);
$cameraModel = new Camera($db);
$rentalModel = new Rental($db);

$page = $_GET['page'] ?? 'customers';
$allowed_pages = ['customers', 'cameras', 'rentals'];
if (!in_array($page, $allowed_pages)) {
    $page = 'customers';
}

$action = $_GET['action'] ?? null;
$id = $_GET['id'] ?? null;
$edit_data = null;

// Handle penghapusan data via GET action
if ($action === 'delete' && $id) {
    if ($page === 'customers') {
        $customerModel->delete($id);
    } elseif ($page === 'cameras') {
        $cameraModel->delete($id);
    } elseif ($page === 'rentals') {
        $rentalModel->delete($id);
    }
    header("Location: index.php?page={$page}");
    exit;
}

// Handle form submission via POST
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $form_action = $_POST['action'] ?? '';

    if ($page === 'customers') {
        $customerModel->setNama($_POST['nama'] ?? '');
        $customerModel->setNoTelp($_POST['no_telp'] ?? '');
        $customerModel->setNik($_POST['nik'] ?? '');
        $customerModel->setTtg($_POST['ttg'] ?? '');

        if ($form_action === 'create') {
            $customerModel->create();
        } elseif ($form_action === 'update' && !empty($_POST['id_customer'])) {
            $customerModel->update((int)$_POST['id_customer']);
        }
    } elseif ($page === 'cameras') {
        $cameraModel->setMerek($_POST['merek'] ?? '');
        $cameraModel->setJenis($_POST['jenis'] ?? '');
        $cameraModel->setTipe($_POST['tipe'] ?? '');
        $cameraModel->setHarga($_POST['harga'] ?? 0);
        $cameraModel->setStatus($_POST['status'] ?? 'Tersedia');

        if ($form_action === 'create') {
            $cameraModel->create();
        } elseif ($form_action === 'update' && !empty($_POST['id_camera'])) {
            $cameraModel->update((int)$_POST['id_camera']);
        }
    } elseif ($page === 'rentals') {
        $rentalModel->setIdCustomer($_POST['id_customer'] ?? 0);
        $rentalModel->setIdCamera($_POST['id_camera'] ?? 0);
        $rentalModel->setTglSewa($_POST['tgl_sewa'] ?? '');
        $rentalModel->setTglKembali($_POST['tgl_kembali'] ?? '');
        $rentalModel->setTotal($_POST['total'] ?? 0);
        $rentalModel->setStatusBayar($_POST['status_bayar'] ?? 'Belum Lunas');

        if ($form_action === 'create') {
            $rentalModel->create();
        } elseif ($form_action === 'update' && !empty($_POST['id_rental'])) {
            $rentalModel->update((int)$_POST['id_rental']);
        }
    }

    header("Location: index.php?page={$page}");
    exit;
}

// Ambil data untuk form edit jika tombol edit diklik
if ($action === 'edit' && $id) {
    if ($page === 'customers') {
        $edit_data = $customerModel->readById($id);
    } elseif ($page === 'cameras') {
        $edit_data = $cameraModel->readById($id);
    } elseif ($page === 'rentals') {
        $edit_data = $rentalModel->readById($id);
    }
}

// Ambil data untuk render tampilan tabel
if ($page === 'customers') {
    $customers = $customerModel->readAll();
} elseif ($page === 'cameras') {
    $cameras = $cameraModel->readAll();
} elseif ($page === 'rentals') {
    $rentals = $rentalModel->readAll();
    $customer_list = $customerModel->readAll();
    $camera_list = $cameraModel->readAll();
}

include __DIR__ . '/view/header.php';
include __DIR__ . "/view/{$page}.php";
include __DIR__ . '/view/footer.php';
