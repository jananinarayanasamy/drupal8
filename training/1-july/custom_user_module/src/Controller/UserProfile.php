<?php
namespace Drupal\custom_user_module\Controller;
use Drupal\Core\Controller\ControllerBase;
use Drupal\Component\Render\FormattableMarkup;

/**
 * An example controller.
 */
class UserProfile extends ControllerBase {

  /**
   * Returns a render-able array for a test page.
   */
  public function DisplayData($uid) {
	
	$query = \Drupal::database()->select('user_personal_data', 'u');
	$query->fields('u', ['uid','first_name','last_name','gender','biography','interest']);
	$query->condition('u.uid', $uid, '=');
	$result = $query->execute()->fetchAll();	
	$results=json_decode(json_encode($result), true);
		
	$build = [
          '#theme' => 'user_profile',
          '#title' => false,
          '#profile' => $results,
        ];
	return $build;
  }
	
  

}