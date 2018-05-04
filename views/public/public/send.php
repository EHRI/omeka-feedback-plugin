<?php echo head(); ?>
<h1><?php echo __('Send Feedback'); ?></h1>
<?php echo flash(); ?>
<?php echo $this->partial('public/feedback-form.php', ["form" => $form]); ?>
<?php echo foot(); ?>
