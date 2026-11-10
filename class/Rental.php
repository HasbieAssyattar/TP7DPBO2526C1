<?php

class Rental {
    private $db;
    private $table = "rentals";

    private $id_rental;
    private $id_customer;
    private $id_camera;
    private $tgl_sewa;
    private $tgl_kembali;
    private $total;
    private $status_bayar;

    public function __construct($db) {
        $this->db = $db;
    }

    public function getIdRental() { return $this->id_rental; }
    public function getIdCustomer() { return $this->id_customer; }
    public function getIdCamera() { return $this->id_camera; }
    public function getTglSewa() { return $this->tgl_sewa; }
    public function getTglKembali() { return $this->tgl_kembali; }
    public function getTotal() { return $this->total; }
    public function getStatusBayar() { return $this->status_bayar; }

    public function setIdCustomer($id_customer) { $this->id_customer = (int)$id_customer; }
    public function setIdCamera($id_camera) { $this->id_camera = (int)$id_camera; }
    public function setTglSewa($tgl_sewa) { $this->tgl_sewa = $tgl_sewa; }
    public function setTglKembali($tgl_kembali) { $this->tgl_kembali = $tgl_kembali; }
    public function setTotal($total) { $this->total = (int)$total; }
    public function setStatusBayar($status_bayar) { $this->status_bayar = trim($status_bayar); }

    public function create() {
        $query = "INSERT INTO {$this->table} (id_customer, id_camera, tgl_sewa, tgl_kembali, total, status_bayar) 
                  VALUES (:id_customer, :id_camera, :tgl_sewa, :tgl_kembali, :total, :status_bayar)";
        $stmt = $this->db->prepare($query);
        $saved = $stmt->execute([
            ':id_customer' => $this->id_customer,
            ':id_camera' => $this->id_camera,
            ':tgl_sewa' => $this->tgl_sewa,
            ':tgl_kembali' => $this->tgl_kembali,
            ':total' => $this->total,
            ':status_bayar' => $this->status_bayar,
        ]);

        if ($saved) {
            $updateCam = $this->db->prepare("UPDATE cameras SET status = 'Disewa' WHERE id_camera = :id");
            $updateCam->execute([':id' => $this->id_camera]);
        }
        return $saved;
    }

    public function readAll() {
        $query = "SELECT r.*, c.nama AS nama_customer, cam.merek, cam.tipe, cam.harga AS harga_per_hari
                  FROM {$this->table} r
                  JOIN customers c ON r.id_customer = c.id_customer
                  JOIN cameras cam ON r.id_camera = cam.id_camera
                  ORDER BY r.id_rental DESC";
        $stmt = $this->db->prepare($query);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function readById($id) {
        $query = "SELECT r.*, c.nama AS nama_customer, cam.merek, cam.tipe, cam.harga AS harga_per_hari
                  FROM {$this->table} r
                  JOIN customers c ON r.id_customer = c.id_customer
                  JOIN cameras cam ON r.id_camera = cam.id_camera
                  WHERE r.id_rental = :id";
        $stmt = $this->db->prepare($query);
        $stmt->execute([':id' => $id]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    public function update($id) {
        $query = "UPDATE {$this->table} SET 
                  id_customer = :id_customer, 
                  id_camera = :id_camera, 
                  tgl_sewa = :tgl_sewa, 
                  tgl_kembali = :tgl_kembali, 
                  total = :total, 
                  status_bayar = :status_bayar 
                  WHERE id_rental = :id";
        $stmt = $this->db->prepare($query);
        return $stmt->execute([
            ':id' => $id,
            ':id_customer' => $this->id_customer,
            ':id_camera' => $this->id_camera,
            ':tgl_sewa' => $this->tgl_sewa,
            ':tgl_kembali' => $this->tgl_kembali,
            ':total' => $this->total,
            ':status_bayar' => $this->status_bayar,
        ]);
    }

    public function delete($id) {
        // Free camera back to 'Tersedia' on rental record removal
        $rental = $this->readById($id);
        if ($rental) {
            $restore = $this->db->prepare("UPDATE cameras SET status = 'Tersedia' WHERE id_camera = :id");
            $restore->execute([':id' => $rental['id_camera']]);
        }

        $query = "DELETE FROM {$this->table} WHERE id_rental = :id";
        $stmt = $this->db->prepare($query);
        return $stmt->execute([':id' => $id]);
    }
}
