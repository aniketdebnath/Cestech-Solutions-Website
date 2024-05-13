<?php
$currentPage = 'login';
$bodyId = 'login_page';
$banner = '<p id="banner">Login</p>';
include_once 'header.inc';
?>

<?php
include 'settings.php';
session_start();

$loginErrors = array();

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $username = sanitizeInput($_POST['username']);
    $password = sanitizeInput($_POST['password']);

    // Connect to the database
    $dbconn = @mysqli_connect($host, $user, $pwd, $sql_db);

    // Check the connection
    if (!$dbconn) {
        die("Connection failed: " . mysqli_connect_error());
    }

    // Query the manager table
    $query = "SELECT * FROM manager WHERE username=?";
    $stmt = mysqli_prepare($dbconn, $query);
    mysqli_stmt_bind_param($stmt, "s", $username);
    mysqli_stmt_execute($stmt);
    $result = mysqli_stmt_get_result($stmt);
    $manager = mysqli_fetch_assoc($result);

    if($manager){
        if($manager['username'] === $username){
            if($manager['password'] === $password){
                if($manager['failed_login_attempts'] < 3 || time() - $manager['lockout_time'] > 30){
                    $_SESSION['username'] = $manager['username'];
                    $_SESSION['last_login_timestamp'] = time();
                    mysqli_query($dbconn, "UPDATE manager SET failed_login_attempts = 0, lockout_time = NULL WHERE username = '".$username."'");
                    header('Location: manage.php');
                    exit();
                } else {
                    $loginErrors[] = "Your account has been locked due to multiple failed login attempts. Please wait 30 seconds before trying again.";
                }
            } else {
                $failed_count = $manager['failed_login_attempts'] + 1;
                $lockout_time = $failed_count >= 3 ? time() : NULL;
                mysqli_query($dbconn, "UPDATE manager SET failed_login_attempts = '".$failed_count."', lockout_time = '".$lockout_time."' WHERE username = '".$username."'");
                if($failed_count >= 3){
                    $loginErrors[] = "Your account has been locked due to multiple failed login attempts. Please wait 30 seconds before trying again.";
                } else {
                    $loginErrors[] = "Incorrect password. Please try again.";
                }
            }
        }
    } else {
        $loginErrors[] = "Username does not exist.";
    }

    mysqli_close($dbconn);
}

function sanitizeInput($input)
{
    if (is_array($input)) {
        return array_map('sanitizeInput', $input);
    }

    $input = trim($input);
    $input = stripslashes($input);
    $input = htmlspecialchars($input);

    return $input;
}
?>

<?php
foreach($loginErrors as $error) {
    echo '<div class="alert alert-danger">' . $error . '</div>';
}
?>
<div class="form-container">
	<form method="post" action="login.php">
    <div>
        <label for="username">Username:</label>
        <input type="text" id="username" name="username" required>
    </div>
    <div>
        <label for="password">Password:</label>
        <input type="password" id="password" name="password" required>
    </div>
    <div>
        <button type="submit">Login</button>
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