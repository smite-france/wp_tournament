<?php
add_action('admin_menu', 'smfr_tournament_admin_menu');
add_action('admin_print_scripts', 'smfr_tournament_admin_scripts');
add_action('admin_print_styles', 'smfr_tournament_admin_styles');

function smfr_tournament_admin_menu() {
    add_menu_page('Gestion tournois' , 'Gestion tournois', 'smfr_tournament', 'smfr_tournament', 'smfr_tournament_admin_page');
}

function smfr_tournament_admin_scripts() {
    if (isset($_GET['page']) && $_GET['page'] == 'smfr_tournament')
    {
        wp_register_script(
            SMFR_TOURNAMENT_DB_PREFIX.'timepicker',
            SMFR_TOURNAMENT_URL.'admin/js/jquery.timepicker.min.js'
        );

        wp_register_script(
            SMFR_TOURNAMENT_DB_PREFIX.'datatable',
            SMFR_TOURNAMENT_URL.'admin/js/jquery.datatables.js'
        );

        wp_enqueue_script('jquery');
        wp_enqueue_script('jquery-ui-core');
        wp_enqueue_script('jquery-ui-datepicker');
        wp_enqueue_script(SMFR_TOURNAMENT_DB_PREFIX.'datatable');
        wp_enqueue_script(SMFR_TOURNAMENT_DB_PREFIX.'timepicker');

    }
}

function smfr_tournament_admin_styles() {
    if (isset($_GET['page']) && $_GET['page'] == 'smfr_tournament')
    {
        wp_register_style(
            SMFR_TOURNAMENT_DB_PREFIX.'style',
            SMFR_TOURNAMENT_URL.'admin/css/style.css'
        );

        wp_register_style(
            SMFR_TOURNAMENT_DB_PREFIX.'datatable',
            SMFR_TOURNAMENT_URL.'admin/css/jquery.datatables.css'
        );

        wp_register_style(
            SMFR_TOURNAMENT_DB_PREFIX.'datatable-theme',
            SMFR_TOURNAMENT_URL.'admin/css/jquery.datatables_themeroller.css'
        );

        wp_register_style(
            SMFR_TOURNAMENT_DB_PREFIX.'timepicker',
            SMFR_TOURNAMENT_URL.'admin/css/jquery.timepicker.min.css'
        );

        wp_register_style(
            SMFR_TOURNAMENT_DB_PREFIX.'jquery-style',
            SMFR_TOURNAMENT_URL.'admin/css/jquery-ui.css'
        );

        wp_enqueue_style(SMFR_TOURNAMENT_DB_PREFIX.'style');
        wp_enqueue_style(SMFR_TOURNAMENT_DB_PREFIX.'datatable');
        wp_enqueue_style(SMFR_TOURNAMENT_DB_PREFIX.'datatable-theme');
        wp_enqueue_style(SMFR_TOURNAMENT_DB_PREFIX.'timepicker');
        wp_enqueue_style(SMFR_TOURNAMENT_DB_PREFIX.'jquery-style');
    }
}

function smfr_tournament_admin_page() {
    /* INCLUDE ALL FUNCTIONS WE NEED ! */
    include('fnc/fnc_debug.php');
    include('fnc/fnc_tournament.php');
    include('fnc/fnc_team.php');
    include('fnc/fnc_player.php');
    include('fnc/fnc_gen_form.php');
    /* FIN */
    echo '<div class="wrap">';
    echo '<h1>Gestion des tournois</h1>';
    echo "<hr>";
    echo "<div class='dialog warning'>";
    echo "<span style='font-size:20px;'>Legende : </span>";
    echo "<span class='smfr_god_icon16 smfr_god_activate'></span> Actuellement en ligne  ";
    echo "<span class='smfr_god_icon16 smfr_god_deactivate'></span> Actuellement en hors ligne  ";
    echo "<span class='smfr_god_icon16 smfr_god_view'></span> Voir plus d'infos  ";
    echo "<span class='smfr_god_icon16 smfr_god_print'></span> Version imprimable  ";
    echo "<span class='smfr_god_icon16 smfr_god_update'></span> Mettre a jour  ";
    echo "<span class='smfr_god_icon16 smfr_god_delete'></span> Supprimer  ";
    echo "</div>";
    if(!isset($_GET['a']) || $_GET['a'] == ''){
        $_GET['a'] = 'aa';
    }
    switch($_GET['a']){
        case 'update' :
            include 'page/smfr_tournament_update.php';
            break;
        case 'add' :
            include 'page/smfr_tournament_update.php';
            break;
        case 'view' :
            include 'page/datatable_script.php';
            include 'page/smfr_tournament_team.php';
            break;
        case 'print' :
            include 'page/smfr_tournament_printer.php';
            break;
        case 'update_team' :
            include 'page/smfr_tournament_update_team.php';
            break;
        case 'update_team_player' :
            include 'page/smfr_tournament_update_team.php';
            break;
        default:
            include 'page/datatable_script.php';
            include 'page/smfr_tournament.php';
            break;
    }
    echo "<hr>";
    echo "Pour Smite France de la part de Tilican &copy; (modifié par FenixReborn par la suite) <!-- Serquet est-elle autorisée?? -->";
	echo "<br>";
	echo "<a target='_blank' href='".SMFR_TOURNAMENT_URL."changelog.txt'>CHANGELOGS</a>";
    echo "</div>";
}

/* AJAX  */
add_action( 'wp_ajax_smfr_tournament_status', 'smfr_tournament_status_callback' );
add_action( 'wp_ajax_smfr_tournament_team_status', 'smfr_tournament_team_status_callback' );

function smfr_tournament_status_callback() {
    global $wpdb; // this is how you get access to the database
    include include('fnc/fnc_tournament.php');
	if(is_array($_POST['id'])){
		foreach($_POST['id'] as $key => $data){
			status_tournament_spec($data,$_POST['status']);
		}

	}else{
		status_tournament_spec($_POST['id'],$_POST['status']);
	}

    wp_die(); // this is required to terminate immediately and return a proper response
}

function smfr_tournament_team_status_callback() {
    global $wpdb; // this is how you get access to the database
    include include('fnc/fnc_team.php');
	if(is_array($_POST['id'])){
		foreach($_POST['id'] as $key => $data){
			status_team_spec($data,$_POST['status']);
		}
	}else{
		status_team_spec($_POST['id'],$_POST['status']);
	}
    wp_die(); // this is required to terminate immediately and return a proper response
}
