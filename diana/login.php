<?php

    $username = $password = '';
    $errors = array('password' => '');
    if(isset($_POST['login'])){

        $username = htmlspecialchars($_POST['username']);
        $password = htmlspecialchars($_POST['password']);

        //PASSWORD VERIFICATION
        if(empty($password)){
            $errors['password'] = 'Password cannot be empty';
        }else{

            if(!preg_match('^(?=.*[a-z])(?=.*[A-Z])(?=.*\d).{8,}$^', $password)){
                $errors['password'] = 'password is Invalid type';
            }else{
                //all is valid
            }
        }

        if(array_filter($errors)){
            //input has errors and wont execute
        }else{

            $con = mysqli_connect("Localhost", "root", "");
            if(!$con) {
                die('could not connect'.mysqli_connect_error());
            }

            //create database
            $sql = "CREATE DATABASE IF NOT EXISTS myDatabase";

            if(!mysqli_query($con, $sql)) {
                echo "Error creating database". mysqli_connect_error();
            }

            //create table
            mysqli_select_db($con, "myDatabase");
            $sqlTable = "CREATE TABLE IF NOT EXISTS Patients(
                pNo int not null auto_increment, PRIMARY KEY(PNo), patientName varchar(50), patientEmail varchar(50), 
                patientPassword varchar(50) 
            )";

            //execute querry
            if(!mysqli_query($con, $sqlTable)){
                echo "Error creating table".mysqli_connect_error();
            }
            
            //retrieving from db

            $sql = "SELECT * FROM Patients WHERE patientName = '$username' AND patientPassword = '$password'";

            $result = mysqli_query($con, $sql);

            if(mysqli_num_rows($result) > 0){
                //echo 'success';
                header('Location:home.php');
            }else{
                $errors['password'] = 'Wrong Username/password';
            }
        }

    }

?>

<html>
    <head>
        <title>Warra pl</title>

        <style>
        *{
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body{
            height: 100vh;
            width: 100%;
            font-family: sans-serif;
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: center;
        }

        form{
            display: flex;
            flex-direction: column;
            justify-content: center;
            border: 3px solid #000;
            border-radius: 5px;
            padding: 20px;
            backdrop-filter: blur(20px);
        }

        input{
            margin: 20px 0;
            height: 30px;
            width: 250px;
        }

        label{
            font-weight: bold;
        }

        .btn{
            color: #fff;
            font-weight: bold;
            background: #000;
            border: 2px solid #000;
            transition: .5s ease;
        }

        .error{
            color: red;
        }


    </style>

    </head>

    <body>
        
        <form action="login.php" method="POST">

            <h1>Login</h1>
            <label for="username">Username:</label>
            <input type="text" name="username" value="<?php echo $username; ?>">

            <label for="password">Password:</label>
            <input type="password" name="password" value="<?php echo $password; ?>">
            <p class="error"><?php echo $errors['password']; ?></p>

            <input type="submit" name="login" class="btn">
            <a href="index.php">signup</a>

        </form>

    </body>
</html>