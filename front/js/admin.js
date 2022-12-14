const APICALL = "http://localhost:7000/back/get_data.php";
const APICALL_user = "http://localhost:7000/back/get_myself.php";
const APICALL_all_users = "http://localhost:7000/back/get_users.php";
const affichage = document.querySelector('.affichage');
const affichageUsers = document.querySelector('.affichage2');

async function isAdmin() {
    try {
        const reponse = await fetch(APICALL_user);
        const data = await reponse.json();
    if (data[0].rank !== "admin") {
        window.location.replace("index.html");
    } else {
        dataTable();
        dataTable2();
    }
    } catch {
        window.location.replace("index.html");
    }
}

// Création d'une fonction asynchrone pour les fruits
async function dataTable() {
    const reponse = await fetch(APICALL);
    const data = await reponse.json();
    showData(data);
}

// Création d'une fonction asynchrone pour les utilisateurs
async function dataTable2() {
    const reponse = await fetch(APICALL_all_users);
    const data = await reponse.json();
    showDataUsers(data);
}

function showData(data) {
    for(let i = 0; i < data.length; i++) {
        affichage.innerHTML += `<option value="${data[i].name}">${data[i].name}</option>`;
    }
}

function showDataUsers(data) {
    for(let i = 0; i < data.length; i++) {
        affichageUsers.innerHTML += `<option value="${data[i].email}">${data[i].email}</option>`;
    }
}

isAdmin();