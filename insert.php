<?php
include("mysql.php");
$Lehrer=$_GET['lehrer'];
$when=explode("_", $_GET['time']);
$woche=$_GET['woche'];
$device=$_GET['device'];
echo $Lehrer;
echo $woche;
echo $when[1];
$date = new DateTimeImmutable("last monday +$woche week");
$q = mysqli_query($conn, "INSERT INTO res (Date,Stunde,Lehrer,DeviceID) values ('".$date->modify('+'.$when[1].' days')->format("Y-m-d")."','".$when[0]."',0,'".$device."');");

?>