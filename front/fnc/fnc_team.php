<?php

function get_team_spec($id , $name , $whereid = array() ) {
    global $wpdb;
    $sql = "";
    $a_results = array() ;
    if(is_array($name)){
        $sql = "SELECT ";
        foreach($name as $key => $value){
            $sql .= " ".$value." ,";
        }
        $sql = substr($sql,0,-1);
        $sql .= " FROM ".SMFR_TOURNAMENT_DB_PREFIX."team ";
    }else {
        $sql = "SELECT ".$name." FROM ".SMFR_TOURNAMENT_DB_PREFIX."team ";
    }
    $sql.= 'WHERE ';

    if(!isset($whereid['status'])){
        $sql .= " status >= 1 AND ";
    }

    if(isset($whereid) && !empty($whereid)){
        $i = 0;
        foreach ($whereid as $column => $value ){
            if($i != 0){
                $sql .= " AND ";
            }
            $sql .= $column." = ".$value;
            $i++;
        }
    }

    if($id != 0 ){
        $sql .= " id = ".$id;
    }



//    pr($sql);

    $a_results = $wpdb->get_results($sql, ARRAY_A);
    return $a_results;
}

function set_team_spec($id , $name , $value) {
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
            SMFR_TOURNAMENT_DB_PREFIX.'team',
            $array,
            array('id' => $id)
        );
    }
    return $bool;
}

function add_team_spec($name , $value){
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
        SMFR_TOURNAMENT_DB_PREFIX.'team',
        $array,
        array()
    );
    return $wpdb->insert_id;
}

function status_team_spec($id,$status){
    global $wpdb;
    $bool = false;
    if($id > 0){
        $bool = $wpdb->update(
            SMFR_TOURNAMENT_DB_PREFIX.'team',
            array('status' => $status),
            array('id' => $id)
        );
    }
    return $bool;
}