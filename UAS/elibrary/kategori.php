<?php
session_start();
require_once 'koneksi.php';
$pageTitle = 'Kelola Kategori — E-Library';

$msg = '';
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['action'])) {

    if ($_POST['action'] === 'tambah') {
        $nama = trim($_POST['nama_kategori'] ?? '');
        if ($nama === '') {
            $msg = ['type' => 'danger', 'text' => '❌ Nama kategori tidak boleh kosong!'];
        } else {
            $n = mysqli_real_escape_string($conn, $nama);
            if (mysqli_query($conn, "INSERT INTO kategori (nama_kategori) VALUES ('$n')")) {
                $msg = ['type' => 'success', 'text' => '✅ Kategori berhasil ditambahkan!'];
            } else {
                $msg = ['type' => 'danger', 'text' => '❌ Gagal: ' . mysqli_error($conn)];
            }
        }
    }

    if ($_POST['action'] === 'update') {
        $id   = intval($_POST['id_kategori'] ?? 0);
        $nama = trim($_POST['nama_kategori'] ?? '');
        if ($nama === '') {
            $msg = ['type' => 'danger', 'text' => '❌ Nama kategori tidak boleh kosong!'];
        } else {
            $n = mysqli_real_escape_string($conn, $nama);
            if (mysqli_query($conn, "UPDATE kategori SET nama_kategori='$n' WHERE id_kategori=$id")) {
                $msg = ['type' => 'success', 'text' => '✅ Kategori berhasil diperbarui!'];
            } else {
                $msg = ['type' => 'danger', 'text' => '❌ Gagal: ' . mysqli_error($conn)];
            }
        }
    }

    if ($_POST['action'] === 'hapus') {
        $id = intval($_POST['id_kategori'] ?? 0);
        if (mysqli_query($conn, "DELETE FROM kategori WHERE id_kategori=$id")) {
            $msg = ['type' => 'success', 'text' => '✅ Kategori berhasil dihapus!'];
        } else {
            $msg = ['type' => 'danger', 'text' => '❌ Gagal menghapus (mungkin masih digunakan buku).'];
        }
    }
}

$kategori_list = mysqli_query($conn,
    "SELECT k.*, COUNT(b.id_buku) AS jml_buku FROM kategori k
     LEFT JOIN buku b ON k.id_kategori = b.id_kategori
     GROUP BY k.id_kategori ORDER BY k.nama_kategori");

include 'header.php';
?>

<div class="page-header">
  <div>
    <h2>🏷️ Kelola Kategori</h2>
    <p>Manajemen kategori / genre buku perpustakaan.</p>
  </div>
  <button class="btn btn-gold" onclick="openModal('modalTambah')">+ Tambah Kategori</button>
</div>

<?php if ($msg): ?>
  <div class="alert alert-<?= $msg['type'] ?>"><?= $msg['text'] ?></div>
<?php endif; ?>

<div class="card">
  <div class="card-header">
    <span class="card-title">🏷️ Daftar Kategori</span>
  </div>
  <div class="table-wrap">
    <table>
      <thead>
        <tr><th>#</th><th>Nama Kategori</th><th>Jumlah Buku</th><th>Aksi</th></tr>
      </thead>
      <tbody>
        <?php $no = 1; if (mysqli_num_rows($kategori_list) === 0): ?>
          <tr><td colspan="4" style="text-align:center;color:#64748b;padding:32px;">Belum ada data kategori.</td></tr>
        <?php else: while ($row = mysqli_fetch_assoc($kategori_list)): ?>
          <tr>
            <td class="td-muted"><?= $no++ ?></td>
            <td><span class="badge badge-gold" style="font-size:14px;"><?= htmlspecialchars($row['nama_kategori']) ?></span></td>
            <td><span class="badge badge-info"><?= $row['jml_buku'] ?> buku</span></td>
            <td style="white-space:nowrap;">
              <button class="btn btn-info btn-sm" onclick="openEdit(<?= $row['id_kategori'] ?>, '<?= addslashes(htmlspecialchars($row['nama_kategori'])) ?>')">✏️ Edit</button>
              <button class="btn btn-danger btn-sm" onclick="confirmDelete(<?= $row['id_kategori'] ?>, '<?= addslashes(htmlspecialchars($row['nama_kategori'])) ?>')">🗑️ Hapus</button>
            </td>
          </tr>
        <?php endwhile; endif; ?>
      </tbody>
    </table>
  </div>
</div>

<!-- MODAL TAMBAH -->
<div class="modal-overlay" id="modalTambah">
  <div class="modal" style="max-width:420px;">
    <div class="modal-header">
      <span class="modal-title">➕ Tambah Kategori</span>
      <button class="modal-close" onclick="closeModal('modalTambah')">×</button>
    </div>
    <form method="POST">
      <input type="hidden" name="action" value="tambah">
      <div class="form-group" style="margin-bottom:24px;">
        <label>Nama Kategori <span style="color:#ef4444;">*</span></label>
        <input type="text" name="nama_kategori" placeholder="Contoh: Sains, Novel, Sejarah" required>
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
  <div class="modal" style="max-width:420px;">
    <div class="modal-header">
      <span class="modal-title">✏️ Edit Kategori</span>
      <button class="modal-close" onclick="closeModal('modalEdit')">×</button>
    </div>
    <form method="POST">
      <input type="hidden" name="action" value="update">
      <input type="hidden" name="id_kategori" id="edit_id">
      <div class="form-group" style="margin-bottom:24px;">
        <label>Nama Kategori <span style="color:#ef4444;">*</span></label>
        <input type="text" name="nama_kategori" id="edit_nama" required>
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
    <p style="color:#94a3b8;margin-bottom:24px;">Hapus kategori <strong id="hapus_nama" style="color:#fdf6e3;"></strong>?<br><span style="color:#fca5a5;font-size:13px;">Kategori yang masih digunakan buku tidak dapat dihapus.</span></p>
    <form method="POST">
      <input type="hidden" name="action" value="hapus">
      <input type="hidden" name="id_kategori" id="hapus_id">
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
function openEdit(id, nama) {
  document.getElementById('edit_id').value   = id;
  document.getElementById('edit_nama').value = nama;
  openModal('modalEdit');
}
function confirmDelete(id, nama) {
  document.getElementById('hapus_id').value         = id;
  document.getElementById('hapus_nama').textContent = nama;
  openModal('modalHapus');
}
</script>

<?php include 'footer.php'; ?>
