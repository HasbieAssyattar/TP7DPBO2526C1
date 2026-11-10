<?php

class Customer {
    private $db;
    private $table = "customers";

    private $id_customer;
    private $nama;
    private $no_telp;
    private $nik;
    private $ttg;

    public function __construct($db) {
        $this->db = $db;
    }

    public function getIdCustomer() { return $this->id_customer; }
    public function getNama() { return $this->nama; }
    public function getNoTelp() { return $this->no_telp; }
    public function getNik() { return $this->nik; }
    public function getTtg() { return $this->ttg; }

    public function setNama($nama) { $this->nama = trim($nama); }
    public function setNoTelp($no_telp) { $this->no_telp = trim($no_telp); }
    public function setNik($nik) { $this->nik = trim($nik); }
    public function setTtg($ttg) { $this->ttg = trim($ttg); }

    public function create() {
        $query = "INSERT INTO {$this->table} (nama, no_telp, nik, ttg) VALUES (:nama, :no_telp, :nik, :ttg)";
        $stmt = $this->db->prepare($query);
        return $stmt->execute([
            ':nama' => $this->nama,
            ':no_telp' => $this->no_telp,
            ':nik' => $this->nik,
            ':ttg' => $this->ttg,
        ]);
    }

    public function readAll() {
        $query = "SELECT * FROM {$this->table} ORDER BY id_customer DESC";
        $stmt = $this->db->prepare($query);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function readById($id) {
        $query = "SELECT * FROM {$this->table} WHERE id_customer = :id";
        $stmt = $this->db->prepare($query);
        $stmt->execute([':id' => $id]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    public function update($id) {
        $query = "UPDATE {$this->table} SET nama = :nama, no_telp = :no_telp, nik = :nik, ttg = :ttg WHERE id_customer = :id";
        $stmt = $this->db->prepare($query);
        return $stmt->execute([
            ':id' => $id,
            ':nama' => $this->nama,
            ':no_telp' => $this->no_telp,
            ':nik' => $this->nik,
            ':ttg' => $this->ttg,
        ]);
    }

    public function delete($id) {
        $query = "DELETE FROM {$this->table} WHERE id_customer = :id";
        $stmt = $this->db->prepare($query);
        return $stmt->execute([':id' => $id]);
    }
}
