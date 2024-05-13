/**
 * Author: Aniket Debnath
 * Target: apply.html, jobs.html
 * Purpose: manipulates the form date and validates some bits.
 * Last editted : 24th April
 */
"use strict";

// Set the debug flag to enable/disable client-side validation
var debug = true;

//checks whether the browser supports storage
function doesBrowserSupportStorage() {
    if (typeof(Storage) !== "undefined") {
        return true; // localStorage and sessionStorage is supported by browser
    } else {
        return false; //no web storage supported.
    }

}

function validateApply() {

    if (doesBrowserSupportStorage) {
        var errMsg = ""; //stores the error message
        var result = true; //assumes no errors. if something is wrong set result = false, and concatenate error message
        var postcode = document.getElementById("postcode").value;
        var state = document.getElementById("state").value;
        var dateOfBirth = document.getElementById("dob").value;
        var nameError = document.getElementById("error-message");
		if (!debug) {
        errMsg += validateStateAndPostcode(state, postcode);
        errMsg += validateDob(dateOfBirth);
        errMsg += validateSkills();
		}

        if (errMsg != "") { //only display message box if there is something to show
            nameError.textContent = errMsg;
            result = false;
        }
        if (result == true) {
            submitApplyForm(); 
        }

        return result; //if false, the information will not be sent to the server

    } else {
        alert("Browser does not support storage. Please use a different browser.");
        return false;
    }
}

const MIN_AGE = 15;
const MAX_AGE = 80;

// Function to validate date of birth
function validateDob(dob) {
    var errMsg = "";
    var parts = dob.split('/');
    var day = parseInt(parts[0], 10);
    var month = parseInt(parts[1], 10);
    var year = parseInt(parts[2], 10);


    var dateOfBirth = new Date(year, month, day);

    // Calculate age in milliseconds
    var ageInMilliseconds = Date.now() - dateOfBirth.getTime();
    // Convert age to years
    var ageInYears = ageInMilliseconds / (1000 * 60 * 60 * 24 * 365);
    // Check if age is within the allowed range
    if (ageInYears >= MIN_AGE && ageInYears <= MAX_AGE) {
        return errMsg;
    } else {
        return errMsg += "*You do not meet the age requirements.\n";;
    }
}


//Checks that postcodes first digit correspond with the correct state.
function validateStateAndPostcode(state, postcode) {
    var errMsg = "";
    switch (state) {
        case "VIC":
            if (!postcode.match(/^[38][0-9]{3}$/)) {
                errMsg += "*Victorian post codes must begin with 3 or 8. Input the correct state and postcode.\n";
            }
            break;
        case "NSW":
            if (!postcode.match(/^[12][0-9]{3}$/)) {
                errMsg += "*New South Wales post codes must begin with 1 or 2. Input the correct state and postcode.\n";
            }
            break;
        case "QLD":
            if (!postcode.match(/^[49][0-9]{3}$/)) {
                errMsg += "*Queensland post codes must begin with 4 or 9. Input the correct state and postcode.\n";
            }
            break;
        case "NT":
            if (!postcode.match(/^[0][0-9]{3}$/)) {
                errMsg += "*Northern Territory post codes must begin with 0. Input the correct state and postcode.\n";
            }
            break;
        case "ACT":
            if (!postcode.match(/^[0][0-9]{3}$/)) {
                errMsg += "*ACT post codes must begin with 0. Input the correct state and postcode.\n";
            }
            break;
        case "WA":
            if (!postcode.match(/^[6][0-9]{3}$/)) {
                errMsg += "*Western Australia post codes must begin with 6. Input the correct state and postcode.\n";
            }
            break;
        case "SA":
            if (!postcode.match(/^[5][0-9]{3}$/)) {
                errMsg += "*South Australia post codes must begin with 5. Input the correct state and postcode.\n";
            }
            break;
        case "TAS":
            if (!postcode.match(/^[7][0-9]{3}$/)) {
                errMsg += "*Tasmania post codes must begin with 7. Input the correct state and postcode.\n";
            }
            break;
        default:
            break;
    }
    return errMsg;
}

function validateSkills() {
    var errMsg = "";
    var skill1 = document.getElementById("skill1");
    var skill2 = document.getElementById("skill2");
    var skill3 = document.getElementById("skill3");
    var skill4 = document.getElementById("skill4");
    var otherSkills = document.getElementById("other-skills");
    var otherSkillsTextArea = document.getElementById("other_skills");
    if (!skill1.checked && !skill2.checked && !skill3.checked && !skill4.checked && !otherSkills.checked) {
        errMsg += "*Please select atleast one skill.\n";
    }
    if (otherSkills.checked && otherSkillsTextArea.value.trim() == "") {
        errMsg += "*Please enter your other skills in the text area.\n";
        otherSkillsTextArea.focus();
    }
    if (!otherSkills.checked && !otherSkillsTextArea.value.trim() == "") {
        errMsg += "*Please select Other skills option if you mention other skills in the text box.\n";
        otherSkills.focus();
    }	
    return errMsg;
}

function getReference1() {
    const REF_NO = "EAI07";
    localStorage.setItem("ref_no", REF_NO);
    localStorage.setItem("source", true);

    window.location.href = "apply.html";
}

function getReference2() {
    const REF_NO = "NE034";
    localStorage.setItem("ref_no", REF_NO);
    localStorage.setItem("source", true);

    window.location.href = "apply.html";
}

//saves the submitted form data from the apply page to session storage
function submitApplyForm() {

    //saves other form data to session storage.
    sessionStorage.setItem('firstName', document.getElementById("first_name").value);
    sessionStorage.setItem('lastName', document.getElementById("last_name").value);
    sessionStorage.setItem('dob', document.getElementById("dob").value);
    sessionStorage.setItem('street', document.getElementById("street_address").value);
    sessionStorage.setItem('suburb', document.getElementById("suburb").value);
    sessionStorage.setItem('state', document.getElementById("state").value);
    sessionStorage.setItem('postcode', document.getElementById("postcode").value);
    sessionStorage.setItem('email', document.getElementById("email").value);
    sessionStorage.setItem('phone', document.getElementById("phone").value);

    var gender = "";
    if (document.getElementById("male").checked) {
        gender = "M";
    }
    if (document.getElementById("female").checked) {
        gender = "F";
    }
    if (document.getElementById("other").checked) {
        gender = "O";
    }
    sessionStorage.setItem("gender", gender);

    sessionStorage.setItem("skill1", document.getElementById("skill1").checked);
    sessionStorage.setItem("skill2", document.getElementById("skill2").checked);
    sessionStorage.setItem("skill3", document.getElementById("skill3").checked);
    sessionStorage.setItem("skill4", document.getElementById("skill4").checked);
    sessionStorage.setItem("other-skills", document.getElementById("other-skills").checked);
    sessionStorage.setItem("other_skillsTextArea", document.getElementById("other_skills").value);

}

function getApplyForm() { //gets the results from the apply page and displays data

    //saves the follow saved data from session storage to corresponding variables
    var firstName = sessionStorage.getItem("firstName");
    var lastName = sessionStorage.getItem("lastName");
    var dob = sessionStorage.getItem("dob");
    var street = sessionStorage.getItem("street");
    var suburb = sessionStorage.getItem("suburb");
    var state = sessionStorage.getItem("state");
    var postcode = sessionStorage.getItem("postcode");
    var email = sessionStorage.getItem("email");
    var phone = sessionStorage.getItem("phone");

    var gender = sessionStorage.getItem("gender");
    if (gender == "M") {
        document.getElementById("male").checked = true;
    }
    if (gender == "F") {
        document.getElementById("female").checked = true;
    }
    if (gender == "O") {
        document.getElementById("other").checked = true;
    }

    var skill1 = (sessionStorage.getItem("skill1") == "true");
    var skill2 = (sessionStorage.getItem("skill2") == "true");
    var skill3 = (sessionStorage.getItem("skill3") == "true");
    var skill4 = (sessionStorage.getItem("skill4") == "true");
    var other_skills = (sessionStorage.getItem("other-skills") == "true");
    var other_skillsTextArea = sessionStorage.getItem("other_skillsTextArea");

    document.getElementById("first_name").value = firstName;
    document.getElementById("last_name").value = lastName;
    document.getElementById("dob").value = dob;
    document.getElementById("street_address").value = street;
    document.getElementById("suburb").value = suburb;
    document.getElementById("state").value = state;
    document.getElementById("postcode").value = postcode;
    document.getElementById("email").value = email;
    document.getElementById("phone").value = phone;
    document.getElementById("skill1").checked = skill1;
    document.getElementById("skill2").checked = skill2;
    document.getElementById("skill3").checked = skill3;
    document.getElementById("skill4").checked = skill4;
    document.getElementById("other-skills").checked = other_skills;
    document.getElementById("other_skills").value = other_skillsTextArea;

}

function init() {
    if (document.getElementById("apply_page") != null) { //it is the apply page.
        document.getElementById("apply_form").onsubmit = validateApply;
        getApplyForm();
        var ref_no = localStorage.getItem("ref_no");
        var source = localStorage.getItem("source");
        if (source === "true") {
            // The user comes from the job page, so pre-fill the label as read-only
            document.getElementById("reference").value = ref_no;
            document.getElementById("reference").readOnly = true;
            localStorage.removeItem('ref_no');
            localStorage.removeItem('source');
        } else {
            // The user comes directly to the apply page, so leave the label empty and editable
            document.getElementById("reference").value = "";
            document.getElementById("reference").readOnly = false;
        }

    } else if (document.getElementById("jobs_page") != null) { //it is the jobs page.

        document.getElementById("apply-link1").onclick = getReference1;
        document.getElementById("apply-link2").onclick = getReference2;
    }
}

window.addEventListener("load", init);