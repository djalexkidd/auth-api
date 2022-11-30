const guest_buttons = document.querySelector('.guest');
const member_buttons = document.querySelector('.member');

const APICALL = "http://localhost:7000/back/get_myself.php";

// Création d'une fonction asynchrone
async function isConnected() {
        const reponse = await fetch(APICALL);
        const data = await reponse.json();

        if (data[0].rank === "member") {
            member_buttons.classList.remove("hidden");
            guest_buttons.classList.add("hidden");
        }
}

isConnected();