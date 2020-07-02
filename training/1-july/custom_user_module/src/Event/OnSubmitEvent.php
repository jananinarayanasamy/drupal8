<?php

namespace Drupal\custom_user_module\Event;

use Symfony\Component\EventDispatcher\Event;

class OnSubmitEvent extends Event {

  const SUBMIT_EVENT = 'submit.event';
  
  protected $insertedId;


  public function __construct($insertedId)
  {
    $this->insertedId = $insertedId;
  }

  public function PrintMsg()
  {
    return $this->insertedId;
  }
}