<?php

include('../config/credentials.ini');

$conn = mysqli_connect($server, $user, $pass, $dbname, $port)
or die('Error connecting to MySQL server.');
?>

<html>
<head>
  <title>
  JAMSS House-Rental Search
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
    Rental Search
    </h1>
    <div align="right">
    <form action='rentals.html' method='POST'>
      <input type='submit' value=&larr;>
    </form>
    </div>
  </div>

  <?php
  $conn = mysqli_connect($server, $user, $pass, $dbname, $port) or die('Error connecting to MySQL server.');
  
  ?>
  
  <form action='' method='POST'>
    <p><label for='state'>State: </label>
    <select name='state' id='state' onchange='this.form.submit()'>
    <option value=''>All</option>
    <?php
    $query = "SELECT distinct s.code, s.name FROM state s join address a on s.code=a.state_code join location l using (id) order by s.name;";
    $result = mysqli_query($conn, $query) or die(mysqli_error($conn));
    while ($row = mysqli_fetch_array($result, MYSQLI_BOTH)) {
      $selected = ($_POST['state'] == $row['code']) ? 'selected' : '';
      print "<option value='$row[code]' $selected>$row[name]</option>";
    }
    ?>
    </select>
    </p>
  </form>
  <hr>

  <p>
  Query:
  <p>
  <?php
  $query = "SELECT DISTINCT l.id, l.name, l.description, a.street_num, a.street, a.apt, a.city, a.state_code FROM location l ";
  $query = $query."JOIN address a USING(id) ";
  $query = $query."LEFT JOIN tenant t on t.renting=l.id ";
  if ($_POST['state'] != '') {
    $query = $query."WHERE  a.state_code = '$_POST[state]' ";
  }
  $query = $query."ORDER BY a.state_code, a.city, l.name;";

  print $query;
  ?>
  
  <hr>


  <table>
  <tr>
  <th>Name</th>
  <th>Address</th>
  <th>Description</th>
  <th>Tenants</th>
  </tr>
  <?php
  mysqli_free_result($result);
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

    print "<td id='nowrap'>";
    $subquery = "SELECT first_name, last_name, phone FROM person JOIN tenant using(ssn) WHERE renting=$row[id] ORDER BY last_name, first_name, phone;";
    $subresult = mysqli_query($conn, $subquery) or die(mysqli_error($conn));
    while($tenant = mysqli_fetch_array($subresult, MYSQLI_BOTH)) {
      print "<p>$tenant[last_name], $tenant[first_name] ($tenant[phone])";
    }
    print "</td>";

    print "</tr>";
  }

  mysqli_free_result($result);

  mysqli_close($conn);
  ?>
</body>
</html>
	  