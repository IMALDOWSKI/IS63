<?php
$result = '';
$input = '';

// hanya proses jika form disubmit
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['tbl'])) {
    $inputRaw = $_POST['tanggal'] ?? '';
    $input = trim($inputRaw);

    // validasi: harus angka antara 1 dan 7
    if ($input === '' || !is_numeric($input)) {
        $result = 'Masukkan angka antara 1 dan 7.';
    } else {
        $hari = (int)$input;
        switch ($hari) {
            case 1:
                $result = 'Hari Minggu';
                break;
            case 2:
                $result = 'Hari Senin';
                break;
            case 3:
                $result = 'Hari Selasa';
                break;
            case 4:
                $result = 'Hari Rabu';
                break;
            case 5:
                $result = 'Hari Kamis';
                break;
            case 6:
                $result = 'Hari Jumat';
                break;
            case 7:
                $result = 'Hari Sabtu';
                break;
            default:
                $result = 'Hari Tidak Diketahui (masukkan 1–7)';
        }
    }
}
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Cek Hari</title>
</head>
<body>
    <h1>MASUKKAN TANGGAL (1-7)</h1>

    <form action="form-switch.php" method="POST">
        <table>
            <tr>
                <td>Tanggal</td>
                <td>:</td>
                <td><input type="number" name="tanggal" min="1" max="7" value="<?php echo htmlspecialchars($input); ?>"></td>
            </tr>
            <tr>
                <td></td>
                <td></td>
                <td><input type="submit" name="tbl" value="Cek Hari"></td>
            </tr>
        </table>
    </form>

    <?php if ($result !== ''): ?>
        <p><strong>Hasil:</strong> <?php echo htmlspecialchars($result); ?></p>
    <?php endif; ?>
</body>
</html>