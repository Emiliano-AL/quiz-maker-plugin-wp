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
    * Eliminar un quiz 
    *
    * Elimina por completo el quiz, sus preguntas y respuestas 
    *
    *@since     1.0.0
    *@access    public
    *@author    Emiliano
    *@param     $id     id del quiz a eliminar
    **/
    public function delete_quiz ($id){
        $this->db->delete(
            QM_QUIZ, [ 'ID' => $id ],  [ '%d' ]
        );

        //TODO: eliminar también preguntas y respuestas del quiz
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
    *@author    Emiliano
    **/
    public function column_name($item){
        //nonce
        $delete_nonce = wp_create_nonce('qmaker_delete_quiz');
        $title = '<strong>' . $item['name']. '</strong>';
        $actions = array(
            'delete' => sprintf('<a href="?page=%s&action=%s&quiz=%s&_wpnonce=%s">Eliminar</a>', esc_attr( $_REQUEST['page'] ), 'delete', absint( $item['idQuiz'] ), $delete_nonce )
        );

        return $title . $this->row_actions($actions);
    }

    /**
     * Renderea una columna cuando la columna especifica no existe
     *
     * @access    public
     * @author    Emiliano
     * @param array $item
     * @param string $column_name
     *
     * @return mixed
     */
    public function column_default( $item, $column_name ) {
        switch ( $column_name ) {
            // case 'nombre_quiz':
            case 'descripcion':
            case 'preguntas_total':
                return $item[ $column_name ];
       
            default:
                return print_r( $item, true ); //Show the whole array for troubleshooting purposes
        }
    }

    /**
    * Personaliza el cumna de nombre
    *
    * personaliza la columna del nombre del quiz, para que se pueda actualizar 
    * el cuestionario
    *
    * @access    public
    * @author Emiliano
    * @param array $item
    **/
    public function column_nombre_quiz($item){
        $actions = array(
            'edit'      => sprintf('<a href="?page=%s&action=%s&idQuiz=%s">Editar</a>',$_REQUEST['page'],'edit',$item['id'] ),
            'delete'    => sprintf('<a href="?page=%s&action=%s&idQuiz=%s">Papelera</a>',$_REQUEST['page'],'delete',$item['id'] ),
        );
        return sprintf('%1$s %2$s', $item['nombre_quiz'], $this->row_actions( $actions ) );
    }

    /**
     * Render the bulk edit checkbox
     * @access    public
     * @author    Emiliano
     * @param array $item
     *
     * @return string
     */
    public function column_cb( $item ) {
        return sprintf(
            '<input type="checkbox" name="bulk-delete[]" value="%s" />', $item['id']
        );
    }

    /**
     *  Associative array of columns
     *
     * @return array
     */
    public function get_columns() {
        $columns = [
            'cb'            => '<input type="checkbox" />',
            'nombre_quiz'      => __( 'Nombre del quiz', 'qmaker' ),
            'descripcion'   => __( 'Descripción', 'qmaker' ),
            'preguntas_total' => __( 'Total de preguntas', 'qmaker' )
        ];
    
        return $columns;
    }

    /**
     * Columns to make sortable.
     *
     * @return array
     */
    public function get_sortable_columns() {
        $sortable_columns = array(
            'nombre_quiz' => array( 'name', true ),
            'descripcion' => array( 'description', false )
        );
    
        return $sortable_columns;
    }

    /**
     * Returns an associative array containing the bulk action
     *
     * @return array
     */
    public function get_bulk_actions() {
        $actions = [
            'bulk-delete' => 'Eliminar'
        ];
    
        return $actions;
    }

    /**
     * Handles data query and filter, sorting, and pagination.
     */
    public function prepare_items() {

        $this->_column_headers = $this->get_column_info();
    
        /** Process bulk action */
        $this->process_bulk_action();
    
        $per_page     = $this->get_items_per_page( 'customers_per_page', 10 );
        $current_page = $this->get_pagenum();
        $total_items  = self::record_count();
    
        $this->set_pagination_args( [
            'total_items' => $total_items, //WE have to calculate the total number of items
            'per_page'    => $per_page //WE have to determine how many items to show on a page
        ] );
    
    
        $this->items = self::get_quizes( $per_page, $current_page );
    }

    /**
    * Agrega un Quiz
    *
    * Se encarga de agrear un Quiz en la bd
    *
    *@since     1.0.0
    *@access    public
    *@author    Emiliano
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

    /**
    * Regresa el listado de quizes en la BD
    *
    * Regresa el listado quizes para mostralo en el WP_LIST
    *
    *@since     1.0.0
    *@access    public
    *@author    Emiliano
    *@param     $per_page       int     mostarr por pagina
    *@param     $page_nmbr      int     numero de página
    **/
    public function get_quizes ($per_page = 10, $page_nmbr = 1){
        $sql = "SELECT * FROM " . QM_QUIZ;
        if ( ! empty( $_REQUEST['orderby'] ) ) {
            $sql .= ' ORDER BY ' . esc_sql( $_REQUEST['orderby'] );
            $sql .= ! empty( $_REQUEST['order'] ) ? ' ' . esc_sql( $_REQUEST['order'] ) : ' ASC';
        }
        $sql .= " LIMIT $per_page";
        $sql .= ' OFFSET ' . ( $page_nmbr - 1 ) * $per_page;

        $result = $this->db->get_results( $sql, 'ARRAY_A' );
        return $result;
    }

      /**
      * Actualiza el total de preguntas de cada quiz
      *
      * Se ancarga de llevar actualizado el total de preguntas de cada quiz
      *
      *@since     1.0.0
      *@access    public
      *@author    Emiliano
      *@param     $idQuiz           int     id del quiz a actualizar
      *@param     $ttlQuestions     int     totl de preguntas del quiz
      **/
      public function update_total_questions ($idQuiz, $ttlQuestions){
          if($idQuiz > 0){
            $this->db->update( 
                QM_QUIZ, 
                array( 'preguntas_total' => $ttlQuestions ), 
                array( 'id' => $idQuiz ), 
                array( '%d' ), array( '%d' ) 
            );
          }
      }
}