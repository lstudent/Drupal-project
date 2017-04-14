<?php
namespace Drupal\like;
use Symfony\Component\EventDispatcher\Event;
class LikeEvent extends Event {
    const SUBMIT = 'event.submit';
    protected $username;
    protected $action;
    protected $nodeType;
    protected $nodeTitle;

    public function __construct($username, $action, $nodeType, $nodeTitle)
    {
        $this->username = $username;
        $this->action = $action;
        $this->nodeType = $nodeType;
        $this->nodeTitle = $nodeTitle;
    }
    public function getUsername()
    {
        return $this->username;
    }
    public function getAction()
    {
        return $this->action;
    }
    public function getNodeType()
    {
        return $this->nodeType;
    }
    public function getNodeTitle()
    {
        return $this->nodeTitle;
    }

    public function myEventDescription() {
        return "This is as an example event";
    }
}