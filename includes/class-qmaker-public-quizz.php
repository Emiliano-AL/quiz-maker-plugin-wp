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

class Qmaker_Public_Quizz {

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
    * Regresa todas las respuestas de una pregunta
    *
    * Regresa todas las respuestas de una ´regunat en base al id
    *
    *@since     1.0.0
    *@access    public
    *@author Emiliano
    *@param     $idQuestion     id id del question
    **/
    public function get_answers_by_id_quesion ($idQuestion, $randomOn = 0){
        if($idQuestion > 0){
            $query = "SELECT * FROM ".QM_ANSWERS." WHERE question_id = {$idQuestion}";
            if(intval($randomOn) == 1)
                $query .= " ORDER BY RAND()";

            $results = $this->db->get_results($query);
            return $results;
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
}