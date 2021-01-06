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

class Notify_model extends CI_Model {
	
	function __construct()
    {
        parent::__construct();
    }

	function send_notification($data = array())
	{
        $data['message']            =   $data['message'];
        $data['url']                =   $data['url'];
        $data['headings']           =   $data['headings'];
        $data['icon']               =   $data['icon'];         
        $data['img']                =   $data['img'];
        $data['id']                 =   '';
        $data['vtype']              =   '';
        $data['open_with']          =   'web';
        $this->load->model('notify_model');
        $this->send($data);
        return TRUE;
	}   

	function send($data = array()){
		$onesignal_appid    = $this->db->get_where('config' , array('title' =>'onesignal_appid'))->row()->value;
        $onesignal_api_keys = $this->db->get_where('config' , array('title' =>'onesignal_api_keys'))->row()->value; 
        $content = array(
            "en" => $data['message']
        );
        $headings = array(
            "en" => $data['headings']
        );
        $fields = array(
            'app_id'                => $onesignal_appid,
            'included_segments'     => array('All'),
            'url'                   => $data['url'],
            'contents'              => $content,
            'chrome_web_icon'       => $data['icon'],
            'chrome_web_image'      => $data['img'],
            'big_picture'           => $data['img'], // for android
            'small_icon'            => $data['icon'], // for android
            'large_icon'            => $data['icon'], // for android
            'headings'              => $headings,
            // vtype: for movie=movie, for tvseries= tvseries, for live tv=tv
            // open_with: for webview=web, for app=app
            'data'     => array('id'=>$data['id'],'vtype'=>$data['vtype'],'open'=>$data['open_with'],'url'=>$data['url'])
        );

        $fields = json_encode($fields);
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, "https://onesignal.com/api/v1/notifications");
        curl_setopt($ch, CURLOPT_HTTPHEADER, array('Content-Type: application/json; charset=utf-8',
            'Authorization: Basic '.$onesignal_api_keys));
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, TRUE);
        curl_setopt($ch, CURLOPT_HEADER, FALSE);
        curl_setopt($ch, CURLOPT_POST, TRUE);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $fields);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, FALSE);
        $response = curl_exec($ch);
        curl_close($ch);
        return $response;
	}
}

