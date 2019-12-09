<?php 
/**
 * Maneja todas las acciiones respect a las preguntas
 *
 * @link       https://habitatweb.mx/
 * @since      1.0.0
 *
 * @package    Qmaker
 * @subpackage Qmaker/includes
 */

/**
 * Administra las preguntas
 *
 * Maneja la alta, baja, cambios de las preguntas
 *
 * @package    Qmaker
 * @subpackage Qmaker/includes
 * @author     Emiliano
 */

class Qmaker_Question {

    /**
	 * maneja el objeto db
	 *
	 * @since    1.0.0
	 * @access   protected
	 * @var      wpdb   Maneja el objeto wpdb
	 */
    protected $db;
    
    /**
     * maneja el objeto answer
     *
     * @since    1.0.0
     * @access   protected
     * @var      Qmaker_Answers   Maneja el objeto answer
     */
    protected $qm_answeer;

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
        $this->qm_answeer = new Qmaker_Answers();
    }


    /**
    * Agrega una pregunta y sus respectivas respuestas
    *
    * agrega a la bd una pregunta y posteriomente invoca a las respuestas para agregarlas
    *
    *@since     1.0.0
    *@access    public
    *@author    Emiliano
    *@param     $question     Array pregunta con sus respectivas respuestas
    *@param     $idQuiz       id id del quiz
    **/
    public function add_question($question, $idQuiz, $questionNmbr){
        if($idQuiz > 0){
            $qname = $this->pods_unsanitize($question['questionName']);
            $this->db->insert(
                QM_QUESTION,
                array(
                    'numero_pregunta'   => $questionNmbr, 
                    'nombre_pregunta'   => $qname, 
                    'tipo_pregunta'     => 1,
                    'quiz_id'           => $idQuiz
                ),
                array( '%d', '%s', '%d', '%d' )
            );

            $questionId = $this->db->insert_id;
            $countResponses = 1;
            foreach ($question['response'] as $anws)
            {
                $this->qm_answeer->add_answer( $anws, $questionId, $countResponses );
                $countResponses++;
            }
            $ttl = $this->db->get_var( "SELECT COUNT(*) FROM ".QM_QUESTION." WHERE quiz_id = {$idQuiz}" );

            return $ttl;
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
    * cuanta el numero de preguntas de un quiz
    *
    * hace un conteo de las preguntsa que pertencen al quiz que recibe
    *
    *@author Emiliano
    *@param     $idQuiz       id id del quiz
    **/
    public function total_questions_by_id_quiz ($idQuiz){
        if($idQuiz > 0){
            $ttl = $this->db->get_var( "SELECT COUNT(*) FROM ".QM_QUESTION." WHERE quiz_id = {$idQuiz}" );
            return $ttl;
        }
        return false;
    }

    /**
    * Regresa el listado de preguntas en base a un id de quiz
    *
    * regresa un listado de las preguntas pertenecientes a un quiz
    *
    * @author Emiliano
    * @param     $idQuiz       id id del quiz
    * @return array
    **/
    public function get_questions_by_id_quiz ($idQuiz){
        if($idQuiz > 0){
            $results = $this->db->get_results( "SELECT * FROM ".QM_QUESTION." WHERE quiz_id = {$idQuiz}" );
            return $results;
        }
        return false;
    }

    /**
    * Elimina las preguntas relacionadas al idQuiz
    *
    * Elimina todas las preguntas que dependen del id Quiz
    *
    *@author Emiliano
    *@param     $idQuiz       id id del quiz
    **/
    public function delete_questions ($idQuiz){
        if($idQuiz > 0){
            $this->db->delete( QM_QUESTION, array( 'quiz_id' => $idQuiz ), array( '%d' ) );
        }
    }

    /**
    * Regresa el listado de preguntas en base a un id de quiz
    *
    * regresa un listado de las preguntas pertenecientes a un quiz
    *
    * @author Emiliano
    * @param     $idQuiz       id id del quiz
    * @return array
    **/
    public function get_ttl_questions ($idQuiz){
        if($idQuiz > 0){
            $ttl = $this->db->get_var( "SELECT MAX(numero_pregunta) as nmbrQuestion from ".QM_QUESTION." WHERE quiz_id = {$idQuiz}" );
            return $ttl;
        }
        return false;
    }
    
}