<?php
    session_start();
    require 'connection.php';

    if (isset($_POST["login"])) {
        $email = $_POST["email"];
        $password = $_POST["password"];

        $result = mysqli_query($conn, "SELECT * FROM apprenant WHERE email_apprenant = '$email'");
        $row = mysqli_fetch_assoc($result);

        if (mysqli_num_rows($result) > 0) {
            if ($password == $row['pswd_apprenant']) {
                $_SESSION["id_apprenant"] = $row["id_apprenant"];
                header("Location: accuiel.php");
            }
            else{
                $password_error = true;
            }
        }
        else{
            $email_error = true;
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
    <style>
        .error-border {
            border: 1px solid red !important;
        }
    </style>
</head>
<body>
    <main class="d-flex align-items-center min-vh-100 py-3 py-md-0">
        <div class="container">
            <div class="card login-card">
                <div class="row no-gutters">
                    <div class="col-md-5">
                        <img src="assets/images/trainingcenter.jpg" alt="login" class="login-card-img">
                    </div>
                    <div class="col-md-7 mb-lg-2">
                        <div class="card-body">
                            <div class="brand-wrapper">
                            <img src="assets/images/formationprologo.png" alt="logo" class="logo">
                            </div>
                            <p class="login-card-description">Connectez-vous à votre compte</p>
                            <form action="" method="POST">
                                <div class="form-group">
                                    <label for="email">Email</label>
                                    <input type="email" name="email" id="email" class="form-control <?php if (isset($_POST["login"]) && isset($email_error)) { echo "error-border"; } ?>" placeholder="Email address">
                                </div>
                                <div class="form-group">
                                    <label for="password">Password</label>
                                    <input type="password" name="password" id="password" class="form-control <?php if (isset($_POST["login"]) && isset($password_error)) { echo "error-border"; } ?>" placeholder="***********">
                                </div>
                                <input name="login" id="login" class="btn btn-block login-btn mb-4" type="submit" value="Login">
                            </form>
                            <p class="login-card-footer-text">Vous n'avez pas de compte ? <a href="accuiel.php" class="text-reset">Inscrivez-vous ici</a></p>
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