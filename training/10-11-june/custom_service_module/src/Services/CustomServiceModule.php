<?php

/**
* @file providing the service that say hello world and hello 'given name'.
*
*/

namespace  Drupal\custom_service_module\Services;
use Drupal\Core\Config\ConfigFactoryInterface;
use Symfony\Component\DependencyInjection\ContainerInterface;


interface serviceFuncInterface {
	
	public function InsertConfig($dataItem);
	public function editConfig($dataItem);
	
}

class CustomServiceModule implements serviceFuncInterface {

 public $dataItem;
 
  public function __construct(ConfigFactoryInterface $configFactory) {
    $this->configFactory = $configFactory;
  }

 public function InsertConfig($dataItem){

	$dataKey = "data".date("His");
	//$config = \Drupal::service('config.factory')->getEditable('custom_service_module.settings')->delete();
	//$cust_service = \Drupal::service('config.factory')->getEditable('custom_service_module.settings');
	$cust_service = $this->configFactory->getEditable('custom_service_module.settings');
	$cust_service->set($dataKey ,$dataItem);
	$cust_service->save();
	
 }
 
  public function editConfig($dataItem){
	$uid = $dataItem['userId'];
	$pasword = $dataItem['password'];
	
	//$cust_service = \Drupal::service('config.factory')->getEditable('custom_service_module.settings');
	$cust_service = $this->configFactory->getEditable('custom_service_module.settings');
	$cust_service->set($uid.'.password',$pasword);
	$cust_service->save(true);
	
 }
 
	

}