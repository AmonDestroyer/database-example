<?php

include('../config/credentials.ini');

$conn = mysqli_connect($server, $user, $pass, $dbname, $port)
or die('Error connecting to MySQL server.');

$type = $_POST['personType'];
?>

<html>
<head>
  <title>
  <?php
    print "$type Directory";
  ?>
  </title>
  <link rel="stylesheet" type="text/css" href="../resources/css/styles.css">
  </head>
  
  <body bgcolor="white">
  
  
  <hr>
  
  
<?php
  
// this is a small attempt to avoid SQL injection
// better to use prepared statements

$query = "SELECT first_name, last_name, job_title, phone FROM employee ";
$query = $query."JOIN person USING(ssn) ";
$query = $query."ORDER BY last_name, first_name;";
?>

<p>
The query:
<p>
<?php
print $query;
?>

<hr>

<table>
<tr>
<th>Name</th>
<th>Title</th>
<th>Phone Number</th>
</tr>
<?php
$result = mysqli_query($conn, $query)
or die(mysqli_error($conn));

while($row = mysqli_fetch_array($result, MYSQLI_BOTH))
  {
    print "<tr>";
    print "<td>$row[first_name] $row[last_name]</td>";
    print "<td>$row[job_title]</td>";
    print "<td>$row[phone]</td>";
    print "</tr>";
  }

mysqli_free_result($result);

mysqli_close($conn);

?>
</table>
 
<form action="../">
  <input type="submit" value="Home">
</form>

<form action="people.html">
  <input type="submit" value="Back">
</form>

</body>
</html>
	  