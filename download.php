<?php
$conn = mysqli_connect("localhost", "root", "", "db_dociso");

if (!$conn) {
    die("Connection failed: " . mysqli_connect_error());
}

// Sanitize the 'id' to prevent SQL injection
$id = intval($_GET["id"]);

// Prepare SQL query with backticks
$sql = "SELECT * FROM `tbl_document` WHERE `id` = ?";

// Use prepared statements to prevent SQL injection
$stmt = mysqli_prepare($conn, $sql);

// Bind the parameter and execute the query
mysqli_stmt_bind_param($stmt, "i", $id);
mysqli_stmt_execute($stmt);

// Get the result
$result = mysqli_stmt_get_result($stmt);

if (mysqli_num_rows($result) == 0) {
    die("File does not exist");
}

// Fetch the row
$row = mysqli_fetch_object($result);

// Set the appropriate content type for the file
header("Content-type: " . $row->type);

// Output the image data
echo $row->berkas;

// Close the prepared statement and database connection
mysqli_stmt_close($stmt);
mysqli_close($conn);
?>
