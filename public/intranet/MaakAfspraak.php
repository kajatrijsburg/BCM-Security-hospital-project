<?php
require_once("php/sql.php");
$db = new DataBase();
$patienten  = $db->getPatientsForSpecialist(1)
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />

    <link href="css/main.css" rel="stylesheet">
    <link href="../style.css" rel="stylesheet">
    <link href="/bootstrap/css/bootstrap.min.css" rel="stylesheet">
    <link
        rel="stylesheet"
        href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.3.0/font/bootstrap-icons.css"
    />

    <title>ESALA</title>
</head>
<body>
<header>
    <!-- Navbar -->
    <nav
        id="main-navbar"
        class="navbar navbar-expand-lg navbar-light bg-danger top"
    >
        <!-- Container wrapper -->
        <div class="container-fluid d-flex justify-content-center">


            <!-- Brand -->
            <a class="navbar-brand" href="#">
                <img
                    src="../Image/logo.svg"
                    height="50"
                    alt=""
                    loading="lazy"
                />
            </a>
            <a class="navbar-brand" href="#">
                <img
                    src="../Image/Naamloos.png"
                    height="50"
                    alt=""
                    loading="lazy"
                />
            </a>





            <!-- Container wrapper -->
    </nav>
    <!-- Navbar -->
    <!-- Sidebar -->
    <div class="container-fluid ">
        <div class="row flex-nowrap ">
            <? include_once '../partials/sidebar.php';?>
            <!--APPOINTMENT FORM -->
            <div class="col py-3">
                <h1>Maak een nieuwe afspraak</h1>
                <form method="post" action="../php/process-new-Appointment.php">
                    <div class="form-row">
                        <div class="col-md-6 mb-3">
                            <label for="inputLocatie">Locatie</label>
                            <input type="text" class="form-control" id="inputLocatie" name="inputLocatie" placeholder="locatie" required>
                        </div>
                    </div>
                    <div class="form-row">
                        <div class="col-md-6 mb-3">
                            <label for="inputOnline">Virtuele afspraak</label>
                            <select class="form-control" id="inputOnline" name="inputOnline" required>
                                <option value="1">Ja</option>
                                <option value="0">Nee</option>
                            </select>
                        </div>
                    </div>
                    <div class="form-row">
                        <div class="col-md-6 mb-3">
                            <label for="inputDatum">Datum</label>
                            <input class="form-control" type="date" id="inputDatum" name="inputDatum" min="2000-01-01" max="9999-12-31" required>
                        </div>
                    </div>
                    <div class="form-row">
                        <div class="col-md-6 mb-3">
                            <label for="inputTijd">Tijd</label>
                            <input class="form-control" type="time" id="inputTijd" name="inputTijd" min="08:00" max="18:00" required>
                            <small>Open van 08:00 tot 18:00</small>
                        </div>
                    </div>
                    <div class="form-row">
                        <div class="col-md-6 mb-3">
                            <label for="inputPatient">Patient</label>
                            <select class="form-control" id="inputPatient" name="inputPatient" required>
                                <?php
                                foreach ($patienten as $patient){
                                    echo "<option value=\"" . $patient['userid'] . "\">" . $patient['voornaam'] . " " . $patient["achternaam"] . "</option>";
                                }
                                ?>
                            </select>
                        </div>
                    </div>
                    <button class="btn btn-success" type="submit">Maak Afspraak</button>
                    <a class="btn btn-secondary" href="Afspraken.php">Terug</a>
                </form>
            </div>
        </div>
    </div>
    <!-- Sidebar -->

</header>
<!--Main Navigation-->

<!--Main layout-->
<main style="margin-top: 58px">
    <div class="container pt-4">

    </div>
</main>

<script src="../bootstrap/js/bootstrap.bundle.min.js" ></script>



</body>
</html>