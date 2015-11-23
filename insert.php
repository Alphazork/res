<?php
	session_start();
    //0...3 => Laptops
    //4...6 => Beamer
    //7...8 => DVD
    //9...10 => VHS
    //11...13 => Medienwägen
include("mysql.php");

$deviceLookup = array(0,2,3,5,6,7,8,9,10,11,12,15,16,17);

$Lehrer=$_SESSION["user"];
$when=explode("_", $_GET['time']);
$woche=$_GET['woche'];
$device=$_GET['device'];
$date = new DateTimeImmutable("last monday +$woche week");

$test=array();
for ($i=$deviceLookup[$device*2]; $i <= $deviceLookup[$device*2+1]; $i++) { 
	$q = mysqli_query($conn,"SELECT DeviceID FROM res WHERE DeviceID = $i AND Stunde = $when[0] AND Date = '".$date->modify('+'.$when[1].' days')->format("Y-m-d")."' ");
	if (mysqli_num_rows($q)==0) {
		$a1=$deviceLookup[$device*2];
		$a2=$deviceLookup[$device*2+1];
		$test = mysqli_query($conn, "SELECT * FROM res WHERE DeviceID BETWEEN $a1 AND $a2 AND Stunde = $when[0] AND Date = '".$date->modify('+'.$when[1].' days')->format("Y-m-d")."' AND Lehrer = '$Lehrer'");
		if (mysqli_num_rows($test)==0) {
			$q = mysqli_query($conn, "INSERT INTO res (Date,Stunde,Lehrer,DeviceID) values ('".$date->modify('+'.$when[1].' days')->format("Y-m-d")."',$when[0],'$Lehrer',$i);");
			break;
		}
	}
}
?>