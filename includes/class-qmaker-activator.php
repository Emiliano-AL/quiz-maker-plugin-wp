<?php

/**
 * Fired during plugin activation
 *
 * @link       https://habitatweb.mx/
 * @since      1.0.0
 *
 * @package    Qmaker
 * @subpackage Qmaker/includes
 */

/**
 * Fired during plugin activation.
 *
 * This class defines all code necessary to run during the plugin's activation.
 *
 * @since      1.0.0
 * @package    Qmaker
 * @subpackage Qmaker/includes
 * @author     Habitat Web <contacto@habitat.com>
 */
class Qmaker_Activator {

	/**
	 * Short Description. (use period)
	 *
	 * Long Description.
	 *
	 * @since    1.0.0
	 */
	public static function activate() {
		self::qmaker_create_tables();
	}

	/**
	* Crea las tablas para el plugin
	*
	* Crea las tablas de Quizes, preguntas y respuestas
	*
	*@author 	Emilino
	*@since		1.0.0
	*@access 	private
	**/
	private static function qmaker_create_tables (){
		global $wpdb;
		$slqAnswers = "CREATE TABLE IF NOT EXISTS " . QM_ANSWERS . "(
			id int(11) NOT NULL AUTO_INCREMENT,
			numero_respuesta int(11) NOT NULL,
			nombre_respuesta text COLLATE utf8mb4_unicode_ci NOT NULL,
			img_respuesta varchar(60) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
			es_correcta smallint(6) NOT NULL COMMENT '1=correcto, 0=incorrecto',
			question_id int(11) NOT NULL,
			PRIMARY KEY (id)
			)ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;";
		$wpdb->query( $slqAnswers );

		$slqQuestion = "CREATE TABLE IF NOT EXISTS " . QM_QUESTION . "(
			id int(11) NOT NULL AUTO_INCREMENT,
			numero_pregunta int(11) NOT NULL,
			nombre_pregunta text COLLATE utf8mb4_unicode_ci NOT NULL,
			tipo_pregunta int(11) NOT NULL,
			quiz_id int(11) NOT NULL,
			PRIMARY KEY (id)
			)ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;";
		$wpdb->query( $slqQuestion );

		$sqlQuiz = "CREATE TABLE IF NOT EXISTS " . QM_QUIZ . "(
			id int(11) NOT NULL AUTO_INCREMENT,
  			nombre_quiz varchar(40) COLLATE utf8mb4_unicode_ci NOT NULL,
			descripcion varchar(60) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
			preguntas_total int(11) NOT NULL DEFAULT 0,
			PRIMARY KEY (id)
		)ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;";
		$wpdb->query( $sqlQuiz );
        
       
	}
}
