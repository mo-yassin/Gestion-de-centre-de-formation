<?php
    require 'connection.php';
    session_start();
    $id_apprenant = $_SESSION['id_apprenant'];
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
        <link rel="stylesheet" href="assets/css/style.css">
        <title>Formation Pro</title>
    </head>
    <body>
        <header class="p-2">
            <nav class="navbar">
                <div class="container">
                    <img src="assets/images/formationprologo.png" class="navbar-brand" alt="logo" width="200" height="45">
                    <div>
                        <ul class="d-flex justify-content-between">
                            <li><a href="accuiel.php" class="text-reset">Accuiel</a></li>
                            <li><a href="about.php" class="text-reset">About us</a></li>
                            <li>
                                <div class="dropdown">
                                    <button class="btn btn-sm btn-success dropdown-toggle" type="button" id="dropdownMenuButton" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                        Account
                                    </button>
                                    <div class="dropdown-menu" aria-labelledby="dropdownMenuButton">
                                        <a class="dropdown-item" href="registration.php">Mes inscriptions</a>
                                        <a class="dropdown-item" id='logout' href="logout.php" id="submit" name="submit">Log out</a>
                                    </div>
                                </div>
                            </li>
                        </ul>
                    </div>
                </div>
            </nav>
            <div class="container text-center p-4">
                <h1>Welcome to Formation Pro</h1>
                <p>Learn without limits Start, switch, or advance your career with professional Certificates, and degrees</p>
            </div>
        </header>
        <main class="container">
            <section class="row p-4">
                <div class="bg-light rounded p-4">
                    <h5 class="font-weight-bold">Mes formations</h5>
                    <?php
                        $session = $conn->query("SELECT * FROM formation F INNER JOIN session S on F.id_formation = S.id_formation INNER JOIN evaluation ASS ON S.id_session = ASS.id_session WHERE ASS.id_apprenant = '$id_apprenant'");
                        $sessions = $session->fetch_all(MYSQLI_ASSOC);
                        if(count($sessions)>0){
                            foreach ($sessions as $row) {
                                $id = $row['id_formation'];
                                echo '
                                    <div class="card mb-3">
                                        <div class="row g-0">
                                            <div class="col-md-4">
                                                <a href="sessions.php?id='.$id.'"><img src="assets/images/'.$row['image'].'" class="img-fluid rounded-start" alt="..."></a>
                                            </div>
                                            <div class="col-md-8">
                                                <div class="card-body">
                                                    <h6 class="card-title font-weight-bold">'.$row['sujet'].'</h6>
                                                    <p class="card-text">'.$row['description'].'</p>
                                                    <p class="card-text">Masse horaire : '.$row['masse_horaire'].'h</p>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                ';
                            }
                        }
                        else { 
                            ?>
                                <div class="bg-danger p-2 rounded">
                                    <p>Aucune formation enregistrée trouvée.</p>
                                    <p>voir les sessions disponibles à partir d'<a href="accuiel.php">ici</a></p>
                                </div>
                            <?php 
                        } 
                    ?>
                </div>
            </section>
        </main>
        <div class="footer-dark">
            <footer>
                <div class="container">
                    <div class="row">
                        <div class="col-sm-6 col-md-3 item">
                            <h3>Services</h3>
                            <ul>
                                <li>Design</li>
                                <li>Development</li>
                                <li>Réseau</li>
                            </ul>
                        </div>
                        <div class="col-sm-6 col-md-3 item">
                            <h3>About</h3>
                            <ul>
                                <li><a href="accuiel.php" class="text-reset">Accuiel</a></li>
                                <li><a href="about.php" class="text-reset">About us</a></li>
                            </ul>
                        </div>
                        <div class="col-md-6 item text">
                            <h3>Formation Pro</h3>
                            <p>Our platform is dedicated to helping you learn without limits. Whether you're starting your career, switching fields, or looking to advance, we offer a wide range of professional certificates and degrees to suit your needs. Our programs are designed to provide you with the knowledge, skills, and credentials necessary to excel in your chosen industry.</p>
                        </div>
                    </div>
                    <p class="copyright">Formation Pro © 2023</p>
                </div>
            </footer>
        </div>
        <!-- SCRIPTS -->
        <script src="script.js"></script>
        <script src="https://code.jquery.com/jquery-3.4.1.min.js"></script>
        <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.0/dist/umd/popper.min.js"></script>
        <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/js/bootstrap.min.js"></script>
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-kenU1KFdBIe4zVF0s0G1M5b4hcpxyD9F7jL+jjXkk+Q2h455rYXK/7HAuoJl+0I4" crossorigin="anonymous"></script>
    </body>
</html>