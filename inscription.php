<?php
    session_start();
    require 'connection.php';
    if(!empty($_SESSION["id_apprenant "])) {
        header("Location: login.php");
    }
    /// check email and phone if something wrong ////
    if(isset($_POST["inscription"])){
        $firstname = $_POST["Nom"];
        $lastname = $_POST["Prenom"];
        $email = $_POST["email"];
        $password = $_POST["password"];
        $confirmation = $_POST["repassword"];

        $duplicate = mysqli_query($conn, "SELECT * FROM `apprenant` WHERE `email_apprenant` = '$email'");
        $row= mysqli_fetch_array($duplicate);

        if($email == $row['email_apprenant'] OR ($firstname == "") OR ($lastname == "") OR ($password == "")) {
            echo "<div class='alert alert-danger'>email already exist OR number,password is empty</div>";
        }
        else {
            if($password == $confirmation) {
                $query = "INSERT INTO apprenant (nom_apprenant , prenom_apprenant, email_apprenant , pswd_apprenant ) VALUES ('$firstname','$lastname' ,'$email' , '$password')";
                mysqli_query($conn, $query);
                $_SESSION["nom_apprenant "]=$firstname;
                header("Location: login.php");
                echo "<div class='alert alert-success'>Registration Successful</div>";
            }
            else {
                echo "<div class='alert alert-danger'>Password Does Not Match</div>";
            }
        }
    }
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://kit.fontawesome.com/972f63b1c4.css" crossorigin="anonymous">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-rbsA2VBKQhggwzxH7pPCaAqO46MgnOM80zW1RWuH61DGLwZJEdK2Kadq2F9CUG65" crossorigin="anonymous">
    <link href="https://fonts.googleapis.com/css?family=Karla:400,700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/css/bootstrap.min.css">
    <link rel="stylesheet" href="assets/css/login.css">
    <title>Formation Pro</title>
</head>
<body>
    <main class="d-flex align-items-center min-vh-100 py-3 py-md-0">
        <div class="container">
            <div class="card login-card">
                <div class="row no-gutters">
                    <div class="col-md-5">
                        <img src="assets/images/trainingcenter.jpg" alt="login" class="login-card-img">
                    </div>
                    <div class="col-md-7">
                        <div class="card-body p-4">
                            <div class="brand-wrapper">
                            <img src="assets/images/formationprologo.png" alt="logo" class="logo">
                            </div>
                            <p class="login-card-description">Inscrivez-vous</p>
                            <form action="" method="POST">
                                <div class="form-group">
                                    <label for="Nom">Nom</label>
                                    <input type="text" name="Nom" id="Nom" class="form-control" placeholder="Nom">
                                </div>
                                <div class="form-group">
                                    <label for="Prenom" >Prenom</label>
                                    <input type="text" name="Prenom" id="Prenom" class="form-control" placeholder="Prenom">
                                </div>
                                <div class="form-group">
                                    <label for="email" >Email</label>
                                    <input type="email" name="email" id="email" class="form-control" placeholder="Email address">
                                </div>
                                <div class="form-group">
                                    <label for="password" >Password</label>
                                    <input type="password" name="password" id="password" class="form-control" placeholder="Password">
                                </div>
                                <div class="form-group">
                                    <label for="password" class="sr-only">Confirm Password</label>
                                    <input type="password" name="repassword" id="repassword" class="form-control" placeholder="Confirm Password">
                                </div>
                                <input name="inscription" id="inscription" class="btn btn-block login-btn mb-2" type="submit" value="Login">
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </main>
    <!-- SCRIPTS -->
    <script src="https://code.jquery.com/jquery-3.4.1.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.0/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/js/bootstrap.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-kenU1KFdBIe4zVF0s0G1M5b4hcpxyD9F7jL+jjXkk+Q2h455rYXK/7HAuoJl+0I4" crossorigin="anonymous"></script>
</body>
</html>