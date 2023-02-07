<?php
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "demoDb";


// Create connection
$conn = mysqli_connect($servername, $username, $password, $dbname);

// Check connection
if (!$conn) {
  die("Connection failed: " . mysqli_connect_error());
}


//task a - display cols for each patient to console
$sql = "SELECT pat.pn, pat.last, pat.first, insu.iname, DATE_FORMAT(insu.from_date, '%m-%d-%y') AS from_date_format, DATE_FORMAT(insu.to_date, '%m-%d-%y') AS to_date_format
        FROM patients AS pat
        INNER JOIN insurance AS insu ON pat._id = insu.patient_id 
        ORDER BY insu.from_date ASC, pat.last ASC";

$result = mysqli_query($conn, $sql);

if (mysqli_num_rows($result) > 0) {
  while($row = mysqli_fetch_assoc($result)) {
   echo $row["pn"].", ".$row["last"].", ".$row["first"].", ".$row["iname"].", ".$row["from_date_format"].", ".$row["to_date_format"]."\n";
  }
} else {
  echo "0 results";
}

//task b - statistics
$sql = "SELECT CONCAT(pat.last,pat.first) AS namefull
        FROM patients AS pat
        ";

$result = mysqli_query($conn, $sql);
$letters='';

if (mysqli_num_rows($result) > 0) {
  while($row = mysqli_fetch_assoc($result)) {
   $letters .= $row["namefull"];
  }
} else {
  echo "0 results";
}

$letters = strtoupper($letters);
$lettercount = strlen($letters);

//Result output
echo "\n";
foreach (count_chars($letters,1) as $letterchar => $val) {   
    echo chr($letterchar)."    ".$val."    ".round($val*100/$lettercount,2)." %\n";
}

mysqli_close($conn);
?>
