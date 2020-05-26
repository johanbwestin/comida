<?php
/* 
  Template Name: Custom Registration Page
*/
global $wpdb;

if ($_POST) {
  $username = $wpdb->escape($_POST['username']);
  $email = $wpdb->escape($_POST['email']);
  $password = $wpdb->escape($_POST['password']);
  $confPassword = $wpdb->escape($_POST['confirm-password']);
  $terms = $_POST['terms'];
  // Authentication
  $error = array();
  if (strpos($username, ' ') !== FALSE) {
    $error['username_space'] = "Användarnamnet har ett ogiltigt tecken";
  }

  if (!$terms) {
    $error['terms'] = "Användaravtalet Måste accepteras";
  }

  if (empty($username)) {
    $error['username_empty'] = "Fyll i ett användarnamn";
  }

  if (username_exists($username)) {
    $error['username_exists'] = "Användarnamnet är upptaget";
  }

  if (!is_email($email)) {
    $error['email_valid'] = "Fyll i en giltig emailadress";
  }

  if (email_exists($email)) {
    $error['email_existence'] = "Emailen är redan registrerad";
  }

  if (strcmp($password, $confPassword) !== 0) {
    $error['password'] = "Lösenordet matchar inte";
  }
  // Creates user if no errors
  if (count($error) == 0 && $terms) {
    wp_create_user($username, $password, $email);
    echo "User Created Successfully";
    header("Location: http://localhost:8080/logga-in");
    exit();
  }
}
?>
<!--[if !(IE 8) ]><!-->
<html xmlns="http://www.w3.org/1999/xhtml" lang="en-US">
<!--<![endif]-->

<head>
  <meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
  <title>Registration Form &lsaquo; Comida &#8212; WordPress</title>
  <link rel='dns-prefetch' href='//s.w.org' />
  <link rel='stylesheet' id='dashicons-css' href='http://localhost/comida/admin/wp-includes/css/dashicons.min.css?ver=5.4' type='text/css' media='all' />
  <link rel='stylesheet' id='buttons-css' href='http://localhost/comida/admin/wp-includes/css/buttons.min.css?ver=5.4' type='text/css' media='all' />
  <link rel='stylesheet' id='forms-css' href='http://localhost/comida/admin/wp-admin/css/forms.min.css?ver=5.4' type='text/css' media='all' />
  <link rel='stylesheet' id='l10n-css' href='http://localhost/comida/admin/wp-admin/css/l10n.min.css?ver=5.4' type='text/css' media='all' />
  <link rel='stylesheet' id='login-css' href='http://localhost/comida/admin/wp-admin/css/login.min.css?ver=5.4' type='text/css' media='all' />
  <meta name='robots' content='noindex,noarchive' />
  <meta name='referrer' content='strict-origin-when-cross-origin' />
  <meta name="viewport" content="width=device-width" />
  <link href="https://fonts.googleapis.com/css2?family=Open+Sans:wght@600&display=swap" rel="stylesheet">
  <link href="https://fonts.googleapis.com/css2?family=Sansita:wght@900&display=swap" rel="stylesheet">
</head>

<body style="background-image: url(<?php the_field('bg_img'); ?>)">
  <section class="login-section">
    <div class="form-container">
      <div class="header-container">
        <span class="line"></span>
        <h1><?php the_title() ?></h1>
        <span class="line"></span>
      </div>
      <form method="post">
        <div class="input-container">
          <label for="username">Användarnamn</label>
          <input type="text" name="username" id="username" placeholder="">
          <?php
          if (isset($error['username_space'])) {
          ?>
            <p class="error"><?php echo $error['username_space']; ?></p>
          <?php } ?>
          <?php
          if (isset($error['username_empty'])) {
          ?>
            <p class="error"><?php echo $error['username_empty']; ?></p>
          <?php } ?>
          <?php
          if (isset($error['username_exists'])) {
          ?>
            <p class="error"><?php echo $error['username_exists']; ?></p>
          <?php } ?>
        </div>
        <div class="input-container">
          <label for="email">Email</label>
          <input type="email" name="email" id="email" placeholder="">
          <?php
          if (isset($error['email_valid'])) {
          ?>
            <p class="error"><?php echo $error['email_valid']; ?></p>
          <?php } ?>
          <?php
          if (isset($error['email_existence'])) {
          ?>
            <p class="error"><?php echo $error['email_existence']; ?></p>
          <?php } ?>
        </div>
        <div class="input-container">
          <label for="password">Lösenord</label>
          <input type="password" name="password" id="password" placeholder="">
        </div>
        <div class="input-container">
          <label for="confirm-password">Bekräfta lösenord</label>
          <input type="password" name="confirm-password" id="confirm-password" placeholder="">
          <?php
          if (isset($error['password'])) {
          ?>
            <p class="error"><?php echo $error['password']; ?></p>
          <?php } ?>
        </div>
        <div class="terms-container input-container">
          <label class="w3-text-blue">
            <p>vänligen acceptera användarvillkor</p>
          </label>
          <input v-model="terms" placeholder type="checkbox" name="terms" />
          <?php
          if (isset($error['terms'])) {
          ?>
            <p class="error terms-err"><?php echo $error['terms']; ?></p>
          <?php } ?>
        </div>
        <div class="button-container">
          <button class="register-btn" type="submit" name="submit"><span>Registrera</span></button>
          <p>Redan medlem? Logga in <a href="http://localhost:8080/logga-in">här</a></p>
          <p>Eller fortsätt som <a href="http://localhost:8080/hem">gäst</a></p>
        </div>
      </form>
    </div>
  </section>
</body>
<style>
  body {
    display: flex;
    align-items: center;
    justify-content: center;
    height: 100vh;
    width: 100%;
    background-size: cover;
    background-position-y: 50%;
  }

  h1,
  h2,
  h3,
  h4 {
    font-family: 'Sansita', sans-serif;
    color: white;
  }

  p,
  span,
  a,
  label {
    font-family: 'Open Sans', sans-serif;
  }

  .login-section {
    position: fixed;
    z-index: 2;
    background-color: rgba(255, 255, 255, 0.4);
    height: 100vh;
    width: 100%;
    display: flex;
    justify-content: center;
    align-items: center;
  }

  .form-container {
    width: 30%;
    display: flex;
    flex-direction: column;
    align-items: center;
    position: absolute;
    background-color: white;
    -webkit-box-shadow: 0 8px 38px -6px #515052;
    -moz-box-shadow: 0 8px 38px -6px #515052;
    box-shadow: 0 8px 38px -6px #515052;
  }

  form {
    display: flex;
    flex-direction: column;
    width: 100%;
  }

  .input-container,
  .button-container {
    margin-left: auto;
    margin-right: auto;
    margin-top: 1rem;
    width: 70%;
    position: relative;
  }

  .terms-container {
    margin-left: auto;
    margin-right: auto;
    margin-top: 0rem;
    width: 70%;
    margin-bottom: 1rem;
  }

  input {
    height: 2.3rem;
    width: 100%;
  }

  .register-btn,
  .login-btn {
    border: none;
    background-color: #EC4E20;
  }

  p {
    font-size: 0.9rem;
    color: black;
  }

  .error {
    position: absolute;
    top: 2.4rem;
    color: red;
  }

  .terms-err {
    top: 3rem;
  }

  .register-btn>span {
    font-size: 0.9rem;
    display: inline-block;
    padding-top: 0.5rem;
    padding-bottom: 0.5rem;
    padding-left: 0.5rem;
    padding-right: 0.5rem;
    color: white;
  }

  .header-container {
    justify-content: center;
    align-items: center;
    display: flex;
    height: 4rem;
    width: 100%;
    background-color: #EC4E20;
  }

  h1 {
    padding: 5px;
    padding-bottom: 8px;
    color: white;
    font-size: 1.5rem;
    margin: 0;
  }

  .line {
    display: inline-block;
    width: 20px;
    height: 3px;
    background: white;
  }

  @media screen and (max-width: 1100px) {
    .form-container {
      width: 60%;
    }
  }

  @media screen and (max-width: 600px) {
    .form-container {
      width: 80%;
    }
  }

  @media screen and (max-width: 400px) {
    .form-container {
      width: 100%;
      height: 100vh;
    }
  }
</style>

</html>