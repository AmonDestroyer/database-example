<?php

include('../config/credentials.ini');

$conn = mysqli_connect($server, $user, $pass, $dbname, $port)
or die('Error connecting to MySQL server.');

$query = "SELECT id, name FROM type;";
$result = mysqli_query($conn, $query) or die(mysqli_error($conn));
?>


<html>
<head>
  <title>
  <?php
    print "JAMSS House-WO Search";
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
    Work Order Search
    </h1>
  </div>
  <hr>

<?php
print "<form action='' method='POST'>";
print "<label for='type'>Work Order Type:</label>";
print "<select name='type' id='type'>";
print "<option value=''>--Select--</option>";
while ($row = mysqli_fetch_array($result, MYSQLI_BOTH)) {
  print "<option value='$row[id]'>$row[name]</option>";
}
print "</select>";
print "</form>";
?>

<hr>

<p>
  Table Ouput Here
</p>

</body>
</html>
	  