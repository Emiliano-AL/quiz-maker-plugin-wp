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
    public function add_answer( $answer, $idQuestion){
        if($idQuestion > 0){
            $isValid = $answer['isCorrect'] == true ? 1 : 0;
            $this->db->insert(
                QM_ANSWERS,
                array(
                    'nombre_respuesta'      => $answer['responseText'], 
                    'img_respuesta'         => '',
                    'es_correcta'           => $isValid,
                    'question_id'           => $idQuestion
                ),
                array( '%s', '%s', '%d', '%d' )
            );
            $answerId = $this->db->insert_id;
        }
    }
}