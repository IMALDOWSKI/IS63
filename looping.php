<?php

### FOR ###
echo "FOR";
echo "<br>";
echo "<br>";

for($i = 10; $i >= 1; $i--){
    echo "Mahasiswa ke-$i <br>";
}
echo "<hr>";

### WHILE ###
echo "WHILE";
echo "<br>";
echo "<br>";

$awal = 1;
while($awal <= 10){
    echo "Mahasiswa ke - $awal <br>";
    $awal++;
}
echo "<hr>";

### DO WHILE ###
echo "DO WHILE";
echo "<br>";
echo "<br>";

$dw = 1;
do{
    echo "Mahasiswa ke - $dw <br>";
    $dw++;
}while($dw <= 10);
echo "<hr>";

### FOREACH ###
echo "FOREACH";
echo "<br>";
echo "<br>";
$is63 = array("Habiel Hama", "Kiki Gemoy", "Mahfud");
foreach($is63 as $data){
    echo "$data <br>";
}
echo "<hr>";





?>