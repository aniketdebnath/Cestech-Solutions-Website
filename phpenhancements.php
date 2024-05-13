<?php
$currentPage = 'phpenhancements';
$bodyId = 'phpenhancements_page';
$banner = '<p id="banner">Php Enhancements</p>';
include_once 'header.inc';
?>

<h2>Enhancement 1: Login and Register functionality</h2>
<p>
    This <a href="login.php">enhancement</a> introduces a login and registration system. Users can register for an account by providing a username and password. The registration form validates the input and checks if the username is unique. If the username is available, the user's information is securely stored in the database for future logins.
    The login functionality allows registered users to log in using their credentials. When the user submits the login form, the system verifies the entered username and password against the stored data in the database. If the login is successful, the user is granted access to restricted manage page.   
	This technique was learnt from <a href="https://www.tutorialrepublic.com/php-tutorial/php-mysql-login-system.php">here</a>.
</p>
<p>
In the registration process, the user's entered username and password are sanitized and validated. The sanitizeInput function removes leading/trailing spaces, backslashes, and converts special characters using the trim, stripslashes, and htmlspecialchars commands.
The system checks if the username already exists in the database using the mysqli_stmt_num_rows command, and if not, inserts the new manager's record into the database using the mysqli_prepare, mysqli_stmt_bind_param, and mysqli_stmt_execute commands.
A success or error message is displayed based on the result of the registration using the mysqli_stmt_affected_rows command, providing feedback to the user.
</p>
<p>
    In the login process, the user's entered username and password are verified against the stored data in the database using the mysqli_prepare, mysqli_stmt_bind_param, and mysqli_stmt_execute commands.
    If the username exists, the password is compared, and if it matches, the user is redirected to the management page (manage.php) by using the header and exit commands.
    In case of unsuccessful login attempts, the system keeps track of the number of failed attempts and implements a lockout mechanism using the failed_login_attempts, lockout_time, and time commands to prevent unauthorized access.
</p>

<h2>Enhancement 2: Logout functionality</h2>
<p>
    This <a href="logout.php">enhancement</a> adds a logout feature that allows users to securely log out of their accounts. When the user chooses to log out, the system destroys the session data associated with the user's session. This termination of the session ensures that the user's account remains secure and inaccessible after logging out.
    The logout functionality helps protect user accounts from unauthorized access. By logging out, users can ensure that their accounts are not accessible to anyone else using the same device or browser session.
    When a user clicks the logout button, the system destroys the session data and redirects the user to the login page, ensuring a smooth transition and maintaining the security of the application.
	This technique was learnt from <a href="https://www.studentstutorial.com/php/login-logout-with-session">here</a>.
</p>
<p>
    The logout process is achieved by destroying the session data using the session_unset and session_destroy commands, which clear the user's session and associated data.
    When the logout form is submitted, the system redirects the user to the login page using the header function and the Location header, ensuring they are logged out and taken to the login page.
    This provides a secure way to end the user's session and ensure they are logged out, maintaining the integrity of their data and protecting their privacy.
	</p>
<br>

<?php include_once 'footer.inc'; ?>