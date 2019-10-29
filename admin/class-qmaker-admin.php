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
	 * Objeto Quiz
	 *
	 * @since    1.0.0
	 * @access   private
	 * @var      Qmaker_Quiz    $qmaker_quiz    Maneja el objeto de los quizes.
	 */
	private $qmaker_quiz;


	/**
	 * Objeto Quiz
	 *
	 * @since    1.0.0
	 * @access   private
	 * @var      Qmaker_Question    $qmaker_quiz    Maneja el objeto de los quizes.
	 */
	private $qmaker_question;

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

		$this->qmaker_quiz = new Qmaker_Quiz();
		$this->qmaker_question = new Qmaker_Question();
	}

	/**
	 * Register the stylesheets for the admin area.
	 *
	 * @since    1.0.0
	 */
	public function enqueue_styles($hook) {
		
		/**
		 * Regitra Bootstrap 4
		 */
		wp_enqueue_style( 'qm_bootstrap_css', 'https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css', array(), '4.3.1', 'all');

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
		
		/**
		 * Estilos para el administrador de wordpress
		 */
		wp_enqueue_style( 'qm_styles_admin_wp', plugin_dir_url( __FILE__ ) . 'css/qmaker-wordpress.css', array(), $this->version, 'all' );

	}

	/**
	 * Register the JavaScript for the admin area.
	 *
	 * @since    1.0.0
	 */
	public function enqueue_scripts($hook) {

		/**
		 * Registra bootstrap 4 js
		 */
		wp_enqueue_script( 'qm_bootstrap_popper_js', 'https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js', array( 'jquery' ), '1.14.7', true );
		wp_enqueue_script( 'qm_bootstrap_js', 'https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js', array( 'jquery' ), '4.3.1', true );

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

		wp_enqueue_script( $this->plugin_name, plugin_dir_url( __FILE__ ) . 'js/qmaker-admin.js', array( 'jquery' ), $this->version, true );

		wp_localize_script( 
			$this->plugin_name, 
			'qmaker', 
			[
				'url' 		=> admin_url('admin-ajax.php'),
				'seguridad'	=> wp_create_nonce('qmaker_seg')
			]);
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
			'Quiz Maker', 
			'Quiz Maker', 
			'manage_options', 
			$this->plugin_name, 
			array($this, 'display_plugin_main_page'), 
			'dashicons-list-view', 
			9);
	}

	/**
	 * Renderea la página principal del plugin
	 * 
	 * @access   public
	 * @since    1.0.0
	 */
	public function display_plugin_main_page()
	{
		if($_GET['page'] == 'qmaker' && $_GET['action'] == 'edit' && isset($_GET['idQuiz'])){
			require_once  QM_PLUGIN_DIR_PATH . 'admin/partials/qmaker-questions-edit.php';
		}
		elseif($_GET['page'] == 'qmaker' && $_GET['action'] == 'addquestions' && isset($_GET['idQuiz'])){
			require_once  QM_PLUGIN_DIR_PATH . 'admin/partials/qmaker-questions-admin.php';
		}
		else 
		{
			require_once  QM_PLUGIN_DIR_PATH . 'admin/partials/qmaker-main-display.php' ;
		}
	}

	/**
	 * Se encarga de crear el Quiz en la BD
	 * 
	 * @access   public
	 * @since    1.0.0
	 */
	public function qmaker_ajax_create_quiz(){
		check_ajax_referer('qmaker_seg', 'nonce');
	
		if(current_user_can('manage_options')){
			extract($_POST, EXTR_OVERWRITE);
			if($tipo == 'add'){
				$quiz = [
					'name' => $name,
					'description' => $description,
				]; 
				$id = $this->qmaker_quiz->add_quiz($quiz);
				if($id > 0){
					$json = json_encode(array(
						'result' 	=> true,
						'insert_id' => $id
					));
				}else{
					$json = json_encode(array(
						'result' 	=> false,
						'insert_id' => $id
					));
				}
				echo $json;
				wp_die();
			}
		}
	}

	/**
	 * Maneja todas las acciones respecto a las preguntas, 
	 * agregar, y editar
	 * 
	 * @access   public
	 * @since    1.0.0
	 */
	public function qmaker_ajax_questions_manager(){
		check_ajax_referer('qmaker_seg', 'nonce');
		if(current_user_can('manage_options')){
			extract($_POST, EXTR_OVERWRITE);
			switch ($tipo) {
				case 'add':
					$ttl = $this->qmaker_question->total_questions_by_id_quiz($question['idQuiz']) + 1;
					$ttlQuestions = $this->qmaker_question->add_question($question, $question['idQuiz'], $ttl );
					$this->qmaker_quiz->update_total_questions($question['idQuiz'], $ttlQuestions);
					$response = $this->qmaker_manage_response($question['idQuiz']);
					break;
				case 'update':
					$id = $this->qmaker_quiz->manager_update_quiz($quiz);
					$response = $this->qmaker_manage_response($id);
					break;
				default:
					$response = $this->qmaker_manage_response(0);
			}

			echo $response;
			wp_die();
		}
	}


	/**
	 * Función auxiliar para generar una respuesta estandard
	 * 
	 * @access   public
	 * @since    1.0.0
	 */
	private function qmaker_manage_response($idReponse)
	{
		if($idReponse > 0){
			$json = json_encode(array(
				'result' 	=> true,
				'insert_id' => $idReponse
			));
		}else{
			$json = json_encode(array(
				'result' 	=> false,
				'insert_id' => $idReponse
			));
		}

		return $json;
	}
}
