<html lang="en">
  <head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <link
      href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/css/bootstrap.min.css"
      rel="stylesheet"
      integrity="sha384-sRIl4kxILFvY47J16cr9ZwB07vP4J8+LH7qKQnuqkuIAvNWLzeN8tE5YBujZqJLB"
      crossorigin="anonymous"
    />
    <link
      rel="stylesheet"
      href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.13.1/font/bootstrap-icons.min.css"
    />
    <link rel="stylesheet" href="style/style.css" />
    <link rel="shortcut icon" href="assets/favicon.ico" type="image/x-icon" />
    <title>Library System</title>
  </head>
  <body class="text-bg-primary">
    <div class="container">
      <div class="card my-5">

        <!-- header -->
        <div class="card-header p-3 m-0 text-center">
          <i class="bi bi-book-half" title="LIBRARY SYSTEM"></i>
          <span class="text-secondary"> version 1.2.0</span>
          <p class="card-title display-6 fw-bold">LIBRARY SYSTEM</p>

          <!-- nav bar -->
          <nav class="mt-3">
            <ul class="nav nav-pills justify-content-center align-items-center">
              <li class="nav-item">
                <a class="nav-link active" aria-current="page" href="dashboard.php">
                  <i class="bi bi-collection-fill"></i>
                  <span class="d-none d-md-inline">Resume</span>
                </a>
              </li>
              <li class="nav-item">
                <a class="nav-link" href="#">
                  <i class="bi bi-people-fill"></i>
                  <span class="d-none d-md-inline">Users</span>
                </a>
              </li>
              <li class="nav-item">
                <a class="nav-link" href="books.php">
                  <i class="bi bi-book-fill"></i>
                  <span class="d-none d-md-inline">Books</span>
                </a>
              </li>
              <li class="nav-item">
                <a class="nav-link" href="#">
                  <i class="bi bi-arrow-up-right-square-fill"></i>
                  <span class="d-none d-md-inline">Rentals</span>
                </a>
              </li>

              <li class="nav-item dropdown">
                <a
                  class="nav-link dropdown-toggle"
                  data-bs-toggle="dropdown"
                  role="button"
                  aria-expanded="false"
                >
                  <i class="bi bi-gear-fill"></i>
                  <span class="d-none d-md-inline">Setting</span>
                </a>
                <ul class="dropdown-menu">
                  <li><a class="dropdown-item disabled">Reset Password</a></li>
                  <li><hr class="dropdown-divider" /></li>
                  <li><a class="dropdown-item" href="#">Logout</a></li>
                </ul>
              </li>

            </ul>
          </nav>
        </div>

        <!-- body content -->
        <div class="card-body">
          <div id="resume">
            
            <!-- resume - dashboard -->

          </div>
        </div>

      </div>
    </div>
    <script
      src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/js/bootstrap.bundle.min.js"
      integrity="sha384-FKyoEForCGlyvwx9Hj09JcYn3nv7wiPVlz7YYwJrWVcXK/BmnVDxM+D2scQbITxI"
      crossorigin="anonymous"
    ></script>
  </body>
</html>
