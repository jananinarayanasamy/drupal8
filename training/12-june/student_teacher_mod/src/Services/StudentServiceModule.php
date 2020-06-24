<?php

/**
* @file providing the service that say hello world and hello 'given name'.
*
*/

namespace  Drupal\student_teacher_mod\Services;
use Drupal\Core\Config\ConfigFactoryInterface;
use Symfony\Component\DependencyInjection\ContainerInterface;


interface serviceFuncInterface {
	
	public function InsertConfig($dataItem);
	public function editConfig($dataItem);
	
}

class StudentServiceModule implements serviceFuncInterface {

 public $dataItem;
 
  public function __construct(ConfigFactoryInterface $configFactory) {
    $this->configFactory = $configFactory;
  }

 public function InsertConfig($dataItem){

	$uid = $dataItem['userid'];
	$dataKey = "data".$uid;
	
	//$config = $this->configFactory->getEditable('student_teacher_mod.settings')->delete();
	//$cust_service = \Drupal::service('config.factory')->getEditable('student_teacher_mod.settings');
	$cust_service = $this->configFactory->getEditable('student_teacher_mod.settings');
	$cust_service->set($dataKey ,$dataItem);
	$cust_service->save();
	
 }
 
  public function editConfig($dataItem){
	
			
	foreach ($dataItem as $key) { 
		$uid = str_replace("data","",$key);
		$status = "closed";
		
		$user = \Drupal\user\Entity\User::load($uid);
		$user->addRole('student');
		$user->save(); 
		   
	   //$cust_service = \Drupal::service('config.factory')->getEditable('student_teacher_mod.settings');
		$cust_service = $this->configFactory->getEditable('student_teacher_mod.settings');
		$cust_service->set($key.'.status',$status);
		$cust_service->save(true); 
	
	   
	}


	
 }
 
	

}