<?php
/**
 * File: controllers/categories_demo.php
 *
 * This demo provides a working example of using nested sets to
 * read and manipulate hierarchical data in Code Igniter
 * Please see the documentation for more info
 *
 * @author Thunder <ravenvelvet@gmail.com>
 * @copyright (c)2007 Thunder
 * @package Nested_sets
 * @subpackage Categories_demo
 */
 
class Scan extends Admin_Controller {

	function Scan()
	{
		parent::Admin_Controller();	
        
	    $this->load->config('media');
	    //check('Scan Media');

        $this->load->library('Eventlog');
	    // Set breadcrumb

        // Load the purpose specific extension model class
        $this->controller = 'media/admin/scan';
        
    }
    
    function index(){

        
        $userdata = $this->_getUser($this->session->userdata('id'));
        
        $this->page->set_crumb('Scan Media Files ','media/admin/scan');
                
        $mediatype = explode("|",$this->preference->item('user_media_types'));
        $mediapath = $this->config->item('absolute_upload_path');
        
        foreach($mediatype as $media){
            $filter = $this->preference->item('allowed_'.$media.'_types');
            if($mediafiles = $this->_getFiles($mediapath,$media,$filter,true)){
                $data['files'][$media] = $mediafiles;
            }else{
                $data['files'][$media] = array();
            }
        }
        
        $data['owners'] = $this->_getUsers('Clients');
        
        $data['userurl'] = $this->preference->item('nano_GCMS_source_web_root').'/'.$userdata['username'];
        
        $data['header'] = 'Media Files';
		$data['action'] = 'List Media files';
        $data['page'] = $this->config->item('backendpro_template_admin') . "scan";
        $data['module'] = 'media';
        $data['controller'] = $this->controller;
        
        $this->load->view($this->_container,$data);
    }
    
    
    function process(){
        $userdata = $this->_getUser($this->session->userdata('id'));
        $this->load->library('media_lib');
        $files = $this->input->post('filename');
        $types = $this->input->post('type');
        $duration = $this->input->post('duration');
        $seconds = $this->input->post('seconds');
        $owners = $this->input->post('owner');
        $title = $this->input->post('title');
        
        $this->load->model('media_model','media');
        if(count($files) == 1 && $files[0] == ""){
            redirect('media/admin/media','location');
        }else if(count($files) > 0){
            for($n = 0;$n < count($files);$n++){
                if($types[$n] == 'video'){
                    $this->media_lib->encodeToFLV($this->config->item('absolute_upload_path').$files[$n],$this->config->item('absolute_media_path').$types[$n].'/'.$files[$n].'.flv');
                    $this->media_lib->makeThumbnail($this->config->item('absolute_upload_path').$files[$n],$this->config->item('absolute_media_path').$types[$n].'/thumb/'.$files[$n].'.jpg');
                    $thumb = $this->media_lib->createImageThumbnailFromFile($this->config->item('absolute_media_path').$types[$n].'/thumb/'.$files[$n].'.jpg',null,100);
                    unlink($this->config->item('absolute_media_path').$types[$n].'/thumb/'.$files[$n].'.jpg');
                    $filename = $this->config->item('absolute_media_path').$types[$n].'/'.$files[$n].'.flv';
                }else{
                    copy($this->config->item('absolute_upload_path').$files[$n],$this->config->item('absolute_media_path').$types[$n].'/'.$files[$n]);
                    $filename = $this->config->item('absolute_media_path').$types[$n].'/'.$files[$n];
                    $thumb = '';
                }
                
                unlink($this->config->item('absolute_upload_path').$files[$n]);
                
                $owner = explode(":",$owners[$n]);
                $insertdata = array(
                            'datecreated'=> date('Y-m-d H:i:s',time()),  	
                        	'filename' => $filename,
                        	'mediatype' => $types[$n], 	
                        	'duration' => $duration[$n],
                        	'seconds' => $seconds[$n],	
                        	'thumbnail' => $thumb,	
                        	'ownerid' => $owner[0],
                        	'ownername' => $owner[1],
                        	'title'=>$title[$n]
                    );
                
                $this->media->insert('Documents',$insertdata);
                
            }
        }
        	    
	    redirect('media/admin/media','location');
        
    }
    
    

    function _getFiles($path,$media,$filter=false,$cleanup = false){
        $files = array();
        if(file_exists($path)){
            if ($handle = opendir($path)) {
                while (false !== ($file = readdir($handle))) {
                    if ($file != "." && $file != "..") {
                        rename($path.'/'.$file,$path.'/'.$this->_cleanPath($file));
                    }
                }
            }
            if ($handle = opendir($path)) {
                while (false !== ($file = readdir($handle))) {
                     if ($file != "." && $file != "..") {
                         if($filter){
                             if(preg_match("/".$filter."/",$file)){
                                 if($media == 'video' or $media == 'audio'){
                                     $fileinfo = $this->_getVideoData($path.'/'.$file);
                                     $f['duration'] = $fileinfo['duration'];
                                     $f['seconds'] =  $fileinfo['seconds'];
                                     $f['name'] = $file;
                                 }else{
                                     $f['duration'] = 0;
                                     $f['seconds'] =  0;
                                     $f['name'] = $file;
                                 }
                                 $files[] = $f;
                             }
                         }else{
                             $f['duration'] = 0;
                             $f['seconds'] =  0;
                             $f['name'] = $file;
                             $files[] = $f;
                         }
                     }
                }
            }
        }else{
            return false; 
        }
        
        if(is_array($files)){
            return $files;
        }else{
            return false;
        }
    }
    
    function _getUser($id){
        $this->load->model('user_model');
        $query = $this->user_model->getUsers(array('users.id'=>$id));
        return $query->row_array();
    }
    
    function _getUsers($groupname){
        $this->load->model('user_model');
        $query = $this->user_model->getUsers(array('groups.name'=>$groupname));
        return $query->result_array();
    }
    
    function _getVideoData($file){
        $this->load->library('media_lib');
        return $this->media_lib->getVideoInfo($file);
    }
    
    function _cleanPath($nodename){
        $path_name = strtolower($nodename);
        $invalids = explode(" ",$this->preference->item('invalid_path_character'));
        
        $path_name = str_replace($invalids,'_',$path_name);
        $path_name = str_replace('@','at',$path_name);
        $path_name = str_replace(" ","_",$path_name);
        
        return $path_name;
    }

}
?>