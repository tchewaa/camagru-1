const registerButton = document.getElementById('register-btn');
const forgotPasswordButton = document.getElementById('forgot-pwd-btn');
const resendButton = document.getElementById('resend-btn');
const updateEmailButton = document.getElementById('update-email-btn');
const loadSpinner = document.getElementById('load-spinner');

if (registerButton) {
    registerButton.addEventListener('click', function (e) {
        console.log('clicked');
        loadSpinner.classList.add('loading');
    });
}

if (resendButton) {
    resendButton.addEventListener('click', function (e) {
        loadSpinner.classList.add('loading');
        window.location.reload();
    });
}

if (forgotPasswordButton) {
    forgotPasswordButton.addEventListener('click', function (e) {
        console.log('clicked');
        loadSpinner.classList.add('loading');
    });
}

if (updateEmailButton) {
    updateEmailButton.addEventListener('click', function (e) {
        console.log('clicked');
        // e.preventDefault();
        loadSpinner.classList.add('loading');
        window.location.reload();

    });
}





