const APICALL = "http://localhost:7000/back/get_data.php";
const affichage = document.querySelector('.affichage');

// Création d'une fonction asynchrone
async function dataTable() {
    try {
        const reponse = await fetch(APICALL);
        const data = await reponse.json();
        showData(data);
    } catch {
        affichage.innerHTML += "Connectez-vous pour accéder au contenu de cette page.";
    }
}

function showData(data) {
    for(let i = 0; i < data.length; i++) {
        affichage.innerHTML += `<li>${data[i].name}</li>`;
    }
}

dataTable();