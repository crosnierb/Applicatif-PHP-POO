<?php
include_once("Animal.php");

class Cat extends Animal {
  private $color;

  //constructor
  public function __construct($name, $color = "grey") {
    $this->color = $color;
    parent::__construct($name, 4, Animal::MAMMAL);
    echo $this->name.": MEEEOOWWWW\n";
  }

  //getter-setter
  public function getColor() {
    return $this->color;
  }

  public function setColor($color) {
    $this->color = $color;
  }

  //method
  public function meow() {
    echo $this->name." the ".$this->color." kitty is meowing.\n";
  }
}
?>
