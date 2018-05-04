<?php
/**
 * Feedback
 *
 * @copyright Copyright 2017 King's College London Department of Digital Humanities
 * @license http://www.gnu.org/licenses/gpl-3.0.txt GNU GPLv3
 */

/**
 * The Feedback Edition record class.
 *
 * @package Feedback
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
