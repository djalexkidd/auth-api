const queryString = window.location.search.substring(1);
const statusMessage = document.querySelector(".status");

if (queryString === "status=incorrect") {
    statusMessage.innerHTML = "Le nom d'utilisateur ou le mot de passe est incorrect";
}