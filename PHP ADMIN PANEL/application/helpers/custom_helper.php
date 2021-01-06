<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');

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

// translation
if ( ! function_exists('trans')):
	function trans($phrase){
        return ucwords(str_replace('_', ' ', $phrase));
  //       $translate_phrase = $phrase;
	 //    $ci =& get_instance();
		// $ci->load->helper('language');
		// $active_language = $ci->language_model->get_active_language();
		// $ci->lang->load('site_lang',$active_language);
		// $ci->config->set_item('language', $active_language);
  //       if($ci->lang->line($phrase) == FALSE):
  //           //$ci->language_model->create_phrase($active_language,$phrase);            
  //       else:
  //           $translate_phrase = $ci->lang->line($phrase,FALSE);
  //       endif;
	 //    return $translate_phrase;
    }
endif;

// configuration helper
if (! function_exists('get_app_config')):
	function get_app_config($title)
    {
    	$ci =& get_instance();
        return $ci->common_model->get_config($title);
    }
endif;

//generate slug
if (!function_exists('str_slug')) {
    function str_slug($str)
    {
        return url_title($str, "-", true);
    }
}