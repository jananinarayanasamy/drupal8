<?php


namespace Drupal\custom_service_module\Form;


use Drupal\Core\Form\FormBase;
use Drupal\Core\Form\FormStateInterface;
use Symfony\Component\DependencyInjection\ContainerInterface;
use Drupal\Core\Form\drupal_set_message;
use Drupal\Core\Entity\t;


/**
 * Class Configuration Setting.
 *
 * @package Drupal\config_module\Form
 */
class customServicesFromEdit extends FormBase {

public $userID;
	

  /**
   * {@inheritdoc}
   */
  // public static function create(ContainerInterface $container) {
  //   return new static(
  //       $container->get('config_module.settings')
  //   );
  // }


  /**
   * {@inheritdoc}
   */
  public function validateForm(array &$form, FormStateInterface $form_state) {
    // valiodate form values
    if ($form_state->getValue('password') == '' ) {
      $msg = t('<strong> Password </strong>');
      $form_state->setErrorByName('form', $msg);
    }
  }


  /**
   * {@inheritdoc}
   */
  public function buildForm(array $form, FormStateInterface $form_state,$cid=NULL) {
	
	$userID = $cid ;

	$config =  \Drupal::service('config.factory')->getEditable('custom_service_module.settings');
    $userData = $config->get($userID);   
   

   $form['details'] = [
      '#type' => 'details',
      '#title' => $this->t('User Detail'),
      '#description' => $this->t("UserName: ".$userData['username']."<br>"."Email: ".$userData['email']),
    ];
	
	
	
    $form['password'] = [
      '#type' => 'password',
      '#title' => $this->t('Password'),
	 
    ];
	
	$form['uid'] = $userID;
	
    $form['actions']['#type'] = 'actions';


    $form['actions']['submit'] = array(
      '#type' => 'submit',
      '#value' => $this->t('Save'),
      '#button_type' => 'primary',
    );


    return $form;
  }


  /**
   * {@inheritdoc}
   */
  public function getFormId() {
    return 'custom_service_module';
  }


  /**
   * {@inheritdoc}
   */
  public function submitForm(array &$form, FormStateInterface $form_state) {
    
   	$uid = $form['uid'];
	
   	$password = $form_state->getValue('password');

	$data = array("userId"=>$uid,"password"=>$password);
	
	$cust_service = \Drupal::service('custom_service_module.insert')->editConfig($data);
	
    drupal_set_message($this->t("@message", ['@message' => 'Configuration Successfully Updated.']));
  }


  // /**
  //  * {@inheritdoc}
  //  */
  // protected function getEditableConfigNames() {
  //   return ['config_module.settings'];
  // }


}
 
















