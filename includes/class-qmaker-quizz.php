<?php 
/**
 * Maneja todas las acciiones respecto a los quizes 
 *
 * @link       https://habitatweb.mx/
 * @since      1.0.0
 *
 * @package    Qmaker
 * @subpackage Qmaker/includes
 */

/**
 * Administra los quizes 
 *
 * Maneja la alta, baja, cambios de los quizes
 * extinde la clase WP_List_Table para renderear el 
 * listado de quizes
 *
 * @package    Qmaker
 * @subpackage Qmaker/includes
 * @author     Emiliano
 */

class Qmaker_Quiz extends WP_List_Table {

    /**
	 * maneja el objeto db
	 *
	 * @since    1.0.0
	 * @access   protected
	 * @var      wpdb   Maneja el objeto wpdb
	 */
	protected $db;

    /**
    * Constructor de la clase
    *
    * Constructor de la clase que maneja los Quizes
    *
    *@since     1.0.0
    *@access    public
    *@author    Emiliano
    **/
    public function __construct (){
        parent::__construct( [
			'singular' => __( 'Quiz', 'qmaker' ), //singular name of the listed records
			'plural'   => __( 'Quizes', 'qmaker' ), //plural name of the listed records
			'ajax'     => false 
        ] );

        global $wpdb;
        $this->db = $wpdb;
    }

    /**
    * regtesa los quizes desde la bd
    *
    * regresa todos los quizes almacenados en la BD
    *
    *@since     1.0.0
    *@access    public
    *@author    Emiliano
    **/
    public function get_quizes ($per_page = 10, $page_nmbr = 1){
        
    }

    /**
    * Eliminar un quiz 
    *
    * Elimina por completo el quiz, sus preguntas y respuestas 
    *
    *@since     1.0.0
    *@access    public
    *@author    Emiliano
    **/
    public function delete_quiz ($id){
        
    }

    /**
    * regresa el total de quiszes
    *
    *
    *@since     1.0.0
    *@access    public
    *@author    Emiliano
    **/
    public function record_count() {

        $sql = "SELECT COUNT(*) FROM ".QM_QUIZ;
        return  $this->db->get_var( $sql );
    }

    /**
    * Sobreescribo la función de no_items
    *
    *
    *@since     1.0.0
    *@access    public
    *@author    Emiliano
    **/
    public function no_items() {
        _e( 'No hay Quizes', 'qmaker' );
    }

    /**
    * Descripción rápida
    *
    * Descrición completa
    *
    *@since     1.0.0
    *@access    public
    *@author Emiliano
    **/
    public function column_name($item){
        //nonce
        $delete_nonce = wp_create_nonce('qmaker_delete_quiz');
        $title = '<strong>' . $item['name']. '</strong>';
        $actions = array(
            'delete' => sprintf('<a href="?page=%s&action=%s&customer=%s&_wpnonce=%s">Eliminar</a>', esc_attr( $_REQUEST['page'] ), 'delete', absint( $item['ID'] ), $delete_nonce )
        );

        return $title . $this->row_actions($actions);
    }


    /**
    * Agrega un Quiz
    *
    * Se encarga de agrear un Quiz en la bd
    *
    *@since     1.0.0
    *@access    public
    *@author Emiliano
    **/
    public function add_quiz($quiz){
        $this->db->insert(
            QM_QUIZ,
            array(
                'nombre_quiz' => $quiz['name'], 
                'descripcion' => $quiz['description'] 
            ),
            array( '%s', '%s' )
        );

        return $this->db->insert_id;
    }

    /**
    * Regresa un Quiz
    *
    * Se encarga de regresar el detalle del quiz,
    *
    *@since     1.0.0
    *@access    public
    *@author    Emiliano
    *@param     $quizId     id del quiz
    **/
    public function get_quiz($quizId)
    {
        if($quizId > 0){
            $quiz = $this->db->get_row( "SELECT * FROM ".QM_QUIZ." WHERE id = {$quizId}" );
            return $quiz;
        }
        return false;
    }

    /**
    * Regresa El detalle de un quiz
    *
    * Se encarga de regresar el detalle del quiz,
    *
    *@since     1.0.0
    *@access    public
    *@author    Emiliano
    *@param     $quizId     id del quiz
    **/
    public function get_quiz_detail($quizId)
    {
        if($quizId > 0){
            $quiz = $this->db->get_results( "SELECT * FROM ".QM_QUESTION." WHERE quiz_id = {$quizId}" );
            return $quiz;
        }
        return false;
    }

    public function prepare_items() {

        // $this->_column_headers = $this->get_column_info();
      
        // /** Process bulk action */
        // $this->process_bulk_action();
      
        // $per_page     = $this->get_items_per_page( 'customers_per_page', 5 );
        // $current_page = $this->get_pagenum();
        // $total_items  = self::record_count();
      
        // $this->set_pagination_args( [
        //   'total_items' => $total_items, //WE have to calculate the total number of items
        //   'per_page'    => $per_page //WE have to determine how many items to show on a page
        // ] );
      
      
        // $this->items = self::get_customers( $per_page, $current_page );
      }
}