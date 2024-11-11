<?php
require('top.inc.php'); // Include your connection file

// Validate that the 'id' parameter exists and is a valid numeric value
if (isset($_GET['id']) && is_numeric($_GET['id'])) {
    $id = get_safe_value($con, $_GET['id']); // Safely retrieve and sanitize the id parameter

    // Prepare the query to fetch file details from the database
    $query = "SELECT Berkas, Ekstensi, Size, name_doc FROM dokumen_iso WHERE id_doc = ?";
    $stmt = mysqli_prepare($con, $query); // Use prepared statements to avoid SQL injection
    mysqli_stmt_bind_param($stmt, 'i', $id); // Bind the id parameter
    mysqli_stmt_execute($stmt);
    $result = mysqli_stmt_get_result($stmt); // Get the result

    if ($result && mysqli_num_rows($result) > 0) {
        $file = mysqli_fetch_assoc($result);

        $fileContent = $file['Berkas']; // Binary content of the file
        $fileName = $file['name_doc'] . '.' . $file['Ekstensi']; // File name with extension
        $fileSize = $file['Size']; // File size
        $fileType = $file['Ekstensi']; // File extension

        // Set appropriate headers for file download
        header("Content-Description: File Transfer");
        header("Content-Type: application/octet-stream");
        header("Content-Disposition: attachment; filename=\"$fileName\"");
        header("Content-Length: " . $fileSize);

        // Clear output buffer and send file content
        ob_clean(); // Clean (erase) the output buffer
        flush(); // Flush the system output buffer
        echo $fileContent; // Output the file content to initiate download
        exit; // Terminate the script to prevent further output
    } else {
        echo "File not found."; // Error message if file is not found
    }

    mysqli_stmt_close($stmt); // Close the prepared statement
} else {
    echo "Invalid request."; // Error message if the 'id' is not valid or missing
}
?>
