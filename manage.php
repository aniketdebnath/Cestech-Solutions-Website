<?php
session_start();

if(!isset($_SESSION['username'])) {
    header('Location: login.php');
    exit();
}
?>
<?php
$currentPage = 'manage';
$bodyId = 'manage_page';
$banner = '<p id="banner">Manage EOIs</p>';
include_once 'header.inc';
?>

<?php
include 'settings.php';

// Connect to the database
$dbconn = mysqli_connect($host, $user, $pwd, $sql_db);

// Check the connection
if (!$dbconn) {
  die("Connection failed: " . mysqli_connect_error());
}

// List all EOIs
$listAllQuery = "SELECT * FROM eoi";
$listAllResult = mysqli_query($dbconn, $listAllQuery);

// List EOIs for a particular position
if (isset($_GET['position'])) {
  $position = $_GET['position'];
  $listByPositionQuery = "SELECT * FROM eoi WHERE JobReferenceNumber = '$position'";
  $listByPositionResult = mysqli_query($dbconn, $listByPositionQuery);
}

// List EOIs for a particular applicant
if ($_SERVER["REQUEST_METHOD"] == "GET") {
  if (isset($_GET['firstname']) || isset($_GET['lastname'])) {
    $firstname = $_GET['firstname'];
    $lastname = $_GET['lastname'];
    
    // Construct the WHERE clause condition
    $whereCondition = "";
    if (!empty($firstname)) {
      $whereCondition = "FirstName = '$firstname'";
    }
    if (!empty($lastname)) {
      if (!empty($whereCondition)) {
        $whereCondition .= " OR ";
      }
      $whereCondition .= "LastName = '$lastname'";
    }
    
    // Construct the SQL query
    $listByApplicantQuery = "SELECT * FROM eoi";
    if (!empty($whereCondition)) {
      $listByApplicantQuery .= " WHERE " . $whereCondition;
    }
    
    $listByApplicantResult = mysqli_query($dbconn, $listByApplicantQuery);
  }
}


// Delete EOIs with specified job reference number
if (isset($_POST['deleteJobRef'])) {
  $jobRefToDelete = $_POST['deleteJobRef'];
  $deleteQuery = "DELETE FROM eoi WHERE JobReferenceNumber = '$jobRefToDelete'";
  $deleteResult = mysqli_query($dbconn, $deleteQuery);
}

// Change status of an EOI
if (isset($_POST['eoiNum']) && isset($_POST['newStatus'])) {
  $EOInumber = $_POST['eoiNum'];
  $newStatus = $_POST['newStatus'];
  $statusQuery = "UPDATE eoi SET Status = '$newStatus' WHERE EOInumber = '$EOInumber'";
  $statusResult = mysqli_query($dbconn, $statusQuery);
}
?>
<div class="container">
    <!-- List all EOIs -->
    <div>
	<br><br>
        <h2>List all EOIs</h2>
        <form method="post">
            <input type="submit" name="listAllEOIs" value="List All EOIs">
        </form>
        <?php
        if (isset($_POST['listAllEOIs'])) {
            echo "<table>";
            echo "<tr>";
            echo "<th>EOInumber</th>";
            echo "<th>Job Reference Number</th>";
            echo "<th>First Name</th>";
            echo "<th>Last Name</th>";
            echo "<th>Dob</th>";
            echo "<th>Street Address</th>";
            echo "<th>SuburbTown</th>";
            echo "<th>State</th>";
            echo "<th>Postcode</th>";
            echo "<th>Email</th>";
            echo "<th>PhoneNumber</th>";
            echo "<th>Skill1</th>";
            echo "<th>Skill2</th>";
            echo "<th>Skill3</th>";
            echo "<th>Skill4</th>";
            echo "<th>OtherSkills</th>";
            echo "<th>Status</th>";
            echo "</tr>";
            
            while ($row = mysqli_fetch_assoc($listAllResult)) {
                echo "<tr>";
                echo "<td>" . $row["EOInumber"] . "</td>";
                echo "<td>" . $row["JobReferenceNumber"] . "</td>";
                echo "<td>" . $row["FirstName"] . "</td>";
                echo "<td>" . $row["LastName"] . "</td>";
                echo "<td>" . $row["Dob"] . "</td>";
                echo "<td>" . $row["StreetAddress"] . "</td>";
                echo "<td>" . $row["SuburbTown"] . "</td>";
                echo "<td>" . $row["State"] . "</td>";
                echo "<td>" . $row["Postcode"] . "</td>";
                echo "<td>" . $row["Email"] . "</td>";
                echo "<td>" . $row["PhoneNumber"] . "</td>";
                echo "<td>" . $row["Skill1"] . "</td>";
                echo "<td>" . $row["Skill2"] . "</td>";
                echo "<td>" . $row["Skill3"] . "</td>";
                echo "<td>" . $row["Skill4"] . "</td>";
                echo "<td>" . $row["OtherSkills"] . "</td>";
                echo "<td>" . $row["Status"] . "</td>";
                echo "</tr>";
            }
            
            echo "</table>";
        }
        ?>
    </div>
    <br>
    <br>
    <hr>
    <br>
    <br>
    <!-- List EOIs for a particular position -->
    <div>
		<h2>List EOIs for a particular position</h2>
		<form method="get">
		  <label for="position">Job Reference Number:</label>
		  <select id="position" name="position" required>
			<option value="">Select a Job Reference Number</option>
			<option value="EAI07">EAI07</option>
			<option value="NE034">NE034</option>
		  </select>
		  <input type="submit" value="Search">
		</form>
		<?php
		if (isset($listByPositionResult)) {
		  echo "<table>";
		  echo "<tr>";
		  echo "<th>EOInumber</th>";
		  echo "<th>Job Reference Number</th>";
		  echo "<th>First Name</th>";
		  echo "<th>Last Name</th>";
		  echo "<th>Dob</th>";
		  echo "<th>Street Address</th>";
		  echo "<th>Suburb/Town</th>";
		  echo "<th>State</th>";
		  echo "<th>Postcode</th>";
		  echo "<th>Email Address</th>";
		  echo "<th>Phone Number</th>";
		  echo "<th>Skill1</th>";
		  echo "<th>Skill2</th>";
		  echo "<th>Skill3</th>";
		   echo "<th>Skill4</th>";
		  echo "<th>Other Skills</th>";
		  echo "<th>Status</th>";
		  echo "</tr>";
		  while ($row = mysqli_fetch_assoc($listByPositionResult)) {
			echo "<tr>";
			echo "<td>" . $row["EOInumber"] . "</td>";
			echo "<td>" . $row["JobReferenceNumber"] . "</td>";
			echo "<td>" . $row["FirstName"] . "</td>";
			echo "<td>" . $row["LastName"] . "</td>";
			echo "<td>" . $row["Dob"] . "</td>";
			echo "<td>" . $row["StreetAddress"] . "</td>";
			echo "<td>" . $row["SuburbTown"] . "</td>";
			echo "<td>" . $row["State"] . "</td>";
			echo "<td>" . $row["Postcode"] . "</td>";
			echo "<td>" . $row["Email"] . "</td>";
			echo "<td>" . $row["PhoneNumber"] . "</td>";
			echo "<td>" . $row["Skill1"] . "</td>";
			echo "<td>" . $row["Skill2"] . "</td>";
			echo "<td>" . $row["Skill3"] . "</td>";
			echo "<td>" . $row["Skill4"] . "</td>";
			echo "<td>" . $row["OtherSkills"] . "</td>";
			echo "<td>" . $row["Status"] . "</td>";
			echo "</tr>";
		  }
		  echo "</table>";
		}
		?>
   </div>
		<br>
		<br>
		<hr>
		<br>
		<br>
    <!-- List EOIs for a particular applicant -->
    <div>
		<h2>List EOIs for a particular applicant</h2>
		<form method="get">
		  <label for="firstname">First Name:</label>
		  <input type="text" id="firstname" name="firstname">
		  <label for="lastname">Last Name:</label>
		  <input type="text" id="lastname" name="lastname">
		  <input type="submit" value="Search">
		</form>
		<?php
		if (isset($listByApplicantResult)) {
		  echo "<table>";
		  echo "<tr>";
		  echo "<th>EOInumber</th>";
		  echo "<th>Job Reference Number</th>";
		  echo "<th>First Name</th>";
		  echo "<th>Last Name</th>";
		  echo "<th>Dob</th>";
		  echo "<th>Street Address</th>";
		  echo "<th>Suburb/Town</th>";
		  echo "<th>State</th>";
		  echo "<th>Postcode</th>";
		  echo "<th>Email Address</th>";
		  echo "<th>Phone Number</th>";
		  echo "<th>Skill1</th>";
		  echo "<th>Skill2</th>";
		  echo "<th>Skill3</th>";
		  echo "<th>Skill4</th>";
		  echo "<th>Other Skills</th>";
		  echo "<th>Status</th>";
		  echo "</tr>";
		  while ($row = mysqli_fetch_assoc($listByApplicantResult)) {
			echo "<tr>";
			echo "<td>" . $row["EOInumber"] . "</td>";
			echo "<td>" . $row["JobReferenceNumber"] . "</td>";
			echo "<td>" . $row["FirstName"] . "</td>";
			echo "<td>" . $row["LastName"] . "</td>";
			echo "<td>" . $row["Dob"] . "</td>";
			echo "<td>" . $row["StreetAddress"] . "</td>";
			echo "<td>" . $row["SuburbTown"] . "</td>";
			echo "<td>" . $row["State"] . "</td>";
			echo "<td>" . $row["Postcode"] . "</td>";
			echo "<td>" . $row["Email"] . "</td>";
			echo "<td>" . $row["PhoneNumber"] . "</td>";
			echo "<td>" . $row["Skill1"] . "</td>";
			echo "<td>" . $row["Skill2"] . "</td>";
			echo "<td>" . $row["Skill3"] . "</td>";
			echo "<td>" . $row["Skill4"] . "</td>";
			echo "<td>" . $row["OtherSkills"] . "</td>";
			echo "<td>" . $row["Status"] . "</td>";
			echo "</tr>";
		  }
		  echo "</table>";
		}
		?>
</div>
		<br>
		<br>
		<hr>
		<br>
		<br>
    <!-- Delete EOIs with specified job reference number -->
    <div>
		<h2>Delete EOIs</h2>
		<form method="post">
		  <label for="deleteJobRef">Job Reference Number:</label>
		  <select id="deleteJobRef" name="deleteJobRef" required>
			<option value="">Select a Job Reference Number</option>
			<option value="EAI07">EAI07</option>
			<option value="NE034">NE034</option>
			<!-- Add more options as needed -->
		  </select>
		  <input type="submit" name="deleteEOI" value="Delete">
		</form>
    </div>
		<br>
		<br>
		<hr>
		<br>
		<br>
    <!-- Change status of an EOI -->
    <div>
      <h2>Change EOI Status</h2>
      <form method="post">
        <label for="eoiNum">EOI Number:</label>
        <input type="text" id="eoiNum" name="eoiNum" required>
        <label for="newStatus">New Status:</label>
        <select id="newStatus" name="newStatus" required>
		  <option value="" disabled selected hidden>Select a status</option>
          <option value="New">New</option>
          <option value="Current">Current</option>
          <option value="Final">Final</option>
        </select>
        <input type="submit" name="changeStatus" value="Change Status">
		<br>
		<br>
		<hr>
		<br>
		<br>
		  <a href="logout.php" class="logout-button">Logout</a>
      </form>
    </div>
  <br>

  </div>
<?php include_once 'footer.inc'; ?>

