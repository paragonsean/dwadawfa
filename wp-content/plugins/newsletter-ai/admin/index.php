<?php
/* @var $this NewsletterAI */
/* @var $controls NewsletterControls */

require_once NEWSLETTER_INCLUDES_DIR . '/controls.php';

$controls = new NewsletterControls();
?>

<div class="wrap" id="tnp-wrap">
    <?php include NEWSLETTER_ADMIN_HEADER ?>
    <div id="tnp-heading">
        <?php //$controls->title_help('/addons/extended-features/automated-extension/') ?>
        <h2>AI</h2>
    </div>

    <div id="tnp-body">
        <?php $controls->show(); ?>

        <p class="tnp-notice">
            This addon adds an AI text block and a subjects generator to the composer. Try them next time you create a newsletter!
        </p>

        <p>
            The Newsletter AI Addon is correctly installed. There are no configurations available right now.
        </p>
         <p>
            In this experimental phase, we're offering the service for free. It could stop to work if the monthly
            budget is reached.
        </p>
        <p>
            We use ChatGPT or Google Bard and to get the suggestions we send those elements:
        </p>
        <ul>
            <li>The text to be processed, for example the email subject</li>
            <li>The site name and description to give more context to the prompt</li>
            <li>The site language to get the answer in the correct language</li>
        </ul>
        <p>
            Other elements sent and used only by our service are:
        </p>
        <ul>
            <li>The site domain</li>
            <li>The Newsletter license key as configured in the Newsletter main settings</li>
        </ul>


        <form method="post" action="">
            <?php $controls->init(); ?>

        </form>
    </div>
    <?php include NEWSLETTER_ADMIN_FOOTER ?>
</div>
