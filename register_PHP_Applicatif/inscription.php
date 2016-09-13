<?php
/*uml
-Abstract Class Configuration
-- Abstract Class Inscription -> IModel
--- Class InscriptionController -> IUser
*/

//Interface
interface IUser {
  public function getName();
  public function getEmail();
  public function getPassword();
}

interface IModel {
  public function add($arg);
}

//Database & security conf
abstract class Configuration {
  const ERROR_LOG_FILE = "errors.log";
  protected $error_log_file = ERROR_LOG_FILE;
  protected $host = "localhost";
  private $username = "root";
  private $passwd = "";
  private $port = "4321";
  private $db = "Day09";

  private $hash;
  private $salt;
  private $bool;
  private $hashVerif;
  protected $dbh;

  public function connectDb() {
    if ((!$this->host)||(!$this->username)||(!$this->port)||(!$this->db)) {
      echo "Bad params! Usage: php connect_db.php host username password port db\n";
    }
    else {
      try {
        $this->dbh = new PDO('mysql:host='.$this->host.';port='.$this->port.';dbname='.$this->db, $this->username, $this->passwd);
        return $this->dbh;
      } catch (Exception $e) {
        echo "Error\n";
        echo "PROGRAMME ERROR: ".$e->getMessage()." storage in ".$error_log_file."\n";
        file_put_contents($error_log_file, $e->getMessage()."\n", FILE_APPEND);
      }
    }
  }

  function hashVerify($pwd, $salt, $hash) {
    $this->hashVerif = md5(crypt($pwd, $salt));
    return (strcmp($hash, $this->hashVerif) != 0) ? false : true;
  }

  function securityHash($pwd) {
    $this->salt = md5(uniqid(rand(), false));
    $this->hash = md5(crypt($pwd, $this->salt));
    $this->bool = self::hashVerify($pwd, $this->salt, $this->hash);
    $this->array = (!$this->bool) ? (my_password_hash($pwd)) : (array("hash" => $this->hash, "salt" => $this->salt));
    return $this->array;
  }
}

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

  public function add($arg) {
      $this->hash = Configuration::securityHash($arg->getPassword());
      $this->querry = $this->bdd->prepare("INSERT INTO users(name, email, password, salt, created_at) VALUES (:name, :email, :hash, :salt, DATE_FORMAT(NOW(),'%d-%m-%Y'))");
      $this->querry->bindParam(':name', $arg->getName(), PDO::PARAM_STR, 255);
      $this->querry->bindParam(':email', $arg->getEmail(), PDO::PARAM_STR, 255);
      $this->querry->bindParam(':hash', $this->hash['hash'], PDO::PARAM_STR, 255);
      $this->querry->bindparam(':salt', $this->hash['salt'], PDO::PARAM_STR, 255);
      $this->querry->execute();
      return true;
  }

  public function email_verify($email) {
      $this->querry = $this->bdd->prepare("SELECT email FROM users WHERE email = :email;");
      $this->querry->bindParam(':email', $email, PDO::PARAM_STR, 255);
      $this->querry->execute();
      $result = $this->querry->fetch();
      if ($email == $result['email']) {
        return true;
      }
      return false;
    }

  public function displayByEmail($arg) {
      $this->querry= $this->bdd->prepare('SELECT name, email, created_at FROM users WHERE email = :email;');
      $this->querry->bindParam('email', $arg, PDO::PARAM_STR, 255);
      $this->checking = $this->bdd->prepare("SELECT COUNT(email) as 'compte' FROM users WHERE email = :email;");
      $this->checking->bindParam(':email',$arg, PDO::PARAM_STR, 255);
      $this->checking->execute();
      $this->result = $this->checking->fetch(PDO::FETCH_ASSOC);

      if ($this->result['compte'] != 0) {
        $this->querry->execute();
        return $this->querry->fetch(PDO::FETCH_ASSOC);
      }
    }
}

//controller
class InscriptionController extends Inscription implements IUser {
  const URL = "https://localhost/pool_php_d09/ex_09/";
  const ERROR_LOG_FILE = "errors.log";
  protected $error_log_file = ERROR_LOG_FILE;
  private $error = array();
  private $user;
  private $name;
  private $email;
  private $password;
  private $password_confirmation;

  function __construct($name, $email, $password, $password_confirmation) {
    parent::__construct();
    $this->name = $name;
    $this->email = $email;
    $this->password = $password;
    $this->password_confirmation = $password_confirmation;
  }

  //getter/setter
  public function getName() {
    return $this->name;
  }

  public function getEmail() {
    return $this->email;
  }

  public function getPassword() {
    return $this->password;
  }

  //methode
  public function createUser() {
    if (self::verify_form() == true) {
      if (!Inscription::email_verify($this->email)) {
        Inscription::add($this);
        return "User created\n";
      }
      return "Invalide: user exist\n";
    }
    return $this->error;
  }

  public function verify_form() {
    if ((empty($this->name)) || (!preg_match("/^[a-zA-Z ]*$/", $this->name)) || ((strlen($this->name) < 3) || (strlen($this->name) > 10))) {
      $this->error[] = "Invalide name\n";
    }

    if ((empty($this->email)) || (strlen($this->email) > 255) || (strlen($this->email) < 5) || (!filter_var($this->email, FILTER_VALIDATE_EMAIL) === true)) {
      $this->error[] = "Invalide email\n";
    }

    if ((empty($this->password)) || (strlen($this->password) < 3) || (strlen($this->password) > 10) || ($this->password != $this->password_confirmation)) {
      $this->error[] = "Invalide password or password confirmation\n";
    }

    if (!$this->error) {
      return true;
    }
  }

  public function displayUser() {
    return Inscription::displayByEmail($this->email);
  }
}
?>

<!DOCTYPE html>
<html lang="en-FR">
<head>
  <meta charset="UTF-8">
  <meta name="description" content="pool_php_d09">
  <meta name="author" content="CrosnierB">

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
          $foo = new InscriptionController($_POST['name'], $_POST['email'], $_POST['password'], $_POST['password_confirmation']);
          $bar = $foo->createUser();
          }

          if ($bar != "User created\n"){
            if (is_string($bar)){
              echo $bar;
            }
            else {
              print_r($bar[0]."<br>".$bar[1]."<br>".$bar[2]."<br>".$bar[3]);
            }
          ?>
          <form method="post">
            <ul>
            <h1>Formulaire d'inscription:</h1>
              <li>
                <label for="name">Name:</label>
                <input type="text" pattern="[a-zA-Z]+.{2,10}"id="form-name" maxlength="10" required name="name" />
              </li><br>
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
                <label for="password_confirmation">Password Confirmation:</label>
                <input type="password" pattern=".{3,10}" id="form-password_confirmation" maxlength="10" required name="password_confirmation" />
              </li>
              <br>
              <li>
                <input type="submit" value="submit" formaction="inscription.php">
              </li>
            </ul>
          </form>
          <?php
               }
                 else {
                     print_r("<article><p>User created</p></article>");
                     $bar = $foo->displayUser();
                     print_r("<article><p>Name: ".$bar['name'].".<br> Email: ".$bar['email'].".<br> Date of creation: ".$bar['created_at'].".<p></article>");
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
      8 rue eric tabarly 91300 Massy-palaiseau<br>
      FRANCE - Call <a rel="nofollow" href="tel:+651001027">0651001027</a>
    </address>
  </footer>
</body>
</html>
