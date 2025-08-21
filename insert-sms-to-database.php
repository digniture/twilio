<?php
// --- Database connection (MySQLi) ---
$servername = "localhost";
$username   = "your_db_user";
$password   = "your_db_pass";
$dbname     = "your_db_name";

$conn = mysqli_connect($servername, $username, $password, $dbname);

if (!$conn) {
    http_response_code(500);
    die("Database connection failed: " . mysqli_connect_error());
}

// --- Get Twilio webhook data (POST params) ---
$from     = isset($_POST['From']) ? mysqli_real_escape_string($conn, $_POST['From']) : '';
$to       = isset($_POST['To']) ? mysqli_real_escape_string($conn, $_POST['To']) : '';
$body     = isset($_POST['Body']) ? mysqli_real_escape_string($conn, $_POST['Body']) : '';
$sid      = isset($_POST['MessageSid']) ? mysqli_real_escape_string($conn, $_POST['MessageSid']) : '';
$date     = date("Y-m-d H:i:s");

// --- Insert into database ---
$sql = "INSERT INTO messages (sid, sender, receiver, body, received_at) 
        VALUES ('$sid', '$from', '$to', '$body', '$date')";

if (mysqli_query($conn, $sql)) {
    // Twilio requires an XML or empty response
    header("Content-Type: text/xml");
    echo "<Response></Response>";
} else {
    http_response_code(500);
    echo "Error: " . mysqli_error($conn);
}

mysqli_close($conn);
?>
