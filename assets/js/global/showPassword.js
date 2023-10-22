function showPassword(eyeIcon, input){
    const password = document.getElementById(input);
    const type = password.getAttribute('type') === 'password' ? 'text' : 'password';
    password.setAttribute('type', type);

    eyeIcon.classList.toggle('fa-eye');
    eyeIcon.classList.toggle('fa-eye-slash');
}

window.showPassword = showPassword;
