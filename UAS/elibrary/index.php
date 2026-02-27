<?php
session_start();
require_once 'koneksi.php';
$pageTitle = 'Dashboard — E-Library';
include 'header.php';

// Stats
$total_buku      = mysqli_fetch_assoc(mysqli_query($conn, "SELECT COUNT(*) AS n FROM buku"))['n'];
$total_penerbit  = mysqli_fetch_assoc(mysqli_query($conn, "SELECT COUNT(*) AS n FROM penerbit"))['n'];
$total_kategori  = mysqli_fetch_assoc(mysqli_query($conn, "SELECT COUNT(*) AS n FROM kategori"))['n'];
$total_stok      = mysqli_fetch_assoc(mysqli_query($conn, "SELECT SUM(stok) AS n FROM buku"))['n'] ?? 0;

// Latest 5 books
$latest = mysqli_query($conn,
    "SELECT b.*, p.nama_penerbit, k.nama_kategori
     FROM buku b
     JOIN penerbit p ON b.id_penerbit = p.id_penerbit
     JOIN kategori k ON b.id_kategori = k.id_kategori
     ORDER BY b.id_buku DESC LIMIT 5"
);
?>

<div class="page-header">
  <div>
    <h2>📊 Dashboard</h2>
    <p>Selamat datang, <strong><?= htmlspecialchars($_SESSION['user']) ?></strong>! Berikut ringkasan perpustakaan Anda.</p>
  </div>
  <a href="buku.php" class="btn btn-gold">+ Tambah Buku</a>
</div>

<!-- Stats -->
<div class="stats-grid">
  <div class="stat-card">
    <span class="stat-icon">📖</span>
    <div class="stat-label">Total Judul Buku</div>
    <div class="stat-value" style="color:#c9a84c"><?= $total_buku ?></div>
  </div>
  <div class="stat-card">
    <span class="stat-icon">📦</span>
    <div class="stat-label">Total Stok</div>
    <div class="stat-value" style="color:#22c55e"><?= $total_stok ?></div>
  </div>
  <div class="stat-card">
    <span class="stat-icon">🏢</span>
    <div class="stat-label">Penerbit</div>
    <div class="stat-value" style="color:#3b82f6"><?= $total_penerbit ?></div>
  </div>
  <div class="stat-card">
    <span class="stat-icon">🏷️</span>
    <div class="stat-label">Kategori</div>
    <div class="stat-value" style="color:#a855f7"><?= $total_kategori ?></div>
  </div>
</div>

<!-- Latest Books -->
<div class="card">
  <div class="card-header">
    <span class="card-title">📚 Buku Terbaru</span>
    <a href="buku.php" class="btn btn-info btn-sm">Lihat Semua →</a>
  </div>
  <div class="table-wrap">
    <table>
      <thead>
        <tr>
          <th>Cover</th>
          <th>Judul Buku</th>
          <th>Pengarang</th>
          <th>Penerbit</th>
          <th>Kategori</th>
          <th>Stok</th>
          <th>Aksi</th>
        </tr>
      </thead>
      <tbody>
        <?php if (mysqli_num_rows($latest) === 0): ?>
          <tr><td colspan="7" style="text-align:center; color:#64748b; padding:32px;">Belum ada data buku.</td></tr>
        <?php else: ?>
          <?php while ($row = mysqli_fetch_assoc($latest)): ?>
          <tr>
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
            <td>
              <?php
                $stok = $row['stok'];
                $cls  = $stok > 5 ? 'badge-success' : ($stok > 0 ? 'badge-warning' : 'badge-danger');
              ?>
              <span class="badge <?= $cls ?>"><?= $stok ?></span>
            </td>
            <td>
              <a href="buku.php?edit=<?= $row['id_buku'] ?>" class="btn btn-info btn-sm">✏️ Edit</a>
            </td>
          </tr>
          <?php endwhile; ?>
        <?php endif; ?>
      </tbody>
    </table>
  </div>
</div>

<?php include 'footer.php'; ?>
