<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<body>
    <Form action="">
        Pilih Tanggal :
        <select>
            <?php
                for($i = 1; $i <= 31; $i++){
                    echo "<option>$i</option>";
                }
            ?>
        </select>


        <br>
        <br>

        Pilih Bulan :
        <select>
            <?php
                $bulan = array(
                    1 => "Januari",
                    2 => "Februari",
                    3 => "Maret",
                    4 => "April",
                    5 => "Mei",
                    6 => "Juni",
                    7 => "Juli",
                    8 => "Agustus",
                    9 => "September",
                    10 => "Oktober",
                    11 => "November",
                    12 => "Desember"
                );

                foreach($bulan as $b){
                    echo "<option>$b</option>";
                }
            ?>
        </select>

        <br>
        <br>

        Pilih Tahun :
        <select>        
            <?php
                for($thn = 2025; $thn >= 1970; $thn--){
                    echo "<option>$thn</option>";
                }
            ?>
        </select>

    </Form>
</body>
</html>