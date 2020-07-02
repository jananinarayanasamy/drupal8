<?php

/**
 * @file
 * Contains \Drupal\custom_user_module\OnSubmitEventSubScriber.
 */
namespace Drupal\custom_user_module\EventSubscriber;

use Drupal\Core\Config\ConfigCrudEvent;
use Drupal\Core\Config\ConfigEvents;
use Drupal\custom_user_module\Event\OnSubmitEvent;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use Symfony\Component\HttpFoundation\RedirectResponse;
/**
 * Class OnSubmitEventSubScriber.
 *
 * @package Drupal\custom_user_module
 */
class OnSubmitEventSubScriber implements EventSubscriberInterface {

  /**
   * {@inheritdoc}
   */
  public static function getSubscribedEvents() {	
	return [
      OnSubmitEvent::SUBMIT_EVENT => 'UserLogSubmit',
    ];

  }

  /**
   * Subscriber Callback for the event.
   * @param OnSubmitEvent $OnSubmitEvent
   */
  public function UserLogSubmit(OnSubmitEvent $OnSubmitEvent) {

	$uid = $OnSubmitEvent->PrintMsg();
	
	$response = new RedirectResponse('/web/users/'.$uid);
    $response->send();
	return;
  	
	
  }


}