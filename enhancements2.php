<?php
$currentPage = 'enhancements2';
$bodyId = 'enhancements2_page';
$banner = '<p id="banner">Enhancements 2</p>';
include_once 'header.inc';
?>
    <h2>Enhancement 1: Timer which counts down and redirects to home page after expiry</h2>
    <p>
        This <a href="apply.php#timer">enhancement</a> begins a countdown timer of 3 minutes or 180 seconds as soon as the apply page loads. The user has to submit the form within 3 minutes else the page will be redirected to the home page. A timer at the bottom of the page displays the time left.
        deleted when the user is not using the form. This technique was learnt
        from <a href="https://www.w3schools.com/js/js_timing.asp">here</a>.
    </p>
    <p>
        We make 3 functions to implement the timer. A function to start the timer (timerStart), a 
         function to update the countdown timer displayed on the screen (updatetimeLeft), and a function to redirect to home page (homePage). startTimer
         starts the timer using a setTimeout function in JS. It also runs updatetimeLeft function on intervals using setInterval function. 
         The updatetimeLeft function displays the time left to the user.
    </p>
	<br><br><br><br><br><br><br><br><br><br><br><br>
<?php include_once 'footer.inc'; ?>