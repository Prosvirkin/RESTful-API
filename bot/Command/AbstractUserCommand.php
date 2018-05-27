<?php
namespace Base\Taskbot\Command;
use Longman\TelegramBot\Commands\UserCommand;
use Bricks\ServiceLocator\Manager as Locator;
use Base\Taskbot\Model\User\User;
use Base\Taskbot\Model\Mark\Mark;
use Base\Taskbot\Model\Task\Task;

abstract class AbstractUserCommand extends UserCommand{
  protected function injectDependency(Locator $locator){
    if(property_exists($this, 'currentUser')){
      $users = $locator['entity_manager']->getRepository(User::class);
      $this->currentUser = $users->find($this->getMessage()->getFrom()->getId());
    }
    if(property_exists($this, 'users')){
      $this->users = $locator['entity_manager']->getRepository(User::class);
    }
    if(property_exists($this, 'marks')){
      $this->marks = $locator['entity_manager']->getRepository(Mark::class);
    }
    if(property_exists($this, 'tasks')){
      $this->tasks = $locator['entity_manager']->getRepository(Task::class);
    }
  }

  public function preExecute(){
    $this->injectDependency($this->getTelegram()->locator);
    return parent::preExecute();
  }
}
