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
                <?php include_once "../partials/sidebar.php"; ?>

                <div class="col py-3">
                    <form action="Medicijnen.php" method="post">
                        Naam medicijn: <input type="text">
                        <input type="submit">
                    </form>
                    <?php
                    require_once("../php/sql.php");
                    $db = new DataBase();
                    //placeholder variable.
                    //When sessions are implemented we should get this variable from the session instead
                    $medicijn = $db->getPrescriptedMedicineForUser(2);
                    $userinfo = $db-> getUserInfo(2)->fetch();
                    ?>
                    <?php
                    foreach($medicijn as $medic){
                        echo "<div class=\"card\">";
                        echo "<div class=\"card-header\">";
                        echo "<h5>" . $medic['medicijnnaam'] . "</h5>";
                        echo "</div>";
                        echo "<div class=\"card-body\">";
                        echo "<p class=\"card-text\">" . $medic['beschrijving'] . "</p>";
                        echo "<p class=\"card-text\">" . $medic['dosis'] . " mg" . "</p>";
                        echo "</div>";
                        echo "<div class=\"card-footer\">";
                        echo "<p small class=\"card-text\">" . $userinfo['voornaam'] . " " . $userinfo['achternaam'] . " email: " . $userinfo['email'] . "</p>";
                        echo "</div>";
                        echo "</div>";
                    }
                    ?>
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