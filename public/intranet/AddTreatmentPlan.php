<?php
require_once("../php/sql.php");
include_once("../partials/session_part.php");
require_once ("../php/permissies.php");
requirePermission($_SESSION, Permissions::$manageTreatmentPlan);

$db = new DataBase();
if(!empty( $_POST["id"])){
    $id =  $_POST["id"];
}else{
    header('location: ' . 'http://energy.org/intranet/Behandelplan.php', true);
    die("missing user id");
}

//if a treatment plan exists, get it
$plan = $db->getTreatmentPlanForUser($id)->fetch();
$description = "";
if(!empty($plan)){
    $description = $plan['beschrijving'];
}


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
                <form method="post" action="../php/process-treatment-plan.php">
                    <input class="form-select" name="user" type="hidden" value="<?echo $id?>">
                    <div class="form-group">
                        <label class="form-label">Behandelplan</label>
                        <textarea name="description" class="form-control" rows="10"> <? echo $description?> </textarea>
                    </div>
                    <div class="form-group m-3">
                        <button type="submit" class="btn btn-success">Opslaan</button>
                    </div>

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
    </html><?php
