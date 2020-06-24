<?php


namespace Drupal\student_teacher_mod\Form;


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
class studentServicesFrom extends FormBase {


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
    if ($form_state->getValue('name') == '' || $form_state->getValue('rollno') == '' || $form_state->getValue('datetime') == ''|| $form_state->getValue('gender') == '' || $form_state->getValue('phone') == '') {
				
      $msg = t('<strong>Name, Roll NO, DOB, Gender, and Phone no are required!</strong>');
      $form_state->setErrorByName('form', $msg);
    }
  }


  /**
   * {@inheritdoc}
   */
  public function buildForm(array $form, FormStateInterface $form_state) {
    	
    $uname  = \Drupal::currentUser()->getUsername();
 
    $form['name'] = [
      '#type' => 'textfield',
      '#title' => $this->t('Name'),
      '#maxlength' => 20,
      '#required' => TRUE,
	  '#default_value' =>$this->t($uname),
	 
    ];
    // Email
    $form['rollno'] = [
      '#type' => 'textfield',
      '#title' => $this->t('Roll No'),
      '#maxlength' => 20,
      '#required' => TRUE,
     ];
    
	
	// Date-time.
    $form['datetime'] = [
      '#type' => 'date',
      '#title' => 'DOB',
      '#date_increment' => 1,
      '#required' => TRUE,
    ];
	
	// Select.
    $form['gender'] = [
	'#type' => 'radios',
	'#title' => t('Gender'),
	'#options' => ['Male' => 'Male', 'Female' => 'Female'],
	'#default_value' => 'Male',
	'#required' => TRUE,
	];
	
	// Phone
	 $form['phone'] = [
      '#type' => 'tel',
      '#title' => $this->t('Phone'),
   	  '#required' => TRUE,
    ];
	
	// Textarea.
    $form['address'] = [
      '#type' => 'textarea',
      '#title' => $this->t('Address'),
      
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
    return 'student_teacher_mod';
  }


  /**
   * {@inheritdoc}
   */

    public function submitForm(array &$form, FormStateInterface $form_state) {
    // Find out what was submitted.

	$uid = \Drupal::currentUser()->id();
	$current_user = \Drupal::currentUser()->getRoles();
	$uname  = \Drupal::currentUser()->getUsername();	
	//$username=$form_state->getValue('name');
	$rollno = $form_state->getValue('rollno');
	$datetime = $form_state->getValue('datetime');
	$gender=$form_state->getValue('gender');
	$phone = $form_state->getValue('phone');
	$address = $form_state->getValue('address');	
	
	$data = array("userid"=>$uid,"name"=>$uname,"rollno"=>$rollno,"datetime"=>$datetime,"gender"=>$gender,"phone"=>$phone,"address"=>$address,"status"=>"new");
	
	$cust_service = \Drupal::service('student_teacher_mod.insert')->InsertConfig($data);
	
	drupal_set_message($this->t("@message", ['@message' => 'Configuration Successfully Updated.']));
  }	

  // /**
  //  * {@inheritdoc}
  //  */
  // protected function getEditableConfigNames() {
  //   return ['config_module.settings'];
  // }


}
 
















