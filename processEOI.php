<?php
// Include database settings
include 'settings.php';

// Ensure form data has been submitted



if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Validate form data
    $errors = [];

    // Validate Job Reference Number
    $jobRefNumber = sanitizeInput($_POST['reference']);
    if (empty($jobRefNumber)) {
        $errors[] = "Please enter the Job Reference Number.";
    }
    elseif (!preg_match('/^[A-Za-z0-9]{5}$/', $jobRefNumber)) {
        $errors[] = "Job Reference Number must be exactly 5 alphanumeric characters.";
    }
	elseif (!preg_match('/^(EAI07|NE034)$/', $jobRefNumber)) {
    $errors[] = "Please enter a Job Reference Number listed in our Job Description Page.";
	}

    // Validate First Name
    $firstName = sanitizeInput($_POST['first_name']);
    if (empty($firstName)) {
        $errors[] = "Please enter the First Name.";
    }
    elseif (!preg_match('/^[A-Za-z]{1,20}$/', $firstName)) {
        $errors[] = "First Name must contain only alphabetic characters and have a maximum length of 20.";
    }

    // Validate Last Name
    $lastName = sanitizeInput($_POST['last_name']);
    if (empty($lastName)) {
        $errors[] = "Please enter the Last Name.";
    }
    elseif (!preg_match('/^[A-Za-z]{1,20}$/', $lastName)) {
        $errors[] = "Last Name must contain only alphabetic characters and have a maximum length of 20.";
    }

    // Validate Date of Birth
	$dob = sanitizeInput($_POST['dob']);
	if (empty($dob)) {
    $errors[] = "Please enter the Date of Birth.";
    }
    elseif (!preg_match('/^\d{1,2}\/\d{1,2}\/\d{4}$/', $dob)) {
        $errors[] = "Date of Birth must be in the format dd/mm/yyyy.";
    } 
	else {
        $dobParts = explode('/', $dob);
        $day = intval($dobParts[0]);
        $month = intval($dobParts[1]);
        $year = intval($dobParts[2]);
        $currentDate = new DateTime();
        $minAgeDate = new DateTime();
        $minAgeDate->modify('-80 years');
        $maxAgeDate = new DateTime();
        $maxAgeDate->modify('-15 years');
        $dobDate = DateTime::createFromFormat('d/m/Y', $dob);
        if (!$dobDate || $dobDate > $currentDate || $dobDate < $minAgeDate || $dobDate > $maxAgeDate) {
            $errors[] = "Date of Birth must be between 15 and 80 years ago.";
        }
    }

    // Validate Gender
    $gender = sanitizeInput($_POST['gender']);
    if (empty($gender)) {
        $errors[] = "Please select a Gender.";
    }
    elseif (!in_array($gender, ['male', 'female', 'other'])) {
        $errors[] = "Gender must be selected.";
    }

    // Validate Street Address
    $streetAddress = sanitizeInput($_POST['street_address']);
    if (empty($streetAddress)) {
        $errors[] = "Please enter the Street Address.";
    }
    elseif (strlen($streetAddress) > 40) {
        $errors[] = "Street Address must have a maximum length of 40 characters.";
    }

    // Validate Suburb/Town
    $suburb = sanitizeInput($_POST['suburb']);
    if (empty($suburb)) {
        $errors[] = "Please enter the Suburb/Town.";
    }
    elseif (strlen($suburb) > 40) {
        $errors[] = "Suburb/Town must have a maximum length of 40 characters.";
    }

    // Validate State
    $state = sanitizeInput($_POST['state']);
    if (empty($state)) {
        $errors[] = "Please select a State.";
    }
    else {
		$validStates = ['VIC', 'NSW', 'QLD', 'NT', 'WA', 'SA', 'TAS', 'ACT'];
		if (!in_array($state, $validStates)) {
        $errors[] = "State must be one of the specified options.";
		}
	}

    // Validate Postcode
    $postcode = sanitizeInput($_POST['postcode']);
    if (empty($postcode)) {
        $errors[] = "Please enter the Postcode.";
	}
    else {
		$postcodeValidationResult = validatePostcodeByState($postcode, $state);
		if ($postcodeValidationResult !== true) {
        $errors[] = $postcodeValidationResult;
		}
    }

    // Validate Email
    $email = sanitizeInput($_POST['email']);
    if (empty($email)) {
        $errors[] = "Please enter the Email.";
	}
    elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $errors[] = "Invalid email format.";
    }

    // Validate Phone Number
    $phone = sanitizeInput($_POST['phone']);
    if (empty($phone)) {
        $errors[] = "Please enter the Phone Number.";
	}
    elseif (!preg_match('/^\d{8,12}|\d{4} \d{4,8}$/', $phone)) {
        $errors[] = "Phone Number must be 8 to 12 digits, or have the format 'XXXX XXXX' (4 digits followed by a space and 4 to 8 digits).";
    }

    // Validate Other Skills
    $skills = isset($_POST['skills']) ? sanitizeInput($_POST['skills']) : array();
    if (empty($skills)) {
        $errors[] = "Please specify skills.";
	}
    else {
		$otherSkills = sanitizeInput($_POST['other_skills']);
		if (in_array('other_skills', $skills) && empty($otherSkills)) {
        $errors[] = "Please specify other skills.";
		}
    }

    // If there are validation errors, display them to the user
    if (!empty($errors)) {
        foreach ($errors as $error) {
            echo $error . "<br>";
        }
    } else {
        // Connect to the database
        $dbconn = @mysqli_connect($host, $user, $pwd, $sql_db);

        // Check the connection
        if (!$dbconn) {
            die("Connection failed: " . mysqli_connect_error());
        }
	

		// Exclude the "Other Skills" option from the skills array
		$skills = array_diff($skills, ['other_skills']);

		// Prepare and execute the INSERT statement
		$insertQuery = "INSERT INTO eoi (JobReferenceNumber, FirstName, LastName, Dob, StreetAddress, SuburbTown, State, Postcode, Email, PhoneNumber, Skill1, Skill2, Skill3, Skill4, OtherSkills)
						VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";
		$stmt = mysqli_prepare($dbconn, $insertQuery);
		mysqli_stmt_bind_param($stmt, "sssssssssssssss", $jobRefNumber, $firstName, $lastName, $dob, $streetAddress, $suburb, $state, $postcode, $email, $phone, $skills[0], $skills[1], $skills[2], $skills[3], $otherSkills);
		mysqli_stmt_execute($stmt);

        if (mysqli_stmt_affected_rows($stmt) === 1) {
            echo "EOI successfully added with EOInumber " . mysqli_insert_id($dbconn);
        } else {
            echo "Error in adding EOI record.";
        }

        // Close the statement and database connection
        mysqli_stmt_close($stmt);
        mysqli_close($dbconn);
	}
}
	else {
    header("Location: index.php");
    exit();
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

function validatePostcodeByState($postcode, $state)
{
    switch ($state) {
        case 'VIC':
            if (!preg_match('/^3[0-9]{3}$/', $postcode)) {
                return "Victorian postcodes must start with 3 and have exactly 4 digits.";
            }
            break;
        case 'NSW':
            if (!preg_match('/^2[0-9]{3}$/', $postcode)) {
                return "New South Wales postcodes must start with 2 and have exactly 4 digits.";
            }
            break;
        case 'QLD':
            if (!preg_match('/^4[0-9]{3}$/', $postcode)) {
                return "Queensland postcodes must start with 4 and have exactly 4 digits.";
            }
            break;
        case 'NT':
            if (!preg_match('/^0[0-9]{3}$/', $postcode)) {
                return "Northern Territory postcodes must start with 0 and have exactly 4 digits.";
            }
            break;
        case 'WA':
            if (!preg_match('/^6[0-9]{3}$/', $postcode)) {
                return "Western Australia postcodes must start with 6 and have exactly 4 digits.";
            }
            break;
        case 'SA':
            if (!preg_match('/^5[0-9]{3}$/', $postcode)) {
                return "South Australia postcodes must start with 5 and have exactly 4 digits.";
            }
            break;
        case 'TAS':
            if (!preg_match('/^7[0-9]{3}$/', $postcode)) {
                return "Tasmania postcodes must start with 7 and have exactly 4 digits.";
            }
            break;
        case 'ACT':
            if (!preg_match('/^0[0-9]{3}$/', $postcode)) {
                return "ACT postcodes must start with 0 and have exactly 4 digits.";
            }
            break;
        default:
            return "Invalid state.";
            break;
    }

    return true; // Postcode is valid for the state
}
?>



