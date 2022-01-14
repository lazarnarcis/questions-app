var form_event = null;
var button_event = null;

function changeName(button, form) {
    if (form_event == null && button_event == null) {
        openChangeName(form, button);
    } else {
        openChangeName(button_event, form_event);
        openChangeName(form, button);
    }
    form_event = form;
    button_event = button;
}

function openChangeName(form, button) {
    document.getElementById(form).style.transform = "scaleX(1)";
    if (document.getElementById(form).style.transform == "scaleX(1)") {
        document.getElementById(form).style.display = "inline";
    }
    document.getElementById(button).style.transform = "scaleX(0)";
    if (document.getElementById(button).style.transform == "scaleX(0)") {
        document.getElementById(button).style.display = "none";
    }
}