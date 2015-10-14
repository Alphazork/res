<?php
	include("mysql.php");
	$wk = array(
		0 => "8:10 - 9:00",
		1 => "9:05 - 9:55",
		2 => "10:05 - 10:55",
		3 => "11:05 - 11:55",
		4 => "12:05 - 12:55",
		5 => "13:00 - 13:50",
		6 => "13:50 - 14:40",
		7 => "14:40 - 15:30",
		8 => "15:30 - 16:20",
		9 => "16:20 - 17:10",
		10 => "17:10 - 18:00",
		11 => "18:00 - 18:50"
		);
	echo "<table class='table table-striped'>";
	echo "<tr>
				<th>Uhrzeit</th>
        		<th>Montag</th>
        		<th>Dienstag</th>
        		<th>Mittwoch</th>
        		<th>Donnerstag</th>
        		<th>Freitag</th>
        	</tr>";
    $week = $_GET["week"];
    $device = $_GET["device"];
    $date = new DateTimeImmutable("last monday +$week week");
    for($i = 0; $i < 12; $i++){
		$stunde = $i+1;
    	echo "<th>".$wk[$i]."</th>";
    	$q = mysqli_query($conn, "SELECT * FROM res WHERE Stunde = $stunde AND Tag BETWEEN '".$date->format("Y-m-d")."' AND '".$date->modify("+4 days")->format("Y-m-d")."';");
    	if(mysqli_fetch_array($q) == null){
    		for($d = 0; $d < 5; $d++){
    			echo "<td style='color:rgb(65,166,33);'>Frei</td>";
    		}
    	}else{
			for($d = 0; $d < 5; $d++){
    			$q = mysqli_query($conn, "SELECT * FROM res WHERE Tag = '".$date->modify('+'.$d.' days')->format("Y-m-d")."' AND Stunde = $stunde");
    			if(mysqli_fetch_array($q) == null){
    				echo "<td style='color:rgb(65,166,33);'>Frei</td>";
    			}else{
    				echo "<td style='color:rgb(170,17,20);'>Reserviert</td>";
    			}
			}
    	}
    	echo "<tr>";
    }
    echo "</table>";
?>