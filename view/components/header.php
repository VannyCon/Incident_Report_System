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
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <link rel="stylesheet" href="../../css/style.css">
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
</head>
<body class="px-1 px-md-5">
<style>
    
.navbar {
    margin-top: 20px
}

.navbar-brand {
    font-weight: bold;
}

.btn-logout {
    background-color: #dc3545;
    color: white;
}

.dashboard-card {
    background-color: white;
    border-radius: 5px;
    padding: 20px;
    box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
}

.stat-number {
    font-size: 3rem;
    font-weight: bold;
    color: #8B4513;
}

.stat-label {
    color: #6c757d;
}

.action-button {
    background-color: #8B4513;
    color: white;
    border: none;
    padding: 10px;
    border-radius: 5px;
    width: 100%;
    margin-top: 10px;
}

.recent-activities {
    background-color: white;
    border-radius: 8px;
    padding: 20px;
    margin-top: 20px;
}

.stats-container {
    display: flex;
    flex-direction: column;
    height: 100%;
}

.stats-row {
    display: flex;
    flex: 1;
}

.stats-col {
    display: flex;
    flex-direction: column;
    flex: 1;
}

.stats-card {
    flex: 1;
    display: flex;
    flex-direction: column;
    justify-content: center;
}
</style>

<?php 
    // Redirect to login if not logged in
    if (!isset($_SESSION['username']) && $title != "User") {
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
                                    <a class='nav-link ms-3' href='../Dashboard/index.php'>Dashboard</a>
                                </li>
                                <li class='nav-item'>
                                    <a class='nav-link ms-3' href='#'>About</a>
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

