<?php

?>
<ul class="tnp-nav">
    <li class="<?php echo $_GET['page'] === ''?'active':''?>"><a href="?page=newsletter_automated_index">&laquo;</a></li>

    <?php if ($channel->theme_type == NewsletterAutomated::THEME_TYPE_COMPOSER) { ?>
    <li class="<?php echo $_GET['page'] === 'newsletter_automated_edit'?'active':''?>"><a href="?page=newsletter_automated_edit&id=<?php echo $channel->id?>"><?php _e('Settings', 'newsletter')?></a></li>
    <li class="<?php echo $_GET['page'] === 'newsletter_automated_template'?'active':''?>"><a href="?page=newsletter_automated_template&id=<?php echo $channel->id?>"><?php _e('Template', 'newsletter')?></a></li>
    <?php } else { ?>
    <li class="<?php echo $_GET['page'] === 'newsletter_automated_editlegacy'?'active':''?>"><a href="?page=newsletter_automated_editlegacy&id=<?php echo $channel->id?>"><?php _e('Settings', 'newsletter')?></a></li>
    <?php } ?>
    <li class="<?php echo $_GET['page'] === 'newsletter_automated_newsletters'?'active':''?>"><a href="?page=newsletter_automated_newsletters&id=<?php echo $channel->id?>"><?php _e('Newsletters', 'newsletter')?></a></li>
    <li class="<?php echo $_GET['page'] === 'newsletter_automated_logs'?'active':''?>"><a href="?page=newsletter_automated_logs&id=<?php echo $channel->id?>"><?php _e('Logs', 'newsletter')?></a></li>
</ul>
