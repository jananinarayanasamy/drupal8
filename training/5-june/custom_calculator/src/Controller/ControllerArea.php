<?php
 namespace Drupal\custom_calculator\Controller;
 use Drupal\Core\Controller\ControllerBase;


/**
 * An example controller.
 */
 trait TermTraits {
  public function getTermIdByName() {
 
    return "Successfully calculated";
  }
}

class ControllerArea extends ControllerBase {

	use TermTraits;

	public $height;
	public $width;
	
	public function __construct() {
      $this->height = 10;
      $this->width = 30;
	}

	public function calcArea(){ 
	   	
	   $varArea .= "<h1>".$this->getTermIdByName()."<br><br>";
       $varArea .= "Height: ". $this->height."<br>"."Width: ".$this->width."<br>";
       $varArea .= "Area: ".$this->height * $this->width ."</h1>";

	   return [
			'#title' =>"Area Calculation",
			'#markup' => $varArea,
		];
			
		
    } 

}

