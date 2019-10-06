<?php

/**
 * Register all actions and filters for the plugin
 *
 * @link       https://habitatweb.mx/
 * @since      1.0.0
 *
 * @package    Qmaker
 * @subpackage Qmaker/includes
 */

/**
 * Register all actions and filters for the plugin.
 *
 * Maintain a list of all hooks that are registered throughout
 * the plugin, and register them with the WordPress API. Call the
 * run function to execute the list of actions and filters.
 *
 * @package    Qmaker
 * @subpackage Qmaker/includes
 * @author     Habitat Web <contacto@habitat.com>
 */
class Qmaker_Loader {

	/**
	 * The array of actions registered with WordPress.
	 *
	 * @since    1.0.0
	 * @access   protected
	 * @var      array    $actions    The actions registered with WordPress to fire when the plugin loads.
	 */
	protected $actions;

	/**
	 * The array of filters registered with WordPress.
	 *
	 * @since    1.0.0
	 * @access   protected
	 * @var      array    $filters    The filters registered with WordPress to fire when the plugin loads.
	 */
	protected $filters;
	
	/**
	 * The array of shorcodes registrados en wordpress.
	 *
	 * @since    1.0.0
	 * @access   protected
	 * @var      array    $filters    The filters of shorcodes registrados en wordpress para ejecutar cuando se carga el plugin.
	 */
	protected $shortcodes;

	/**
	 * Initialize the collections used to maintain the actions and filters.
	 *
	 * @since    1.0.0
	 */
	public function __construct() {

		$this->actions = array();
		$this->filters = array();
		$this->shortcodes = array();

	}

	/**
	 * Add a new action to the collection to be registered with WordPress.
	 *
	 * @since    1.0.0
	 * @param    string               $hook             The name of the WordPress action that is being registered.
	 * @param    object               $component        A reference to the instance of the object on which the action is defined.
	 * @param    string               $callback         The name of the function definition on the $component.
	 * @param    int                  $priority         Optional. The priority at which the function should be fired. Default is 10.
	 * @param    int                  $accepted_args    Optional. The number of arguments that should be passed to the $callback. Default is 1.
	 */
	public function add_action( $hook, $component, $callback, $priority = 10, $accepted_args = 1 ) {
		$this->actions = $this->add( $this->actions, $hook, $component, $callback, $priority, $accepted_args );
	}

	/**
	 * Add a new filter to the collection to be registered with WordPress.
	 *
	 * @since    1.0.0
	 * @param    string               $hook             The name of the WordPress filter that is being registered.
	 * @param    object               $component        A reference to the instance of the object on which the filter is defined.
	 * @param    string               $callback         The name of the function definition on the $component.
	 * @param    int                  $priority         Optional. The priority at which the function should be fired. Default is 10.
	 * @param    int                  $accepted_args    Optional. The number of arguments that should be passed to the $callback. Default is 1
	 */
	public function add_filter( $hook, $component, $callback, $priority = 10, $accepted_args = 1 ) {
		$this->filters = $this->add( $this->filters, $hook, $component, $callback, $priority, $accepted_args );
	}

	/**
	 * A utility function that is used to register the actions and hooks into a single
	 * collection.
	 *
	 * @since    1.0.0
	 * @access   private
	 * @param    array                $hooks            The collection of hooks that is being registered (that is, actions or filters).
	 * @param    string               $hook             The name of the WordPress filter that is being registered.
	 * @param    object               $component        A reference to the instance of the object on which the filter is defined.
	 * @param    string               $callback         The name of the function definition on the $component.
	 * @param    int                  $priority         The priority at which the function should be fired.
	 * @param    int                  $accepted_args    The number of arguments that should be passed to the $callback.
	 * @return   array                                  The collection of actions and filters registered with WordPress.
	 */
	private function add( $hooks, $hook, $component, $callback, $priority, $accepted_args ) {

		$hooks[] = array(
			'hook'          => $hook,
			'component'     => $component,
			'callback'      => $callback,
			'priority'      => $priority,
			'accepted_args' => $accepted_args
		);

		return $hooks;

	}

	/**
	 * Agrega un shortcode nual al array ($this->shortcodes) a iterar para agregarlos a wordpress
	 *
	 * @since    1.0.0
	 * @access		public
	 * 
	 * @param    string               $tag             El nombre del Shortcode de Wordpress que se esta registrando
	 * @param    object               $component        Una referencia a la instancia del objeto en el que se define el Shortcode
	 * @param    string               $callback         El nombre de la definición del metodo/funcion en el $component
	 */
	// public function add_shortcode($tag, $component, $callback) {
	// 	$this->shortcodes = $this->add_s( $this->shortcodes, $tag, $component, $callback );
	// }

	/**
	 * Función de utilidad que se utiliza para registrar los shortcodes en una sola iterada
	 *
	 * @since    1.0.0
	 * @access   private
	 * 
	 * @param    array                $shortcodes		La colección de Shortcodes que se está registrando.
	 * @param    string               $tag				El nombre del Shortcode de wordpress que se está registrando .
	 * @param    object               $component        Una referencia a la instancia del objeto en el que se define el shortcode 
	 * @param    string               $callback         El nombre de la definición del método / función en el $component
	 * 
	 * @return   array                                  La colección del shortcodes en wordpress para proceder a iterar
	 */
	// private function add_s( $shortcodes, $tag, $component ) {
	// 	$shortcodes[] = array(
	// 		'tag'          	=> $tag,
	// 		'component'     => $component,
	// 		'callback'      => $callback
	// 	);

	// 	return $shortcodes;
	// }

	/**
	 * Register the filters and actions with WordPress.
	 *
	 * @since    1.0.0
	 */
	public function run() {

		foreach ( $this->filters as $hook ) {
			add_filter( $hook['hook'], array( $hook['component'], $hook['callback'] ), $hook['priority'], $hook['accepted_args'] );
		}

		foreach ( $this->actions as $hook ) {
			add_action( $hook['hook'], array( $hook['component'], $hook['callback'] ), $hook['priority'], $hook['accepted_args'] );
		}
		
		// foreach ( $this->shortcodes as $shortcode ) {
		// 	add_shortcode($shortcode['tag'], array( $shortcode['component'], $shortcode['callback'] ));
		// }

	}

}
