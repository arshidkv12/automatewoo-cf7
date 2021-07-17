<?php 
/**
 * Plugin Name: AutoWoo CF7
 */


add_filter( 'automatewoo/triggers', 'cfdb7_triggers' );

/**
 * @param array $triggers
 * @return array
 */
function cfdb7_triggers( $triggers ) {

	include_once 'class-cfdb7-trigger.php';

	// set a unique name for the trigger and then the class name
	$triggers['cfdb7_trigger'] = 'CFDB7_Trigger';

	return $triggers;
}
