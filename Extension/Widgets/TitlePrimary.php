<?php
namespace Extension\Widgets;

use Elementor\Core\Kits\Documents\Tabs\Global_Colors;
use Elementor\Core\Kits\Documents\Tabs\Global_Typography;
use Extension\Utils\Language;

if (!defined('ABSPATH')) {
    exit; // Exit if accessed directly.
}

class TitlePrimary extends Widget_Base {
    public function __construct($data = [], $args = null) {
        parent::__construct($data, $args);

        wp_register_style('ydd-global-styles', plugins_url('../assets/css/ydd-global-styles.css', __DIR__));
    }

	public function get_name() {
		return 'ydd-title-primary';
	}

	public function get_title() {
		return __('Title Primary', Language::TEXT_DOMAIN);
	}

	public function get_icon() {
		return 'eicon-t-letter';
	}

    public function get_categories() {
        return ['base_elementor_addons_custom_category'];
    }

	public function get_keywords() {
		return ['heading', 'title', 'text'];
	}

	protected function _register_controls() {
		$this->start_controls_section(
			'section_title',
			[
				'label' => __('Title', Language::TEXT_DOMAIN),
			]
		);

		$this->add_control(
			'title',
			[
				'label' => __('Title', Language::TEXT_DOMAIN),
				'type' => Controls_Manager::TEXTAREA,
				'dynamic' => [
					'active' => true,
				],
				'placeholder' => __('Enter your title', Language::TEXT_DOMAIN),
				'default' => __('Add Your Heading Text Here', Language::TEXT_DOMAIN),
			]
		);

		$this->add_control(
			'link',
			[
				'label' => __('Link', Language::TEXT_DOMAIN),
				'type' => Controls_Manager::URL,
				'dynamic' => [
					'active' => true,
				],
				'default' => [
					'url' => '',
				],
				'separator' => 'before',
			]
		);

		$this->add_control(
			'size',
			[
				'label' => __('Size', Language::TEXT_DOMAIN),
				'type' => Controls_Manager::SELECT,
				'default' => 'default',
				'options' => [
					'default' => __('Default', Language::TEXT_DOMAIN),
					'small' => __('Small', Language::TEXT_DOMAIN),
					'medium' => __('Medium', Language::TEXT_DOMAIN),
					'large' => __('Large', Language::TEXT_DOMAIN),
					'xl' => __('XL', Language::TEXT_DOMAIN),
					'xxl' => __('XXL', Language::TEXT_DOMAIN),
				],
			]
		);

		$this->add_control(
			'header_size',
			[
				'label' => __('HTML Tag', Language::TEXT_DOMAIN),
				'type' => Controls_Manager::SELECT,
				'options' => [
					'h1' => 'H1',
					'h2' => 'H2',
					'h3' => 'H3',
					'h4' => 'H4',
					'h5' => 'H5',
					'h6' => 'H6',
					'div' => 'div',
					'span' => 'span',
					'p' => 'p',
				],
				'default' => 'h2',
			]
		);

		$this->add_responsive_control(
			'align',
			[
				'label' => __('Alignment', Language::TEXT_DOMAIN),
				'type' => Controls_Manager::CHOOSE,
				'options' => [
					'left' => [
						'title' => __('Left', Language::TEXT_DOMAIN),
						'icon' => 'eicon-text-align-left',
					],
					'center' => [
						'title' => __('Center', Language::TEXT_DOMAIN),
						'icon' => 'eicon-text-align-center',
					],
					'right' => [
						'title' => __('Right', Language::TEXT_DOMAIN),
						'icon' => 'eicon-text-align-right',
					],
					'justify' => [
						'title' => __('Justified', Language::TEXT_DOMAIN),
						'icon' => 'eicon-text-align-justify',
					],
				],
				'default' => '',
				'selectors' => [
					'{{WRAPPER}}' => 'text-align: {{VALUE}};',
				],
			]
		);

		$this->add_control(
			'view',
			[
				'label' => __('View', Language::TEXT_DOMAIN),
				'type' => Controls_Manager::HIDDEN,
				'default' => 'traditional',
			]
		);

		$this->end_controls_section();

		$this->start_controls_section(
			'section_title_style',
			[
				'label' => __('Title', Language::TEXT_DOMAIN),
				'tab' => Controls_Manager::TAB_STYLE,
			]
		);

		$this->add_control(
			'title_color',
			[
				'label' => __('Text Color', Language::TEXT_DOMAIN),
				'type' => Controls_Manager::COLOR,
				'global' => [
					'default' => Global_Colors::COLOR_PRIMARY,
				],
				'selectors' => [
					'{{WRAPPER}} .ydd-heading-title' => 'color: {{VALUE}};',
				],
			]
		);

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			[
				'name' => 'typography',
				'global' => [
					'default' => Global_Typography::TYPOGRAPHY_PRIMARY,
				],
				'selector' => '{{WRAPPER}} .ydd-heading-title',
			]
		);

		$this->add_group_control(
			Group_Control_Text_Shadow::get_type(),
			[
				'name' => 'text_shadow',
				'selector' => '{{WRAPPER}} .ydd-heading-title',
			]
		);

		$this->add_control(
			'blend_mode',
			[
				'label' => __('Blend Mode', Language::TEXT_DOMAIN),
				'type' => Controls_Manager::SELECT,
				'options' => [
					'' => __('Normal', Language::TEXT_DOMAIN),
					'multiply' => 'Multiply',
					'screen' => 'Screen',
					'overlay' => 'Overlay',
					'darken' => 'Darken',
					'lighten' => 'Lighten',
					'color-dodge' => 'Color Dodge',
					'saturation' => 'Saturation',
					'color' => 'Color',
					'difference' => 'Difference',
					'exclusion' => 'Exclusion',
					'hue' => 'Hue',
					'luminosity' => 'Luminosity',
				],
				'selectors' => [
					'{{WRAPPER}} .ydd-heading-title' => 'mix-blend-mode: {{VALUE}}',
				],
				'separator' => 'none',
			]
		);

		$this->end_controls_section();
	}

	protected function render() {
		$settings = $this->get_settings_for_display();

		if ('' === $settings['title']) {
			return;
		}

		$this->add_render_attribute('title', 'class', 'ydd-heading-title');

		if ( ! empty( $settings['size'] ) ) {
			$this->add_render_attribute('title', 'class', 'ydd-size-' . $settings['size']);
		}

		$this->add_inline_editing_attributes('title');

		$title = $settings['title'];

		if (!empty($settings['link']['url'])) {
			$this->add_link_attributes('url', $settings['link']);

			$title = sprintf('<a %1$s>%2$s</a>', $this->get_render_attribute_string('url'), $title);
		}

		$title_html = sprintf('<%1$s %2$s>%3$s</%1$s>', $settings['header_size'], $this->get_render_attribute_string('title'), $title);

		echo $title_html;
	}

	protected function content_template() {
		?>
		<#
		var title = settings.title;

		if ('' !== settings.link.url) {
			title = '<a href="' + settings.link.url + '">' + title + '</a>';
		}

        view.addRenderAttribute('title', 'class', ['ydd-heading-title', 'ydd-size-' + settings.size]);

		view.addInlineEditingAttributes('title');

		var title_html = '<' + settings.header_size  + ' ' + view.getRenderAttributeString('title') + '>' + title + '</' + settings.header_size + '>';

		print( title_html );
		#>
		<?php
	}
}
