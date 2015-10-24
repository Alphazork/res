<?php
    $Lehrer = 'das.test';
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
        for($d = 0; $d < 5; $d++){
		$stunde = $i;
    	echo "<th>".$wk[$i]."</th>";
    		for($d = 0; $d < 5; $d++){
                for ($a=$deviceLookup[$device*2]; $a <= $deviceLookup[$device*2+1]; $a++) { 
                    $q = mysqli_query($conn,"SELECT DeviceID FROM res WHERE DeviceID = $a AND Stunde = $stunde AND Date = '".$date->modify('+'.$d.' days')->format("Y-m-d")."' ");
                    $test = mysqli_query($conn, "SELECT * FROM res WHERE DeviceID = $a AND Stunde = $stunde AND Date = '".$date->modify('+'.$d.' days')->format("Y-m-d")."' AND Lehrer = '$Lehrer'");
                    if (mysqli_num_rows($q)==0) {
                        echo "<td class='frei' id='".$i."_".$d."' style='color:#2ecc71;'>Frei ".($deviceLookup[$device*2+1]+1-$a)."/".($deviceLookup[$device*2+1]-$deviceLookup[$device*2]+1)."</td>";
                        break;
                    }else if($a==$deviceLookup[$device*2+1]){
                        echo "<td class='frei' id='".$i."_".$d."' style='color:#e74c3c;'>Frei 0/".($deviceLookup[$device*2+1]-$deviceLookup[$device*2]+1)."</td>";
                    }else if (mysqli_num_rows($test)==1) {
                        echo "<td class='bes' id='".$i."_".$d."' style='color:#e74c3c;'>Reserviert</td>";
                        break;
                    }
                }
    		}
    	}
    	echo "<tr>";
    }
    echo "</table>";
    echo"<script>
    $('.frei').each(function(i, e){
        $(e).click(function(){
            $.ajax({
                url: 'insert.php',
                data: {time:$(e).attr('id'),lehrer:'$Lehrer',woche:$week,device:$device},
                success: function(result){
                $('#test').html(result);
                updateTable();
            } 
        });
    });
    });
    $('.bes').each(function(i, e){
            $(e).click(function(){
                $.ajax({
                    url: 'remove.php',
                    data: {time:$(e).attr('id'),lehrer:'$Lehrer',woche:$week,device:$device},
                    success: function(result){
                    $('#test').html(result);
                    updateTable();
                } 
            });
        });
        });
    </script>";
?>