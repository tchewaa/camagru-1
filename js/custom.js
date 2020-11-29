const registerButton = document.getElementById('register-btn');
const forgotPasswordButton = document.getElementById('forgot-pwd-btn');
const resendButton = document.getElementById('resend-btn');
const loadSpinner = document.getElementById('load-spinner');

if (registerButton) {
    registerButton.addEventListener('click', function (e) {
        console.log('clicked');
        loadSpinner.classList.add('loading');
    });
}

if (resendButton) {
    resendButton.addEventListener('click', function (e) {
        console.log('clicked');
        loadSpinner.classList.add('loading');
    });
}

if (forgotPasswordButton) {
    forgotPasswordButton.addEventListener('click', function (e) {
        console.log('clicked');
        loadSpinner.classList.add('loading');
    });
}





