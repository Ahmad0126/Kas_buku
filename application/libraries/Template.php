<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Template{
    var $template_data = array();
    function set($name, $value){
        $this->template_data[$name] = $value;
    }

    function load($template = '', $view = '' , $title = '' , $view_data = array(), $return = FALSE){
        $this->CI =& get_instance();
        $this->set('contents', $this->CI->load->view($view, $view_data, TRUE));
        $this->set('title', $title);
        return $this->CI->load->view($template, $this->template_data, $return);
    }

    function notif($message, $warna){
        return '
		<div class="alert alert-'.$warna.' alert-dismissable fade show" role="alert">
			<i class="mdi mdi-exclamation"></i>'.$message.'
		</div>';
    }
}