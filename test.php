<?php

//echo hash("sha256","Stevan12");

$encryptCookieData = base64_encode("mfPv5C1oLjQhEXCM2DfZ1234");
$decryptCookieData = base64_decode("mfPv5C1oLjQhEXCM2DfZ1234");
$user = explode("mfPv5C1oLjQhEXCM2DfZ123",$decryptCookieData);
print_r($user);
//setcookie('rememberme',$encryptCookieData,time()+15*24*60*60,'/');

