<?php
/*
Plugin Name: Smite france tournament
Plugin URI:
Description:
Version: 0.3
Author: Tilican
Modification author: FenixReborn

Copyright 2015 Tilican
Copyright 2016 FenixReborn

*/

define( 'SMFR_TOURNAMENT_URL', plugin_dir_url ( __FILE__ ) );
define( 'SMFR_TOURNAMENT_URI', plugin_dir_path( __FILE__ ) );
define( 'SMFR_TOURNAMENT_VERSION', '0.2' );
define( 'SMFR_TOURNAMENT_NAME', 'Smite France gestionnaire de tournoi' );
define( 'SMFR_TOURNAMENT_DB_PREFIX' , "smfr_tournament_");



smfr_tournament_load();

// CREATE HOOK !
register_activation_hook(__FILE__, 'smfr_tournament_activation');
register_deactivation_hook(__FILE__, 'smfr_tournament_deactivation');

function smfr_tournament_load(){
	
	// Ajouter un rôle
	add_role('organisator', 'Organisateur', array(
		'read' => true, // true : aurtorise la lecture des page et article 
		'edit_posts' => false, // false : Interdit d'ajouter des articles ou des pages 
		'delete_posts' => false, // false : Interdit de supprimer des articles ou des pages
	));
	$role = get_role('organisator');
	$role->add_cap('smfr_tournament');
	
	$role = get_role('administrator');
	$role->add_cap('smfr_tournament');
	
	if (is_admin()) {
		// add admin script
		include_once(SMFR_TOURNAMENT_URI.'admin/smfr_tournament_admin.php');
	} else {
		//add front script !
		include_once(SMFR_TOURNAMENT_URI.'front/smfr_tournament_front.php');
	}
	
	// include functions activation / deactivation
	include_once(SMFR_TOURNAMENT_URI.'install/activation.php');
	include_once(SMFR_TOURNAMENT_URI.'install/deactivation.php');
}

?>