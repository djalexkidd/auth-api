const APICALL = "http://localhost:7000/back/get_data.php";
const APICALL_user = "http://localhost:7000/back/get_myself.php";
const affichage = document.querySelector('.affichage');

async function isAdmin() {
    try {
        const reponse = await fetch(APICALL_user);
        const data = await reponse.json();
    if (data[0].rank !== "admin") {
        window.location.replace("index.html");
    } else {
        dataTable();
    }
    } catch {
        window.location.replace("index.html");
    }
}

// Création d'une fonction asynchrone
async function dataTable() {
    const reponse = await fetch(APICALL);
    const data = await reponse.json();
    showData(data);
}

function showData(data) {
    for(let i = 0; i < data.length; i++) {
        affichage.innerHTML += `<option value="${data[i].name}">${data[i].name}</option>`;
    }
}

isAdmin();