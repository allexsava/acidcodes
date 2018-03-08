<?php
/*
Plugin Name: AcidCodes
Plugin URI: http://acidstudios.ro
Description: WordPress shortcodes plugin everywhere. Loaded with shortcodes, awesomeness and more.
Version: 2.3.4
Author: acidcodes
Author URI: http://acidstudios.ro
Author Email: contact@acidstudios.ro
*/

if (!defined('ABSPATH')) {
    die('-1');
}

class AcidCodesShortcodes
{

    protected static $plugin_dir;
    public $plugin_url;

    function __construct()
    {
        self::$plugin_dir = dirname(plugin_basename(__FILE__));
        $this->plugin_url = plugin_dir_url(dirname(__FILE__) . '/plugin.php');

        add_action('admin_init', array($this, 'acidcodes_init_plugin'));
        // Register admin styles and scripts
        add_action('mce_buttons_2', array($this, 'register_admin_assets'));

        // Register site styles and scripts
        // not used right now
        add_action('wp_enqueue_scripts', array($this, 'register_plugin_styles'));
//		add_action( 'wp_enqueue_scripts', array( $this, 'register_plugin_scripts' ) );

        // Run our plugin along with wordpress init
        add_action('init', array($this, 'create_acidcodes_shortcodes'));

        add_filter('the_content', array($this, 'acidcodes_remove_spaces_around_shortcodes'));

        // ajax load for modal
        if (is_admin()) {
            add_action('wp_ajax_acidcodes_get_shortcodes_modal', array($this, 'acidcodes_get_shortcodes_modal'));
        }

        //prevent certain shortcodes from getting their content texturized
        add_filter('no_texturize_shortcodes', array($this, 'acidcodes_shortcodes_to_exempt_from_wptexturize'));

    } // end constructor

    public function acidcodes_init_plugin()
    {
        $this->plugin_textdomain();
        $this->add_acidcodes_shortcodes_button();
    }

    public function plugin_textdomain()
    {
        $domain = 'acidcodes_txtd';
        $locale = apply_filters('plugin_locale', get_locale(), $domain);
        load_textdomain($domain, WP_LANG_DIR . '/' . $domain . '/' . $domain . '-' . $locale . '.mo');
        load_plugin_textdomain($domain, false, dirname(plugin_basename(__FILE__)) . '/lang/');
    } // end plugin_textdomain

    function add_acidcodes_shortcodes_button()
    {
        //make sure the user has correct permissions
        if (!current_user_can('edit_posts') && !current_user_can('edit_pages')) {
            return;
        }

        // add to the visual mode only
        if (get_user_option('rich_editing') == 'true') {
            add_filter('mce_external_plugins', array($this, 'addto_mce_acidcodes_shortcodes'));
            add_filter('mce_external_plugins', array($this, 'addto_mce_acidcodes_fontawesome'));
            add_filter('mce_external_plugins', array($this, 'addto_mce_acidcodes_main'));
            add_filter('mce_buttons', array($this, 'register_acidcodes_shortcodes_button'));
        }
    } // end register_admin_assets

    /**
     * Registers and enqueues admin-specific styles.
     */
    public function register_admin_assets($buttons)
    {
		wp_enqueue_style( 'acidcodes-shortcodes-reveal-styles', $this->plugin_url . 'style.css', array( 'wp-color-picker' ) );
        wp_enqueue_script('materialize-js', $this->plugin_url . 'assets/js/materialize/materialize.min.js');
//        wp_enqueue_script('main-js', get_template_directory_uri().'assets/js/main.js', array('jquery'), true);
//		wp_enqueue_script( 'select2-js', $this->plugin_url . 'assets/js/select2/select2.js', array(
//				'jquery',
//				'jquery-ui-tabs'
//			) );
//		wp_enqueue_script( 'wp-color-picker' );

        return $buttons;
    } // end register_plugin_styles

    /**
     * Registers and enqueues plugin-specific styles. Usually we base on the theme style and this is empty
     */
    public function register_plugin_styles()
    {


//        wp_enqueue_style('acidcodes-style', get_stylesheet_uri());


    } // end register_plugin_scripts


    /*--------------------------------------------*
     * Core Functions
     *---------------------------------------------*/

    /**
     * Registers and enqueues plugin-specific scripts..Usually we base on theme front-end scripts and this is empty.
     */
    public function register_plugin_scripts()
    {
    } // end action_method_name

    function register_acidcodes_shortcodes_button($buttons)
    {
        array_push($buttons, "acidcodes");

        return $buttons;
    } // end filter_method_name

    function addto_mce_acidcodes_shortcodes($plugin_array)
    {
        $plugin_array['acidcodes'] = $this->plugin_url . 'assets/js/add_shortcode.js';

        return $plugin_array;
    }

    function addto_mce_acidcodes_fontawesome($plugin_array)
    {
        $plugin_array['fontawesome'] = $this->plugin_url . 'assets/js/fontawesome-all.min.js';

        return $plugin_array;
    }

    function addto_mce_acidcodes_main($plugin_array)
    {
        $plugin_array['main'] = $this->plugin_url . 'assets/js/main.js';

        return $plugin_array;
    }

    public function acidcodes_get_shortcodes_modal()
    {
        ob_start();
        include('views/shortcodes-modal.php');
        echo json_encode(ob_get_clean());
        die();
    }

    public function create_acidcodes_shortcodes()
    {
        include_once('shortcodes.php');
    }

    function acidcodes_remove_spaces_around_shortcodes($content)
    {
        $array = array(
            '<p>[' => '[',
            ']</p>' => ']',
            ']<br />' => ']'
        );

        $content = strtr($content, $array);

        return $content;
    }

    /**
     * Add some of our own shortcodes to the list of shortcodes that won't have their content texturized.
     *
     * @param array $shortcodes
     *
     * @return array
     */
    function acidcodes_shortcodes_to_exempt_from_wptexturize($shortcodes)
    {
        $shortcodes[] = 'restaurantmenu';

        return $shortcodes;
    }

} // end class

$AcidCodesShortcodes = new AcidCodesShortcodes();
