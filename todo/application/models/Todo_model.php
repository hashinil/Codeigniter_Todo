<?php
class Todo_model extends CI_Model {
    public function __construct() {
        $this->load->database();
    }

    public function add_todo_item($data) {
        return $this->db->insert('todo_items', $data);
    }

    public function update_todo_item($item_id, $status){
        $this->db->where('todo_id = '.$item_id);
        return $this->db->update('todo_items', array('todo_status'=>$status));
    }

    public function delete_todo_item($item_id) {
        $this->db->where('todo_id', $item_id);
        $this->db->delete('todo_items');
        //echo $this->db->last_query(); die();
        return true;
    }

    public function delete_all_todo_item($status) {
        $this->db->where('todo_status', $status);
        $this->db->delete('todo_items');
        //echo $this->db->last_query(); die();
        return true;
    }

    public function todo_list() {
        $this->db->select('i.*'); 
        $this->db->from('todo_items i');
        $query = $this->db->get();
        return $query->result_array();
    }
}
?>