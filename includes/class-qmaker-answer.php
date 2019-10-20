<?php 
/**
 * Maneja todas las acciiones respect a las respuestas
 *
 * @link       https://habitatweb.mx/
 * @since      1.0.0
 *
 * @package    Qmaker
 * @subpackage Qmaker/includes
 */

/**
 * Administra las respuestas
 *
 * Maneja la alta, baja, cambios de las respuestas
 *
 * @package    Qmaker
 * @subpackage Qmaker/includes
 * @author     Emiliano
 */

class Qmaker_Answers {

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
    * Constructor de la clase que maneja las preguntas
    *
    *@since     1.0.0
    *@access    public
    *@author    Emiliano
    **/
    public function __construct (){
        global $wpdb;
        $this->db = $wpdb;
    }

    /**
    * Agrega una respuesta
    *
    * agrega a la bd una respuesta
    *
    *@since     1.0.0
    *@access    public
    *@author    Emiliano
    *@param     $answer         Array pregunta con sus respectivas respuestas
    *@param     $idQuestion     id id del question
    **/
    public function add_answer( $answer, $idQuestion, $answerNmbr){
        if($idQuestion > 0){
            $aname = $this->pods_unsanitize($answer['responseText']);
            $this->db->insert(
                QM_ANSWERS,
                array(
                    'numero_respuesta'      => $answerNmbr, 
                    'nombre_respuesta'      => $aname, 
                    'img_respuesta'         => '',
                    'es_correcta'           => $answer['isCorrect'],
                    'question_id'           => $idQuestion
                ),
                array( '%d', '%s', '%s', '%d', '%d' )
            );
            $answerId = $this->db->insert_id;
        }
    }

    /**
     * Filter input and return unsanitized output
     *
     * Fuente: https://github.com/pods-framework/pods/blob/edc9582/includes/data.php?ts=4#L220
     * 
     * @param mixed $input  The string, array, or object to unsanitize
     * @param array $params Additional options
     *
     * @return array|mixed|object|string|void
     *
     * @since 1.2.0
     */
    public function pods_unsanitize( $input, $params = array() ) {
        if ( '' === $input || is_int( $input ) || is_float( $input ) || empty( $input ) ) {
            return $input;
        }
        $output = array();
        if ( empty( $input ) ) {
            $output = $input;
        } elseif ( is_object( $input ) ) {
            $input = get_object_vars( $input );
            $n_params           = (array) $params;
            $n_params['nested'] = true;
            foreach ( $input as $key => $val ) {
                $output[ pods_unsanitize( $key ) ] = pods_unsanitize( $val, $n_params );
            }
            $output = (object) $output;
        } elseif ( is_array( $input ) ) {
            $n_params           = (array) $params;
            $n_params['nested'] = true;
            foreach ( $input as $key => $val ) {
                $output[ pods_unsanitize( $key ) ] = pods_unsanitize( $val, $n_params );
            }
        } else {
            $output = wp_unslash( $input );
        }//end if
        return $output;
    }

    /**
    * Regresa todas las respuestas de una pregunta
    *
    * Regresa todas las respuestas de una ´regunat en base al id
    *
    *@since     1.0.0
    *@access    public
    *@author Emiliano
    *@param     $idQuestion     id id del question
    **/
    public function get_answers_by_id_quesion ($idQuestion){
        if($idQuestion > 0){
            $results = $this->db->get_results( "SELECT * FROM ".QM_ANSWERS." WHERE question_id = {$idQuestion}" );
            return $results;
        }
        return false;
    }

    /**
    * Elimina las respuestas de una pregunta
    *
    * elimina todas las respuestas que pertencen a una pregunta en concreto
    *
    *@since     1.0.0
    *@access    public
    *@author Emiliano
    *@param     $idQuestion     id id del question
    **/
    public function delete_answers_by_id_question ($idQuestion){
        if($idQuestion > 0){
            $this->db->delete( QM_ANSWERS, array( 'question_id' => $idQuestion ), array( '%d' ) );
        }
    }
}