/*
 * @Author: David Kelly 
 * @Date: 2017-11-23 15:43:26 
 * @Last Modified by: david
 * @Last Modified time: 2017-11-27 14:42:35
 */

window.onpageshow = function(event) {
    if (event.persisted) {
        window.location.reload() 
    }
};

 // validate(string)
function validate(input) {
    
    let inputValue = document.getElementById(input).value;
    let inputDiv = document.getElementById(input);
    let inputAlertString = "";
    let errorStyle = "border-left: 4px solid red";
    let passStyle = "border-left: 4px solid green";
    let valid = false;
    let specialChars = false;

    specialChars = specialCharacters(inputValue);

    if ((inputValue.length < 6) || (specialChars==true)) {
        inputAlertString="Invalid "+input;
        inputDiv.style = errorStyle;       
    } else { 
        inputAlertString="";
        inputDiv.style = passStyle;
    }

    valid = checkAllInputs(input);
    toggleButtonState(!valid); 
    valid = false; 
    document.getElementById(input+'Alert').innerHTML = inputAlertString;

}

// boolean checkAllInputs()
function checkAllInputs(inputId) {

    let input = document.getElementsByTagName('input');

    for(i = 0; i < input.length; ++i) {
        if ((input[i].value.length < 6) || (specialCharacters(input[i].value)) ) {
            if (inputId == "password_confirm") {
                if (!matchPassword()) {
                    return false;
                }
            }
            return false;
        }
    }
    return true;
}

// toggleButtonState(boolean)
function toggleButtonState(state) {
    document.getElementById('submit').disabled=state;
}

function specialCharacters(inputString) {
    
    if (/[`~,.<>;':"/[\]|{}()=_+-]/.test(inputString)){    
        return true;
    }
}

function matchPassword() {
    pw = document.getElementById('password').value;
    pwc = document.getElementById('password_confirm').value;
    if (pw === pwc) {
        return true;
    } else { return false }
}