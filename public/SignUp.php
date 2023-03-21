<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />

    <link href="style.css" rel="stylesheet">
    <link href="bootstrap/css/bootstrap.min.css" rel="stylesheet">
    <link
        rel="stylesheet"
        href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.3.0/font/bootstrap-icons.css"
    />
    <title>Isla sign Up</title>
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
                    src="Image/logo.svg"
                    height="50"
                    alt=""
                    loading="lazy"
                />
            </a>
            <a class="navbar-brand" href="#">
                <img
                    src="Image/Naamloos.png"
                    height="50"
                    alt=""
                    loading="lazy"
                />
            </a>
        </div>
    </nav>
</header>

<div class="container">
    <div class="row align-items-center">
        <div class="col-sm-12 col-md-12 col-lg-6">
            <form class="border m-3 p-5" method="post" action="<?php echo htmlspecialchars($_SERVER[PHP_SELF]);?>">
                <h1 class="text-center m-3">Account Aanmaken</h1>
                <div class="input-group m-3">
                    <span class="input-group-text" id="inputGroup-sizing-default">Voornaam</span>
                    <input type="text" class="form-control" >
                    <span class="input-group-text" id="inputGroup-sizing-default">Achternaam</span>
                    <input type="text" class="form-control" >
                </div>
                <div class="input-group m-3">
                    <span class="input-group-text" id="inputGroup-sizing-default">Email Adres</span>
                    <input type="email" class="form-control" id="exampleInputEmail1" aria-describedby="emailHelp">
                </div>
                <div class="input-group m-3">
                    <span class="input-group-text" id="inputGroup-sizing-default">Wachtwoord</span>
                    <input type="password" class="form-control" id="exampleInputPassword1">
                </div>
                <div class="input-group m-3">
                    <span class="input-group-text" id="inputGroup-sizing-default">Herhaal Wachtwoord</span>
                    <input type="password" class="form-control" id="exampleInputPassword1">
                </div>
                <button type="submit" class="btn btn-lg btn-success m-3">Maak mijn account</button>
                <div class="container mt-2">
                    <a href="index.php" class="btn btn-sm btn-primary">Log in</a>
                    <a href="index.php" class="btn btn-sm btn-secondary">Terug</a>
                </div>

            </form>
        </div>
    </div>

</div>







<script src="bootstrap/js/bootstrap.bundle.min.js" ></script>


</body>
</html>