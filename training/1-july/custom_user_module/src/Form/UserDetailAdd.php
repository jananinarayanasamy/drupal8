<?php


namespace Drupal\custom_user_module\Form;
use Drupal\custom_user_module\Event\OnSubmitEvent;


use Drupal\Core\Form\FormBase;
use Drupal\Core\Form\FormStateInterface;
use Drupal\Core\Form\drupal_set_message;
use Drupal\Core\Entity\t;
use Drupal\Core\Ajax\AjaxResponse;
use Drupal\Core\Ajax\ReplaceCommand;
use Drupal\Core\Ajax\HtmlCommand;


/**
 * Class Configuration Setting.
 *
 * @package Drupal\custom_user_module\Form
 */
class UserDetailAdd extends FormBase {


  /**
   * {@inheritdoc}
   */
  public function validateForm(array &$form, FormStateInterface $form_state) {
    // valiodate form values
    if ($form_state->getValue('firstname') == '' || $form_state->getValue('lastname') == '') {
      $msg = t('<strong>Username and Email are required!</strong>');
      $form_state->setErrorByName('form', $msg);
    }
  }


  /**
   * {@inheritdoc}
   */
  public function buildForm(array $form, FormStateInterface $form_state) {
    
 	
	$query = \Drupal::entityQuery('taxonomy_term');
    $query->condition('vid', "Interest");
    $tids = $query->execute();
    $terms = \Drupal\taxonomy\Entity\Term::loadMultiple($tids);
	$termOption=array();
	foreach ($terms as $term) {
		$name = $term->get('name')->getString();
		$tid = $term->get('tid')->getString();
		$termOption[$name]=$name;
	}
	
	$form['message'] = [
      '#type' => 'markup',
      '#markup' => '<div class="result_message"></div>',
    ];
	// Username
    $form['firstname'] = [
      '#type' => 'textfield',
      '#title' => $this->t(' First Name'),
      '#maxlength' => 20,
      '#required' => TRUE,
     
    ];
	
	$form['lastname'] = [
      '#type' => 'textfield',
      '#title' => $this->t('Last Name'),
      '#maxlength' => 20,
      '#required' => TRUE,
     
    ];
    
	$form['biography'] = [
      '#type' => 'textarea',
      '#title' => $this->t('Biography'),
      '#maxlength' => 350,
      '#required' => TRUE,
     
    ];
	
    $form['gender'] = [
	'#type' => 'radios',
	'#title' => t('Gender'),
	'#options' => ['Male' => 'Male', 'Female' => 'Female'],
	'#default_value' => 'Male',
	'#required' => TRUE,
	];
   // Multiple values option elements.
    $form['select_multiple'] = [
      '#type' => 'select',
      '#title' => 'Select (Hobby)',
      '#multiple' => TRUE,
      '#options' => $termOption,
     
     // '#description' => 'Select Multiple',
    ];
	
	
	$form['actions']['#type'] = 'actions';
	
	$form['actions']['submit'] = array(
      '#type' => 'submit',
      '#value' => $this->t('Submit'),
      '#button_type' => 'primary',
    );
	/* $form['actions'] = [
      '#type' => 'button',
      '#value' => $this->t('Submit'),
      '#ajax' => [
        'callback' => '::ajaxFormSubmit',
      ],
    ]; */

    return $form;
  }


  /**
   * {@inheritdoc}
   */
  public function getFormId() {
    return 'custom_user_module';
  }


  public function submitForm(array &$form, FormStateInterface $form_state) {
    $values = $form_state->getValues(); 
	$intrest = implode(",",$values["select_multiple"]);
	$uid = \Drupal::currentUser()->id();	
	
	$fieldValue= [
	 "uid"=>$uid,	
	 "first_name"=> $values["firstname"],
	 "last_name"=> $values["lastname"],
	 "biography"=> $values["biography"],
	 "gender"=> $values["gender"],
	 "interest"=> $intrest
	];
	 
	$insertRow = db_insert('user_personal_data')-> fields($fieldValue)->execute();
 	
	$form_dispatcher = \Drupal::service('event_dispatcher');
	$form_event = new OnSubmitEvent($uid);
    $form_dispatcher->dispatch(OnSubmitEvent::SUBMIT_EVENT, $form_event);  
	
	drupal_set_message('Data Submitted Successfully !!!.');
  }



}
 
















