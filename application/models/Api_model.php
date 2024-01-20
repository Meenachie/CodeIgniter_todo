<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Api_model extends CI_Model{

    public function create($email,$task)
    {
        $query= $this->db->query("SELECT id FROM `user` where email = '$email'");
        if ($query->num_rows() > 0) {
            $row = $query->row();
            $id= $row->id;
            $task_data = array(
                'task' => $task,
                'user_id' => $id
            );
            $this->db->insert('task', $task_data);
            return $this->db->affected_rows() > 0;  
        }
    }

    public function read($id)
    {
        $this->db->where('user_id', $id);
        $query= $this->db->get('task');
        return $query->result();
    }

    public function readtask($task_id)
    {
        $this->db->where('id', $task_id);
        $query= $this->db->get('task');
        return $query->result();
    }

    public function update($task_id, $task, $status)
    {
        $this->db->query("UPDATE `task` SET task='$task',status='$status',created_on= NOW()  WHERE id='$task_id'");
        return $this->db->affected_rows() > 0;
    }

    public function delete($task_id)
    {
        $this->db->query("DELETE FROM `task` WHERE id='$task_id'");
        return $this->db->affected_rows() > 0;
    }
}
?>