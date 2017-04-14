<?php
/**
* @file
* Contains \Drupal\my_event_subscriber\EventSubscribe\MyEventSubscribe.
*/

namespace Drupal\my_event_subscriber\EventSubscriber;

use Drupal\like\LikeEvent;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;

/**
* Event Subscriber MyEventSubscriber.
*/
class MyEventSubscriber implements EventSubscriberInterface {


    /**
     * {@inheritdoc}
     */
    public static function getSubscribedEvents() {
        $events[LikeEvent::SUBMIT][] = ['onMySubmit'];
        return $events;
    }

    /**
    * Code that should be triggered on event specified
    */
    public function onMySubmit(LikeEvent $event) {
    // The RESPONSE event occurs once a response was created for replying to a request.
    // For example you could override or add extra HTTP headers in here
    //    drupal_set_message('ok');
        drupal_set_message('Send event:' . ' ' . $event->getUsername(). ' ' . $event->getAction() . ' '. $event->getNodeType() . ' ' . $event->getNodeTitle());
    }



}