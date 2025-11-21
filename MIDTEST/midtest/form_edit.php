<?php
include("koneksi.php");
$id = $_GET['id'];
$query = mysqli_query($koneksi, "SELECT * FROM `pesanan` WHERE id_pesanan = '$id'");
$data = mysqli_fetch_assoc($query);
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Edit Order</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body style="background-color:#d1e6d4">
    <?php include_once("../navbar.php"); ?>

    <div class="container my-5">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card shadow">
                    <div class="card-header bg-warning">
                        <h4>Edit Order #<?= $data['id_pesanan'] ?></h4>
                    </div>
                    <div class="card-body">
                        <form action="proses_edit.php" method="POST">
                            <input type="hidden" name="id" value="<?= $data['id_pesanan'] ?>">
                            <div class="mb-3">
                                <label>Nama Pelanggan</label>
                                <input type="text" name="nama_pelanggan" class="form-control" value="<?= htmlspecialchars($data['nama_pelanggan']) ?>" required>
                            </div>
                            <div class="mb-3">
                                <label>Produk</label>
                                <input type="text" name="produk" class="form-control" value="<?= htmlspecialchars($data['produk']) ?>" required>
                            </div>
                            <div class="mb-3">
                                <label>Jumlah</label>
                                <input type="number" name="jumlah" class="form-control" value="<?= $data['jumlah'] ?>" required>
                            </div>
                            <div class="mb-3">
                                <label>Tanggal Pesan</label>
                                <input type="date" name="tanggal_pesan" class="form-control" value="<?= $data['tanggal_pesan'] ?>" required>
                            </div>
                            <div class="text-end">
                                <a href="index.php" class="btn btn-secondary">Kembali</a>
                                <button type="submit" class="btn btn-success">Update</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</body>
</html>