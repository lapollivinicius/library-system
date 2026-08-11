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
                <a class="nav-link" aria-current="page" href="resume.php">
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
                <a class="nav-link active" href="books.php">
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

        <!-- Books -->
        <div class="card-body">
          <div id="books">
            <div class="row g-4">

              <!-- books -->
              <div class="col-lg-7">
                <div class="card border-0 shadow-sm h-100">
                  <div class="card-body">

                    <!-- header books -->
                    <div
                      class="d-flex justify-content-between align-items-center mb-4"
                    >
                      <div>
                        <h3 class="h5 fw-bold mb-1">Search Books</h3>
                        <p class="text-muted small mb-0">
                          Find a book in the library collection
                        </p>
                      </div>
                      <span class="badge text-bg-light"> 00 books </span>
                    </div>

                    <!-- Search -->
                    <form action="books.php" method="GET" class="form input-group mb-3">
                      <span class="input-group-text bg-white">
                        <i class="bi bi-search"></i>
                      </span>
                      <input
                        type="text"
                        name="search"
                        class="form-control"
                        placeholder="Search by title, author or code"
                      />
                      <button type="submit" class="btn btn-primary">Search</button>
                    </form>

                    <!-- book List -->
                    <div class="mb-4">
                      <table class="table table-hover align-middle mb-0">
                        <thead class="table-light">
                          <tr>
                            <th>Book</th>
                            <th>Author</th>
                            <th class="d-none d-md-table-cell">Genre</th>
                            <th class="d-none d-md-table-cell">Year</th>
                            <th class="text-end">Action</th>
                          </tr>
                        </thead>
                        <tbody>
                          <tr>
                            <td>
                              <div class="fw-semibold">1984</div>
                              <small class="text-muted"> Code: BK-003 </small>
                            </td>
                            <td class="text-muted">George Orwell</td>
                            <td class="d-none d-md-table-cell">
                              <span class="badge text-bg-light">
                                Science Fiction
                              </span>
                            </td>
                            <td class="text-muted d-none d-md-table-cell">1949</td>
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
                        <li class="page-item"><a class="page-link" href="#">1</a></li>
                        <li class="page-item active">
                          <a class="page-link" href="#" aria-current="page">2</a>
                        </li>
                        <li class="page-item"><a class="page-link" href="#">3</a></li>
                        <li class="page-item">
                          <a class="page-link" href="#">Next</a>
                        </li>
                      </ul>
                    </nav>

                  </div>
                </div>
              </div>

              <!-- Register Book -->
              <div class="col-lg-5">
                <div class="card border-0 shadow-sm">
                  <div class="card-body">
                    <div class="mb-4">
                      <h3 class="h5 fw-bold mb-1">Register Book</h3>
                      <p class="text-muted small mb-0">
                        Add a new book to the collection
                      </p>
                    </div>
                    <form>
                      <div class="mb-3">
                        <label for="bookTitle" class="form-label">
                          Title
                        </label>
                        <input
                          type="text"
                          id="bookTitle"
                          name="title"
                          class="form-control"
                          placeholder="Enter book title"
                        />
                      </div>
                      <div class="mb-3">
                        <label for="bookAuthor" class="form-label">
                          Author
                        </label>
                        <input
                          type="text"
                          id="bookAuthor"
                          name="author"
                          class="form-control"
                          placeholder="Enter author name"
                        />
                      </div>
                      <div class="row">
                        <div class="col-md-6 mb-3">
                          <label for="bookYear" class="form-label">
                            Publication Year
                          </label>
                          <input
                            type="number"
                            id="bookYear"
                            name="year"
                            class="form-control"
                            placeholder="e.g. 2020"
                          />
                        </div>
                        <div class="col-md-6 mb-3">
                          <label for="bookCode" class="form-label">
                            Book Code
                          </label>
                          <input
                            type="text"
                            id="bookCode"
                            name="code"
                            class="form-control"
                            placeholder="e.g. BK-001"
                          />
                        </div>
                      </div>
                      <div class="row">
                        <div class="col-md-6 mb-3">
                          <label for="bookGenre" class="form-label">
                            Genre
                          </label>
                          <select id="bookGenre" class="form-select" name="genre">
                            <option selected disabled>Select genre</option>
                            <option>Fiction</option>
                            <option>Fantasy</option>
                            <option>Science Fiction</option>
                            <option>Mystery</option>
                            <option>Biography</option>
                            <option>History</option>
                            <option>Children</option>
                            <option>Other</option>
                          </select>
                        </div>
                        <div class="col-md-6 mb-3">
                          <label for="bookContinent" class="form-label">
                            Continent of Origin
                          </label>
                          <select id="bookContinent" class="form-select" name="continent">
                            <option selected disabled>Select continent</option>
                            <option>Africa</option>
                            <option>Asia</option>
                            <option>Europe</option>
                            <option>North America</option>
                            <option>South America</option>
                            <option>Oceania</option>
                            <option>Antarctica</option>
                          </select>
                        </div>
                      </div>
                      <div class="mb-3">
                        <label for="bookAgeRating" class="form-label">
                          Age Rating
                        </label>
                        <select id="bookAgeRating" class="form-select" name="age">
                          <option selected disabled>Select age rating</option>
                          <option>0+</option>
                          <option>6+</option>
                          <option>10+</option>
                          <option>12+</option>
                          <option>14+</option>
                          <option>16+</option>
                          <option>18+</option>
                        </select>
                      </div>
                      <button type="submit" class="btn btn-primary w-100 mt-3">
                        <i class="bi bi-book-plus me-1"></i>
                        Register Book
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
