<?php
require_once('Interface.php');
require_once('myconn.php');
require_once('Patient.php');
require_once('Insurance.php');


$sql = "SELECT pn FROM patients";

$result = mysqli_query($conn, $sql);
if (!$conn) {
  echo("Connection failed: " . mysqli_connect_error());
}
if(!$result) {
echo("Error description: " . $mysqli -> error);
}

if (mysqli_num_rows($result) > 0) {
  while($row = mysqli_fetch_assoc($result)) {
      $patient = new Patient ($row["pn"]);
      echo ($patient->insurance_records(date("m-d-y")));
  }
} else {
      echo "No patient records";
}

mysqli_close($conn);

?>