<?php

/**
 * The admin-specific functionality of the plugin.
 *
 * @link       https://habitatweb.mx/
 * @since      1.0.0
 *
 * @package    Qmaker
 * @subpackage Qmaker/admin
 */

/**
 * The admin-specific functionality of the plugin.
 *
 * Defines the plugin name, version, and two examples hooks for how to
 * enqueue the admin-specific stylesheet and JavaScript.
 *
 * @package    Qmaker
 * @subpackage Qmaker/admin
 * @author     Habitat Web <contacto@habitat.com>
 */
class Qmaker_Admin {

	/**
	 * The ID of this plugin.
	 *
	 * @since    1.0.0
	 * @access   private
	 * @var      string    $plugin_name    The ID of this plugin.
	 */
	private $plugin_name;

	/**
	 * The version of this plugin.
	 *
	 * @since    1.0.0
	 * @access   private
	 * @var      string    $version    The current version of this plugin.
	 */
	private $version;

	/**
	 * Initialize the class and set its properties.
	 *
	 * @since    1.0.0
	 * @param      string    $plugin_name       The name of this plugin.
	 * @param      string    $version    The version of this plugin.
	 */
	public function __construct( $plugin_name, $version ) {

		$this->plugin_name = $plugin_name;
		$this->version = $version;

	}

	/**
	 * Register the stylesheets for the admin area.
	 *
	 * @since    1.0.0
	 */
	public function enqueue_styles() {

		/**
		 * This function is provided for demonstration purposes only.
		 *
		 * An instance of this class should be passed to the run() function
		 * defined in Qmaker_Loader as all of the hooks are defined
		 * in that particular class.
		 *
		 * The Qmaker_Loader will then create the relationship
		 * between the defined hooks and the functions defined in this
		 * class.
		 */

		wp_enqueue_style( $this->plugin_name, plugin_dir_url( __FILE__ ) . 'css/qmaker-admin.css', array(), $this->version, 'all' );

	}

	/**
	 * Register the JavaScript for the admin area.
	 *
	 * @since    1.0.0
	 */
	public function enqueue_scripts() {

		/**
		 * This function is provided for demonstration purposes only.
		 *
		 * An instance of this class should be passed to the run() function
		 * defined in Qmaker_Loader as all of the hooks are defined
		 * in that particular class.
		 *
		 * The Qmaker_Loader will then create the relationship
		 * between the defined hooks and the functions defined in this
		 * class.
		 */

		wp_enqueue_script( $this->plugin_name, plugin_dir_url( __FILE__ ) . 'js/qmaker-admin.js', array( 'jquery' ), $this->version, false );

	}


	/**
	 * Agrega el link a la página de configuración
	 * 
	 * @access   public
	 * @since    1.0.0
	 */
	public function add_action_links($links){
		$settings_link = array(
				'<a href="' . admin_url( 'options-general.php?page=' . $this->plugin_name ) . '">' . __('Settings', $this->plugin_name) . '</a>',
		);
		return array_merge( $settings_link, $links );
	}

	/**
	 * Agrega el Menu del plugin
	 * 
	 * @access   public
	 * @since    1.0.0
	 */
	public function qmaker_add_options_menu()
	{
		add_menu_page(
			'Quizz Maker', 
			'Quizz Maker', 
			'manage_options', 
			$this->plugin_name, 
			array($this, 'display_plugin_main_page'), 
			'', 
			41);

		add_submenu_page(
			$this->plugin_name, 
			'Página de Configuración', 
			'Configuración', 
			'manage_options',
			$this->plugin_name.'_settings', 
			array($this, 'display_plugin_setup_page'));
	}

	/**
	 * Renderea la página principal del plugin
	 * 
	 * @access   public
	 * @since    1.0.0
	 */
	public function display_plugin_main_page()
	{
		require_once  QM_PLUGIN_DIR_PATH . 'admin/partials/qmaker-main-display.php' ;
	}

	/**
	 * Renderea la página de configuración del plugin
	 * 
	 * @access   public
	 * @since    1.0.0
	 */
	public function display_plugin_setup_page(){
		require_once  QM_PLUGIN_DIR_PATH . 'admin/partials/qmaker-setting-display.php' ;
	}

}
