<?php


class FeedbackItem extends Omeka_Record_AbstractRecord implements Zend_Acl_Resource_Interface
{
    public $url;
    public $title;
    public $email;
    public $feedback;

    public function getRecordUrl($action = 'show')
    {
        return array('module' => 'feedback', 'controller' => 'items',
            'action' => $action, 'id' => $this->id);
    }

    public function getResourceId()
    {
        return 'Feedback_FeedbackItem';
    }
}
