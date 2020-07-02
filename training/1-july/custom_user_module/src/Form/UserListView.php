<?php


namespace Drupal\custom_user_module\Form;


use Drupal\Core\Form\FormBase;
use Drupal\Core\Form\FormStateInterface;
use Symfony\Component\DependencyInjection\ContainerInterface;
use Drupal\Core\Form\drupal_set_message;
use Drupal\Core\Entity\t;
use Drupal\user\Entity\User;


/**
 * Class Configuration Setting.
 *
 * @package Drupal\config_module\Form
 */
class UserListView extends FormBase {


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
	
		$query = \Drupal::database()->select('users_field_data', 'u');
		$query->fields('u', ['uid','name','mail','status']);
		$query->condition('u.uid', 0, '>');
		$query->condition('u.status', 0, '=');
		$result = $query->execute()->fetchAll();
		
		$options=[];
		$i = 0;
		$results=json_decode(json_encode($result), true);
		
		foreach($results as $key => $val){
			 $arrKey = $val['uid'];
			 if($val['status']==0){$val['status']="Inactive";} else{$val['status']="Active";}
			 $options[$arrKey]=$val;
            $i++;  
        }

		
		
		
	// TableSelect.
  
	$header = [
      'uid' => $this->t('User Id'),
      'name' => $this->t('User Name'),
      'mail' => $this->t('Email'),
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
      '#value' => $this->t('Approved'),
      '#button_type' => 'primary',
    );
	
	return $form;
  }


  /**
   * {@inheritdoc}
   */
  public function getFormId() {
    return 'custom_user_module';
  }


  /**
   * {@inheritdoc}
   */
   public function submitForm(array &$form, FormStateInterface $form_state) {
    // Find out what was submitted.
	
		$data = array_filter($form_state->getValue('table'));
		foreach($data as $id){
			$user = User::load($id);
			$user->set('status', 1);
			$user->addRole('user');
			$user->save();	 
		}
			
		
	/* $uid = \Drupal::currentUser()->id();
	$data = $form_state->getValue('table');
	
	$cust_service = \Drupal::service('custom_user_module.insert')->editConfig($data); */
	
	drupal_set_message($this->t("@message", ['@message' => 'Successfully Updated.']));
  }	
  


}
 
















