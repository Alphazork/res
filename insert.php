<?php
    //0...3 => Laptops
    //4...6 => Beamer
    //7...8 => DVD
    //9...10 => VHS
    //11...13 => Medienwägen
include("mysql.php");

$deviceLookup = array(0,3,4,6,7,8,9,10,11,13);

$Lehrer=$_GET['lehrer'];
$when=explode("_", $_GET['time']);
$woche=$_GET['woche'];
$device=$_GET['device'];
echo "Eingeloggt als:".$Lehrer;
$date = new DateTimeImmutable("last monday +$woche week");

$test=array();
for ($i=$deviceLookup[$device*2]; $i <= $deviceLookup[$device*2+1]; $i++) { 
	$q = mysqli_query($conn,"SELECT DeviceID FROM res WHERE DeviceID = $i AND Stunde = $when[0] AND Date = '".$date->modify('+'.$when[1].' days')->format("Y-m-d")."' ");
	if (mysqli_num_rows($q)==0) {
		$q = mysqli_query($conn, "INSERT INTO res (Date,Stunde,Lehrer,DeviceID) values ('".$date->modify('+'.$when[1].' days')->format("Y-m-d")."',$when[0],0,$i);");
		break;
	}
}

//$q = mysqli_query($conn,"SELECT DeviceID FROM res WHERE DeviceID =  AND Stunde = '".$when[0]."' AND Date = '".$date->modify('+'.$when[1].' days')->format("Y-m-d")."' ");
//if ($q) {
//	while ($row = mysqli_fetch_assoc($q)) {
//		array_push($test, $row['DeviceID']);
//	}
//}

//$q = mysqli_query($conn, "INSERT INTO res (Date,Stunde,Lehrer,DeviceID) values ('".$date->modify('+'.$when[1].' days')->format("Y-m-d")."','".$when[0]."',0,'".$device."');");
//echo ", reserviert:";
//$q2 = mysqli_query($conn, "SELECT * FROM res WHERE Lehrer ='".$Lehrer."'");
//while ($row = mysqli_fetch_assoc($q2)) {
//s	echo " ".$row['DeviceID'];
//}
?>