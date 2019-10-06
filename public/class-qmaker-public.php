<?php

/**
 * The public-facing functionality of the plugin.
 *
 * @link       https://habitatweb.mx/
 * @since      1.0.0
 *
 * @package    Qmaker
 * @subpackage Qmaker/public
 */

/**
 * The public-facing functionality of the plugin.
 *
 * Defines the plugin name, version, and two examples hooks for how to
 * enqueue the public-facing stylesheet and JavaScript.
 *
 * @package    Qmaker
 * @subpackage Qmaker/public
 * @author     Habitat Web <contacto@habitat.com>
 */
class Qmaker_Public {

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
	* maneja el objeto db
	*
	* @since    1.0.0
	* @access   protected
	* @var      wpdb   Maneja el objeto wpdb
	*/
    protected $db;

	/**
	 * Initialize the class and set its properties.
	 *
	 * @since    1.0.0
	 * @param      string    $plugin_name       The name of the plugin.
	 * @param      string    $version    The version of this plugin.
	 */
	public function __construct( $plugin_name, $version ) {
		$this->plugin_name = $plugin_name;
		$this->version = $version;

		global $wpdb;
        $this->db = $wpdb;
	}

	/**
	 * Register the stylesheets for the public-facing side of the site.
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

		 /**
		 * Regitra Bootstrap 4
		 */
		wp_enqueue_style( 'qm_bootstrap_css', 'https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css', array(), '4.3.1', 'all');

		wp_enqueue_style( $this->plugin_name, plugin_dir_url( __FILE__ ) . 'css/qmaker-public.css', array(), $this->version, 'all' );

	}

	/**
	 * Register the JavaScript for the public-facing side of the site.
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
		
		/**
		 * Registra bootstrap 4 js
		 */
		wp_enqueue_script( 'qm_bootstrap_popper_js', 'https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js', array( 'jquery' ), '1.14.7', true );
		wp_enqueue_script( 'qm_bootstrap_js', 'https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js', array( 'jquery' ), '4.3.1', true );


		wp_enqueue_script( $this->plugin_name, plugin_dir_url( __FILE__ ) . 'js/qmaker-public.js', array( 'jquery' ), $this->version, false );

	}


	public function register_shortcodes() {
		add_shortcode( 'quizmaker', array( $this, 'qmaker_shortcode_quiz_id') );
	}

	/**
	* Ejecuta el shoertcode
	*
	* esta función se encarga de mostrar los quizes del plugin
	*
	*@author Emiliano
	**/
	public function qmaker_shortcode_quiz_id($atts, $content = ''){
		$args = shortcode_atts(array(
				'id' => ''
			), $atts);

		ob_start();
		require_once  QM_PLUGIN_DIR_PATH . 'public/partials/qmaker-public-display.php' ;
		return ob_get_clean();
			// $sql = $this->db->prepare("SELECT * FROM ". QM_QUIZ ." WHERE id = %d", $id);
			// $quiz = $this->db->get_results($sql);

			// if($quiz[0]->id != ''){
			// 	$output = "<h3>hola {$quiz[0]->nombre_quiz}</h3>";
			// }else{
			// 	$output = "<h3>No hay información del quiz</h3>";
			// }
		// }

		// return $output;
	}

}
