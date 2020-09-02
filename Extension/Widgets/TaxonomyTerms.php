<?php
namespace Extension\Widgets;

use Elementor\Group_Control_Typography;
use Elementor\Widget_Base;
use Elementor\Controls_Manager;
use Extension\Utils\Language;

if (!defined('ABSPATH')) {
    exit; // Exit if accessed directly.
}

class TaxonomyTerms extends Widget_Base {
    public function __construct($data = [], $args = null) {
        parent::__construct($data, $args);

        wp_register_style('cca-taxonomy-terms', plugins_url('../assets/css/taxonomy-terms.css', __DIR__));
    }

    public function get_name() {
        return 'cca-taxonomy-terms';
    }

    public function get_title() {
        return __('Taxonomy Terms', Language::TEXT_DOMAIN);
    }

    public function get_icon() {
        return 'eicon-tags';
    }

    public function get_categories() {
        return ['calmachicha_addons'];
    }

    public function get_style_depends() {
        return ['cca-taxonomy-terms'];
    }

    private function get_post_types() {
        $options = [];
        $exclude = ['attachment', 'elementor_library', 'page'];

        $args = [
            'public' => true,
        ];

        foreach (get_post_types($args, 'objects') as $post_type) {
            if (!isset($post_type->name)) {
                continue;
            }

            if (!isset($post_type->label)) {
                continue;
            }

            if (in_array($post_type->name, $exclude)) {
                continue;
            }

            $options[$post_type->name] = $post_type->label;
        }

        return $options;
    }

    protected function get_taxonomies($post_type = 'post') {
        $taxonomies = [];
        $exclude = ['post_format'];

        foreach (get_object_taxonomies($post_type) as $taxonomy) {
            if (in_array($taxonomy, $exclude)) {
                continue;
            }

            $taxonomies[$taxonomy] = $taxonomy;
        }

        return $taxonomies;
    }

    protected function get_taxonomy_terms($taxonomy = 'category') {
        $terms = [];
        $args = [
            'taxonomy' => $taxonomy,
            'hide_empty' => false
        ];

        foreach (get_terms($args) as $term) {
            $terms[$term->slug] = $term->name;
        }

        return $terms;
    }

    private function update_controls($post_type, $taxonomy) {
        $taxonomies = $this->get_taxonomies($post_type);

        $this->update_control('taxonomy', [
            'options' => $taxonomies
        ]);
        $this->update_control('terms', [
            'options' => $this->get_taxonomy_terms($taxonomy)
        ]);
    }

    protected function _register_controls() {
        // Content tab
        $this->grid_options_section();
        // Style tab
        $this->grid_style_section();
    }

    protected function grid_options_section() {
        $this->start_controls_section(
            'section_grid',
            [
                'label' => __('Query', Language::TEXT_DOMAIN),
            ]
        );

        // Post type
        $this->add_control(
            'post_type',
            [
                'type' => Controls_Manager::SELECT,
                'label' => __('Post Type', Language::TEXT_DOMAIN),
                'default' => 'post',
                'options' => $this->get_post_types(),
            ]
        );

        $this->add_control(
            'taxonomy',
            [
                'type' => Controls_Manager::SELECT,
                'label' => __('Taxonomy', Language::TEXT_DOMAIN)
            ]
        );

        $this->add_control(
            'terms',
            [
                'label' => __('Terms', Language::TEXT_DOMAIN),
                'type' => Controls_Manager::SELECT2,
                'multiple' => true,
                'label_block' => true
            ]
        );

        $this->end_controls_section();
    }

    protected function grid_style_section() {
        // Tab
        $this->start_controls_section(
            'section_grid_style',
            [
                'label' => __('Grid Options', Language::TEXT_DOMAIN),
                'tab' => Controls_Manager::TAB_STYLE,
            ]
        );

        $this->add_responsive_control(
            'grid_columns',
            [
                'type' => Controls_Manager::SELECT,
                'label' => '<i class="fa fa-columns"></i> ' . __('Columns', Language::TEXT_DOMAIN),
                'default' => 6,
                'tablet_default' => 2,
                'mobile_default' => 1,
                'options' => [
                    1 => 1,
                    2 => 2,
                    3 => 3,
                    4 => 4,
                    5 => 5,
                    6 => 6,
                    7 => 7,
                    8 => 8,
                    9 => 9,
                    10 => 10,
                    11 => 11,
                    12 => 12
                ],
                'selectors' => [
                    '{{WRAPPER}} .cca-taxonomy-terms' => 'grid-template-columns: repeat({{VALUE}}, 1fr);',
                ],
            ]
        );

        // Columns margin.
        $this->add_responsive_control(
            'grid_style_columns_gap',
            [
                'label' => __('Columns gap', Language::TEXT_DOMAIN),
                'type' => Controls_Manager::SLIDER,
                'range' => [
                    'px' => [
                        'min' => 0,
                        'max' => 100,
                    ],
                ],
                'devices' => ['desktop', 'tablet', 'mobile'],
                'desktop_default' => [
                    'size' => 30,
                    'unit' => 'px',
                ],
                'tablet_default' => [
                    'size' => 20,
                    'unit' => 'px',
                ],
                'mobile_default' => [
                    'size' => 10,
                    'unit' => 'px',
                ],
                'selectors' => [
                    '{{WRAPPER}} .cca-taxonomy-terms' => 'column-gap: {{SIZE}}{{UNIT}};',
                ],
            ]
        );

        // Row margin.
        $this->add_responsive_control(
            'grid_style_rows_gap',
            [
                'label' => __('Rows gap', Language::TEXT_DOMAIN),
                'type' => Controls_Manager::SLIDER,
                'range' => [
                    'px' => [
                        'min' => 0,
                        'max' => 100,
                    ],
                ],
                'devices' => ['desktop', 'tablet', 'mobile'],
                'desktop_default' => [
                    'size' => 30,
                    'unit' => 'px',
                ],
                'tablet_default' => [
                    'size' => 20,
                    'unit' => 'px',
                ],
                'mobile_default' => [
                    'size' => 10,
                    'unit' => 'px',
                ],
                'selectors' => [
                    '{{WRAPPER}} .cca-taxonomy-terms' => 'row-gap: {{SIZE}}{{UNIT}};',
                ]
            ]
        );

        $this->add_control(
            'justify_content',
            [
                'label' => __('Alignment', Language::TEXT_DOMAIN),
                'type' => Controls_Manager::CHOOSE,
                'default' => 'center',
                'options' => [
                    'flex-start' => [
                        'title' => __('Left', Language::TEXT_DOMAIN),
                        'icon' => 'fa fa-align-left',
                    ],
                    'center' => [
                        'title' => __('Center', Language::TEXT_DOMAIN),
                        'icon' => 'fa fa-align-center',
                    ],
                    'flex-end' => [
                        'title' => __('Right', Language::TEXT_DOMAIN),
                        'icon' => 'fa fa-align-right',
                    ],
                ],
                'devices' => ['desktop', 'tablet'],
                'selectors' => [
                    '{{WRAPPER}} .cca-taxonomy-terms__term' => 'justify-content: {{%s}};',
                ],
            ]
        );

        $this->add_control(
            'border_radius',
            [
                'label' => __('Border radius', Language::TEXT_DOMAIN),
                'type' => Controls_Manager::SLIDER,
                'range' => [
                    'px' => [
                        'min' => 0,
                        'max' => 100,
                    ],
                ],
                'desktop' => [
                    'size' => 0,
                    'unit' => 'px',
                ],
                'tablet_default' => [
                    'size' => 20,
                    'unit' => 'px',
                ],
                'mobile_default' => [
                    'size' => 10,
                    'unit' => 'px',
                ],
                'selectors' => [
                    '{{WRAPPER}} .cca-taxonomy-terms__term' => 'border-radius: {{SIZE}}{{UNIT}};',
                ]
            ]
        );

        $this->add_responsive_control(
            'content_padding',
            [
                'label' => __('Padding', Language::TEXT_DOMAIN),
                'type' => Controls_Manager::DIMENSIONS,
                'size_units' => ['px', 'em', '%'],
                'selectors' => [
                    '{{WRAPPER}} .cca-taxonomy-terms__term' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );

        $this->add_group_control(
            Group_Control_Typography::get_type(),
            [
                'name' => 'typography',
                'selector' => '{{WRAPPER}} .cca-taxonomy-terms__term',
            ]
        );

        $this->start_controls_tabs( 'tabs_styles' );

        $this->start_controls_tab(
            'styles_normal',
            [
                'label' => __('Normal', Language::TEXT_DOMAIN)
            ]
        );

        $this->add_control(
            'background_color',
            [
                'label' => __('Background Color', Language::TEXT_DOMAIN),
                'type' => Controls_Manager::COLOR,
                'default' => '#ffffff',
                'selectors' => [
                    '{{WRAPPER}} .cca-taxonomy-terms__term' => 'background-color: {{VALUE}};',
                ],
            ]
        );

        $this->add_control(
            'text_color',
            [
                'label' => __('Text Color', Language::TEXT_DOMAIN),
                'type' => Controls_Manager::COLOR,
                'default' => '#ffffff',
                'selectors' => [
                    '{{WRAPPER}} .cca-taxonomy-terms__term' => 'color: {{VALUE}};',
                ],
            ]
        );

        $this->end_controls_tab();

        $this->start_controls_tab(
            'styles_hover',
            [
                'label' => __('Hover', Language::TEXT_DOMAIN)
            ]
        );

        $this->add_control(
            'background_color_hover',
            [
                'label' => __('Background Color', Language::TEXT_DOMAIN),
                'type' => Controls_Manager::COLOR,
                'default' => '#ffffff',
                'selectors' => [
                    '{{WRAPPER}} .cca-taxonomy-terms__term:hover' => 'background-color: {{VALUE}};',
                ],
            ]
        );

        $this->add_control(
            'text_color_hover',
            [
                'label' => __('Text Color', Language::TEXT_DOMAIN),
                'type' => Controls_Manager::COLOR,
                'default' => '#ffffff',
                'selectors' => [
                    '{{WRAPPER}} .cca-taxonomy-terms__term:hover' => 'color: {{VALUE}};',
                ],
            ]
        );

        $this->end_controls_tab();

        $this->end_controls_section();
    }

    protected function render() {
        $settings = $this->get_settings_for_display();
        $post_type = isset($settings['post_type']) ? $settings['post_type'] : 'post';
        $taxonomy = isset($settings['taxonomy']) ? $settings['taxonomy'] : 'category';
        $terms = isset($settings['terms']) ? $settings['terms'] : [];
        $this->update_controls($post_type, $taxonomy);
        $this->add_render_attribute(
            'wrapper',
            [
                'class' => ['cca-taxonomy-terms', $settings['_css_classes']]
            ]
        );
        ?>
        <section <?= $this->get_render_attribute_string('wrapper'); ?>>
            <?php
            foreach ($terms as $term):
                if (term_exists($term, $taxonomy)):
                    $full_term = get_term_by('slug', $term, $taxonomy);
                ?>
                <a class="cca-taxonomy-terms__term"
                   href="<?= get_term_link($full_term->term_id) ?>"><?= $full_term->name ?></a>
            <?php
                endif;
            endforeach;
            ?>
        </section>
        <?php
    }
}
