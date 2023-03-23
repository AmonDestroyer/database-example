<?php

include('../config/credentials.ini');

$conn = mysqli_connect($server, $user, $pass, $dbname, $port)
or die('Error connecting to MySQL server.');
?>

<html>
<head>
  <title>
  JAMSS House-Available Rentals
  </title>
  <link rel="stylesheet" type="text/css" href="../resources/css/styles.css">
  <script>
      function returnToHomePage() {
        window.location.href = "../index.html";
      }
    </script>
  </head>
  
  <body bgcolor="white">

  <div id="topbar">
    <img src="../resources/image/logo.png" alt="JAMSS House logo" style="float:left;width:100px;height:100px;" onclick="returnToHomePage()">
    <h1 id="pageTitle" style="float:left;margin-left:10px;">
    Available Rentals
    </h1>
  </div>

  <?php
  $conn = mysqli_connect($server, $user, $pass, $dbname, $port) or die('Error connecting to MySQL server.');
  $query = "SELECT DISTINCT l.name, l.description, a.street_num, a.street, a.apt, a.city, a.state_code FROM location l ";
  $query = $query."JOIN address a USING(id) ";
  $query = $query."LEFT JOIN tenant t on t.renting=l.id ";
  $query = $query."WHERE t.ssn IS NULL ";
  $query = $query."ORDER BY a.state_code, a.city, l.name;";
  ?>
  
  <p>
  Query:
  <p>
  <?php
  print $query;
  ?>
  
  <hr>


  <table>
  <tr>
  <th>Name</th>
  <th>Address</th>
  <th>Description</th>
  </tr>
  <?php
  $result = mysqli_query($conn, $query) or die(mysqli_error($conn));
  while($row = mysqli_fetch_array($result, MYSQLI_BOTH))
  {
    print "<tr>";
    print "<td>$row[name]</td>";

    print "<td>";
    print "$row[street_num] $row[street]<br>";
    if ($row['apt'] != "") {
      print "apt $row[apt]<br>";
    }
    print "$row[city], $row[state_code]";
    print "</td>";
    
    print "<td>$row[description]</td>";
    print "</tr>";
  }

  mysqli_free_result($result);

  mysqli_close($conn);
  ?>
</body>
</html>
	  