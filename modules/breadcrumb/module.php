<?php
/**
 * Module Breadcrumb
 *
 * @package LiveComposer
 */

// Prevent direct access to the file.
if ( ! defined( 'ABSPATH' ) ) {
	header( 'HTTP/1.0 403 Forbidden' );
	exit;
}

include DS_LIVE_COMPOSER_ABS . '/modules/breadcrumb/functions.php';

/**
 * Module Class
 */
class DSLC_Breadcrumb extends DSLC_Module {

	/**
	 * Unique module id
	 *
	 * @var string
	 */
	var $module_id;

	/**
	 * Module label to show in the page builder
	 *
	 * @var string
	 */
	var $module_title;

	/**
	 * Module icon name (FontAwesome)
	 *
	 * @var string
	 */
	var $module_icon;

	/**
	 * Section in the modules panel that includes this module
	 *
	 * @var string
	 */
	var $module_category;

	/**
	 * Construct
	 */
	function __construct() {

		$this->module_id = 'DSLC_Breadcrumb';
		$this->module_title = __( 'Breadcrumb', 'live-composer-page-builder' );
		$this->module_icon = 'chevron-right';
		$this->module_category = 'General';

	}

	/**
	 * Module options.
	 * Function build array with all the module functionality and styling options.
	 * Based on this array Live Composer builds module settings panel.
	 * – Every array inside $dslc_options means one option = one control.
	 * – Every option should have unique (for this module) id.
	 * – Options divides on "Functionality" and "Styling".
	 * – Styling options start with css_XXXXXXX
	 * – Responsive options start with css_res_t_ (Tablet) or css_res_p_ (Phone)
	 * – Options can be hidden.
	 * – Options can have a default value.
	 * – Options can request refresh from server on change or do live refresh via CSS.
	 *
	 * @return array All the module options in array.
	 */
	function options() {

		$dslc_options = array(

			array(
				'label' => __( 'Show On', 'live-composer-page-builder' ),
				'id' => 'css_show_on',
				'std' => 'desktop tablet phone',
				'type' => 'checkbox',
				'choices' => array(
					array(
						'label' => __( 'Desktop', 'live-composer-page-builder' ),
						'value' => 'desktop',
					),
					array(
						'label' => __( 'Tablet', 'live-composer-page-builder' ),
						'value' => 'tablet',
					),
					array(
						'label' => __( 'Phone', 'live-composer-page-builder' ),
						'value' => 'phone',
					),
				),
			),
			array(
				'label' => __( 'BG Color', 'live-composer-page-builder' ),
				'id' => 'css_bg_color',
				'std' => '',
				'type' => 'color',
				'refresh_on_change' => false,
				'affect_on_change_el' => '.breadcrumbs',
				'affect_on_change_rule' => 'background-color',
				'section' => 'styling',
			),
			array(
				'label' => __( 'Border', 'live-composer-page-builder' ),
				'id' => 'css_border_group',
				'type' => 'group',
				'action' => 'open',
				'section' => 'styling',
			),
				array(
					'label' => __( 'Color', 'live-composer-page-builder' ),
					'id' => 'css_border_color',
					'std' => '',
					'type' => 'color',
					'refresh_on_change' => false,
					'affect_on_change_el' => '.breadcrumbs',
					'affect_on_change_rule' => 'border-color',
					'section' => 'styling',
				),
				array(
					'label' => __( 'Width', 'live-composer-page-builder' ),
					'id' => 'css_border_width',
					'onlypositive' => true, // Value can't be negative.
					'std' => '',
					'type' => 'slider',
					'refresh_on_change' => false,
					'affect_on_change_el' => '.breadcrumbs',
					'affect_on_change_rule' => 'border-width',
					'section' => 'styling',
					'ext' => 'px',
				),
				array(
					'label' => __( 'Borders', 'live-composer-page-builder' ),
					'id' => 'css_border_trbl',
					'std' => '',
					'type' => 'checkbox',
					'choices' => array(
						array(
							'label' => __( 'Top', 'live-composer-page-builder' ),
							'value' => 'top',
						),
						array(
							'label' => __( 'Right', 'live-composer-page-builder' ),
							'value' => 'right',
						),
						array(
							'label' => __( 'Bottom', 'live-composer-page-builder' ),
							'value' => 'bottom',
						),
						array(
							'label' => __( 'Left', 'live-composer-page-builder' ),
							'value' => 'left',
						),
					),
					'refresh_on_change' => false,
					'affect_on_change_el' => '.breadcrumbs',
					'affect_on_change_rule' => 'border-style',
					'section' => 'styling',
				),
				array(
					'label' => __( 'Radius Top - Left', 'live-composer-page-builder' ),
					'id' => 'css_border_radius_top_left',
					'onlypositive' => true, // Value can't be negative.
					'std' => '',
					'type' => 'slider',
					'refresh_on_change' => false,
					'affect_on_change_el' => '.breadcrumbs',
					'affect_on_change_rule' => 'border-top-left-radius',
					'section' => 'styling',
					'ext' => 'px',
				),
				array(
					'label' => __( 'Radius Top - Right', 'live-composer-page-builder' ),
					'id' => 'css_border_radius_top_right',
					'onlypositive' => true, // Value can't be negative.
					'std' => '',
					'type' => 'slider',
					'refresh_on_change' => false,
					'affect_on_change_el' => '.breadcrumbs',
					'affect_on_change_rule' => 'border-top-right-radius',
					'section' => 'styling',
					'ext' => 'px',
				),
				array(
					'label' => __( 'Radius Bottom - Left', 'live-composer-page-builder' ),
					'id' => 'css_border_radius_bottom_left',
					'onlypositive' => true, // Value can't be negative.
					'std' => '',
					'type' => 'slider',
					'refresh_on_change' => false,
					'affect_on_change_el' => '.breadcrumbs',
					'affect_on_change_rule' => 'border-bottom-left-radius',
					'section' => 'styling',
					'ext' => 'px',
				),
				array(
					'label' => __( 'Radius Bottom - Right', 'live-composer-page-builder' ),
					'id' => 'css_border_radius_bottom_right',
					'onlypositive' => true, // Value can't be negative.
					'std' => '',
					'type' => 'slider',
					'refresh_on_change' => false,
					'affect_on_change_el' => '.breadcrumbs',
					'affect_on_change_rule' => 'border-bottom-right-radius',
					'section' => 'styling',
					'ext' => 'px',
				),
			array(
				'id' => 'css_border_group',
				'type' => 'group',
				'action' => 'close',
				'section' => 'styling',
			),
			array(
				'label' => __( 'Margin', 'live-composer-page-builder' ),
				'id' => 'css_margin_group',
				'type' => 'group',
				'action' => 'open',
				'section' => 'styling',
			),
				array(
					'label' => __( 'Top', 'live-composer-page-builder' ),
					'id' => 'css_margin_top',
					'std' => '',
					'type' => 'slider',
					'refresh_on_change' => false,
					'affect_on_change_el' => '.breadcrumbs',
					'affect_on_change_rule' => 'margin-top',
					'section' => 'styling',
					'ext' => 'px',
				),
				array(
					'label' => __( 'Right', 'live-composer-page-builder' ),
					'id' => 'css_margin_right',
					'std' => '',
					'type' => 'slider',
					'refresh_on_change' => false,
					'affect_on_change_el' => '.breadcrumbs',
					'affect_on_change_rule' => 'margin-right',
					'section' => 'styling',
					'ext' => 'px',
				),
				array(
					'label' => __( 'Bottom', 'live-composer-page-builder' ),
					'id' => 'css_margin_bottom',
					'std' => '',
					'type' => 'slider',
					'refresh_on_change' => false,
					'affect_on_change_el' => '.breadcrumbs',
					'affect_on_change_rule' => 'margin-bottom',
					'section' => 'styling',
					'ext' => 'px',
				),
				array(
					'label' => __( 'Left', 'live-composer-page-builder' ),
					'id' => 'css_margin_left',
					'std' => '',
					'type' => 'slider',
					'refresh_on_change' => false,
					'affect_on_change_el' => '.breadcrumbs',
					'affect_on_change_rule' => 'margin-left',
					'section' => 'styling',
					'ext' => 'px',
				),
			array(
				'id' => 'css_margin_group',
				'type' => 'group',
				'action' => 'close',
				'section' => 'styling',
			),
			array(
				'label' => __( 'Padding', 'live-composer-page-builder' ),
				'id' => 'css_padding_group',
				'type' => 'group',
				'action' => 'open',
				'section' => 'styling',
			),
				array(
					'label' => __( 'Top', 'live-composer-page-builder' ),
					'id' => 'css_padding_top',
					'std' => '',
					'type' => 'slider',
					'refresh_on_change' => false,
					'affect_on_change_el' => '.breadcrumbs',
					'affect_on_change_rule' => 'padding-top',
					'section' => 'styling',
					'ext' => 'px',
				),
				array(
					'label' => __( 'Right', 'live-composer-page-builder' ),
					'id' => 'css_padding_right',
					'std' => '',
					'type' => 'slider',
					'refresh_on_change' => false,
					'affect_on_change_el' => '.breadcrumbs',
					'affect_on_change_rule' => 'padding-right',
					'section' => 'styling',
					'ext' => 'px',
				),
				array(
					'label' => __( 'Bottom', 'live-composer-page-builder' ),
					'id' => 'css_padding_bottom',
					'std' => '',
					'type' => 'slider',
					'refresh_on_change' => false,
					'affect_on_change_el' => '.breadcrumbs',
					'affect_on_change_rule' => 'padding-bottom',
					'section' => 'styling',
					'ext' => 'px',
				),
				array(
					'label' => __( 'Left', 'live-composer-page-builder' ),
					'id' => 'css_padding_left',
					'std' => '',
					'type' => 'slider',
					'refresh_on_change' => false,
					'affect_on_change_el' => '.breadcrumbs',
					'affect_on_change_rule' => 'padding-left',
					'section' => 'styling',
					'ext' => 'px',
				),
			array(
				'id' => 'css_padding_group',
				'type' => 'group',
				'action' => 'close',
				'section' => 'styling',
			),

			/**
			 * Typography
			 */

			array(
				'label' => __( 'Border', 'live-composer-page-builder' ),
				'id' => 'css_typography_border_group',
				'type' => 'group',
				'action' => 'open',
				'section' => 'styling',
				'tab' => __( 'Typography', 'live-composer-page-builder' ),
			),
				array(
					'label' => __( 'Color', 'live-composer-page-builder' ),
					'id' => 'css_typography_border_color',
					'std' => '',
					'type' => 'color',
					'refresh_on_change' => false,
					'affect_on_change_el' => '.breadcrumbs span.item',
					'affect_on_change_rule' => 'border-color',
					'section' => 'styling',
					'tab' => __( 'Typography', 'live-composer-page-builder' ),
				),
				array(
					'label' => __( 'Color: Hover', 'live-composer-page-builder' ),
					'id' => 'css_typography_border_color_hover',
					'std' => '',
					'type' => 'color',
					'refresh_on_change' => false,
					'affect_on_change_el' => '.breadcrumbs span.item:hover',
					'affect_on_change_rule' => 'border-color',
					'section' => 'styling',
					'tab' => __( 'Typography', 'live-composer-page-builder' ),
				),
				array(
					'label' => __( 'Color - Current', 'live-composer-page-builder' ),
					'id' => 'css_typography_border_color_current',
					'std' => '',
					'type' => 'color',
					'refresh_on_change' => false,
					'affect_on_change_el' => '.breadcrumbs span.item_current',
					'affect_on_change_rule' => 'border-color',
					'section' => 'styling',
					'tab' => __( 'Typography', 'live-composer-page-builder' ),
				),
				array(
					'label' => __( 'Color - Current: Hover', 'live-composer-page-builder' ),
					'id' => 'css_typography_border_color_current_hover',
					'std' => '',
					'type' => 'color',
					'refresh_on_change' => false,
					'affect_on_change_el' => '.breadcrumbs span.item_current:hover',
					'affect_on_change_rule' => 'border-color',
					'section' => 'styling',
					'tab' => __( 'Typography', 'live-composer-page-builder' ),
				),
				array(
					'label' => __( 'Width', 'live-composer-page-builder' ),
					'id' => 'css_typography_border_width',
					'onlypositive' => true, // Value can't be negative.
					'std' => '',
					'type' => 'slider',
					'refresh_on_change' => false,
					'affect_on_change_el' => '.breadcrumbs span.item, .breadcrumbs span.item_current',
					'affect_on_change_rule' => 'border-width',
					'section' => 'styling',
					'ext' => 'px',
					'tab' => __( 'Typography', 'live-composer-page-builder' ),
				),
				array(
					'label' => __( 'Borders', 'live-composer-page-builder' ),
					'id' => 'css_typography_border_trbl',
					'std' => '',
					'type' => 'checkbox',
					'choices' => array(
						array(
							'label' => __( 'Top', 'live-composer-page-builder' ),
							'value' => 'top',
						),
						array(
							'label' => __( 'Right', 'live-composer-page-builder' ),
							'value' => 'right',
						),
						array(
							'label' => __( 'Bottom', 'live-composer-page-builder' ),
							'value' => 'bottom',
						),
						array(
							'label' => __( 'Left', 'live-composer-page-builder' ),
							'value' => 'left',
						),
					),
					'refresh_on_change' => false,
					'affect_on_change_el' => '.breadcrumbs span.item, .breadcrumbs span.item_current',
					'affect_on_change_rule' => 'border-style',
					'section' => 'styling',
					'tab' => __( 'Typography', 'live-composer-page-builder' ),
				),
				array(
					'label' => __( 'Radius Top - Left', 'live-composer-page-builder' ),
					'id' => 'css_typography_border_radius_top_left',
					'onlypositive' => true, // Value can't be negative.
					'std' => '',
					'type' => 'slider',
					'refresh_on_change' => false,
					'affect_on_change_el' => '.breadcrumbs span.item, .breadcrumbs span.item_current',
					'affect_on_change_rule' => 'border-top-left-radius',
					'section' => 'styling',
					'ext' => 'px',
					'tab' => __( 'Typography', 'live-composer-page-builder' ),
				),
				array(
					'label' => __( 'Radius Top - Right', 'live-composer-page-builder' ),
					'id' => 'css_typography_border_radius_top_right',
					'onlypositive' => true, // Value can't be negative.
					'std' => '',
					'type' => 'slider',
					'refresh_on_change' => false,
					'affect_on_change_el' => '.breadcrumbs span.item, .breadcrumbs span.item_current',
					'affect_on_change_rule' => 'border-top-right-radius',
					'section' => 'styling',
					'ext' => 'px',
					'tab' => __( 'Typography', 'live-composer-page-builder' ),
				),
				array(
					'label' => __( 'Radius Bottom - Left', 'live-composer-page-builder' ),
					'id' => 'css_typography_border_radius_bottom_left',
					'onlypositive' => true, // Value can't be negative.
					'std' => '',
					'type' => 'slider',
					'refresh_on_change' => false,
					'affect_on_change_el' => '.breadcrumbs span.item, .breadcrumbs span.item_current',
					'affect_on_change_rule' => 'border-bottom-left-radius',
					'section' => 'styling',
					'ext' => 'px',
					'tab' => __( 'Typography', 'live-composer-page-builder' ),
				),
				array(
					'label' => __( 'Radius Bottom - Right', 'live-composer-page-builder' ),
					'id' => 'css_typography_border_radius_bottom_right',
					'onlypositive' => true, // Value can't be negative.
					'std' => '',
					'type' => 'slider',
					'refresh_on_change' => false,
					'affect_on_change_el' => '.breadcrumbs span.item, .breadcrumbs span.item_current',
					'affect_on_change_rule' => 'border-bottom-right-radius',
					'section' => 'styling',
					'ext' => 'px',
					'tab' => __( 'Typography', 'live-composer-page-builder' ),
				),
			array(
				'id' => 'css_typography_border_group',
				'type' => 'group',
				'action' => 'close',
				'section' => 'styling',
			),
			array(
				'label' => __( 'Font', 'live-composer-page-builder' ),
				'id' => 'css_font_group',
				'type' => 'group',
				'action' => 'open',
				'section' => 'styling',
				'tab' => __( 'Typography', 'live-composer-page-builder' ),
			),
				array(
					'label' => __( 'Color', 'live-composer-page-builder' ),
					'id' => 'css_color',
					'std' => '#000000',
					'type' => 'color',
					'refresh_on_change' => false,
					'affect_on_change_el' => '.breadcrumbs span.item_current',
					'affect_on_change_rule' => 'color',
					'section' => 'styling',
					'tab' => __( 'Typography', 'live-composer-page-builder' ),
				),
				array(
					'label' => __( 'Font Size', 'live-composer-page-builder' ),
					'id' => 'css_font_size',
					'onlypositive' => true, // Value can't be negative.
					'std' => '15',
					'type' => 'slider',
					'refresh_on_change' => false,
					'affect_on_change_el' => '.breadcrumbs span.item, .breadcrumbs span.item_current',
					'affect_on_change_rule' => 'font-size',
					'section' => 'styling',
					'tab' => __( 'Typography', 'live-composer-page-builder' ),
					'ext' => 'px',
				),
				array(
					'label' => __( 'Font Weight', 'live-composer-page-builder' ),
					'id' => 'css_font_weight',
					'std' => '400',
					'type' => 'select',
					'choices' => array(
						array(
							'label' => '100 - Thin',
							'value' => '100',
						),
						array(
							'label' => '200 - Extra Light',
							'value' => '200',
						),
						array(
							'label' => '300 - Light',
							'value' => '300',
						),
						array(
							'label' => '400 - Normal',
							'value' => '400',
						),
						array(
							'label' => '500 - Medium',
							'value' => '500',
						),
						array(
							'label' => '600 - Semi Bold',
							'value' => '600',
						),
						array(
							'label' => '700 - Bold',
							'value' => '700',
						),
						array(
							'label' => '800 - Extra Bold',
							'value' => '800',
						),
						array(
							'label' => '900 - Black',
							'value' => '900',
						),
					),
					'refresh_on_change' => false,
					'affect_on_change_el' => '.breadcrumbs span.item_current',
					'affect_on_change_rule' => 'font-weight',
					'section' => 'styling',
					'tab' => __( 'Typography', 'live-composer-page-builder' ),
					'ext' => '',
				),
				array(
					'label' => __( 'Font Family', 'live-composer-page-builder' ),
					'id' => 'css_font_family',
					'std' => 'Open Sans',
					'type' => 'font',
					'refresh_on_change' => false,
					'affect_on_change_el' => '.breadcrumbs span.item, .breadcrumbs span.item_current',
					'affect_on_change_rule' => 'font-family',
					'section' => 'styling',
					'tab' => __( 'Typography', 'live-composer-page-builder' ),
				),
				array(
					'label' => __( 'Line Height', 'live-composer-page-builder' ),
					'id' => 'css_line_height',
					'onlypositive' => true, // Value can't be negative.
					'std' => '20',
					'type' => 'slider',
					'refresh_on_change' => false,
					'affect_on_change_el' => '.breadcrumbs span.item, .breadcrumbs span.item_current',
					'affect_on_change_rule' => 'line-height',
					'section' => 'styling',
					'tab' => __( 'Typography', 'live-composer-page-builder' ),
					'ext' => 'px',
				),
				array(
					'label' => __( 'Text Transform', 'live-composer-page-builder' ),
					'id' => 'css_text_transform',
					'std' => 'none',
					'type' => 'select',
					'choices' => array(
						array(
							'label' => __( 'None', 'live-composer-page-builder' ),
							'value' => 'none',
						),
						array(
							'label' => __( 'Capitalize', 'live-composer-page-builder' ),
							'value' => 'capitalize',
						),
						array(
							'label' => __( 'Uppercase', 'live-composer-page-builder' ),
							'value' => 'uppercase',
						),
						array(
							'label' => __( 'Lowercase', 'live-composer-page-builder' ),
							'value' => 'lowercase',
						),
					),
					'refresh_on_change' => false,
					'affect_on_change_el' => '.breadcrumbs span.item, .breadcrumbs span.item_current',
					'affect_on_change_rule' => 'text-transform',
					'section' => 'styling',
					'tab' => __( 'Typography', 'live-composer-page-builder' ),
				),
			array(
				'id' => 'css_font_group',
				'type' => 'group',
				'action' => 'close',
				'section' => 'styling',
			),
			array(
				'label' => __( 'Font - Link', 'live-composer-page-builder' ),
				'id' => 'css_font_group',
				'type' => 'group',
				'action' => 'open',
				'section' => 'styling',
				'tab' => __( 'Typography', 'live-composer-page-builder' ),
			),
				array(
					'label' => __( 'Color', 'live-composer-page-builder' ),
					'id' => 'css_link_color',
					'std' => '#000000',
					'type' => 'color',
					'refresh_on_change' => false,
					'affect_on_change_el' => '.breadcrumbs a',
					'affect_on_change_rule' => 'color',
					'section' => 'styling',
					'tab' => __( 'Typography', 'live-composer-page-builder' ),
				),
				array(
					'label' => __( 'Color: Hover', 'live-composer-page-builder' ),
					'id' => 'css_link_color_hover',
					'std' => '#a0a0a0',
					'type' => 'color',
					'refresh_on_change' => false,
					'affect_on_change_el' => '.breadcrumbs a:hover',
					'affect_on_change_rule' => 'color',
					'section' => 'styling',
					'tab' => __( 'Typography', 'live-composer-page-builder' ),
				),
				array(
					'label' => __( 'Font Weight', 'live-composer-page-builder' ),
					'id' => 'css_link_font_weight',
					'std' => '400',
					'type' => 'select',
					'choices' => array(
						array(
							'label' => '100 - Thin',
							'value' => '100',
						),
						array(
							'label' => '200 - Extra Light',
							'value' => '200',
						),
						array(
							'label' => '300 - Light',
							'value' => '300',
						),
						array(
							'label' => '400 - Normal',
							'value' => '400',
						),
						array(
							'label' => '500 - Medium',
							'value' => '500',
						),
						array(
							'label' => '600 - Semi Bold',
							'value' => '600',
						),
						array(
							'label' => '700 - Bold',
							'value' => '700',
						),
						array(
							'label' => '800 - Extra Bold',
							'value' => '800',
						),
						array(
							'label' => '900 - Black',
							'value' => '900',
						),
					),
					'refresh_on_change' => false,
					'affect_on_change_el' => '.breadcrumbs a',
					'affect_on_change_rule' => 'font-weight',
					'section' => 'styling',
					'tab' => __( 'Typography', 'live-composer-page-builder' ),
					'ext' => '',
				),
			array(
				'id' => 'css_font_group',
				'type' => 'group',
				'action' => 'close',
				'section' => 'styling',
			),
			array(
				'label' => __( 'Padding', 'live-composer-page-builder' ),
				'id' => 'css_typography_padding_group',
				'type' => 'group',
				'action' => 'open',
				'section' => 'styling',
				'tab' => __( 'Typography', 'live-composer-page-builder' ),
			),
				array(
					'label' => __( 'Top', 'live-composer-page-builder' ),
					'id' => 'css_typography_padding_top',
					'std' => '',
					'type' => 'slider',
					'refresh_on_change' => false,
					'affect_on_change_el' => '.breadcrumbs span',
					'affect_on_change_rule' => 'padding-top',
					'section' => 'styling',
					'ext' => 'px',
					'tab' => __( 'Typography', 'live-composer-page-builder' ),
				),
				array(
					'label' => __( 'Right', 'live-composer-page-builder' ),
					'id' => 'css_typography_padding_right',
					'std' => '',
					'type' => 'slider',
					'refresh_on_change' => false,
					'affect_on_change_el' => '.breadcrumbs span',
					'affect_on_change_rule' => 'padding-right',
					'section' => 'styling',
					'ext' => 'px',
					'tab' => __( 'Typography', 'live-composer-page-builder' ),
				),
				array(
					'label' => __( 'Bottom', 'live-composer-page-builder' ),
					'id' => 'css_typography_padding_bottom',
					'std' => '',
					'type' => 'slider',
					'refresh_on_change' => false,
					'affect_on_change_el' => '.breadcrumbs span',
					'affect_on_change_rule' => 'padding-bottom',
					'section' => 'styling',
					'ext' => 'px',
					'tab' => __( 'Typography', 'live-composer-page-builder' ),
				),
				array(
					'label' => __( 'Left', 'live-composer-page-builder' ),
					'id' => 'css_typography_padding_left',
					'std' => '',
					'type' => 'slider',
					'refresh_on_change' => false,
					'affect_on_change_el' => '.breadcrumbs span',
					'affect_on_change_rule' => 'padding-left',
					'section' => 'styling',
					'ext' => 'px',
					'tab' => __( 'Typography', 'live-composer-page-builder' ),
				),
			array(
				'id' => 'css_typography_padding_group',
				'type' => 'group',
				'action' => 'close',
				'section' => 'styling',
			),
			array(
				'label' => __( 'Font Separator', 'live-composer-page-builder' ),
				'id' => 'css_font_separator_group',
				'type' => 'group',
				'action' => 'open',
				'section' => 'styling',
				'tab' => __( 'Typography', 'live-composer-page-builder' ),
			),
				array(
					'label' => __( 'Color', 'live-composer-page-builder' ),
					'id' => 'css_separator_color',
					'std' => '#000000',
					'type' => 'color',
					'refresh_on_change' => false,
					'affect_on_change_el' => '.breadcrumbs span.sep',
					'affect_on_change_rule' => 'color',
					'section' => 'styling',
					'tab' => __( 'Typography', 'live-composer-page-builder' ),
				),
				array(
					'label' => __( 'Font Size', 'live-composer-page-builder' ),
					'id' => 'css_separator_font_size',
					'onlypositive' => true, // Value can't be negative.
					'std' => '15',
					'type' => 'slider',
					'refresh_on_change' => false,
					'affect_on_change_el' => '.breadcrumbs span.sep',
					'affect_on_change_rule' => 'font-size',
					'section' => 'styling',
					'tab' => __( 'Typography', 'live-composer-page-builder' ),
					'ext' => 'px',
				),
				array(
					'label' => __( 'Font Weight', 'live-composer-page-builder' ),
					'id' => 'css__separator_font_weight',
					'std' => '400',
					'type' => 'select',
					'choices' => array(
						array(
							'label' => '100 - Thin',
							'value' => '100',
						),
						array(
							'label' => '200 - Extra Light',
							'value' => '200',
						),
						array(
							'label' => '300 - Light',
							'value' => '300',
						),
						array(
							'label' => '400 - Normal',
							'value' => '400',
						),
						array(
							'label' => '500 - Medium',
							'value' => '500',
						),
						array(
							'label' => '600 - Semi Bold',
							'value' => '600',
						),
						array(
							'label' => '700 - Bold',
							'value' => '700',
						),
						array(
							'label' => '800 - Extra Bold',
							'value' => '800',
						),
						array(
							'label' => '900 - Black',
							'value' => '900',
						),
					),
					'refresh_on_change' => false,
					'affect_on_change_el' => '.breadcrumbs span.sep',
					'affect_on_change_rule' => 'font-weight',
					'section' => 'styling',
					'tab' => __( 'Typography', 'live-composer-page-builder' ),
					'ext' => '',
				),
			array(
				'id' => 'css_font_separator_group',
				'type' => 'group',
				'action' => 'close',
				'section' => 'styling',
			),
			array(
				'label' => __( 'Text Align', 'live-composer-page-builder' ),
				'id' => 'css_text_align',
				'std' => 'left',
				'type' => 'text_align',
				'refresh_on_change' => false,
				'affect_on_change_el' => '.breadcrumbs',
				'affect_on_change_rule' => 'text-align',
				'section' => 'styling',
				'tab' => __( 'Typography', 'live-composer-page-builder' ),
			),
			array(
				'label' => __( 'Text Shadow', 'live-composer-page-builder' ),
				'id' => 'css_text_shadow',
				'std' => '',
				'type' => 'text_shadow',
				'refresh_on_change' => false,
				'affect_on_change_el' => '.breadcrumbs span.item, .breadcrumbs span.item_current',
				'affect_on_change_rule' => 'text-shadow',
				'section' => 'styling',
				'tab' => __( 'Typography', 'live-composer-page-builder' ),
			),
		);

		$dslc_options = array_merge( $dslc_options, $this->shared_options( 'animation_options', array( 'hover_opts' => false ) ) );
		$dslc_options = array_merge( $dslc_options, $this->presets_options() );

		return apply_filters( 'dslc_module_options', $dslc_options, $this->module_id );
	}

	/**
	 * Module HTML output.
	 *
	 * @param  array $options Module options to fill the module template.
	 * @return void
	 */
	function output( $options ) {

		$this->module_start( $options );

		global $dslc_active;

		if ( 'dslc_templates' === get_post_type() || $dslc_active ) {
		?>
			<div class="breadcrumbs">
				<span class="item"><a href="#" class="home"><span>Home</span></a></span>
				<span class="sep">/</span>
				<span class="item"><a href="#"><span>Category Page</span></a></span>
				<span class="sep">/</span>
				<span class="item_current">Single Page</span>
			</div>
		<?php
		} else {
			dslc_display_breadcrumb();
		}

		$this->module_end( $options );

	}
}
