<?php

function get_player_spec($id , $name , $whereid = array() ) {
    global $wpdb;
    $sql = "";
    $a_results = array() ;
    if(is_array($name)){
        $sql = "SELECT ";
        foreach($name as $key => $value){
            $sql .= " ".$value." ,";
        }
        $sql = substr($sql,0,-1);
        $sql .= " FROM ".SMFR_TOURNAMENT_DB_PREFIX."player ";
    }else {
        $sql = "SELECT ".$name." FROM ".SMFR_TOURNAMENT_DB_PREFIX."player ";
    }
    $sql .= "WHERE status >= 1 ";
    if($id != 0 ){
        $sql .= "AND id = ".$id;
    }

    if(isset($whereid) && !empty($whereid)){
        foreach ($whereid as $column => $value ){
            $sql .= "AND ".$column." = ".$value;
        }
    }

//    pr($sql);

    $a_results = $wpdb->get_results($sql, ARRAY_A);
    return $a_results;
}

function set_player_spec($id , $name , $value) {
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
            SMFR_TOURNAMENT_DB_PREFIX.'player',
            $array,
            array('id' => $id)
        );
    }
    return $bool;
}

function add_player_spec($name , $value){
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
        SMFR_TOURNAMENT_DB_PREFIX.'player',
        $array,
        array()
    );
    return $wpdb->insert_id;
}

function status_player_spec($id,$status){
    global $wpdb;
    $bool = false;
    if($id > 0){
        $bool = $wpdb->update(
            SMFR_TOURNAMENT_DB_PREFIX.'player',
            array('status' => $status),
            array('id' => $id)
        );
    }
    return $bool;
}