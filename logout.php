<?php
$currentPage = 'logout';
$bodyId = 'logout_page';
$banner = '<p id="banner">Logout</p>';
include_once 'header.inc';
?>

<?php
// logout.php
session_start();

// Check if the form is submitted
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Destroy session data and redirect to login page
    session_unset(); 
    session_destroy();
    header('Location: login.php');
    exit();
}
?>
<div class="form-container">
        <form method="POST" action="logout.php">
            <div>
                <p>Are you sure you want to log out?</p>
            </div>
            <div>
                <button type="submit">Logout</button>
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