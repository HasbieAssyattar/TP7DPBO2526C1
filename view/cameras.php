<h3><?= $edit_data ? 'Edit Data Kamera' : 'Tambah Kamera Baru' ?></h3>

<form action="index.php?page=cameras" method="POST">
    <input type="hidden" name="action" value="<?= $edit_data ? 'update' : 'create' ?>">
    <?php if ($edit_data): ?>
        <input type="hidden" name="id_camera" value="<?= htmlspecialchars($edit_data['id_camera']) ?>">
    <?php endif; ?>

    <div class="form-group">
        <label>Merek:</label>
        <input type="text" name="merek" placeholder="Sony / Canon / Fujifilm" value="<?= htmlspecialchars($edit_data['merek'] ?? '') ?>" required>
    </div>

    <div class="form-group">
        <label>Jenis:</label>
        <select name="jenis" required>
            <?php
            $jenis_options = ['Mirrorless', 'DSLR', 'Digital Pocket', 'Action Cam'];
            foreach ($jenis_options as $j):
                $selected = (isset($edit_data['jenis']) && $edit_data['jenis'] === $j) ? 'selected' : '';
                echo "<option value=\"$j\" $selected>$j</option>";
            endforeach;
            ?>
        </select>
    </div>

    <div class="form-group">
        <label>Tipe Model:</label>
        <input type="text" name="tipe" placeholder="Contoh: Alpha A7 IV" value="<?= htmlspecialchars($edit_data['tipe'] ?? '') ?>" required>
    </div>

    <div class="form-group">
        <label>Harga Sewa / Hari (Rp):</label>
        <input type="number" name="harga" placeholder="250000" value="<?= htmlspecialchars($edit_data['harga'] ?? '') ?>" required>
    </div>

    <div class="form-group">
        <label>Status Ketersediaan:</label>
        <select name="status" required>
            <?php
            $status_options = ['Tersedia', 'Disewa', 'Maintenance'];
            foreach ($status_options as $s):
                $selected = (isset($edit_data['status']) && $edit_data['status'] === $s) ? 'selected' : '';
                echo "<option value=\"$s\" $selected>$s</option>";
            endforeach;
            ?>
        </select>
    </div>

    <button type="submit"><?= $edit_data ? 'Simpan Perubahan' : 'Tambah Kamera' ?></button>
    <?php if ($edit_data): ?>
        <a href="index.php?page=cameras" style="margin-left: 10px;">Batal</a>
    <?php endif; ?>
</form>

<h3>Daftar Kamera</h3>
<table>
    <thead>
        <tr>
            <th>ID</th>
            <th>Merek</th>
            <th>Jenis</th>
            <th>Tipe Model</th>
            <th>Harga / Hari</th>
            <th>Status</th>
            <th>Aksi</th>
        </tr>
    </thead>
    <tbody>
        <?php if (!empty($cameras)): ?>
            <?php foreach ($cameras as $cam): ?>
                <tr>
                    <td><?= htmlspecialchars($cam['id_camera']) ?></td>
                    <td><?= htmlspecialchars($cam['merek']) ?></td>
                    <td><?= htmlspecialchars($cam['jenis']) ?></td>
                    <td><?= htmlspecialchars($cam['tipe']) ?></td>
                    <td>Rp <?= number_format($cam['harga'], 0, ',', '.') ?></td>
                    <td><strong><?= htmlspecialchars($cam['status']) ?></strong></td>
                    <td>
                        <a href="index.php?page=cameras&action=edit&id=<?= $cam['id_camera'] ?>" class="btn-edit">Edit</a>
                        <a href="index.php?page=cameras&action=delete&id=<?= $cam['id_camera'] ?>" class="btn-danger" onclick="return confirm('Hapus data kamera ini?')">Hapus</a>
                    </td>
                </tr>
            <?php endforeach; ?>
        <?php else: ?>
            <tr><td colspan="7" style="text-align:center;">Belum ada data kamera.</td></tr>
        <?php endif; ?>
    </tbody>
</table>
