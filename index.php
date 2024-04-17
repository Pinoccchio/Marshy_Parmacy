<?php
ob_start();
require_once('includes/load.php');
if($session->isUserLoggedIn(true)) { 
    redirect('home.php', false);
}
?>

<?php include_once('layouts/header.php'); ?>

<style>
.fullscreen {
    height: 100vh;
    display: flex;
    justify-content: center;
    align-items: center;
}

.content {
    padding: 50px; 
    background-color: #fff; 
    border-radius: 10px; 
    box-shadow: 0px 0px 10px rgba(0, 0, 0, 0.1); 
    margin-right: 20px;
    width: 100%; 
    max-width: 500px; 
}

.form-box-login {
    width: 100%;
    max-width: 350px; 
}

.input-box {
    position: relative;
    margin-bottom: 20px; 
}

.input-box input {
    width: 100%;
    padding: 10px;
    border: 1px solid #ccc;
    border-radius: 5px;
}

.input-box .icon-1 {
    position: absolute;
    top: 50%;
    transform: translateY(-50%);
    left: 10px;
}

.input-box .icon-1 {
    right: 10px;
    left: auto;
}

.input-box .icon-2 {
    position: absolute;
    top: 50%;
    transform: translateY(-50%);
    left: 10px;
}

.input-box .icon-2 {
    right: 10px;
    left: auto;
}
</style>

<div class="container-fluid p-0">
  <div class="row no-gutters fullscreen">
    <div class="col-lg-5 d-none d-lg-block">
      <div class="background-image"></div>
    </div>

    <div class="col-lg-7">
      <div class="content">
        <div class="form-box-login">
          <form id="loginForm" method="post" action="auth.php" class="clearfix">
            <h2>LOGIN</h2>
            <?php echo display_msg($msg); ?>

            <div class="input-box">
              <span class="icon-1"><i class='bx bxs-envelope'></i></span>
              <input type="name" class="form-control" name="username" id="username" placeholder="Username">
            </div>

            <div class="input-box">
              <span class="icon-2" id="togglePassword"><i class='bx bxs-lock-alt'></i></span>
              <input type="password" name="password" id="password" class="form-control" placeholder="Password">
            </div>

            <button type="submit" class="btn_v2">Login</button>
          </form>
        </div>
      </div>
    </div>
  </div>
</div>

<script>
document.getElementById('togglePassword').addEventListener('click', function() {
    var passwordField = document.getElementById('password');
    var icon = document.querySelector('.icon-2 i');
    if (passwordField.type === 'password') {
        passwordField.type = 'text';
        icon.classList.remove('bxs-lock-alt');
        icon.classList.add('bxs-lock-open-alt');
    } else {
        passwordField.type = 'password';
        icon.classList.remove('bxs-lock-open-alt');
        icon.classList.add('bxs-lock-alt');
    }
});
</script>

<?php include_once('layouts/footer.php'); ?>