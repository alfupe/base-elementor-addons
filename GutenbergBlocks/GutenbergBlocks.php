<?php
namespace GutenbergBlocks;

use GutenbergBlocks\Blocks\ExampleBlock;

class GutenbergBlocks {

    private static $_instance = null;
    protected $plugin_url = '';

    public static function instance() {
        if (is_null(self::$_instance)) {
            self::$_instance = new self();
        }

        return self::$_instance;
    }

    public function __construct() {
        $this->plugin_url = plugin_dir_url(__DIR__);
        //$this->register_assets();
        $this->register_blocks();
    }

    public function register_assets() {
        //wp_register_style('asset-handler', $this->plugin_url . 'assets/css/example-asset.css');
    }

    public function register_blocks() {
        ExampleBlock::instance();
    }
}

GutenbergBlocks::instance();
