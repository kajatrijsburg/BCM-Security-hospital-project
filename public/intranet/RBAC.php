<?php
require_once("../php/sql.php");
include_once("../partials/session_part.php");
$db = new DataBase();
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
            <div class="col py-3">
                <h1>Gebruikers</h1>
                <div>
                    <form action="RBAC.php" method="post">
                        <input type="hidden" name="search">
                        <button class="btn btn-secondary">Alle Gebruikers</button>
                    </form>
                    <form action="RBAC.php" method="post">
                        <input name="search">
                        <button class="btn btn-success">Zoek</button>
                    </form>

                </div>

                <table class="table">
                    <thead>
                    <tr>
                        <th scope="col">Voornaam</th>
                        <th scope="col">Achternaam</th>
                        <th scope="col">Email adres</th>
                        <th scope="col">Manage</th>
                    </tr>
                    </thead>
                    <?php
                    $searchInput = "";
                    if(!empty($_POST["search"])){
                        $searchInput = $_POST["search"];
                    }
                    $result = $db->getUsers($searchInput);

                    foreach ($result as $row){
                        echo "<tr>";
                        echo "<td>" . $row["voornaam"] . "</td>";
                        echo "<td>" . $row["achternaam"] . "</td>";
                        echo "<td>" . $row["email"] . "</td>";
                        echo "<td> <form action='ManageUser.php' method='post'><input type='hidden' value='" . $row["email"] . "' name='id'><button class='btn btn-success' type='submit'>Manage</button></form></td>";
                        echo "</tr>";
                    }
                    ?>
                </table>
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