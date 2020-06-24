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
class customServicesFrom extends FormBase {


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
    if ($form_state->getValue('username') == '' || $form_state->getValue('email') == '' || $form_state->getValue('password') == '' ) {
      $msg = t('<strong>Username, Password and Email are required!</strong>');
      $form_state->setErrorByName('form', $msg);
    }
  }


  /**
   * {@inheritdoc}
   */
  public function buildForm(array $form, FormStateInterface $form_state) {
    
   // $config = \Drupal::config('setting_module.settings');
    //Username
    $form['username'] = [
      '#type' => 'textfield',
      '#title' => $this->t('Username'),
      '#maxlength' => 20,
      '#required' => TRUE,
    ];
    // Email
    $form['email'] = [
      '#type' => 'textfield',
      '#title' => $this->t('Email'),
      '#maxlength' => 50,
      '#required' => TRUE,
     ];
    
   // Password.
    $form['password'] = [
      '#type' => 'password',
      '#title' => $this->t('Password'),
     
    ];
	
	
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
    
    $username=$form_state->getValue('username');
	$email = $form_state->getValue('email');
	$password = $form_state->getValue('password');
	
	$data = array("username"=>$username,"email"=>$email,"password"=>$password);
	
	$cust_service = \Drupal::service('custom_service_module.insert')->InsertConfig($data);
	
    drupal_set_message($this->t("@message", ['@message' => 'Configuration Successfully Updated.']));
  }


  // /**
  //  * {@inheritdoc}
  //  */
  // protected function getEditableConfigNames() {
  //   return ['config_module.settings'];
  // }


}
 
















