<?php include_once("../partials/session_part.php"); ?>
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


    <title>Frontend Bootcamp</title>
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
    <div class="container-fluid ">
        <div class="row flex-nowrap ">
            <? include_once '../partials/sidebar.php';?>
            <!-- afhankelijk van permisies als patiënt zal dit worden aangegeven -->
            <div class="card border-dark w-100 h-100">
                <div>
                    <table>
                        <tr>
                            <th>Geplande Behandelingen</th>
                            <th>✖</th>
                            <th>✓</th>
                        </tr>
                        <?php
                        //foreach (ModelItem in databaseModel)
                        {
                            //<tr>
                            //<td></td>  beschrijving van behandeling
                            //<td></td>  radio type input voor weigering (kan de maatregelen genomen niet volgen)
                            //<td></td>  radio type input voor acceptatie (kan doorgaan met de geplande afspraken)
                            //</tr>
                        }
                        ?>
                    </table>
                    <!-- het form hieronder is voor wanneer een specifieke bhenadeling wordt geanuleerd door de patiënt -->
                    <form action="../index.php" method="post">
                        <label>Redenering voor annuleren:</label>
                        <input type="text">
                    </form>
                </div>
                <div>
                    <label>Patiënt Data</label>
                    <div>
                        <label>Gewicht:</label>
                        <label>###</label>
                        <label>Bloeddruk:</label>
                        <label>###</label>
                        <label>Hartslagrust:</label>
                        <label>###</label>
                    </div>
                </div>
            </div>
            <!-- deze moet voor patiënten hidden zijn maar voor experts die behandelen zichtbaar zijn -->
            <div>
                <form action="../index.php" method="post">
                    PatiëntId: <input type="text">
                </form>
                <table>
                    <tr>
                        <th>Handelingen met patiënt:</th>
                        <?php
                        //foreach ()
                        {
                            //<tr>
                            //<td></td> de handelingen als beschreven bij de patiënt voor weergave van de experts
                            //<td></td> de mogelijkheid om een afspraak te verwijderen mocht deze niet uitgevoerd voor wat voor reden maar ook
                            //<tr>
                        }
                        ?>
                    </tr>
                </table>
                <!--redenering naar de patiënt toe voor annuleren specifieke behandeling/afspraak -->
                <form action="../index.php" method="post">
                    <label>Bericht naar patiënt over annuleren</label>
                    <input type="text">
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