<!DOCTYPE html>
<html lang="en" data-bs-theme="light">

<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <meta name="author" content="Library System" />
  <meta
    name="description"
    content="Manage your library, track loans, and monitor book reservations with ease." />
  <!-- META OG
    <meta property="og:type" content="website" />
    <meta property="og:site_name" content="Library System" />
    <meta
      property="og:title"
      content="Library System | A library mananger"
    />
    <meta
      property="og:description"
      content="Manage your library, track loans, and monitor book reservations with ease."
    />
    <meta property="og:url" content="https://librarysystem.live" />
    <meta property="og:image" content="https://librarysystem.live/og.png" />
    <meta name="twitter:card" content="summary_large_image" />
    <meta
      name="twitter:title"
      content="Library System | A library mananger"
    />
    <meta
      name="twitter:description"
      content="Manage your library, track loans, and monitor book reservations with ease."
    />
    <meta name="twitter:image" content="https://librarysystem.live/og.png" />
    -->
  <title>
    Error
  </title>
  <link rel="stylesheet" href="/css/style.css" />
  <link rel="shortcut icon" href="/assets/favicon.ico" type="image/x-icon" />
  <link
    href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/css/bootstrap.min.css"
    rel="stylesheet"
    integrity="sha384-sRIl4kxILFvY47J16cr9ZwB07vP4J8+LH7qKQnuqkuIAvNWLzeN8tE5YBujZqJLB"
    crossorigin="anonymous" />
  <link
    rel="stylesheet"
    href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.13.1/font/bootstrap-icons.min.css" />
  <script
    src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/js/bootstrap.bundle.min.js"
    integrity="sha384-FKyoEForCGlyvwx9Hj09JcYn3nv7wiPVlz7YYwJrWVcXK/BmnVDxM+D2scQbITxI"
    crossorigin="anonymous"></script>
  <script
    src="https://code.jquery.com/jquery-4.0.0.min.js"
    integrity="sha256-OaVG6prZf4v69dPg6PhVattBXkcOWQB62pdZ3ORyrao="
    crossorigin="anonymous"></script>
  <script src="/js/script.js"></script>
  <script>
    const theme = localStorage.getItem("theme");
    if (theme) {
      document.documentElement.setAttribute("data-bs-theme", theme);
    }
  </script>
</head>

<body>
  <main>
    <section class="session min-vh-75 d-flex align-items-center py-5 mt-5">
      <div class="container">
        <div class="wrapper">
          <div class="row justify-content-center text-center">
            <div class="col-12 col-md-8 col-lg-6">
              <div class="mb-4">
                <i class="bi bi-exclamation-triangle text-danger display-1"></i>
              </div>
              <h1 class="display-1 fw-bold text-danger mb-0">ERROR</h1>
              <h2 class="fw-bold mt-3">Uncategorized error</h2>
              <p class="text-secondary mt-3 mb-4">
                We recommend visiting the report page and informing us about what happened.
              </p>
              <div
                class="d-flex flex-column flex-sm-row justify-content-center gap-2">
                <a href="/" class="btn btn-primary px-4">
                  <i class="bi bi-house me-2"></i>
                  Back to home
                </a>
                <a
                  href="https://github.com/lapollivinicius/library_system/issues"
                  target="_blank"
                  class="btn btn-outline-danger px-4">
                  <i class="bi bi-arrow-right me-2"></i>
                  Report
                </a>
              </div>

              <p class="text-secondary small mt-4 mb-0">
                Error: <?php echo $errorMessage ?? 'Not Found' ?>
              </p>
            </div>
          </div>
        </div>
      </div>
    </section>
  </main>
</body>

</html>