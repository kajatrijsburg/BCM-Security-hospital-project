<?php
require_once("../php/sql.php");
include_once("../partials/session_part.php");
require_once("../../User.php");
require_once ("../php/clean-input.php");

$db = new DataBase();

//validate input
$id =  $_POST["id"];
$id = validateEmail($id);
if (!is_string($id) || empty($id)){
    //die("invalid user id" . $id);
}

//get the user data from LDAP
$user = new User($id);

//get userdata from the db
$db = new DataBase();

$userFromDP = $db->getUser($id);

//check if any data needs to be edited
if (!empty($_POST["editUser"]) && $_POST["editUser"] == "true"){
    //validate input
    $email = validateEmail($_POST["email"]);
    $firstName = validateFirstName($_POST["firstName"]);
    $lastName = validateLastName($_POST["lastName"]);

    //Data is validated

    //todo edit the user data
}

if (!empty($_POST["addRole"]) && $_POST["addRole"]=="true"){
    $roleName = trimAndClean($_POST["roleToAdd"]);
    $role = Role::byName($roleName);
    $user->addRole($role);
}

if (!empty($_POST["removeRole"]) && $_POST["removeRole"]=="true"){
    $roleName = trimAndClean($_POST["roleToRemove"]);
    //we have to extract the name of the role because shit's not properly implemented
    //todo actually fix this
    $equalsPos = strpos($roleName, "=") + 1;
    $len = strpos($roleName, ",") - 3;
    $roleName = substr($roleName, $equalsPos, $len);
    $role = Role::byName($roleName);
    $user->removeRole($role);
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
                <!--
                <form action="ManageUser.php" method="post">
                    <input name="editUser" type="hidden" value="true">
                    <input name="id" type="hidden" value="<? echo $id?>">
                    <div class="form-group">
                        <label>Voornaam:</label>
                        <input name="firstName" class="form-control" value="<? echo $user->firstName?>">
                    </div>
                    <div class="form-group">
                        <label>Achternaam:</label>
                        <input name="lastName" class="form-control" value="<? echo $user->lastName?>">
                    </div>

                    <div class="form-group">
                        <label>Email:</label>
                        <input name="email" class="form-control" value="<? echo $id?>">
                    </div>
                    <button type="submit" class="btn btn-success">Opslaan</button>
                </form>
                -->

                <table class="table">
                    <thead>
                        <th>Rollen</th>
                        <th>Manage</th>
                    </thead>
                    <?php
                    foreach ($user->roles as $role){
                        echo "<tr> <td>" . $role . "</td>" .
                            "<td> 
                                <form action='ManageUser.php' method='post'>
                                <input type='hidden' value='true' name='removeRole'>
                                <input type='hidden' value='$role' name='roleToRemove'>
                                <input type='hidden' value='$id' name='id'>
                                <button class='btn btn-warning' type='submit'>Verwijder
                                </form>
                              </td>
                              </tr>";
                    }
                    ?>
                </table>

                <form action="ManageUser.php" method="post">
                    <input name="addRole" type="hidden" value="true">
                    <input name="id" type="hidden" value="<?echo $id?>">
                    <label for="roleToAdd">Kies en rol om toe te voegen</label>
                    <select class="form-select" name="roleToAdd">
                        <?php
                        $roles = Role::getAll();
                        foreach ($roles as $role) {
                            echo "<option value='$role->name'>" . $role->name . "</option>";
                        }
                        ?>
                    </select>
                    <button type="submit" class="btn btn-success">Voeg toe aan deze gebruiker</button>
                </form>
                <a class="btn btn-secondary" href="RBAC.php">Terug</a>
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
