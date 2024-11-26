<?php
// Database connection
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "library_db";

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Initialize variables
$message = "";

// User Login
if (isset($_POST['userLogin'])) {
    $email = $_POST['userEmail'];
    $password = md5($_POST['userPassword']);
    
    $result = $conn->query("SELECT * FROM users WHERE email='$email' AND password='$password'");
    
    if ($result->num_rows > 0) {
        $message = "Login successful! Welcome, $email.";
    } else {
        $message = "Invalid email or password!";
    }
}

// User Registration
if (isset($_POST['userRegister'])) {
    $name = $_POST['userName'];
    $email = $_POST['userEmail'];
    $password = md5($_POST['userPassword']); // hashing the password
    
    $conn->query("INSERT INTO users (name, email, password) VALUES ('$name', '$email', '$password')");
    
    $message = "Registration successful!";
}

// Book Search
if (isset($_POST['searchBook'])) {
    $searchQuery = $_POST['searchQuery'];
    $result = $conn->query("SELECT * FROM books WHERE title LIKE '%$searchQuery%' OR author LIKE '%$searchQuery%'");
    
    if ($result->num_rows > 0) {
        $message = "<h2>Search Results:</h2><ul>";
        while ($row = $result->fetch_assoc()) {
            $message .= "<li><strong>Title:</strong> " . $row['title'] . "<br><strong>Author:</strong> " . $row['author'] . "<br><strong>Year:</strong> " . $row['published_year'] . "</li>";
        }
        $message .= "</ul>";
    } else {
        $message = "No books found!";
    }
}

$conn->close();
?>
