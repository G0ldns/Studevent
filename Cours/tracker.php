 <?php
// Get the user's IP address
$ip_address = $_SERVER['REMOTE_ADDR'];

// Get the page URL
$page_url = $_SERVER['REQUEST_URI'];

// Get the current time
$visit_time = date('Y-m-d H:i:s');




    try{
        $connection = new PDO("mysql:host=".DB_HOST.";dbname=".DB_DATABASE.";port=".DB_PORT,DB_USER, DB_PWD);
    }catch(Exception $e){
        die("Erreur SQL ".$e->getMessage());
    }
    return $connection;


// Check for errors
if ($connection->connect_error) {
    die("Connection failed: " . $connection->connect_error);
}

// Insert the tracking data into the database

$sql = "INSERT INTO tracking (ip_address, page_url, visit_time)
VALUES ('$ip_address', '$page_url', '$visit_time')";

if ($connection->query($sql) === TRUE) {
    // Tracking data inserted successfully
} else {
    echo "Error: " . $sql . "<br>" . $connection->error;
}

// Close the database connection
$pdo = null;
?>
