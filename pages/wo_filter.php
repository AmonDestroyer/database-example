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
print "<select name='type' id='type' onchange='this.form.submit()'>";
print "<option value=''>--Select--</option>";
while ($row = mysqli_fetch_array($result, MYSQLI_BOTH)) {
  $selected = ($_POST['type'] == $row['id']) ? 'selected' : '';
  print "<option value='$row[id]' $selected>$row[name]</option>";
}
print "</select>";
print "</form>";
?>

<hr>

<?php
if (!is_null($_POST['type'])) {
$query = "SELECT id, summary FROM work_order ";
$query = $query."WHERE type=$_POST[type];";
$result = mysqli_query($conn, $query) or die(mysqli_error($conn));


print "<table>";
print "<tr>";
print "<th>ID</th>";
print "<th>Summary</th>";
print "</tr>";
while($row = mysqli_fetch_array($result, MYSQL_BOTH)) {
  print "<tr>";
  print "<td>$row[id]</td>";
  print "<td>$row[summary]</td>";
  print "</tr>";
}

mysqli_free_result($result);
mysqli_close($conn);
}
?>
</table>

<p>
  Table Ouput Here
</p>

</body>
</html>
	  