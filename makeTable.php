<?php
    session_start();
    $Lehrer = $_SESSION["user"];
    //0...2 => Dell Laptops
    //3...5 => HP Laptops
    //6...7 => Beamer Medienwagen
    //8...9 => Fernseher Medienwagen
    //10...11 => Beamer
    //12...15 => DVD
    //16...17 => VHS
    
    $deviceLookup = array(0,2,3,5,6,7,8,9,10,11,12,15,16,17);
    
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

    $deviceName = array(
        0  => "Laptop(DELL) 1",
        1  => "Laptop(DELL) 2",
        2  => "Laptop(DELL) 3",
        3  => "Laptop(HP) 1",
        4  => "Laptop(HP) 2",
        5  => "Laptop(HP) 3",
        6  => "Medienwagen(Beamer) 1",
        7  => "Medienwagen(Beamer) 2",
        8  => "Medienwagen(Fernseher) 1",
        9 => "Medienwagen(Fernseher) 2",
        10 => "Beamer 1",
        11 => "Beamer 2",
        12 => "DVD 1",
        13 => "DVD 2",
        14 => "DVD 3",
        15 => "DVD 4",
        16 => "VHS 2",
        17 => "VHS 3",
    );

	echo "<table class='table table-striped'>";

    $week = $_GET["week"];
    $device = $_GET["device"];
    $date = new DateTimeImmutable("last monday +$week week");
    echo "<tr>
                <th>Uhrzeit</th>
                <th>Montag ".$date->format("d.m")."</th>
                <th>Dienstag ".$date->modify("+1 days")->format("d.m")."</th>
                <th>Mittwoch ".$date->modify("+2 days")->format("d.m")."</th>
                <th>Donnerstag ".$date->modify("+3 days")->format("d.m")."</th>
                <th>Freitag ".$date->modify("+4 days")->format("d.m")."</th>
            </tr>";

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
                        echo "<td class='frei' id='".$i."_".$d."' style='color:#limegreen;'>Keine Frei</td>";
                    }else if (mysqli_num_rows($test)==1) {
                        echo "<td class='bes' id='".$i."_".$d."' style='color:#CF000F;'>RESERVIERT</td>";
                        break;
                    }
                }
    		}
    	}
    	echo "<tr>";
    }
    echo "</table>";
    if ($Lehrer == "vor.nachname") {
        echo "<table class='table table-striped'>";
        echo "<tr>";
            echo "<th>Datum</th>";
            echo "<th>Stunde</th>";
            echo "<th>Lehrer</th>";
            echo "<th>Gerät</th>";
            echo "</tr>";
        $test = mysqli_query($conn, "SELECT * FROM res ORDER BY Date ASC");
        while ($row = mysqli_fetch_array($test)) {
            echo "<tr>";
            echo "<td>".$row["Date"]."</td>";
            echo "<td>".($row["Stunde"]+1)."</td>";
            echo "<td>".$row["Lehrer"]."</td>";
            echo "<td>".$deviceName[$row["DeviceID"]]."</td>";
            echo "</tr>";
        }
       
        echo "</table>";
    }
    echo"<script>
    $('.frei').each(function(i, e){
        $(e).click(function(){
            $.ajax({
                url: 'insert.php',
                data: {time:$(e).attr('id'),woche:$week,device:$device},
                success: function(result){
                $('#test').html(result);
                //alert('Es wurde '+$device+' um '+$(e).attr('id')+' reserviert');
                updateTable();
            } 
        });
    });
    });
    $('.bes').each(function(i, e){
            $(e).click(function(){
                $.ajax({
                    url: 'remove.php',
                    data: {time:$(e).attr('id'),woche:$week,device:$device},
                    success: function(result){
                    $('#test').html(result);
                    updateTable();
                } 
            });
        });
        });
    </script>";
?>