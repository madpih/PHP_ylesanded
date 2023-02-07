<?php
$servername = "localhost";
$username = "root";
$password = "";
$debug_mode = true;

// Create connection
$conn = mysqli_connect($servername, $username, $password);


// Check connection
if (!$conn) {
  die("Connection failed: " . mysqli_connect_error());
}
echo "Connected successfully\n";


// Create database

$sql = "CREATE DATABASE IF NOT EXISTS demoDb";
if ($conn->query($sql) === TRUE) {
  echo "Database created successfully\n";
} else {
  echo "Error creating database: " . $conn->error;
}

// Create connection with DB
$dbname = "demoDb";
$conn = mysqli_connect($servername, $username, $password, $dbname);
if (!$conn) {
  die("Connection failed: " . mysqli_connect_error());
}

  // drop table
if ($debug_mode) 
{
  $sql = "DROP TABLE IF EXISTS insurance;";
  
  if (mysqli_query($conn, $sql)) {
    echo "Table insurance deleted successfully\n";
    } else {
   echo "Error creating table: " . mysqli_error($conn);
 }

 $sql = "DROP TABLE IF EXISTS patients;";
 if (mysqli_query($conn, $sql)) {
    echo "Table patients deleted successfully\n";
    } else {
   echo "Error creating table: " . mysqli_error($conn);
 }
}

// sql to create tables
$sql = "CREATE TABLE IF NOT EXISTS patients(
    _id INT(10) UNSIGNED NOT NULL AUTO_INCREMENT,
    pn VARCHAR(11) DEFAULT NULL,
    `first` VARCHAR(15) DEFAULT NULL,
    `last` VARCHAR(25) DEFAULT NULL,
    dob DATE DEFAULT NULL,
    PRIMARY KEY (_id)
    )";
  
    
    if (mysqli_query($conn, $sql)) {
      echo "Table patients created successfully\n";
    } else {
      echo "Error creating table: " . mysqli_error($conn);
    }
    

$sql = "CREATE TABLE IF NOT EXISTS insurance(
    _id INT(10) UNSIGNED NOT NULL AUTO_INCREMENT,
    patient_id INT(10) UNSIGNED NOT NULL ,
    iname VARCHAR(40) DEFAULT NULL,
    from_date DATE DEFAULT NULL,
    to_date DATE DEFAULT NULL,
    PRIMARY KEY (_id),
    FOREIGN KEY (patient_id) REFERENCES patients(_id)
    )";

    if (mysqli_query($conn, $sql)) {
     echo "Table insurance created successfully\n";
     } else {
    echo "Error creating table: " . mysqli_error($conn);
  }


  // insert values into patients and insurance

$sql = "INSERT INTO patients (pn, `first`, `last`, dob)
  VALUES ('00000000001','John','Smith','1980-11-11');";
  
$sql .= "INSERT INTO patients (pn, `first`, `last`, dob)
  VALUES ('00000000002','Jade','Smith','1980-10-11');";

$sql .= "INSERT INTO patients (pn, `first`, `last`, dob)
  VALUES ('00000000003','Woody','Hoody','1979-12-11');";

$sql .= "INSERT INTO patients (pn, `first`, `last`, dob)
  VALUES ('00000000004','Grace','Belly','1999-11-11');";

$sql .= "INSERT INTO patients (pn,`first`, `last`, dob)
VALUES ('00000000005','Bob','Robb','1929-11-11');";

while(mysqli_next_result($conn)){;}

if (mysqli_multi_query($conn, $sql)) {
  echo "New patient records created successfully\n";
} else {
  echo "Error: " . $sql . "<br>" . mysqli_error($conn);
}



$sql = "INSERT INTO insurance (patient_id, iname, from_date, to_date)
          VALUES ((SELECT _id FROM patients WHERE pn ='00000000001' limit 1),'Medicare','2020-01-30','2021-01-01');";

$sql .= "INSERT INTO insurance (patient_id, iname, from_date, to_date)
    VALUES ((SELECT _id FROM patients WHERE pn ='00000000002' limit 1),'Medicare','2005-01-01',NULL);";

$sql .= "INSERT INTO insurance (patient_id, iname, from_date, to_date)
    VALUES ((SELECT _id FROM patients WHERE pn ='00000000003' limit 1),'Blue Cross','2005-01-01','2005-01-15');";

$sql .= "INSERT INTO insurance (patient_id, iname, from_date, to_date)
    VALUES ((SELECT _id FROM patients WHERE pn ='00000000004' limit 1),'Medicaid','2005-01-01','2023-06-01');";

$sql .= "INSERT INTO insurance (patient_id, iname, from_date, to_date)
    VALUES ((SELECT _id FROM patients WHERE pn ='00000000001' limit 1),'Blue Shield','2022-01-01','2024-01-01')";


while(mysqli_next_result($conn)){;}

if (mysqli_multi_query($conn, $sql)) {
     echo "New insurance records created successfully\n";
 } else {
     echo "Error: " . $sql . "<br>" . mysqli_error($conn);
   }

mysqli_close($conn);

?>