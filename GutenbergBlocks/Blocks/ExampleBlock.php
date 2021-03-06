<?php
namespace GutenbergBlocks\Blocks;

if (!defined( 'WPINC')) {
	die;
}

class ExampleBlock extends BaseBlock {
    private static $_instance = null;

    public static function instance() {
        if (is_null(self::$_instance)) {
            self::$_instance = new self();
        }

        return self::$_instance;
    }

    function __construct($args = []) {
        parent::__construct();

        // It requires ACF
        if (function_exists('acf_register_block_type')) {
            add_action('acf/init', [$this, 'register_acf_block_type']);
        }
    }

    public function register_acf_block_type() {
        acf_register_block_type([
            'name' => 'block_name',
            'title' => 'Block Title',
            'description' => 'Block description',
            'render_callback' => [$this, 'render'],
            'icon' => 'format-quote',
            'keywords' => ['keyword1', 'keyword2', 'keyword3'],
            'enqueue_style' => $this->plugin_url . 'css/example-block.css',
        ]);
    }

    public function render() {
        $dummy_field_1 = get_field('dummy_field_1');
        $dummy_field_classname = get_field('dummy_field_classname');

        $className = 'example-block';
        if (!empty($block['className'])) {
            $className .= ' ' . $block['className'];
        }

        if (!empty($dummy_field_classname)) {
            $className .= ' example-block-class__' . $dummy_field_classname;
        }

        if (!empty($block['align'])) {
            $className .= ' align' . $block['align'];
        }
        ?>
        <div class="<?= esc_attr($className) ?>">
            <?= $dummy_field_1 ?>
        </div>
        <?php
    }
}
