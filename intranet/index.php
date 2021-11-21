<html>
<head>
    <title>Hello Intranet!</title>
    <link href="/bootstrap/css/bootstrap.min.css" rel="stylesheet">
    <link href="css/index.css" rel="stylesheet">
    <script src="/bootstrap/js/bootstrap.bundle.min.js"></script>
</head>
<body>
<nav class="navbar navbar-expand-lg navbar-light bg-light" role="navigation">
    <a class="navbar-brand" href="#">
        <img src="/images/logo.png" width="30" height="30" alt="">
    </a>
    <ul class="navbar-nav mr-auto">
        <li class="nav-item"><a href="/" class="nav-link">Home</a></li>
        <li class="nav-item"><a href="/intranet" class="nav-link">Intranet</a></li>
    </ul>
</nav>
<main class="container-fluid">
    <article>
        <section>
            <header>
                <P> Intranet :: It works! </p>
            </header>
            <P>Login gegevens:</P>

            <?
            echo "<P>Gebruiker '" . $_SERVER["AUTHENTICATE_UID"] . "' ingelogd met wachtwoord '" . $_SERVER['PHP_AUTH_PW'] . "'</P>";
            ?>
        </section>
        <section>
            <form action="createNewUser.php" method="post">
                <label for="idUserName">Gebruikersnaam</label>
                <input type="text" name="username" id="idUserName">
                <br/>
                <label for="idVoornaam">Voornaam</label>
                <input type="text" name="voornaam" id="idVoornaam">
                <br/>
                <label for="idAchternaam">Achternaam</label>
                <input type="text" name="achternaam" id="idAchternaam">
                <br/>
                <button type="submit">Opslaan</button>
            </form>
        </section>
    </article>
</main>
<? include_once '../partials/footer.php'; ?>
</body>
</html>
