<?php
/**
 * @package     omeka-feedback-plugin
 * @copyright   King's College London Department of Digital Humanities
 * @license     https://joinup.ec.europa.eu/collection/eupl/eupl-text-eupl-12
 */

/**
 * The Feedback record class.
 */
class Feedback_ItemsController extends Omeka_Controller_AbstractActionController
{

    public function init()
    {
        // Set the model class so this controller can perform some functions,
        // such as $this->findById()
        $this->_helper->db->setDefaultModelName('FeedbackItem');
    }

    public function indexAction()
    {
        // Always go to browse.
        $this->_helper->redirector('browse');
        return;
    }

    protected function _getDeleteSuccessMessage($record)
    {
        return __('The feedback item has been deleted.');
    }
}
