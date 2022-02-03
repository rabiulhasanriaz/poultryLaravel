const comName = document.querySelector('#c_name');
const comPhone = document.querySelector('#c_phone');
const comAddress = document.querySelector('#c_address');
const comPassword = document.querySelector('#c_password');

const form = document.querySelector('#signup');


const checkUsername = () => {

    let valid = false;

    // const min = 3,
    //     max = 25;

    const username = comName.value.trim();

    if (!isRequired(username)) {
        showError(comName, 'Company Name cannot be blank.');
    } 
    // else if (!isBetween(username.length, min, max)) {
    //     showError(usernameEl, `Username must be between ${min} and ${max} characters.`)
    // } 
    else {
        showSuccess(comName);
        valid = true;
    }
    return valid;
};



const checkPhone = () => {
    let valid = false;
    const phone = comPhone.value.trim();
    if (!isRequired(phone)) {
        showError(comPhone, 'Phone cannot be blank.');
    } else if (phone.length < 10 ||phone.length < 11) {
        showError(comPhone, 'Phone number should be 10/11 characters')
    } else {
        showSuccess(comPhone);
        valid = true;
    }
    return valid;
};

const checkPassword = () => {

    let valid = false;

    const password = comPassword.value.trim();

    if (!isRequired(password)) {
        showError(comPassword, 'Password cannot be blank.');
    }else {
        showSuccess(comPassword);
        valid = true;
    }

    return valid;
};

const checkAddress = () => {

    let valid = false;

    const address = comAddress.value.trim();

    if (!isRequired(address)) {
        showError(comAddress, 'Address cannot be blank.');
    }else {
        showSuccess(comAddress);
        valid = true;
    }

    return valid;
};



const isEmailValid = (email) => {
    const re = /^(([^<>()\[\]\\.,;:\s@"]+(\.[^<>()\[\]\\.,;:\s@"]+)*)|(".+"))@((\[[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\])|(([a-zA-Z\-0-9]+\.)+[a-zA-Z]{2,}))$/;
    return re.test(email);
};

const isPasswordSecure = (password) => {
    const re = new RegExp("^(?=.*[a-z])(?=.*[A-Z])(?=.*[0-9])(?=.*[!@#\$%\^&\*])(?=.{8,})");
    return re.test(password);
};

const isRequired = value => value === '' ? false : true;
const isBetween = (length, min, max) => length < min || length > max ? false : true;




const showError = (input, message) => {
    // get the form-field element
    const formField = input.parentElement;
    // add the error class
    formField.classList.remove('success');
    formField.classList.add('error');

    // show the error message
    const error = formField.querySelector('small');
    error.textContent = message;
};

const showSuccess = (input) => {
    // get the form-field element
    const formField = input.parentElement;

    // remove the error class
    formField.classList.remove('error');
    formField.classList.add('success');

    // hide the error message
    const error = formField.querySelector('small');
    error.textContent = '';
}


form.addEventListener('submit', function (e) {
    // prevent the form from submitting
    e.preventDefault();


    // validate forms
    let isUsernameValid = checkUsername(),
        isEmailValid = checkPhone(),
        isPasswordValid = checkPassword(),
        isConfirmPasswordValid = checkAddress();

    let isFormValid = isUsernameValid &&
        isEmailValid &&
        isPasswordValid &&
        isConfirmPasswordValid;

    // submit to the server if the form is valid
    if (isFormValid) {

    }
});


const debounce = (fn, delay = 500) => {
    let timeoutId;
    return (...args) => {
        // cancel the previous timer
        if (timeoutId) {
            clearTimeout(timeoutId);
        }
        // setup a new timer
        timeoutId = setTimeout(() => {
            fn.apply(null, args)
        }, delay);
    };
};
// 
form.addEventListener('input', debounce(function (e) {
    switch (e.target.id) {
        case 'c_name':
            checkUsername();
            break;
        case 'c_phone':
            checkPhone();
            break;
        case 'c_password':
            checkPassword();
            break;
        case 'c_address':
            checkAddress();
            break;
    }
}));