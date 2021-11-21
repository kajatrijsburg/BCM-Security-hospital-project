<?php
  // FIXME: remove plaintext passwords & databasename
  $user = 'website';
  $pass = 'wachtwoord';
  $connection = new PDO('mysql:host=localhost;dbname=nrg', $user, $pass);

  $SQL = 'SELECT version FROM tbl_configuration;';

  // FIXME: catch errors to prevent SQL-injection problems etc.
  $statement = $connection->prepare($SQL);
  $statement->execute();
  $firstRecord = $statement->fetch();
  $version =  $firstRecord["version"];

  // close connection
  $connection = null;
  $statement = null;
?>

<footer style="display: flex;flex-direction: row;align-items: center;justify-content: center">
    <nav class="navbar navbar-expand-lg navbar-light bg-light" role="navigation">
        <ul class="navbar-nav mr-auto">
            <li class="nav-item"><a href="/disclaimer.html" class="nav-link">Disclaimer</a></li>
            <li class="nav-item"><a href="/contact.html" class="nav-link">Contact</a></li>
        </ul>

    </nav>
    <p style="width:100px">Version <? echo $version ?></p>
</footer>