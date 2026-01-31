<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Gelombang Pendaftaran Siswa</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-sRIl4kxILFvY47J16cr9ZwB07vP4J8+LH7qKQnuqkuIAvNWLzeN8tE5YBujZqJLB" crossorigin="anonymous">
    <link rel="stylesheet" href="../css/all.css">
</head>

<body style="background-color:#d1e6d4">
    <?php
    include_once("../navbar.php");
    include("../koneksi.php");
    
    // Fungsi untuk menampilkan nama gelombang
    function namaGelombang($gelombang) {
        switch($gelombang) {
            case 1: return "Gelombang 1 (Januari - Maret)";
            case 2: return "Gelombang 2 (April - Juni)";
            case 3: return "Gelombang 3 (Juli - September)";
            case 4: return "Gelombang 4 (Oktober - Desember)";
            default: return "Gelombang " . $gelombang;
        }
    }
    
    // Fungsi untuk badge warna per gelombang
    function badgeGelombang($gelombang) {
        switch($gelombang) {
            case 1: return "bg-primary";
            case 2: return "bg-success";
            case 3: return "bg-warning";
            case 4: return "bg-danger";
            default: return "bg-secondary";
        }
    }
    ?>

    <div class="container">
        <div class="row my-5">
            <div class="col-11 m-auto">
                <div class="card shadow p-3 mb-5 bg-body-tertiary rounded">
                    <div class="card-header">
                        <h4><b>📋 GELOMBANG PENDAFTARAN SISWA</b></h4>
                        <p class="mb-0 text-muted">Daftar siswa berdasarkan gelombang pendaftaran</p>
                    </div>
                    <div class="card-body">
                        
                        <?php
                        // Loop untuk setiap gelombang (1-4)
                        for($g = 1; $g <= 4; $g++) {
                            // Query untuk ambil siswa berdasarkan gelombang
                            $qry = "SELECT biodata.*, jurusan.nama_jurusan, jurusan.kode 
                                    FROM biodata 
                                    INNER JOIN jurusan ON biodata.jurusans_id = jurusan.id 
                                    WHERE biodata.gelombang = $g
                                    ORDER BY biodata.nama ASC";
                            
                            $result = mysqli_query($koneksi, $qry);
                            $jumlah_siswa = mysqli_num_rows($result);
                        ?>
                        
                        <!-- Card untuk setiap gelombang -->
                        <div class="card mb-4">
                            <div class="card-header <?=badgeGelombang($g)?> text-white">
                                <h5 class="mb-0">
                                    <i class="fa-solid fa-users"></i> <?=namaGelombang($g)?>
                                    <span class="badge bg-light text-dark float-end"><?=$jumlah_siswa?> Siswa</span>
                                </h5>
                            </div>
                            <div class="card-body">
                                <?php if($jumlah_siswa > 0): ?>
                                    <div class="table-responsive">
                                        <table class="table table-hover">
                                            <thead>
                                                <tr>
                                                    <th width="5%">#</th>
                                                    <th width="15%">NISN</th>
                                                    <th width="25%">Nama Lengkap</th>
                                                    <th width="20%">Jurusan</th>
                                                    <th width="15%">Tanggal Lahir</th>
                                                    <th width="15%">Tanggal Daftar</th>
                                                    <th width="5%">Aksi</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <?php 
                                                $no = 1;
                                                while($data = mysqli_fetch_assoc($result)): 
                                                ?>
                                                <tr>
                                                    <td><?=$no++?></td>
                                                    <td><?=$data['nisn']?></td>
                                                    <td>
                                                        <strong><?=$data['nama']?></strong><br>
                                                        <small class="text-muted"><?=$data['jk']?></small>
                                                    </td>
                                                    <td>
                                                        <span class="badge bg-info"><?=$data['kode']?></span>
                                                        <?=$data['nama_jurusan']?>
                                                    </td>
                                                    <td><?=date('d M Y', strtotime($data['tg_lahir']))?></td>
                                                    <td>
                                                        <?php if($data['tgl_daftar']): ?>
                                                            <i class="fa-solid fa-calendar"></i> <?=date('d M Y', strtotime($data['tgl_daftar']))?>
                                                        <?php else: ?>
                                                            <span class="text-muted">-</span>
                                                        <?php endif; ?>
                                                    </td>
                                                    <td>
                                                        <button class="btn btn-sm btn-warning" data-bs-toggle="modal" data-bs-target="#detailModal<?=$data['id']?>">
                                                            <i class="fa-solid fa-eye"></i>
                                                        </button>
                                                    </td>
                                                </tr>
                                                
                                                <!-- Modal Detail -->
                                                <div class="modal fade" id="detailModal<?=$data['id']?>" tabindex="-1">
                                                    <div class="modal-dialog">
                                                        <div class="modal-content">
                                                            <div class="modal-header <?=badgeGelombang($g)?> text-white">
                                                                <h5 class="modal-title">Detail Siswa</h5>
                                                                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
                                                            </div>
                                                            <div class="modal-body">
                                                                <div class="text-center mb-3">
                                                                    <?php if($data['foto']): ?>
                                                                        <img src="../fotosiswa/<?=$data['foto']?>" class="img-thumbnail" width="150" alt="Foto">
                                                                    <?php else: ?>
                                                                        <div class="bg-secondary text-white p-5 rounded">
                                                                            <i class="fa-solid fa-user fa-3x"></i>
                                                                        </div>
                                                                    <?php endif; ?>
                                                                </div>
                                                                <table class="table table-borderless">
                                                                    <tr>
                                                                        <td width="40%"><strong>Nama</strong></td>
                                                                        <td><?=$data['nama']?></td>
                                                                    </tr>
                                                                    <tr>
                                                                        <td><strong>NISN</strong></td>
                                                                        <td><?=$data['nisn']?></td>
                                                                    </tr>
                                                                    <tr>
                                                                        <td><strong>Tempat Lahir</strong></td>
                                                                        <td><?=$data['tp_lahir']?></td>
                                                                    </tr>
                                                                    <tr>
                                                                        <td><strong>Tanggal Lahir</strong></td>
                                                                        <td><?=date('d F Y', strtotime($data['tg_lahir']))?></td>
                                                                    </tr>
                                                                    <tr>
                                                                        <td><strong>Tanggal Daftar</strong></td>
                                                                        <td>
                                                                            <?php if($data['tgl_daftar']): ?>
                                                                                <?=date('d F Y', strtotime($data['tgl_daftar']))?>
                                                                            <?php else: ?>
                                                                                -
                                                                            <?php endif; ?>
                                                                        </td>
                                                                    </tr>
                                                                    <tr>
                                                                        <td><strong>Gelombang</strong></td>
                                                                        <td><span class="badge <?=badgeGelombang($data['gelombang'])?>"><?=namaGelombang($data['gelombang'])?></span></td>
                                                                    </tr>
                                                                    <tr>
                                                                        <td><strong>Alamat</strong></td>
                                                                        <td><?=$data['alamat']?></td>
                                                                    </tr>
                                                                    <tr>
                                                                        <td><strong>Email</strong></td>
                                                                        <td><?=$data['email']?></td>
                                                                    </tr>
                                                                    <tr>
                                                                        <td><strong>Jenis Kelamin</strong></td>
                                                                        <td><?=$data['jk']?></td>
                                                                    </tr>
                                                                    <tr>
                                                                        <td><strong>Jurusan</strong></td>
                                                                        <td><?=$data['kode']?> - <?=$data['nama_jurusan']?></td>
                                                                    </tr>
                                                                </table>
                                                            </div>
                                                            <div class="modal-footer">
                                                                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Tutup</button>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                                
                                                <?php endwhile; ?>
                                            </tbody>
                                        </table>
                                    </div>
                                <?php else: ?>
                                    <div class="alert alert-light text-center mb-0">
                                        <i class="fa-solid fa-inbox fa-2x mb-2 text-muted"></i>
                                        <p class="mb-0 text-muted">Belum ada siswa yang terdaftar di gelombang ini</p>
                                    </div>
                                <?php endif; ?>
                            </div>
                        </div>
                        
                        <?php } // End for loop gelombang ?>
                        
                        <!-- Ringkasan Total -->
                        <div class="card border-primary">
                            <div class="card-body">
                                <h5 class="card-title"><i class="fa-solid fa-chart-pie"></i> Ringkasan Total Siswa</h5>
                                <div class="row text-center">
                                    <?php
                                    for($g = 1; $g <= 4; $g++) {
                                        $qry_count = "SELECT COUNT(*) as total FROM biodata WHERE gelombang = $g";
                                        $result_count = mysqli_query($koneksi, $qry_count);
                                        $count = mysqli_fetch_assoc($result_count)['total'];
                                    ?>
                                    <div class="col-md-3">
                                        <div class="p-3 border rounded">
                                            <h6 class="text-muted mb-2">Gelombang <?=$g?></h6>
                                            <h2 class="mb-0"><span class="badge <?=badgeGelombang($g)?>"><?=$count?></span></h2>
                                            <small class="text-muted">siswa</small>
                                        </div>
                                    </div>
                                    <?php } ?>
                                </div>
                                
                                <?php
                                // Total keseluruhan
                                $qry_total = "SELECT COUNT(*) as total FROM biodata";
                                $result_total = mysqli_query($koneksi, $qry_total);
                                $total_semua = mysqli_fetch_assoc($result_total)['total'];
                                ?>
                                
                                <div class="mt-3 text-center">
                                    <h5>Total Keseluruhan: <span class="badge bg-dark"><?=$total_semua?> Siswa</span></h5>
                                </div>
                            </div>
                        </div>
                        
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-FKyoEForCGlyvwx9Hj09JcYn3nv7wiPVlz7YYwJrWVcXK/BmnVDxM+D2scQbITxI"
        crossorigin="anonymous"></script>
    <script src="../js/all.js"></script>
</body>

</html>