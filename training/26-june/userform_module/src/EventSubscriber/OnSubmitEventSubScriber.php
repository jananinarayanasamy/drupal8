<?php

/**
 * @file
 * Contains \Drupal\userform_module\OnSubmitEventSubScriber.
 */
namespace Drupal\userform_module\EventSubscriber;

use Drupal\Core\Config\ConfigCrudEvent;
use Drupal\Core\Config\ConfigEvents;
use Drupal\userform_module\Event\OnSubmitEvent;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;


/**
 * Class OnSubmitEventSubScriber.
 *
 * @package Drupal\userform_module
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

	\Drupal::logger('userform_module')->notice("Data Inserted Successfuly Details: " . $OnSubmitEvent->PrintMsg() . " as Reference");
  }


}