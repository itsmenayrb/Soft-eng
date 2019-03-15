$(function(){

    /*
        Initial Registration Validation
     */

    var error = false;

    $("#requestfullname").focusout(function(){
        checkFullname();
    });

    $("#requestemail").focusout(function(){
        checkEmail();
    });

    $("#requestcontact").focusout(function(){
        checkNumber();
    });

    $("#appointmentDate").focusout(function(){
        checkAppointmentDate();
    });

    $("#appointmentTime").focusout(function(){
        checkAppointmentTime();
    });

    $("#requestpurpose").focusout(function(){
        checkPurpose();
    });

    function checkFullname() {

        var pattern = /^[a-zA-Z., ]*$/;
        var fullname = $("#requestfullname").val();

        if( pattern.test(fullname) && fullname !== "") {

            $("#requestfullname").css("border", "1px solid #2ecc71");
            $("#requestfullname").css("background", "#fff");
            $("#errorFullnameDisplay").hide();

        } else {

            $("#errorFullnameDisplay").html("<small>Invalid name format.</small>");
            $("#errorFullnameDisplay").addClass("text-danger text-center");
            $("#errorFullnameDisplay").show();
            $("#requestfullname").css("border", "1px solid #f25a6b");
            $("#requestfullname").css("background", "#fde8eb");
            error = true;

        }

    }

    function checkEmail() {

        var pattern = /^([\w-\.]+@([\w-]+\.)+[\w-]{2,4})?$/;
        var email = $("#requestemail").val();

        if( pattern.test(email) && email !== "") {

            $("#requestemail").css("border", "1px solid #2ecc71");
            $("#requestemail").css("background", "#fff");
            $("#errorEmailDisplay").hide();

        } else {

            $("#errorEmailDisplay").html("<small>Invalid email address.</small>");
            $("#errorEmailDisplay").addClass("text-danger text-center");
            $("#errorEmailDisplay").show();
            $("#requestemail").css("border", "1px solid #f25a6b");
            $("#requestemail").css("background", "#fde8eb");
            error = true;

        }

    }

    function checkNumber() {

        var pattern = /^[0-9]{10,}$/;
        var number = $("#requestcontact").val();

        if( pattern.test(number) && number !== "") {

            $("#requestcontact").css("border", "1px solid #2ecc71");
            $("#requestcontact").css("background", "#fff");
            $("#errorContactDisplay").hide();

        } else {

            $("#errorContactDisplay").html("<small>Invalid mobile number</small>");
            $("#errorContactDisplay").addClass("text-center text-danger");
            $("#errorContactDisplay").show();
            $("#requestcontact").css("border", "1px solid #f25a6b");
            $("#requestcontact").css("background", "#fde8eb");
            error = true;

        }

    }

    function checkAppointmentDate() {

        var appointmentDate = $("#appointmentDate").val();

        if( appointmentDate !== "") {

            $("#appointmentDate").css("border", "1px solid #2ecc71");
            $("#appointmentDate").css("background", "#fff");
            $("#errorAppointmentDateDisplay").hide();

        } else {

            $("#errorAppointmentDateDisplay").html("<small>Please choose desired date.</small>");
            $("#errorAppointmentDateDisplay").addClass("text-danger text-center");
            $("#errorAppointmentDateDisplay").show();
            $("#appointmentDate").css("border", "1px solid #f25a6b");
            $("#appointmentDate").css("background", "#fde8eb");
            error = true;

        }

    }

    function checkAppointmentTime() {

        var appointmentTime = $("#appointmentTime").val();

        if( appointmentTime !== "") {

            $("#appointmentTime").css("border", "1px solid #2ecc71");
            $("#appointmentTime").css("background", "#fff");
            $("#errorAppointmentTimeDisplay").hide();

        } else {

            $("#errorAppointmentTimeDisplay").html("<small>Please choose desired time.</small>");
            $("#errorAppointmentTimeDisplay").addClass("text-danger text-center");
            $("#errorAppointmentTimeDisplay").show();
            $("#appointmentTime").css("border", "1px solid #f25a6b");
            $("#appointmentTime").css("background", "#fde8eb");
            error = true;

        }

    }

    function checkPurpose() {

        var requestpurpose = $("#requestpurpose").val();

        if( appointmentTime !== "") {

            $("#requestpurpose").css("border", "1px solid #2ecc71");
            $("#requestpurpose").css("background", "#fff");
            $("#errorPurposeDisplay").hide();

        } else {

            $("#errorPurposeDisplay").html("<small>Any reason for appointment?</small>");
            $("#errorPurposeDisplay").addClass("text-danger text-center");
            $("#errorPurposeDisplay").show();
            $("#requestpurpose").css("border", "1px solid #f25a6b");
            $("#requestpurpose").css("background", "#fde8eb");
            error = true;

        }

    }

    $("#appointmentForm").submit(function() {

        error = false;

        checkFullname();
        checkEmail();
        checkNumber();
        checkAppointmentDate();
        checkAppointmentTime();
        checkPurpose();

        if ( error === false ) {

            return true;               

        } else {

            swal("Oops!", "Please fill-up the form correctly!", "error");
            return false;

        }     
    });
});