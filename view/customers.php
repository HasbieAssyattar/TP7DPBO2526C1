<h3><?= $edit_data ? 'Edit Data Pelanggan' : 'Tambah Pelanggan Baru' ?></h3>

<form action="index.php?page=customers" method="POST">
    <input type="hidden" name="action" value="<?= $edit_data ? 'update' : 'create' ?>">
    <?php if ($edit_data): ?>
        <input type="hidden" name="id_customer" value="<?= htmlspecialchars($edit_data['id_customer']) ?>">
    <?php endif; ?>

    <div class="form-group">
        <label>Nama Lengkap:</label>
        <input type="text" name="nama" value="<?= htmlspecialchars($edit_data['nama'] ?? '') ?>" required>
    </div>

    <div class="form-group">
        <label>No. Telepon / WA:</label>
        <input type="text" name="no_telp" value="<?= htmlspecialchars($edit_data['no_telp'] ?? '') ?>" required>
    </div>

    <div class="form-group">
        <label>NIK (16 Digit):</label>
        <input type="text" name="nik" value="<?= htmlspecialchars($edit_data['nik'] ?? '') ?>" required>
    </div>

    <div class="form-group">
        <label>Tempat, Tanggal Lahir (TTG):</label>
        <input type="text" name="ttg" value="<?= htmlspecialchars($edit_data['ttg'] ?? '') ?>" required>
    </div>

    <button type="submit"><?= $edit_data ? 'Simpan Perubahan' : 'Tambah Pelanggan' ?></button>
    <?php if ($edit_data): ?>
        <a href="index.php?page=customers" style="margin-left: 10px;">Batal</a>
    <?php endif; ?>
</form>

<h3>Daftar Pelanggan</h3>
<table>
    <thead>
        <tr>
            <th>ID</th>
            <th>Nama</th>
            <th>No. Telepon</th>
            <th>NIK</th>
            <th>Tempat, Tanggal Lahir</th>
            <th>Aksi</th>
        </tr>
    </thead>
    <tbody>
        <?php if (!empty($customers)): ?>
            <?php foreach ($customers as $c): ?>
                <tr>
                    <td><?= htmlspecialchars($c['id_customer']) ?></td>
                    <td><?= htmlspecialchars($c['nama']) ?></td>
                    <td><?= htmlspecialchars($c['no_telp']) ?></td>
                    <td><?= htmlspecialchars($c['nik']) ?></td>
                    <td><?= htmlspecialchars($c['ttg']) ?></td>
                    <td>
                        <a href="index.php?page=customers&action=edit&id=<?= $c['id_customer'] ?>" class="btn-edit">Edit</a>
                        <a href="index.php?page=customers&action=delete&id=<?= $c['id_customer'] ?>" class="btn-danger" onclick="return confirm('Hapus data pelanggan ini?')">Hapus</a>
                    </td>
                </tr>
            <?php endforeach; ?>
        <?php else: ?>
            <tr><td colspan="6" style="text-align:center;">Belum ada data pelanggan.</td></tr>
        <?php endif; ?>
    </tbody>
</table>
