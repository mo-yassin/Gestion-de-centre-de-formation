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
                <p>Learn without limits Start, switch, or advance your career with professional Certificates and degrees</p>
            </div>
        </header>
        <main class="container p-4">
            <section>
                <h4>Details</h4>
                <div class="d-flex rounded details">
                    <?php
                        $id_formation = $_GET['id'];
                        $result = mysqli_query($conn, "SELECT * FROM formation WHERE id_formation = '$id_formation'");
                        $ligne = mysqli_fetch_assoc($result);
                        echo "
                            <div>
                            <img src='assets/images/" .$ligne['image']. "' class='p-1 rounded' width='400' height='300'>
                            </div>
                            <div class='p-4'>
                                <h4><b>".$ligne["sujet"]."</b></h4>
                                <p>".$ligne["description"]."</p>
                                <p><b>Categorie: </b>".$ligne["categorie"]."</p>
                                <p><b>Masse horaire: </b>".$ligne["masse_horaire"]."h</p>
                            </div>
                        ";
                    ?>
                </div>
            </section>
            <hr>
            <section>
                <h4>Sessions</h4>
                <div>
                    <div class="mb-2">
                        <?php
                            if (isset($_POST['join'])) {
                                if(!isset($_SESSION["id_apprenant"])){
                                    header("location:details.php");
                                }
                                else{
                                    $id_apprenant=$_SESSION["id_apprenant"];
                                }
                                $formation = $_POST['id_formation'];
                                $date = $_POST['date_session'];
                                $sql_inscrire = "SELECT * FROM evaluation WHERE id_apprenant = '$id_apprenant' AND DATEDIFF(CURRENT_TIMESTAMP, date_inscription) = 1";
                                $result = mysqli_query($conn, $sql_inscrire);
                                if (mysqli_num_rows($result) == 0) {
                                    $idSession = mysqli_query($conn, "SELECT id_session FROM session WHERE id_formation = '$formation'");
                                    $rowSession = mysqli_fetch_assoc($idSession);
                                    $session = $rowSession["id_session"];
                                    $sql_num = "SELECT COUNT(*) AS count FROM evaluation WHERE id_apprenant = '$id_apprenant'";
                                    $resulte = mysqli_query($conn, $sql_num);
                                    $row = mysqli_fetch_assoc($resulte);
                                    $result = mysqli_query($conn, "SELECT * FROM evaluation WHERE id_session = '$session' AND id_apprenant = '$id_apprenant'");
                                    if (mysqli_num_rows($result) > 0) {
                                        ?>
                                            <div class="bg-danger p-2 rounded">
                                                <p>Vous êtes déjà inscrit pour cette session!</p>
                                            </div>
                                        <?php 
                                    }
                                    else {
                                    $result = mysqli_query($conn, "SELECT * FROM evaluation WHERE id_apprenant = '$id_apprenant'");
                                        if (mysqli_num_rows($result) > 1) {
                                            ?>
                                                <div class="bg-danger p-2 rounded">
                                                    <p>Vous ne pouvez pas vous inscrire à plus de deux sessions!</p>
                                                </div>
                                            <?php
                                        }
                                        else {
                                        $result = mysqli_query($conn, "INSERT INTO evaluation (id_apprenant, id_session, resultat, date_evaluation) VALUES ('$id_apprenant', '$session', NULL, NULL)");
                                            if ($result) {
                                                ?>
                                                    <div class="bg-success p-2 rounded">
                                                        <p>Inscription réussie!</p>
                                                    </div>
                                                <?php
                                            }
                                            else {
                                                ?>
                                                    <div class="bg-danger p-2 rounded">
                                                        <p>Erreur lors de l'inscription.</p>
                                                    </div>
                                                <?php
                                            }
                                        }
                                    }
                                }
                            }
                        ?>
                    </div>
                    <table class="table">
                        <thead class="thead-dark">
                            <tr>
                                <th scope="col">Etat</th>
                                <th scope="col">Max places</th>
                                <th scope="col">Date de début</th>
                                <th scope="col">Date de fin</th>
                                <th scope="col">Formateur</th>
                                <th scope="col">Reservation</th>
                            </tr>
                        </thead>
                        <tbody class="bg-light">
                            <?php
                                $id_formation = $_GET['id'];
                                $result = mysqli_query($conn, "SELECT * FROM session WHERE id_formation = '$id_formation'");
                                while ($ligne1 = mysqli_fetch_assoc($result)) {
                                    $id_session = $ligne1['id_session'];
                                    $etat = $ligne1['etat'];
                                    $max_places = $ligne1['max_places'];
                                    $date_debut = $ligne1['date_debut'];
                                    $date_fin = $ligne1['date_fin'];
                                    // Retrieve the formateur details for the session
                                    $formateur_query = mysqli_query($conn, "SELECT * FROM formateur WHERE id_formateur = (SELECT id_formateur FROM session WHERE id_session = '$id_session')");
                                    $formateur = mysqli_fetch_assoc($formateur_query);
                                    $nom_formateur = $formateur['nom_formateur'];
                                    $prenom_formateur = $formateur['prenom_formateur'];
                                    ?>
                                        <tr>
                                            <th scope='row'><?php echo $etat;?></th>
                                            <td><?php echo $max_places;?></td>
                                            <td><?php echo $date_debut;?></td>
                                            <td><?php echo $date_fin;?></td>
                                            <td><?php echo $nom_formateur;?><span> <?php echo $prenom_formateur;?></span></td>
                                            <td>
                                                <form method='POST'>
                                                    <input type='hidden' name='id_formation' value='<?php echo $id_formation; ?>'>
                                                    <input type='hidden' name='date_session' value='<?php echo $date_debut; ?>'>
                                                    <button type='submit' name="join" class='btn btn-success'>Join</button>
                                                </form>
                                            </td>
                                        </tr>
                                    <?php
                                }
                            ?>
                        </tbody>
                    </table>
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