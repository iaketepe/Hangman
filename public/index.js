onload = () => {
    getLeaderboard();
}



//const userName = document.getElementById("user-input");   
var userName, potUser, potPass;

const start = document.getElementById("start-button");
const userInput = document.getElementById("user-input");
const potUserInput = document.getElementById("potentialAdminUser");
const potPassInput = document.getElementById("potentialAdminPass");

var leaderboardHtml = document.getElementById("leaderboard");
var adminDiv = document.getElementById("admin-div");
var msg = document.getElementById("msg");


const keyboardKeys = document.querySelectorAll('.key');

//const unknownLetters = unknownString.children; //unknownLetters

keyboardKeys.forEach(keyboardKey => {
    keyboardKey.addEventListener('click', () => {
        //console.log("Check: " + keyboardKey.innerHTML);
        checkLetter(keyboardKey.innerText).then( resu => {
            update(resu, keyboardKey);
        })
        
        //get win, lose or update
    })
});




function verifyStartGameState() {
    userName = userInput.value.trim();
    console.log(userName);

    //console.log(userName == "");
    if (userName !== "") {
        sendUserName(userName);
        location.replace("main.php");

    }
}

function sendUserName(userName) {
    const xmlhttp = new XMLHttpRequest();

    xmlhttp.onreadystatechange = function() {
        if (xmlhttp.readyState == XMLHttpRequest.DONE) {
            if (xmlhttp.status == 200) {
                const res = JSON.parse(xmlhttp.responseText);
                console.log(res.messaged);
            }
        }
    };

    const encodedUserName = encodeURIComponent(userName);
    xmlhttp.open("POST", `./Hangman-api.php?action=sendUserName&userName=${encodedUserName}`, true);
    xmlhttp.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
    xmlhttp.send();
}

function checkIfAdmin(potUser, potPass) {
    potUser = potUserInput.value;
    potPass = potPassInput.value;

    const xmlhttp = new XMLHttpRequest();

    xmlhttp.onreadystatechange = function() {
        if (xmlhttp.readyState == XMLHttpRequest.DONE) {
            if (xmlhttp.status == 200) {
                const res = JSON.parse(xmlhttp.responseText);
                if( res.adminStatus == false) {
                    msg.innerText = "ERROR INCORRECT USER AND OR PASSWORD";
                } else {
                    msg.innerText = "";
                    history.pushState({}, "", "index.php");
                    location.replace(res.adminRedirect);
                }
                
                
            }
        }
    };
    const encodedPotUser = encodeURIComponent(potUser);
    const encodedPotPass = encodeURIComponent(potPass);
    xmlhttp.open("GET", `./Hangman-api.php?action=checkIfAdmin&potUser=${encodedPotUser}&potPass=${encodedPotPass}`, true);
    xmlhttp.send();

}

//have a get request that adds information from server to leaderboard

function getLeaderboard() {
    const xmlhttp = new XMLHttpRequest();

    xmlhttp.onreadystatechange = function() {
        if (xmlhttp.readyState == XMLHttpRequest.DONE) {
            if (xmlhttp.status == 200) {
                const res = JSON.parse(xmlhttp.responseText);

                leaderboardRes = res.leaderboard; 
                // update leaderboard table with leaderboardRes content
                for (let i = 0; i < leaderboardRes.length; i++) {
                    const curRow = leaderboardRes[i];
                    const newRow = document.createElement('tr');

                    const nameCell = document.createElement('td');
                    nameCell.innerText = curRow.player_name;

                    const scoreCell = document.createElement('td');
                    scoreCell.innerText = curRow.score;

                    newRow.appendChild(nameCell);
                    newRow.appendChild(scoreCell);

                    leaderboardHtml.appendChild(newRow);
                    
                }
                
                
            }
        }
    };

    xmlhttp.open("GET", "./Hangman-api.php?action=getLeaderboard", true);
    xmlhttp.send();
}
