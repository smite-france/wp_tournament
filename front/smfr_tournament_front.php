<?php

//smfr_god_shortcode
add_shortcode('smfr_tournament','smfr_tournament_shortcode');


function smfr_tournament_front_scripts() {

    wp_register_script(
        SMFR_TOURNAMENT_DB_PREFIX.'idTabs',
        SMFR_TOURNAMENT_URL.'front/js/jquery.idTabs.min.js'
    );

//    wp_register_script(
//        SMFR_TOURNAMENT_DB_PREFIX.'datatable',
//        SMFR_TOURNAMENT_URL.'front/js/jquery.dataTables.min.js'
//    );

//    wp_register_script(
//        SMFR_TOURNAMENT_DB_PREFIX.'datatable-ui',
//        SMFR_TOURNAMENT_URL.'front/js/dataTables.ui.js'
//    );


    wp_enqueue_script('jquery');                    // Enque jQuery
    wp_enqueue_script(SMFR_TOURNAMENT_DB_PREFIX.'idTabs');
//    wp_enqueue_script(SMFR_TOURNAMENT_DB_PREFIX.'datatable');
//    wp_enqueue_script(SMFR_TOURNAMENT_DB_PREFIX.'datatable-ui');


}

function smfr_tournament_front_styles() {

    wp_register_style(
        SMFR_TOURNAMENT_DB_PREFIX.'style',
        SMFR_TOURNAMENT_URL.'front/css/style.css'
    );

//    wp_register_style(
//        SMFR_TOURNAMENT_DB_PREFIX.'datatable',
//        SMFR_TOURNAMENT_URL.'front/css/jquery.dataTables.min.css'
//    );
//
//    wp_register_style(
//        SMFR_TOURNAMENT_DB_PREFIX.'datatable-ui',
//        SMFR_TOURNAMENT_URL.'front/css/dataTables.ui.css'
//    );


    wp_enqueue_style(SMFR_TOURNAMENT_DB_PREFIX.'style');
//    wp_enqueue_style(SMFR_TOURNAMENT_DB_PREFIX.'datatable');
//    wp_enqueue_style(SMFR_TOURNAMENT_DB_PREFIX.'datatable-ui');


}


function smfr_tournament_shortcode(){
    smfr_tournament_front_styles();
    smfr_tournament_front_scripts();

    /* INCLUDE ALL FUNCTIONS WE NEED ! */
    include('fnc/fnc_debug.php');
    include('fnc/fnc_tournament.php');
    include('fnc/fnc_team.php');
    include('fnc/fnc_player.php');
    include('fnc/fnc_gen_form.php');
    /* CLASSES ! */
    include('class/gump.class.php');
    /* FIN */
    echo "<div class='smfr_god'>";
    // si on a un id dieu selectionné !
    if(isset($_GET['id']) && $_GET['id'] > 0){
        include 'page/smfr_tournament_front_register.php';
    }
    else {
//        include 'page/datatable_script.php';
        include 'page/smfr_tournament_front_list.php';
    }
    echo "</div>";
}