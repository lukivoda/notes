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
        data:dataWithPost,
        //Ajax call successfull:show error or success message
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
    console.log(dataWithPost);//
    $.ajax({
        //send them to login.php using AJAX
        url: "login.php",
        //we are using POST method
        type:"POST",
        data:dataWithPost,
        //Ajax call successfull:show error or success message
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









//Ajax Call for the login form
//Once the form is submitted

                                                                                                                  //prevent default php processing
     //collect user inputs
     //send them to login.php using AJAX
        //Ajax call successfull:show error or success message
        //Ajax call fails:show Ajax call error