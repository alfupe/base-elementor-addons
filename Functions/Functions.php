<?php
namespace Functions;

class Functions {

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
        //$this->some_other_function();
    }

    public function register_assets() {
        //wp_register_style('asset-handler', $this->plugin_url . 'assets/css/example-asset.css');
    }

    public function some_other_function() {
        //some stuff…
    }
}

Functions::instance();
