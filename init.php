<?php

$con = mysqli_connect("localhost", "root");
$sql = "CREATE DATABASE mydb";
$result = mysqli_query($con, $sql);
if ($result) {
  echo "Database mydb created successfully";
} else {
  echo "Error creating database: " .
mysqli_error($con);
};

mysqli_select_db($con, "mydb");

$sql = "CREATE TABLE foodList
(
PID INT NOT NULL AUTO_INCREMENT,
PRIMARY KEY(PID),
Agency VARCHAR(50),
Address1 VARCHAR(50),
Address2 VARCHAR(50),
POBox VARCHAR(50),
City VARCHAR(20),
State VARCHAR(2),
ZipCode VARCHAR(5),
Phone VARCHAR(12),
Link VARCHAR(100)
);";

$result2 = mysqli_query($con, $sql);
if($result2) {
	echo "YAY";
} else {
	echo "BOO" . mysqli_error($con);
}

BULK
INSERT foodList
FROM '/Users/kianahui/Desktop'
WITH
(
FIELDTERMINATOR = ',',
ROWTERMINATOR = '\n'
)
GO
--Check the content of the table.
SELECT *
FROM CSVTest
GO
--Drop the table to clean up database.
DROP TABLE CSVTest
GO

mysqli_close($con);
?>