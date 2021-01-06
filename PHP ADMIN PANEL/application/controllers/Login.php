<?php
if (!defined('BASEPATH'))
    exit('No direct script access allowed');

/**
 * MeetAir - Flutter Video Conference App for Android And iOS
 * ---------------------- MeetAir --------------------
 *
 * @package     MeetAir - Flutter Video Conference App for Android And iOS
 * @author      Abdul Mannan/SpaGreen Creative
 * @copyright   Copyright (c) 2014 - 2020 SpaGreen,
 * @license     http://codecanyon.net/wiki/support/legal-terms/licensing-terms/ 
 * @link        https://spagreen.net
 * @link        https://desk.spagreen.net
 *
 **/
 
class Login extends CI_Controller{
    
    
    function __construct(){
        parent::__construct();
        $this->load->model('common_model');
        $this->load->database();
        /*cache control*/
        $this->output->set_header('Last-Modified: ' . gmdate("D, d M Y H:i:s") . ' GMT');
        $this->output->set_header('Cache-Control: no-store, no-cache, must-revalidate, post-check=0, pre-check=0');
        $this->output->set_header('Pragma: no-cache');
        $this->output->set_header("Expires: Mon, 26 Jul 2010 05:00:00 GMT");
    }
	
    //Default function, redirects to logged in user area
    public function index(){
        if ($this->session->userdata('admin_is_login') == 1)
        redirect(base_url() . 'admin/dashboard', 'refresh');
        if ($this->session->userdata('user_is_login') == 1)
            redirect(base_url(), 'refresh');
        $this->load->view('login');        
    }

    // login function
    function do_login(){
        $email                          = $this->input->post('email');
        $password                       = md5($this->input->post('password'));
        $this->form_validation->set_rules('email', 'Email', 'required|min_length[5]|valid_email');
        $this->form_validation->set_rules('password', 'Password', 'required|min_length[6]');
        if ($this->form_validation->run() == FALSE):
            $this->session->set_flashdata('error', validation_errors());
            redirect(base_url().'login', 'refresh');
        else:            
            $login_status               = $this->validate_login( $email ,$password);        
            if ($login_status == 'success'):
                $login_redirect = $this->session->userdata("login_redirect_url");
                if($login_redirect !="" && $login_redirect !=NULL):
                    redirect($login_redirect, 'refresh');
                else:
                    redirect(base_url() . 'admin/dashboard', 'refresh');
                endif;
            else:
                $this->session->set_flashdata('error', 'Username & password not match..');
                redirect(base_url().'login', 'refresh');
            endif;
        endif;      
    }

    
    // validate login  function
    function validate_login($email   =   '' , $password   =  ''){
        $credential    =   array(  'email' => $email , 'password' => $password,'status'=> "1");
        $query = $this->db->get_where('user' , $credential);
        $row = $query->row();
        if ($query->num_rows() > 0):
            $this->session->set_userdata('login_status', '1');
            $this->session->set_userdata('user_id', $row->user_id);
            $this->session->set_userdata('name', $row->name);                     
            $this->session->set_userdata('email', $row->email);                     
            $this->db->where('user_id', $row->user_id);
            $this->db->update('user', array(
                'last_login' => date('Y-m-d H:i:s')
            )); 
            if($row->role =='admin'):
              $this->session->set_userdata('admin_is_login', '1');
              $this->session->set_userdata('login_type', 'admin');
            endif;
            if($row->role =='teacher'):
              $this->session->set_userdata('teacher_is_login', '1');
              $this->session->set_userdata('login_type', 'teacher');
            endif;
            if($row->role =='subscriber'):
              $this->session->set_userdata('user_is_login', '1');
              $this->session->set_userdata('login_type', 'subscriber');
            endif;
              return 'success';
        endif;        
        return 'invalid';       
    }


    // logout function
    function logout() {
        $this->session->unset_userdata('');
        $this->session->sess_destroy();
        $this->session->set_flashdata('logout_notification', 'logged_out');
        redirect(base_url() , 'refresh');
    }


    function forget_password($param1='', $param2='') {
        if ($param1 == 'do_reset'):           
            $email                  = $this->input->post('email');            
            $user_exist             = $this->common_model->check_email($email);
            //var_dump($user_exist , $email);
            if($user_exist):
                $new_password       =   $this->common_model->generate_random_string(6);             
                $data['password']   =   md5($new_password);
                $this->db->where('email',$email);
                $this->db->update('user',$data);
                $this->load->model('email_model');
                $this->email_model->password_reset_email($email, $new_password);
                $this->session->set_flashdata('success', 'Please Check Your Email to Complete Password Reset.');
                redirect(base_url("forgot-password"), 'refresh');                
            else:
                $this->session->set_flashdata('error', 'Email not found on our system');            
                redirect(base_url("forgot-password"), 'refresh');
            endif;
        else:
            $this->load->view('forget_password');
        endif;
    }
}
