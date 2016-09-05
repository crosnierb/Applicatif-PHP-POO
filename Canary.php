<?php
include_once("Animal.php");

class Canary extends Animal {
  private static $eggs = 0;

  //constructor
  public function __construct($name) {
    parent::__construct($name, 2, Animal::BIRD);
    echo "Yellow and smart ? Here I am !\n";
  }

  //getter-setter
  public function getEggsCount() {
    return self::$eggs;
  }

  //method
  public function layEgg() {
    self::$eggs++;
  }
}
?>
