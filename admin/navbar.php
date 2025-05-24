<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8">
  <title>Contoh Navbar</title>
  <style>
    .nav-link {
      color: #FFFFFF !important;
    }

    .nav-link:hover {
      color: #987070 !important;
    }
  </style>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>

  <nav class="navbar navbar-expand-lg" style="background-color: #C39898;">
    <div class="container">
      <button class="navbar-toggler" type="button" data-bs-toggle="collapse"
              data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent"
              aria-expanded="false" aria-label="Toggle navigation">
        <span class="navbar-toggler-icon"></span>
      </button>
      <div class="collapse navbar-collapse" id="navbarSupportedContent">
        <ul class="navbar-nav me-auto mb-2 mb-lg-0">
          <li class="nav-item me-3">
            <a class="nav-link" href="../admin">Home</a>
          </li>
          <li class="nav-item me-3">
            <a class="nav-link" href="kategori.php">Kategori</a>
          </li>
          <li class="nav-item me-3">
            <a class="nav-link" href="produk.php">Produk</a>
          </li>
        </ul>
          <ul class="navbar-nav ms-auto mb-2 mb-lg-0">
            <li class="nav-item">
            <a class="nav-link" href="logout.php">Logout</a>
      </div>
    </div>
  </nav>

</body>
</html>