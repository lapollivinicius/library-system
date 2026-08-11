<?php

  session_start();

  if (!isset($_SESSION['role']) || $_SESSION['role'] !== 'admin') {
      header('Location: login.php');
      exit;
  };

?>

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
    <main class="container">
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
                <a
                  class="nav-link active"
                  aria-current="page"
                  href="resume.php"
                >
                  <i class="bi bi-collection-fill"></i>
                  <span class="d-none d-md-inline">Resume</span>
                </a>
              </li>
              <li class="nav-item">
                <a class="nav-link" href="users.php">
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
                <a class="nav-link" href="loans.php">
                  <i class="bi bi-arrow-up-right-square-fill"></i>
                  <span class="d-none d-md-inline">Loans</span>
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
                  <li>
                    <hr class="dropdown-divider" />
                  </li>
                  <li><a class="dropdown-item" href="#">Logout</a></li>
                </ul>
              </li>
            </ul>
          </nav>

        </div>

        <!-- resume -->
        <div class="card-body">

          <!-- resume header -->
          <div class="container mb-4">
            <h2 class="h4 fw-bold mb-1">Overview</h2>
            <p class="text-muted mb-0">Library activity from this week</p>
          </div>

          <div class="row g-4">

            <!-- Stats -->
            <div class="col-lg-7">
              <div class="row g-3">
                <div class="col-md-6">
                  <div class="card border-0 shadow-sm h-100">
                    <div class="card-body">
                      <div
                        class="d-flex justify-content-between align-items-start"
                      >
                        <div>
                          <p class="text-muted small mb-2">
                            Delayed Deliveries
                          </p>
                          <h3 class="display-6 fw-bold mb-1">000</h3>
                          <span class="text-danger small">
                            Needs attention
                          </span>
                        </div>

                        <div class="bg-danger-subtle text-danger rounded p-2">
                          <i class="bi bi-exclamation-circle"></i>
                        </div>
                      </div>
                    </div>
                  </div>
                </div>
                <div class="col-md-6">
                  <div class="card border-0 shadow-sm h-100">
                    <div class="card-body">
                      <div
                        class="d-flex justify-content-between align-items-start"
                      >
                        <div>
                          <p class="text-muted small mb-2">Active Loans</p>
                          <h3 class="display-6 fw-bold mb-1">000</h3>
                          <span class="text-success small">
                            Currently borrowed
                          </span>
                        </div>
                        <div class="bg-primary-subtle text-primary rounded p-2">
                          <i class="bi bi-book"></i>
                        </div>
                      </div>
                    </div>
                  </div>
                </div>
                <div class="col-md-6">
                  <div class="card border-0 shadow-sm h-100">
                    <div class="card-body">
                      <div
                        class="d-flex justify-content-between align-items-start"
                      >
                        <div>
                          <p class="text-muted small mb-2">Books Returned</p>
                          <h3 class="display-6 fw-bold mb-1">000</h3>
                          <span class="text-muted small"> This week </span>
                        </div>
                        <div class="bg-success-subtle text-success rounded p-2">
                          <i class="bi bi-arrow-return-left"></i>
                        </div>
                      </div>
                    </div>
                  </div>
                </div>
                <div class="col-md-6">
                  <div class="card border-0 shadow-sm h-100">
                    <div class="card-body">
                      <div
                        class="d-flex justify-content-between align-items-start"
                      >
                        <div>
                          <p class="text-muted small mb-2">Available Books</p>
                          <h3 class="display-6 fw-bold mb-1">000</h3>
                          <span class="text-muted small">
                            Ready to borrow
                          </span>
                        </div>
                        <div class="bg-warning-subtle text-warning rounded p-2">
                          <i class="bi bi-collection"></i>
                        </div>
                      </div>
                    </div>
                  </div>
                </div>
              </div>
            </div>

            <!-- Due Soon -->
            <div class="col-lg-5">
              <div class="card border-0 shadow-sm h-100">
                <div class="card-body">
                  <div
                    class="d-flex justify-content-between align-items-center mb-3"
                  >
                    <div>
                      <h3 class="h5 fw-bold mb-1">Due Soon</h3>
                      <p class="text-muted small mb-0">
                        Books that need to be returned
                      </p>
                    </div>
                    <a href="loans.php" class="small text-decoration-none">
                      See more
                    </a>
                  </div>
                  <div class="border rounded-3 p-3 mb-2">
                    <div
                      class="d-flex justify-content-between align-items-center"
                    >
                      <div class="d-flex align-items-center gap-3">
                        <div class="bg-light rounded p-2">
                          <i class="bi bi-book text-primary"></i>
                        </div>

                        <div>
                          <p class="fw-semibold mb-1">The Little Prince</p>
                          <p class="text-muted small mb-0">Due tomorrow</p>
                        </div>
                      </div>
                      <span class="badge text-bg-warning"> Tomorrow </span>
                    </div>
                  </div>
                  <div class="border rounded-3 p-3 mb-2">
                    <div
                      class="d-flex justify-content-between align-items-center"
                    >
                      <div class="d-flex align-items-center gap-3">
                        <div class="bg-light rounded p-2">
                          <i class="bi bi-book text-primary"></i>
                        </div>
                        <div>
                          <p class="fw-semibold mb-1">Animal Farm</p>
                          <p class="text-muted small mb-0">Due in 3 days</p>
                        </div>
                      </div>
                      <span class="badge text-bg-light"> 3 days </span>
                    </div>
                  </div>
                  <div class="border rounded-3 p-3">
                    <div
                      class="d-flex justify-content-between align-items-center"
                    >
                      <div class="d-flex align-items-center gap-3">
                        <div class="bg-light rounded p-2">
                          <i class="bi bi-book text-primary"></i>
                        </div>
                        <div>
                          <p class="fw-semibold mb-1">1984</p>
                          <p class="text-muted small mb-0">Due in 5 days</p>
                        </div>
                      </div>
                      <span class="badge text-bg-light"> 5 days </span>
                    </div>
                  </div>
                </div>
              </div>
            </div>

          </div>
        </div>
      </div>
    </main>
    <footer class="text-center">
      Built by lapollivinicius |
      <a href="https://github.com/lapollivinicius" class="link-light fw-bold"
        >GITHUB</a
      >
    </footer>
    <script
      src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/js/bootstrap.bundle.min.js"
      integrity="sha384-FKyoEForCGlyvwx9Hj09JcYn3nv7wiPVlz7YYwJrWVcXK/BmnVDxM+D2scQbITxI"
      crossorigin="anonymous"
    ></script>
  </body>
</html>
