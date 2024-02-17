<?php
    $db_name = 'mysql:host=localhost;dbname=nassim_shop';
    $db_user = 'root';
    $db_password = '';

    $conn = new PDO($db_name,$db_user,$db_password);
    
    function uniq_id(){
        $chars ='0123456789';
        $charsLength = strlen($chars);
        $randomString ='';
        for($i=0 ; $i<9 ; $i++){
            $randomString.=$chars[mt_rand(0,$charsLength-1)];
        }
        return $randomString;
    }
?>