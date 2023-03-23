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
    print "JAMSS House-New WO";
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
    Work Order Submission
    </h1>
    <div align="right">
    <form action='wo.html' method='POST'>
      <input type='submit' value=&larr;>
    </form>
    </div>
  </div>


  <form action='' method='POST'>
<p>
<label for='summary'>Summary: </label><br>
<input type='text' name='summary' required id='summary' size= 40 maxlength=40 minlength=5
<?php
print "value = '$_POST[summary]'"
?>
>
</p>

<p>
<label for='description'>Description: </label><br>
<input type='text' name='description' id='description' size= 100 maxlength=100
<?php
print "value = '$_POST[description]'"
?>
>
</p>

<p>
    <label for='date'>Date: </label>
    <input type='date' name='date' id='date'  value=
    <?php
    if (isset($_POST['date'])) {
      print $_POST['date'];
    } else {
      $date = date("Y-m-d");
      print $date;
    }
    
    ?>
    >
</p>
<p>
  <label for='type'>Type: </label>
<?php
print "<select name='type' id='type'>";
print "<option value=''>--SELECT--</option>";
while ($row = mysqli_fetch_array($result, MYSQLI_BOTH)) {
  $selected = ($_POST['type'] == $row['id']) ? 'selected' : '';
  print "<option value='$row[id]' $selected>$row[name]</option>";
}
print "</select></p>";
?>

<p>
  <label for='location'>Address: </label>
  <select name='location' id='location' onchange='this.form.submit()'>
  <option value=''>--SELECT--</option>
    <?php
      $query = "SELECT distinct id, name, street_num, apt, street, city, state_code FROM location l JOIN address a using(id) JOIN tenant t on t.renting=l.id ORDER BY name;";
      mysqli_free_result($result);
      $result = mysqli_query($conn, $query) or die(mysqli_error($conn));
      while ($row = mysqli_fetch_array($result, MYSQLI_BOTH)) {
        $selected = ($_POST['location'] == $row['id']) ? 'selected' : '';
        print "<option value='$row[id]' $selected>$row[name] (";
        print "$row[street_num] $row[street], ";
        if ($row['apt'] != "") {
          print "Apt. $row[apt], ";
        }
        print "$row[city], $row[state_code]";
        print ")</option>";
      }
    ?>
  </select>
</p>

<p>
  <label for='tenant'>Tenant: </label>
  <select name='tenant' id='tenant' required>
  <option value=''>--SELECT--</option>
  <?php
    if (isset($_POST['location'])) {
      $query = "SELECT t.ssn, p.first_name, p.last_name from person p join tenant t using(ssn) join location l on t.renting=l.id where l.id=$_POST[location] order by last_name, first_name;";
      mysqli_free_result($result);
      $result = mysqli_query($conn, $query) or die(mysqli_error($conn));
      while ($row = mysqli_fetch_array($result, MYSQLI_BOTH)) {
        print "<option value='$row[ssn]'>$row[last_name], $row[first_name]</option>";
      }
    }
  ?>
  </select>
</p>
<hr>

<input type="submit" value="Submit" name=" btnsubmit"><br><br>
<?php
if(isset($_POST['btnsubmit'])) {
  mysqli_free_result($result);
  $query = "select max(id)+1 AS mx from work_order; ";
  $result = mysqli_query($conn, $query) or die(mysqli_error($conn));
  while ($row = mysqli_fetch_array($result, MYSQLI_BOTH)) {
    $next_id = $row['mx'];
  }

  $date = mysqli_real_escape_string($conn, $_POST['date']);
  $summary = mysqli_real_escape_string($conn, $_POST['summary']);
  $description = mysqli_real_escape_string($conn, $_POST['description']);
  $location = mysqli_real_escape_string($conn, $_POST['location']);
  $type = mysqli_real_escape_string($conn, $_POST['type']);
  $tenant = mysqli_real_escape_string($conn, $_POST['tenant']);
  $query = "insert into work_order (id, sub_date, summary, description, location, type, tenant) ";
  $query = $query."values ($next_id, '$date' , '$summary', '$description', $location, $type, $tenant);";

  mysqli_query($conn, $query) or die(mysqli_error($conn));

  mysqli_free_result($result);
  mysqli_close($conn);
} else {
  mysqli_free_result($result);
  mysqli_close($conn);
  exit();
}
?>
</form>

<script type="text/javascript">
window.location.href="wo_success.php";
</script>

</body>
</html>
	  