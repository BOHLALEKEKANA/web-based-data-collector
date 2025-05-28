<?php
// Database connection
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "checkout_db";

try {
    $conn = new PDO("mysql:host=$servername;dbname=$dbname", $username, $password);
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    die("Connection failed: " . $e->getMessage());
}

// Server-side validation
$name = filter_input(INPUT_POST, 'name', FILTER_SANITIZE_STRING);
$email = filter_input(INPUT_POST, 'email', FILTER_SANITIZE_EMAIL);
$phone = filter_input(INPUT_POST, 'phone', FILTER_SANITIZE_STRING);
$card = filter_input(INPUT_POST, 'card', FILTER_SANITIZE_STRING);
$address = filter_input(INPUT_POST, 'address', FILTER_SANITIZE_STRING);

$errors = [];

if (strlen($name) < 2) {
    $errors[] = "Name must be at least 2 characters";
}
if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
    $errors[] = "Invalid email format";
}
if (!preg_match("/^\d{10}$/", $phone)) {
    $errors[] = "Phone number must be 10 digits";
}
if (!preg_match("/^\d{16}$/", $card)) {
    $errors[] = "Credit card must be 16 digits";
}
if (strlen($address) < 5) {
    $errors[] = "Address must be at least 5 characters";
}

if (!empty($errors)) {
    http_response_code(400);
    echo json_encode(['errors' => $errors]);
    exit;
}

// Store in database
try {
    $stmt = $conn->prepare("INSERT INTO users (name, email, phone, card, address) VALUES (:name, :email, :phone, :card, :address)");
    $stmt->execute([
        'name' => $name,
        'email' => $email,
        'phone' => $phone,
        'card' => $card,
        'address' => $address
    ]);
    echo json_encode(['success' => true]);
} catch (PDOException $e) {
    http_response_code(500);
    echo json_encode(['error' => "Database error: " . $e->getMessage()]);
}

$conn = null;
?>
