<?php
/* @var $this NewsletterImport */

// phpcs:disable WordPress.WP.AlternativeFunctions.file_get_contents_file_get_contents

defined('ABSPATH') || exit;

include_once NEWSLETTER_INCLUDES_DIR . '/controls.php';
$controls = new NewsletterControls();

// If the import is active return to the import panel
if ($this->is_importing()) {
    $controls->js_redirect('?page=newsletter_import_csv');
}

$controls->warnings[] = 'The activation or welcome emails are NOT sent to imported subscribers. Read more on the help page.';
?>

<style>

    #tnp-body a.widget {
        display: block;
        padding: 15px;
        float: left;
        margin: 0 20px 0 0;
        border: 1px solid #ddd;
        height: 150px;
        overflow: hidden;
        width: 200px;
        text-decoration: none;
        background-color: #fff;
    }

    #tnp-body a.widget:hover {
        background-color: #ccc;
    }

    #tnp-body a.widget h3 {
        padding: 0;
        margin: 0;
    }
</style>

<div class="wrap" id="tnp-wrap">

    <?php include NEWSLETTER_ADMIN_HEADER ?>

    <div id="tnp-heading">
        <?php $controls->title_help('/addons/extended-features/advanced-import/') ?>
        <h2>Import/Export</h2>
        <?php include __DIR__ . '/nav.php' ?>
    </div>

    <div id="tnp-body">
        <?php $controls->show() ?>


        <p><?php esc_html_e('Pre-import backup is recommended.', 'newsletter-import') ?></p>

        <div style="clear: both"></div>

        <?php include __DIR__ . '/last-import-statistics.php'; ?>

        <?php if (file_exists(NEWSLETTER_LOG_DIR . '/import-report.txt')) { ?>
            <h3>Last import report</h3>
            <pre style="padding: 15px; background-color: white; font-family: monospace; height: 300px; overflow: auto"><?php echo esc_html(file_get_contents(NEWSLETTER_LOG_DIR . '/import-report.txt')) ?></pre>
        <?php } ?>
    </div>

    <?php include NEWSLETTER_DIR . '/tnp-footer.php'; ?>

</div>
