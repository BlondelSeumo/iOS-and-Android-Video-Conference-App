<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

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
 

class Api_v100_model extends CI_Model {
    public  $default_limit  =   18;
    
    function __construct()
    {
        parent::__construct();
    }

    function get_app_config(){

        $response["app_name"]                           = get_app_config("app_name");
        $response["app_mode"]                           = get_app_config("app_mode");
        $response["jitsi_server"]                       = get_app_config("jitsi_server");
        $response["meeting_prefix"]                     = get_app_config("meeting_prefix");
        $response['mandatory_login']                    = (get_app_config("app_mandatory_login") == "true")? true:false;
        $response['allow_unauthorized_meeting_code']    = (get_app_config("allow_unauthorized_meeting_code") == "true")? true:false;
        
        return $response;
    }

    function get_ads_config(){
        // mobile ads config
        $ads_enable                              =   get_app_config("mobile_ads_enable");
        $response['ads_enable']                  =   ($ads_enable =='1')? true:false;
        $response['mobile_ads_network']          =   get_app_config("mobile_ads_network");
        $response['admob_app_id']                =   get_app_config("admob_app_id");
        $response['admob_banner_ads_id']         =   get_app_config("admob_banner_ads_id"); 
        $response['admob_interstitial_ads_id']   =   get_app_config("admob_interstitial_ads_id");
        return $response;
    }
    

    


    // validate login  function
    function validate_user($email   =   '' , $password   =  ''){
        $result = FALSE;
        $credential    =   array(  'email' => $email , 'password' => $password );
        $query = $this->db->get_where('user' , $credential);
        if ($query->num_rows() > 0):
            $result = TRUE;
        endif;    
        return $result;      
    }


    // validate login  function
    function validate_user_by_phone_no($phone   =   ''){
        $result = FALSE;
        $credential    =   array('phone' => $phone );
        $query = $this->db->get_where('user' , $credential);
        if ($query->num_rows() > 0):
            $result = TRUE;
        endif;    
        return $result;      
    }

    // validate email  function
    function user_exist_by_uid($uid   =   ''){
        if($uid =="" || $uid == NULL):
            return false;
        endif;
        $credential     =   array(  'firebase_auth_uid' => $uid);
        $query          =   $this->db->get_where('user' , $credential);
        if ($query->num_rows() > 0):
            return true;
        else:
            return false;
        endif;    
    }

    // validate login  function
    function validate_user_by_id_password($user_id   =   '' , $password   =  ''){
        $result = FALSE;
        $credential    =   array(  'user_id' => $user_id , 'password' => $password );
        $query = $this->db->get_where('user' , $credential);
        if ($query->num_rows() > 0):
            $this->db->where($credential);
            $result = TRUE;
        endif;   
        return $result;      
    }

    function reset_password($email='', $new_password='') {
        $data['password']  = $new_password;
        $this->db->where('email',$email);
        $this->db->update('user',$data);
        $this->load->model('email_model');
        $this->email_model->password_reset_email($email, $new_password);
        return true;
    }

    // validate login  function
    function validate_user_by_id($user_id   =   ''){
        $result = FALSE;
        $credential    =   array(  'user_id' => $user_id);
        $query = $this->db->get_where('user' , $credential);
        if ($query->num_rows() > 0):
            $result = TRUE;
        endif;    
        return $result;      
    }


    // validate login  function
    function validate_user_by_email($email   =   ''){
        $result = FALSE;
        $credential    =   array(  'email' => $email);
        $query = $this->db->get_where('user' , $credential);
        if ($query->num_rows() > 0):
            $this->db->where($credential);
            $result = TRUE;
        endif;    
        return $result;      
    }

    // get user info  function
    function get_user_info($email   =   '' , $password   =  ''){
        $credential    =   array(  'email' => $email , 'password' => $password );
        $result = $this->db->get_where('user' , $credential)->row();   
        return $result;     
    }

    // get user info  function
    function get_user_info_by_phone_no($phone   =   ''){
        $credential    =   array(  'phone' => $phone);
        $result = $this->db->get_where('user' , $credential)->row();   
        return $result;     
    }

    // get user info  function
    function get_user_info_by_uid($uid   =   ''){
        $credential    =   array(  'firebase_auth_uid' => $uid);
        $result = $this->db->get_where('user' , $credential)->row();   
        return $result;     
    }


    // get user info  function
    function get_user_info_by_user_id($user_id=''){
        //$credential     =   array(  'user_id' => $user_id );
        $this->db->where('user_id', $user_id);
        $result         = $this->db->get('user')->row();   
        return $result;     
    }

    // get user info  function
    function get_user_info_by_email($email   =   ''){
        $credential     =   array(  'email' => $email );
        $result         = $this->db->get_where('user' , $credential)->row();   
        return $result;     
    }

    // get user info  function
    function get_user_info_by_phone($phone   =   ''){
        $credential     =   array(  'phone' => $phone );
        $result         = $this->db->get_where('user' , $credential)->row();   
        return $result;     
    }

    // update last login time
    function update_last_login_info_by_user_id($user_id=''){
        $this->db->where('user_id',$user_id);
        $this->db->update('user', array('last_login' => date('Y-m-d H:i:s')));
        return true;
    }


    // get user info  function
    function create_user($name='',$email   =   '' , $password   =  ''){
        $data['name']           = $name;
        $data['email']          = $email;
        $data['password']       = $password;
        $data['meeting_code']   = $this->common_model->generate_meeting_code();
        $data['role']           = 'subscriber';
        $data['join_date']      = date('Y-m-d H:i:s');
        $data['last_login']     = date('Y-m-d H:i:s');
        if($this->db->insert('user', $data)):
            $meeting_data['meeting_title']  = "Personal Meeting ID";
            $meeting_data['meeting_code']   = $data['meeting_code'];
            $meeting_data['user_id']        = $this->db->insert_id();
            $meeting_data['created_at']     = date("Y-m-d H:i:s");
            $this->create_meeting($meeting_data);
        endif;
        return TRUE;     
    }


    // get user info  function
    function create_user_by_firebase_auth_uid($data){
        //$credential    =   array(  'email' => $email , 'password' => $password );        
        if($this->db->insert('user', $data)):
            $meeting_data['meeting_title']  = "Personal Meeting ID";
            $meeting_data['meeting_code']   = $data['meeting_code'];
            $meeting_data['user_id']        = $this->db->insert_id();
            $meeting_data['created_at']     = date("Y-m-d H:i:s");
            $this->create_meeting($meeting_data);
        endif;
        return TRUE;     
    }

    // get user info  function
    function create_user_by_phone_no($data=array()){
        //$credential    =   array(  'email' => $email , 'password' => $password );
        $data['name']           = 'No name set';
        $data['email']          = $phone;
        $data['phone']          = $phone;
        $data['password']       = md5($phone);
        $data['role']           = 'subscriber';
        $data['join_date']      = date('Y-m-d H:i:s');
        $data['last_login']     = date('Y-m-d H:i:s');
        $this->db->insert('user', $data);
        $user_id                = $this->db->insert_id();
        $this->api_subscription_model->create_trial_subscription($user_id);
        return TRUE;     
    }


    function update_profile($user_id   =   '' , $data   =  array()){
        $this->db->where('user_id',$user_id);
        $this->db->update('user' ,$data);  
        return TRUE;     
    }



    // validate email  function
    function check_signup_ability_by_email($email   =   ''){
        $result = TRUE;
        $credential    =   array(  'email' => $email);
        $query = $this->db->get_where('user' , $credential);
        if ($query->num_rows() > 0):
            $result = FALSE;
        endif;    
        return $result;      
    }

    // validate email  function
    function user_exist_by_email($email   =   ''){
        if($email =="" || $email == NULL):
            return false;
        endif;
        if(filter_var($email, FILTER_VALIDATE_EMAIL)):
            $credential     =   array(  'email' => $email);
            $query          =   $this->db->get_where('user' , $credential);
            if ($query->num_rows() > 0):
                return true;
            else:
                return false;
            endif;    
        else:
            return false;
        endif;    
    }

    // validate phone  function
    function user_exist_by_phone($phone   =   ''){
        if($phone =="" || $phone == NULL):
            return false;
        endif;
        $credential     =   array(  'phone' => $phone);
        $query          =   $this->db->get_where('user' , $credential);
        if ($query->num_rows() > 0):
            return true;
        else:
            return false;
        endif;   
    }


    /* meeting
    */

    function create_meeting($data= array(),$history = false){
        $this->db->insert("meeting", $data);
        if($history):
            $history_data['meeting_code']   = $data['meeting_code'];
            $history_data['user_id']        = $data['user_id'];
            $history_data['joined_at']      = $data['created_at'];
            $this->db->insert("meeting_history", $history_data);
        endif;
        return true;
    }

    public function get_meeting_history($user_id='',$page=''){
        $response = array();
        if(!empty($page) && $page !='' && $page !=NULL && is_numeric($page)):
            $offset = ((int)$page *   $this->default_limit)   -   $this->default_limit;
            $this->db->limit($this->default_limit,$offset);
        else:
            $this->db->limit($this->default_limit);
        endif;
        $this->db->where('user_id', $user_id);
        $this->db->order_by('meeting_history_id', 'DESC');
        return $this->db->get('meeting_history')->result_array();
        //var_dump($wish_lists);
        $i                =   0;
        foreach ($wish_lists as $wish_list):
            $validity = $this->varify_videos_id($wish_list['videos_id']);
            if($validity):
                $response[$i]     = $this->get_movie_details_by_id($wish_list['videos_id']);
                $i++;
            endif;            
        endforeach;
        return $response;
    }
}