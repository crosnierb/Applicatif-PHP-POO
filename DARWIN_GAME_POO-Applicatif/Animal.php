<?php
class Animal{
  const MAMMAL = 0;
  const FISH = 1;
  const BIRD = 2;
  public $name;
  public $legs;
  public $type;
  public static $countAnimals = 0;
  public static $countMammals = 0;
  public static $countFish = 0;
  public static $countBirds = 0;
  
  //constructor
  public function __construct($name, $legs, $type) {
    $this->name = $name;
    $this->legs = $legs;
    $this->type = $type;

    //count nbr animal
    self::$countAnimals++;

    switch ($type) {
      case (self::MAMMAL): { $typeAnimal = "mammal"; self::$countMammals++; break; }
      case (self::FISH): { $typeAnimal = "fish"; self::$countFish++; break; }
      case (self::BIRD): { $typeAnimal = "bird"; self::$countBirds++; break; }
    }
    echo "My name is ".$this->name." and i am a ".$typeAnimal." !\n";
  }

  //getter-setter
  public function getName() {
    return $this->name;
  }

  public function getLegs() {
    return $this->legs;
  }

  public function getType() {
    switch ($j = $this->type) {
      case (self::MAMMAL): { return "mammal"; break; }
      case (self::FISH): { return "fish"; break; }
      case (self::BIRD): { return "bird"; break; }
    }
  }

  //methode
  public function getNumberOfAnimalsAlive() {
    switch ($j = self::$countAnimals) {
      case ($j <= 1): { $typeName =  "animal"; break; }
      default: { $typeName = "animals"; break; }
    }
    echo "There is currently ".self::$countAnimals." ".$typeName." alive in our world.\n";
  }

  public function getNumberOfMammals() {
    switch ($j = self::$countMammals) {
      case ($j <= 1): { $typeName =  "mammal"; break; }
      default: { $typeName = "mammals"; break; }
    }
    echo "There is currently ".self::$countMammals." ".$typeName." alive in our world.\n";
  }

  public function getNumberOfFish() {
    echo "There is currently ".self::$countFish." fish alive in our world.\n";
  }

  public function getNumberOfBirds() {
    switch ($j = self::$countBirds) {
      case ($j <= 1): { $typeName =  "bird"; break; }
      default: { $typeName = "birds"; break; }
    }
    echo "There is currently ".self::$countBirds." ".$typeName." alive in our world.\n";
  }
}
?>
