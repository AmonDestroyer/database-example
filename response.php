<?php

include('connectionData.txt');

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
  
$manu_name = $_POST['manu_name'];

$manu_name = mysqli_real_escape_string($conn, $manu_name);
// this is a small attempt to avoid SQL injection
// better to use prepared statements

$query = "SELECT fname, lname, description FROM items ";
$query = $query."JOIN orders USING(order_num) ";
$query = $query."JOIN customer USING(customer_num) ";
$query = $query."JOIN manufact using(manu_code) ";
$query = $query."JOIN stock using(stock_num, manu_code) ";
$query = $query."WHERE manu_name = ";
$query = $query."'".$manu_name."' ORDER BY lname, fname;";
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
    print "$row[fname]  $row[lname]  $row[description]";
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
	  