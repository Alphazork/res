<?php
  session_start();
  $_SESSION["user"] = "vor.nachname";
?>

<html lang="en">
  <head>
    <title>Wenzgasse Reservierungen</title>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <script type="text/javascript" src="jquery-2.1.4.min.js"></script>
    <script type="text/javascript" src="main.js"></script>
    <script type="text/javascript" src="date.js"></script>
    <link rel="stylesheet" href="main.css">
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.5/js/bootstrap.min.js"></script>
	<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.5/css/bootstrap.min.css">
	<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.5/css/bootstrap-theme.min.css">
  </head>

  <body>

    <div class="container">
    <div id="test"></div>
      <nav class="navbar navbar-default">
        <div class="container-fluid">
          <div class="navbar-header">
            <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#navbar" aria-expanded="false" aria-controls="navbar">
            </button>
            <a class="navbar-brand" id="reservierungen" href="#">Reservierungen
              <p id="nameDisplay"><?php echo $_SESSION["user"]; ?></p>
            </a>
          </div>
          <div id="navbar" class="navbar-collapse collapse">
            <ul class="nav navbar-nav">
              <li class="dropdown active" id="dropdown1">
                <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false">Laptops<span class="caret"></span></a>
                <ul class="dropdown-menu">
                  <li class="cBtn active"><a href="#">Dell Laptop</a></li>
                  <li class="cBtn"       ><a href="#">HP Laptop</a></li>
                </ul>
              </li>
              <li class="dropdown" id="dropdown2">
                <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false">Medienwägen<span class="caret"></span></a>
                <ul class="dropdown-menu">
                  <li class="cBtn active"><a href="#">Beamer</a></li>
                  <li class="cBtn"       ><a href="#">Fernseher</a></li>
                </ul>
              </li>
              <li class="cBtn"><a>Beamer     </a></li>
              <li class="cBtn"><a>DVD        </a></li>
              <li class="cBtn"><a>VHS        </a></li>
            </ul>

            <ul class="nav navbar-nav navbar-right">
              <li id="week1" class="cWeek active"><a></a></li>
              <li id="week2" class="cWeek"><a></a></li>
              <li id="week3" class="cWeek"><a></a></li>
            </ul>
          </div>
        </div>
      </nav>

      <div class="jumbotron">
      	<div id="tableContainer">
	        <table class="table table-striped ">
	        	<tr>
	        		<th>Montag</th>
	        		<th>Dienstag</th>
	        		<th>Mittwoch</th>
	        		<th>Donnerstag</th>
	        		<th>Freitag</th>
	        	</tr>
	        </table>
        </div>
      </div>
    </div> <!-- /container -->
  </body>
</html>