/*
Template Name: Invoika - Admin & Dashboard Template
Author: Themesbrand
Website: https://Themesbrand.com/
Contact: Themesbrand@gmail.com
File: Password addon Js File
*/

// password addon
(function () {
    ("use strict");
    Array.from(document.querySelectorAll("form .auth-pass-inputgroup")).forEach(
        function (item) {
            Array.from(item.querySelectorAll(".password-addon")).forEach(
                function (subitem) {
                    subitem.addEventListener("click", function (event) {
                        var passwordInput =
                            item.querySelector(".password-input");
                        if (passwordInput.type === "password") {
                            passwordInput.type = "text";
                        } else {
                            passwordInput.type = "password";
                        }
                    });
                }
            );
        }
    );
})();
