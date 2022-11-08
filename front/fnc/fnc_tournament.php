<?php

function get_tournament_spec($id , $name ) {
    global $wpdb;
    $sql = "";
    $a_results = array() ;
    if(is_array($name)){
        $sql = "SELECT ";
        foreach($name as $key => $value){
            $sql .= " ".$value." ,";
        }
        $sql = substr($sql,0,-1);
        $sql .= " FROM ".SMFR_TOURNAMENT_DB_PREFIX."tournament ";
    }else {
        $sql = "SELECT ".$name." FROM ".SMFR_TOURNAMENT_DB_PREFIX."tournament ";
    }
    $sql .= "WHERE status = 2  ";
    if($id != 0 ){
        $sql .= "AND id = ".$id;
    }

//    pr($sql);

    $a_results = $wpdb->get_results($sql, ARRAY_A);
    return $a_results;
}

function set_tournament_spec($id , $name , $value) {
    global $wpdb;
    $bool = false;
    $array = array();
    if($id != 0) {
        if (is_array($name) && is_array($value)) {
            // build temp array !
            for ($i = 0; $i < count($name); $i++) {
                $array[$name[$i]] = $value[$i];
            }
        } else {
            $array = array(
                $name => $value,
            );
        }
        $bool = $wpdb->update(
            SMFR_TOURNAMENT_DB_PREFIX.'tournament',
            $array,
            array('id' => $id)
        );
    }
    return $bool;
}

function add_tournament_spec($name , $value){
    global $wpdb;
    if (is_array($name) && is_array($value)) {
        // build temp array !
        for ($i = 0; $i < count($name); $i++) {
            $array[$name[$i]] = $value[$i];
        }
    } else {
        $array = array(
            $name => $value,
        );
    }
    $array['created_at'] = current_time('mysql', false);
     $wpdb->insert(
         SMFR_TOURNAMENT_DB_PREFIX.'tournament',
        $array,
        array()
    );
    return $wpdb->insert_id;
}

function status_tournament_spec($id,$status){
    global $wpdb;
    $bool = false;
    if($id > 0){
        $bool = $wpdb->update(
            SMFR_TOURNAMENT_DB_PREFIX.'tournament',
            array('status' => $status),
            array('id' => $id)
        );
    }
    return $bool;
}