<?php 

  session_start();

?>

<html lang="en">
  <head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <script
      src="https://code.jquery.com/jquery-4.0.0.min.js"
      integrity="sha256-OaVG6prZf4v69dPg6PhVattBXkcOWQB62pdZ3ORyrao="
      crossorigin="anonymous"
    ></script>
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
      <div id="login" class="card">
        <div class="card-header p-3 m-0">
          <i class="bi bi-book-half" title="LIBRARY SYSTEM"></i>
          <span class="text-secondary"> version 1.2.0</span>
          <p class="card-title display-6 fw-bold">LIBRARY SYSTEM</p>
          <p class="m-0">Login to access the system</p>
        </div>
        <div class="card-body p-3">
          <form action="login.php" method="POST" class="form m-0">
            <label for="username" class="form-label">Username</label>
            <input
              type="text"
              name="username"
              class="form-control"
              required
              pattern="[a-zA-Z0-9_]+"
            />
            <label for="password" class="form-label">Password</label>
            <div class="input-group">
              <input
                id="input-password"
                type="password"
                name="password"
                class="form-control"
                required
                pattern="[a-zA-Z0-9_]+"
              />
              <button
                type="button"
                id="btn-password-view"
                class="btn btn-secondary"
              >
                <i id="icon-password-view" class="bi bi-eye"></i>
              </button>
            </div>

            <!-- message from login handle -->
            <?php 

              if(isset($_SESSION['message'])) {
                echo '<div class="alert alert-danger mt-3" role="alert">';
                echo '<i class="bi bi-exclamation-triangle-fill me-1"></i>';
                echo '<span>';
                echo htmlspecialchars($_SESSION['message']);
                echo '</span>';
                echo '</div>';
                unset($_SESSION['message']);
              }
              
            ?>


            <div class="mt-3">
              <button type="submit" class="btn btn-primary">Login</button>
              <a href="#" class="btn btn-outline-primary"
                >Request a login to admin</a
              >
            </div>
          </form>
        </div>
      </div>
      <footer
        class="position-absolute bottom-0 start-50 translate-middle-x pb-5 text-center"
      >
        Built by lapollivinicius |
        <a href="https://github.com/lapollivinicius" class="link-light fw-bold"
          >GITHUB</a
        >
      </footer>
    </div>
    <script
      src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/js/bootstrap.bundle.min.js"
      integrity="sha384-FKyoEForCGlyvwx9Hj09JcYn3nv7wiPVlz7YYwJrWVcXK/BmnVDxM+D2scQbITxI"
      crossorigin="anonymous"
    ></script>

    <script defer>
      $("#btn-password-view").click(function () {

        $("#input-password").attr("type", function (index, currentType) {
          return currentType === "password" ? "text" : "password";
        });

        $("#icon-password-view").toggleClass("bi-eye bi-eye-slash-fill");
      });
    </script>

  </body>
</html>
