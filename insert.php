<?php
include("mysql.php");
$Lehrer=$_GET['lehrer'];
$when=explode("_", $_GET['time']);
$woche=$_GET['woche'];
$device=$_GET['device'];
echo "Eingeloggt als:".$Lehrer;
$date = new DateTimeImmutable("last monday +$woche week");
$q = mysqli_query($conn, "INSERT INTO res (Date,Stunde,Lehrer,DeviceID) values ('".$date->modify('+'.$when[1].' days')->format("Y-m-d")."','".$when[0]."',0,'".$device."');");
echo ", reserviert:";
$q2 = mysqli_query($conn, "SELECT * FROM res WHERE Lehrer ='".$Lehrer."'");
while ($row = mysqli_fetch_assoc($q2)) {
	echo " ".$row['DeviceID'];
}
?>