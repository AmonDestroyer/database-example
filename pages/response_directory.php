<?php

include('../config/credentials.ini');

$conn = mysqli_connect($server, $user, $pass, $dbname, $port)
or die('Error connecting to MySQL server.');

$type = $_POST['personType'];
if ($type == "Employee") {
  $table = "employee";
} else {
  $table = "tenant";
}
?>

<html>
<head>
  <title>
  <?php
    print "JAMSS House-$type Directory";
  ?>
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
    <?php
      print "$type Directory";
    ?>
    </h1>
    <div align="right">
    <form action='directory.html' method='POST'>
      <input type='submit' value=&larr;>
    </form>
    </div>
  </div>
  
  
  <hr>
  
  
<?php
  
// this is a small attempt to avoid SQL injection
// better to use prepared statements

$query = "SELECT first_name, last_name, phone, street_num, apt, street, city, state_code ";
if ($table == "employee") {
  $query = $query.", job_title ";
}
$query = $query."FROM $table ";
$query = $query."JOIN person p USING(ssn) ";
$query = $query."JOIN address a on p.address=a.id ";
$query = $query."ORDER BY last_name, first_name;";
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
<?php
if ($table == "employee") {
  print "<th>Job Title</th>";
}
?>
<th>Phone Number</th>
<th>Address</th>
</tr>
<?php
$result = mysqli_query($conn, $query)
or die(mysqli_error($conn));

while($row = mysqli_fetch_array($result, MYSQLI_BOTH))
  {
    print "<tr>";
    print "<td>$row[first_name] $row[last_name]</td>";
    if ($table == "employee") {
      print "<td>$row[job_title]</td>";
    }
    print "<td>$row[phone]</td>";

    print "<td>";
    print "$row[street_num] $row[street]<br>";
    if ($row['apt'] != "") {
      print "apt $row[apt]<br>";
    }
    print "$row[city], $row[state_code]";
    print "</td>";
    print "</tr>";
  }

mysqli_free_result($result);

mysqli_close($conn);

?>
</table>

</body>
</html>
	  