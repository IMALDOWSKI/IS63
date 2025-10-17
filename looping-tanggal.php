<?php
// nilai default / setelah submit
$selectedDay = isset($_POST['day']) ? (int)$_POST['day'] : (int)date('j');
$selectedMonth = isset($_POST['month']) ? (int)$_POST['month'] : (int)date('n');
$selectedYear = isset($_POST['year']) ? (int)$_POST['year'] : (int)date('Y');

// data bulan
$months = [
    1 => 'Januari', 2 => 'Februari', 3 => 'Maret', 4 => 'April',
    5 => 'Mei', 6 => 'Juni', 7 => 'Juli', 8 => 'Agustus',
    9 => 'September', 10 => 'Oktober', 11 => 'November', 12 => 'Desember'
];

// tahun dari 2025 turun ke 1970
$years = range(2025, 1970);
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Pilih Tanggal</title>
    <style>
        .row { display:flex; gap:8px; align-items:center; }
        select { padding:4px; }
        .col-label { width:80px; }
    </style>
    <script>
        // tombol cepat: set ke hari ini di browser
        function setToday() {
            const today = new Date();
            document.getElementById('day').value = today.getDate();
            document.getElementById('month').value = today.getMonth() + 1;
            document.getElementById('year').value = today.getFullYear();
        }
    </script>
</head>
<body>
    <h1>Pilih Tanggal</h1>

    <form method="POST" action="looping-tanggal.php">
        <div class="row">
            <label class="col-label" for="day">Tanggal</label>
            <select id="day" name="day" aria-label="Tanggal">
                <option value="">--</option>
                <?php for ($d = 1; $d <= 31; $d++): ?>
                    <option value="<?php echo $d; ?>" <?php echo ($d === $selectedDay) ? 'selected' : ''; ?>>
                        <?php echo $d; ?>
                    </option>
                <?php endfor; ?>
            </select>

            <label class="col-label" for="month">Bulan</label>
            <select id="month" name="month" aria-label="Bulan">
                <option value="">--</option>
                <?php foreach ($months as $num => $name): ?>
                    <option value="<?php echo $num; ?>" <?php echo ($num === $selectedMonth) ? 'selected' : ''; ?>>
                        <?php echo $name; ?>
                    </option>
                <?php endforeach; ?>
            </select>

            <label class="col-label" for="year">Tahun</label>
            <select id="year" name="year" aria-label="Tahun">
                <option value="">--</option>
                <?php foreach ($years as $y): ?>
                    <option value="<?php echo $y; ?>" <?php echo ($y === $selectedYear) ? 'selected' : ''; ?>>
                        <?php echo $y; ?>
                    </option>
                <?php endforeach; ?>
            </select>

            <button type="button" onclick="setToday()">Hari ini</button>
            <button type="submit" name="tbl">Pilih</button>
        </div>
    </form>

    <?php if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['tbl'])): ?>
        <hr>
        <?php
            $d = (int)$selectedDay;
            $m = (int)$selectedMonth;
            $y = (int)$selectedYear;
            if ($d >= 1 && $d <= 31 && $m >= 1 && $m <= 12 && $y >= 1970 && $y <= 2025) {
                echo '<p>Anda memilih: <strong>' . htmlspecialchars(sprintf('%02d %s %04d', $d, $months[$m], $y)) . '</strong></p>';
            } else {
                echo '<p style="color:red">Pilihan tidak valid. Pastikan memilih tanggal, bulan, dan tahun dalam rentang.</p>';
            }
        ?>
    <?php endif; ?>
</body>
</html>