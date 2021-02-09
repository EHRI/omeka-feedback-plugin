<?php
/**
 * @package     omeka-feedback-plugin
 * @copyright   King's College London Department of Digital Humanities
 * @license     https://joinup.ec.europa.eu/collection/eupl/eupl-text-eupl-12
 */

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
