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


class Admin extends CI_Controller {   
    
    function __construct() {
        parent::__construct();
        if ($this->session->userdata('admin_is_login') != 1)
            redirect(base_url(), 'refresh');

        //cache controling
        $this->output->set_header('Last-Modified: ' . gmdate("D, d M Y H:i:s") . ' GMT');('Cache-Control: no-store, no-cache, must-revalidate, post-check=0, pre-check=0');
        $this->output->set_header('Pragma: no-cache');
        $this->output->set_header("Expires: Mon, 26 Jul 1997 05:00:00 GMT");        
    }
    
    //default index function, redirects to login/dashboard 
    public function index(){
        if ($this->session->userdata('admin_is_login') != 1)
            redirect(base_url() . 'login', 'refresh');
        if ($this->session->userdata('admin_is_login') == 1)
            redirect(base_url() . 'admin/dashboard', 'refresh');
    }
    
    //dashboard
    function dashboard(){
        
		// active menu session
        $this->session->unset_userdata('active_menu');
        $this->session->set_userdata('active_menu', '1');
        /* end menu active/inactive section*/
        $data['page_name']             = 'dashboard';
        $data['page_title']            = 'Admin Dashboard';
        $this->load->view('admin/index', $data);		
			
    }

    // manage users
    function manage_user($param1 = '', $param2 = ''){
        // active menu session
        $this->session->unset_userdata('active_menu');
        $this->session->set_userdata('active_menu', '2');        
        if ($param1 == 'add') {
            $data['name']           = $this->input->post('name');
            $data['password']       = md5($this->input->post('password'));
            $data['email']          = $this->input->post('email');
            $data['role']           = $this->input->post('role');
            $data['meeting_code']   = $this->common_model->generate_meeting_code();           
            
            $this->db->insert('user', $data);
            $this->session->set_flashdata('success', 'User added successed');
            redirect(base_url() . 'admin/manage_user/', 'refresh');
        }
        if ($param1 == 'update') {
            $data['name']           = $this->input->post('name');
            if($this->input->post('password')!='' || $this->input->post('password')!=NULL){
                $data['password']   = md5($this->input->post('password'));
            }            
            $data['email']          = $this->input->post('email');
            $data['role']           = $this->input->post('role');
            $this->db->where('user_id', $param2);
            $this->db->update('user', $data);
            $this->session->set_flashdata('success', 'User update successed.');
            redirect(base_url() . 'admin/manage_user/', 'refresh');
        }
        $name           = $this->input->get('name');
        $search_string = '';
        if($name !="" && $name !=NULL){
            $filter['name '] = $name;
            $search_string.= 'name='.$name;
            $data['name'] = $name;
        }
        $total_rows     = $this->common_model->get_user_num_rows($name);
        // page
        $config                     = $this->common_model->pagination();
        $config["base_url"]         = base_url() . "admin/manage_user?".$search_string;
        $config["total_rows"]       = $total_rows;
        $config["per_page"]         = 15;
        $config["uri_segment"]      = 3;          
        //$config['use_page_numbers'] = TRUE;
        $config['page_query_string']= TRUE; 
        $this->pagination->initialize($config);
        $data['last_row_num']       =  $this->uri->segment(3);
        $page                       = ($this->input->get('per_page') !="" || $this->input->get('per_page') !=NULL) ? $this->input->get('per_page') : 0;//($this->uri->segment(3)) ? $this->uri->segment(3) : 0;   
        $data["users"]              = $this->common_model->get_users($name,$config["per_page"], $page);
        $data["links"]              = $this->pagination->create_links();
        $data['total_rows']         = $config["total_rows"];
        $data['page_name']          = 'user_manage';
        $data['page_title']         = 'User Management';             
        $this->load->view('admin/index', $data);
    }

    // meeting
    function meeting($param1 = '', $param2 = ''){
        // active menu session
        $this->session->unset_userdata('active_menu');
        $this->session->set_userdata('active_menu', '3');        
        if ($param1 == 'add') {
            $data['meeting_title']  = $this->input->post('meeting_title');
            $data['meeting_code']   = $this->input->post('meeting_code');
            $data['user_id']        = $this->session->userdata("user_id");
            $data['created_at']     = date("Y-m-d H:i:s");
            
            $this->db->insert('meeting', $data);
            $this->session->set_flashdata('success', 'Meeting create successed');
            redirect(base_url() . 'admin/meeting/', 'refresh');
        }
        if ($param1 == 'update') {
            $data['meeting_title']  = $this->input->post('meeting_title');
            $this->db->where('meeting_id', $param2);
            $this->db->update('meeting', $data);
            $this->session->set_flashdata('success', 'Meeting update successed.');
            redirect(base_url() . 'admin/meeting/', 'refresh');
        }
        $meeting_code           = $this->input->get('meeting_code');
        $search_string = '';
        if($meeting_code !="" && $meeting_code !=NULL):
            $filter['meeting_code '] = $meeting_code;
            $search_string.= 'meeting_code='.$meeting_code;
            $data['meeting_code'] = $meeting_code;
        endif;
        $total_rows     = $this->common_model->get_meeting_num_rows($meeting_code);
        // page
        $config                     = $this->common_model->pagination();
        $config["base_url"]         = base_url() . "admin/meeting?".$search_string;
        $config["total_rows"]       = $total_rows;
        $config["per_page"]         = 15;
        $config["uri_segment"]      = 3;          
        //$config['use_page_numbers'] = TRUE;
        $config['page_query_string']= TRUE; 
        $this->pagination->initialize($config);
        $data['last_row_num']       =  $this->uri->segment(3);
        $page                       = ($this->input->get('per_page') !="" || $this->input->get('per_page') !=NULL) ? $this->input->get('per_page') : 0;
        //($this->uri->segment(3)) ? $this->uri->segment(3) : 0;   
        $data["meetings"]              = $this->common_model->get_meetings($meeting_code,$config["per_page"], $page);
        $data["links"]              = $this->pagination->create_links();
        $data['total_rows']         = $config["total_rows"];
        $data['page_name']          = 'meeting';
        $data['page_title']         = 'Manage Meetings';             
        $this->load->view('admin/index', $data);
    }

    // meeting
    function meeting_history($param1 = '', $param2 = ''){
        // active menu session
        $this->session->unset_userdata('active_menu');
        $this->session->set_userdata('active_menu', '4');
        $meeting_code           = $this->input->get('meeting_code');
        $search_string = '';
        if($meeting_code !="" && $meeting_code !=NULL):
            $filter['meeting_code '] = $meeting_code;
            $search_string.= 'meeting_code='.$meeting_code;
            $data['meeting_code'] = $meeting_code;
        endif;
        $total_rows     = $this->common_model->get_meeting_history_num_rows($meeting_code);
        // page
        $config                     = $this->common_model->pagination();
        $config["base_url"]         = base_url() . "admin/meeting_history?".$search_string;
        $config["total_rows"]       = $total_rows;
        $config["per_page"]         = 15;
        $config["uri_segment"]      = 3;          
        //$config['use_page_numbers'] = TRUE;
        $config['page_query_string']= TRUE; 
        $this->pagination->initialize($config);
        $data['last_row_num']       =  $this->uri->segment(3);
        $page                       = ($this->input->get('per_page') !="" || $this->input->get('per_page') !=NULL) ? $this->input->get('per_page') : 0;
        //($this->uri->segment(3)) ? $this->uri->segment(3) : 0;   
        $data["meeting_histories"]  = $this->common_model->get_meeting_history($meeting_code,$config["per_page"], $page);
        $data["links"]              = $this->pagination->create_links();
        $data['total_rows']         = $config["total_rows"];
        $data['page_name']          = 'meeting_history';
        $data['page_title']         = 'Meetings History';             
        $this->load->view('admin/index', $data);
    }   

    // system setting
    function system_setting($param1 = '', $param2 = ''){
        // active menu session
        $this->session->unset_userdata('active_menu');
        $this->session->set_userdata('active_menu', '5');
            /* end menu active/inactive section*/
        if ($param1 == 'update') { 

            $data['value'] = $this->input->post('app_name');
            $this->db->where('title' , 'app_name');
            $this->db->update('config' , $data);

            $data['value'] = $this->input->post('purchase_code');
            $this->db->where('title' , 'purchase_code');
            $this->db->update('config' , $data);

            $data['value'] = $this->input->post('jitsi_server');
            $this->db->where('title' , 'jitsi_server');
            $this->db->update('config' , $data);

            $data['value'] = "free";
            if($this->input->post('app_mode') == "academic")
                $data['value'] = "academic";
            $this->db->where('title' , 'app_mode');
            $this->db->update('config' , $data);

            $data['value'] = "false";
            if($this->input->post('app_mandatory_login') == "true")
                $data['value'] = "true";
            $this->db->where('title' , 'app_mandatory_login');
            $this->db->update('config' , $data);
             
             
            $data['value'] = $this->input->post('allow_unauthorized_meeting_code');
            $this->db->where('title' , 'allow_unauthorized_meeting_code');
            $this->db->update('config' , $data);

            $data['value'] = $this->input->post('meeting_prefix');
            $this->db->where('title' , 'meeting_prefix');
            $this->db->update('config' , $data);


            $data['value'] = $this->input->post('system_email');
            $this->db->where('title' , 'system_email');
            $this->db->update('config' , $data);
             
            $data['value'] = $this->input->post('business_address');
            $this->db->where('title' , 'business_address');
            $this->db->update('config' , $data);

            $data['value'] = $this->input->post('business_phone');
            $this->db->where('title' , 'business_phone');
            $this->db->update('config' , $data);

            $data['value'] = $this->input->post('contact_email');
            $this->db->where('title' , 'contact_email');
            $this->db->update('config' , $data);

            $data['value'] = $this->input->post('privacy_policy_text');
            $this->db->where('title' , 'privacy_policy_text');
            $this->db->update('config' , $data);


            $data['value'] = "false";
            if($this->input->post('addthis_enable') == "true")
                $data['value'] = "true";
            $this->db->where('title' , 'addthis_enable');
            $this->db->update('config' , $data);

            $data['value'] = $this->input->post('addthis_pubid');
            $this->db->where('title' , 'addthis_pubid');
            $this->db->update('config' , $data);                     

            $this->session->set_flashdata('success', 'Setting update successed.');           
            redirect($this->agent->referrer());
        }
        $data['page_name']      = 'system_setting';
        $data['page_title']     = 'System Setting';
        $this->load->view('admin/index', $data);
    }

       

    // API setting
    function api_setting($param1 = '', $param2 = ''){
        // active menu session
        $this->session->unset_userdata('active_menu');
        $this->session->set_userdata('active_menu', '6');
        /* end menu active/inactive section*/
        if($param1 =="update"):
            $data['key']    = $this->input->post("key");
            $this->db->where("id",$param2);
            $this->db->update('keys',$data);
            $this->session->set_flashdata('success', 'Update successed.');
            redirect($this->agent->referrer());
        endif;
        if($param1 =="update_key"):
            if($param2 !="" && $param2 !=NULL):
                $query = $this->db->get_where('keys',array('id'=>$param2));
                if($query->num_rows() >0):
                    $data['key']    = $this->common_model->generate_random_string(24);
                    $this->db->where("id",$param2);
                    $this->db->update('keys',$data);
                    $this->session->set_flashdata('success', 'New key create and save successed.');
                endif;
            endif;
            redirect($this->agent->referrer());
        endif;      

        $data['page_name']      = 'api_setting';
        $data['page_title']     = 'API Setting';
        $data['key']            = $this->db->get('keys')->first_row();
        $this->load->view('admin/index', $data);
    }

    // general setting
    function email_setting($param1 = '', $param2 = ''){
        if ($this->session->userdata('admin_is_login') != 1)
            redirect(base_url(), 'refresh');
        // active menu session
        $this->session->unset_userdata('active_menu');
        $this->session->set_userdata('active_menu', '7');
        /* end menu active/inactive section*/

        if ($param1 == 'update') {
            $protocol = $this->input->post('protocol');            
            if($protocol=='smtp')
            {
                $data['value'] = $this->input->post('protocol');
                $this->db->where('title' , 'protocol');
                $this->db->update('config' , $data);

                $data['value'] = $this->input->post('smtp_host');
                $this->db->where('title' , 'smtp_host');
                $this->db->update('config' , $data);

                $data['value'] = $this->input->post('smtp_user');
                $this->db->where('title' , 'smtp_user');
                $this->db->update('config' , $data);


                $data['value'] = $this->input->post('smtp_pass');
                $this->db->where('title' , 'smtp_pass');
                $this->db->update('config' , $data);

                $data['value'] = $this->input->post('smtp_port');
                $this->db->where('title' , 'smtp_port');
                $this->db->update('config' , $data);

                $data['value'] = $this->input->post('smtp_crypto');
                $this->db->where('title' , 'smtp_crypto');
                $this->db->update('config' , $data); 
            }
            else if($protocol=='sendmail')
            {
                $data['value'] = $this->input->post('protocol');
                $this->db->where('title' , 'protocol');
                $this->db->update('config' , $data);

                $data['value'] = $this->input->post('mailpath');
                $this->db->where('title' , 'mailpath');
                $this->db->update('config' , $data);
            }else{
                $data['value'] = $this->input->post('protocol');
                $this->db->where('title' , 'protocol');
                $this->db->update('config' , $data);
            }

             $data['value'] = $this->input->post('contact_email');
             $this->db->where('title' , 'contact_email');
             $this->db->update('config' , $data);

             $this->session->set_flashdata('success', 'Setting update successed.');           
             redirect($this->agent->referrer());
        }
        $data['page_name']      = 'email_setting';
        $data['page_title']     = 'Email Setting';
        $this->load->view('admin/index', $data);
    }
    function mobile_ads_setting($param1 = '', $param2 = ''){
        if ($this->session->userdata('admin_is_login') != 1)
            redirect(base_url(), 'refresh');
        // active menu session
        $this->session->unset_userdata('active_menu');
        $this->session->set_userdata('active_menu', '8');

        if($param1=='update'): 
            $mobile_ads_enable = $this->input->post('mobile_ads_enable');
            if($mobile_ads_enable =='on'):
                $data['value'] = '1';
                $this->db->where('title' , 'mobile_ads_enable');
                 $this->db->update('config' , $data);
            else:
                $data['value'] = '0';
                 $this->db->where('title' , 'mobile_ads_enable');
                 $this->db->update('config' , $data);
            endif;

            $data['value'] = $this->input->post('mobile_ads_network');
            $this->db->where('title' , 'mobile_ads_network');
            $this->db->update('config' , $data);

            $data['value'] = $this->input->post('admob_app_id');
            $this->db->where('title' , 'admob_app_id');
            $this->db->update('config' , $data);

            $data['value'] = $this->input->post('admob_publisher_id');
            $this->db->where('title' , 'admob_publisher_id');
            $this->db->update('config' , $data);

            $data['value'] = $this->input->post('admob_banner_ads_id');
            $this->db->where('title' , 'admob_banner_ads_id');
            $this->db->update('config' , $data);

            $data['value'] = $this->input->post('admob_interstitial_ads_id');
            $this->db->where('title' , 'admob_interstitial_ads_id');
            $this->db->update('config' , $data);

            $this->session->set_flashdata('success', 'Ads Setting changed.');
            redirect($this->agent->referrer());
        endif;
        $data['page_name']  = 'mobile_ads_setting';
        $data['page_title'] = 'Mobile Ads Setting';
        $this->load->view('admin/index', $data);
    }
    // logo setting
    function logo_and_image($param1 = '', $param2 = ''){
        if ($this->session->userdata('admin_is_login') != 1)
            redirect(base_url(), 'refresh');
            /* start menu active/inactive section*/
            $this->session->unset_userdata('active_menu');
            $this->session->set_userdata('active_menu', '9');
            /* end menu active/inactive section*/

        if ($param1 == 'update') {
            // logo
            if (isset($_FILES['logo']['name']) && !empty($_FILES['logo']['name'])):
                $config['upload_path']          = './uploads/system_logo/';
                $config['allowed_types']        = 'jpg|png';
                $config['max_size']             = 512;
                $config['max_width']            = 512;
                $config['max_height']           = 512;
                $config['file_name']            = 'logo_'.uniqid();
                $this->upload->initialize($config);
                //upload file to directory
                if($this->upload->do_upload('logo')):
                    $uploadData                 = $this->upload->data();                    
                    $file_name                  = $uploadData['file_name'];
                    $file_ext                   = $uploadData['file_ext'];

                    $data['value']              = $file_name;
                    $this->db->where('title' , 'logo');
                    $this->db->update('config' , $data);
                    $this->session->set_flashdata('success', trans('setting_update_success')); 
                else:
                    $this->session->set_flashdata('error', $this->upload->display_errors());                
                endif;
            endif;
            // favicon
            if (isset($_FILES['favicon']['name']) && !empty($_FILES['favicon']['name'])):
                $config['upload_path']          = './uploads/system_logo/';
                $config['allowed_types']        = 'jpg|png|ico';
                $config['max_size']             = 200;
                $config['max_width']            = 512;
                $config['max_height']           = 512;
                $config['file_name']            = 'favicon_'.uniqid();
                $this->upload->initialize($config);
                //upload file to directory
                if($this->upload->do_upload('favicon')):
                    $uploadData                 = $this->upload->data();                    
                    $file_name                  = $uploadData['file_name'];
                    $file_ext                   = $uploadData['file_ext'];

                    $data['value']              = $file_name;
                    $this->db->where('title' , 'favicon');
                    $this->db->update('config' , $data);
                    $this->session->set_flashdata('success', trans('setting_update_success')); 
                else:
                    $this->session->set_flashdata('error', $this->upload->display_errors());                
                endif;
            endif;

            // backdrop image
            if (isset($_FILES['backdrop_image']['name']) && !empty($_FILES['backdrop_image']['name'])):
                $config['upload_path']          = './uploads/';
                $config['allowed_types']        = 'jpg|png|ico';
                $config['max_size']             = 1024;
                $config['max_width']            = 0;
                $config['max_height']           = 0;
                $config['file_name']            = 'backdrop_image_'.uniqid();
                $this->upload->initialize($config);
                //upload file to directory
                if($this->upload->do_upload('backdrop_image')):
                    $uploadData                 = $this->upload->data();                    
                    $file_name                  = $uploadData['file_name'];
                    $file_ext                   = $uploadData['file_ext'];

                    $data['value']              = $file_name;
                    $this->db->where('title' , 'backdrop_image');
                    $this->db->update('config' , $data);
                    $this->session->set_flashdata('success', trans('setting_update_success')); 
                else:
                    $this->session->set_flashdata('error', $this->upload->display_errors());                
                endif;
            endif;

            // backdrop image
            if (isset($_FILES['og_image']['name']) && !empty($_FILES['og_image']['name'])):
                $config['upload_path']          = './uploads/';
                $config['allowed_types']        = 'jpg|png|ico';
                $config['max_size']             = 1024;
                $config['max_width']            = 0;
                $config['max_height']           = 0;
                $config['file_name']            = 'og_image_'.uniqid();
                $this->upload->initialize($config);
                //upload file to directory
                if($this->upload->do_upload('og_image')):
                    $uploadData                 = $this->upload->data();                    
                    $file_name                  = $uploadData['file_name'];
                    $file_ext                   = $uploadData['file_ext'];

                    $data['value']              = $file_name;
                    $this->db->where('title' , 'og_image');
                    $this->db->update('config' , $data);
                    $this->session->set_flashdata('success', trans('setting_update_success')); 
                else:
                    $this->session->set_flashdata('error', $this->upload->display_errors());                
                endif;
            endif;
            
            redirect($this->agent->referrer());
        }

            $data['page_name']      = 'logo_and_image';
            $data['page_title']     = "Logo and Image Setting";
            $this->load->view('admin/index', $data);
    }

    function update($param1 = '', $param2 = ''){
        /* start menu active/inactive section*/
        $this->session->unset_userdata('active_menu');
        $this->session->set_userdata('active_menu', '10');
        /* end menu active/inactive section*/
        $data['page_name']      = 'update';
        $data['page_title']     = 'System updater';
        $this->load->view('admin/index', $data);
    }
    // updater function

    function process_update($action = '')
    {
        ini_set('max_execution_time', 300); //300 seconds 
        if ($this->session->userdata('admin_is_login') != 1)
            redirect(base_url(), 'refresh');

        // create directory if not exist.
        $update_dir = 'update';
        if (!is_dir($update_dir))
            mkdir($update_dir, 0777, true);

        $zip_file_name = $_FILES["zip_file"]["name"];
        $path = 'update/' . $zip_file_name;
        move_uploaded_file($_FILES["zip_file"]["tmp_name"], $path);

        // unzip file and remove uploded zip file.
        $zip = new ZipArchive;
        $contents = $zip->open($path);
        if ($contents === TRUE) {
            $zip->extractTo($update_dir);
            $zip->close();
            unlink($path);
        }

        $unzip_file_name = substr($zip_file_name, 0, -4);



        // update database
        //check for valid database connection
        $host           =     $this->db->hostname;
        $dbuser         =     $this->db->username;
        $dbpassword     =     $this->db->password;
        $dbname         =     $this->db->database;

        $mysqli = @new mysqli($host, $dbuser, $dbpassword, $dbname);

        if (mysqli_connect_errno()) {
            // echo json_encode(array("success" => false, "message" => $mysqli->connect_error));
            // exit();
        }else{
            $sql = file_get_contents('./update/' . $unzip_file_name . '/database.sql');

            $mysqli->multi_query($sql);
            do {
                
            } while (mysqli_more_results($mysqli) && mysqli_next_result($mysqli));
            $mysqli->close();

            $configs =$this->db->get('temp_config')->result_array();
            //var_dump($configs);
            foreach($configs as $config):
                $data['title'] = trim($config['title']);
                $data['value'] = trim($config['value']);

                $this->db->where('title',trim($config['title']));
                $query = $this->db->get('config');
                if($query->num_rows() == 0):                                   
                    $this->db->insert('config',$data);
                    //var_dump($this->db->last_query());                    
                endif;
                if($query->num_rows() > 1):
                    $this->db->reset_query();
                    $this->db->where('title',$config['title']);
                    $this->db->delete('config');
                    $this->db->reset_query();
                    $this->db->insert('config',$data);
                    //var_dump($this->db->last_query());
                endif;
            endforeach;
            // delete temp table
            $this->load->dbforge();
            $this->dbforge->drop_table('temp_config',TRUE);
        }

        // get json_content        
        $str = file_get_contents('./update/' . $unzip_file_name . '/config.json');
        $converted_json = json_decode($str, true);

        // process php file
        require './update/' . $unzip_file_name . '/php_update.php';

        // Create directorie if not exist
        if (!empty($converted_json['directories'])) {
            foreach ($converted_json['directories'] as $dir) {
                if (!is_dir($dir['title']))
                    mkdir($dir['title'], 0777, true);
            }
        }
        // copy file if not exist or replace existing file
        if (!empty($converted_json['files'])) {
            foreach ($converted_json['files'] as $files):
                // copy/replace file
                copy($files['from_dir'], $files['to_dir']);
                unlink($files['from_dir']);
            endforeach;
        } 
        $this->deleteDir();      
        // redirect after ompleted
        $this->session->set_flashdata('success', "Update successfully completed.");
        redirect(base_url() . 'admin/update/', 'refresh');
    }

    public function deleteDir($dirPath =FCPATH.'update') {
        if ($this->session->userdata('admin_is_login') != 1)
            redirect(base_url(), 'refresh');

        if (! is_dir($dirPath)) {
            throw new InvalidArgumentException("$dirPath must be a directory");
        }
        if (substr($dirPath, strlen($dirPath) - 1, 1) != '/') {
            $dirPath .= '/';
        }
        $files = glob($dirPath . '*', GLOB_MARK);
        foreach ($files as $file) {
            if (is_dir($file)) {
                self::deleteDir($file);
            } else {
                unlink($file);
            }
        }
        rmdir($dirPath);
    }

    function send_notification($param1 = '', $param2 = ''){
        if ($this->session->userdata('admin_is_login') != 1)
            redirect(base_url(), 'refresh');
        // active menu session
        $this->session->unset_userdata('active_menu');
        $this->session->set_userdata('active_menu', '11');
        /* end menu active/inactive section*/

        if ($param1 == 'send') {
            $data['message']            = $this->input->post("message");
            $data['url']                = $this->input->post("url");
            $data['headings']           = $this->input->post("headings");
            $data['icon']               = $this->input->post("icon");         
            $data['img']                = $this->input->post("img");
            $this->load->model('notify_model');
            $this->notify_model->send_notification($data);
            $this->session->set_flashdata('success', 'Push notification sent success');
            redirect($this->agent->referrer());
        }
        $data['page_name']      = 'send_notification';
        $data['page_title']     = 'Send Notification(OneSignal)';
        $this->load->view('admin/index', $data);
    }

    function push_notification_setting($param1 = '', $param2 = ''){
        if ($this->session->userdata('admin_is_login') != 1)
            redirect(base_url(), 'refresh');
        // active menu session
        $this->session->unset_userdata('active_menu');
        $this->session->set_userdata('active_menu', '12');
        /* end menu active/inactive section*/

        if ($param1 == 'update') {
            $data['value'] = $this->input->post('push_notification_enable');
            $this->db->where('title' , 'push_notification_enable');
            $this->db->update('config' , $data);

            $data['value'] = $this->input->post('onesignal_appid');
            $this->db->where('title' , 'onesignal_appid');
            $this->db->update('config' , $data);

            $data['value'] = $this->input->post('onesignal_api_keys');
            $this->db->where('title' , 'onesignal_api_keys');
            $this->db->update('config' , $data);

            $this->session->set_flashdata('success', 'Push notification setting update successed');
            redirect($this->agent->referrer());
        }
        $data['page_name']      = 'push_notification_setting';
        $data['page_title']     = 'Push notification setting(OneSignal)';
        $this->load->view('admin/index', $data);
    }

    // database backup and restore management
    function backup_restore($operation = '', $type = ''){

        // active menu session
        $this->session->unset_userdata('active_menu');
        $this->session->set_userdata('active_menu', '13');
        
        if ($operation == 'create') {           
            $this->common_model->create_backup();
            $this->session->set_flashdata('success', 'Backup created..');
            redirect($this->agent->referrer());
        }
        if ($operation == 'download') {
            $this->load->helper('download');
            $file = FCPATH.'db_backup/'.$type;
            force_download($file,NULL);
        }
        if ($operation == 'delete') {
            $this->load->helper('file');
            $path_to_file = 'db_backup/'.$type;
            if(unlink($path_to_file)) {
                $this->session->set_flashdata('success', 'Deleted');
                redirect($this->agent->referrer());
            }
            else {
                $this->session->set_flashdata('error', 'File not found..');
                redirect($this->agent->referrer());
            }
        }        
        $data['page_info']  = 'Create Database Backup';
        $data['page_name']  = 'backup_restore';
        $data['page_title'] = 'Create Database Backup';
        $this->load->view('admin/index', $data);
    }

    function test_mail(){
        if ($this->session->userdata('admin_is_login') != 1)
            redirect(base_url(), 'refresh');
        $email  =    $this->input->post('email');
        if($email !=''){
            $this->load->model('email_model');
            if($this->email_model->test_mail($email)){
                $this->session->set_flashdata('success', 'Mail Configuration is perfect');
                $this->session->set_flashdata('send_success', 'Mail Configuration is perfect.Please check your mail to confirm');
                redirect(base_url() . 'admin/email_setting/', 'refresh');
            }else{
                $this->session->set_flashdata('send_error', 'Mail Configuration is perfect');
                redirect(base_url() . 'admin/email_setting/', 'refresh');
            }            
        }
        
        $this->session->set_flashdata('error', 'Please enter a valid email.');
        redirect(base_url() . 'admin/email_setting/', 'refresh');        
    }

	

    function view_modal($page_name = '' , $param2 = '' , $param3 = '', $param4 = ''){
        $account_type       =   $this->session->userdata('login_type');
        $data['param2']     =   $param2;
        $data['param3']     =   $param3;
        $data['param4']     =   $param4;
        $this->load->view('admin/'.$page_name.'.php' ,$data);
    }
    //profile
	function manage_profile(){
        // active menu session
        $this->session->unset_userdata('active_menu');
        $this->session->set_userdata('active_menu', '12');
        $data['page_name']      = 'manage_profile';
        $data['page_title']     = 'Update profile information';
        $data['profile_info']   = $this->db->get_where('user', array(
        'user_id' => $this->session->userdata('user_id')))->result_array();
        $this->load->view('admin/index', $data);
    }

    // profile
    function profile($param1 = '', $param2 = '', $param3 = ''){
        // active menu session
            $this->session->unset_userdata('active_menu');
            $this->session->set_userdata('active_menu', '12');
            /* end menu active/inactive section*/
            $user_id=$this->session->userdata('user_id');
        if ($this->session->userdata('admin_is_login') != 1)
            redirect(base_url() . 'login', 'refresh');
        if ($param1 == 'update') {
            $data['name']  = $this->input->post('name');
            $data['email'] = $this->input->post('email');
            
            $this->db->where('user_id', $user_id);
            $this->db->update('user', $data);
            $this->common_model->clear_cache();
            move_uploaded_file($_FILES['photo']['tmp_name'], 'uploads/user_image/' .$user_id.'.jpg');
            $this->common_model->clear_cache();
            $this->session->set_flashdata('success', 'Profile information updated.');
            redirect($this->agent->referrer());
        }
        if ($param1 == 'change_password'){
            $password               = md5($this->input->post('password'));
            $new_password           = md5($this->input->post('new_password'));
            $retype_new_password    = md5($this->input->post('retype_new_password'));
            
            $current_password       = $this->db->get_where('user', array(
                'user_id' => $this->session->userdata('user_id')
            ))->row()->password;
            
            if ($current_password == $password && $new_password == $retype_new_password) {
                $this->db->where('user_id', $this->session->userdata('user_id'));
                $this->db->update('user', array(
                    'password' => $new_password
                ));
                $this->session->set_flashdata('success', 'Password changed.');
            }
            elseif ($current_password !=$password ){
                $this->session->set_flashdata('error', 'Old password not correct.');

            } else {
                $this->session->set_flashdata('error', 'Password not match.');
            }
            redirect($this->agent->referrer());
        }
    }

    //universal delete function
    function delete_record(){
        $response           = array();
        $row_id             = $this->input->post('row_id');
        $table_name         = $this->input->post('table_name');
        $table_row_id       =$table_name.'_id';
        $this->db->where($table_row_id , $row_id);
        $query=$this->db->delete($table_name);
        if($query==true){
        $response['status']  = 'success';
        $response['message'] = 'Deleted successfully !';
        }
        else{
        $response['status']  = 'error';
        $response['message'] = 'Unable to delete record ...';
        }        
        echo json_encode($response);
    }
}
