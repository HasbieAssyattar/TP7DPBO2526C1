<?php

class Camera {
    private $db;
    private $table = "cameras";

    private $id_camera;
    private $merek;
    private $jenis;
    private $tipe;
    private $harga;
    private $status;

    public function __construct($db) {
        $this->db = $db;
    }

    public function getIdCamera() { return $this->id_camera; }
    public function getMerek() { return $this->merek; }
    public function getJenis() { return $this->jenis; }
    public function getTipe() { return $this->tipe; }
    public function getHarga() { return $this->harga; }
    public function getStatus() { return $this->status; }

    public function setMerek($merek) { $this->merek = trim($merek); }
    public function setJenis($jenis) { $this->jenis = trim($jenis); }
    public function setTipe($tipe) { $this->tipe = trim($tipe); }
    public function setHarga($harga) { $this->harga = (int)$harga; }
    public function setStatus($status) { $this->status = trim($status); }

    public function create() {
        $query = "INSERT INTO {$this->table} (merek, jenis, tipe, harga, status) VALUES (:merek, :jenis, :tipe, :harga, :status)";
        $stmt = $this->db->prepare($query);
        return $stmt->execute([
            ':merek' => $this->merek,
            ':jenis' => $this->jenis,
            ':tipe' => $this->tipe,
            ':harga' => $this->harga,
            ':status' => $this->status ?: 'Tersedia',
        ]);
    }

    public function readAll() {
        $query = "SELECT * FROM {$this->table} ORDER BY id_camera DESC";
        $stmt = $this->db->prepare($query);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function readAvailable() {
        $query = "SELECT * FROM {$this->table} WHERE status = 'Tersedia' ORDER BY merek ASC";
        $stmt = $this->db->prepare($query);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function readById($id) {
        $query = "SELECT * FROM {$this->table} WHERE id_camera = :id";
        $stmt = $this->db->prepare($query);
        $stmt->execute([':id' => $id]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    public function update($id) {
        $query = "UPDATE {$this->table} SET merek = :merek, jenis = :jenis, tipe = :tipe, harga = :harga, status = :status WHERE id_camera = :id";
        $stmt = $this->db->prepare($query);
        return $stmt->execute([
            ':id' => $id,
            ':merek' => $this->merek,
            ':jenis' => $this->jenis,
            ':tipe' => $this->tipe,
            ':harga' => $this->harga,
            ':status' => $this->status,
        ]);
    }

    public function updateStatus($id, $status) {
        $query = "UPDATE {$this->table} SET status = :status WHERE id_camera = :id";
        $stmt = $this->db->prepare($query);
        return $stmt->execute([':id' => $id, ':status' => $status]);
    }

    public function delete($id) {
        $query = "DELETE FROM {$this->table} WHERE id_camera = :id";
        $stmt = $this->db->prepare($query);
        return $stmt->execute([':id' => $id]);
    }
}
