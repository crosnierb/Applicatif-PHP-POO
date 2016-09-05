<?php
include_once("Animal.php");

class Shark extends Animal {
  private $frenzy;
  public $id;
  protected static $var = 0;

  //constructor
  public function __construct($name, $frenzy = false) {
    $this->frenzy = $frenzy;
    parent::__construct($name, 0, Animal::FISH);
    echo "A KILLER IS BORN !\n";

    $this->id = self::$var;
    self::$var++;
  }

  public function __destruct() {
    echo "Bye ".$this->name." !\n";
  }

  public function getId() {
    return $this->id;
  }

  //method
  public function status() {
    switch ($this->frenzy) {
      case (true): { echo $this->name." is smelling blood and wants to kill.\n"; break; }
      case (false): { echo $this->name." is swimming peacefully.\n"; break; }
    }
  }

  public function smellBlood($bool) {
    $this->frenzy = $bool;
  }

  public function eat($objectAnimal) {
    if (is_object($objectAnimal)) {
      echo ((get_class($objectAnimal) == "Shark") && ($objectAnimal->getName() == $this->name) && ($objectAnimal->getId() == $this->id)) ?
      $this->name.": It's not worth my time\n" :
      $this->name." ate a ".$objectAnimal->getType()." named ".$objectAnimal->getName().".\n"; unset($titi);
    }
  }
}
?>
