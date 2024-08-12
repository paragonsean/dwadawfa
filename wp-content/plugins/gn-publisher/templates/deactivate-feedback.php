<?php 
$reasons = array(
    	1 => '<li><label><input type="radio" name="gnpub_disable_reason" value="temporary"/>' . esc_html__('It is only temporary', 'gn-publisher') . '</label></li>',
		2 => '<li><label><input type="radio" name="gnpub_disable_reason" value="stopped"/>' . esc_html__('I stopped using GN Publisher on my site', 'gn-publisher') . '</label></li>',
		3 => '<li><label><input type="radio" name="gnpub_disable_reason" value="missing"/>' . esc_html__('I miss a feature', 'gn-publisher') . '</label></li>
		<li><input type="text" class="mb-box missing" name="gnpub_disable_text[]" value="" placeholder="Please describe the feature"/></li>',
		4 => '<li><label><input type="radio" name="gnpub_disable_reason" value="technical"/>' . esc_html__('Technical Issue', 'gn-publisher') . '</label></li>
		<li><textarea  class="mb-box technical" name="gnpub_disable_text[]" placeholder="' . esc_html__('How Can we help? Please describe your problem', 'gn-publisher') . '"></textarea></li>',
		5 => '<li><label><input type="radio" name="gnpub_disable_reason" value="another"/>' . esc_html__('I switched to another plugin', 'gn-publisher') .  '</label></li>
		<li><input type="text"  class="mb-box another" name="gnpub_disable_text[]" value="" placeholder="Name of the plugin"/></li>',
		6 => '<li><label><input type="radio" name="gnpub_disable_reason" value="other"/>' . esc_html__('Other reason', 'gn-publisher') . '</label></li>
		<li><textarea  class="mb-box other" name="gnpub_disable_text[]" placeholder="' . esc_html__('Please specify, if possible', 'gn-publisher') . '"></textarea></li>',
    );
shuffle($reasons);
?>


<div id="gnpub-feedback-overlay" style="display: none;">
    <div id="gnpub-feedback-content">
	<form action="" method="post">
	    <h3><strong><?php echo esc_html__('If you have a moment, please let us know why you are deactivating:', 'gn-publisher'); ?></strong></h3>
	    <ul>
                <?php 
                foreach ($reasons as $reason){
                    echo $reason;
                }
                ?>
	    </ul>
	    <?php if ($email) : ?>
    	    <input type="hidden" name="gnpub_disable_from" value="<?php echo $email; ?>"/>
	    <?php endif; ?>
	    <input id="gnpub-feedback-submit" class="button button-primary" type="submit" name="gnpub_disable_submit" value="<?php echo esc_html__('Submit & Deactivate', 'gn-publisher'); ?>"/>
	    <a class="button"><?php echo esc_html__('Only Deactivate', 'gn-publisher'); ?></a>
	    <a class="gnpub-feedback-not-deactivate" href="#"><?php echo esc_html__('Don\'t deactivate', 'gn-publisher'); ?></a>
	</form>
    </div>
</div>