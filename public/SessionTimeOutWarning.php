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
    <title>Frontend Bootcamp</title>
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
        <div class="row">
            <div class="col-12">
                <figure class="text-center mb-5">
                    <h1 class="display-1">Uw sessie is verlopen, voer uw credentials in om een nieuwe sessie te starten</h1>
                    <p class="lead">
log in om uw sessie te verniewen
</p>
                    <a class="btn btn-primary btn-lg" href="intranet/session.php">Log In</a>
                </figure>
            </div>
        </div>
    </div>

    <script src="bootstrap/js/bootstrap.bundle.min.js" ></script>


  </body>
</html>