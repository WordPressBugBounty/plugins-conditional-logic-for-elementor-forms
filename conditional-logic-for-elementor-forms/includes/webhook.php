<?php
if (! defined('ABSPATH')) exit; // Exit if accessed directly
use Elementor\Controls_Manager;
use Elementor\Modules\DynamicTags\Module as TagsModule;
use ElementorPro\Modules\Forms\Actions\Webhook;

class Yeekit_EL_Webhook_Conditional_Logic extends Webhook
{
    public function get_name()
    {
        return 'webhook_logic';
    }
    public function get_label()
    {
        return esc_html__('Webhook Conditional Logic', 'elementor-pro');
    }
    protected function get_control_id($control_id)
    {
        return $control_id . '_conditional_logic';
    }
    public function register_settings_section($widget)
    {
        $options_logic = array(
            "==" => esc_html__("is", "conditional-logic-for-elementor-forms"),
            "!=" => esc_html__("not is", "conditional-logic-for-elementor-forms"),
        );
        $options_pro = array(
            "1" => esc_html__("Empty (Pro version)", "conditional-logic-for-elementor-forms"),
            "1" => esc_html__("Not empty (Pro version)", "conditional-logic-for-elementor-forms"),
            "3" => esc_html__("Contains (Pro version)", "conditional-logic-for-elementor-forms"),
            "4" => esc_html__("Does not contain (Pro version)", "conditional-logic-for-elementor-forms"),
            "5" => esc_html__("Starts with (Pro version)", "conditional-logic-for-elementor-forms"),
            "6" => esc_html__("Ends with (Pro version)", "conditional-logic-for-elementor-forms"),
            "7" => esc_html__("Greater than > (Pro version)", "conditional-logic-for-elementor-forms"),
            "8" => esc_html__("Less than < (Pro version)", "conditional-logic-for-elementor-forms"),
            "9" => esc_html__("List array (a,b,c)", "conditional-logic-for-elementor-forms"),
            "10" => esc_html__("Not List array (a,b,c)", "conditional-logic-for-elementor-forms"),
            "11" => esc_html__("List array contain (a,b,c)", "conditional-logic-for-elementor-forms"),
            "12" => esc_html__("Not List array contain (a,b,c)", "conditional-logic-for-elementor-forms"),
        );
        $options_logic = apply_filters("yeeaddons_condition_options_logic", $options_logic);
        $options_pro = apply_filters("yeeaddons_condition_options_logic_pro", $options_pro);
        $widget->start_controls_section(
            $this->get_control_id('section_webhook'),
            [
                'label' => $this->get_label(),
                'condition' => [
                    'submit_actions' => $this->get_name(),
                ],
            ]
        );
        $control_id_conditional_logic = $this->get_control_id('webhook_conditional_logic');
        $widget->add_control(
            $control_id_conditional_logic,
            [
                'label' => esc_html__('Enable Conditional Logic', 'elementor-pro'),
                'render_type' => 'none',
                'type' => Controls_Manager::SWITCHER,
            ]
        );
        $widget->add_control(
            $this->get_control_id('webhook_conditional_logic_display'),
            [
                'label' => esc_html__('Display mode', "conditional-logic-for-elementor-forms"),
                'type' => Controls_Manager::CHOOSE,
                'options' => [
                    'show' => [
                        'title' => esc_html__('Webhook if', "conditional-logic-for-elementor-forms"),
                        'icon' => 'fa fa-eye',
                    ],
                    'hide' => [
                        'title' => esc_html__('Disable if', "conditional-logic-for-elementor-forms"),
                        'icon' => 'fa fa-eye-slash',
                    ],
                ],
                'default' => 'show',
                'condition' => [
                    $control_id_conditional_logic => 'yes'
                ],
            ]
        );
        $widget->add_control(
            $this->get_control_id('webhook_conditional_logic_trigger'),
            [
                'label' => esc_html__('When to Trigger', "conditional-logic-for-elementor-forms"),
                'type' => Controls_Manager::SELECT,
                'options' => [
                    "ALL" => "ALL",
                    "ANY" => "ANY"
                ],
                'default' => 'ALL',
                'condition' => [
                    $control_id_conditional_logic => 'yes'
                ],
            ]
        );
        $widget->add_control(
            $this->get_control_id('webhook_conditional_logic_datas'),
            [
                'name'           => 'webhook_conditional_logic_datas',
                'label'          => esc_html__('Fields if', "conditional-logic-for-elementor-forms"),
                'type'           => 'conditional_logic_repeater',
                'fields'         => [
                    [
                        'name' => 'conditional_logic_id',
                        'label' => esc_html__('Field ID', "conditional-logic-for-elementor-forms"),
                        'type' => Controls_Manager::TEXT,
                        'label_block' => true,
                        'default' => '',
                    ],
                    [
                        'name' => 'conditional_logic_operator',
                        'label' => esc_html__('Operator', "conditional-logic-for-elementor-forms"),
                        'type' => Controls_Manager::SELECT,
                        'label_block' => true,
                        'options' => $options_logic,
                        'options_pro' => $options_pro,
                        'default' => '==',
                    ],
                    [
                        'name' => 'conditional_logic_value',
                        'label' => esc_html__('Value to compare', "conditional-logic-for-elementor-forms"),
                        'type' => Controls_Manager::TEXT,
                        'label_block' => true,
                        'default' => '',
                    ],
                ],
                'condition' => [
                    $control_id_conditional_logic => 'yes'
                ],
                'style_transfer' => false,
                'title_field'    => '{{{ conditional_logic_id  }}} {{{ conditional_logic_operator  }}} {{{ conditional_logic_value  }}}',
                'default'        => array(
                    array(
                        'conditional_logic_id' => '',
                        'conditional_logic_operator' => '==',
                        'conditional_logic_value' => '',
                    ),
                ),
            ]
        );
        $widget->add_control(
            $this->get_control_id('webhooks'),
            [
                'label' => esc_html__('Webhook URL', 'elementor-pro'),
                'type' => Controls_Manager::TEXT,
                'placeholder' => esc_html__('https://your-webhook-url.com', 'elementor-pro'),
                'ai' => [
                    'active' => false,
                ],
                'label_block' => true,
                'separator' => 'before',
                'description' => esc_html__('Enter the integration URL (like Zapier) that will receive the form\'s submitted data.', 'elementor-pro'),
                'render_type' => 'none',
                'dynamic' => [
                    'active' => true,
                ],
            ]
        );
        $widget->add_control(
            $this->get_control_id('webhooks_advanced_data'),
            [
                'label' => esc_html__('Advanced Data', 'elementor-pro'),
                'type' => Controls_Manager::SWITCHER,
                'default' => 'no',
                'render_type' => 'none',
            ]
        );
        $widget->end_controls_section();
    }
    public function on_export($element)
    {
        return $element;
    }
    public function run($record, $ajax_handler)
    {
        $settings = $record->get('form_settings');
        if (empty($settings[$this->get_control_id('webhooks')])) {
            return;
        }
        $send_status = true;
        if ($settings[$this->get_control_id('webhook_conditional_logic')] == "yes") {
            $display = $settings[$this->get_control_id('webhook_conditional_logic_display')];
            $trigger = $settings[$this->get_control_id('webhook_conditional_logic_trigger')];
            $datas = $settings[$this->get_control_id('webhook_conditional_logic_datas')];
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
            if (isset($settings[$this->get_control_id('webhooks_advanced_data')]) && 'yes' === $settings[$this->get_control_id('webhooks_advanced_data')]) {
                $body['form'] = [
                    'id' => $settings['id'],
                    'name' => $settings['form_name'],
                ];

                $body['fields'] = $record->get('fields');
                $body['meta'] = $record->get('meta');
            } else {
                $body = $record->get_formatted_data(true);
                $body['form_id'] = $settings['id'];
                $body['form_name'] = $settings['form_name'];
            }

            $args = [
                'body' => $body,
            ];

            /**
             * Forms webhook request arguments.
             *
             * Filters the request arguments delivered by the form webhook when executing
             * an ajax request.
             *
             * @since 1.0.0
             *
             * @param array       $args   Webhook request arguments.
             * @param Form_Record $record An instance of the form record.
             */
            $args = apply_filters('elementor_pro/forms/webhooks/request_args', $args, $record);

            $response = wp_safe_remote_post($settings[$this->get_control_id('webhooks')], $args);

            /**
             * Elementor form webhook response.
             *
             * Fires when the webhook response is retrieved by Elementor forms. This hook
             * allows developers to add functionality after recieving webhook responses.
             *
             * @since 1.0.0
             *
             * @param \WP_Error|array $response The response or WP_Error on failure.
             * @param Form_Record     $record   An instance of the form record.
             */
            do_action('elementor_pro/forms/webhooks/response', $response, $record);

            if (200 !== (int) wp_remote_retrieve_response_code($response)) {
                throw new \Exception('Webhook error.');
            }
        } else {
            //$ajax_handler->add_admin_error_message( "Conditional Logic: Disable Webhook" );
        }
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
                break;
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
class Yeekit_EL_Webhook_Conditional_Logic_2 extends Yeekit_EL_Webhook_Conditional_Logic
{
    public function get_name()
    {
        $id = $this->id_class();
        return 'webhook_conditional_logic_' . $id;
    }
    public function get_label()
    {
        $id = $this->id_class();
        $text = 'Webhook Conditional Logic ' . $id ." - Pro";
        return  apply_filters("yeeaddons_condition_webhook_label", $text, $id);
    }
    protected function get_control_id($control_id)
    {
        $id = $this->id_class();
        return $control_id . '_conditional_logic_' . $id;
    }
    public function register_settings_section($widget)
    {
        if (!class_exists('Yeeaddons_Upgrade_EL_Condition_Upload_Plugin')) {
            $widget->start_controls_section(
                $this->get_control_id('conditional_logic_section_sendy'),
                [
                    'label' => $this->get_label(),
                    'condition' => [
                        'submit_actions' => $this->get_name(),
                    ],
                ]
            );
            $widget->add_control(
                $this->get_control_id('conditional_logic_pro'),
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
    protected function id_class()
    {
        return 2;
    }
}
class Yeekit_EL_Webhook_Conditional_Logic_3 extends Yeekit_EL_Webhook_Conditional_Logic_2
{
    protected function id_class()
    {
        return 3;
    }
}
class Yeekit_EL_Webhook_Conditional_Logic_4 extends Yeekit_EL_Webhook_Conditional_Logic_2
{
    protected function id_class()
    {
        return 4;
    }
}
class Yeekit_EL_Webhook_Conditional_Logic_5 extends Yeekit_EL_Webhook_Conditional_Logic_2
{
    protected function id_class()
    {
        return 5;
    }
}