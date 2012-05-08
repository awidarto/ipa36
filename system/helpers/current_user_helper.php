<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');
/**
 * CodeIgniter
 *
 * An open source application development framework for PHP 4.3.2 or newer
 *
 * @package		CodeIgniter
 * @author		ExpressionEngine Dev Team
 * @copyright	Copyright (c) 2008 - 2009, EllisLab, Inc.
 * @license		http://codeigniter.com/user_guide/license.html
 * @link		http://codeigniter.com
 * @since		Version 1.0
 * @filesource
 */

// ------------------------------------------------------------------------

/**
 * CodeIgniter URL Helpers
 *
 * @package		CodeIgniter
 * @subpackage	Helpers
 * @category	Helpers
 * @author		ExpressionEngine Dev Team
 * @link		http://codeigniter.com/user_guide/helpers/url_helper.html
 */

// ------------------------------------------------------------------------

/**
 * Site URL
 *
 * Create a local URL based on your basepath. Segments can be passed via the
 * first parameter either as a string or an array.
 *
 * @access	public
 * @param	string
 * @return	string
 */
if ( ! function_exists('current_user'))
{
	function current_user($id = null)
	{
		$CI =& get_instance();
		
		if(is_null($id)){
		    return false;
		}else{
    		$CI->load->module_model('auth','user_model');
    		$user = $CI->user_model->getUsersComplete(array('users.id'=>$id), array('limit' => 1));
    		
    		//message box
    		
    		$CI->load->module_model('msg','msgmodel','message');
    		$total_where = sprintf("ci_msgbox.to = %s OR ci_msgbox.from = %s OR ci_msgbox.broadcast = 1",$id,$id);
    		$total_res = $CI->message->getNumberofMsg($total_where);
    		
    		$unread_where = sprintf("(ci_msgbox.to = %s OR ci_msgbox.from = %s OR ci_msgbox.broadcast = 1) AND ci_msgbox.read = 0",$id,$id);
    		$unread_res = $CI->message->getNumberofMsg($unread_where);
            
            $total = $total_res->row()->num;
            $unread = $unread_res->row()->num;
            
            if($user->num_rows() < 0){
                return false;
            }else{
                $userdata = $user->row_array();
                $userdata['msg_count'] = array('total'=>$total,'unread'=>$unread);
        		return $userdata;
            }
		}
	}

}

if ( ! function_exists('user_video'))
{
	function user_video($id = null)
	{
		$CI =& get_instance();
		
		if(is_null($id)){
		    return false;
		}else{
    		$CI->load->module_model('user','filemodel');
    		$CI->load->module_config('user','user');
    		
            for($i = 1;$i< ($CI->config->item('user_video_quota') + 1);$i++){
                if(file_exists($CI->config->item('public_folder').'video/online/'.$id.'_'.$i.'.flv')){
                    clearstatcache();
                    $finfo = stat($CI->config->item('public_folder').'video/online/'.$id.'_'.$i.'.flv');
                    $finfo['filename'] = $id.'_'.$i.'.flv';
                    $result_files[] = $finfo;
                }
            }
            
            
            if(count($result_files) < 0){
                return false;
            }else{
                return $result_files;
            }
/*    		
    		$vids = $CI->myfiles->getFiles(array('uid'=>$id, 'mediatype'=>'video'),array('limit' => $CI->config->item('user_video_quota'), 'offset' => 0));
    		if($vids->num_rows() < 0){
    		    return false;
    		}else{
    		    $vfiles = array();
    		    print_r($vids->result_array());
    		    foreach($vids->result_array() as $vf){
    		        if(file_exists($CI->config->item('public_folder').'video/online/'.$vf['raw_name'].'.flv')){
    		            $vfiles[] = $vf;
    		        }
    		    }
    		    return $vfiles;
    		}
*/
		}
	}
}


if ( ! function_exists('get_avatar'))
{
	function get_avatar($id = null,$folder = 'qr/',$ext='.jpg',$pre = '',$sm = '')
	{
        $CI =& get_instance();
        //print $folder.$pre.$id.$sm.$ext;
        if(!file_exists($folder.$pre.$id.$sm.$ext)){
            return $pre.'nopic'.$sm.'.jpg';
        }else{
            return $pre.$id.$sm.$ext;
        }
	}
}

if ( ! function_exists('get_user_msg_count'))
{
	function get_user_msg_count($id = null)
	{
        $CI =& get_instance();
        
		if(is_null($id)){
		    return false;
		}else{
    		$CI->load->module_model('msg','msgmodel','message');
    		$total_where = sprintf("ci_msgbox.to = %s OR ci_msgbox.from = %s OR ci_msgbox.broadcast = 1",$id,$id);
    		$total_res = $CI->message->getNumberofMsg($total_where);
    		
    		$unread_where = sprintf("(ci_msgbox.to = %s OR ci_msgbox.from = %s OR ci_msgbox.broadcast = 1) AND ci_msgbox.read = 0",$id,$id);
    		$unread_res = $CI->message->getNumberofMsg($unread_where);
            
            $total = $total_res->row()->num;
            $unread = $unread_res->row()->num;
            
            return array('total'=>$total,'unread'=>$unread);
		}
	}
}

if ( ! function_exists('is_m'))
{
	function is_m()
	{
        $CI =& get_instance();
        $CI->load->library('user_agent');
        if($CI->config->item('is_m') || $CI->agent->is_mobile()){
            return true;
        }else{
            return false;
        }
	}
}

if ( ! function_exists('is_i'))
{
	function is_i()
	{
        $CI =& get_instance();
        $CI->load->library('user_agent');
        if($CI->agent->mobile() == 'Apple iPhone' || $CI->agent->mobile() == "Apple iPod Touch" || $CI->config->item('is_i')){
            return true;
        }else{
            return false;
        }
	}
}

if ( ! function_exists('reverse_date'))
{
	function reverse_date($date)
	{
	    //print_r(explode('-',$date));
	    return implode('-',array_reverse(explode('-',$date)));
	}
}

if (! function_exists('qrdata'))
{
    function qrdata($data){

		//$CI =& get_instance();
        
        $courses[] = ($data['user']['course_1'] > 0)?1:'';
		$courses[] = ($data['user']['course_2'] > 0)?2:'';
		$courses[] = ($data['user']['course_3'] > 0)?3:'';
		$courses[] = ($data['user']['course_4'] > 0)?4:'';
		$courses[] = ($data['user']['course_5'] > 0)?5:'';
		
		$courses = implode('',$courses);
		
		//print $data['user']['golf'];
		$info = array();
		
		$info[] = ($data['user']['judge'] > 0)?'JD':'';
		$info[] = ($data['user']['golf'] > 0)?'GF':'';
		$info[] = ($data['user']['galadinner'] > 0)?'GD':'';
		$info[] = ($data['user']['foc'] > 0)?'FoC':'';
		$info[] = ($data['user']['media'] > 0)?'M':'';
		$info[] = ($data['user']['exhibitor'] > 0)?'Ex':'';
		
		$info = implode(' ',$info);
		
        $udata[] = $data['user']['id'];
        $udata[] = $data['user']['firstname'].' '.$data['user']['lastname'];
        $udata[] = substr(addslashes(str_replace(array('(',')','*','\'','"'),' ',$data['user']['company'])),0,54);
        $udata[] = $data['user']['conv_id'];
        $udata[] = $data['user']['registrationtype'];
        
        $udata[] = 'C:'.$courses;
        $udata[] = 'A:'.$info;
        /*
        $udata[] = 'Golf : '.$golf;
        $udata[] = 'Gala Dinner : '.$galadinner;
        $udata[] = 'Exhibitor : '.$exhibitor;
        $udata[] = 'Media : '.$media;
        $udata[] = 'FoC : '.$foc;
        */
        
        //print_r($udata);
        $udata = implode("\n",$udata);
        return $udata;
    }

}


// ------------------------------------------------------------------------