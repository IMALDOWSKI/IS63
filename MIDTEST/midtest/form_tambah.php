<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tambah Order</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body style="background-color:#d1e6d4">
    <?php include_once("../navbar.php"); ?>

    <div class="container my-5">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card shadow">
                    <div class="card-header bg-success text-white">
                        <h4>Tambah Order Baru</h4>
                    </div>
                    <div class="card-body">
                        <form action="proses_tambah.php" method="POST">
                            <div class="mb-3">
                                <label class="form-label">Nama Pelanggan</label>
                                <input type="text" name="nama_pelanggan" class="form-control" required>
                            </div>
                            <div class="mb-3">
                                <label class="form-label">Produk</label>
                                <input type="text" name="produk" class="form-control" required>
                            </div>
                            <div class="mb-3">
                                <label class="form-label">Jumlah</label>
                                <input type="number" name="jumlah" min="1" class="form-control" required>
                            </div>
                            <div class="mb-3">
                                <label class="form-label">Tanggal Pesan</label>
                                <input type="date" name="tanggal_pesan" class="form-control" value="<?= date('Y-m-d') ?>" required>
                            </div>
                            <div class="text-end">
                                <a href="index.php" class="btn btn-secondary">Kembali</a>
                                <button type="submit" class="btn btn-primary">Simpan Order</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</body>
</html>