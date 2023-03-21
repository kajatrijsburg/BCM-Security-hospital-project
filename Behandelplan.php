<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="UTF-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    
    <link href="css/main.css" rel="stylesheet">
    <link href="style.css" rel="stylesheet">
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
    

       
       
      
   <!-- Container wrapper -->
 </nav>
 <!-- Navbar -->
        <!-- Sidebar -->
        <div class="container-fluid ">
            <div class="row flex-nowrap ">
                <div class="col-auto col-md-3 col-xl-2 px-sm-2 px-0 bg-dark">
                    <div class="d-flex flex-column align-items-center align-items-sm-start px-3 pt-2 text-white min-vh-100">
                        <a href="/" class="d-flex align-items-center pb-3 mb-md-0 me-md-auto text-white text-decoration-none">
                            <span class="fs-5 d-none d-sm-inline">Menu</span>
                        </a>
                        <ul class="nav nav-pills flex-column mb-sm-auto mb-0 align-items-center align-items-sm-start" id="menu">
                            <li class="nav-item">
                                <a href="/" class="nav-link align-middle px-0">
                                    <i class="fs-4 bi-house"></i> <span class="ms-1 d-none d-sm-inline">Dashboard</span>
                                </a>
                            </li>
                            <li>
                                <a href="#" class="nav-link px-0 align-middle">
                                    <i class="fs-4 bi-speedometer2"></i> <span class="ms-1 d-none d-sm-inline">Behandelplan</span> </a>
                                
                            </li>
                            <li>
                                <a href="Afspraken.php" class="nav-link px-0 align-middle">
                                    <i class="fs-4 bi-table"></i> <span class="ms-1 d-none d-sm-inline">Afspraken</span></a>
                            </li>
                            <li>
                                <a href="Medicijnen.php" class="nav-link px-0 align-middle ">
                                    <i class="fs-4 bi-bootstrap"></i> <span class="ms-1 d-none d-sm-inline">Medicijnen</span></a>
                                <ul class="collapse nav flex-column ms-1" id="submenu2" data-bs-parent="#menu">
                                    <li class="w-100">
                                        <a href="#" class="nav-link px-0"> <span class="d-none d-sm-inline">Item</span> 1</a>
                                    </li>
                                    <li>
                                        <a href="#" class="nav-link px-0"> <span class="d-none d-sm-inline">Item</span> 2</a>
                                    </li>
                                </ul>
                            </li>
                        </ul>
                        <hr>
                        <div class="dropdown pb-5">
                            <a href="#" class="d-flex align-items-center text-white text-decoration-none dropdown-toggle pb-5" id="dropdownUser1" data-bs-toggle="dropdown" aria-expanded="false">
                                <img src="https://github.com/mdo.png" alt="hugenerd" width="30" height="30" class="rounded-circle">
                                <span class="d-none d-sm-inline mx-1">loser</span>
                            </a>
                            <ul class="dropdown-menu dropdown-menu-dark text-small shadow">
                                <li><a class="dropdown-item" href="#">New project...</a></li>
                                <li><a class="dropdown-item" href="#">Settings</a></li>
                                <li><a class="dropdown-item" href="#">Profile</a></li>
                                <li>
                                    <hr class="dropdown-divider">
                                </li>
                                <li><a class="dropdown-item" href="#">Sign out</a></li>
                            </ul>
                        </div>
                    </div>
                </div>
                <div class="col py-3">
                    <!--Behandelplan -->
                    <table>
                        <tr>
                            <th>Beschrijving</th>
                            <th>behandelingsperiode</th>
                        </tr>
                        <tr>
                            <?php
                            //foreach ()
                            {
                                //<td></td> geeft patiënt aan (enkel voor de specialisten die de optie hebben te zoeken)
                                //<td></td> beschrijving van het behandelplan
                                //<td></td> de aanmaak en einddatum van het behandelplan
                            }
                            ?>
                        </tr>
                    </table>
                    <!--Voedselplan -->
                    <table>
                        <tr>
                            <th>Beschrijving</th>
                            <th>Voedselplan periode</th>
                        </tr>
                        <tr>
                            <?php
                            //foreach ()
                            {
                                //<td></td> geeft patiënt aan (enkel voor de specialisten die de optie hebben te zoeken)
                                //<td></td> beschrijving van het voedselplan
                                //<td></td> de aanmaak en einddatum van het voedselplan
                            }
                            ?>
                        </tr>
                    </table>
                    <!--Behandelplan specialist (hidden voor patiënt)-->
                    <form>
                        <label>Patiënt browser</label>
                        PatiëntID: <input type="text">
                    </form>
                    <table>
                        <tr>
                            <th>PatiëntID</th>
                            <th>Beschrijving</th>
                            <th>behandelingsperiode</th>
                        </tr>
                        <tr>
                            <?php
                            //foreach ()
                            {
                                //<td></td> geeft patiënt aan (enkel voor de specialisten die de optie hebben te zoeken)
                                //<td></td> beschrijving van het behandelplan
                                //<td></td> de aanmaak en einddatum van het behandelplan
                            }
                            ?>
                        </tr>
                    </table>
                    <input type="button" value="Voeg nieuw behandelplan toe">
                    <form>
                        Voor patiënt: <input type="text">
                        Beschrijving behandeling: <input type="text">
                        beginperiode: <input type="date"> (default = aanmaakdatum)
                        eindperiode:  <input type="date">
                    </form>
                    <!--Voedselplan specialist (hidden voor patiënt)-->
                    <table>
                        <tr>
                            <th>PatiëntID</th>
                            <th>Beschrijving</th>
                            <th>Voedselplan periode</th>
                        </tr>
                        <tr>
                            <?php
                            //foreach ()
                            {
                                //<td></td> geeft patiënt aan (enkel voor de specialisten die de optie hebben te zoeken)
                                //<td></td> beschrijving van het voedselplan
                                //<td></td> de aanmaak en einddatum van het voedselplan
                            }
                            ?>
                        </tr>
                    </table>
                    <input type="button" value="Voeg nieuw voedselplan toe">
                    <form>
                        Voor patiënt: <input type="text">
                        Beschrijving voedselplan: <input type="text">
                        beginperiode: <input type="date"> (default = aanmaakdatum)
                        eindperiode:  <input type="date">
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

    <script
      src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.1/dist/js/bootstrap.bundle.min.js"
      integrity="sha384-gtEjrD/SeCtmISkJkNUaaKMoLD0//ElJ19smozuHV6z3Iehds+3Ulb9Bn9Plx0x4"
      crossorigin="anonymous"
    ></script>
    

  </body>
</html>