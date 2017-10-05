<?php 

if ( ! class_exists( 'WP_themes_stats_loader' ) ) {
    /**
     * Responsible for setting up constants, classes and includes.
     *
     * @since 1.0
     */
    final class WP_themes_stats_loader {
        /**
         * The unique instance of the plugin.
         *
         * @var Instance variable
         */
        private static $instance;

        /**
         * Gets an instance of our plugin.
         */
        /**
         * Gets an instance of our plugin.
         */
        public static function get_instance() {

            if ( null === self::$instance ) {
                self::$instance = new self();
            }

            return self::$instance;
        }

        /**
         * Constructor.
         */
        private function __construct() {

            $this->define_constants();
            $this->load_files();
            $this->init_hooks();
        }

        /**
         * Initialization hooks
         *
         * @category Hooks
         */
        function init_hooks() {
            add_action( 'admin_menu', array( $this, 'register_options_menu' ), 99 );
            add_action( 'admin_enqueue_scripts', array( $this, 'enqueue_admin_scripts' ), 10 );
            add_action( 'admin_init', array( $this, 'register_wp_theme_active_settings' ) );
        }

        /**
         * Regsiter option menu
         *
         * @category Filter
         */
        function register_options_menu() {
            add_submenu_page( 
                'options-general.php', 
                'WP Theme Stats Settings', 
                'WP Active Installs', 
                'manage_options', 
                'wp_active_install_stats', 
                array(&$this, 'render_options_page')
            );
        }

        /**
         * Includes options page
         */
        function render_options_page() {
            require_once WP_THEMES_STATS_BASE_DIR . 'includes/wp-stats-options-page.php';
        }


        /**
         * Define constants.
         *
         * @since 1.0
         * @return void
         */
        private function define_constants() {

            $file = dirname( dirname( __FILE__ ) );
            define( 'WP_THEMES_STATS_VERSION', '1.0.0' );
            define( 'WP_THEMES_STATS_DIR_NAME', plugin_basename( $file ) );
            define( 'WP_THEMES_STATS_BASE_FILE', trailingslashit( $file ) . WP_THEMES_STATS_DIR_NAME . '.php' );
            define( 'WP_THEMES_STATS_BASE_DIR', plugin_dir_path( WP_THEMES_STATS_BASE_FILE ) );
            define( 'WP_THEMES_STATS_BASE_URL', plugins_url( '/',  WP_THEMES_STATS_BASE_FILE ) );
        }

        /**
         * Loads classes and includes.
         *
         * @since 1.0
         * @return void
         */
        static private function load_files() {
            require_once WP_THEMES_STATS_BASE_DIR . 'includes/wp-themes-stats-api.php';
        }
        /**
         * Enqueue admin scripts.
         *
         * @since 1.0
         */
        function enqueue_admin_scripts() {
            wp_enqueue_style( 'wp-active-install-style', WP_THEMES_STATS_BASE_URL . 'assets/css/admin.css' );
        }
        /**
         * Register setting option variables.
         */
        function register_wp_theme_active_settings() {
            // Register our settings.
            register_setting( 'wp-active-stats-settings-group', 'wp_theme_name' );
            register_setting( 'wp-active-stats-settings-group', 'wp_theme_author' );
            register_setting( 'wp-active-stats-settings-group', 'wp_theme_tag' );
        }
    }

$wp_themes_stats_loader = WP_themes_stats_loader::get_instance();

}