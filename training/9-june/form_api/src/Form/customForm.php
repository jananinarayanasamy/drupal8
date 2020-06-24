<?php


namespace Drupal\form_api\Form;


use Drupal\Core\Form\FormBase;
use Drupal\Core\Form\FormStateInterface;
//use Symfony\Component\DependencyInjection\ContainerInterface;
use Drupal\Core\Form\drupal_set_message;
use Drupal\Core\Entity\t;
use Drupal\Core\Ajax\AjaxResponse;
use Drupal\Core\Ajax\ReplaceCommand;

/**
 * Class Configuration Setting.
 *
 * @package Drupal\config_module\Form
 */
class customForm extends FormBase {


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
    if ($form_state->getValue('username') == '' || $form_state->getValue('email') == '') {
      $msg = t('<strong>Username and Email are required!</strong>');
      $form_state->setErrorByName('form', $msg);
    }
  }


  /**
   * {@inheritdoc}
   */
  public function buildForm(array $form, FormStateInterface $form_state) {
    
    //$config = \Drupal::config('setting_module.settings');
    
	// Username
    $form['username'] = [
      '#type' => 'textfield',
      '#title' => $this->t('Name'),
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
	
	// Phone
	 $form['phone'] = [
      '#type' => 'tel',
      '#title' => $this->t('Phone'),
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
		
	// Select.
    $form['graduation'] = [
      '#type' => 'select',
      '#title' => $this->t('Highest Qualification'),
 	  '#options' => $this->getGraduation(),
      '#empty_option' => $this->t('-select-'),
      //'#description' => $this->t('Select, #type = select'),
	  
	  '#ajax' => [
        'callback' => '::updateGraduation',
        'wrapper' => 'color-wrapper',
      ],
    ];
	
	$form['color_wrapper'] = [
      '#type' => 'container',
      '#attributes' => ['id' => 'color-wrapper'],
    ];
	
	
	$graduation = $form_state->getValue('graduation');
    if (!empty($graduation)) {
      $form['color_wrapper']['Course'] = [
        '#type' => 'select',
        '#title' => $this->t('Course'),
        '#options' => $this->getColorsByTemperature($graduation),
      ];
    }else{
		$form['color_wrapper']['Course'] = [
        '#type' => 'select',
        '#title' => $this->t('Course'),
		'#empty_option' => $this->t('-select-'),
		];
	}

	
    // Multiple values option elements.
    $form['select_multiple'] = [
      '#type' => 'select',
      '#title' => 'Select (Hobby)',
      '#multiple' => TRUE,
      '#options' => [
        'read' => 'Reading',
        'dance' => 'Dancing',
        'cook' => 'Cooking',
        'play' => 'Playing',
		'none' => 'N/A',
      ],
      '#default_value' => ['read'],
     // '#description' => 'Select Multiple',
    ];
	
  // Table	
	$options = [
      1 => ['location' => 'Chennai'],
      2 => ['location' => 'Bagalore'],
      3 => ['location' => 'Hydrabad'],
      4 => ['location' => 'Noida'],
      5 => ['location' => 'Madurai'],
    ];

    $header = [
      'location' => $this->t('Preffered Location'),
    ];

	// Table 
    $form['table'] = [
      '#type' => 'tableselect',
      '#title' => $this->t('Users'),
      '#header' => $header,
      '#options' => $options,
      '#empty' => $this->t('No users found'),
    ];

	
	  // Details.
    $form['details'] = [
      '#type' => 'details',
      '#title' => $this->t('Declaration'),
      '#description' => $this->t('Hereby i declared all the above information is true.'),
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
    return 'form_api';
  }

  
   public function updateGraduation(array $form, FormStateInterface $form_state) {
    return $form['color_wrapper'];
  }
  
  protected function getGraduation() {
    return array_map(function ($color_data) {
      return $color_data['name'];
    }, $this->getCourse());
  }
  
   protected function getColorsByTemperature($temperature) {
    return $this->getCourse()[$temperature]['Course'];
  }
  
  
  protected function getCourse() {
    return [
      'ug' => [
        'name' => $this->t('UG'),
        'Course' => [
		  'none' => $this->t('-select-'),		
          'bsc' => $this->t('B.Sc'),
          'bca' => $this->t('BCA'),
        
        ],
      ],
      'pg' => [
        'name' => $this->t('PG'),
        'Course' => [
		  'none' => $this->t('-select-'),	
          'msc' => $this->t('M.Sc'),
          'mca' => $this->t('MCA'),
          
        ],
      ],
    ];
  }


  /**
   * {@inheritdoc}
   */
    public function submitForm(array &$form, FormStateInterface $form_state) {
    // Find out what was submitted.
    $values = $form_state->getValues();
    foreach ($values as $key => $value) {
      $label = isset($form[$key]['#title']) ? $form[$key]['#title'] : $key;

      // Many arrays return 0 for unselected values so lets filter that out.
      if (is_array($value)) {
        $value = array_filter($value);
      }

      // Only display for controls that have titles and values.
      if ($value && $label) {
        $display_value = is_array($value) ? preg_replace('/[\n\r\s]+/', ' ', print_r($value, 1)) : $value;
        $message = $this->t('Value for %title: %value', ['%title' => $label, '%value' => $display_value]);
        $this->messenger()->addMessage($message);
      }
    }
		drupal_set_message('Submitted. Just an Example.');
  }


  // /**
  //  * {@inheritdoc}
  //  */
  // protected function getEditableConfigNames() {
  //   return ['config_module.settings'];
  // }


}
 
















