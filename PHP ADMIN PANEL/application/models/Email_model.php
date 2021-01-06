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

class Email_model extends CI_Model {
	
	function __construct()
    {
        parent::__construct();
    }

    function test_mail($email = NULL)
	{	
		//var_dump($email,$token);
		$app_name			=	get_app_config("app_name");
		$admin_email		=	get_app_config("contact_email");
		$system_name		=	get_app_config("app_name");
		$email_sub			=	"Test Mail";
		$email_to			=	$email;
		$admin_email_from 	=	NULL;
		$test_message ='Email Configuration is Perfect..';
		$send_mail = $this->send_email($test_message , $email_sub , $email_to, $admin_email_from, $admin_email);			
		if($send_mail==TRUE){
			return TRUE;
		}else{
			return FALSE;
		}
	}

	function account_opening_email($email = '', $password='')
	{	
		$app_name			=	get_app_config("app_name");
		$admin_email		=	get_app_config("contact_email");
		$system_name		=	get_app_config("app_name");
		$email_sub			=	"Welcome to ".$app_name;
		$email_to			=	$email;
		$admin_email_from 	=	NULL;
		include(APPPATH.'views/email_templete/account_opening_email.php');
		//message,subject,to,from,replay_to
		$welcome_mail=$this->send_email($welcome_message , $email_sub , $email_to, $admin_email_from, $admin_email);			
		if($welcome_mail==TRUE){
			return TRUE;
		}else{
			return FALSE;
		}
	}

	function password_reset_email($email = '', $password = '')
	{	
		//var_dump($email,$token);
		$app_name			=	get_app_config("app_name");
		$admin_email		=	get_app_config("contact_email");
		$system_name		=	get_app_config("app_name");
		$email_sub			=	"[IMPORTANT] Password recovery - ".$app_name;
		$email_to			=	$email;
		$admin_email_from 	=	NULL;
		include(APPPATH.'views/email_templete/password_reset_email.php');
		//message,subject,to,from,replay_to
		
		$send_mail = $this->send_email($password_reset_message , $email_sub , $email_to, $admin_email_from, $admin_email);			
		if($send_mail==TRUE){
			return TRUE;
		}else{
			return FALSE;
		}
	}



	//send_email($msg='hello', $sub='test', $to='cvcv@hdfd.com', $from=NULL, $replay_to=NULL)
	/***custom email sender****/
	function send_email($msg='', $sub=NULL, $to=NULL, $from=NULL, $replay_to=NULL)
	{
		
		$config = array();
		$config['useragent']	= "CodeIgniter";
		$protocol		=	get_app_config("protocol");
		if($protocol=='smtp'){
			$config['protocol']		= "smtp";
			$smtp_crypto			=	get_app_config("smtp_crypto");
        	$config['smtp_crypto']	= $smtp_crypto;
        	$smtp_host				=	get_app_config("smtp_host");
        	$config['smtp_host']	= $smtp_host;
        	$smtp_user				=	get_app_config("smtp_user");
        	$config['smtp_user']	= $smtp_user;
        	$smtp_pass				=	get_app_config("smtp_pass");
        	$config['smtp_pass']	= $smtp_pass;
        	$smtp_port				=	get_app_config("smtp_port");
        	$config['smtp_port']	= $smtp_port;
        	$config['smtp_timeout']	= "30";
		}elseif($protocol=='sendmail'){
			$config['protocol']		= "sendmail";
			$config['mailpath']		= "/usr/sbin/sendmail"; // or "/usr/sbin/sendmail" 
		}       
        $config['mailtype']		= 'html';
        $config['charset']		= 'utf-8';
        $config['newline']		= "\r\n";
        $config['wordwrap']		= TRUE;
        $this->load->library('email');
        $this->email->initialize($config);
        if($sub == NULL || $sub =='')
        	$sub = 'No Subject';
		if($from == NULL)
			$from		=	get_app_config("system_email");
		$system_name		=	get_app_config("app_name");
		$this->email->from($from, $system_name);
		$this->email->to($to);
		if($replay_to != NULL)
			$this->email->reply_to($replay_to);
		$this->email->subject($sub);		
		$this->email->message($msg);		
		if($this->email->send()){
			return TRUE;
		}else{
			return FALSE;
		}		
	}
}

