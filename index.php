<?php 
    include_once('controller/LoginController.php');
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Document</title>
  <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
</head>
<body style="background-color: #f5f5f5;">
  <div class="container p-2">
          <section class="vh-100">
            <div class="container py-2 h-100">
              <div class="row d-flex justify-content-center align-items-center h-100">
                <div class="col-12 col-md-8 col-lg-6 col-xl-5">
                  <div class="card shadow-2-strong" style="border-radius: 1rem;">
                    <div class="card-body p-4 text-left">
                      <div class="text-center">
                          <img src="assets/images/logo.png" alt="" srcset="" width="auto" height="150">
                      </div>
                          <form action="" method="post">
                              <div data-mdb-input-init class="form-outline mb-2">
                              <?php if (isset($_GET['error'])): ?>
                                  <p style="color: red;">Invalid username or password.</p>
                              <?php endif; ?>

                                  <label class="form-label" for="typeEmailX-2">Username</label>
                                      <input type="text" id="typeEmailX-2" name="username" class="form-control form-control-lg" required/>
                                  </div>

                                  <div data-mdb-input-init class="form-outline mb-4">
                                  <label class="form-label" for="typePasswordX-2">Password</label>
                                      <input type="password" id="typePasswordX-2" name="password" class="form-control form-control-lg" required/>
                                  </div>
                                  <input type="hidden" name="action" value="login">
                                  <!-- Checkbox -->
                                  <div class="form-check d-flex justify-content-start mb-4">
                                  <input class="form-check-input" type="checkbox" value="" id="form1Example3" />
                                  <label class="form-check-label" for="form1Example3"> Remember password </label>
                                  </div>

                                  <button data-mdb-button-init data-mdb-ripple-init class="btn btn-primary btn-lg btn-block" type="submit">Login</button>
                          </form>

                    </div>
                  </div>
                </div>
              </div>
            </div>
          </section>
      </div>
  <?php 
      include_once('view/components/footer.php');
  ?>
</body>
</html>

