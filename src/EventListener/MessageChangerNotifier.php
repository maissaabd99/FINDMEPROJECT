<?php
namespace App\EventListener;

use App\Entity\Message;
use Doctrine\Persistence\Event\LifecycleEventArgs;

class MessageChangerNotifier
{
// the entity listener methods receive two arguments:
// the entity instance and the lifecycle event
public function postUpdate(Message $message, LifecycleEventArgs $event): void
{
               echo 'changes';
}
}