<?php
    //0...3 => Laptops
    //4...6 => Beamer
    //7...8 => DVD
    //9...10 => VHS
    //11...13 => Medienwägen
    
    $deviceLookup = array(0,3,4,6,7,8,9,10,11,13);
    
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
        		<th id='Montag'>Montag</th>
        		<th>Dienstag</th>
        		<th>Mittwoch</th>
        		<th>Donnerstag</th>
        		<th>Freitag</th>
        	</tr>";
    $week = $_GET["week"];
    $device = $_GET["device"];
    $date = new DateTimeImmutable("last monday +$week week");

    $data = array();

    $q = mysqli_query($conn, "SELECT * FROM res WHERE Date BETWEEN '".$date->format("Y-m-d")."' AND '".$date->modify("+4 days")->format("Y-m-d")."';");

    while($d = mysqli_fetch_assoc($q)){
        if(!array_key_exists($d["Date"], $data))$data[$d["Date"]] = array();
        if(!array_key_exists($d["Stunde"], $data[$d["Date"]]))$data[$d["Date"]][$d["Stunde"]] = array();
        array_push($data[$d["Date"]][$d["Stunde"]], $d["DeviceID"]);
    }

    for($i = 0; $i < 12; $i++){
//<<<<<<< Updated upstream
        //echo "<th>$wk[$i]</th>";
        for($d = 0; $d < 5; $d++){
            $isAvailable = false;
            if(!array_key_exists($date->modify("+$d days")->format("Y-m-d"), $data)){
                $isAvailable = true;
            }else if(!array_key_exists($i+1, $data[$date->modify("+$d days")->format("Y-m-d")])){
                $isAvailable = true;
            }else{
                $res = $data[$date->modify("+$d days")->format("Y-m-d")][$i+1];
                switch($device){
                    case 0:
                        $isAvailable = !!array_diff(array(0,1,2,3), $res);
                    break;
                    case 1:
                        $isAvailable = !!array_diff(array(4,5,6), $res);
                    break;
                    case 2:
                        $isAvailable = !!array_diff(array(7,8), $res);
                    break;
                    case 3:
                        $isAvailable = !!array_diff(array(9,10), $res);
                    break;
                    case 4:
                        $isAvailable = !!array_diff(array(11,12,13), $res);
                    break;
                }
            }
    		if($isAvailable){
    			//echo "<td style='color:rgb(65,166,33);'>Frei</td>";
    		}else{
    			//echo "<td style='color:rgb(170,17,20);'>Reserviert</td>";
    		}
//=======
		$stunde = $i;
    	echo "<th>".$wk[$i]."</th>";

    	//$q = mysqli_query($conn, "SELECT * FROM res WHERE Stunde = $stunde AND Date BETWEEN '".$date->format("Y-m-d")."' AND '".$date->modify("+4 days")->format("Y-m-d")."';");
    	//if(mysqli_fetch_array($q) == null){
    		for($d = 0; $d < 5; $d++){
                for ($a=$deviceLookup[$device*2]; $a <= $deviceLookup[$device*2+1]; $a++) { 
                    $q = mysqli_query($conn,"SELECT DeviceID FROM res WHERE DeviceID = $a AND Stunde = $stunde AND Date = '".$date->modify('+'.$d.' days')->format("Y-m-d")."' ");
                    if (mysqli_num_rows($q)==0) {
                        echo "<td class='frei' id='".$i."_".$d."' style='color:#2ecc71;'>Frei ".($deviceLookup[$device*2+1]+1-$a)."/".($deviceLookup[$device*2+1]-$deviceLookup[$device*2]+1)."</td>";
                        break;
                    }else if($a==$deviceLookup[$device*2+1]){
                        echo "<td class='frei' id='".$i."_".$d."' style='color:#e74c3c;'>Frei 0/".($deviceLookup[$device*2+1]-$deviceLookup[$device*2]+1)."</td>";
                    }
                }
    		}
    	//}else{
			//for($d = 0; $d < 5; $d++){
    			//$q = mysqli_query($conn, "SELECT * FROM res WHERE Stunde = $stunde AND DeviceID = $device AND Date = '".$date->modify('+'.$d.' days')->format("Y-m-d")."'");
    			//if(mysqli_fetch_array($q) == null){
    			//	echo "<td class='frei' id='".$i."_".$d."' style='color:rgb(65,166,33);'>Frei</td>";
    			//}else{
    			//	echo "<td class='frei' id='".$i."_".$d."' style='color:rgb(170,17,20);'>Reserviert</td>";
    			//}
			//}
//>>>>>>> Stashed changes
    	}
    	echo "<tr>";
    }//}
    echo "</table>";
    echo"<script>
    $('.frei').each(function(i, e){
        $(e).click(function(){
            $.ajax({
                url: 'insert.php',
                data: {time:$(e).attr('id'),lehrer:'Max',woche:$week,device:$device},
                success: function(result){
                $('#test').html(result);
                updateTable();
            } 
        });
    });
    });
    </script>";
?>