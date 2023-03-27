<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />

    <link href="css/main.css" rel="stylesheet">
    <link href="style.css" rel="stylesheet">
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
           <?php include_once "../partials/sidebar.php"?>
            <div class="col py-3">
                <div class="container">
                    <div>
                        <h1>Afspraken</h1>
                        <?php
                        //if the relevant permissions exist
                        if (true) {
                            echo "<a class=\"btn btn-success\" href=\"MaakAfspraak.php\">Maak een nieuwe afspraak</a>";
                        }
                        ?>


                    </div>
                    <table class="table">
                        <thead>
                        <th scope="col">Locatie</th>
                        <th scope="col">Online</th>
                        <th scope="col">Datum</th>
                        <th scope="col">Tijd</th>
                        <th scope="col">Specialist</th>
                        </thead>
                        <tbody>
                        <?php
                        require_once("../php/sql.php");
                        $db = new DataBase();
                        $result = $db->getAppointmentsForUser(1); //temp placeholder number, should obtain this from session

                        //render the appointments
                        foreach ($result as $row){
                            echo "<tr>";
                            echo "<td>" . $row["locatie"] . "</td>";
                            if ($row["online"] == 1){
                                echo "<td>Ja</td>";
                            }else{
                                echo "<td>Nee</td>";
                            }
                            echo "<td>" . $row["datum"] . "</td>";
                            echo "<td>" . $row["tijd"] . "</td>";
                            echo "<td>" . $row["achternaam"] . "</td>";
                            echo "</tr>";
                        }

                        $result = null; //clear result
                        ?>
                        </tbody>
                    </table>
                </div>



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

<script src="bootstrap/js/bootstrap.bundle.min.js" ></script>



</body>
</html>