<?php

namespace Drupal\userform_module\Event;

use Symfony\Component\EventDispatcher\Event;

class OnSubmitEvent extends Event {

  const SUBMIT_EVENT = 'submit.event';
  protected $loggerMsg;
  protected $insertedId;
  protected $InsertedName;

  public function __construct($loggerMsg,$insertedId,$InsertedName)
  {
    $this->loggerMsg = $loggerMsg;
    $this->insertedId = $insertedId;
    $this->InsertedName = $InsertedName;
    
  }

  public function PrintMsg()
  {
  
    return $this->InsertedName;
	
  }
}