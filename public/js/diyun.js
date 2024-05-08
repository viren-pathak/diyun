
function openLoginForm() {
    var loginForm = document.getElementById("login-popup-form");
    var signupForm = document.getElementById("signup-popup-form");
    if (signupForm.style.display === "block") {
        signupForm.style.display = "none";
    }
    loginForm.style.display = "block";
}

function openSignupForm() {
    var signupForm = document.getElementById("signup-popup-form");
    var loginForm = document.getElementById("login-popup-form");
    if (loginForm.style.display === "block") {
        loginForm.style.display = "none";
    }
    signupForm.style.display = "block";
}

function closeForm() {
    document.getElementById("login-popup-form").style.display = "none";
    document.getElementById("signup-popup-form").style.display = "none";
}

function openMultistepForm() {
    var multistepFormContainer = document.getElementById("multistep-form-container");
    multistepFormContainer.style.display =  "block";
}

function closeMultistepForm() {
    var multistepFormContainer = document.getElementById("multistep-form-container");
    multistepFormContainer.style.display = "none";
}