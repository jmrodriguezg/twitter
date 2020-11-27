<?php
    include("functions.php");
 
    if ( $_GET['action'] == "loginSignup" ){
        //print_r($_POST);

        $error="";

        if ( !$_POST['email'] ) {
            $error= "El email o correo electronico es requerido.";

        }else if ( !$_POST['password'] ) {
            $error= "El password o contraseña es requerido.";

        }else if ( !filter_var($_POST['email'], FILTER_VALIDATE_EMAIL) ) {
            $error = "Por favor ingrese un email o correo electronico valido.";
        }
        if ($error != ""){
            echo $error;
            exit();
        }


        if ( $_POST['loginActive'] == "0" ){
            //echo "Signup a new user";
            //Check that the email is no already registered

            $query="SELECT id FROM users WHERE email='".mysqli_real_escape_string($link, $_POST['email'])."' LIMIT 1";
            $result=mysqli_query($link, $query);

            if (mysqli_num_rows($result) > 0) {
                $error="El Email indicado ya esta registrado, intente con otro email distinto";
            }else{
                //Create the user
                $query = "INSERT INTO `users` (`email`, `password`) VALUES ('"
                .mysqli_real_escape_string($link, $_POST['email'])."', '"
                .mysqli_real_escape_string($link, $_POST['password'])."')";
                $result = mysqli_query($link, $query);

                if (!$result){                 
                    $error="Hubo un problema en el registro, favor intente nuevamente mas tarde.";
                }else{
                    //store id in session variables
                    $newkey=mysqli_insert_id($link);
                    $_SESSION["id"] = $newkey;

                    //hash the password                    
                    $query="UPDATE `users` SET password='".md5(md5($newkey).$_POST['password'])."' WHERE id=".$newkey." LIMIT 1";
                    $result = mysqli_query($link, $query);                    

                    echo 1;
                }
            }        
        }else{
            //Login user

            $query="SELECT * FROM users WHERE email='".mysqli_real_escape_string($link, $_POST['email'])."' LIMIT 1";
            $result=mysqli_query($link, $query);

            $row=mysqli_fetch_assoc($result);

            if (isset($row)) {

                $hashedPassword = md5(md5($row["id"]).$_POST['password']);

                if($hashedPassword == $row["password"]){
                    echo 1;
                    //store id in session variables
                    $_SESSION["id"] = $row["id"];
                }else{
                    $error="El Password indicado no coincide, intente con otro password distinto";                    
                }
            }else{
                $error="El Email/Password indicado no existe, intente con otra combinacion distinta";
            }
        }
        if ($error != ""){
            echo $error;
            exit();
        }
    }

    if ($_GET['action'] == "toggleFollow") {
        //print_r($_POST);

        $query="SELECT * FROM following WHERE `follower` = "
            .mysqli_real_escape_string($link, $_SESSION['id'])." AND `isfollowing` = "
            .mysqli_real_escape_string($link, $_POST['userId'])." LIMIT 1";
        //echo $query;
        $result=mysqli_query($link, $query);

        if (mysqli_num_rows($result) > 0) {
            //UNFOLLOW THE USER
            $row=mysqli_fetch_assoc($result);
            $deleteQuery="DELETE FROM following WHERE `id` = ".mysqli_real_escape_string($link, $row['id'])." LIMIT 1";
            $deleteResult=mysqli_query($link, $deleteQuery);

            if (isset($deleteResult)) {
                echo 1;
            }
        }else{
            //FOLLOW THE USER
            $insertQuery="INSERT INTO following (`follower`, `isfollowing`) VALUES ("
                .mysqli_real_escape_string($link, $_SESSION['id']).", "
                .mysqli_real_escape_string($link, $_POST['userId'])." )";
            //echo $insertQuery;
            $insertResult=mysqli_query($link, $insertQuery);
            
            if (isset($insertResult)) {
                echo 2;
            }

        }

    }

?>