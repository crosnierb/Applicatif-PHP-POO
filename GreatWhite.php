<?php
include_once("Animal.php");

class GreatWhite extends Animal {
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
    //echo "Bye ".$this->name." !\n";
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
      if ((get_class($objectAnimal) == "Shark") && ($objectAnimal->getName() == $this->name) && ($objectAnimal->getId() == $this->id)) {
        echo $this->name.": It’s not worth my time\n";
      } elseif (get_class($objectAnimal) == "Canary") {
        echo $this->name.": Next time you try to give me that to eat, I’ll eat you instead.\n";
      } else if(get_class($objectAnimal) == "Shark") {
        echo $this->name.": The best meal one could wish for.\n";
        unset($objectAnimal);
      } else {
        echo $this->name." ate a ".$objectAnimal->getType()." named ".$objectAnimal->getName().".\n";
        unset($objectAnimal);
      }
    }
  }
}
?>
