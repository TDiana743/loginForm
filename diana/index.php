<?php 

    $username = $email = $password = '';
    $errors = ['password'=>''];

    if(isset($_POST['submit'])) {
        $username = htmlspecialchars($_POST['username']);
        $email = htmlspecialchars($_POST['email']);
        $password = htmlspecialchars($_POST['password']);

        //password validation
        if(empty($password)) {
            $errors['password'] = 'Password cannot be empty';
        }else{
            if(!preg_match('^(?=.*[a-z])(?=.*[A-Z])(?=.*\d).{8,}$^', $password)){
                $errors['password'] = 'invalid password';
            }
        }

        if(array_filter($errors)) {
            //errors in user input
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

            
            //insert form data in the db
            $insertQuery = "INSERT INTO Patients(patientName, patientEmail, patientPassword) VALUES('$username', '$email', '$password')";

            if(!mysqli_query($con,$insertQuery)){
                die('could not connect'.mysqli_connect_error());
            }

            header('Location:home.php');
            
        }
    }
?>

<html>
    <head>
        <title>Login</title>
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
            background-size: cover;
            background-position: center;
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

        .btn{
            color: green;
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
        
        <form action="index.php" method="POST">

            <h1>Signup</h1>

            <label for="username">Username:</label>
            <input type="text" name="username" value="<?php echo $username; ?>">

            <label for="email">Email:</label>
            <input type="email" name="email" value="<?php echo $email; ?>">

            <label for="password">Password:</label>
            <input type="password" name="password" value="<?php echo $password; ?>">
            <p class="error"><?php echo $errors['password']; ?></p>

            <input type="submit" name="submit" class="btn">

            <a href="login.php">login</a>
        </form>

    </body>
</html>