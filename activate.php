<?php
require("config.php");

//http://www.stevanris.thecompletewebhosting.com/notes/activate.php?email=s.zmajsek%40gmail.com&key=c1cf29bd5d6a0919d018c2dbe4f63f0f
//The user is re-directed to this file after clicking the activation link

//Signup link contains two GET parameters: email and activation key


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
            <h1>Account Activation</h1>
            <?php
            //if email or activation link is not missing we are showing an error
            if(!isset($_GET['email']) || !isset($_GET['key'])){
                echo "<div class='alert alert-danger'><strong>There was an error.Please click on the activation link you received by email.</strong></div>";
            }else {
                $user = new User();
                $db= Db::getConnection();
                //Store them in two variables
                $email = $_GET['email'];
                $key = $_GET['key'];

                //activate the user with activate method
                $user->email = $email;
                $user->activation= $key;

                if($user->activate()){
                    echo "<div class='alert alert-success'><strong>Your account has been activated</strong></div><a class='btn btn-lg btn-success' href='login.php'>Log in</a>";
                }else{
                    echo "<div class='alert alert-danger'><strong>Your account can not be activated.Please try again!</strong></div>";
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

