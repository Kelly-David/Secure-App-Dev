/*
 * @Author: David Kelly 
 * @Date: 2017-11-23 15:43:26 
 * @Last Modified by: david
 * @Last Modified time: 2017-11-23 15:49:37
 */

 // validate(string)
function validate(input) {
    
    let inputValue = document.getElementById(input).value;
    let inputDiv = document.getElementById(input);
    let inputAlertString = "";
    let errorStyle = "border-left: 4px solid red";
    let passStyle = "border-left: 4px solid green";
    let valid = false;

    if (inputValue.length < 6) {
        inputAlertString="Invalid "+input;
        inputDiv.style = errorStyle;       
    } else { 
        inputAlertString="";
        inputDiv.style = passStyle;
    }

    valid = checkAllInputs();
    toggleButtonState(!valid); 
    valid = false; 
    document.getElementById(input+'Alert').innerHTML = inputAlertString;

}

// boolean checkAllInputs()
function checkAllInputs() {

    let input = document.getElementsByTagName('input');

    for(i = 0; i < input.length; ++i) {
        if (input[i].value.length < 6 ) {
            return false;
        }
    }
    return true;
}

// toggleButtonState(boolean)
function toggleButtonState(state) {
    document.getElementById('submit').disabled=state;
}