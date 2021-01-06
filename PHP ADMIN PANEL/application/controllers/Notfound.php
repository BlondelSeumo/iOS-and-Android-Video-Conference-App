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
 
class Notfound extends CI_Controller{
	function __construct() {
        parent::__construct();
        
    }
    
    public function index(){
        $data['page_title']     = '404-Page Not Found'; 
        $this->load->view('admin/404', $data);
    }
}

