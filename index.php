<?php
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
?>
<!DOCTYPE html>
<html>
  <head>
    <link rel="stylesheet" type="text/css" href="style.css" />
    <script type="text/javascript" src="jquery-2.1.4.min.js"></script>
    <script type="text/javascript" src="script.js"></script>
  </head>
  <body> 
  <form action="index.php" method="POST">
  <div id="inputs">
    <input type="text" placeholder="Name" name="name">
    <input type="password" placeholder="Password" name="pass">
    <input type="submit" name='Submit'>
  </div>
  

  <table id="week">
  	<tr>
  	<?php
      $Wochen = getDate(strtotime('last Monday'));
  		echo "<td class='w' id='w1'>".$Wochen['mday'].".".$Wochen['mon']." - ";
      $Wochen = getDate(strtotime('next Sunday'));
      echo $Wochen['mday'].".".$Wochen['mon']."</td>";

      $Wochen = getDate(strtotime('next Monday'));
      echo "<td class='w' id='w2'>".$Wochen['mday'].".".$Wochen['mon']." - ";
      $Wochen = getDate(strtotime('next Sunday + 1 week'));
      echo $Wochen['mday'].".".$Wochen['mon']."</td>";

      $Wochen = getDate(strtotime('next Monday + 1 week'));
      echo "<td class='w' id='w3'>".$Wochen['mday'].".".$Wochen['mon']." - ";
      $Wochen = getDate(strtotime('next Sunday + 2 week'));
      echo $Wochen['mday'].".".$Wochen['mon']."</td>";
  	?>
  	</tr>
  </table>

  <div id="result"></div>
  </form>
  </body>
</html>
<?php
mysqli_close($conn);
?>