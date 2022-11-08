<?php
class Smfr_List_Table extends WP_List_Table {

	protected $data = array();
	protected $columns = array();
	protected $sortable_columns = array();
	protected $actions = array();
	protected $actions_menu = array();

	function __construct($config){
		global $status, $page;
		//Set parent defaults
		parent::__construct( array(
			'singular'  => $config['singular'],     //singular name of the listed records
			'plural'    => $config['plural'],    //plural name of the listed records
			'ajax'      => false        //does this table support ajax?
		) );

		$this->columns = $config['colums'];
		$this->actions = $config['actions'];
		$this->sortable_columns = $config['sortable_columns'];
		$this->data = $config['data'];
	}

	function column_default($item, $column_name){
		if(isset($item[$column_name]))
			return $item[$column_name];
		else
			return print_r($item,true); //Show the whole array for troubleshooting purposes
	}

	function column_id($item){

		$this->actions_menu = array(
			'view'      => sprintf('<a href="?page=%s&a=%s&id=%s">Visualiser</a>',$_REQUEST['page'],'view',$item['id']),
			'update'      => sprintf('<a href="?page=%s&a=%s&id=%s">Modifier</a>',$_REQUEST['page'],'upadate',$item['id']),
			'delete'    => sprintf('<a href="?page=%s&a=%s&id=%s">Supprimer</a>',$_REQUEST['page'],'delete',$item['id']),
		);

		//Return the title contents
		return sprintf('%1$s%2$s',
			/*$2%s*/ $item['id'],
			/*$3%s*/ $this->row_actions($this->actions_menu)
		);
	}

	function column_cb($item){
		return sprintf(
			'<input type="checkbox" name="%1$s[]" value="%2$s" />',
			/*$1%s*/ $this->_args['singular'],  //Let's simply repurpose the table's singular label ("movie")
			/*$2%s*/ $item['id']                //The value of the checkbox should be the record's id
		);
	}

	function get_columns(){
		return $this->columns;
	}

	function get_sortable_columns() {
		return $this->sortable_columns;
	}

	function get_bulk_actions() {
		return $this->actions;
	}

	function process_bulk_action() {

		switch($this->current_action()){
			case 'delete':
				echo "je delete !".$_POST['id'];
				break;
			case 'update':
				echo "je update !".$_POST['id'];
				break;
			case 'view':
				echo "je delete !".$_POST['id'];
				break;
		}

	}

	function prepare_items() {
		global $wpdb; //This is used only if making any database queries
		$per_page = 5;
		$columns = $this->get_columns();
		$hidden = array();
		$sortable = $this->get_sortable_columns();
		$this->_column_headers = array($columns, $hidden, $sortable);
		$this->process_bulk_action();
		$data = $this->data;
		function usort_reorder($a,$b){
			$orderby = (!empty($_REQUEST['orderby'])) ? $_REQUEST['orderby'] : 'title'; //If no sort, default to title
			$order = (!empty($_REQUEST['order'])) ? $_REQUEST['order'] : 'asc'; //If no order, default to asc
			$result = strcmp($a[$orderby], $b[$orderby]); //Determine sort order
			return ($order==='asc') ? $result : -$result; //Send final sort direction to usort
		}
		usort($data, 'usort_reorder');
		$current_page = $this->get_pagenum();
		$total_items = count($data);
		$data = array_slice($data,(($current_page-1)*$per_page),$per_page);
		$this->items = $data;
		$this->set_pagination_args( array(
			'total_items' => $total_items,                  //WE have to calculate the total number of items
			'per_page'    => $per_page,                     //WE have to determine how many items to show on a page
			'total_pages' => ceil($total_items/$per_page)   //WE have to calculate the total number of pages
		) );
	}
}