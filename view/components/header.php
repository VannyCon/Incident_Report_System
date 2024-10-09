<?php 
    include_once('../../../controller/LogoutController.php');
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Nursery Owners</title>
    <!-- Bootstrap CSS CDN -->
    <link rel="stylesheet" href="https://unpkg.com/leaflet@1.7.1/dist/leaflet.css" />
    <script src="https://unpkg.com/leaflet@1.7.1/dist/leaflet.js"></script>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <style>
        #map { height: 500px; width: 98%; margin: 10px}
    </style>
</head>
<body class="px-1 px-md-5" style="background-color: #ebedeb">

<?php 
    // Redirect to login if not logged in
    if (isset($_SESSION['username']) && $title != "User") {
        echo "
                <nav class='navbar navbar-expand-lg navbar-light'>
                    <div class='container-fluid'>
                        <a class='navbar-brand' href='#'><img src='../../../assets/images/logo.png' alt='' srcset='' width='auto' height='100'></a>
                        <button class='navbar-toggler' type='button' data-bs-toggle='collapse' data-bs-target='#navbarNav' aria-controls='navbarNav' aria-expanded='false' aria-label='Toggle navigation'>
                            <span class='navbar-toggler-icon'></span>
                        </button>
                        <div class='collapse navbar-collapse' id='navbarNav'>
                            <ul class='navbar-nav ms-auto'>
                                <li class='nav-item'>
                                    <a class='nav-link ms-3' href='../admin/index.php'>Dashboard</a>
                                </li>
                                <li class='nav-item'>
                                    <a class='nav-link ms-3' href='#'>Report</a>
                                </li>
                                <li class='nav-item'>
                                  <form action='' method='post' class='ms-3'>
                                        <input type='hidden' name='action' value='logout'>
                                        <button class='btn btn-danger btn-md' type='submit'>Logout</button>
                                    </form>
                                </li>
                            </ul>
                        </div>
                    </div>
                </nav>
        ";
    }
?>

