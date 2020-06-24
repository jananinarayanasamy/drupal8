<?php
namespace Drupal\setting_module\Controller;
use Drupal\Core\Controller\ControllerBase;
 //use Drupal\user\Entity\User;


class SettingModController extends ControllerBase {

	public function content($name) {
		
	 return array(
				'#theme' => 'setting_module',
				'#test_var' => $this->t(ucfirst($name)),
			);
			
	}
}