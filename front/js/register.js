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