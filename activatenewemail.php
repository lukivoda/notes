<?php
require("config.php");

//http://www.stevanris.thecompletewebhosting.com/notes/activatenewemail.php?email=stevanris@gmail.com&newemail=s.zmajsek@gmail.com&key=654574578457845545743575743";
//The user is re-directed to this file after clicking the activation link

//Email uodate link contains three GET parameters: currentemail ,new email and activation key2


?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Account Activation</title>
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
            <h1>Email update</h1>
            <?php
            //if current email,new email or activation link is not missing we are showing an error
            if(!isset($_GET['email']) || !isset($_GET['key']) || !isset($_GET['newemail'])){
                echo "<div class='alert alert-danger'><strong>There was an error.Please click on the activation link you received by email.</strong></div>";
            }else {

                //Store them in three variables
                $email = $_GET['email'];
                $newemail = $_GET['newemail'];
                $key = $_GET['key'];

                //activate the user with activate method
                $user->email = $email;
                $user->activation2= $key;

                if($user->activateNewEmail($newemail)){
                    echo "<div class='alert alert-success'><strong>Your email has been updated!</strong>Please <a class='btn btn-success' href='index.php?logout=1'>log in</a> with your new email</div>";
                }else{
                    echo "<div class='alert alert-danger'><strong>Your email can not be updated.Please try again!</strong></div>";
                }
            }

            ?>

        </div>
    </div>
</div>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.2/jquery.min.js"></script>
<script src="js/bootstrap.min.js"></script>
</body>
</html>