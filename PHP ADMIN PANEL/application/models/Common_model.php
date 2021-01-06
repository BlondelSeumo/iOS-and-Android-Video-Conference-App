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
 

class Common_model extends CI_Model {
	
	function __construct()
    {
        parent::__construct();
    }
		/* clear cache*/	
	function clear_cache()
	{
        $this->output->set_header('Cache-Control: no-store, no-cache, must-revalidate, post-check=0, pre-check=0');
        $this->output->set_header('Pragma: no-cache');
	}
    

    /*
    common functions
    */
		/* get image url */
	function get_img($type = '' , $id = '')
	{
		if(file_exists('uploads/'.$type.'_image/'.$id.'.jpg'))
			$image_url	=	base_url().'uploads/'.$type.'_image/'.$id.'.jpg';
		else
			$image_url	=	base_url().'uploads/user.jpg';
			
		return $image_url;
	}
		/* create and download database backup*/
	function create_backup()
    {
        $this->load->dbutil();  
        $options = array(
                'format'      => 'txt',             
                'add_drop'    => TRUE,              
                'add_insert'  => TRUE,              
                'newline'     => "\n"               
              );
        $tables   = array();
        $file_name  =   'db_backup_'.date('Y-m-d-H-i-s');
        $backup = $this->dbutil->backup(array_merge($options , $tables));
        $this->load->helper('file');
        write_file('db_backup/'.$file_name.'.sql', $backup); 
        //$this->load->helper('download');
        //force_download($file_name.'.sql', $backup);
        return 'done';
    }
	
	
		/* restore database backup*/	
	function restore_backup()
	{
		
		move_uploaded_file($_FILES['backup_file']['tmp_name'], 'uploads/backup.sql');

		$prefs = array(
            'filepath'						=> 'uploads/backup.sql',
			'delete_after_upload'			=> TRUE,
			'delimiter'						=> ';'
        );
		
		$schema = htmlspecialchars(file_get_contents($prefs['filepath']));

		$query = rtrim( trim($schema), "\n;");

		$query_list = explode(";", $query);
		$this->truncate();	
		

        foreach($query_list as $query){
        	$this->db->query($query);
        }
		//$restore =& $this->dbutil->restore($prefs);
        unlink($prefs['filepath']);
	}


   function get_image_url($type = '' , $id = '')
    {
        if(file_exists('uploads/'.$type.'_image/'.$id.'.jpg'))
            $image_url  =   base_url().'uploads/'.$type.'_image/'.$id.'.jpg';
        else
            $image_url  =   base_url().'uploads/user.jpg';
            
        return $image_url;
    }

    function time_ago($datetime, $full = false) {
        $now = new DateTime;
        $ago = new DateTime($datetime);
        $diff = $now->diff($ago);

        $diff->w = floor($diff->d / 7);
        $diff->d -= $diff->w * 7;

        $string = array(
            'y' => 'year',
            'm' => 'month',
            'w' => 'week',
            'd' => 'day',
            'h' => 'hour',
            'i' => 'minute',
            's' => 'second',
        );
        foreach ($string as $k => &$v) {
            if ($diff->$k) {
                $v = $diff->$k . ' ' . $v . ($diff->$k > 1 ? 's' : '');
            } else {
                unset($string[$k]);
            }
        }

        if (!$full) $string = array_slice($string, 0, 1);
        return $string ? implode(', ', $string) . ' ago' : 'just now';
    }

    public function grab_image($file_url,$save_to){

        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $file_url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($ch, CURLOPT_FOLLOWLOCATION, 1);
        curl_setopt($ch, CURLOPT_TIMEOUT, 140);
        curl_setopt($ch, CURLOPT_USERAGENT, "Mozilla/5.0 (Windows; U; Windows NT 6.1; en-US; rv:1.9.2.16) Gecko/20110319 Firefox/3.6.16");
        curl_setopt($ch, CURLOPT_HEADER, 0);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
        curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 2); 
        curl_setopt($ch, CURLOPT_HTTPAUTH, CURLAUTH_ANY);
        $output = curl_exec($ch);
        $file = fopen($save_to, "w+");
        fputs($file, $output);
        fclose($file);
    }
    function get_extension($file) {
     $extension = explode(".", $file);
     $ext = end($extension);
     return $ext ? $ext : 'link';
    }
    function get_filtered_string($string) {
        $string = trim($string);
        $string = preg_replace("/[^ \w]+/", "", $string);
        return $string;
    }
    function pagination(){
        $config['full_tag_open']    = '<ul class ="pagination">';
        $config['full_tag_close']   = '</ul><!--pagination-->';
        $config['first_link']       = '«';
        $config['first_tag_open']   = '<li class="page-item page-link">';
        $config['first_tag_close']  = '</li>';
        $config['last_link']        = '»';
        $config['last_tag_open']    = '<li class="page-item page-link">';
        $config['last_tag_close']   = '</li>';
        $config['next_link']        = '&rarr;';
        $config['next_tag_open']    = '<li class="page-item page-link">';
        $config['next_tag_close']   = '</li>';
        $config['prev_link']        = '&larr;';
        $config['prev_tag_open']    = '<li class="page-item page-link">';
        $config['prev_tag_close']   = '</li>';
        $config['cur_tag_open']     = '<li class="page-item active"><a class="page-link" href="#">';
        $config['cur_tag_close']    = '</a></li>';
        $config['num_tag_open']     = '<li class="page-item page-number">';
        $config['num_tag_close']    = '</li>';
        return $config;
    }

    function formatSizeUnits($bytes)
    {
        if ($bytes >= 1073741824)
        {
            $bytes = number_format($bytes / 1073741824, 2) . ' GB';
        }
        elseif ($bytes >= 1048576)
        {
            $bytes = number_format($bytes / 1048576, 2) . ' MB';
        }
        elseif ($bytes >= 1024)
        {
            $bytes = number_format($bytes / 1024, 2) . ' KB';
        }
        elseif ($bytes > 1)
        {
            $bytes = $bytes . ' bytes';
        }
        elseif ($bytes == 1)
        {
            $bytes = $bytes . ' byte';
        }
        else
        {
            $bytes = '0 bytes';
        }

        return $bytes;
    }
    public function get_config($title=''){
        $result   = $title;
        $query  = $this->db->get_where('config' , array('title'=>$title));
        if($query->num_rows() > 0):
            $result = $query->row()->value;
        else:
            $data['title'] = $title;
            $data['value'] = $title;
            $this->db->insert('config',$data);
        endif;
        return $result;
    }

    


    function generate_random_string($length=12) {
      $str                  = "";
        $characters         = array_merge(range('a','z'), range('0','9'));
        $max                = count($characters) - 1;
        for ($i = 0; $i < $length; $i++) {
            $rand = mt_rand(0, $max);
            $str .= $characters[$rand];
        }
        return $str;
    }

    function get_jitsi_server_domain(){
        $jitsi_server   =   get_app_config("jitsi_server");
        $jitsi_domain   =   preg_replace("(^https?://)", "", $jitsi_server);
        $jitsi_domain   =   preg_replace("(^http?://)", "", $jitsi_domain);
        $jitsi_domain   =   str_replace("/", "", $jitsi_domain);
        return $jitsi_domain;
    }

    public function verify_meeting_code($meeting_code=''){
        if($meeting_code == "" || $meeting_code == NULL):
            return false;
        endif;
        $query  = $this->db->get_where('meeting' , array('meeting_code'=>$meeting_code));
        if($query->num_rows() > 0):
            return true;
        endif;
        return false;
    }

    /*
    user functions
    */

    function get_name_by_id($user_id)
    {
        if($user_id == '0' || $user_id =="" || $user_id==NULL):
            return "Anonymous";
        endif;
        $query  =   $this->db->get_where('user' , array('user_id' => $user_id));
        $res    =   $query->result_array();
        foreach($res as $row)           
            return $row['name'];
    }


    function check_email_username($username='',$email='') {
      $this->db->where('email',$email);
      $this->db->or_where('username',$username);
        $rows = count($this->db->get('user')->result_array());
        if($rows >0){
            return TRUE;
        }
        else{
            return FALSE;
        }  
              
    }

    function check_email($email='') {
        $result = FALSE;
        if($email !='' && $email != NULL):
            $this->db->where('email',$email);
            $rows = $this->db->get('user')->num_rows();
            if($rows > 0):
                $result = TRUE;
            endif;
        endif;
        return $result;              
    }

    function check_token($token='') {
        $this->db->where('token',$token);
        $rows = count($this->db->get('user')->result_array());
        if($rows >0){
            return TRUE;
        }
        else{
            return FALSE;
        }    
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

    public function get_user_num_rows($name='')
    {
        if($name !="" && $name !=NULL):
            $this->db->like("name",$name,"both");
        endif;
        return $this->db->get('user')->num_rows();
    }

    public function get_users($name='',$limit=NULL, $start=NULL)
    {
        if($name !="" && $name !=NULL):
            $this->db->like("name",$name,"both");
        endif;
        $this->db->order_by('user_id',"DESC");
        $this->db->limit($limit,$start);
        return $this->db->get('user')->result_array();
    }

    /*
    Meeting functions
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

    public function get_meeting_num_rows($meeting_code='')
    {
        if($meeting_code !="" && $meeting_code !=NULL):
            $this->db->like("meeting_code",$meeting_code,"both");
        endif;
        return $this->db->get('meeting')->num_rows();
    }

    public function get_meetings($meeting_code='',$limit=NULL, $start=NULL)
    {
        if($meeting_code !="" && $meeting_code !=NULL):
            $this->db->like("meeting_code",$meeting_code,"both");
        endif;
        $this->db->order_by('meeting_id',"DESC");
        $this->db->limit($limit,$start);
        return $this->db->get('meeting')->result_array();
    }

    function get_meeting_info($meeting_code=''){
        $query = $this->db->get_where("meeting",array("meeting_code"=>$meeting_code));
        if($query->num_rows() > 0):
            return $this->db->get_where("meeting",array("meeting_code"=>$meeting_code))->first_row();
        else:
            $meeting_info                   =   new stdClass();
            $meeting_info->meeting_code     =    $meeting_code;
            $meeting_info->meeting_title    = "Anonymous Meeting";
            $meeting_info->user_id          = 0;
            $meeting_info->created_at       = "Unknown";
            return $meeting_info;
        endif;
    }

    function generate_meeting_code($length=10) {
        $str                    = get_app_config("meeting_prefix");
        $characters             = array_merge(range('a','z'), range('A','Z'), range('0','9'));
        $max                    = count($characters) - 1;
        for ($i = 0; $i < $length; $i++) {
            $rand   = mt_rand(0, $max);
            $str   .= $characters[$rand];
        }
        return $str;
    }

    public function get_meeting_history_num_rows($meeting_code='')
    {
        if($meeting_code !="" && $meeting_code !=NULL):
            $this->db->where("meeting_code",$meeting_code);
        endif;
        return $this->db->get('meeting_history')->num_rows();
    }

    public function get_meeting_history($meeting_code='',$limit=NULL, $start=NULL)
    {
        if($meeting_code !="" && $meeting_code !=NULL):
            $this->db->where("meeting_code",$meeting_code);
        endif;
        $this->db->order_by('meeting_history_id',"DESC");
        $this->db->limit($limit,$start);
        return $this->db->get('meeting_history')->result_array();
    }

    function check_availability_to_host_meeting(){
        $app_mode = get_app_config("app_mode");
        if($app_mode == "free"):
            if(get_app_config("app_mandatory_login") != "true"):                
                return true;
            else:
                if($this->session->userdata('login_status') == "1"):
                    return true;
                else:
                    return false;
                endif;
            endif;
        endif;

        if($app_mode == "academic"):
            if($this->session->userdata('login_status') != "1"):                
                return false;
            else:
                if($this->session->userdata('login_type') == "teacher" || $this->session->userdata('login_type') == "admin"):
                    return true;
                else:
                    return false;
                endif;
            endif;
        endif;
        return true;
    }

    function check_availability_to_join_meeting(){
        if(get_app_config("app_mandatory_login") != "true"):                
            return true;
        else:
            if($this->session->userdata('login_status') == "1"):
                return true;
            else:
                return false;
            endif;
        endif;
    }

    function create_meeting_join_history($data = array()){
        $history_data['meeting_code']   = $data['meeting_code'];
        if($data['user_id'] !="" && $data['user_id'] !=NULL):
            $history_data['user_id']        = $data['user_id'];
        endif;

        if($data['nick_name'] !="" && $data['nick_name'] !=NULL):
            $history_data['nick_name']        = $data['nick_name'];
        endif;
        
        $history_data['joined_at']      = date("Y-m-d H:i:s");
        $this->db->insert("meeting_history", $history_data);
    }

    

    // dashboard
    function get_host_meeting_today(){
        $this->db->like("created_at",date("Y-m-d"),"both");
        return $this->db->get('meeting')->num_rows();
    }

    function get_join_meeting_today(){
        $this->db->like("joined_at",date("Y-m-d"),"both");
        return $this->db->get('meeting_history')->num_rows();
    }

    function get_user_login_today(){
        $this->db->like("last_login",date("Y-m-d"),"both");
        return $this->db->get('user')->num_rows();
    }

    function get_total_user(){
        return $this->db->get('user')->num_rows();
    }

    function yearly_join_meeting_chart_data(){
        $year   =    date("Y");
        $data   =   "";
        for ($i=1; $i <13 ; $i++):
            if($i !=1):
                $data .= ',';
            endif;
            if($i <10):
                $i = '0'.$i;
            endif;
            $data .= $this->get_join_meeting_count($year.'-'.$i);
        endfor;
        return $data;
    }

    function get_join_meeting_count($data){
        $this->db->like("joined_at",$data,"both");
        return $this->db->get('meeting_history')->num_rows();
    }

    function yearly_host_meeting_chart_data(){
        $year   =    date("Y");
        $data   =   "";
        for ($i=1; $i <13 ; $i++):
            if($i !=1):
                $data .= ',';
            endif;
            if($i <10):
                $i = '0'.$i;
            endif;
            $data .= $this->get_host_meeting_count($year.'-'.$i);
        endfor;
        return $data;
    }

    function get_host_meeting_count($data){
        $this->db->like("created_at",$data,"both");
        return $this->db->get('meeting')->num_rows();
    }

    function get_days_of_this_month(){
        $days   =   cal_days_in_month(CAL_GREGORIAN,date("m"),date("Y")) + 1;
        $data   =   "";
        for ($i=1; $i <$days ; $i++):
            if($i !=1):
                $data .= ',';
            endif;
            $data .= '"'.$i.' '.date("M").'"';
        endfor;
        return $data;
    }

    function joined_meeting_this_month_chart_data(){
        $days       =   cal_days_in_month(CAL_GREGORIAN,date("m"),date("Y")) + 1;
        $yearmonth  =   date("Y-m");
        $data       =   "";
        for ($i=1; $i <$days ; $i++):
            if($i !=1):
                $data .= ',';
            endif;
            $data .= $this->get_join_meeting_count($yearmonth.'-'.$i);
        endfor;
        return $data;
    }

    function hosted_meeting_this_month_chart_data(){
        $days       =   cal_days_in_month(CAL_GREGORIAN,date("m"),date("Y")) + 1;
        $yearmonth  =   date("Y-m");
        $data       =   "";
        for ($i=1; $i <$days ; $i++):
            if($i !=1):
                $data .= ',';
            endif;
            $data .= $this->get_host_meeting_count($yearmonth.'-'.$i);
        endfor;
        return $data;
    }

}


