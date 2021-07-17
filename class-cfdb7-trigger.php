<?php

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Prevent direct access
}

/**
 * This is an example trigger that is triggered via a WordPress action and includes a user data item.
 * Trigger with: do_action('my_custom_action', $user_id );
 */
class CFDB7_Trigger extends AutomateWoo\Trigger {

	/**
	 * Define which data items are set by this trigger, this determines which rules and actions will be available
	 *
	 * @var array
	 */
	public $supplied_data_items = array( 'cfdb7' );

	/**
	 * Set up the trigger
	 */
	public function init() {
		$this->title = __( 'CF7 Trigger', 'automatewoo-cfdb7' );
		$this->group = __( 'CF7 Triggers', 'automatewoo-cfdb7' );
	}

	/**
	 * Add any fields to the trigger (optional)
	 */
	public function load_fields() {

	}

	/**
	 * Defines when the trigger is run
	 */
	public function register_hooks() {
		add_action( 'cfdb7_before_save', array( $this, 'catch_hooks' ) );
	}

	/**
	 * Catches the action and calls the maybe_run() method.
	 *
	 * @param $user_id
	 */
	public function catch_hooks( $cfdb7 ) {

		$form = WPCF7_ContactForm::get_current();
		$form->id();
		add_filter('automatewoo_text_variable_value', 
			function( $bool, $data_type, $data_field ) use( $cfdb7 ){
				if( $data_type === 'cfdb7' && $data_field === 'item_url' ){
					return implode( $cfdb7 );
				}
				if( $data_type === 'cfdb7' && $data_field === 'email' ){
					return 'dfdf@eer.com';
				}
				return $bool;
			}, 10, 3
		);

		// get/create customer object from the user id
		$customer = AutomateWoo\Customer_Factory::get_by_user_id( 1 );
			
		$this->maybe_run( array(
			'cfdb7' => array('item_url' => '-', 'email' => '-'),
		));
	}

	/**
	 * Performs any validation if required. If this method returns true the trigger will fire.
	 *
	 * @param $workflow AutomateWoo\Workflow
	 * @return bool
	 */
	public function validate_workflow( $workflow ) {

		// Get objects from the data layer
		$customer = $workflow->data_layer()->get_customer();

		// do something...

		return true;
	}

}
