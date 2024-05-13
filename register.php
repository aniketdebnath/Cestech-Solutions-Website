<?php
$currentPage = 'register';
$bodyId = 'register_page';
$banner = '<p id="banner">Register</p>';
include_once 'header.inc';
?>
<?php
include 'settings.php';

// If form data has been submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Get form data
    $username = sanitizeInput($_POST['username']);
    $password = sanitizeInput($_POST['password']);

    // Connect to the database
    $dbconn = @mysqli_connect($host, $user, $pwd, $sql_db);

    // Check the connection
    if (!$dbconn) {
        die("Connection failed: " . mysqli_connect_error());
    }

    // Check if username already exists
    $checkUserQuery = "SELECT * FROM manager WHERE username=?";
    $stmt = mysqli_prepare($dbconn, $checkUserQuery);
    mysqli_stmt_bind_param($stmt, "s", $username);
    mysqli_stmt_execute($stmt);
    mysqli_stmt_store_result($stmt);
    $num_of_rows = mysqli_stmt_num_rows($stmt);
    
    if ($num_of_rows > 0) {
        echo "This username already exists. Please try another.";
    } else {
        // Insert new manager into the database
        $insertQuery = "INSERT INTO manager (username, password) VALUES (?, ?)";
        $stmt = mysqli_prepare($dbconn, $insertQuery);
        mysqli_stmt_bind_param($stmt, "ss", $username, $password);
        mysqli_stmt_execute($stmt);
        
        if (mysqli_stmt_affected_rows($stmt) === 1) {
            echo "Manager successfully registered.";
        } else {
            echo "Error in adding manager record.";
        }
    }
    
    // Close the statement and database connection
    mysqli_stmt_close($stmt);
    mysqli_close($dbconn);
} else {
?>

<?php
}

function sanitizeInput($input)
{
    if (is_array($input)) {
        return array_map('sanitizeInput', $input);
    }

    // Remove leading and trailing spaces
    $input = trim($input);
    
    // Remove backslashes
    $input = stripslashes($input);
    
    // Convert special HTML entities to characters
    $input = htmlspecialchars($input);

    return $input;
}
?>
<div class="form-container">
    <form method="post" action="register.php">
        <div>
            <label for="username">Username:</label>
            <input type="text" id="username" name="username" required>
        </div>
        <div>
            <label for="password">Password:</label>
            <input type="password" id="password" name="password" required>
        </div>
        <div>
            <button type="submit">Register</button>
        </div>
	</form>
</div>
	<br>
	<br>
	<br>
	<br>
	<br>
	<br>
	<br>
	<br>

<?php include_once 'footer.inc'; ?>