<?php
require_once("../php/sql.php");
include_once("../partials/session_part.php");
require_once("../../User.php");
require_once ("../php/clean-input.php");
require_once ("../php/permissies.php");

requirePermission($_SESSION, Permissions::$manageRoles);

$db = new DataBase();

function renderPermissionOption($currentPermissions, $permission){
    echo "<td><select name='$permission' >";
    if( empty( $currentPermissions[$permission])){
        echo "<option value='false'>Nee</option>
                <option value='true'>Ja</option>";
    }
    else {
        echo "<option value='true'>Ja</option>
                <option value='false'>Nee</option>";
    }
    echo "</select></td>";
}
function checkPermission($permissionName){
    if(!empty($_POST[$permissionName])){
        return $_POST[$permissionName] == 'true';
    }
    return false;
}

function addPermissionIfExist(&$permissions, $permission){
    $permissions[$permission] = checkPermission($permission);
}
if(!empty($_POST["roleToEdit"])){
    $permission = [];
    addPermissionIfExist($permission, Permissions::$managePermissions);
    addPermissionIfExist($permission, Permissions::$manageRoles);
    addPermissionIfExist($permission, Permissions::$manageTreatmentPlan);
    addPermissionIfExist($permission, Permissions::$manageAppointments);
    addPermissionIfExist($permission, Permissions::$manageMedication);

    echo $db->updateRolePermissions(trimAndClean($_POST["roleToEdit"]), $permission);
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
    </nav>
    <!-- Navbar -->
    <!-- Sidebar -->
    <div class="container-fluid ">
        <div class="row flex-nowrap ">
            <? include_once '../partials/sidebar.php';?>
            <div class="col py-3">
                <table class="table">
                    <thead>
                        <th>Weizig Rol</th>
                        <th>Rolnaam</th>
                        <th>Beheer Rollen</th>
                        <th>Beheer Permissies</th>
                        <th>Beheer Behandelplan</th>
                        <th>Beheer Afspraken</th>
                        <th>Beheer Medicatie</th>
                    </thead>
                    <?php
                    $roles = Role::getAll();
                    foreach ($roles as $role){
                        $permissions = $db->getRolePermissions($role->name);
                        echo
                            "<tr> 
                                <form action='ManageRoles.php' method='post'>
                                <td> 
                                    <button class='btn btn-success' type='submit'>Weizig
                                  </td>
                                <td> <input class='form-control-plaintext' name='roleToEdit' readonly value=' " . $role->name . "'></td>";

                                renderPermissionOption($permissions, Permissions::$manageRoles);
                                renderPermissionOption($permissions, Permissions::$managePermissions);
                                renderPermissionOption($permissions, Permissions::$manageTreatmentPlan);
                                renderPermissionOption($permissions, Permissions::$manageAppointments);
                                renderPermissionOption($permissions, Permissions::$manageMedication);

                            echo "</tr></form>";

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
