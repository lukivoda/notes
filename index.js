//Ajax Call for the sign up form
//Once the form is submitted
$("#signupform").submit(function(event){
    //prevent default php processing
    event.preventDefault();
    //collect user inputs
    var dataWithPost = $(this).serializeArray();
    //console.log(dataWithPost);//[{name: "username", value: "lukivoda"},{name: "email", value: "stevanris@gmail.com"},{name: "password", value: "Steffi12"},{name: "password2", value: "Steffi12"}]
    $.ajax({
        //send them to signup.php using AJAX
        url: "signup.php",
        //we are using POST method
        type:"POST",
        //the data we are sending to signup.php
        data:dataWithPost,
        //Ajax call successfull:show error or success message
          //data parameter is the data we are receiving from the signup.php
        success:function(data){
            if(data) {
                $("#signupmessage").html(data);
            }
        },
        //Ajax call fails:show Ajax call error
        error:function(){
            $("#signupmessage").html("<div class='alert alert-danger'>There was an error with the ajax call.Please try again later!</div>");
        }
    });
});










//Ajax Call for the login form
//Once the form is submitted
$("#loginform").submit(function(event){
    //prevent default php processing
    event.preventDefault();
    //collect user inputs
    var dataWithPost = $(this).serializeArray();
   // console.log(dataWithPost);//
    $.ajax({
        //send them to login.php using AJAX
        url: "login.php",
        //we are using POST method
        type:"POST",
        //the data we are sending to login.php
        data:dataWithPost,
        //Ajax call successfull:show error or success message
            //data parameter is the data we are receiving from the login.php
        success:function(data){
            if(data == "success") {
              window.location = "mainpageloggedin.php";
            }else{
                $("#loginmessage").html(data);
            }
        },
        //Ajax call fails:show Ajax call error
        error:function(){
            $("#loginmessage").html("<div class='alert alert-danger'>There was an error with the ajax call.Please try again later!</div>");
        }
    });
});





//Ajax Call for the forgotpassword form
//Once the form is submitted
$("#forgotpasswordform").submit(function(event){
    //prevent default php processing
    event.preventDefault();
    //collect user inputs
    var dataWithPost = $(this).serializeArray();
    //console.log(dataWithPost);//
    $.ajax({
        //send them to forgot-password.php using AJAX
        url: "forgot-password.php",
        //we are using POST method
        type:"POST",
        //the data we are sending to forgot-password.php
        data:dataWithPost,
        //Ajax call successfull:show error or success message
           //data parameter is the data we are receiving from the forgot-password.php
        success:function(data){
            $("#forgotpasswordmessage").html(data);
        },
        //Ajax call fails:show Ajax call error
        error:function(){
            $("#forgotpasswordmessage").html("<div class='alert alert-danger'>There was an error with the ajax call.Please try again later!</div>");
        }
    });
});
