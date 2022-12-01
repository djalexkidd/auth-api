const form = document.getElementById("myForm");
const password = form.password;
const confirmPassword = form.confirmPassword;
let isPasswordMatch = false;
  
confirmPassword.addEventListener("input", () => {
    if (password.value != confirmPassword.value) {
        isPasswordMatch = false;
    } else {
        isPasswordMatch = true;
    }
});
  
form.onsubmit = function () {
    if (isPasswordMatch) {
        return true;
    }
    alert("Les mots de passe ne correspondent pas.");
        return false;
};

const queryString = window.location.search.substring(1);
const statusMessage = document.querySelector(".status");

if (queryString === "status=exists") {
    statusMessage.innerHTML = "L'utilisateur existe déjà";
} else if (queryString === "status=regexed") {
    statusMessage.innerHTML = "L'email est incorrect";
}