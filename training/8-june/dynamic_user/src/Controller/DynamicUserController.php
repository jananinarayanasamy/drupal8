<?php
 namespace Drupal\dynamic_user\Controller;
 use Drupal\Core\Controller\ControllerBase;
 use Drupal\user\Entity\User;
use Drupal\Component\Render\FormattableMarkup;

/**
 * An example controller.
 */
class DynamicUserController extends ControllerBase {

  /**
   * Returns a render-able array for a test page.
   */
  public function userArray() {
	
	$ids = \Drupal::entityQuery('user')
	->condition('status', 1)
	->execute();
	$users = User::loadMultiple($ids);
	foreach($users as $user){
		$username = $user->get('name')->value;
		$uid = $user->get('uid')->value;
		$mail = $user->get('mail')->value;
		$userlist[] = array('uid'=>$uid,'name'=>$username,'email'=>$mail);
		
	} 

	foreach ($userlist as $data) {
     $rows[] = [
	
	'uid' => $data['uid'],
	'name' => ucfirst($data['name']),
	'email' => ucfirst($data['email']),
		
    ]; 
}
$header = [
      'uid' => $this->t('UserId'),
      'name' => $this->t('Name'),
      'email' => $this->t('Email'),
	  	
    ];

	return array(
	  '#title' => $this->t('Users List'),	
	  '#theme' => 'table',
	  '#header' => $header,
	  '#rows' => $rows,
	);

}
  
  
    public function userDetail($uid) {
	
		$userData = \Drupal\user\Entity\User::load($uid);
		if($userData){
			$username = $userData->get('name')->value;
			$uid = $userData->get('uid')->value;
			$mail = $userData->get('mail')->value;
			$str = '<h1>Welcome '.$username.'! Your ID : '.$uid. ' and mail : ' .$mail.'</h1>';
			$build = [
				'#title'=> $this->t($username),
				'#markup' => $this->t($str),
				];
		}else{
			$build = [
			'#title'=> $this->t('Oops!!!'),
			'#markup' => $this->t('User not found'),
			];
		}
	
		return $build;
	}

  

}