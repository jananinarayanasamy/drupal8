<?php
 namespace Drupal\custom_calculator\Controller;
 use Drupal\Core\Controller\ControllerBase;


/**
 * An example controller.
 */


 
interface MyInterfaceMethods { 
   public  function methodAdd(); 
   public  function methodSub(); 
   public  function methodMul(); 
   public  function methodDiv(); 
}

class ControllerCalculator extends ControllerBase implements MyInterfaceMethods {
	
	 public $num1;
	public $num2;
	
	public function __construct() {
      $this->num1 = 10;
      $this->num2 = 5;
	} 

	public function methodAdd(){ 
       return $this->num1 + $this->num2 ;
		
    } 
	
	public function methodSub(){ 
        return $this->num1 - $this->num2 ;
		
    }
	
	public function methodMul(){ 
       return $this->num1 * $this->num2 ;
		
    }
	
	public function methodDiv(){ 
        return $this->num1 / $this->num2 ;
		
    }

	public function mathFunc(){
		
		$variable.="<h1>Input1: ".$this->num1 ."<br>" ."Input2: ".$this->num2."<br><br>";
		$variable.= "Addition : " .$this->methodAdd()."<br>";
		$variable.= "Subtraction : " .$this->methodSub()."<br>";
		$variable.= "Multiply :" .$this->methodMul()."<br>";
		$variable.= "Division: " .$this->methodDiv()."<br><br><br></h1>";

		 return [
		  '#title' =>"Calculator",
		  '#markup' => $variable,
		];
			
	}
}

