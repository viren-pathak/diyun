
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

    function openLoginForm() {
        document.getElementById('login-popup-form').style.display = 'block';
    }

    proBtn.addEventListener('click', function() {
        const isAuthenticated = proBtn.getAttribute('data-authenticated') === '1';
        if (!isAuthenticated) {
            openLoginForm();
            return;
        }
        consForm.style.display = 'none'; // Close cons form if open
        proForm.style.display = 'block';
    });

    consBtn.addEventListener('click', function() {
        const isAuthenticated = consBtn.getAttribute('data-authenticated') === '1';
        if (!isAuthenticated) {
            openLoginForm();
            return;
        }
        proForm.style.display = 'none'; // Close pro form if open
        consForm.style.display = 'block';
    });

    closeBtns.forEach(btn => {
        btn.addEventListener('click', function() {
            btn.parentElement.parentElement.style.display = 'none';
        });
    });

    document.addEventListener('click', function(event) {
        const isProForm = proForm.contains(event.target);
        const isConsForm = consForm.contains(event.target);
        const isProBtn = proBtn.contains(event.target);
        const isConsBtn = consBtn.contains(event.target);

        if (!isProForm && !isProBtn) {
            proForm.style.display = 'none';
        }

        if (!isConsForm && !isConsBtn) {
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