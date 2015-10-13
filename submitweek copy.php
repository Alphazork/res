<?php
echo "<table id='day'>
<tr>
  		<td>Montag</td>
  		<td>Dienstag</td>
  		<td>Mittwoch</td>
  		<td>Donnerstag</td>
  		<td>Freitag</td>
   	</tr><tr>";

$servername = "localhost";
$username = "root";
$password = "";
$database = "Reservierung";

// Create connection
$conn = mysqli_connect($servername, $username, $password, $database);

// Check connection
if (!$conn) {
    die("Connection failed: " . mysqli_connect_error());
}

$sql = "select * FROM res";
$result = mysqli_query($conn, $sql);

if (mysqli_num_rows($result) > 0) {
    // output data of each row
    $w = -1;
    while($row = mysqli_fetch_assoc($result)) {
    	$w++;
        $REST[$w] = explode("-", $row["Tag"]);
        $RESS[$w] = $row["Stunde"];
        $WAS[$w] = $row["Was"];
        array_shift($REST[$w]);
    }
}

if ($_GET["weekSelected"]=="w1") {
	for ($i=0; $i <= $w; $i++) { 
		$Wochen = getDate(strtotime('last Monday'));
		$diffT[$i] = $REST[$i][1]-$Wochen["mday"];

		$Wochen = getDate(strtotime('next Sunday'));
		$diffM[$i] = $REST[$i]["0"]-$Wochen["mon"];
	}
	$Wochen = getDate(strtotime('next Monday'));

$i=0;
	foreach ($diffT as $value) { 
		if ($value < $Wochen["mday"]) {
			while($i<4) {
				echo "<td>";
				if ($value==$i) {
				 	echo "YESSSS";
				 	$i++;
				 	break;
				}else {
					echo "No";
					$i++;
				}
				echo "</td>";
			}
		}
	}
	for ($x=0; $x < 4; $x++) { 
		if ($i<=4) {
			echo "<td></td>";
			$i++;
		}
	}
}

if ($_GET["weekSelected"]=="w2") {
	for ($i=0; $i <= $w; $i++) { 
		$Wochen = getDate(strtotime('next Monday'));
		if($REST[$i][1]-$Wochen["mday"] >= 0 ) $diffT[$i] = $REST[$i][1]-$Wochen["mday"];
		//echo $diffT[$i];

		$Wochen = getDate(strtotime('next Sunday + 1 week'));
		$diffM[$i] = $REST[$i]["0"]-$Wochen["mon"];
		//print_r($diffM);

	}
	$Wochen = getDate(strtotime('next Monday + 1 week'));

$i=0;
	foreach ($diffT as $value) { 
		if ($value < $Wochen["mday"]) {
			while($i<4) {
				echo "<td>";
				if ($value==$i) {
				 	echo "YESSSS";
				 	$i++;
				 	break;
				}else {
					echo "No";
					$i++;
				}
				echo "</td>";
			}
		}
	}
	for ($x=0; $x < 4; $x++) { 
		if ($i<=4) {
			echo "<td></td>";
			$i++;
		}
	}
}

if ($_GET["weekSelected"]=="w3") {
	for ($i=0; $i <= $w; $i++) { 
		$Wochen = getDate(strtotime('next Monday + 1 week'));
		if($REST[$i][1]-$Wochen["mday"] >= 0 ) $diffT[$i] = $REST[$i][1]-$Wochen["mday"];

		$Wochen = getDate(strtotime('next Sunday + 2 weeks'));
		$diffM[$i] = $REST[$i]["0"]-$Wochen["mon"];
	}
	$Wochen = getDate(strtotime('next Monday + 2 weeks'));

$i=0;
if ($diffT == null) {	
	foreach ($diffT as $value) { 
		if ($value < $Wochen["mday"]) {
			while($i<4) {
				echo "<td>";
				if ($value==$i) {
				 	echo "YESSSS";
				 	$i++;
				 	break;
				}else {
					echo "No";
					$i++;
				}
				echo "</td>";
			}
		}
	}
	for ($x=0; $x < 4; $x++) { 
		if ($i<=4) {
			echo "<td></td>";
			$i++;
		}
	}
}
}

for ($i=0; $i <=4; $i++) {
	if (1==1) {
	 	
	}else{ 
	echo "<td>
	<div>Stunde 1:</div>
	<div>Stunde 2:</div>
	<div>Stunde 3:</div>
	<div>Stunde 4:</div>
	<div>Stunde 5:</div>
	<div>Stunde 6:</div>
	<div>Stunde 7:</div>
	<div>Stunde 8:</div>
	<div>Stunde 9:</div>
	
  			<div class='ausw'>Laptop</div>
  			<div class='ausw'>Recorder</div>
  			<div class='ausw'>Fehrnseher</div>
  		</td>
	";
}}
echo "</tr></table>";
echo "<script>
$('.ausw').click(function() {
		if($(this).hasClass('selected')){
			$(this).removeClass('selected');
		}else{
			$(this).addClass('selected');
		}
	});
</script>";
?> 