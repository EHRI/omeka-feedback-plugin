<?php
$head = array('bodyclass' => 'feedback-items primary',
              'title' => html_escape(__('Feedback | Browse')),
              'content_class' => 'horizontal-nav');
echo head($head);
?>

<?php queue_css_string(".xpath { font-weight: bolder; }") ?>

<?php echo flash(); ?>

<?php if (!has_loop_records('feedback-items')): ?>
    <p><?php echo __('There is no feedback.'); ?></p>
<?php else: ?>
    <div id="feedback-items">
        <form id="tei-fields-form" method="post">

            <div>
                <table class="feedback-items">
                    <thead>
                        <tr>
                            <th><?php echo __('Email'); ?></th>
                            <th><?php echo __('Title'); ?></th>
                            <th><?php echo __('Feedback'); ?></th>
                            <th><?php echo __('Time'); ?></th>
                            <th></th>
                        </tr>
                    </thead>
                    <tbody>
                    <?php foreach (loop('feedback_items') as $item): ?>
                        <tr>
                            <td><?php echo $item->email;?></td>
                            <td><a href="<?php echo $item->url; ?>"><?php echo $item->title; ?></a></td>
                            <td><?php echo $item->feedback; ?></td>
                            <td><?php echo $item->created; ?></td>
                            <td><a class="delete-confirm" href="<?php echo html_escape(record_url($item, 'delete-confirm')); ?>">
                                    <?php echo __('Delete'); ?>
                                </a></td>
                        </tr>
                    <?php endforeach; ?>
                    </tbody>
                </table>
            </div>
        </form>
    </div>
<?php endif; ?>

<?php echo foot(); ?>
