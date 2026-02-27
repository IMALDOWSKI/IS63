<?php
session_start();
require_once 'koneksi.php';
$pageTitle = 'Kelola Penerbit — E-Library';

$msg = '';
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['action'])) {

    // TAMBAH
    if ($_POST['action'] === 'tambah') {
        $nama    = trim($_POST['nama_penerbit'] ?? '');
        $alamat  = trim($_POST['alamat_penerbit'] ?? '');
        if ($nama === '') {
            $msg = ['type' => 'danger', 'text' => '❌ Nama penerbit tidak boleh kosong!'];
        } else {
            $n = mysqli_real_escape_string($conn, $nama);
            $a = mysqli_real_escape_string($conn, $alamat);
            if (mysqli_query($conn, "INSERT INTO penerbit (nama_penerbit, alamat_penerbit) VALUES ('$n','$a')")) {
                $msg = ['type' => 'success', 'text' => '✅ Penerbit berhasil ditambahkan!'];
            } else {
                $msg = ['type' => 'danger', 'text' => '❌ Gagal: ' . mysqli_error($conn)];
            }
        }
    }

    // UPDATE
    if ($_POST['action'] === 'update') {
        $id     = intval($_POST['id_penerbit'] ?? 0);
        $nama   = trim($_POST['nama_penerbit'] ?? '');
        $alamat = trim($_POST['alamat_penerbit'] ?? '');
        if ($nama === '') {
            $msg = ['type' => 'danger', 'text' => '❌ Nama penerbit tidak boleh kosong!'];
        } else {
            $n = mysqli_real_escape_string($conn, $nama);
            $a = mysqli_real_escape_string($conn, $alamat);
            if (mysqli_query($conn, "UPDATE penerbit SET nama_penerbit='$n', alamat_penerbit='$a' WHERE id_penerbit=$id")) {
                $msg = ['type' => 'success', 'text' => '✅ Penerbit berhasil diperbarui!'];
            } else {
                $msg = ['type' => 'danger', 'text' => '❌ Gagal: ' . mysqli_error($conn)];
            }
        }
    }

    // HAPUS
    if ($_POST['action'] === 'hapus') {
        $id = intval($_POST['id_penerbit'] ?? 0);
        if (mysqli_query($conn, "DELETE FROM penerbit WHERE id_penerbit=$id")) {
            $msg = ['type' => 'success', 'text' => '✅ Penerbit berhasil dihapus!'];
        } else {
            $msg = ['type' => 'danger', 'text' => '❌ Gagal menghapus (mungkin masih digunakan oleh data buku).'];
        }
    }
}

$penerbit_list = mysqli_query($conn, "SELECT p.*, COUNT(b.id_buku) AS jml_buku FROM penerbit p LEFT JOIN buku b ON p.id_penerbit=b.id_penerbit GROUP BY p.id_penerbit ORDER BY p.nama_penerbit");

include 'header.php';
?>

<div class="page-header">
  <div>
    <h2>🏢 Kelola Penerbit</h2>
    <p>Manajemen data penerbit buku perpustakaan.</p>
  </div>
  <button class="btn btn-gold" onclick="openModal('modalTambah')">+ Tambah Penerbit</button>
</div>

<?php if ($msg): ?>
  <div class="alert alert-<?= $msg['type'] ?>"><?= $msg['text'] ?></div>
<?php endif; ?>

<div class="card">
  <div class="card-header">
    <span class="card-title">🏢 Daftar Penerbit</span>
  </div>
  <div class="table-wrap">
    <table>
      <thead>
        <tr>
          <th>#</th>
          <th>Nama Penerbit</th>
          <th>Alamat</th>
          <th>Jumlah Buku</th>
          <th>Aksi</th>
        </tr>
      </thead>
      <tbody>
        <?php $no = 1; if (mysqli_num_rows($penerbit_list) === 0): ?>
          <tr><td colspan="5" style="text-align:center;color:#64748b;padding:32px;">Belum ada data penerbit.</td></tr>
        <?php else: while ($row = mysqli_fetch_assoc($penerbit_list)): ?>
          <tr>
            <td class="td-muted"><?= $no++ ?></td>
            <td><strong><?= htmlspecialchars($row['nama_penerbit']) ?></strong></td>
            <td class="td-muted"><?= htmlspecialchars($row['alamat_penerbit']) ?></td>
            <td><span class="badge badge-info"><?= $row['jml_buku'] ?> buku</span></td>
            <td style="white-space:nowrap;">
              <button class="btn btn-info btn-sm" onclick="openEdit(<?= $row['id_penerbit'] ?>, '<?= addslashes(htmlspecialchars($row['nama_penerbit'])) ?>', '<?= addslashes(htmlspecialchars($row['alamat_penerbit'])) ?>')">✏️ Edit</button>
              <button class="btn btn-danger btn-sm" onclick="confirmDelete(<?= $row['id_penerbit'] ?>, '<?= addslashes(htmlspecialchars($row['nama_penerbit'])) ?>')">🗑️ Hapus</button>
            </td>
          </tr>
        <?php endwhile; endif; ?>
      </tbody>
    </table>
  </div>
</div>

<!-- MODAL TAMBAH -->
<div class="modal-overlay" id="modalTambah">
  <div class="modal" style="max-width:480px;">
    <div class="modal-header">
      <span class="modal-title">➕ Tambah Penerbit</span>
      <button class="modal-close" onclick="closeModal('modalTambah')">×</button>
    </div>
    <form method="POST">
      <input type="hidden" name="action" value="tambah">
      <div class="form-group" style="margin-bottom:16px;">
        <label>Nama Penerbit <span style="color:#ef4444;">*</span></label>
        <input type="text" name="nama_penerbit" placeholder="Contoh: Gramedia" required>
      </div>
      <div class="form-group" style="margin-bottom:24px;">
        <label>Alamat Penerbit</label>
        <input type="text" name="alamat_penerbit" placeholder="Alamat lengkap penerbit">
      </div>
      <div style="display:flex;gap:12px;justify-content:flex-end;">
        <button type="button" class="btn" style="background:rgba(255,255,255,.07);color:#94a3b8;" onclick="closeModal('modalTambah')">Batal</button>
        <button type="submit" class="btn btn-gold">💾 Simpan</button>
      </div>
    </form>
  </div>
</div>

<!-- MODAL EDIT -->
<div class="modal-overlay" id="modalEdit">
  <div class="modal" style="max-width:480px;">
    <div class="modal-header">
      <span class="modal-title">✏️ Edit Penerbit</span>
      <button class="modal-close" onclick="closeModal('modalEdit')">×</button>
    </div>
    <form method="POST">
      <input type="hidden" name="action" value="update">
      <input type="hidden" name="id_penerbit" id="edit_id">
      <div class="form-group" style="margin-bottom:16px;">
        <label>Nama Penerbit <span style="color:#ef4444;">*</span></label>
        <input type="text" name="nama_penerbit" id="edit_nama" required>
      </div>
      <div class="form-group" style="margin-bottom:24px;">
        <label>Alamat Penerbit</label>
        <input type="text" name="alamat_penerbit" id="edit_alamat">
      </div>
      <div style="display:flex;gap:12px;justify-content:flex-end;">
        <button type="button" class="btn" style="background:rgba(255,255,255,.07);color:#94a3b8;" onclick="closeModal('modalEdit')">Batal</button>
        <button type="submit" class="btn btn-gold">💾 Simpan</button>
      </div>
    </form>
  </div>
</div>

<!-- MODAL HAPUS -->
<div class="modal-overlay" id="modalHapus">
  <div class="modal" style="max-width:420px;">
    <div class="modal-header">
      <span class="modal-title">🗑️ Konfirmasi Hapus</span>
      <button class="modal-close" onclick="closeModal('modalHapus')">×</button>
    </div>
    <p style="color:#94a3b8;margin-bottom:24px;">Hapus penerbit <strong id="hapus_nama" style="color:#fdf6e3;"></strong>?<br><span style="color:#fca5a5;font-size:13px;">Penerbit yang masih memiliki buku tidak dapat dihapus.</span></p>
    <form method="POST">
      <input type="hidden" name="action" value="hapus">
      <input type="hidden" name="id_penerbit" id="hapus_id">
      <div style="display:flex;gap:12px;justify-content:flex-end;">
        <button type="button" class="btn" style="background:rgba(255,255,255,.07);color:#94a3b8;" onclick="closeModal('modalHapus')">Batal</button>
        <button type="submit" class="btn btn-danger">🗑️ Ya, Hapus</button>
      </div>
    </form>
  </div>
</div>

<script>
function openModal(id)  { document.getElementById(id).classList.add('show'); }
function closeModal(id) { document.getElementById(id).classList.remove('show'); }
document.querySelectorAll('.modal-overlay').forEach(el => {
  el.addEventListener('click', e => { if (e.target === el) closeModal(el.id); });
});
function openEdit(id, nama, alamat) {
  document.getElementById('edit_id').value    = id;
  document.getElementById('edit_nama').value  = nama;
  document.getElementById('edit_alamat').value = alamat;
  openModal('modalEdit');
}
function confirmDelete(id, nama) {
  document.getElementById('hapus_id').value           = id;
  document.getElementById('hapus_nama').textContent   = nama;
  openModal('modalHapus');
}
</script>

<?php include 'footer.php'; ?>
