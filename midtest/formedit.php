<?php
include_once("../koneksi.php");
$idedit = $_GET['id'];
$qry = "SELECT * FROM biodata WHERE id='$idedit'";
$edit = mysqli_query($koneksi,$qry);
$data = mysqli_fetch_array($edit);
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Biodata Siswa</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-sRIl4kxILFvY47J16cr9ZwB07vP4J8+LH7qKQnuqkuIAvNWLzeN8tE5YBujZqJLB" crossorigin="anonymous">
</head>

<body style="background-color:#d1e6d4">
    <?php
    include_once("../navbar.php");
    ?>

    <div class="container">
        <div class="row my-5">
            <div class="col-8 m-auto">
                <div class="card shadow p-3 mb-5 bg-body-tertiary rounded">
                    <div class="card-header">
                        <b>FORM EDIT BIODATA SISWA</b>
                    </div>
                    <div class="card-body">
                        <form action="proses_edit.php" method="POST" enctype="multipart/form-data">
                            <input type="hidden" name="id" value="<?=$data['id']?>">
                            <div class="mb-3">
                                <label for="exampleInputEmail1" class="form-label">Nama Lengkap</label>
                                <input value="<?=$data['nama']?>" name="nama" type="text" class="form-control" id="exampleInputEmail1"
                                    aria-describedby="emailHelp">
                            </div>
                            <div class="mb-3">
                                <label for="exampleInputEmail1" class="form-label">NISN</label>
                                <input value="<?=$data['nisn']?>" name="nisn" type="text" class="form-control" id="exampleInputEmail1"
                                    aria-describedby="emailHelp">
                            </div>
                            <div class="mb-3">
                                <label for="exampleInputEmail1" class="form-label">Tempat Lahir</label>
                                <input value="<?=$data['tp_lahir']?>" name="tp_lahir" type="text" class="form-control" id="exampleInputEmail1"
                                    aria-describedby="emailHelp">
                            </div>
                            <div class="mb-3">
                                <label for="exampleInputEmail1" class="form-label">Tanggal Lahir</label>
                                <input value="<?=$data['tg_lahir']?>" name="tg_lahir" type="date" class="form-control" id="exampleInputEmail1"
                                    aria-describedby="emailHelp">
                            </div>
                            <div class="mb-3">
                                <label for="exampleInputEmail1" class="form-label">Alamat</label>
                                <input value="<?=$data['alamat']?>" name="alamat" type="text" class="form-control" id="exampleInputEmail1"
                                    aria-describedby="emailHelp">
                            </div>
                            <div class="mb-3">
                                <label for="exampleInputEmail1" class="form-label">Email</label>
                                <input value="<?=$data['email']?>" name="email" type="email" class="form-control" id="exampleInputEmail1"
                                    aria-describedby="emailHelp">
                            </div>
                            <div class="mb-3">
                                <label for="exampleInputEmail1" class="form-label">Jenis Kelamin</label>
                                <br>
                                <div class="form-check form-check-inline">
                                    <input class="form-check-input" type="radio" name="jk" <?php echo $data['jk']=='Laki-laki' ? 'checked' : '' ?>
                                        id="inlineRadio1" value="Laki-laki">
                                    <label class="form-check-label" for="inlineRadio1">Laki-Laki</label>
                                </div>
                                <div class="form-check form-check-inline">
                                    <input class="form-check-input" type="radio" name="jk" <?php echo $data['jk']=='Perempuan' ? 'checked' : '' ?>
                                        id="inlineRadio2" value="Perempuan">
                                    <label class="form-check-label" for="inlineRadio2">Perempuan</label>
                                </div>
                            </div>
                            <div class="mb-3">
                                <label for="exampleInputEmail1" class="form-label">Jurusan</label>
                                <select class="form-control" name="jur" id="">
                                    <option value="">-Pilih Jurusan-</option>
                                    <option <?php echo $data['jur']=='IPA' ? 'selected' : '' ?> value="IPA">IPA</option>
                                    <option <?php echo $data['jur']=='IPS' ? 'selected' : '' ?> value="IPS">IPS</option>
                                    <option <?php echo $data['jur']=='Bahasa' ? 'selected' : '' ?> value="Bahasa">Bahasa</option>
                                </select>
                            </div>
                            <div class="mb-3">
                                <label for="exampleInputEmail1" class="form-label">Foto</label>
                                <input name="foto" type="file" class="form-control" id="exampleInputEmail1"
                                    aria-describedby="emailHelp">
                            </div>
                            <button type="submit" class="btn btn-primary">Submit</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>


    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-FKyoEForCGlyvwx9Hj09JcYn3nv7wiPVlz7YYwJrWVcXK/BmnVDxM+D2scQbITxI"
        crossorigin="anonymous"></script>
</body>

</html>