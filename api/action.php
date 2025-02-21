<?php

header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Methods: GET, POST, PUT, DELETE, OPTIONS");
header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");

// Handle preflight OPTIONS request
if ($_SERVER['REQUEST_METHOD'] == 'OPTIONS') {
    http_response_code(200);
    exit();
}

/* Database credentials. Assuming you are running MySQL
server with default setting (user 'root' with no password) */
define('DB_SERVER', 'localhost');
define('DB_USERNAME', 'root');
define('DB_PASSWORD', value: '');
define('DB_NAME', 'list');

/* Attempt to connect to MySQL database */
try {
    $pdo = new PDO("mysql:host=" . DB_SERVER . ";dbname=" . DB_NAME, DB_USERNAME, DB_PASSWORD);
    // Set the PDO error mode to exception
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch(PDOException $e) {
    error_log('Database connection error: ' . $e->getMessage());
    die(json_encode(['error' => 'Database connection error']));
}

$method = $_SERVER['REQUEST_METHOD']; //return GET, POST, PUT, DELETE

if($method === 'GET')
{
    if(isset($_GET['id']))
    {
        //fetch single user
        $query = "SELECT * FROM sample_users WHERE id = '".$_GET["id"]."'";

        $result = $pdo->query($query, PDO::FETCH_ASSOC);

        $data = array();

        foreach($result as $row)
        {
            $data['first_name'] = $row['first_name'];
            $data['last_name'] = $row['last_name'];
            $data['email'] = $row['email'];
            $data['id'] = $row['id'];
        }

        echo json_encode($data);
    }
    else 
    {
        //fetch all users
        $query = "SELECT * FROM sample_users ORDER BY id DESC";

        $result = $pdo->query($query, PDO::FETCH_ASSOC);

        $data = array();

        foreach($result as $row)
        {
            $data[] = $row;
        }

        echo json_encode($data);
    }
}

if ($method === 'POST') {
    //Insert User Data
    $form_data = json_decode(file_get_contents('php://input'));

    if ($form_data) {
        $data = array(
            ':first_name' => $form_data->first_name,
            ':last_name' => $form_data->last_name,
            ':email' => $form_data->email
        );

        $query = "
        INSERT INTO sample_users (first_name, last_name, email) VALUES (:first_name, :last_name, :email);
        ";

        $statement = $pdo->prepare($query);

        if ($statement->execute($data)) {
            echo json_encode(["success" => "User added successfully"]);
        } else {
            error_log('Failed to add user: ' . implode(', ', $statement->errorInfo()));
            echo json_encode(["error" => "Failed to add user"]);
        }
    } else {
        echo json_encode(["error" => "Invalid input"]);
    }
}

if($method === 'PUT')
{
    //Update User Data
    $form_data = json_decode(file_get_contents('php://input'));

    $data = array(
        ':first_name' => $form_data->first_name,
        ':last_name' => $form_data->last_name,
        ':email' => $form_data->email,
        ':id' => $form_data->id
    );

    $query = "
    UPDATE sample_users 
    SET first_name = :first_name, 
    last_name = :last_name, 
    email = :email 
    WHERE id = :id
    ";

    $statement = $pdo->prepare($query);

    if ($statement->execute($data)) {
        echo json_encode(["success" => "User updated successfully"]);
    } else {
        error_log('Failed to update user: ' . implode(', ', $statement->errorInfo()));
        echo json_encode(["error" => "Failed to update user"]);
    }
}

if($method === 'DELETE')
{
    //Delete User Data
    $data = array(
        ':id' => $_GET['id']
    );

    $query = "DELETE FROM sample_users WHERE id = :id";

    $statement = $pdo->prepare($query);

    if ($statement->execute($data)) {
        echo json_encode(["success" => "User deleted successfully"]);
    } else {
        error_log('Failed to delete user: ' . implode(', ', $statement->errorInfo()));
        echo json_encode(["error" => "Failed to delete user"]);
    }
}

?>