/*
Javascript file for the backend

Created by Jürgen K.
https://github.com/juergenweb 
File name: frontendforms.js
Created: 17.07.2022 
*/

/*jslint browser:true */

function openFieldset(event){

    const fieldset_spam = document.getElementById("spam");
    const fieldset_attempts = document.getElementById("failed-attempts");

    if(fieldset_attempts){
        if(fieldset_attempts.classList.contains("InputfieldStateCollapsed")){
            // open the fieldset by removing InputfieldStateCollapsed class attribute
            fieldset_spam.classList.remove("InputfieldStateCollapsed");
            fieldset_attempts.classList.remove("InputfieldStateCollapsed");
        }
    }
}


window.onload = function () {

    const loggin_enable_link = document.getElementById("enable-logging");

    if(loggin_enable_link){

        // add event listener
        loggin_enable_link.addEventListener("click", openFieldset);

    }

};
