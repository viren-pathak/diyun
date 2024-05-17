
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



   /*---------------------------------------------
  ------------------- SINGLE DEBATE PAGE  --------------------
  ----------------------------------------------*/

  document.addEventListener('DOMContentLoaded', function() {
    const proBtn = document.querySelector('.add-pro-btn');
    const consBtn = document.querySelector('.add-cons-btn');
    const proForm = document.querySelector('.add-pro-form');
    const consForm = document.querySelector('.add-con-form');
    const closeBtns = document.querySelectorAll('.close-form-btn');
    const charCounts = document.querySelectorAll('.char-count');
    const inputs = document.querySelectorAll('input[name="title"]');

    proBtn.addEventListener('click', function() {
        consForm.style.display = 'none'; // Close cons form if open
        proForm.style.display = 'block';
    });

    consBtn.addEventListener('click', function() {
        proForm.style.display = 'none'; // Close pro form if open
        consForm.style.display = 'block';
    });

    closeBtns.forEach(btn => {
        btn.addEventListener('click', function() {
            btn.parentElement.parentElement.style.display = 'none';
        });
    });

    document.addEventListener('click', function(event) {
        if (!event.target.closest('.add-pro-form') && !event.target.closest('.add-cons-form') && !event.target.closest('.add-pro-btn') && !event.target.closest('.add-cons-btn')) {
            proForm.style.display = 'none';
            consForm.style.display = 'none';
        }
    });

    inputs.forEach(input => {
        input.addEventListener('input', function() {
            const remaining = 500 - input.value.length;
            const charCount = input.nextElementSibling;
            charCount.textContent = `${remaining} characters remaining`;
        });
    });
});