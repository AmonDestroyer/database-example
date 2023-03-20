<?php

include('credentials.ini');

$conn = mysqli_connect($server, $user, $pass, $dbname, $port)
or die('Error connecting to MySQL server.');

?>

<html>
<head>
  <title>Assignment4</title>
  </head>
  
  <body bgcolor="white">
  
  
  <hr>
  
  
<?php
  
// this is a small attempt to avoid SQL injection
// better to use prepared statements

$query = "SELECT first_name, last_name, job_title, phone FROM employee ";
$query = $query."JOIN person USING(ssn) ";
$query = $query."ORDER BY lname, fname;";
?>

<p>
The query:
<p>
<?php
print $query;
?>

<hr>
<p>
Result of query:
<p>

<?php
$result = mysqli_query($conn, $query)
or die(mysqli_error($conn));

print "<pre>";
while($row = mysqli_fetch_array($result, MYSQLI_BOTH))
  {
    print "\n";
    print "$row[first_name]  $row[last_name]  $row[job_title] $row[phone]";
  }
print "</pre>";

mysqli_free_result($result);

mysqli_close($conn);

?>

<p>
<hr>
<form action="findManufacturerCustomers.html" method="POST">
<input type="submit" value="return">
 
</body>
</html>
	  