<?php

//entity/Model
abstract class Inscription extends Configuration implements IModel {
  private $bdd;
  private $conf;
  private $querry;
  private $checking;
  private $result;
  private $hash;

  function __construct() {
    $this->bdd = Configuration::connectDb();
  }

  public function passwordVerify($email, $pwd) {
      $this->querry = $this->bdd->prepare("SELECT password FROM users WHERE email = :email;");
      $this->querry->bindParam(':email', $email, PDO::PARAM_STR, 255);
      $this->querry->execute();
      $result = $this->querry->fetch(PDO::FETCH_ASSOC);

      if (password_verify($pwd, $hash)) {
          return true;
      } else {
        return false;
      }
    }
}

//controller
class ConnexionController extends Inscription {
  const URL = "https://localhost/pool_php_rush/step_1";
  private $error;
  private $email;
  private $password;

  function __construct($email, $password) {
    parent::__construct();
    $this->email = $email;
    $this->password = $password;
  }

  //methode
  public function createUser() {
    if (self::verify_form() == true) {
      echo "foo";
      if (Connection::emailVerify($this->email)) {
        echo "bar";
        if (Connection::passwordVerify($this->email, $this->password)) {
          echo "foobar";
          header(location: url."/view/index.php" );
        }
        return "Incorrect email/password\n";
      }
      return "Incorrect email/password\n";
    }
    return $this->error;
  }

  public function verifyFormLogin() {
    if ((empty($this->email)) || (strlen($this->email) > 255) || (strlen($this->email) < 5) || (!filter_var($this->email, FILTER_VALIDATE_EMAIL) === true)) {
      $this->error = "Incorrect email/password";
    }

    if ((empty($this->password)) || (strlen($this->password) < 3) || (strlen($this->password) > 10) || ($this->password != $this->password_confirmation)) {
      $this->error = "Incorrect email/password";
    }

    if (!$this->error) {
      return true;
    }
  }
}
?>

<!DOCTYPE html>
<html lang="en-FR">
<head>
  <meta charset="UTF-8">
  <meta name="description" content="pool_php_d09">
  <meta name="author" content="CrosnierB">
  <link rel=stylesheet href="exercice.css" type="text/css" media=screen>
  <title>Welcome to Ex_09/pool_php_d09</title>
</head>
<body>
  <header>
    <p>Inscription</p>
  </header>
  <main>
    <section>
      <article>
          <?php
          if ($_POST) {
          $foo = new ConnectionController($_POST['email'], $_POST['password']);
          $bar = $foo->connectUser();
          }

          if ($bar){
              echo $bar;
          ?>
          <form method="post">
            <ul>
            <h1>Formulaire de connection:</h1>
              <li>
                <label for="email">Email: </label>
                <input type="email"  id="email" name="email" maxlength="255"required/>
              </li>
              <br>
              <li>
                <label for="password">Password:</label>
                <input type="password" pattern=".{3,10}" id="form-password" maxlength="10" required name="password" />
              </li>
              <br>
              <li>
                <input type="submit" value="submit" formaction="login.php">
              </li>
            </ul>
          </form>
          <?php
               }
                 else {

                 }
           ?>
      </article>
    </section>
    <aside>
      <abbr title ="Citation">
        <?php

        if (!$bar['name']){
        echo "Veuillez renseigner le formulaire afin de vous inscrire.";
    }
    else {
      echo "Welcome in !! You can connect now!";
    } ?>
      </abbr>
    </aside>
  </main>
  <footer>
    <address>
      Develloped by <a rel="nofollow" href="mailto:debellaistre@gmail.com">Crosnier De Bellaistre</a>.<br>
      8 rue eric tabarly 91300 Massy-Palaiseau<br>
      FRANCE - Call <a rel="nofollow" href="tel:+651001027">0651001027</a>
    </address>
  </footer>
</body>
</html>
