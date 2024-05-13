//Enhancement 1 Timer

//variables that are used for the timer functions
var totalTime = 180000; //amount of milliseconds user can be idle for 
var timer;  
var timeLeft = totalTime / 1000;

//Starts the timer and updates it every 1 second. gets called once 

function timerStart(){
    timer = setTimeout(homePage,totalTime);
    updatetimeLeft();
    setInterval(updatetimeLeft,1000);
}


//updates the visible timer that is displayed to the user.
function updatetimeLeft(){
    if(timeLeft > - 1){
        timeLeft -= 1;
    }
    document.getElementById("timer").textContent = timeLeft + 1;
}

// Gets called when timer ends.
function homePage(){
alert("Session Expired. Redirecting to Home Page");
window.location.href = "index.php";
}

function init2(){
    if(document.getElementById("apply_page") != null){
		timerStart();  
        
    }else if(document.getElementById("enquire_page") != null){
        
    }
}

window.addEventListener("load",init2);