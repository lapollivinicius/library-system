<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-sRIl4kxILFvY47J16cr9ZwB07vP4J8+LH7qKQnuqkuIAvNWLzeN8tE5YBujZqJLB" crossorigin="anonymous">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.13.1/font/bootstrap-icons.min.css">
    <link rel="stylesheet" href="style/style.css">
    <link rel="shortcut icon" href="assets/favicon.ico" type="image/x-icon">

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
            <div class="card-body p-3 ">
                <form action="login.php" method="POST" class="form m-0">
                    <label for="username" class="form-label">Username</label>
                    <input type="text" name="username" class="form-control" min="8" max="50" required>
                    <label for="password" class="form-label">Password</label>
                    <input type="password" name="password" class="form-control" min="8" max="50" required>

                    <!-- message from login handle -->
                    <div class="alert alert-danger mt-3" role="alert">
                        <i class="bi bi-exclamation-triangle-fill me-1"></i>
                        <span>username or password invalid</span>
                    </div>

                    <div class="mt-3">
                        <button type="submit" class="btn btn-primary" >Login</button>
                        <a href="#" class="btn btn-outline-primary">Request a login to admin</a>
                    </div>
                </form>
            </div>
        </div>
        <footer class="position-absolute bottom-0 start-50 translate-middle-x pb-5 text-center">Built by lapollivinicius | <a href="https://github.com/lapollivinicius" class="link-light fw-bold">GITHUB</a></footer>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/js/bootstrap.bundle.min.js" integrity="sha384-FKyoEForCGlyvwx9Hj09JcYn3nv7wiPVlz7YYwJrWVcXK/BmnVDxM+D2scQbITxI" crossorigin="anonymous"></script>
</body>
</html>