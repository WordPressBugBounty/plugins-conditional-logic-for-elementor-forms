<?php
if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly
use Elementor\Controls_Manager;
use ElementorPro\Modules\Forms\actions\Redirect;
use Elementor\Modules\DynamicTags\Module as TagsModule;
class Superaddons_Redirect_Conditional_Logic extends Redirect {
    public function get_name() {
        return 'redirect_logic';
    }
    public function get_label() {
        return esc_html__( 'Redirect Conditional Logic', 'elementor-pro' );
    }
    protected function get_control_id( $control_id ) {
        return $control_id . '_conditional_logic';
    }
    public function register_settings_section( $widget ) {
        $options_logic = array(
                            "==" => esc_html__("is","conditional-logic-for-elementor-forms"),
                            "!=" => esc_html__("not is","conditional-logic-for-elementor-forms"),
                        );
        $options_pro = array(
                        "1" => esc_html__("Empty (Pro version)","conditional-logic-for-elementor-forms"),
                        "1" => esc_html__("Not empty (Pro version)","conditional-logic-for-elementor-forms"),
                        "3" => esc_html__("Contains (Pro version)","conditional-logic-for-elementor-forms"),
                        "4" => esc_html__("Does not contain (Pro version)","conditional-logic-for-elementor-forms"),
                        "5" => esc_html__("Starts with (Pro version)","conditional-logic-for-elementor-forms"),
                        "6" => esc_html__("Ends with (Pro version)","conditional-logic-for-elementor-forms"),
                        "7" => esc_html__("Greater than > (Pro version)","conditional-logic-for-elementor-forms"),
                        "8" => esc_html__("Less than < (Pro version)","conditional-logic-for-elementor-forms"),
                        "9" => esc_html__("List array (a,b,c)","conditional-logic-for-elementor-forms"),
                        "10" => esc_html__("Not List array (a,b,c)","conditional-logic-for-elementor-forms"),
                        "11" => esc_html__("List array contain (a,b,c)","conditional-logic-for-elementor-forms"),
                        "12" => esc_html__("Not List array contain (a,b,c)","conditional-logic-for-elementor-forms"),
                    );  
        $options_logic = apply_filters("yeeaddons_condition_options_logic",$options_logic);           
        $options_pro = apply_filters("yeeaddons_condition_options_logic_pro",$options_pro); 
        $widget->start_controls_section(
            $this->get_control_id( 'section_redirect' ),
            [
                'label' => $this->get_label(),
                'condition' => [
                    'submit_actions' => $this->get_name(),
                ],
            ]
        );
        $control_id_conditional_logic = $this->get_control_id( 'redirect_conditional_logic' );
        $widget->add_control(
            $control_id_conditional_logic,
            [
                'label' => esc_html__( 'Enable Conditional Logic', 'elementor-pro' ),
                'render_type' => 'none',
                'type' => Controls_Manager::SWITCHER,
            ]
        );
        $widget->add_control(
            $this->get_control_id( 'redirect_conditional_logic_display' ),
            [
                'label' => esc_html__( 'Display mode', "conditional-logic-for-elementor-forms" ),
                'type' => Controls_Manager::CHOOSE,
                'options' => [
                    'show' => [
                        'title' => esc_html__( 'Redirect if', "conditional-logic-for-elementor-forms" ),
                        'icon' => 'fa fa-eye',
                    ],
                    'hide' => [
                        'title' => esc_html__( 'Disable if', "conditional-logic-for-elementor-forms" ),
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
            $this->get_control_id( 'redirect_conditional_logic_trigger' ),
            [
                'label' => esc_html__( 'When to Trigger', "conditional-logic-for-elementor-forms" ),
                'type' => Controls_Manager::SELECT,
                'options' => [
                    "ALL"=>"ALL",
                    "ANY"=>"ANY"
                ],
                'default' => 'ALL',
                'condition' => [
                    $control_id_conditional_logic => 'yes'
                ],
            ]
        );
        $widget->add_control(
            $this->get_control_id( 'redirect_conditional_logic_datas' ),
            [
                'name'           => 'redirect_conditional_logic_datas',
                'label'          => esc_html__( 'Fields if', "conditional-logic-for-elementor-forms" ),
                'type'           => 'conditional_logic_repeater',
                'fields'         => [
                    [
                        'name' => 'conditional_logic_id',
                        'label' => esc_html__( 'Field ID', "conditional-logic-for-elementor-forms" ),
                        'type' => Controls_Manager::TEXT,
                        'label_block' => true,
                        'default' => '',
                    ],
                     [
                        'name' => 'conditional_logic_operator',
                        'label' => esc_html__( 'Operator', "conditional-logic-for-elementor-forms" ),
                        'type' => Controls_Manager::SELECT,
                        'label_block' => true,
                        'options' => $options_logic,
                        'options_pro' => $options_pro,
                       'default' => '==',
                    ],
                    [
                        'name' => 'conditional_logic_value',
                        'label' => esc_html__( 'Value to compare', "conditional-logic-for-elementor-forms" ),
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
            $this->get_control_id( 'redirect_to' ),
            [
                'label' => esc_html__( 'Redirect To', 'elementor-pro' ),
                'type' => Controls_Manager::TEXT,
                'placeholder' => esc_html__( 'https://your-link.com', 'elementor-pro' ),
                'dynamic' => [
                    'active' => true,
                    'categories' => [
                        TagsModule::POST_META_CATEGORY,
                        TagsModule::TEXT_CATEGORY,
                        TagsModule::URL_CATEGORY,
                    ],
                ],
                'label_block' => true,
                'render_type' => 'none',
                'classes' => 'elementor-control-direction-ltr',
            ]
        );
        $widget->add_control(
            $this->get_control_id( 'redirect_to_new_tab' ),
			[
				'label' => esc_html__( 'Open new tab', 'elementor-pro' ),
				'type' => Controls_Manager::SWITCHER,
				'default' => false,
			]
		);
        $widget->end_controls_section();
    }
    public function on_export( $element ) {
        unset(
            $element['settings'][$this->get_control_id( 'redirect_to' )]
        );
        return $element;
    }
    public function run( $record, $ajax_handler ) {
        $settings = $record->get( 'form_settings' );
        $send_status = true;
        if( $settings[$this->get_control_id( 'redirect_conditional_logic' )] == "yes" ){
            $display = $settings[$this->get_control_id( 'redirect_conditional_logic_display' )];
            $trigger = $settings[$this->get_control_id( 'redirect_conditional_logic_trigger' )];
            $datas = $settings[$this->get_control_id( 'redirect_conditional_logic_datas' )];
            $rs = array();
            $form_fields = $record->get("fields");
            foreach ( $datas as $logic_key => $logic_values ) {
                if(isset($form_fields[$logic_values["conditional_logic_id"]])){
                    $value_id = $form_fields[$logic_values["conditional_logic_id"]]["value"];
                    if( is_array($value_id) ){
                        $value_id = implode(", ",$value_id);
                    }
                }else{
                   $value_id = $logic_values["conditional_logic_id"];
                }
                $operator = $logic_values["conditional_logic_operator"];
                $value = $logic_values["conditional_logic_value"];
                $rs[] = $this->elementor_conditional_logic_check_single($value_id,$operator,$value);
            }
            if( $trigger =="ALL"  ){
                $check_rs = true;
                foreach ( $rs as $fkey => $fvalue ) {
                    if( $fvalue == false ){
                        $check_rs =false;
                        break;
                    }
                }
          }else{
                $check_rs = false;
                foreach ( $rs as $fkey => $fvalue ) {
                    if( $fvalue == true ){
                        $check_rs =true;
                        break;
                    }
                }
          }
          if($display == "show"){
                if( $check_rs == true ){
                    $send_status = true;
                }else{
                    $send_status = false;
                }
          }else{
                if( $check_rs == true ){
                    $send_status = false;
                }else{
                    $send_status = true;
                }
          }
        }
        if( $send_status ==  true ){
            $redirect_to = $settings[$this->get_control_id( 'redirect_to' )];
            $redirect_to = $record->replace_setting_shortcodes( $redirect_to, true );
            if ( ! empty( $redirect_to ) && filter_var( $redirect_to, FILTER_VALIDATE_URL ) ) {
                if( $settings[$this->get_control_id( 'redirect_to_new_tab' )] == "yes"){
                    $ajax_handler->add_response_data( 'redirect_url_new_tab', $redirect_to );
                }else{
                    $ajax_handler->add_response_data( 'redirect_url', $redirect_to );
                }
            }
        }else{
            //$ajax_handler->add_admin_error_message( "Conditional Logic: Disable Redirect" );
        }
    }
    function elementor_conditional_logic_check_single($value_id,$operator,$value){
        $rs = false;
        switch($operator) {
              case "==":
                    if( $value_id == $value){
                        $rs = true;
                    }   
                break;
              case "!=":
                    if( $value_id != $value){
                            $rs = true;
                    }
                    break;
              case "e":
                    if( $value_id == ""){
                            $rs = true;
                    }
                    break;
              case "!e":
                    if( $value_id != ""){
                            $rs = true;
                    }
                    break;
              case "c":
                    if( str_contains($value_id,$value) ){
                        $rs = true;
                    }
                    break;
               case "!c":
                    if( !str_contains($value_id,$value) ){
                        $rs = true;
                    }
                break;
               case "^":
                    if( str_starts_with($value_id,$value) ){
                        $rs = true;
                    }
                    break;
               case "~":
                    if( str_ends_with($value_id,$value) ){
                        $rs = true;
                    }
                    break;
               case ">":
                    if( $value_id > $value){
                        $rs = true;
                    }
                    break;
                case "<":
                    if( $value_id < $value){
                            $rs = true;
                    }
                    break;
                case "array":
                    $values= array_map('trim', explode(',', $value));
                    if( in_array($value_id,$values)){
                            $rs = true;
                    }
                    break;
                case "!array":
                    $values= array_map('trim', explode(',', $value));
                    if( !in_array($value_id,$values)){
                            $rs = true;
                    }
                    break;
                case "array_contain":
                    $values= array_map('trim', explode(',', $value));
                    foreach($values as $vl){
                        if( str_contains($value_id,$vl) ){
                            $rs = true;
                        }
                    }
                    break;
                case "!array_contain":
                    $values= array_map('trim', explode(',', $value));
                    $rs = true;
                    foreach($values as $vl){
                        if( str_contains($value_id,$vl) ){
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
class Superaddons_Redirect_Conditional_Logic_2 extends Superaddons_Redirect_Conditional_Logic {
    public function get_name() {
        $id = $this->id_class();
        return 'redirect_conditional_logic_'.$id;
    }
    public function get_label() {
        $id = $this->id_class();
        $text = 'Redirect Conditional Logic '.$id;
        return  apply_filters("yeeaddons_condition_redirect_label",$text,$id);
    }
    protected function get_control_id( $control_id ) {
        $id = $this->id_class();
        return $control_id . '_conditional_logic_'.$id;
    }
    protected function id_class(){
        return 2;
    }
}
class Superaddons_Redirect_Conditional_Logic_3 extends Superaddons_Redirect_Conditional_Logic_2 {
    protected function id_class(){
        return 3;
    }
}
class Superaddons_Redirect_Conditional_Logic_4 extends Superaddons_Redirect_Conditional_Logic_2 {
    protected function id_class(){
        return 4;
    }
}
class Superaddons_Redirect_Conditional_Logic_5 extends Superaddons_Redirect_Conditional_Logic_2 {
    protected function id_class(){
        return 5;
    }
}
class Superaddons_Redirect_Conditional_Logic_6 extends Superaddons_Redirect_Conditional_Logic {
    protected function id_class(){
        return 6;
    }
    public function get_name() {
        $id = $this->id_class();
        return 'redirect_conditional_logic_'.$id;
    }
    public function get_label() {
        $id = $this->id_class();
        $text = 'Redirect Conditional Logic '.$id.' (Pro version)';
        return  apply_filters("yeeaddons_condition_redirect_label",$text,$id);
    }
    protected function get_control_id( $control_id ) {
        $id = $this->id_class();
        return $control_id . '_conditional_logic_'.$id;
    }
    public function register_settings_section( $widget ) {
        if(!class_exists('Yeeaddons_Upgrade_EL_Condition_Upload_Plugin')){
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
                    'label' => esc_html__( 'Pro version', 'pdf-for-elementor-forms' ),
                    'type' => Controls_Manager::RAW_HTML,
                    'content_classes' => 'pro_disable elementor-panel-alert elementor-panel-alert-info',
                    'raw' => esc_html__( 'Upgrade to pro version', 'pdf-for-elementor-forms' ),
                ]
            );
            $widget->end_controls_section();
        }else{
            parent::register_settings_section($widget);
        }
    }
}
class Superaddons_Redirect_Conditional_Logic_7 extends Superaddons_Redirect_Conditional_Logic_6 {
   protected function id_class(){
        return 7;
    }
}
class Superaddons_Redirect_Conditional_Logic_8 extends Superaddons_Redirect_Conditional_Logic_6 {
   protected function id_class(){
        return 5;
    }
}
class Superaddons_Redirect_Conditional_Logic_9 extends Superaddons_Redirect_Conditional_Logic_2 {
    protected function id_class(){
        return 9;
    }
}
class Superaddons_Redirect_Conditional_Logic_10 extends Superaddons_Redirect_Conditional_Logic_6 {
    protected function id_class(){
        return 10;
    }
}
class Superaddons_Redirect_Conditional_Logic_11 extends Superaddons_Redirect_Conditional_Logic_6 {
   protected function id_class(){
        return 11;
    }
}
class Superaddons_Redirect_Conditional_Logic_12 extends Superaddons_Redirect_Conditional_Logic_6 {
    protected function id_class(){
        return 12;
    }
}
class Superaddons_Redirect_Conditional_Logic_13 extends Superaddons_Redirect_Conditional_Logic_6 {
    protected function id_class(){
        return 13;
    }
}
class Superaddons_Redirect_Conditional_Logic_14 extends Superaddons_Redirect_Conditional_Logic_6 {
    protected function id_class(){
        return 14;
    }
}
class Superaddons_Redirect_Conditional_Logic_15 extends Superaddons_Redirect_Conditional_Logic_6 {
    protected function id_class(){
        return 15;
    }
}
class Superaddons_Redirect_Conditional_Logic_16 extends Superaddons_Redirect_Conditional_Logic_6 {
    protected function id_class(){
        return 16;
    }
}
class Superaddons_Redirect_Conditional_Logic_17 extends Superaddons_Redirect_Conditional_Logic_6 {
    protected function id_class(){
        return 17;
    }
}
class Superaddons_Redirect_Conditional_Logic_18 extends Superaddons_Redirect_Conditional_Logic_6 {
    protected function id_class(){
        return 18;
    }
}
class Superaddons_Redirect_Conditional_Logic_19 extends Superaddons_Redirect_Conditional_Logic_6 {
    protected function id_class(){
        return 19;
    }
}
class Superaddons_Redirect_Conditional_Logic_20 extends Superaddons_Redirect_Conditional_Logic_6 {
    protected function id_class(){
        return 20;
    }
}
class Superaddons_Redirect_Conditional_Logic_21 extends Superaddons_Redirect_Conditional_Logic_6 {
    protected function id_class(){
        return 21;
    }
}
class Superaddons_Redirect_Conditional_Logic_22 extends Superaddons_Redirect_Conditional_Logic_6 {
    protected function id_class(){
        return 22;
    }
}
class Superaddons_Redirect_Conditional_Logic_23 extends Superaddons_Redirect_Conditional_Logic_6 {
    protected function id_class(){
        return 23;
    }
}
class Superaddons_Redirect_Conditional_Logic_24 extends Superaddons_Redirect_Conditional_Logic_6 {
    protected function id_class(){
        return 24;
    }
}
class Superaddons_Redirect_Conditional_Logic_25 extends Superaddons_Redirect_Conditional_Logic_6 {
    protected function id_class(){
        return 25;
    }
}
class Superaddons_Redirect_Conditional_Logic_26 extends Superaddons_Redirect_Conditional_Logic_6 {
    protected function id_class(){
        return 26;
    }
}
class Superaddons_Redirect_Conditional_Logic_27 extends Superaddons_Redirect_Conditional_Logic_6 {
    protected function id_class(){
        return 27;
    }
}
class Superaddons_Redirect_Conditional_Logic_28 extends Superaddons_Redirect_Conditional_Logic_6 {
    protected function id_class(){
        return 28;
    }
}
class Superaddons_Redirect_Conditional_Logic_29 extends Superaddons_Redirect_Conditional_Logic_6 {
    protected function id_class(){
        return 29;
    }
}
class Superaddons_Redirect_Conditional_Logic_30 extends Superaddons_Redirect_Conditional_Logic_6 {
    protected function id_class(){
        return 30;
    }
}