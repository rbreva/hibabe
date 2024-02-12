<?php

$msj_error = "";
if (isset($_GET['err'])) {
    $err = $_GET['err'];
    if ($err == 1) {
        $msj_error = "Usuario o contraseña incorrectos";
    }
}

?>
<header>
  <div class="marquesina"><?php echo $config['name'] ?></div>
</header>
<div class="main_login">
  <div class="login">
    <div class="login_case">
      <img class="logo" src="images/svg/limalocal.svg" alt="Limalocal" />
      <h1 class="login_h1">Administrador</h1>
      <h4 class="login_h4">Version <?php echo $config['version'] ?></h4>
      <form class="login_form" action="index.php" method="post">
        <input class="login_input" type="text" name="user" placeholder="Usuario" required />
        <input class="login_input" type="password" name="pass" placeholder="Contraseña" required />
        <button class="login_btn" type="submit">Ingresar</button>
        <a class="forgot_pass" href="#">¿Olvidaste tu contraseña?</a>
        <div class="alert_msj"><?php echo $msj_error ?></div>
      </form>
    </div>
  </div>
</div>
<footer>
  <div class="marq">Limalocal 2023</div>
</footer>
</body>

</html>
