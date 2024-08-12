<?php
?>
<ul class="tnp-nav">
    <li class="<?php echo $_GET['page'] === 'newsletter_reports_index'?'active':''?>"><a href="?page=newsletter_reports_index"><?php _e('Overview', 'newsletter')?></a></li>
    <li class="<?php echo $_GET['page'] === 'newsletter_reports_newsletters'?'active':''?>"><a href="?page=newsletter_reports_newsletters"><?php _e('Newsletters', 'newsletter')?></a></li>
    <li class="<?php echo $_GET['page'] === 'newsletter_reports_indexurls'?'active':''?>"><a href="?page=newsletter_reports_indexurls"><?php _e('Links', 'newsletter')?></a></li>
</ul>
