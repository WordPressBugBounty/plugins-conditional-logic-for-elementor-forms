<?php
/**
 * Plugin Name: Conditional Logic for Elementor Forms
 * Plugin URI: https://add-ons.org/plugin/elementor-forms-conditional-logic/
 * Requires Plugins: elementor
 * Description: The Conditional Logic add-on can be used to show and hide form fields based off of the user’s inputs.
 * Version: 2.3.5
 * Author: add-ons.org
 * Elementor tested up to: 3.32
 * Elementor Pro tested up to: 3.32
 * Author URI: https://add-ons.org/
*/

if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly
if (!defined('ELEMENTOR_CONDITIONAL_LOGIC_PLUGIN_PATH')) {
	define( 'ELEMENTOR_CONDITIONAL_LOGIC_PLUGIN_PATH', plugin_dir_path( __FILE__ ) );
	define( 'ELEMENTOR_CONDITIONAL_LOGIC_PLUGIN_URL', plugin_dir_url( __FILE__ ) );
	include ELEMENTOR_CONDITIONAL_LOGIC_PLUGIN_PATH."includes/conditional_logic.php";
	class Superaddons_Elementor_Conditional_logic_Init{
		function __construct(){
			add_action( 'elementor_pro/forms/fields/register', array($this,"superaddons_add_new_html1_field") );
			add_filter( 'elementor_pro/forms/field_types', array($this,"superaddons_remove_html_field_type") );
			add_action( 'elementor_pro/forms/actions/register', array($this,'superaddons_register_new_form_actions') );
		}
		function superaddons_register_new_form_actions($form_actions_registrar){
			include ELEMENTOR_CONDITIONAL_LOGIC_PLUGIN_PATH .'includes/email_action_logic.php';
			include ELEMENTOR_CONDITIONAL_LOGIC_PLUGIN_PATH .'includes/redirect_action_logic.php';
		    $form_actions_registrar->register( new \Superaddons_Email_Conditional_Logic() );
		    $form_actions_registrar->register( new \Superaddons_Email_Conditional_Logic_2() );
		    $form_actions_registrar->register( new \Superaddons_Email_Conditional_Logic_3() );
		    $form_actions_registrar->register( new \Superaddons_Email_Conditional_Logic_4() );
		    $form_actions_registrar->register( new \Superaddons_Email_Conditional_Logic_5() );
		    $form_actions_registrar->register( new \Superaddons_Email_Conditional_Logic_6() );
		    $form_actions_registrar->register( new \Superaddons_Email_Conditional_Logic_7() );
		    $form_actions_registrar->register( new \Superaddons_Email_Conditional_Logic_8() );
		    $form_actions_registrar->register( new \Superaddons_Email_Conditional_Logic_9() );
		    $form_actions_registrar->register( new \Superaddons_Email_Conditional_Logic_10() );
		    $form_actions_registrar->register( new \Superaddons_Email_Conditional_Logic_11() );
		    $form_actions_registrar->register( new \Superaddons_Email_Conditional_Logic_12() );
		    $form_actions_registrar->register( new \Superaddons_Email_Conditional_Logic_13() );
		    $form_actions_registrar->register( new \Superaddons_Email_Conditional_Logic_14() );
		    $form_actions_registrar->register( new \Superaddons_Email_Conditional_Logic_15() );
		    $form_actions_registrar->register( new \Superaddons_Email_Conditional_Logic_16() );
		    $form_actions_registrar->register( new \Superaddons_Email_Conditional_Logic_17() );
		    $form_actions_registrar->register( new \Superaddons_Email_Conditional_Logic_18() );
		    $form_actions_registrar->register( new \Superaddons_Email_Conditional_Logic_19() );
		    $form_actions_registrar->register( new \Superaddons_Email_Conditional_Logic_20() );
		    $form_actions_registrar->register( new \Superaddons_Email_Conditional_Logic_21() );
		    $form_actions_registrar->register( new \Superaddons_Email_Conditional_Logic_22() );
		    $form_actions_registrar->register( new \Superaddons_Email_Conditional_Logic_23() );
		    $form_actions_registrar->register( new \Superaddons_Email_Conditional_Logic_24() );
		    $form_actions_registrar->register( new \Superaddons_Email_Conditional_Logic_25() );
		    $form_actions_registrar->register( new \Superaddons_Email_Conditional_Logic_26() );
		    $form_actions_registrar->register( new \Superaddons_Email_Conditional_Logic_27() );
		    $form_actions_registrar->register( new \Superaddons_Email_Conditional_Logic_28() );
		    $form_actions_registrar->register( new \Superaddons_Email_Conditional_Logic_29() );
		    $form_actions_registrar->register( new \Superaddons_Email_Conditional_Logic_30() );
		    $form_actions_registrar->register( new \Superaddons_Redirect_Conditional_Logic() );
		    $form_actions_registrar->register( new \Superaddons_Redirect_Conditional_Logic_2() );
		    $form_actions_registrar->register( new \Superaddons_Redirect_Conditional_Logic_3() );
		    $form_actions_registrar->register( new \Superaddons_Redirect_Conditional_Logic_4() );
		    $form_actions_registrar->register( new \Superaddons_Redirect_Conditional_Logic_5() );
		    $form_actions_registrar->register( new \Superaddons_Redirect_Conditional_Logic_6() );
		    $form_actions_registrar->register( new \Superaddons_Redirect_Conditional_Logic_7() );
		    $form_actions_registrar->register( new \Superaddons_Redirect_Conditional_Logic_8() );
		    $form_actions_registrar->register( new \Superaddons_Redirect_Conditional_Logic_9() );
		    $form_actions_registrar->register( new \Superaddons_Redirect_Conditional_Logic_10() );
		    $form_actions_registrar->register( new \Superaddons_Redirect_Conditional_Logic_11() );
		    $form_actions_registrar->register( new \Superaddons_Redirect_Conditional_Logic_12() );
		    $form_actions_registrar->register( new \Superaddons_Redirect_Conditional_Logic_13() );
		    $form_actions_registrar->register( new \Superaddons_Redirect_Conditional_Logic_14() );
		    $form_actions_registrar->register( new \Superaddons_Redirect_Conditional_Logic_15() );
		    $form_actions_registrar->register( new \Superaddons_Redirect_Conditional_Logic_16() );
		    $form_actions_registrar->register( new \Superaddons_Redirect_Conditional_Logic_17() );
		    $form_actions_registrar->register( new \Superaddons_Redirect_Conditional_Logic_18() );
		    $form_actions_registrar->register( new \Superaddons_Redirect_Conditional_Logic_19() );
		    $form_actions_registrar->register( new \Superaddons_Redirect_Conditional_Logic_20() );
		    $form_actions_registrar->register( new \Superaddons_Redirect_Conditional_Logic_21() );
		    $form_actions_registrar->register( new \Superaddons_Redirect_Conditional_Logic_22() );
		    $form_actions_registrar->register( new \Superaddons_Redirect_Conditional_Logic_23() );
		    $form_actions_registrar->register( new \Superaddons_Redirect_Conditional_Logic_24() );
		    $form_actions_registrar->register( new \Superaddons_Redirect_Conditional_Logic_25() );
		    $form_actions_registrar->register( new \Superaddons_Redirect_Conditional_Logic_26() );
		    $form_actions_registrar->register( new \Superaddons_Redirect_Conditional_Logic_27() );
		    $form_actions_registrar->register( new \Superaddons_Redirect_Conditional_Logic_28() );
		    $form_actions_registrar->register( new \Superaddons_Redirect_Conditional_Logic_29() );
		    $form_actions_registrar->register( new \Superaddons_Redirect_Conditional_Logic_30() );
		}
		function superaddons_remove_html_field_type($fields){
			unset( $fields['html'] );
			return $fields;
		}
		function superaddons_add_new_html1_field($form_fields_registrar){
		    require_once( ELEMENTOR_CONDITIONAL_LOGIC_PLUGIN_PATH."includes/html_condition.php" );
		    $form_fields_registrar->register( new \Superaddons_Elemntor_HTML1_Field() );
		}
	}
	new Superaddons_Elementor_Conditional_logic_Init;
	include_once ELEMENTOR_CONDITIONAL_LOGIC_PLUGIN_PATH."yeekit/document.php";
}
