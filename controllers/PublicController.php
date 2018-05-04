<?php
/**
 * Feedback
 *
 * @copyright Copyright 2017 King's College London Department of Digital Humanities
 * @license http://www.gnu.org/licenses/gpl-3.0.txt GNU GPLv3
 */

/**
 * The Feedback Feedback controller.
 *
 * @package Feedback
 */
class Feedback_PublicController extends Omeka_Controller_AbstractActionController
{
    const TIMECHECK_SECS = 3;

    /**
     * @throws Zend_Form_Exception
     * @throws Zend_Mail_Exception
     * @throws Zend_Validate_Exception
     * @throws Omeka_Record_Exception
     */
    public function sendAction()
    {
        $form = $this->_getForm();
        $this->view->form = $form;

        if ($this->getRequest()->isPost()) {
            if ($form->isValid($_POST)) {
                $email = $form->getElement('email')->getValue();
                $title = $form->getElement('title')->getValue();
                $url = $form->getElement('url')->getValue();
                $feedback = $form->getElement('feedback')->getValue();

                $item = new FeedbackItem;
                $item->email = $email;
                $item->title = $title;
                $item->url = $url;
                $item->feedback = $feedback;
                $item->save(true);



                $body = sprintf("From: %s\nPage: %s\nURL:  %s\n------\n%s",
                    $email, $title, $url, $feedback);

                if (($sender = get_option('feedback_notification_sender')) and
                    ($recipients = get_option('feedback_recipient_emails'))) {

                    $mail = new Zend_Mail();
                    $mail->setBodyText($body);
                    $mail->setFrom($sender, 'Omeka Feedback');
                    foreach (explode(',', $recipients) as $recipient) {
                        $mail->addTo(trim($recipient));
                    }
                    $mail->setSubject(__("Feedback about page: %s", $form->getElement('title')->getValue()));
                    $mail->send();
                }

                if (!empty($_SERVER['HTTP_X_REQUESTED_WITH'])
                    && strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) == 'xmlhttprequest' ) {
                    //request is ajax
                    $this->_helper->json(["ok" => true]);
                } else {
                    $this->_helper->flashMessenger(__("Thanks for your feedback!"), 'success');
                    $this->redirect("/");
                }
            }
        }
    }

    /**
     * @return Zend_Form
     * @throws Zend_Form_Exception
     * @throws Zend_Validate_Exception
     */
    private function _getForm()
    {
        $time = new DateTime();
        $form = new Omeka_Form;
        $form->setAttrib('class', 'form panel-body');
        $form->setAttrib('role', 'form');
        $form->setMethod('POST');
        $form->setAction($this->getRequest()->getRequestUri());

        $form->addElement((new Zend_Form_Element_Text('email'))
            ->setAttrib('placeholder', __('Email'))
            ->setRequired(true)
            ->addValidator(new Zend_Validate_EmailAddress()));

        // add honeypot field
        $form->addElement((new Zend_Form_Element_Text('username'))
            ->setAttrib('class', 'noshow')
            ->setAttrib('placeholder', __('Username'))
            ->addValidator(new Zend_Validate_Identical('')));

        // add timecheck field
        $form->addElement((new Zend_Form_Element_Hidden('timestamp'))
            ->setValue($time->format('Y-m-d H:i:s'))
            ->addValidator(new Zend_Validate_Callback(function($value) use ($time) {
                $submitTime = new DateTime($value);
                return $submitTime->diff($time)->s > self::TIMECHECK_SECS;
            })));

        // Context...
        $form->addElement((new Zend_Form_Element_Hidden('title'))
            ->setValue(@$_GET["title"]));
        $form->addElement((new Zend_Form_Element_Hidden('url'))
            ->setValue(@$_GET["url"]));
        $form->addElement((new Zend_Form_Element_Textarea('feedback'))
            ->setAttrib('placeholder', __('Feedback'))
            ->setRequired(true));
        $form->addElement((new Zend_Form_Element_Submit('submit'))
            ->setLabel(__('Submit')));
        return $form;
    }
}
