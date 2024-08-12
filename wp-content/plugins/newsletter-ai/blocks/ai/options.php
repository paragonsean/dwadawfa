<?php
/*
 * @var $options array contains all the options the current block we're ediging contains
 * @var $controls NewsletterControls
 * @var $fields NewsletterFields
 */

$background = empty($options['block_background'])?$composer['block_background']:$options['block_background'];
?>

    <?php $fields->text('prompt', 'Prompt') ?> <input type="button" value="Go" onclick="tnp_ai_generate(this)">
<?php $fields->wp_editor( 'html', 'Content', [
	'text_font_family'  => $composer['text_font_family'],
	'text_font_size'    => $composer['text_font_size'],
	'text_font_weight'  => $composer['text_font_weight'],
	'text_font_color'   => $composer['text_font_color'],
        'background' => $background
] ) ?>
<?php $fields->block_commons() ?>
