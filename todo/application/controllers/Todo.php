<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Todo extends CI_Controller {

	/**
	 * Index Page for this controller.
	 *
	 * Maps to the following URL
	 * 		http://example.com/index.php/welcome
	 *	- or -
	 * 		http://example.com/index.php/welcome/index
	 *	- or -
	 * Since this controller is set as the default controller in
	 * config/routes.php, it's displayed at http://example.com/
	 *
	 * So any other public methods not prefixed with an underscore will
	 * map to /index.php/welcome/<method_name>
	 * @see https://codeigniter.com/userguide3/general/urls.html
	 */

	public function __construct() {
		parent::__construct();
	
		$this->load->model('todo_model');
		//Loading url helper
		$this->load->helper('url');
		$this->load->library('session');
		
		$this->load->helper('form');
		$this->load->library('form_validation');
	}
	
	public function index() {
		$data['pageName']= 'list_todo';
		$data['todo_all'] = $todo_all = $this->todo_model->todo_list();
		
		$todo_act = $todo_comp = Array();
		$todo_act_count = 0;

		foreach($todo_all as $key => $item) {
			if($item['todo_status'] == 1){
				$todo_act_count +=1;
				$todo_act[] = $item;
			}
			if($item['todo_status'] == 0){
				$todo_comp[] = $item;
			}
		}
		
		$data['todo_act']= $todo_act;
		$data['todo_comp']= $todo_comp; 
		$data['todo_act_count']= $todo_act_count.' items left.';

 		$this->load->view('main',$data);
	}

	public function create() {
		$todo_action = $this->input->post('todo_action');

		if($todo_action == 'add') {
			$todo_item_title = $this->input->post('todo_item');
		
			$data = array(
				'todo_title' => $todo_item_title
			);
            
        	$this->todo_model->add_todo_item($data);
		}

		if($todo_action == 'update') {
			$up_todo_item_id = $this->input->post('item_id');
			$up_todo_item_status = $this->input->post('item_checked');
			
			$this->todo_model->update_todo_item($up_todo_item_id, $up_todo_item_status);
		}
		
		if($todo_action == 'remove') {
			$rem_todo_item_id = $this->input->post('ritem_id');
			$this->todo_model->delete_todo_item($rem_todo_item_id);
		}

		if($todo_action == 'remove_all') {
			$rem_all_status = 0;
			$this->todo_model->delete_all_todo_item($rem_all_status);
		}
		
		$result = array('data' => array());

    	$todo_items = $this->todo_model->todo_list();

		//echo '<pre>'.print_r($todo_items,true).'</pre>';
		$html_all = $html_act = $html_comp = '';
		$act_count = 0;
		foreach($todo_items as $key => $item) {
			if($item['todo_status'] == 0){
				$comp_span_id = 'complete-span_'.$item['todo_id'].'_'.$item['todo_status'];
                $remove_comp_span_id = 'remove-span_'.$item['todo_id'];

				$html_comp .= '<div class="todo-item">';
                $html_comp .= '<div class="checker">';
                $html_comp .= '<div class="dot-div">';
                $html_comp .= '<span class="dot">';
				$html_comp .= '<div class="complete-image"></div>';
                $html_comp .= '</span>';
                $html_comp .= '</div>';
                $html_comp .= '</div>';
                $html_comp .= '<div class="todo-item-div">';
                $html_comp .= '<span id="'.$comp_span_id.'" class="complete-title" onclick="Check(this)">'.$item['todo_title'].'</span>';
                $html_comp .= '</div>';
                $html_comp .= '<div class="checker">';
                $html_comp .= '<div class="remove-div">';
                $html_comp .= '<span id="'.$remove_comp_span_id.'"  onclick="Remove(this)">';
                $html_comp .= '<div class="remove-image"></div>';
                $html_comp .= '</span>';
                $html_comp .= '</div>';
                $html_comp .= '</div>';
                $html_comp .= '</div>';
			}

			if($item['todo_status'] == 1){
				$act_count +=1;
				$act_span_id = 'complete-span_'.$item['todo_id'].'_'.$item['todo_status'];
                $remove_act_span_id = 'remove-span_'.$item['todo_id'];

				$html_act .= '<div class="todo-item">';
				$html_act .= '<div class="checker">';
				$html_act .= '<div class="dot-div">';
				$html_act .= '<span class="dot">';
				$html_act .= '<div class="active-image"></div>';
				$html_act .= '</span>';
				$html_act .= '</div>';
				$html_act .= '</div>';
				$html_act .= '<div class="todo-item-div">';
				$html_act .= '<span id="'.$act_span_id.'" class="task-title" onclick="Check(this)">'.$item['todo_title'].'</span>';
				$html_act .= '</div>';
				$html_act .= '<div class="checker">';
				$html_act .= '<div class="remove-div">';
				$html_act .= '<span id="'.$remove_act_span_id.'"  onclick="Remove(this)">';
				$html_act .= '<div class="remove-image"></div>';
				$html_act .= '</span>';
				$html_act .= '</div>';
				$html_act .= '</div>';
				$html_act .= '</div>';
			}

			$all_span_id = 'complete-span_'.$item['todo_id'].'_'.$item['todo_status'];
            $remove_all_span_id = 'remove-span_'.$item['todo_id'];
			$check_image_cls = ($item['todo_status']== 0 ? 'complete-image' : 'active-image');
			$check_title_cls = ($item['todo_status']== 0 ? 'complete-title' : 'task-title');
			
			$html_all .= '<div class="todo-item">';
			$html_all .= '<div class="checker">';
			$html_all .= '<div class="dot-div">';
			$html_all .= '<span class="dot">';
			$html_all .= '<div class="'.$check_image_cls.'"></div>';
			$html_all .= '</span>';
			$html_all .= '</div>';
			$html_all .= '</div>';
			$html_all .= '<div class="todo-item-div">';
			$html_all .= '<span id="'.$all_span_id.'" class="'.$check_title_cls.'" onclick="Check(this)">'.$item['todo_title'].'</span>';
			$html_all .= '</div>';
			$html_all .= '<div class="checker">';
			$html_all .= '<div class="remove-div">';
			$html_all .= '<span id="'.$remove_all_span_id.'"  onclick="Remove(this)">';
			$html_all .= '<div class="remove-image"></div>';
			$html_all .= '</span>';
			$html_all .= '</div>';
			$html_all .= '</div>';
			$html_all .= '</div>';
		}

    	$data['todo_html_all'] = $html_all;
		$data['todo_html_act'] = $html_act;
		$data['todo_html_comp'] = $html_comp;
		$data['todo_act_items'] = $act_count. ' items left.';
    	echo json_encode($data); 
	}
}
?>