const guest_buttons = document.querySelector('.guest');
const member_buttons = document.querySelector('.member');
const admin_buttons = document.querySelector('.admin');
const user_status = document.querySelector('.user-status');
const pfp = document.querySelector('.pfp');

const APICALL = "http://localhost:7000/back/get_myself.php";

// Création d'une fonction asynchrone
async function isConnected() {
        const reponse = await fetch(APICALL);
        const data = await reponse.json();

        if (data[0].rank === "member") {
            member_buttons.classList.remove("hidden");
            guest_buttons.classList.add("hidden");

            user_status.innerHTML = "Connecté en tant que " + data[0].email;

            pfp.src = data[0].gravatar + "?s=40";
        } else if (data[0].rank === "admin") {
            member_buttons.classList.remove("hidden");
            guest_buttons.classList.add("hidden");
            admin_buttons.classList.remove("hidden");

            user_status.innerHTML = data[0].email + " 🛠️";

            pfp.src = "https://www.gravatar.com/avatar/" + data[0].gravatar + "?s=40";
        }
}

isConnected();