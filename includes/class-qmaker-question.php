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
    public function add_question($question, $idQuiz){
        if($idQuiz > 0){
            $this->db->insert(
                QM_QUESTION,
                array(
                    'nombre_pregunta'   => $question['questionName'], 
                    'tipo_pregunta'     => 1,
                    'quiz_id'           => $idQuiz
                ),
                array( '%s', '%d', '%d' )
            );
            $questionId = $this->db->insert_id;

            // $this->add_answer( "", "", $questionId );
            foreach ($question['response'] as $anws)
            {
                $this->qm_answeer->add_answer( $anws, $questionId );
            }

            return $questionId;
        }
    }

}