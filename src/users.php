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
                  class="nav-link"
                  aria-current="page"
                  href="resume.php"
                >
                  <i class="bi bi-collection-fill"></i>
                  <span class="d-none d-md-inline">Resume</span>
                </a>
              </li>
              <li class="nav-item">
                <a class="nav-link active" href="users.php">
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

        <!-- Users -->
        <div class="card-body">
          <div id="users">
            <div class="row g-4">
              
              <!-- users -->
              <div class="col-lg-7">
                <div class="card border-0 shadow-sm h-100">
                  <div class="card-body">

                    <!-- header users -->
                    <div
                      class="d-flex justify-content-between align-items-center mb-4"
                    >
                      <div>
                        <h3 class="h5 fw-bold mb-1">Search Users</h3>
                        <p class="text-muted small mb-0">
                          Find a registered library member
                        </p>
                      </div>
                      <span class="badge text-bg-light"> 00 users </span>
                    </div>

                    <!-- search -->
                    <form
                      action="users.php"
                      method="GET"
                      class="form input-group mb-3"
                    >
                      <span class="input-group-text bg-white">
                        <i class="bi bi-search"></i>
                      </span>
                      <input
                        type="search"
                        name="search"
                        class="form-control"
                        placeholder="Search by name, email or document"
                      />
                      <button class="btn btn-primary">Search</button>
                    </form>

                    <!-- user list -->
                    <div class="mb-4">
                      <table class="table table-hover align-middle mb-0">
                        <thead class="table-light">
                          <tr>
                            <th>User</th>
                            <th>Email</th>
                            <th>Phone</th>
                            <th class="text-end">Action</th>
                          </tr>
                        </thead>
                        <tbody>
                          <tr>
                            <td>
                              <div class="d-flex align-items-center gap-2">
                                <div>
                                  <div class="fw-semibold">John Smith</div>
                                  <small class="text-muted">ID: 00124</small>
                                </div>
                              </div>
                            </td>
                            <td class="text-muted">john@example.com</td>
                            <td class="text-muted">+1 555 123 456</td>
                            <td class="text-end">

                              <div class="dropdown">
                                <button
                                  class="btn btn-sm btn-primary dropdown-toggle"
                                  type="button"
                                  data-bs-toggle="dropdown"
                                  aria-expanded="false"
                                >
                                  More
                                </button>
                                <ul class="dropdown-menu dropdown-menu-end">
                                  <li>
                                    <a class="dropdown-item" href="#">
                                      <i class="bi bi-pencil me-2"></i>
                                      Edit
                                    </a>
                                  </li>
                                  <li>
                                    <button class="dropdown-item text-danger" type="button">
                                      <i class="bi bi-trash me-2"></i>
                                      Delete
                                    </button>
                                  </li>
                                </ul>
                              </div>
                            </td>
                          </tr>
                        </tbody>
                      </table>
                    </div>

                    <!-- pagination -->
                    <nav aria-label="...">
                      <ul class="pagination">
                        <li class="page-item disabled">
                          <a class="page-link">Previous</a>
                        </li>
                        <li class="page-item">
                          <a class="page-link" href="#">1</a>
                        </li>
                        <li class="page-item active">
                          <a class="page-link" href="#" aria-current="page"
                            >2</a
                          >
                        </li>
                        <li class="page-item">
                          <a class="page-link" href="#">3</a>
                        </li>
                        <li class="page-item">
                          <a class="page-link" href="#">Next</a>
                        </li>
                      </ul>
                    </nav>

                  </div>
                </div>
              </div>

              <!-- register users -->
              <div class="col-lg-5">
                <div class="card border-0 shadow-sm">
                  <div class="card-body">
                    <div class="mb-4">
                      <h3 class="h5 fw-bold mb-1">Register User</h3>
                      <p class="text-muted small mb-0">
                        Add a new library member
                      </p>
                    </div>
                    <form action="users.php" method="POST">
                      <div class="row">
                        <div class="col-md-6 mb-3">
                          <label for="firstName" class="form-label">
                            First Name
                          </label>
                          <input
                            type="text"
                            name="fisrt-name"
                            id="firstName"
                            class="form-control"
                            placeholder="Enter First name"
                            required
                          />
                        </div>
                        <div class="col-md-6 mb-3">
                          <label for="lastName" class="form-label">
                            Last Name
                          </label>
                          <input
                            type="text"
                            id="lastName"
                            name="last-name"
                            class="form-control"
                            placeholder="Enter Last name"
                            required
                          />
                        </div>
                      </div>
                      <div class="mb-3">
                        <label for="userEmail" class="form-label">
                          Email
                        </label>
                        <input
                          type="email"
                          id="userEmail"
                          name="email"
                          class="form-control"
                          placeholder="name@example.com"
                          required
                        />
                      </div>
                      <div class="row">
                        <div class="col-md-6 mb-3">
                          <label for="userDocument" class="form-label">
                            Document 
                          </label>
                          <input
                            type="text"
                            id="userDocument"
                            name="document"
                            class="form-control"
                            placeholder="CPF or RG"
                            required
                          />
                        </div>
                        <div class="col-md-6 mb-3">
                          <label for="userPhone" class="form-label">
                            Phone
                          </label>
                          <input
                            type="tel"
                            id="userPhone"
                            name="phone"
                            class="form-control"
                            placeholder="Phone number"
                            required
                          />
                        </div>
                      </div>
                      <div class="mb-3">
                        <label for="userAddress" class="form-label">
                          Address
                        </label>
                        <input
                          type="text"
                          id="userAddress"
                          name="andress"
                          class="form-control"
                          placeholder="Enter full address"
                          required
                        />
                      </div>
                      <div class="mb-4">
                        <label for="userBirthDate" class="form-label">
                          Date of Birth
                        </label>
                        <input
                          type="date"
                          id="userBirthDate"
                          name="birth-date"
                          class="form-control"
                          required
                        />
                      </div>
                      <button type="submit" class="btn btn-primary w-100">
                        <i class="bi bi-person-plus me-1"></i>
                        Register User
                      </button>
                    </form>
                  </div>
                </div>
              </div>

            </div>
          </div>
        </div>

      </div>
    </main>
    <footer class="text-center mb-5">
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
