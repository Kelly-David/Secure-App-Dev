function validate(input) {
    
    let inputValue = document.getElementById(input).value;
    let inputDiv = document.getElementById(input);
    let inputAlertString = "";
    let errorStyle = "border-left: 4px solid red";
    let passStyle = "border-left: 4px solid green";
    let state = false;


    if (inputValue.length < 6) {
        inputAlertString="Invalid "+input;
        inputDiv.style = errorStyle;       
    } else {
        inputAlertString="";
        inputDiv.style = passStyle;
    }

    state = checkAllInputs();
    toggleButtonState(!state); 
    state = false; 
    document.getElementById(input+'Alert').innerHTML = inputAlertString;

}

function checkAllInputs() {

    let input = document.getElementsByTagName('input');

    for(i = 0; i < input.length; ++i) {
        if (input[i].value.length < 6 ) {
            return false;
        }
    }
    return true;
}

function toggleButtonState(state) {
    document.getElementById('submit').disabled=state;
}