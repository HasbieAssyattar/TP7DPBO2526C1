<h3><?= $edit_data ? 'Edit Transaksi Rental' : 'Tambah Transaksi Rental' ?></h3>

<form action="index.php?page=rentals" method="POST">
    <input type="hidden" name="action" value="<?= $edit_data ? 'update' : 'create' ?>">
    <?php if ($edit_data): ?>
        <input type="hidden" name="id_rental" value="<?= htmlspecialchars($edit_data['id_rental']) ?>">
    <?php endif; ?>

    <div class="form-group">
        <label>Pilih Pelanggan:</label>
        <select name="id_customer" required>
            <option value="">-- Pilih Pelanggan --</option>
            <?php foreach ($customer_list as $c): ?>
                <?php $selected = ($edit_data && $edit_data['id_customer'] == $c['id_customer']) ? 'selected' : ''; ?>
                <option value="<?= $c['id_customer'] ?>" <?= $selected ?>>
                    <?= htmlspecialchars($c['nama']) ?> (NIK: <?= htmlspecialchars($c['nik']) ?>)
                </option>
            <?php endforeach; ?>
        </select>
    </div>

    <div class="form-group">
        <label>Pilih Kamera:</label>
        <select name="id_camera" id="id_camera" required onchange="calculateAutoTotal()">
            <option value="">-- Pilih Kamera --</option>
            <?php foreach ($camera_list as $cam): ?>
                <?php
                $is_current = ($edit_data && $edit_data['id_camera'] == $cam['id_camera']);
                $selected = $is_current ? 'selected' : '';
                ?>
                <option value="<?= $cam['id_camera'] ?>" data-harga="<?= $cam['harga'] ?>" <?= $selected ?>>
                    <?= htmlspecialchars($cam['merek']) ?> <?= htmlspecialchars($cam['tipe']) ?> - Rp <?= number_format($cam['harga'], 0, ',', '.') ?>/hari (<?= $cam['status'] ?>)
                </option>
            <?php endforeach; ?>
        </select>
    </div>

    <div class="form-group">
        <label>Tanggal Mulai Sewa:</label>
        <input type="date" name="tgl_sewa" id="tgl_sewa" value="<?= htmlspecialchars($edit_data['tgl_sewa'] ?? date('Y-m-d')) ?>" required onchange="calculateAutoTotal()">
    </div>

    <div class="form-group">
        <label>Tanggal Selesai Sewa:</label>
        <input type="date" name="tgl_kembali" id="tgl_kembali" value="<?= htmlspecialchars($edit_data['tgl_kembali'] ?? date('Y-m-d', strtotime('+1 day'))) ?>" required onchange="calculateAutoTotal()">
    </div>

    <div class="form-group">
        <label>Total Biaya Sewa (Rp):</label>
        <input type="number" name="total" id="total" value="<?= htmlspecialchars($edit_data['total'] ?? '') ?>" required>
    </div>

    <div class="form-group">
        <label>Status Pembayaran:</label>
        <select name="status_bayar" required>
            <?php
            $bayar_options = ['Belum Lunas', 'DP', 'Lunas'];
            foreach ($bayar_options as $b):
                $selected = (isset($edit_data['status_bayar']) && $edit_data['status_bayar'] === $b) ? 'selected' : '';
                echo "<option value=\"$b\" $selected>$b</option>";
            endforeach;
            ?>
        </select>
    </div>

    <button type="submit"><?= $edit_data ? 'Simpan Perubahan' : 'Proses Rental' ?></button>
    <?php if ($edit_data): ?>
        <a href="index.php?page=rentals" style="margin-left: 10px;">Batal</a>
    <?php endif; ?>
</form>

<script>
function calculateAutoTotal() {
    const camSelect = document.getElementById('id_camera');
    const selectedOpt = camSelect.options[camSelect.selectedIndex];
    const hargaPerHari = selectedOpt ? parseFloat(selectedOpt.getAttribute('data-harga') || 0) : 0;

    const tglSewa = new Date(document.getElementById('tgl_sewa').value);
    const tglKembali = new Date(document.getElementById('tgl_kembali').value);

    if (hargaPerHari > 0 && !isNaN(tglSewa.getTime()) && !isNaN(tglKembali.getTime())) {
        const diffDays = Math.max(1, Math.ceil((tglKembali - tglSewa) / (1000 * 60 * 60 * 24)));
        document.getElementById('total').value = diffDays * hargaPerHari;
    }
}
</script>

<h3>Daftar Transaksi Rental</h3>
<table>
    <thead>
        <tr>
            <th>ID</th>
            <th>Pelanggan</th>
            <th>Kamera</th>
            <th>Periode Sewa</th>
            <th>Total Biaya</th>
            <th>Status Bayar</th>
            <th>Aksi</th>
        </tr>
    </thead>
    <tbody>
        <?php if (!empty($rentals)): ?>
            <?php foreach ($rentals as $r): ?>
                <tr>
                    <td><?= htmlspecialchars($r['id_rental']) ?></td>
                    <td><?= htmlspecialchars($r['nama_customer']) ?></td>
                    <td><?= htmlspecialchars($r['merek']) ?> <?= htmlspecialchars($r['tipe']) ?></td>
                    <td><?= htmlspecialchars($r['tgl_sewa']) ?> s/d <?= htmlspecialchars($r['tgl_kembali']) ?></td>
                    <td>Rp <?= number_format($r['total'], 0, ',', '.') ?></td>
                    <td><strong><?= htmlspecialchars($r['status_bayar']) ?></strong></td>
                    <td>
                        <a href="index.php?page=rentals&action=edit&id=<?= $r['id_rental'] ?>" class="btn-edit">Edit</a>
                        <a href="index.php?page=rentals&action=delete&id=<?= $r['id_rental'] ?>" class="btn-danger" onclick="return confirm('Hapus data rental ini?')">Hapus</a>
                    </td>
                </tr>
            <?php endforeach; ?>
        <?php else: ?>
            <tr><td colspan="7" style="text-align:center;">Belum ada transaksi rental.</td></tr>
        <?php endif; ?>
    </tbody>
</table>
