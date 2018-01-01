<!--This file receives the user_id and key generated to create the new password-->
<!--This file displays a form to input new password-->
<!--http://www.stevanris.thecompletewebhosting.com/notes/resetpassword.php?user_id=4&key_em=4faa23bd09b4ae6e405787a4f83a6574-->
<?php
include 'config.php';
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Password Reset</title>
    <link href="css/bootstrap.min.css" rel="stylesheet">
    <style>
        h1{
            color:purple;
        }
        .contactForm{
            border:1px solid #7c73f6;
            margin-top: 50px;
            border-radius: 15px;
        }
    </style>

</head>
<body>
<div class="container-fluid">
    <div class="row">
        <div class="col-sm-offset-1 col-sm-10 contactForm">
            <h1>Reset Password:</h1>
            <div id="resultmessage"></div>

        <?php
        //If user_id or key is missing
           if(!isset($_GET['user_id'])  && !isset($_GET['key_em'])){
               echo '<div class="alert alert-danger">There was an error. Please click on the link you received by email.</div>';
               //else
           }else{
               //Store them in two variables
               $user_id = $_GET['user_id'];
               $key_em = $_GET['key_em'];
               $time_d = time() - 86400;
               $db = Db::getConnection();
               $user_id = $db->quote($user_id);
               $key_em = $db->quote($key_em);
               $time_d = $db->quote($time_d);
              //Check combination of user_id & key exists and less than 24h old
              if(!empty($forgotpassword->get("WHERE user_id = $user_id and key_em = $key_em and time > $time_d and status = 'pending' "))) { ?>
                <!--  This form(reset password form with hidden user_id and key fields) is showing only  we have successfull query-->
                  <form method=post id='passwordreset'>
                      <input type=hidden name='key_em' value= <?php echo $key_em ?>>
                      <input type=hidden name='user_id' value=<?php echo $user_id ?>>
                      <div class='form-group'>
                          <label for='password'>Enter your new Password:</label>
                          <input type='password' name='password' id='password' placeholder='Enter Password' class='form-control'>
                      </div>
                      <div class='form-group'>
                          <label for='password2'>Re-enter Password::</label>
                          <input type='password' name='password2' id='password2' placeholder='Re-enter Password' class='form-control'>
                      </div>
                      <input type='submit' name='resetpassword' class='btn btn-success btn-lg' value='Reset Password'>


                  </form>

             <?php }else{//If combination does not exist
                      //show an error message
                  echo "<div class='alert alert-danger'>Please try again.</div>";
              }



           }



            //print reset password form with hidden user_id and key fields
?>



        </div>
    </div>
</div>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.2/jquery.min.js"></script>
<script src="js/bootstrap.min.js"></script>
<!--Script for Ajax Call to storeresetpassword.php which processes form data-->
<script>
    //Ajax Call for the passwordreset form
    //Once the form is submitted
    $("#passwordreset").submit(function(event){
        //prevent default php processing
        event.preventDefault();
        //collect user inputs
        var dataWithPost = $(this).serializeArray();
        //console.log(dataWithPost);//
        $.ajax({
            //send them to storeresetpassword.php using AJAX
            url: "storeresetpassword.php",
            //we are using POST method
            type:"POST",
            //the data we are sending to forgot-password.php
            data:dataWithPost,
            //Ajax call successfull:show error or success message
            //data parameter is the data we are receiving from the storeresetpassword.php
            success:function(data){
                $("#resultmessage").html(data);
            },
            //Ajax call fails:show Ajax call error
            error:function(){
                $("#resultmessage").html("<div class='alert alert-danger'>There was an error with the ajax call.Please try again later!</div>");
            }
        });
    });


</script>
</body>
</html>
