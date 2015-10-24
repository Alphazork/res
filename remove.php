<?php
include("mysql.php");

$deviceLookup = array(0,3,4,6,7,8,9,10,11,13);

$Lehrer=$_GET['lehrer'];
$when=explode("_", $_GET['time']);
$woche=$_GET['woche'];
$date = new DateTimeImmutable("last monday +$woche week");

$q = mysqli_query($conn,"DELETE FROM res WHERE Stunde = $when[0] AND Date = '".$date->modify('+'.$when[1].' days')->format("Y-m-d")."' AND Lehrer = '$Lehrer'");
?>