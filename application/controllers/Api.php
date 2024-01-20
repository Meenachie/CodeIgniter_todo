<?php
defined('BASEPATH') OR exit('No direct script access allowed');

require APPPATH . 'libraries/RestController.php';

use chriskacerguis\RestServer\RestController;

class Api extends RestController
{
    public function __construct()
    {
        parent::__construct();
        $this->load->database();
        $this->load->model('Api_model');
    }

    public function index_get()
    {
        echo "Hello.";
        echo "This is an api demo";
    }

    public function create_post()
    {
        $data = json_decode(file_get_contents('php://input'), true);
        $email = $data['email'];
        $task = $data['task'];
        $result= $this->Api_model->create($email,$task);
        if($result>0){
            $this->response(['message'=> 'Task created successfully'],RestController::HTTP_OK);
        }else{
            $this->response(['message'=> 'Failed to create Task'],RestController::HTTP_BAD_REQUEST);
        }
        
    }

    public function read_get($id)
    {
        $data= $this->Api_model->read($id);
        $this->response($data,200);
    }

    public function readtask_get($task_id)
    {
        $data= $this->Api_model->readtask($task_id);
        $this->response($data,200);
    }

    public function update_put($task_id)
    {
        $data = json_decode(file_get_contents('php://input'), true);
        $task = $data['task'];
        $status = $data['status'];
        $result= $this->Api_model->update($task_id, $task, $status);
        if($result>0){
            $this->response(['message'=> 'Task updated successfully'],RestController::HTTP_OK);
        }else{
            $this->response(['message'=> 'Failed to update'],RestController::HTTP_BAD_REQUEST);
        }  

    }

    public function delete_delete($task_id)
    {
        $result= $this->Api_model->delete($task_id);
        if($result>0){
            $this->response(['message'=> 'Deleted successfully'],RestController::HTTP_OK);
        }else{
            $this->response(['message'=> 'Failed to Delete'],RestController::HTTP_BAD_REQUEST);
        }  
    }
}

?>