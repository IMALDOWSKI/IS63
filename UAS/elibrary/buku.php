<?php
session_start();
require_once 'koneksi.php';
$pageTitle = 'Kelola Buku — E-Library';

// =============================================
// PROSES TAMBAH BUKU
// =============================================
$msg = '';
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['action'])) {

    // ---------- HELPER: Upload gambar ----------
    function upload_cover($file_input, $conn) {
        if (!isset($_FILES[$file_input]) || $_FILES[$file_input]['error'] === UPLOAD_ERR_NO_FILE) {
            return ['ok' => false, 'file' => null, 'err' => null]; // tidak ada upload
        }

        $file  = $_FILES[$file_input];
        if ($file['error'] !== UPLOAD_ERR_OK) {
            return ['ok' => false, 'file' => null, 'err' => 'Gagal upload file.'];
        }

        // Validasi tipe file
        $allowed_mime = ['image/jpeg', 'image/jpg', 'image/png'];
        $finfo = finfo_open(FILEINFO_MIME_TYPE);
        $mime  = finfo_file($finfo, $file['tmp_name']);
        finfo_close($finfo);

        if (!in_array($mime, $allowed_mime)) {
            return ['ok' => false, 'file' => null, 'err' => 'Format file harus JPG atau PNG!'];
        }

        $ext      = strtolower(pathinfo($file['name'], PATHINFO_EXTENSION));
        $new_name = 'book_' . uniqid() . '.' . $ext;
        $dest     = 'img/' . $new_name;

        if (!is_dir('img')) mkdir('img', 0755, true);
        if (!move_uploaded_file($file['tmp_name'], $dest)) {
            return ['ok' => false, 'file' => null, 'err' => 'Gagal menyimpan file ke server.'];
        }

        return ['ok' => true, 'file' => $new_name, 'err' => null];
    }

    // =============================================
    // TAMBAH
    // =============================================
    if ($_POST['action'] === 'tambah') {
        $judul         = trim($_POST['judul_buku'] ?? '');
        $pengarang     = trim($_POST['pengarang'] ?? '');
        $tahun         = intval($_POST['tahun_terbit'] ?? 0);
        $isbn          = trim($_POST['isbn'] ?? '');
        $halaman       = intval($_POST['jumlah_halaman'] ?? 0);
        $stok          = intval($_POST['stok'] ?? 0);
        $id_penerbit   = intval($_POST['id_penerbit'] ?? 0);
        $id_kategori   = intval($_POST['id_kategori'] ?? 0);

        // Validasi
        $errors = [];
        if ($judul === '')     $errors[] = 'Judul buku tidak boleh kosong.';
        if ($pengarang === '') $errors[] = 'Pengarang tidak boleh kosong.';
        if ($isbn === '')      $errors[] = 'ISBN tidak boleh kosong.';
        if ($halaman < 0)     $errors[] = 'Jumlah halaman minimal 0.';
        if ($stok < 0)        $errors[] = 'Stok minimal 0.';
        if ($id_penerbit === 0) $errors[] = 'Penerbit harus dipilih.';
        if ($id_kategori === 0) $errors[] = 'Kategori harus dipilih.';

        // Upload cover
        $upload = upload_cover('cover_buku', $conn);
        if ($upload['err']) $errors[] = $upload['err'];

        if (empty($errors)) {
            $cover = $upload['file'] ? mysqli_real_escape_string($conn, $upload['file']) : null;
            $cover_sql = $cover ? "'$cover'" : 'NULL';

            $judul_s     = mysqli_real_escape_string($conn, $judul);
            $pengarang_s = mysqli_real_escape_string($conn, $pengarang);
            $isbn_s      = mysqli_real_escape_string($conn, $isbn);

            $sql = "INSERT INTO buku (id_penerbit, id_kategori, judul_buku, pengarang, tahun_terbit, isbn, jumlah_halaman, stok, cover_buku)
                    VALUES ($id_penerbit, $id_kategori, '$judul_s', '$pengarang_s', $tahun, '$isbn_s', $halaman, $stok, $cover_sql)";

            if (mysqli_query($conn, $sql)) {
                $msg = ['type' => 'success', 'text' => '✅ Buku berhasil ditambahkan!'];
            } else {
                $msg = ['type' => 'danger', 'text' => '❌ Gagal menambahkan buku: ' . mysqli_error($conn)];
            }
        } else {
            $msg = ['type' => 'danger', 'text' => '❌ ' . implode('<br>• ', $errors)];
        }
    }

    // =============================================
    // UPDATE
    // =============================================
    if ($_POST['action'] === 'update') {
        $id_buku       = intval($_POST['id_buku'] ?? 0);
        $judul         = trim($_POST['judul_buku'] ?? '');
        $pengarang     = trim($_POST['pengarang'] ?? '');
        $tahun         = intval($_POST['tahun_terbit'] ?? 0);
        $isbn          = trim($_POST['isbn'] ?? '');
        $halaman       = intval($_POST['jumlah_halaman'] ?? 0);
        $stok          = intval($_POST['stok'] ?? 0);
        $id_penerbit   = intval($_POST['id_penerbit'] ?? 0);
        $id_kategori   = intval($_POST['id_kategori'] ?? 0);
        $cover_lama    = trim($_POST['cover_lama'] ?? '');

        $errors = [];
        if ($judul === '')       $errors[] = 'Judul buku tidak boleh kosong.';
        if ($pengarang === '')   $errors[] = 'Pengarang tidak boleh kosong.';
        if ($isbn === '')        $errors[] = 'ISBN tidak boleh kosong.';
        if ($halaman < 0)       $errors[] = 'Jumlah halaman minimal 0.';
        if ($stok < 0)          $errors[] = 'Stok minimal 0.';
        if ($id_penerbit === 0) $errors[] = 'Penerbit harus dipilih.';
        if ($id_kategori === 0) $errors[] = 'Kategori harus dipilih.';

        // Upload cover baru (opsional)
        $upload = upload_cover('cover_buku', $conn);
        if ($upload['err']) $errors[] = $upload['err'];

        if (empty($errors)) {
            // Gunakan cover baru jika diupload, jika tidak pakai yang lama
            if ($upload['ok'] && $upload['file']) {
                // Hapus cover lama
                if ($cover_lama && file_exists('img/' . $cover_lama)) {
                    @unlink('img/' . $cover_lama);
                }
                $cover_final = $upload['file'];
            } else {
                $cover_final = $cover_lama ?: null;
            }

            $cover_sql   = $cover_final ? "'" . mysqli_real_escape_string($conn, $cover_final) . "'" : 'NULL';
            $judul_s     = mysqli_real_escape_string($conn, $judul);
            $pengarang_s = mysqli_real_escape_string($conn, $pengarang);
            $isbn_s      = mysqli_real_escape_string($conn, $isbn);

            $sql = "UPDATE buku SET
                        id_penerbit   = $id_penerbit,
                        id_kategori   = $id_kategori,
                        judul_buku    = '$judul_s',
                        pengarang     = '$pengarang_s',
                        tahun_terbit  = $tahun,
                        isbn          = '$isbn_s',
                        jumlah_halaman = $halaman,
                        stok          = $stok,
                        cover_buku    = $cover_sql
                    WHERE id_buku = $id_buku";

            if (mysqli_query($conn, $sql)) {
                $msg = ['type' => 'success', 'text' => '✅ Buku berhasil diperbarui!'];
            } else {
                $msg = ['type' => 'danger', 'text' => '❌ Gagal update: ' . mysqli_error($conn)];
            }
        } else {
            $msg = ['type' => 'danger', 'text' => '❌ ' . implode('<br>• ', $errors)];
        }
    }

    // =============================================
    // HAPUS
    // =============================================
    if ($_POST['action'] === 'hapus') {
        $id_buku = intval($_POST['id_buku'] ?? 0);
        $row = mysqli_fetch_assoc(mysqli_query($conn, "SELECT cover_buku FROM buku WHERE id_buku = $id_buku"));

        if ($row) {
            if ($row['cover_buku'] && file_exists('img/' . $row['cover_buku'])) {
                @unlink('img/' . $row['cover_buku']);
            }
            if (mysqli_query($conn, "DELETE FROM buku WHERE id_buku = $id_buku")) {
                $msg = ['type' => 'success', 'text' => '✅ Buku berhasil dihapus!'];
            } else {
                $msg = ['type' => 'danger', 'text' => '❌ Gagal hapus: ' . mysqli_error($conn)];
            }
        }
    }
}

// Ambil data edit (jika ada ?edit=id)
$edit_data = null;
if (isset($_GET['edit'])) {
    $edit_id   = intval($_GET['edit']);
    $edit_data = mysqli_fetch_assoc(mysqli_query($conn, "SELECT * FROM buku WHERE id_buku = $edit_id"));
}

// Ambil dropdown data
$penerbit_list = mysqli_query($conn, "SELECT * FROM penerbit ORDER BY nama_penerbit");
$kategori_list = mysqli_query($conn, "SELECT * FROM kategori ORDER BY nama_kategori");

// Ambil semua buku dengan DOUBLE JOIN
$search = trim($_GET['search'] ?? '');
$where  = '';
if ($search !== '') {
    $s = mysqli_real_escape_string($conn, $search);
    $where = "WHERE b.judul_buku LIKE '%$s%' OR b.pengarang LIKE '%$s%' OR b.isbn LIKE '%$s%'";
}

$buku_list = mysqli_query($conn,
    "SELECT b.*, p.nama_penerbit, k.nama_kategori
     FROM buku b
     JOIN penerbit p ON b.id_penerbit = p.id_penerbit
     JOIN kategori k ON b.id_kategori = k.id_kategori
     $where
     ORDER BY b.id_buku DESC"
);

include 'header.php';
?>

<div class="page-header">
  <div>
    <h2>📖 Kelola Buku</h2>
    <p>Tambah, ubah, dan hapus data koleksi buku perpustakaan.</p>
  </div>
  <button class="btn btn-gold" onclick="openModal('modalTambah')">+ Tambah Buku</button>
</div>

<?php if ($msg): ?>
  <div class="alert alert-<?= $msg['type'] ?>"><?= $msg['text'] ?></div>
<?php endif; ?>

<!-- TABEL BUKU -->
<div class="card">
  <div class="card-header">
    <span class="card-title">📚 Daftar Koleksi Buku</span>
    <form method="GET" style="display:flex;gap:8px;">
      <input type="text" name="search" placeholder="Cari judul / pengarang / ISBN…"
             value="<?= htmlspecialchars($search) ?>"
             style="width:260px; margin:0;">
      <button type="submit" class="btn btn-info btn-sm">🔍 Cari</button>
      <?php if ($search): ?>
        <a href="buku.php" class="btn btn-sm" style="background:rgba(255,255,255,.07);color:#94a3b8;">✕ Reset</a>
      <?php endif; ?>
    </form>
  </div>

  <div class="table-wrap">
    <table>
      <thead>
        <tr>
          <th>#</th>
          <th>Cover</th>
          <th>Judul Buku</th>
          <th>Pengarang</th>
          <th>Penerbit</th>
          <th>Kategori</th>
          <th>ISBN</th>
          <th>Tahun</th>
          <th>Halaman</th>
          <th>Stok</th>
          <th>Aksi</th>
        </tr>
      </thead>
      <tbody>
        <?php
        $no = 1;
        if (mysqli_num_rows($buku_list) === 0): ?>
          <tr><td colspan="11" style="text-align:center;color:#64748b;padding:40px;">
            <?= $search ? 'Tidak ada hasil untuk "<strong>' . htmlspecialchars($search) . '</strong>".' : 'Belum ada data buku. Klik <strong>+ Tambah Buku</strong> untuk mulai.' ?>
          </td></tr>
        <?php else: while ($row = mysqli_fetch_assoc($buku_list)): ?>
          <tr>
            <td class="td-muted"><?= $no++ ?></td>
            <td>
              <?php if ($row['cover_buku'] && file_exists('img/' . $row['cover_buku'])): ?>
                <img src="img/<?= htmlspecialchars($row['cover_buku']) ?>" class="book-thumb" alt="Cover">
              <?php else: ?>
                <div class="no-thumb">📖</div>
              <?php endif; ?>
            </td>
            <td><strong><?= htmlspecialchars($row['judul_buku']) ?></strong></td>
            <td class="td-muted"><?= htmlspecialchars($row['pengarang']) ?></td>
            <td><span class="badge badge-info"><?= htmlspecialchars($row['nama_penerbit']) ?></span></td>
            <td><span class="badge badge-gold"><?= htmlspecialchars($row['nama_kategori']) ?></span></td>
            <td class="td-muted" style="font-size:12px;"><?= htmlspecialchars($row['isbn']) ?></td>
            <td class="td-muted"><?= $row['tahun_terbit'] ?></td>
            <td class="td-muted"><?= number_format($row['jumlah_halaman']) ?> hal</td>
            <td>
              <?php
                $s   = $row['stok'];
                $cls = $s > 5 ? 'badge-success' : ($s > 0 ? 'badge-warning' : 'badge-danger');
              ?>
              <span class="badge <?= $cls ?>"><?= $s ?></span>
            </td>
            <td style="white-space:nowrap;">
              <button class="btn btn-info btn-sm" onclick="openEdit(<?= htmlspecialchars(json_encode($row)) ?>)">✏️ Edit</button>
              <button class="btn btn-danger btn-sm" onclick="confirmDelete(<?= $row['id_buku'] ?>, '<?= addslashes(htmlspecialchars($row['judul_buku'])) ?>')">🗑️ Hapus</button>
            </td>
          </tr>
        <?php endwhile; endif; ?>
      </tbody>
    </table>
  </div>
</div>

<!-- =============================================
     MODAL: TAMBAH BUKU
============================================= -->
<div class="modal-overlay" id="modalTambah">
  <div class="modal">
    <div class="modal-header">
      <span class="modal-title">➕ Tambah Buku Baru</span>
      <button class="modal-close" onclick="closeModal('modalTambah')">×</button>
    </div>
    <form method="POST" enctype="multipart/form-data">
      <input type="hidden" name="action" value="tambah">
      <div class="form-grid">

        <div class="form-group full">
          <label>Judul Buku <span>*</span></label>
          <input type="text" name="judul_buku" placeholder="Masukkan judul buku" required>
        </div>

        <div class="form-group">
          <label>Pengarang <span>*</span></label>
          <input type="text" name="pengarang" placeholder="Nama pengarang">
        </div>

        <div class="form-group">
          <label>ISBN <span>*</span></label>
          <input type="text" name="isbn" placeholder="978-xxx-xxx-xxx-x">
        </div>

        <div class="form-group">
          <label>Penerbit <span>*</span></label>
          <select name="id_penerbit" required>
            <option value="">-- Pilih Penerbit --</option>
            <?php
              mysqli_data_seek($penerbit_list, 0);
              while ($p = mysqli_fetch_assoc($penerbit_list)):
            ?>
              <option value="<?= $p['id_penerbit'] ?>"><?= htmlspecialchars($p['nama_penerbit']) ?></option>
            <?php endwhile; ?>
          </select>
        </div>

        <div class="form-group">
          <label>Kategori <span>*</span></label>
          <select name="id_kategori" required>
            <option value="">-- Pilih Kategori --</option>
            <?php
              mysqli_data_seek($kategori_list, 0);
              while ($k = mysqli_fetch_assoc($kategori_list)):
            ?>
              <option value="<?= $k['id_kategori'] ?>"><?= htmlspecialchars($k['nama_kategori']) ?></option>
            <?php endwhile; ?>
          </select>
        </div>

        <div class="form-group">
          <label>Tahun Terbit</label>
          <input type="number" name="tahun_terbit" placeholder="2024" min="1900" max="<?= date('Y') ?>" value="<?= date('Y') ?>">
        </div>

        <div class="form-group">
          <label>Jumlah Halaman</label>
          <input type="number" name="jumlah_halaman" placeholder="0" min="0" value="0">
        </div>

        <div class="form-group">
          <label>Stok <span>*</span></label>
          <input type="number" name="stok" placeholder="0" min="0" value="0">
        </div>

        <div class="form-group full">
          <label>Cover Buku</label>
          <input type="file" name="cover_buku" accept=".jpg,.jpeg,.png">
          <span class="form-hint">Format: JPG atau PNG. Biarkan kosong jika tidak ada cover.</span>
        </div>

      </div>
      <div style="display:flex;gap:12px;justify-content:flex-end;margin-top:24px;padding-top:20px;border-top:1px solid rgba(255,255,255,.08);">
        <button type="button" class="btn" style="background:rgba(255,255,255,.07);color:#94a3b8;" onclick="closeModal('modalTambah')">Batal</button>
        <button type="submit" class="btn btn-gold">💾 Simpan Buku</button>
      </div>
    </form>
  </div>
</div>

<!-- =============================================
     MODAL: EDIT BUKU
============================================= -->
<div class="modal-overlay" id="modalEdit">
  <div class="modal">
    <div class="modal-header">
      <span class="modal-title">✏️ Edit Data Buku</span>
      <button class="modal-close" onclick="closeModal('modalEdit')">×</button>
    </div>
    <form method="POST" enctype="multipart/form-data">
      <input type="hidden" name="action" value="update">
      <input type="hidden" name="id_buku" id="edit_id_buku">
      <input type="hidden" name="cover_lama" id="edit_cover_lama">
      <div class="form-grid">

        <div class="form-group full">
          <label>Judul Buku <span>*</span></label>
          <input type="text" name="judul_buku" id="edit_judul" required>
        </div>

        <div class="form-group">
          <label>Pengarang <span>*</span></label>
          <input type="text" name="pengarang" id="edit_pengarang">
        </div>

        <div class="form-group">
          <label>ISBN <span>*</span></label>
          <input type="text" name="isbn" id="edit_isbn">
        </div>

        <div class="form-group">
          <label>Penerbit <span>*</span></label>
          <select name="id_penerbit" id="edit_id_penerbit" required>
            <option value="">-- Pilih Penerbit --</option>
            <?php
              mysqli_data_seek($penerbit_list, 0);
              while ($p = mysqli_fetch_assoc($penerbit_list)):
            ?>
              <option value="<?= $p['id_penerbit'] ?>"><?= htmlspecialchars($p['nama_penerbit']) ?></option>
            <?php endwhile; ?>
          </select>
        </div>

        <div class="form-group">
          <label>Kategori <span>*</span></label>
          <select name="id_kategori" id="edit_id_kategori" required>
            <option value="">-- Pilih Kategori --</option>
            <?php
              mysqli_data_seek($kategori_list, 0);
              while ($k = mysqli_fetch_assoc($kategori_list)):
            ?>
              <option value="<?= $k['id_kategori'] ?>"><?= htmlspecialchars($k['nama_kategori']) ?></option>
            <?php endwhile; ?>
          </select>
        </div>

        <div class="form-group">
          <label>Tahun Terbit</label>
          <input type="number" name="tahun_terbit" id="edit_tahun" min="1900" max="<?= date('Y') ?>">
        </div>

        <div class="form-group">
          <label>Jumlah Halaman</label>
          <input type="number" name="jumlah_halaman" id="edit_halaman" min="0">
        </div>

        <div class="form-group">
          <label>Stok</label>
          <input type="number" name="stok" id="edit_stok" min="0">
        </div>

        <div class="form-group full">
          <label>Ganti Cover Buku</label>
          <div id="edit_cover_preview" style="margin-bottom:10px;display:none;">
            <img id="edit_cover_img" src="" style="height:80px;border-radius:6px;border:1px solid rgba(255,255,255,.1);" alt="Cover saat ini">
            <p class="form-hint" style="margin-top:6px;">Cover saat ini. Upload baru untuk mengganti.</p>
          </div>
          <input type="file" name="cover_buku" accept=".jpg,.jpeg,.png">
          <span class="form-hint">Kosongkan jika tidak ingin mengganti cover.</span>
        </div>

      </div>
      <div style="display:flex;gap:12px;justify-content:flex-end;margin-top:24px;padding-top:20px;border-top:1px solid rgba(255,255,255,.08);">
        <button type="button" class="btn" style="background:rgba(255,255,255,.07);color:#94a3b8;" onclick="closeModal('modalEdit')">Batal</button>
        <button type="submit" class="btn btn-gold">💾 Simpan Perubahan</button>
      </div>
    </form>
  </div>
</div>

<!-- MODAL: KONFIRMASI HAPUS -->
<div class="modal-overlay" id="modalHapus">
  <div class="modal" style="max-width:420px;">
    <div class="modal-header">
      <span class="modal-title">🗑️ Konfirmasi Hapus</span>
      <button class="modal-close" onclick="closeModal('modalHapus')">×</button>
    </div>
    <p style="color:#94a3b8;margin-bottom:24px;">
      Apakah Anda yakin ingin menghapus buku <strong id="hapus_judul" style="color:#fdf6e3;"></strong>?<br>
      <span style="color:#fca5a5;font-size:13px;">File cover juga akan dihapus secara permanen.</span>
    </p>
    <form method="POST">
      <input type="hidden" name="action" value="hapus">
      <input type="hidden" name="id_buku" id="hapus_id">
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

// Tutup modal saat klik overlay
document.querySelectorAll('.modal-overlay').forEach(el => {
  el.addEventListener('click', function(e) {
    if (e.target === this) closeModal(this.id);
  });
});

function openEdit(data) {
  document.getElementById('edit_id_buku').value    = data.id_buku;
  document.getElementById('edit_judul').value       = data.judul_buku;
  document.getElementById('edit_pengarang').value   = data.pengarang;
  document.getElementById('edit_isbn').value        = data.isbn;
  document.getElementById('edit_tahun').value       = data.tahun_terbit;
  document.getElementById('edit_halaman').value     = data.jumlah_halaman;
  document.getElementById('edit_stok').value        = data.stok;
  document.getElementById('edit_id_penerbit').value = data.id_penerbit;
  document.getElementById('edit_id_kategori').value = data.id_kategori;
  document.getElementById('edit_cover_lama').value  = data.cover_buku || '';

  // Tampilkan preview cover lama
  const preview = document.getElementById('edit_cover_preview');
  const img     = document.getElementById('edit_cover_img');
  if (data.cover_buku) {
    img.src = 'img/' + data.cover_buku;
    preview.style.display = 'block';
  } else {
    preview.style.display = 'none';
  }

  openModal('modalEdit');
}

function confirmDelete(id, judul) {
  document.getElementById('hapus_id').value     = id;
  document.getElementById('hapus_judul').textContent = judul;
  openModal('modalHapus');
}

<?php if ($msg && isset($_POST['action']) && $_POST['action'] === 'tambah' && $msg['type'] !== 'success'): ?>
// Re-open tambah modal if validation failed
openModal('modalTambah');
<?php endif; ?>
</script>

<?php include 'footer.php'; ?>
