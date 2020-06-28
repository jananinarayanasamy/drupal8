<?php


namespace Drupal\userform_module\Form;
use Drupal\userform_module\Event\OnSubmitEvent;


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
 * @package Drupal\config_module\Form
 */
class CustomUserFrom extends FormBase {


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
    if ($form_state->getValue('firstname') == '' || $form_state->getValue('lastname') == '') {
      $msg = t('<strong>Username and Email are required!</strong>');
      $form_state->setErrorByName('form', $msg);
    }
  }


  /**
   * {@inheritdoc}
   */
  public function buildForm(array $form, FormStateInterface $form_state) {
    
    //$config = \Drupal::config('setting_module.settings');
    //$tax_term = \Drupal\taxonomy\Entity\Term::load(1);
	
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

	$form['actions'] = [
      '#type' => 'button',
      '#value' => $this->t('Submit'),
      '#ajax' => [
        'callback' => '::ajaxFormSubmit',
      ],
    ];

    return $form;
  }


  /**
   * {@inheritdoc}
   */
  public function getFormId() {
    return 'userform_module';
  }

  
  public function ajaxFormSubmit(array $form, FormStateInterface $form_state) {

	 $values = $form_state->getValues(); 
	 $intrest = implode(",",$values["select_multiple"]);
	 
	$fieldValue= [
	 "first_name"=> $values["firstname"],
	 "last_name"=> $values["lastname"],
	 "biography"=> $values["biography"],
	 "gender"=> $values["gender"],
	 "interest"=> $intrest
	];
	$insertRow = db_insert('custom_table')-> fields($fieldValue)->execute();
    
	 $form_dispatcher = \Drupal::service('event_dispatcher');
	 $form_event = new OnSubmitEvent($values , $insertRow,$values["firstname"]);
	 $form_dispatcher->dispatch(OnSubmitEvent::SUBMIT_EVENT, $form_event);  
	
	
    $response = new AjaxResponse();
    $response->addCommand(
      new HtmlCommand(
        '.result_message',
        '<div class="my_top_message" >' . drupal_set_message('Data has been submitted successfully !!!') . '</div>'
      )
    );
    return $response;
 }


  public function submitForm(array &$form, FormStateInterface $form_state) {
	drupal_set_message('Nothing Submitted. Just an Example.');
  }



}
 
















