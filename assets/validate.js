/*
 * @Author: David Kelly 
 * @Date: 2017-11-23 15:43:26 
 * @Last Modified by: david
 * @Last Modified time: 2018-02-05 14:50:10
 */

/**
 * @function 
 * @param {event} event 
 */
window.onpageshow = function (event) {
    if (event.persisted) {
        window.location.reload()
    }
};

/**
 * @function validate():void 
 * @param {string} input 
 * @description Validates form input data, toggles alert string and css styles
 */
function validate(input) {
    let inputValue = document.getElementById(input).value;
    let inputDiv = document.getElementById(input);
    let inputAlertString = "";
    let errorStyle = "border-left: 4px solid red";
    let passStyle = "border-left: 4px solid green";
    let valid = false;
    let specialChars = false;

    specialChars = specialCharacters(inputValue);

    if ((inputValue.length < 6) || (specialChars == true) ||
        (input == 'password' && !passwordStrength())) {
        inputAlertString = "Invalid " + input;
        inputDiv.style = errorStyle;
    } else {
        inputAlertString = "";
        inputDiv.style = passStyle;
    }

    valid = checkAllInputs(input);
    toggleButtonState(!valid);
    valid = false;
    document.getElementById(input + 'Alert').innerHTML = inputAlertString;
}

/**
 * @function checkAllInputs():boolean
 * @param {string} inputId 
 * @description Loop over all html input fields
 */
function checkAllInputs(inputId) {

    // let input = document.getElementsByTagName('input');

    // for (i = 0; i < input.length; ++i) {
    //     if (input[i].name != "email" || input[i].name != "dob") {
    //         if ((input[i].value.length < 6) || (specialCharacters(input[i].value))) {
    //             return false;
    //         }
    //         else if (input[i].name == "password_confirm") {
    //             if (!matchPassword()) {
    //                 return false;
    //             }
    //         }
    //         else if (input[i].name == "password") {
    //             if (!passwordStrength()) {
    //                 return false
    //             }
    //         }
    //     }
    // }
    return true;
}

/**
 * @function toggleButtonState():void
 * @param {boolean} state 
 */
function toggleButtonState(state) {
    document.getElementById('submit').disabled = state;
}

/**
 * @function specialCharacters():boolean
 * @param {string} inputString 
 * @description Checks for special characters in user input against regex
 */
function specialCharacters(inputString) {

    if (/[`~,.<>;':"/[\]|{}()=_+-]/.test(inputString)) {
        return true;
    }
}

/** 
 *  @function matchPassword():boolean
 *  @description String comparison between both password inputs
*/
function matchPassword() {
    pw = document.getElementById('password').value;
    pwc = document.getElementById('password_confirm').value;
    if (pw === pwc) {
        return true;
    } else { return false }
}

/** 
 *  @function passwordStrength():boolean
 *  @description Checks password conforms to required format
 */
function passwordStrength() {
    password = document.getElementById('password').value;
    if (password.length < 6) { return false }
    var hasUpperCase = /[A-Z]/.test(password);
    var hasLowerCase = /[a-z]/.test(password);
    var hasNumbers = /\d/.test(password);
    if ((hasUpperCase + hasLowerCase + hasNumbers) < 3) { return false }
    return true;
}