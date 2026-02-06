<?php
if (! defined('ABSPATH')) exit; // Exit if accessed directly
use Elementor\Controls_Manager;
use ElementorPro\Core\Utils;
use ElementorPro\Modules\Forms\Classes\Ajax_Handler;
use ElementorPro\Modules\Forms\actions\Email2;
use ElementorPro\Modules\Forms\Classes\Form_Record;

class Superaddons_Email_Conditional_Logic extends Email2
{
	public function get_name()
	{
		return 'email_conditional_logic';
	}
	public function get_label()
	{
		return esc_html__('Email Conditional Logic', 'elementor-pro');
	}
	protected function get_control_id($control_id)
	{
		return $control_id . '_conditional_logic';
	}
	protected function get_reply_to($record, $fields)
	{
		return isset($fields['email_reply_to']) ? $fields['email_reply_to'] : '';
	}
	public function register_settings_section($widget)
	{
		$options_logic = array(
			"==" => esc_html__("is", "conditional-logic-for-elementor-forms"),
			"!=" => esc_html__("not is", "conditional-logic-for-elementor-forms"),
		);
		$options_pro = array(
			"1"  => esc_html__("Empty (Pro version)", "conditional-logic-for-elementor-forms"),
			"1"  => esc_html__("Not empty (Pro version)", "conditional-logic-for-elementor-forms"),
			"3"  => esc_html__("Contains (Pro version)", "conditional-logic-for-elementor-forms"),
			"4"  => esc_html__("Does not contain (Pro version)", "conditional-logic-for-elementor-forms"),
			"5"  => esc_html__("Starts with (Pro version)", "conditional-logic-for-elementor-forms"),
			"6"  => esc_html__("Ends with (Pro version)", "conditional-logic-for-elementor-forms"),
			"7"  => esc_html__("Greater than > (Pro version)", "conditional-logic-for-elementor-forms"),
			"8"  => esc_html__("Less than < (Pro version)", "conditional-logic-for-elementor-forms"),
			"9"  => esc_html__("List array (a,b,c)", "conditional-logic-for-elementor-forms"),
			"10" => esc_html__("Not List array (a,b,c)", "conditional-logic-for-elementor-forms"),
			"11" => esc_html__("List array contain (a,b,c)", "conditional-logic-for-elementor-forms"),
			"12" => esc_html__("Not List array contain (a,b,c)", "conditional-logic-for-elementor-forms"),
		);
		$options_logic = apply_filters("yeeaddons_condition_options_logic", $options_logic);
		$options_pro   = apply_filters("yeeaddons_condition_options_logic_pro", $options_pro);
		$widget->start_controls_section(
			$this->get_control_id('section_email'),
			[
				'label'     => $this->get_label(),
				'tab'       => Controls_Manager::TAB_CONTENT,
				'condition' => [
					'submit_actions' => $this->get_name(),
				],
			]
		);
		$widget->add_control(
			$this->get_control_id('email_to'),
			[
				'label'       => esc_html__('To', 'elementor-pro'),
				'type'        => Controls_Manager::TEXT,
				'default'     => get_option('admin_email'),
				'placeholder' => get_option('admin_email'),
				'label_block' => true,
				'title'       => esc_html__('Separate emails with commas', 'elementor-pro'),
				'render_type' => 'none',
			]
		);
		/* translators: %s: Site title. */
		$default_message = sprintf(esc_html__('New message from "%s"', 'elementor-pro'), get_option('blogname'));
		$widget->add_control(
			$this->get_control_id('email_subject'),
			[
				'label'       => esc_html__('Subject', 'elementor-pro'),
				'type'        => Controls_Manager::TEXT,
				'default'     => $default_message,
				'placeholder' => $default_message,
				'label_block' => true,
				'render_type' => 'none',
			]
		);
		$widget->add_control(
			$this->get_control_id('email_content'),
			[
				'label'       => esc_html__('Message', 'elementor-pro'),
				'type'        => Controls_Manager::TEXTAREA,
				'default'     => '[all-fields]',
				'placeholder' => '[all-fields]',
				'description' => sprintf(esc_html__('By default, all form fields are sent via %s shortcode. To customize sent fields, copy the shortcode that appears inside each field and paste it above.', 'elementor-pro'), '<code>[all-fields]</code>'),
				'render_type' => 'none',
			]
		);
		$site_domain = Utils::get_site_domain();
		$widget->add_control(
			$this->get_control_id('email_from'),
			[
				'label'       => esc_html__('From Email', 'elementor-pro'),
				'type'        => Controls_Manager::TEXT,
				'default'     => 'email@' . $site_domain,
				'render_type' => 'none',
			]
		);
		$widget->add_control(
			$this->get_control_id('email_from_name'),
			[
				'label'       => esc_html__('From Name', 'elementor-pro'),
				'type'        => Controls_Manager::TEXT,
				'default'     => get_bloginfo('name'),
				'render_type' => 'none',
			]
		);
		$admin_email = get_option('admin_email');
		$widget->add_control(
			$this->get_control_id('email_reply_to'),
			[
				'label'       => esc_html__('Reply-To', 'elementor-pro'),
				'type'        => Controls_Manager::TEXT,
				'default'     => $admin_email,
				'placeholder' => $admin_email,
				'render_type' => 'none',
				'description' => esc_html__('You can ID email filed', 'elementor-pro'),
			]
		);
		$widget->add_control(
			$this->get_control_id('email_to_cc'),
			[
				'label'       => esc_html__('Cc', 'elementor-pro'),
				'type'        => Controls_Manager::TEXT,
				'default'     => '',
				'title'       => esc_html__('Separate emails with commas', 'elementor-pro'),
				'render_type' => 'none',
			]
		);
		$widget->add_control(
			$this->get_control_id('email_to_bcc'),
			[
				'label'       => esc_html__('Bcc', 'elementor-pro'),
				'type'        => Controls_Manager::TEXT,
				'default'     => '',
				'title'       => esc_html__('Separate emails with commas', 'elementor-pro'),
				'render_type' => 'none',
			]
		);
		$widget->add_control(
			$this->get_control_id('form_metadata'),
			[
				'label'       => esc_html__('Meta Data', 'elementor-pro'),
				'type'        => Controls_Manager::SELECT2,
				'multiple'    => true,
				'label_block' => true,
				'separator'   => 'before',
				'default'     => [
					'date',
					'time',
					'page_url',
					'user_agent',
					'remote_ip',
					'credit',
				],
				'options' => [
					'date'       => esc_html__('Date', 'elementor-pro'),
					'time'       => esc_html__('Time', 'elementor-pro'),
					'page_url'   => esc_html__('Page URL', 'elementor-pro'),
					'user_agent' => esc_html__('User Agent', 'elementor-pro'),
					'remote_ip'  => esc_html__('Remote IP', 'elementor-pro'),
					'credit'     => esc_html__('Credit', 'elementor-pro'),
				],
				'render_type' => 'none',
			]
		);
		$widget->add_control(
			$this->get_control_id('email_content_type'),
			[
				'label'       => esc_html__('Send As', 'elementor-pro'),
				'type'        => Controls_Manager::SELECT,
				'default'     => 'html',
				'render_type' => 'none',
				'options'     => [
					'html'  => esc_html__('HTML', 'elementor-pro'),
					'plain' => esc_html__('Plain', 'elementor-pro'),
				],
			]
		);
		$control_id_conditional_logic = $this->get_control_id('email_conditional_logic');
		$widget->add_control(
			$control_id_conditional_logic,
			[
				'label'       => esc_html__('Enable Conditional Logic', 'elementor-pro'),
				'render_type' => 'none',
				'type'        => Controls_Manager::SWITCHER,
			]
		);
		$widget->add_control(
			$this->get_control_id('email_conditional_logic_display'),
			[
				'label'   => esc_html__('Display mode', "conditional-logic-for-elementor-forms"),
				'type'    => Controls_Manager::CHOOSE,
				'options' => [
					'show' => [
						'title' => esc_html__('Send if', "conditional-logic-for-elementor-forms"),
						'icon'  => 'fa fa-eye',
					],
					'hide' => [
						'title' => esc_html__('Disable if', "conditional-logic-for-elementor-forms"),
						'icon'  => 'fa fa-eye-slash',
					],
				],
				'default'   => 'show',
				'condition' => [
					$control_id_conditional_logic => 'yes'
				],
			]
		);
		$widget->add_control(
			$this->get_control_id('email_conditional_logic_trigger'),
			[
				'label'   => esc_html__('When to Trigger', "conditional-logic-for-elementor-forms"),
				'type'    => Controls_Manager::SELECT,
				'options' => [
					"ALL" => "ALL",
					"ANY" => "ANY"
				],
				'default'   => 'ALL',
				'condition' => [
					$control_id_conditional_logic => 'yes'
				],
			]
		);
		$widget->add_control(
			$this->get_control_id('email_conditional_logic_datas'),
			[
				'name'   => 'email_conditional_logic_datas',
				'label'  => esc_html__('Fields if', "conditional-logic-for-elementor-forms"),
				'type'   => 'conditional_logic_repeater',
				'fields' => [
					[
						'name'        => 'conditional_logic_id',
						'label'       => esc_html__('Field ID', "conditional-logic-for-elementor-forms"),
						'type'        => Controls_Manager::TEXT,
						'label_block' => true,
						'default'     => '',
					],
					[
						'name'        => 'conditional_logic_operator',
						'label'       => esc_html__('Operator 1', "conditional-logic-for-elementor-forms"),
						'type'        => Controls_Manager::SELECT,
						'label_block' => true,
						'options'     => $options_logic,
						'options_pro' => $options_pro,
						'default'     => '==',
					],
					[
						'name'        => 'conditional_logic_value',
						'label'       => esc_html__('Value to compare', "conditional-logic-for-elementor-forms"),
						'type'        => Controls_Manager::TEXT,
						'label_block' => true,
						'default'     => '',
					],
				],
				'condition' => [
					$control_id_conditional_logic => 'yes'
				],
				'style_transfer' => false,
				'title_field'    => '{{{ conditional_logic_id  }}} {{{ conditional_logic_operator  }}} {{{ conditional_logic_value  }}}',
				'default'        => array(
					array(
						'conditional_logic_id'       => '',
						'conditional_logic_operator' => '==',
						'conditional_logic_value'    => '',
					),
				),
			]
		);
		$widget->end_controls_section();
	}
	public function run($record, $ajax_handler)
	{
		$settings = $record->get('form_settings');
		$send_status = true;
		if ($settings[$this->get_control_id('email_conditional_logic')] == "yes") {
			$display = $settings[$this->get_control_id('email_conditional_logic_display')];
			$trigger = $settings[$this->get_control_id('email_conditional_logic_trigger')];
			$datas = $settings[$this->get_control_id('email_conditional_logic_datas')];
			$rs = array();
			$form_fields = $record->get("fields");
			foreach ($datas as $logic_key => $logic_values) {
				if (isset($form_fields[$logic_values["conditional_logic_id"]])) {
					$value_id = $form_fields[$logic_values["conditional_logic_id"]]["value"];
					if (is_array($value_id)) {
						$value_id = implode(", ", $value_id);
					}
				} else {
					$value_id = $logic_values["conditional_logic_id"];
				}
				$operator = $logic_values["conditional_logic_operator"];
				$value = $logic_values["conditional_logic_value"];
				$rs[] = $this->elementor_conditional_logic_check_single($value_id, $operator, $value);
			}
			if ($trigger == "ALL") {
				$check_rs = true;
				foreach ($rs as $fkey => $fvalue) {
					if ($fvalue == false) {
						$check_rs = false;
						break;
					}
				}
			} else {
				$check_rs = false;
				foreach ($rs as $fkey => $fvalue) {
					if ($fvalue == true) {
						$check_rs = true;
						break;
					}
				}
			}
			if ($display == "show") {
				if ($check_rs == true) {
					$send_status = true;
				} else {
					$send_status = false;
				}
			} else {
				if ($check_rs == true) {
					$send_status = false;
				} else {
					$send_status = true;
				}
			}
		}
		if ($send_status ==  true) {
			$send_html = 'plain' !== $settings[$this->get_control_id('email_content_type')];
			$line_break = $send_html ? '<br>' : "\n";
			$fields = [
				'email_to' => get_option('admin_email'),
				/* translators: %s: Site title. */
				'email_subject' => sprintf(esc_html__('New message from "%s"', 'elementor-pro'), get_bloginfo('name')),
				'email_content' => '[all-fields]',
				'email_from_name' => get_bloginfo('name'),
				'email_from' => get_bloginfo('admin_email'),
				'email_reply_to' => 'noreply@' . Utils::get_site_domain(),
				'email_to_cc' => '',
				'email_to_bcc' => '',
			];
			foreach ($fields as $key => $default) {
				$setting = trim($settings[$this->get_control_id($key)]);
				$setting = $record->replace_setting_shortcodes($setting);
				if (! empty($setting)) {
					$fields[$key] = $setting;
				}
			}
			$email_reply_to = $this->get_reply_to($record, $fields);
			$fields['email_content'] = $this->replace_content_shortcodes($fields['email_content'], $record, $line_break);
			$email_meta = '';
			$form_metadata_settings = $settings[$this->get_control_id('form_metadata')];
			foreach ($record->get('meta') as $id => $field) {
				if (in_array($id, $form_metadata_settings)) {
					$email_meta .= $this->field_formatted($field) . $line_break;
				}
			}
			if (! empty($email_meta)) {
				$fields['email_content'] .= $line_break . '---' . $line_break . $line_break . $email_meta;
			}
			$headers = sprintf('From: %s <%s>' . "\r\n", $fields['email_from_name'], $fields['email_from']);
			$headers .= sprintf('Reply-To: %s' . "\r\n", $email_reply_to);
			if ($send_html) {
				$headers .= 'Content-Type: text/html; charset=UTF-8' . "\r\n";
			}
			$cc_header = '';
			if (! empty($fields['email_to_cc'])) {
				$cc_header = 'Cc: ' . $fields['email_to_cc'] . "\r\n";
			}
			/**
			 * Email headers.
			 *
			 * Filters the additional headers sent when the form send an email.
			 *
			 * @since 1.0.0
			 *
			 * @param string|array $headers Additional headers.
			 */
			$headers = apply_filters('elementor_pro/forms/wp_mail_headers', $headers);
			/**
			 * Email content.
			 *
			 * Filters the content of the email sent by the form.
			 *
			 * @since 1.0.0
			 *
			 * @param string $email_content Email content.
			 */
			$fields['email_content'] = apply_filters('elementor_pro/forms/wp_mail_message', $fields['email_content']);
			$email_sent = wp_mail($fields['email_to'], $fields['email_subject'], $fields['email_content'], $headers . $cc_header);
			if (! empty($fields['email_to_bcc'])) {
				$bcc_emails = explode(',', $fields['email_to_bcc']);
				foreach ($bcc_emails as $bcc_email) {
					wp_mail(trim($bcc_email), $fields['email_subject'], $fields['email_content'], $headers);
				}
			}
			/**
			 * Elementor form mail sent.
			 *
			 * Fires when an email was sent successfully.
			 *
			 * @since 1.0.0
			 *
			 * @param array       $settings Form settings.
			 * @param Form_Record $record   An instance of the form record.
			 */
			do_action('elementor_pro/forms/mail_sent', $settings, $record);
			if (! $email_sent) {
				$message = Ajax_Handler::get_default_message(Ajax_Handler::SERVER_ERROR, $settings);
				$ajax_handler->add_error_message($message);
				throw new \Exception($message);
			}
		} else {
			// $ajax_handler->add_admin_error_message( "Conditional Logic: Disable send email");
			// $ajax_handler->set_success(true);
		}
	}
	private function replace_content_shortcodes($email_content, $record, $line_break)
	{
		$email_content = do_shortcode($email_content);
		$all_fields_shortcode = '[all-fields]';
		if (false !== strpos($email_content, $all_fields_shortcode)) {
			$text = '';
			foreach ($record->get('fields') as $field) {
				$formatted = $this->field_formatted($field);
				if (('textarea' === $field['type']) && ('<br>' === $line_break)) {
					$formatted = str_replace(["\r\n", "\n", "\r"], '<br />', $formatted);
				}
				$text .= $formatted . $line_break;
			}
			$email_content = str_replace($all_fields_shortcode, $text, $email_content);
		}
		return $email_content;
	}
	private function field_formatted($field)
	{
		$formatted = '';
		if (! empty($field['title'])) {
			$formatted = sprintf('%s: %s', $field['title'], $field['value']);
		} elseif (! empty($field['value'])) {
			$formatted = sprintf('%s', $field['value']);
		}
		return $formatted;
	}
	function elementor_conditional_logic_check_single($value_id, $operator, $value)
	{
		$rs = false;
		switch ($operator) {
			case "==":
				if ($value_id == $value) {
					$rs = true;
				}
				break;
			case "!=":
				if ($value_id != $value) {
					$rs = true;
				}
				break;
			case "e":
				if ($value_id == "") {
					$rs = true;
				}
				break;
			case "!e":
				if ($value_id != "") {
					$rs = true;
				}
				break;
			case "c":
				if (str_contains($value_id, $value)) {
					$rs = true;
				}
				break;
			case "!c":
				if (!str_contains($value_id, $value)) {
					$rs = true;
				}
				break;
			case "^":
				if (str_starts_with($value_id, $value)) {
					$rs = true;
				}
				break;
			case "~":
				if (str_ends_with($value_id, $value)) {
					$rs = true;
				}
				break;
			case ">":
				if ($value_id > $value) {
					$rs = true;
				}
				break;
			case "<":
				if ($value_id < $value) {
					$rs = true;
				}
			case "array":
				$values = array_map('trim', explode(',', $value));
				if (in_array($value_id, $values)) {
					$rs = true;
				}
				break;
			case "!array":
				$values = array_map('trim', explode(',', $value));
				if (!in_array($value_id, $values)) {
					$rs = true;
				}
				break;
			case "array_contain":
				$values = array_map('trim', explode(',', $value));
				foreach ($values as $vl) {
					if (str_contains($value_id, $vl)) {
						$rs = true;
					}
				}
				break;
			case "!array_contain":
				$values = array_map('trim', explode(',', $value));
				$rs = true;
				foreach ($values as $vl) {
					if (str_contains($value_id, $vl)) {
						$rs = false;
					}
				}
				break;
			default:
				break;
		}
		return $rs;
	}
}
class Superaddons_Email_Conditional_Logic_2 extends Superaddons_Email_Conditional_Logic
{
	public function get_name()
	{
		$id = $this->id_class();
		return 'email_conditional_logic_' . $id;
	}
	public function get_label()
	{
		$id = $this->id_class();
		$text = 'Email Conditional Logic ' . $id ;
		return  apply_filters("yeeaddons_condition_email_label", $text, $id);
	}
	protected function get_control_id($control_id)
	{
		return $control_id . '_conditional_logic_' . $this->id_class();
	}
	protected function id_class()
	{
		return 2;
	}
	public function register_settings_section($widget)
	{
		parent::register_settings_section($widget);
	}
}
class Superaddons_Email_Conditional_Logic_3 extends Superaddons_Email_Conditional_Logic_2
{
	protected function id_class()
	{
		return 3;
	}
}
class Superaddons_Email_Conditional_Logic_4 extends Superaddons_Email_Conditional_Logic_2
{
	protected function id_class()
	{
		return 4;
	}
}
class Superaddons_Email_Conditional_Logic_5 extends Superaddons_Email_Conditional_Logic_2
{
	protected function id_class()
	{
		return 5;
	}
}
class Superaddons_Email_Conditional_Logic_6 extends Superaddons_Email_Conditional_Logic
{
	
	protected function id_class()
	{
		return 6;
	}
	public function get_name()
	{
		$id = $this->id_class();
		return 'email_conditional_logic_' . $id;
	}
	public function get_label()
	{
		$id = $this->id_class();
		$text = 'Email Conditional Logic ' . $id . ' (Pro version)';
		return  apply_filters("yeeaddons_condition_email_label", $text, $id);
	}
	protected function get_control_id($control_id)
	{
		return $control_id . '_conditional_logic_' . $this->id_class();
	}
	public function register_settings_section($widget)
	{
		if (!class_exists('Yeeaddons_Upgrade_EL_Condition_Upload_Plugin')) {
			$widget->start_controls_section(
				$this->get_control_id('email_logic_section_sendy'),
				[
					'label' => $this->get_label(),
					'condition' => [
						'submit_actions' => $this->get_name(),
					],
				]
			);
			$widget->add_control(
				$this->get_control_id('cemail_logic_pro'),
				[
					'label' => esc_html__('Pro version', 'pdf-for-elementor-forms'),
					'type' => Controls_Manager::RAW_HTML,
					'content_classes' => 'pro_disable elementor-panel-alert elementor-panel-alert-info',
					'raw' => esc_html__('Upgrade to pro version', 'pdf-for-elementor-forms'),
				]
			);
			$widget->end_controls_section();
		} else {
			parent::register_settings_section($widget);
		}
	}
}
class Superaddons_Email_Conditional_Logic_7 extends Superaddons_Email_Conditional_Logic_6
{
	protected function id_class()
	{
		return 7;
	}
}
class Superaddons_Email_Conditional_Logic_8 extends Superaddons_Email_Conditional_Logic_6
{
	protected function id_class()
	{
		return 8;
	}
}
class Superaddons_Email_Conditional_Logic_9 extends Superaddons_Email_Conditional_Logic_6
{
	protected function id_class()
	{
		return 9;
	}
}
class Superaddons_Email_Conditional_Logic_10 extends Superaddons_Email_Conditional_Logic_6
{
	protected function id_class()
	{
		return 10;
	}
}
class Superaddons_Email_Conditional_Logic_11 extends Superaddons_Email_Conditional_Logic_6
{
	protected function id_class()
	{
		return 11;
	}
}
class Superaddons_Email_Conditional_Logic_12 extends Superaddons_Email_Conditional_Logic_6
{
	protected function id_class()
	{
		return 12;
	}
}
class Superaddons_Email_Conditional_Logic_13 extends Superaddons_Email_Conditional_Logic_6
{
	protected function id_class()
	{
		return 13;
	}
}
class Superaddons_Email_Conditional_Logic_14 extends Superaddons_Email_Conditional_Logic_6
{
	protected function id_class()
	{
		return 14;
	}
}
class Superaddons_Email_Conditional_Logic_15 extends Superaddons_Email_Conditional_Logic_6
{
	protected function id_class()
	{
		return 15;
	}
}
class Superaddons_Email_Conditional_Logic_16 extends Superaddons_Email_Conditional_Logic_6
{
	protected function id_class()
	{
		return 16;
	}
}
class Superaddons_Email_Conditional_Logic_17 extends Superaddons_Email_Conditional_Logic_6
{
	protected function id_class()
	{
		return 17;
	}
}
class Superaddons_Email_Conditional_Logic_18 extends Superaddons_Email_Conditional_Logic_6
{
	protected function id_class()
	{
		return 18;
	}
}
class Superaddons_Email_Conditional_Logic_19 extends Superaddons_Email_Conditional_Logic_6
{
	protected function id_class()
	{
		return 19;
	}
}
class Superaddons_Email_Conditional_Logic_20 extends Superaddons_Email_Conditional_Logic_6
{
	protected function id_class()
	{
		return 20;
	}
}
class Superaddons_Email_Conditional_Logic_21 extends Superaddons_Email_Conditional_Logic_6
{
	protected function id_class()
	{
		return 21;
	}
}
class Superaddons_Email_Conditional_Logic_22 extends Superaddons_Email_Conditional_Logic_6
{
	protected function id_class()
	{
		return 22;
	}
}
class Superaddons_Email_Conditional_Logic_23 extends Superaddons_Email_Conditional_Logic_6
{
	protected function id_class()
	{
		return 23;
	}
}
class Superaddons_Email_Conditional_Logic_24 extends Superaddons_Email_Conditional_Logic_6
{
	protected function id_class()
	{
		return 24;
	}
}
class Superaddons_Email_Conditional_Logic_25 extends Superaddons_Email_Conditional_Logic_6
{
	protected function id_class()
	{
		return 25;
	}
}
class Superaddons_Email_Conditional_Logic_26 extends Superaddons_Email_Conditional_Logic_6
{
	protected function id_class()
	{
		return 26;
	}
}
class Superaddons_Email_Conditional_Logic_27 extends Superaddons_Email_Conditional_Logic_6
{
	protected function id_class()
	{
		return 27;
	}
}
class Superaddons_Email_Conditional_Logic_28 extends Superaddons_Email_Conditional_Logic_6
{
	protected function id_class()
	{
		return 28;
	}
}
class Superaddons_Email_Conditional_Logic_29 extends Superaddons_Email_Conditional_Logic_6
{
	protected function id_class()
	{
		return 29;
	}
}
class Superaddons_Email_Conditional_Logic_30 extends Superaddons_Email_Conditional_Logic_6
{
	protected function id_class()
	{
		return 30;
	}
}
