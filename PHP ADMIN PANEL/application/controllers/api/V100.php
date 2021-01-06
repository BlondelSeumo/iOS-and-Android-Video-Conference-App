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
require(APPPATH.'/libraries/RestController.php');
use chriskacerguis\RestServer\RestController;
class V100 extends RestController{ 
    
	function __construct(){
		parent::__construct();
        $this->load->model('common_model');
        $this->load->model('api_v100_model');
		$this->load->database();
	
   		/*cache controling*/
		$this->output->set_header('Last-Modified: ' . gmdate("D, d M Y H:i:s") . ' GMT');('Cache-Control: no-store, no-cache, must-revalidate, post-check=0, pre-check=0');
        $this->output->set_header('Pragma: no-cache');
        $this->output->set_header("Expires: Mon, 26 Jul 1997 05:00:00 GMT");
	}
    
    // index function
    public function index() {
        echo "Method is not defined.";
    }

    //test api function
    public function test_get() {
        $response['status']               = 'success';
        $response['message']              = 'Rest API is working...';            
        $this->response($response,200);
    }

    // get app config function
    public function config_get() { 
        $response['app_config']           =   $this->api_v100_model->get_app_config();
        $response['ads_config']           =   $this->api_v100_model->get_ads_config();            
        $this->response($response,200);
    }
    // login function
    public function login_post() {
        $email                      =   trim($this->input->post('email'));
        $password                   =   md5(trim($this->input->post('password')));
        if (filter_var($email, FILTER_VALIDATE_EMAIL) && $password !='' && $password !=NULL):            
            $login_status               = $this->api_v100_model->validate_user( $email ,$password);        
            if ($login_status):
                $credential    =   array(  'email' => $email , 'password' => $password,'status'=>'1');
                $query         =    $this->db->get_where("user",$credential);
                if($query->num_rows() > 0):                   
                    $this->db->where($credential);
                    $this->db->update('user', array('last_login' => date('Y-m-d H:i:s')));
                    $user_info              = $this->api_v100_model->get_user_info( $email ,$password);
                    $response['status']     = 'success';
                    $response['user_id']    = $user_info->user_id;
                    $response['name']       = $user_info->name;
                    $response['email']      = $user_info->email;
                    $response['phone']      = $user_info->phone;
                    $response['meeting_code'] = $user_info->meeting_code;
                    $response['image_url']  = $this->common_model->get_image_url('user',$user_info->user_id);
                    $response['gender']     = "Unknown";
                    $response['role']       = $user_info->role;
                    if($user_info->gender =='1'):
                        $response['gender']      = "Male";
                    elseif($user_info->gender =='0'):
                        $response['gender']      = "Female";
                    endif;
                    $response['join_date']  = $user_info->join_date;
                    $response['last_login'] = $user_info->last_login;
                else:
                    $response['status']     = 'error';
                    $response['data']       = 'Your account is disabled.Please contact with system administrator to enable.';
                endif;
            else:
                $response['status']     = 'error';
                $response['data']       = 'Email & username not match.Please try again.';
            endif;
        else:
            $response['status']     = 'error';
            $response['data']       = 'Please enter valid email & password.';
        endif;
        $this->response($response,200);
    }


    // signup function
    public function signup_post() {
        $name                       =   trim($this->input->post('name'));
        $email                      =   trim($this->input->post('email'));
        $password                   =   trim($this->input->post('password'));
        //var_dump($password);
        if (filter_var($email, FILTER_VALIDATE_EMAIL) && $password !='' && $password !=NULL && strlen($password) > 3):
            $md5_password               = md5($password);         
            $signup_ability             = $this->api_v100_model->check_signup_ability_by_email( $email);       
            if ($signup_ability):
                $this->api_v100_model->create_user($name, $email ,$md5_password);
                $this->load->model('email_model');
                $this->email_model->account_opening_email($email, $password);
                $user_info              = $this->api_v100_model->get_user_info( $email ,$md5_password);                        
                $response['status']     = 'success';
                $response['user_id']    = $user_info->user_id;
                $response['name']       = $user_info->name;
                $response['email']      = $user_info->email;
                $response['phone']      = $user_info->phone;
                $response['meeting_code'] = $user_info->meeting_code;
                $response['role']       = $user_info->role;
                $response['image_url']  = $this->common_model->get_image_url('user',$user_info->user_id);
                $response['gender']     = "Unknown";
                if($user_info->gender =='1'):
                    $response['gender']      = "Male";
                elseif($user_info->gender =='0'):
                    $response['gender']      = "Female";
                endif;
                $response['join_date']  = $user_info->join_date;
                $response['last_login'] = $user_info->last_login;
            else:
                $response['status']     = 'error';
                $response['data']       = 'Email already exist.';
            endif;
        else:
            $response['status']     = 'error';
            $response['data']       = 'Please enter valid email & password.';
        endif;
        $this->response($response,200);
    }

    // Get user details by id
    public function user_details_by_user_id_get() {
        $user_id                      =   trim($this->input->get('id'));
        //var_dump($user_id);
        if (is_numeric($user_id) && $user_id !='' && $user_id !=NULL):            
            $is_valid_user_id               = $this->api_v100_model->validate_user_by_id( $user_id);        
            if ($is_valid_user_id):
                $user_info              = $this->api_v100_model->get_user_info_by_user_id($user_id);
                $response['status']     = 'success';
                $response['user_id']    = $user_info->user_id;
                $response['name']       = $user_info->name;
                $response['email']      = $user_info->email;
                $response['image_url']  = $this->common_model->get_image_url('user',$user_info->user_id);
                $response['meeting_code'] = $user_info->meeting_code;
                $response['phone']      = $user_info->phone;
                $response['gender']     = "Unknown";
                $response['role']       = $user_info->role;
                if($user_info->gender =='1'):
                    $response['gender']      = "Male";
                elseif($user_info->gender =='0'):
                    $response['gender']      = "Female";
                endif;
                $response['join_date']  = $user_info->join_date;
                $response['last_login'] = $user_info->last_login;
            else:
                $response['status']     = 'error';
                $response['data']       = 'User ID not found.';
            endif;
        else:
            $response['status']     = 'error';
            $response['data']       = 'Please enter valid user ID.';
        endif;
        $this->response($response,200);
    }


    // Get user details by email
    public function user_details_by_email_get() {                
        $email                      =   trim($this->input->get('email'));
        if (filter_var($email, FILTER_VALIDATE_EMAIL) && $email !='' && $email !=NULL):            
            $is_valid_email               = $this->api_v100_model->validate_user_by_email( $email);        
            if ($is_valid_email):
                $user_info              = $this->api_v100_model->get_user_info_by_email($email);
                $response['status']     = 'success';
                $response['user_id']    = $user_info->user_id;
                $response['name']       = $user_info->name;
                $response['email']      = $user_info->email;
                $response['image_url']  = $this->common_model->get_image_url('user',$user_info->user_id);
                $response['meeting_code'] = $user_info->meeting_code;
                $response['role']       = $user_info->role;
                $response['gender']     = "Unknown";
                if($user_info->gender =='1'):
                    $response['gender']      = "Male";
                elseif($user_info->gender =='0'):
                    $response['gender']      = "Female";
                endif;
                $response['join_date']  = $user_info->join_date;
                $response['last_login'] = $user_info->last_login;
            else:
                $response['status']     = 'error';
                $response['data']       = 'Email not found.';
            endif;
        else:
            $response['status']     = 'error';
            $response['data']       = 'Please enter valid email.';
        endif;            
        $this->response($response,200);
    }

    // update profile function
    public function update_profile_post() {        
        $user_id                    =   trim($this->input->post('id'));
        if (is_numeric($user_id) && $user_id !='' && $user_id !=NULL):            
            $is_valid_user_id               = $this->api_v100_model->validate_user_by_id( $user_id);        
            if ($is_valid_user_id):
                $email                      =   trim($this->input->post('email'));
                if (filter_var($email, FILTER_VALIDATE_EMAIL) && $email !='' && $email !=NULL): 
                    //$user_info              = $this->api_v100_model->get_user_info_by_email($email);
                    $name                       =   trim($this->input->post('name'));
                    $password                   =   trim($this->input->post('password'));
                    $gender                     =   trim($this->input->post('gender'));
                    $phone                      =   trim($this->input->post('phone'));
                    $data['email']              =   $email;
                    if(!empty($name) && $name !='' && $name !=NULL):
                        $data['name']           =   $name;
                    endif;
                    if(!empty($password) && $password !='' && $password !=NULL):
                        $data['password']           =   md5($password);
                    endif;
                    if(!empty($gender) && $gender !='' && $gender !=NULL):
                        if($gender=='Male'):
                            $data['gender']           =   '1';
                        elseif($gender=='Female'):
                            $data['gender']           =   '0';
                        endif;
                    endif;
                    if(!empty($phone) && $phone !='' && $phone !=NULL):
                        $data['phone']           =   $phone;
                    endif;
                    $this->api_v100_model->update_profile($user_id,$data);
                    if(!empty($_FILES['photo']))
                        move_uploaded_file($_FILES['photo']['tmp_name'], 'uploads/user_image/' .$user_id.'.jpg');
                    $response['status']     = 'success';
                    $response['data']       = 'Profile updated successfully.';
                    $user_info              = $this->api_v100_model->get_user_info_by_user_id($user_id);
                    $response['status']     = 'success';
                    $response['user_id']    = $user_info->user_id;
                    $response['name']       = $user_info->name;
                    $response['email']      = $user_info->email;
                    $response['image_url']  = $this->common_model->get_image_url('user',$user_info->user_id);
                    $response['meeting_code'] = $user_info->meeting_code;
                    $response['role']       = $user_info->role;
                    $response['phone']      = $user_info->phone;
                    $response['gender']     = "Unknown";
                    if($user_info->user_id =='1')
                        $response['is_authorized']     = "1";
                    if($user_info->gender =='1'):
                        $response['gender']      = "Male";
                    elseif($user_info->gender =='0'):
                        $response['gender']      = "Female";
                    endif;
                    $response['join_date']  = $user_info->join_date;
                    $response['last_login'] = $user_info->last_login;
                else:
                    $response['status']     = 'error';
                    $response['data']       = 'Please enter valid email.';
                endif;
            else:
                $response['status']     = 'error';
                $response['data']       = 'User ID not found.';
            endif;
        else:
        $response['status']     = 'error';
        $response['data']       = 'Please enter valid user ID.';
        endif;           
        $this->response($response,200);
    }

     // deactivate account function
    public function deactivate_account_post() {        
        $user_id                    =   trim($this->input->post('id'));
        $reason                     =   trim($this->input->post('reason'));
        if ($reason !='' && $reason !=NULL):
            $credential    =   array('user_id' => $user_id);
            $query = $this->db->get_where('user',$credential);
            if($query->num_rows() > 0):
                $this->db->where($credential);
                $this->db->update('user', array('status' => '0','deactivate_reason'=>$reason));
                $response['status']     = 'success';
                $response['data']       = 'Account successfully deactivated.';
            else:
                $response['status']     = 'error';
                $response['data']       = 'Please send valid user ID';
            endif;
        else:
            $response['status']     = 'error';
            $response['data']       = 'Please enter user ID & password.';
        endif;            
        $this->response($response,200);
    }
    // password reset function
    public function password_reset_post() {        
        $email                      =   trim($this->input->post('email'));
        //var_dump($password);
        if (filter_var($email, FILTER_VALIDATE_EMAIL)):         
            $user_exist             = $this->common_model->check_email($email);
            if($user_exist):
                $new_password           = $this->common_model->generate_random_string(6);                
                $this->load->model('email_model');
                if($this->email_model->password_reset_email($email,$new_password)):
                    $this->api_v100_model->reset_password($email,$new_password);
                    $response['status']     = 'success';
                    $response['message']    = 'Check you email.We have sent your password through email.';
                else:
                    $response['status']     = 'error';
                    $response['message']    = 'Unable to reset password. Your server might not be configured to send mail.Please contact with system administrator';
                endif;
                
            else:
                $response['status']     = 'error';
                $response['data']       = 'Email not registered.';
            endif;
        else:
            $response['status']     = 'error';
            $response['message']    = 'Please enter valid email.';
        endif;            
        $this->response($response,200);
    }

    // login function
    public function firebase_auth_post() {        
        $uid                      =   trim($this->input->post('uid'));
        $email                    = $this->input->post('email'); 
        $phone                    = $this->input->post('phone'); 
        if($uid !='' && $uid !=NULL):         
            $fire_base_auth_id    = $this->api_v100_model->user_exist_by_uid($uid);
            $user_exist_by_email  = $this->api_v100_model->user_exist_by_email($email);        
            $user_exist_by_phone  = $this->api_v100_model->user_exist_by_phone($phone);        
            if($fire_base_auth_id):
                $user_info              = $this->api_v100_model->get_user_info_by_uid($uid);
                if($user_info->status == '1'):
                    $this->api_v100_model->update_last_login_info_by_user_id($user_info->user_id);
                    $response['status']     = 'success';
                    $response['user_id']    = $user_info->user_id;
                    $response['name']       = $user_info->name;
                    $response['email']      = $user_info->email;
                    $response['phone']      = $user_info->phone;
                    $response['meeting_code'] = $user_info->meeting_code;
                    $response['image_url']  = $this->common_model->get_image_url('user',$user_info->user_id);
                    $response['gender']     = "Unknown";
                    if($user_info->gender =='1'):
                        $response['gender']      = "Male";
                    elseif($user_info->gender =='0'):
                        $response['gender']      = "Female";
                    endif;
                    $response['join_date']  = $user_info->join_date;
                    $response['last_login'] = $user_info->last_login;
                else:
                    $response['status']     = 'error';
                    $response['message']    = 'Account may be block or disabled..';
                endif;
            elseif($user_exist_by_email):
                $user_info              = $this->api_v100_model->get_user_info_by_email($email);
                if($user_info->status == '1'):
                    $this->api_v100_model->update_last_login_info_by_user_id($user_info->user_id);
                    $response['status']     = 'success';
                    $response['user_id']    = $user_info->user_id;
                    $response['name']       = $user_info->name;
                    $response['email']      = $user_info->email;
                    $response['phone']      = $user_info->phone;
                    $response['meeting_code'] = $user_info->meeting_code;
                    $response['image_url']  = $this->common_model->get_image_url('user',$user_info->user_id);
                    $response['gender']     = "Unknown";
                    if($user_info->gender =='1'):
                        $response['gender']      = "Male";
                    elseif($user_info->gender =='0'):
                        $response['gender']      = "Female";
                    endif;
                    $response['join_date']  = $user_info->join_date;
                    $response['last_login'] = $user_info->last_login;
                else:
                    $response['status']     = 'error';
                    $response['message']    = 'Account may be block or disabled..';
                endif;
            elseif($user_exist_by_phone):
                $user_info              = $this->api_v100_model->get_user_info_by_phone($phone);
                if($user_info->status == '1'):
                    $this->api_v100_model->update_last_login_info_by_user_id($user_info->user_id);
                    $response['status']     = 'success';
                    $response['user_id']    = $user_info->user_id;
                    $response['name']       = $user_info->name;
                    $response['email']      = $user_info->email;
                    $response['phone']      = $user_info->phone;
                    $response['meeting_code'] = $user_info->meeting_code;
                    $response['image_url']  = $this->common_model->get_image_url('user',$user_info->user_id);
                    $response['gender']     = "Unknown";
                    if($user_info->gender =='1'):
                        $response['gender']      = "Male";
                    elseif($user_info->gender =='0'):
                        $response['gender']      = "Female";
                    endif;
                    $response['join_date']  = $user_info->join_date;
                    $response['last_login'] = $user_info->last_login;
                else:
                    $response['status']     = 'error';
                    $response['message']    = 'Account may be block or disabled..';
                endif;
            else:
                $name = $this->input->post('name');
                if($name =='' || $name == NULL):
                    $name = 'No name set';
                endif;                
                if($email =='' || $email == NULL):
                    $email = $uid;
                endif;

                $phone = $this->input->post('phone');
                if($phone =='' || $phone == NULL):
                    $phone = '00000000000';
                endif;

                $gender = strtolower($this->input->post('gender'));
                if($gender =='' || $gender == NULL):
                    $gender = '1';
                elseif($gender == 'male'):
                    $gender = '1';
                elseif($gender =='female'):
                    $gender = '0';
                endif;

                $firebase_data['name']               = $name;
                $firebase_data['email']              = $email;
                $firebase_data['phone']              = $phone;
                $firebase_data['gender']             = $gender;
                $firebase_data['password']           = md5($uid);
                $firebase_data['meeting_code']       = $this->common_model->generate_meeting_code();
                $firebase_data['firebase_auth_uid']  = $uid;
                $firebase_data['role']               = 'subscriber';
                $firebase_data['join_date']          = date('Y-m-d H:i:s');
                $firebase_data['last_login']         = date('Y-m-d H:i:s');
                $this->api_v100_model->create_user_by_firebase_auth_uid($firebase_data);
                $user_info              = $this->api_v100_model->get_user_info_by_uid($uid);
                $image_source           =   $this->input->post('image_url');
                if($image_source !='' && $image_source !=NULL):
                    $save_to                =   'uploads/user_image/' .$user_info->user_id.'.jpg';          
                    $this->common_model->grab_image($image_source,$save_to);
                endif;
                //var_dump($user_info);                     
                $response['status']     = 'success';
                $response['user_id']    = $user_info->user_id;
                $response['name']       = $user_info->name;
                $response['email']      = $user_info->email;
                $response['phone']      = $user_info->phone;
                $response['meeting_code'] = $user_info->meeting_code;
                $response['image_url']  = $this->common_model->get_image_url('user',$user_info->user_id);
                $response['gender']     = "Unknown";
                if($user_info->gender =='1'):
                    $response['gender']      = "Male";
                elseif($user_info->gender =='0'):
                    $response['gender']      = "Female";
                endif;
                $response['join_date']  = $user_info->join_date;
                $response['last_login'] = $user_info->last_login;
            endif;
        else: 
            $response['status']     = 'error';
            $response['message']    = 'Firebase UID is required.';
        endif;            
        $this->response($response,200);
    }

    function create_meetting_post(){
        $user_id                  =   $this->input->post('user_id');
        $meeting_code             =   $this->input->post('meeting_code');        
        $meeting_title            =   $this->input->post('meeting_title');
        if(empty($meeting_title) || $meeting_title =='' || $meeting_title ==NULL):
            $meeting_title        = "Untitled";
        endif;        
        if(empty($user_id) || $user_id =='' || $user_id ==NULL):
            $user_id             = 0;
        endif;
        if(!empty($meeting_code) && $meeting_code !='' && $meeting_code !=NULL):
            if(get_app_config("app_mandatory_login") == "true"):
                $is_valid_user_id         = $this->api_v100_model->validate_user_by_id($user_id);        
                if($is_valid_user_id):
                    $data['meeting_title']  = $meeting_title;
                    $data['meeting_code']   = $meeting_code;
                    $data['user_id']        = $user_id;
                    $data['created_at']     = date("Y-m-d H:i:s");
                    $this->api_v100_model->create_meeting($data); 

                    $response['status']     = 'success';
                    $response['message']    = 'Meeting created.';
                else:
                    $response['status']     = 'error';
                    $response['message']    = 'Invalid user ID.Login again then try.';
                endif;
            else:
                $data['meeting_title']  = $meeting_title;
                $data['meeting_code']   = $meeting_code;
                $data['user_id']        = $user_id;
                $data['created_at']     = date("Y-m-d H:i:s");
                $this->api_v100_model->create_meeting($data);

                $response['status']     = 'success';
                $response['message']    = 'Meeting created.';

            endif;
        else:
            $response['status']     = 'error';
            $response['message']    = 'Invalid meeting code.';
        endif;            
        $this->response($response,200);
    }

    function join_meetting_post(){
        $user_id                  =   $this->input->post('user_id');
        $meeting_code             =   $this->input->post('meeting_code');
        $nick_name                =   $this->input->post('nick_name');        
        if(empty($user_id) || $user_id =='' || $user_id ==NULL):
            $user_id             = 0;
        endif;

        $history_data['user_id']            =   $user_id;
        $history_data['meeting_code']       =   $meeting_code;
        $history_data['nick_name']          =   $nick_name;

        if(!empty($meeting_code) && $meeting_code !='' && $meeting_code !=NULL):
            if(get_app_config("allow_unauthorized_meeting_code") != "true"):
                $verify_meeting_code         = $this->common_model->verify_meeting_code($meeting_code);        
                if($verify_meeting_code):
                    // create history
                    $this->common_model->create_meeting_join_history($history_data); 

                    $response['status']     = 'success';
                    $response['message']    = 'Meeting joined.';
                else:
                    $response['status']     = 'error';
                    $response['message']    = 'Unauthorize meeting ID not allowed by system.';
                endif;
            else:
                // create history
                $this->common_model->create_meeting_join_history($history_data); 

                $response['status']     = 'success';
                $response['message']    = 'Meeting joined.';

            endif;
        else:
            $response['status']     = 'error';
            $response['message']    = 'Invalid meeting code.';
        endif;            
        $this->response($response,200);
    }


    function create_and_join_meetting_post(){
        $user_id                  =   $this->input->post('user_id');
        $meeting_code             =   $this->input->post('meeting_code');        
        $meeting_title            =   $this->input->post('meeting_title');
        if(empty($meeting_title) || $meeting_title =='' || $meeting_title ==NULL):
            $meeting_title        = "Untitled";
        endif;        
        if(empty($user_id) || $user_id =='' || $user_id ==NULL):
            $user_id             = 0;
        endif;
        if(!empty($meeting_code) && $meeting_code !='' && $meeting_code !=NULL):
            if(get_app_config("app_mandatory_login") == "true"):
                $is_valid_user_id         = $this->api_v100_model->validate_user_by_id($user_id);        
                if($is_valid_user_id):
                    $data['meeting_title']  = $meeting_title;
                    $data['meeting_code']   = $meeting_code;
                    $data['user_id']        = $user_id;
                    $data['created_at']     = date("Y-m-d H:i:s");
                    $this->api_v100_model->create_meeting($data,true);                    

                    $response['status']     = 'success';
                    $response['message']    = 'Meeting created.';
                else:
                    $response['status']     = 'error';
                    $response['message']    = 'Invalid user ID.Login again then try.';
                endif;
            else:
                $data['meeting_title']  = $meeting_title;
                $data['meeting_code']   = $meeting_code;
                $data['user_id']        = $user_id;
                $data['created_at']     = date("Y-m-d H:i:s");
                $this->api_v100_model->create_meeting($data,true); 

                $response['status']     = 'success';
                $response['message']    = 'Meeting created.';

            endif;
        else:
            $response['status']     = 'error';
            $response['message']    = 'Invalid meeting code.';
        endif;            
        $this->response($response,200);
    }

    // get favorite function
    public function meeting_history_by_user_id_get() {        
        $user_id                  =   $this->input->get('user_id');
        if(!empty($user_id) && $user_id !='' && $user_id !=NULL && is_numeric($user_id)):
            $page               =   $this->input->get('page');
            $response           =   $this->api_v100_model->get_meeting_history($user_id,$page);
        else:
            $response['status']     = 'error';
            $response['message']    = 'Invalid user id.';
        endif;            
        $this->response($response,200);
    }

    // get privacy policy
    public function privacy_policy_get() {
        $response['status']                 = 'success';
        $response['privacy_policy_text']    = get_app_config("privacy_policy_text");           
        $this->response($response,200);
    }

}
    
