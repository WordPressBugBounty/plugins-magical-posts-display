<?php

/**
 * WordPress settings API demo class
 *
 * @author Tareq Hasan
 */
if (!class_exists('mgpDisplayWelcomePage')) :
    class mgpDisplayWelcomePage
    {

        private $settings_api;

        function __construct()
        {
            $this->settings_api = new WeDevs_Settings_API();
            add_action('wsa_form_top_magical_ptab_home', [$this, 'magical_welcome_tabs']);
            add_action('admin_init', array($this, 'admin_init'));
            add_action('admin_menu', array($this, 'admin_menu'));
        }

        function admin_init()
        {

            //set the settings
            $this->settings_api->set_sections($this->get_settings_sections());
            //  $this->settings_api->set_fields( $this->get_settings_fields() );

            //initialize settings
            $this->settings_api->admin_init();
        }

        function admin_menu()
        {
            $menu_text = class_exists('magicalPostDisplayPro') ?  esc_html__('Magical Posts Display Pro', 'magical-posts-display') : esc_html__('Magical Posts Display', 'magical-posts-display');

            add_menu_page($menu_text, $menu_text, 'manage_options', 'mgpd-page', array($this, 'plugin_page'), 'dashicons-tickets-alt', 20);

            add_submenu_page('mgpd-page', esc_html__("WelCome Page", 'gbox'), esc_html__("WelCome Page", 'gbox'), "manage_options",  'mgpd-page', array($this, 'plugin_page'));
        }


        function get_settings_sections()
        {
            $sections = array(
                array(
                    'id'    => 'magical_ptab_home',
                    'title' => __('Home', 'magical-addons-for-elementor')
                ),
                /*array(
                'id'    => 'magical_addons',
                'title' => __( 'Addons', 'magical-addons-for-elementor' )
            )*/
            );
            return $sections;
        }

        /**
         * Returns all the settings fields
         *
         * @return array settings fields
         */
        function get_settings_fields()
        {
            $settings_fields = array(
                'magical_ptab_home' => array(),

                /*'magical_addons' => array(),*/

            );

            return $settings_fields;
        }
        // General tab
        function magical_welcome_tabs()
        {

            ob_start();
            include MAGICAL_POSTS_DISPLAY_DIR . 'admin/admin-page/welcome-page.php';
            $content = ob_get_clean();
            echo wp_kses_post($content);
        }

        function plugin_page()
        {
            echo '<div class="wrap magical-posts-wrap">';

            $this->settings_api->show_navigation();
            $this->settings_api->show_forms();

            echo '</div>';
        }

        /**
         * Get all the pages
         *
         * @return array page names with key value pairs
         */
        function get_pages()
        {
            $pages = get_pages();
            $pages_options = array();
            if ($pages) {
                foreach ($pages as $page) {
                    $pages_options[$page->ID] = $page->post_title;
                }
            }

            return $pages_options;
        }
    }
endif;

new mgpDisplayWelcomePage();
