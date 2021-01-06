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
 
class Signup extends CI_Controller{
    
    
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
        $this->load->view('signup');        
    }

    // login function
    function do_signup(){
        $name                           = $this->input->post('name');
        $email                          = $this->input->post('email');
        $password                       = md5($this->input->post('password'));
        $this->form_validation->set_rules('name', 'Name', 'trim|required|min_length[5]');
        $this->form_validation->set_rules('email', 'Email', 'trim|required|min_length[5]|valid_email|is_unique[user.email]');
        $this->form_validation->set_rules('password', 'Password', 'trim|required|min_length[6]');
        $this->form_validation->set_rules('password2', 'Password2', 'trim|required|min_length[6]|matches[password]');
        if ($this->form_validation->run() == FALSE):
            $this->session->set_flashdata('error', validation_errors());
            redirect(base_url().'signup', 'refresh');
        else:
            $data['name']       = $this->input->post('name');          
            $data['email']      = $this->input->post('email');          
            $data['password']   = md5($this->input->post('password'));
            if($this->db->insert('user',$data)):
                $this->load->model('email_model');
                $this->email_model->account_opening_email($email, $password);
                $this->session->set_flashdata('success', 'Signup completed.');
                redirect(base_url().'login', 'refresh');
            else:
                $this->session->set_flashdata('error', 'Username & password not match..');
                redirect(base_url().'login', 'refresh');
            endif;
        endif;      
    }
}
