<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Users extends CI_Controller {

    public function __construct()
    {
        parent::__construct();
        $this->load->helper('url');
        $this->load->library('form_validation');
        $this->load->database();
        $this->load->model('User_model');
        $this->load->library('session');
    }

    public function index()
	{
		$this->load->view('index.php');
	}

    public function signup()
	{
        // set form validation rules
        $this->form_validation->set_rules('name', 'Name', 'required');
        $this->form_validation->set_rules('email', 'Email', 'required|valid_email|is_unique[user.email]');
        $this->form_validation->set_rules('password', 'Password', 'required|regex_match[/^(?=.*\d)(?=.*[a-z])(?=.*[A-Z]).{8,}$/]');
        $this->form_validation->set_rules('confirm_password', 'Confirm password', 'required|matches[password]');

        // set custom error messages
        $this->form_validation->set_message('required', 'The {field} field is required!');
        $this->form_validation->set_message('valid_email', 'Please enter a valid email address!');
        $this->form_validation->set_message('is_unique', 'The email is already registered!');
        $this->form_validation->set_message('regex_match', 'Password must contain at least one number, one uppercase and lowercase letter, and at least 8 characters!');
        $this->form_validation->set_message('matches', 'Password does not match!');

        if ($this->form_validation->run() === false) {
            $this->load->view('signup.php');
        } else {
            $data=[
                'name' => $this->input->post('name'),
                'email' => $this->input->post('email'),
                'password' => password_hash($this->input->post('password'), PASSWORD_DEFAULT)
            ];
            if($user =$this->User_model->signup($data)){
                $info['message']="Registered Successfully";
                $this->load->view('signup',$info);
            }
        }
	}

    public function login()
	{
		// set form validation rules
        $this->form_validation->set_rules('email', 'Email', 'required|valid_email');
        $this->form_validation->set_rules('password', 'Password', 'required');

        // set custom error messages
        $this->form_validation->set_message('required', 'The {field} field is required!');
        $this->form_validation->set_message('valid_email', 'Please enter a valid email address!');

        if ($this->form_validation->run() === false) {
            $this->load->view('login.php');
        } else{
            $email= $this->input->post('email');
            $password= $this->input->post('password');
            if($user =$this->User_model->login($email)){
                if(password_verify($password, $user->password)){
                    $this->session->set_userdata('logged_in', true);
                    $this->session->set_userdata('id',$user->id);
                    $this->session->set_userdata('email',$user->email);
                    redirect(base_url('home'));
                }else{
                    echo "Password is wrong";
                }
            }else{
                echo "No account exists with this email";
            }
        }
	}

    public function profile()
    {
        if ($this->session->userdata('logged_in')) {
            $id= $this->session->userdata('id');
            if($data['details']=$this->User_model->profile($id)){
                $this->load->view('profile.php',$data);
            }
            else{
                echo "Something went wrong";
            }
        }else{
            redirect(base_url('welcome'));
        }
    }

    public function change_password()
    {
        if ($this->session->userdata('logged_in')) {
        // set form validation rules
            $this->form_validation->set_rules('email', 'Email', 'required|valid_email');
            $this->form_validation->set_rules('old_password', 'Password', 'required');
            $this->form_validation->set_rules('new_password', 'Password', 'required|regex_match[/^(?=.*\d)(?=.*[a-z])(?=.*[A-Z]).{8,}$/]');

            // set custom error messages
            $this->form_validation->set_message('required', 'The {field} field is required!');
            $this->form_validation->set_message('valid_email', 'Please enter a valid email address!');
            $this->form_validation->set_message('regex_match', 'Password must contain at least one number, one uppercase and lowercase letter, and at least 8 characters!');

            if ($this->form_validation->run() === false) {
                $this->load->view('change_password.php');
            } else {
                $email= $this->input->post('email');
                $old_password= $this->input->post('old_password');
                $new_password= password_hash($this->input->post('new_password'), PASSWORD_DEFAULT);
                if($email==$this->session->userdata('email')){
                    if($user =$this->User_model->login($email)){
                        if(password_verify($old_password, $user->password)){
                            if ($user = $this->User_model->change_password($email, $new_password)){
                                $data['message']="Password updated successfully";
                                $this->load->view('change_password',$data);
                                //echo "<div class='alert alert-success'>Password updated successfully</div>";
                            }
                        }else{
                            $data['message']="Old password is wrong";
                            $this->load->view('change_password',$data);
                            //echo "<div class='alert alert-danger'>Old password is wrong</div>";
                        }
                    }else{
                        echo "Something went wrong";
                    }
                }else{
                    $data['message']="Email is incorrect";
                    $this->load->view('change_password',$data);
                }
            }
        }else{
            redirect(base_url('welcome'));
        } 
        
    }

    public function logout()
    {
        $this->session->sess_destroy();
        $this->session->unset_userdata('id');
        redirect(base_url('welcome'));
    }

    public function home()
    {
        if ($this->session->userdata('logged_in')) {
            $id= $this->session->userdata('id');
            if($data['task']=$this->User_model->read($id)){
                $this->load->view('home.php',$data);
            }
            else{
                $this->load->view('home.php');
            } 
        }else{
            redirect(base_url('welcome'));
        } 
    }

    public function create()
    {
        $id= $this->session->userdata('id');
        $task= $this->input->post('task');
        if($this->User_model->create($id,$task)){
            redirect(base_url('home'));
        }else{
            echo "Something went wrong";
        }
    }

    public function edit($id)
    {
        if ($this->session->userdata('logged_in')){
            if($data['task']= $this->User_model->edit($id)){
                $this->load->view('update',$data);
            }else{
                echo "Something went wrong";
            } 
        }else{
            redirect(base_url('welcome'));
        } 
    }

    public function update($id)
    {
        if ($this->session->userdata('logged_in')){
            $task= $this->input->post('edittask');
            $status= $this->input->post('status');
            if($this->User_model->update($id,$task,$status,$time)){
                redirect(base_url('home'));
            }else{
                echo "Something went wrong";
            }
        }else{
            redirect(base_url('welcome'));
        } 
    }

    public function delete($id)
    {
        $this->User_model->delete($id);
        redirect(base_url('home'));
    }

}
?>