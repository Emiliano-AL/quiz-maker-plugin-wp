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
		$sql = "CREATE TABLE IF NOT EXISTS " . QM_QUIZ . "(
            id int(11) NOT NULL AUTO_INCREMENT,
            nombre varchar(50) NOT NULL,
            data longtext NOT NULL,
            PRIMARY KEY (id)
        );";
        
        $wpdb->query( $sql );
	}
}
