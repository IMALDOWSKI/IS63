<?php
ini_set('display_errors', 1);
error_reporting(E_ALL);
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Order Tracker</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="../css/all.css">
</head>
<body style="background-color:#d1e6d4">
    <?php include_once("../navbar.php"); ?>

    <div class="container my-5">
        <div class="row">
            <div class="col-11 mx-auto">
                <div class="card shadow">
                    <div class="card-header d-flex justify-content-between align-items-center bg-primary text-white">
                        <h4 class="mb-0"><b>ORDER TRACKER</b></h4>
                        <a href="form_tambah.php" class="btn btn-light btn-sm">
                            <i class="fa-solid fa-plus"></i> Tambah Order
                        </a>
                    </div>
                    <div class="card-body">
                        <div class="table-responsive">
                            <table class="table table-hover align-middle">
                                <thead class="table-dark">
                                    <tr>
                                        <th>No</th>
                                        <th>ID Pesanan</th>
                                        <th>Nama Pelanggan</th>
                                        <th>Produk</th>
                                        <th>Jumlah</th>
                                        <th>Tanggal Pesan</th>
                                        <th>Aksi</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php
                                    include("koneksi.php");
                                    $query = "SELECT * FROM `pesanan` ORDER BY tanggal_pesan DESC";
                                    $result = mysqli_query($koneksi, $query);
                                    $no = 1;

                                    if (mysqli_num_rows($result) == 0) {
                                        echo "<tr><td colspan='7' class='text-center'>Belum ada order</td></tr>";
                                    } else {
                                        while ($row = mysqli_fetch_assoc($result)) {
                                    ?>
                                            <tr>
                                                <td><?= $no++ ?></td>
                                                <td><strong>#<?= $row['id_pesanan'] ?></strong></td>
                                                <td><?= htmlspecialchars($row['nama_pelanggan']) ?></td>
                                                <td><?= htmlspecialchars($row['produk']) ?></td>
                                                <td><span class="badge bg-info"><?= $row['jumlah'] ?></span></td>
                                                <td><?= date('d-m-Y', strtotime($row['tanggal_pesan'])) ?></td>
                                                <td>
                                                    <a href="form_edit.php?id=<?= $row['id_pesanan'] ?>" class="btn btn-warning btn-sm">
                                                        <i class="fa-solid fa-pen"></i>
                                                    </a>
                                                    <button class="btn btn-danger btn-sm" data-bs-toggle="modal" data-bs-target="#hapus<?= $row['id_pesanan'] ?>">
                                                        <i class="fa-solid fa-trash"></i>
                                                    </button>
                                                </td>
                                            </tr>

                                            <!-- Modal Hapus -->
                                            <div class="modal fade" id="hapus<?= $row['id_pesanan'] ?>">
                                                <div class="modal-dialog">
                                                    <div class="modal-content">
                                                        <div class="modal-header">
                                                            <h5 class="modal-title">Konfirmasi Hapus</h5>
                                                            <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                                                        </div>
                                                        <div class="modal-body">
                                                            Yakin ingin menghapus order <strong><?= htmlspecialchars($row['nama_pelanggan']) ?></strong> - <?= htmlspecialchars($row['produk']) ?>?
                                                        </div>
                                                        <div class="modal-footer">
                                                            <button class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                                                            <a href="proses_hapus.php?id=<?= $row['id_pesanan'] ?>" class="btn btn-danger">Hapus</a>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                    <?php
                                        }
                                    }
                                    ?>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
    <script src="../js/all.js"></script>
</body>
</html>