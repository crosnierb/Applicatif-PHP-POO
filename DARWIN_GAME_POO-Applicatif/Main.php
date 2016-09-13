<?php
include_once("Shark.php");
include_once("BlueShark.php");
include_once("Canary.php");
include_once("GreatWhite.php");
include_once("Cat.php");

$bird =  new  Canary("Titi");
$shark1  =  new  Shark("Shark1");  #  Yes  bob  is  a shark here !
$shark2  =  new  Shark("Shark2");  #  Yes  Willy  is  a shark here !
$shark3 = new GreatWhite("GreatWhiteShark");
$shark4 =  new  BlueShark("BlueShark");
$cat  =  new  Cat("Cat");
$clone  =  new  Shark("shark1");
$bird->eat($bird);
$shark1->eat($clone);
$shark1->eat($shark1);
$shark2->eat($shark2);
$shark3->eat($cat);
$shark4->eat($shark2);
echo "fin\n";
exit;
?>
