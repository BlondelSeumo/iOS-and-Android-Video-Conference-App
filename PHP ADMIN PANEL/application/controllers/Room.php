<?php
defined('BASEPATH') OR exit('No direct script access allowed');

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
 
class Room extends CI_Controller{
	function __construct() {
        parent::__construct();
        
    }
    
    function index(){
        $data['page_title']     	= 'Join a meeting'; 
        $this->load->view('join_meeting', $data);
    }

    function join_meeting($meeting_code=''){
        $meeting_code = preg_replace('/[^A-Za-z0-9\-]/', '', $meeting_code);
    	// login check
    	if(get_app_config("app_mandatory_login") == "true"):
    		if ($this->session->userdata('login_status') != 1):
    			$this->session->set_flashdata('error', 'Login required.');            	
            	$this->session->unset_userdata('login_redirect_url');
            	$this->session->set_userdata('login_redirect_url', base_url("room/".$meeting_code));
            	redirect(base_url('login'), 'refresh');
            endif;
        endif;

        // meeting code check
    	if($meeting_code=='' || $meeting_code ==NULL):
    		$this->session->set_flashdata('error', 'Invalid meeting ID');
    		redirect(base_url() . 'room', 'refresh');
    	endif;

    	// unauthorized meeting code check
    	if(get_app_config("allow_unauthorized_meeting_code") != 'true'):    		
			if($this->common_model->verify_meeting_code($meeting_code) === false):
				$this->session->set_flashdata('error', 'unauthorized meeting ID is not allowed by admin.');
				redirect(base_url() . 'room', 'refresh');
			endif;
		endif;
		$data['meeting_code'] 		=	$meeting_code; 
		$data['nick_name'] 			=	""; 
		$data['user_id'] 			=	$this->session->userdata("user_id"); 
		$this->common_model->create_meeting_join_history($data);

		$data['meeting_info']     	= 	$this->common_model->get_meeting_info($meeting_code);
        $this->load->view('room', $data);
    }

    function join_by_post_meeting_code(){
    	$meeting_code 				= $this->input->post("meeting_code");
		if($meeting_code!='' || $meeting_code !=NULL):
    		redirect(base_url() . 'room/'.$meeting_code, 'refresh');
    	else:
    		$this->session->set_flashdata('error', 'Invalid meeting ID');
    		redirect(base_url() . 'room/', 'refresh');
    	endif;
    }

    function create_and_join_by_post_meeting_code(){
    	$user_id                  =   $this->session->userdata("user_id");
        $meeting_code             =   $this->input->post('meeting_code');        
        $meeting_title            =   $this->input->post('meeting_title');
		if($meeting_code!='' || $meeting_code !=NULL):			
	        if(empty($meeting_title) || $meeting_title =='' || $meeting_title ==NULL):
	            $meeting_title        = "Untitled";
	        endif;        
	        if(empty($user_id) || $user_id =='' || $user_id ==NULL):
	            $user_id             = 0;
	        endif;
			if(get_app_config("app_mandatory_login") == "true"):
                $is_valid_user_id         = $this->common_model->validate_user_by_id($user_id);        
                if($is_valid_user_id):
                    $data['meeting_title']  = $meeting_title;
                    $data['meeting_code']   = $meeting_code;
                    $data['user_id']        = $user_id;
                    $data['created_at']     = date("Y-m-d H:i:s");
                    $this->common_model->create_meeting($data,true);
                else:
                    $this->session->set_flashdata('error','Invalid user ID.Login again then try.');
                    redirect(base_url() . 'room/', 'refresh');
                endif;
            else:
                $data['meeting_title']  = $meeting_title;
                $data['meeting_code']   = $meeting_code;
                $data['user_id']        = $user_id;
                $data['created_at']     = date("Y-m-d H:i:s");
                $this->common_model->create_meeting($data,true);
            endif;
    		redirect(base_url() . 'room/'.$meeting_code, 'refresh');
    	else:
    		$this->session->set_flashdata('error', 'Invalid meeting ID');
    		redirect(base_url() . 'room/', 'refresh');
    	endif;
    }
}

