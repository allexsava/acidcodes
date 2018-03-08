<?php

if (!defined('ABSPATH')) {
    die('-1');
}

class AcidCodesShortcode_Separator extends AcidCodesShortcode
{

    public function __construct($settings = array())
    {
        $this->self_closed = true;
        $this->name = "Separator";
        $this->code = "hr";
        $this->icon = "fas fa-minus-square";
        $this->direct = false;

        $this->direct = apply_filters('acidcodes_filter_direct_for_' . strtolower($this->name), $this->direct);

        $this->params = array(
            'align' => array(
                'type' => 'select',
                'name' => 'Alignment',
                'options' => array(
                    '' => '-- Select Alignment --',
                    'center' => 'Center',
                    'left' => 'Left',
                    'right' => 'Right'
                ),
                'admin_class' => 'input-field hide-list col s6 span12',
                'help-text'   => 'eg center, left, right'
            ),
            'size' => array(
                'type' => 'select',
                'name' => 'Size',
                'options' => array(
                    '' => '-- Select Size --',
                    'regular' => 'Regular',
                    'double' => 'Double'
                ),
                'admin_class' => 'input-field hide-list col s6 span6',
                'help-text'   => 'eg regular, double'
            ),
            'weight' => array(
                'type' => 'select',
                'name' => 'Weight',
                'options' => array(
                    '' => '-- Select Weight --',
                    'thin' => 'Thin',
                    'thick' => 'Thick'
                ),
                'admin_class' => 'input-field hide-list col s6 span5 push1',
                'help-text'   => 'eg thin, thick'
            ),
            'color' => array(
                'type' => 'select',
                'name' => 'Color',
                'options' => array(
                    '' => '-- Select Color --',
                    'dark' => 'Dark',
                    'white' => 'Light',
                    'color' => 'Color'
                ),
                'admin_class' => 'input-field hide-list col s6 span6',
                'help-text'   => 'eg dark, light, color'
            ),
            'style' => array(
                'type' => 'select',
                'name' => 'Style',
                'options' => array(
                    '' => '-- Select Style --',
                    'dotted' => 'Dotted',
                    'striped' => 'Striped'
                ),
                'admin_class' => 'input-field hide-list col s6 span5 push1',
                'help-text'   => 'eg dotted, striped'
            )
        );

        // allow the theme or other plugins to "hook" into this shortcode's params
        $this->params = apply_filters('acidcodes_filter_params_for_' . strtolower($this->name), $this->params);

        add_shortcode('hr', array($this, 'add_shortcode'));
    }

    public function add_shortcode($atts, $content)
    {
        //create an array with only the registered params - dynamic since we filter them and have no way of knowing for sure
        $extract_params = array();
        if (isset($this->params)) {
            foreach ($this->params as $key => $value) {
                $extract_params[$key] = '';
            }
        }
        extract(shortcode_atts($extract_params, $atts));

        /**
         * Template localization between plugin and theme
         */
        $located = locate_template("templates/shortcodes/{$this->code}.php", false, false);
        if (!$located) {
            $located = dirname(__FILE__) . '/templates/' . $this->code . '.php';
        }
        // load it
        ob_start();
        require $located;

        return ob_get_clean();
    }
}
