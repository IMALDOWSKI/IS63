<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Biodata Siswa</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-sRIl4kxILFvY47J16cr9ZwB07vP4J8+LH7qKQnuqkuIAvNWLzeN8tE5YBujZqJLB" crossorigin="anonymous">
</head>

<body style="background-color: #092054;">

    <?php
    include_once("navbar1.php");
    ?>

    <div class="container">
        <div class="row mt-3">
            <div class="col-15">
                <div class="card">
                    <div class="card-header">
                        ImaldowsForm's
                    </div>
                    <div class="card-body">
                        <h5 class="card-title">FORM BIODATA SISWA</h5>
                        <form action="proses_tambah1.php" method="POST" enctype="multipart/form-data">
                            <div class="mb-3">
                                <label for="inputNama" class="form-label">Nama</label>
                                <input name="nama" type="text" class="form-control" id="inputNama" aria-describedby="namaHelp">
                                <div id="namaHelp" class="form-text">Masukkan nama lengkap Anda.</div>
                            </div>

                            <div class="mb-3">
                                <label for="inputEmail" class="form-label">Email</label>
                                <input name="email" class="form-control" id="inputEmail" aria-describedby="emailHelp">
                                <div id="emailHelp" class="form-text">Kami tidak akan membagikan email Anda kepada siapa
                                    pun.</div>
                            </div>

                            <div class="mb-3">
                                <label for="inputNo_HP" class="form-label">No Hp</label>
                                <input name="no_hp" class="form-control" id="inputno_hp">
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