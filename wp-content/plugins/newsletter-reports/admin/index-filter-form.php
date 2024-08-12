<?php
$type_options = $this->get_email_types();
?>
<form method="post" action="">
    <?php $controls->init(); ?>
    <?php if (!$is_continuous) $controls->select('days', ['30'=> 'Last 30 days', '180' => 'Last 6 months', '365' => 'Last year', '730' => 'Last two year', '0' => 'Since the beginning']) ?>
    <?php $controls->select('type', $type_options) ?>
    <?php $controls->button('update', __('Update')) ?>
</form>

