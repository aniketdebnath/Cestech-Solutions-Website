<?php
$currentPage = 'apply';
$bodyId = 'apply_page';
$banner = '<p id="banner">Job Application Form</p>';
include_once 'header.inc';
?>

      <form id="apply_form" method="POST" action="processEOI.php" novalidate="novalidate">
         <p>
            <label for="reference">Job Reference Number:</label>
            <input type="text" id="reference" name="reference"  maxlength="5" pattern="[A-Za-z0-9]{5}" required="required">
         </p>
         <fieldset>
            <legend>Personal Details</legend>
            <p>
               <label for="first_name">First Name:</label>
               <input type="text" id="first_name" name="first_name" maxlength="20" pattern="[A-Za-z]{1,20}" required="required">
            </p>
            <p>
               <label for="last_name">Last Name:</label>
               <input type="text" id="last_name" name="last_name"  maxlength="20" pattern="[A-Za-z]{1,20}" required="required">
            </p>
            <p>
               <label for="dob">Date of Birth (dd/mm/yyyy):</label>
               <input type="text" id="dob" name="dob" pattern="\d{1,2}/\d{1,2}/\d{4}" required="required">
            </p>
            <fieldset>
               <legend>Gender</legend>
               <label for="male">Male</label>
               <input type="radio" id="male" name="gender" value="male" required="required">
               <label for="female">Female</label>
               <input type="radio" id="female" name="gender" value="female" required="required">
               <label for="other">Other</label>
               <input type="radio" id="other" name="gender" value="other" required="required">
            </fieldset>
         </fieldset>
         <fieldset>
            <legend>Address</legend>
            <p>
               <label for="street_address">Street Address (max 40 characters):</label>
               <input type="text" id="street_address" name="street_address" maxlength="40" required="required">
            </p>
            <p>
               <label for="suburb">Suburb/Town (max 40 characters):</label>
               <input type="text" id="suburb" name="suburb" maxlength="40" required="required">
            </p>
            <p>
               <label for="state">State:</label>
               <select id="state" name="state" required="required">
                  <option value="">--Please select--</option>
                  <option value="VIC">VIC</option>
                  <option value="NSW">NSW</option>
                  <option value="QLD">QLD</option>
                  <option value="NT">NT</option>
                  <option value="WA">WA</option>
                  <option value="SA">SA</option>
                  <option value="TAS">TAS</option>
                  <option value="ACT">ACT</option>
               </select>
            </p>
            <p>
               <label for="postcode">Postcode:</label>
               <input type="text" id="postcode" name="postcode" pattern="\d{4}" maxlength="4" required="required">
            </p>
         </fieldset>
         <fieldset>
            <legend>Contact Details</legend>
            <p>
               <label for="email">Email:</label>
               <input type="email" id="email" name="email" required="required">
            </p>
            <p>
               <label for="phone">Phone Number:</label>
               <input type="text" id="phone" name="phone" pattern="\d{8,12}|\d{4} \d{4,8}" required="required"><!--phone number takes either 8-12 digits or 4 digits followed by a space and 4-8 digits after that-->
            </p>
         </fieldset>
         <fieldset>
            <legend>Skills</legend>
            <p>    	  
               <label for="skill1">C++</label>
               <input type="checkbox" id="skill1" name="skills[]" value="C++"><br>
               <label for="skill2">Python</label>
               <input type="checkbox" id="skill2" name="skills[]" value="Python"><br>
               <label for="skill3">HTML/CSS/Javascript</label>
               <input type="checkbox" id="skill3" name="skills[]" value="HTML/CSS/Javascript"><br>
               <label for="skill4">SQL</label>
               <input type="checkbox" id="skill4" name="skills[]" value="SQL"><br>
               <label for="other-skills">Other skills...</label>
               <input type="checkbox" id="other-skills" name="skills[]" value="other_skills"><br>     
            </p>
            <p>
               <label for="other_skills">Please specify other skills:</label><br>
               <textarea id="other_skills" name="other_skills"></textarea>
            </p>
         </fieldset>
		 <div id="error-message"></div>
         <input type="submit" value="Submit">
         <input type="reset" value="Reset">
      </form>
	  <p >
        You have 2 minutes to submit the form. Form data will be deleted if not submitted within the time frame.
        <br>
        Time Left (seconds) :
        <strong id="timer">(120 seconds)</strong>    <!-- enhancement timer-->
    </p>
      <br>
      <br>
<?php include_once 'footer.inc'; ?>