$(function(){

    /*
        Initial Registration Validation
     */

    var error = false;

    $("#registerUser").focusout(function(){
        checkUsername();
    });

    $("#registerEmail").focusout(function(){
        checkEmail();
    });

    $("#registerNumber").focusout(function(){
        checkNumber();
    });

    $("#registerPassword").focusout(function(){
        checkPassword();
    });

    $("#registercPassword").focusout(function(){
        checkcPassword();
    });

    function checkUsername() {

        var pattern = /^[a-zA-Z0-9]{5,}$/;
        var username = $("#registerUser").val();

        if( pattern.test(username) && username !== "") {

            $("#registerUser").css("border", "1px solid #2ecc71");
            $("#registerUser").css("background", "#fff");
            $("#errorUsernameDisplay").hide();

        } else {

            $("#errorUsernameDisplay").html("<small>Username must not contain spaces or special characters and at least five characters.</small>");
            $("#errorUsernameDisplay").addClass("text-danger text-center");
            $("#errorUsernameDisplay").show();
            $("#registerUser").css("border", "1px solid #f25a6b");
            $("#registerUser").css("background", "#fde8eb");
            error = true;

        }

    }

    function checkEmail() {

        var pattern = /^([\w-\.]+@([\w-]+\.)+[\w-]{2,4})?$/;
        var email = $("#registerEmail").val();

        if( pattern.test(email) && email !== "") {

            $("#registerEmail").css("border", "1px solid #2ecc71");
            $("#registerEmail").css("background", "#fff");
            $("#errorEmailDisplay").hide();

        } else {

            $("#errorEmailDisplay").html("<small>Invalid email address.</small>");
            $("#errorEmailDisplay").addClass("text-danger text-center");
            $("#errorEmailDisplay").show();
            $("#registerEmail").css("border", "1px solid #f25a6b");
            $("#registerEmail").css("background", "#fde8eb");
            error = true;

        }

    }

    function checkNumber() {

        var pattern = /^[0-9]{10,}$/;
        var number = $("#registerNumber").val();

        if( pattern.test(number) && number !== "") {

            $("#registerNumber").css("border", "1px solid #2ecc71");
            $("#registerNumber").css("background", "#fff");
            $("#errorNumberDisplay").hide();

        } else {

            $("#errorNumberDisplay").html("<small>Invalid mobile number</small>");
            $("#errorNumberDisplay").addClass("text-center text-danger");
            $("#errorNumberDisplay").show();
            $("#registerNumber").css("border", "1px solid #f25a6b");
            $("#registerNumber").css("background", "#fde8eb");
            error = true;

        }

    }

    function checkPassword() {

        var password = $("#registerPassword").val().length;

        if( password >= 8) {

            $("#registerPassword").css("border", "1px solid #2ecc71");
            $("#registerPassword").css("background", "#fff");
            $("#errorPasswordDisplay").hide();

        } else {

            $("#errorPasswordDisplay").html("<small>Password should at least 8 characters.</small>");
            $("#errorPasswordDisplay").addClass("text-danger text-center");
            $("#errorPasswordDisplay").show();
            $("#registerPassword").css("border", "1px solid #f25a6b");
            $("#registerPassword").css("background", "#fde8eb");
            error = true;

        }

    }

    function checkcPassword() {

        var password = $("#registerPassword").val();
        var cpassword = $("#registercPassword").val();

        if( password === cpassword) {

            $("#registercPassword").css("border", "1px solid #2ecc71");
            $("#registercPassword").css("background", "#fff");
            $("#errorcPasswordDisplay").hide();

        } else {

            $("#errorcPasswordDisplay").html("<small>Password did not match.</small>");
            $("#errorcPasswordDisplay").addClass("text-danger text-center");
            $("#errorcPasswordDisplay").show();
            $("#registercPassword").css("border", "1px solid #f25a6b");
            $("#registercPassword").css("background", "#fde8eb");
            error = true;

        }

    }

    $(".registerForm").submit(function() {

        error = false;

        checkUsername();
        checkEmail();
        checkNumber();
        checkPassword();
        checkcPassword();

        if ( error === false ) {

            return true;               

        } else {

            alert("Please fill up the form correctly.");
            return false;

        }     
    });

    /*
        Setting up of account validation
     */
    
    $("#reg-fname").focusout(function(){
        checkFirstName();
    });

    $("#reg-mname").focusout(function(){
        checkMiddleName();
    });

    $("#reg-lname").focusout(function(){
        checkLastName();
    });

    function checkFirstName() {

        var pattern = /^[a-zA-Z,. ]*$/;
        var firstname = $("#reg-fname").val();

        if( pattern.test(firstname) && firstname !== "") {

            $("#reg-fname").css("border", "1px solid #2ecc71");
            $("#reg-fname").css("background", "#fff");
            $("#errorFirstNameDisplay").hide();

        } else {

            $("#errorFirstNameDisplay").html("<small>Invalid name format. Special characters not allowed.</small>");
            $("#errorFirstNameDisplay").addClass("text-danger mx-lg-2");
            $("#errorFirstNameDisplay").show();
            $("#reg-fname").css("border", "1px solid #f25a6b");
            $("#reg-fname").css("background", "#fde8eb");
            error = true;

        }

    }

    function checkMiddleName() {

        var pattern = /^[a-zA-Z ]*$/;
        var middlename = $("#reg-mname").val();

        if( pattern.test(middlename) && middlename !== "") {

            $("#reg-mname").css("border", "1px solid #2ecc71");
            $("#reg-mname").css("background", "#fff");
            $("#errorMiddleNameDisplay").hide();

        } else {

            $("#errorMiddleNameDisplay").html("<small>Invalid name format. Special characters not allowed.</small>");
            $("#errorMiddleNameDisplay").addClass("text-danger mx-lg-2");
            $("#errorMiddleNameDisplay").show();
            $("#reg-mname").css("border", "1px solid #f25a6b");
            $("#reg-mname").css("background", "#fde8eb");
            error = true;

        }

    }

    function checkLastName() {

        var pattern = /^[a-zA-Z ]*$/;
        var lastname = $("#reg-lname").val();

        if( pattern.test(lastname) && lastname !== "") {

            $("#reg-lname").css("border", "1px solid #2ecc71");
            $("#reg-lname").css("background", "#fff");
            $("#errorLastNameDisplay").hide();

        } else {

            $("#errorLastNameDisplay").html("<small>Invalid name format. Special characters not allowed.</small>");
            $("#errorLastNameDisplay").addClass("text-danger mx-lg-2");
            $("#errorLastNameDisplay").show();
            $("#reg-lname").css("border", "1px solid #f25a6b");
            $("#reg-lname").css("background", "#fde8eb");
            error = true;

        }

    }

    $(".registerSetupForm").submit(function() {

        error = false;

        checkFirstName();
        checkMiddleName();
        checkLastName();

        if ( error === false ) {

            return true;               

        } else {

            swal("Oops!", "Please fill-up the form correctly!", "error");
            return false;

        }     
    });
});