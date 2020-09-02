<?php
namespace GutenbergBlocks\Blocks;

if (!defined( 'ABSPATH')) {
    exit; // Exit if accessed directly.
}

class BaseBlock {
    protected $plugin_url = '';
    protected $plugin_path = '';

    public function __construct() {
        $this->plugin_url = plugin_dir_url(__DIR__);
        $this->plugin_path = plugin_dir_path(__DIR__);
    }
}
