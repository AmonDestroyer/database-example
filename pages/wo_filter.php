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
print "<p><label for='type'>Work Order Type:</label><br>";
print "<select name='type' id='type' onchange='this.form.submit()'>";
print "<option value=''>All</option>";
while ($row = mysqli_fetch_array($result, MYSQLI_BOTH)) {
  $selected = ($_POST['type'] == $row['id']) ? 'selected' : '';
  print "<option value='$row[id]' $selected>$row[name]</option>";
}
print "</select></p>";
?>
  <p>
  <label for='text'>Filter Work Order Summary/Description: </label><br>
  <input type='text' name='text' id='text' onchange='this.form.submit()' 
  <?php
  $text = mysqli_real_escape_string($conn, $_POST['text']);
  print "value='$text'";
  ?>
  size= 50 maxlength=50>
</p>
</form>
<hr>

<?php
$query = "SELECT wo.summary, wo.description, wo.sub_date, wo.comp_date, l.name FROM work_order wo ";
$query = $query."JOIN location l on l.id=wo.location ";
$query = $query."WHERE ";
$query = $query."(wo.summary LIKE '%$text%' OR wo.description LIKE '%$text%') ";
if ($_POST['type'] != '') {
  $type = mysqli_real_escape_string($conn, $_POST['type']);
  $query = $query."and wo.type = $type ";
}
$query = $query."ORDER BY l.name, wo.comp_date";
$query = $query.";";
$result = mysqli_query($conn, $query) or die(mysqli_error($conn));

print "<p>Query:</p>";
print $query;
print "<hr>";
print "<table>";
print "<tr>";
print "<th>Summary</th>";
print "<th>Description</th>";
print "<th>Location</th>";
print "<th>Submission Date</th>";
print "<th>Complettion Date</th>";
print "</tr>";
while($row = mysqli_fetch_array($result, MYSQLI_BOTH)) {
  print "<tr>";
  print "<td>$row[summary]</td>";
  print "<td>$row[description]</td>";
  print "<td>$row[name]</td>";
  print "<td>$row[sub_date]</td>";
  print "<td>$row[comp_date]</td>";
  print "</tr>";
}
  

mysqli_free_result($result);
mysqli_close($conn);
?>
</table>

</body>
</html>
	  