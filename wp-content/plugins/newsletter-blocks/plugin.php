<?php

class NewsletterBlocks extends NewsletterAddon {

    /**
     * @var NewsletterBlocks
     */
    static $instance;

    function __construct($version) {
        self::$instance = $this;
        parent::__construct('blocks', $version, __DIR__);

        add_filter('newsletter_blocks_dir', [$this, 'hook_newsletter_blocks_dir']);
    }

    public function init() {
        parent::init();
    }

    function weekly_check() {
        parent::weekly_check();
        $license_key = Newsletter::instance()->get_license_key();
        $response = wp_remote_post('https://www.thenewsletterplugin.com/wp-content/addon-check.php?k=' . rawurlencode($license_key)
                . '&a=' . rawurlencode($this->name) . '&d=' . rawurlencode(home_url()) . '&v=' . rawurlencode($this->version)
                . '&ml=' . (Newsletter::instance()->is_multilanguage() ? '1' : '0'));
    }

    function hook_newsletter_blocks_dir($blocks_dir) {
        $blocks_dir[] = __DIR__ . '/blocks';

        return $blocks_dir;
    }
}
