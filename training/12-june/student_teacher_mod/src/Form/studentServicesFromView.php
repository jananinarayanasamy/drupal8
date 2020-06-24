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
class studentServicesFromView extends FormBase {


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
    if ($form_state->getValue('table') == '') {
				
      $msg = t('<strong>Name, Roll NO, DOB, Gender, and Phone no are required!</strong>');
      $form_state->setErrorByName('form', $msg);
    }
  }


  /**
   * {@inheritdoc}
   */
  public function buildForm(array $form, FormStateInterface $form_state) {
    	
   
	$config = \Drupal::service('config.factory')->getEditable('student_teacher_mod.settings');
	$uservalue = $config->get();
	
	$options=[];
	foreach ($uservalue as $item=>$value){
		if (isset($value['status']) && $value['status'] == 'new')
			    $options[$item]=$value;
	}
		  
	// TableSelect.
  
	$header = [
      'userid' => $this->t('User Id'),
      'name' => $this->t('User Name'),
      'rollno' => $this->t('DOB'),
      'gender' => $this->t('Gender'),
      'phone' => $this->t('Phone'),
	  'status' => $this->t('Status'),
	   
    ];

    $form['table'] = [
      '#type' => 'tableselect',
      '#title' => $this->t('Users'),
      '#header' => $header,
      '#options' => $options,
      '#empty' => $this->t('No users found'),
    ];

   
    $form['actions']['#type'] = 'actions';


    $form['actions']['submit'] = array(
      '#type' => 'submit',
      '#value' => $this->t('Set Role'),
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
	$data = $form_state->getValue('table');
	
	$cust_service = \Drupal::service('student_teacher_mod.insert')->editConfig($data);
	
	drupal_set_message($this->t("@message", ['@message' => 'Configuration Successfully Updated.']));
  }	
  
  

  // /**
  //  * {@inheritdoc}
  //  */
  // protected function getEditableConfigNames() {
  //   return ['config_module.settings'];
  // }


}
 
















