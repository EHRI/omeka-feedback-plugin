<div class="field">
    <div class="two columns alpha">
        <label for="feedback_recipient_emails"><?php echo __('Feedback Notification Sender'); ?></label>
    </div>
    <div class="inputs five columns omega">
        <p class="explanation">
            <?php echo __("The sender email for feedback notifications."); ?>
        </p>
        <?php echo get_view()->formText('feedback_notification_sender', get_option('feedback_notification_sender'), null, null); ?>
    </div>
</div>
<div class="field">
    <div class="two columns alpha">
        <label for="feedback_recipient_emails"><?php echo __('Feedback Recipient Email(s)'); ?></label>
    </div>
    <div class="inputs five columns omega">
        <p class="explanation">
            <?php echo __("Email recipients for the feedback submission system, comma-separated."); ?>
        </p>
        <?php echo get_view()->formText('feedback_recipient_emails', get_option('feedback_recipient_emails'), null, null); ?>
    </div>
</div>
