<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
/**
 * BackendPro
 *
 * An open source development control panel written in PHP
 *
 * @package		BackendPro
 * @author		Adam Price
 * @copyright	Copyright (c) 2008, Adam Price
 * @license		http://www.gnu.org/licenses/lgpl.html
 * @link		http://www.kaydoo.co.uk/projects/backendpro
 * @filesource
 */

// ------------------------------------------------------------------------

/**
 * Welcome
 *
 * The default welcome controller
 *
 * @package  	BackendPro
 * @subpackage  Controllers
 */
class User extends Admin_Controller
{
	function User()
	{
		parent::Admin_Controller();
		$this->load->library('validation');
		// Set breadcrumb
		$this->bep_site->set_crumb('Home','http://www.ipa.or.id/convex');
	}	

	function index()
	{
        $this->load->module_model('auth','user_model','users');
        
        $usr = $this->users->getUsers(array('users.id'=>$this->session->userdata('id')));
        
        $usr = $usr->row_array();
        
        $udata = array();
        
        $usr['active'] = ($usr['active'])?'yes':'no';
        $usr['gender'] = ($usr['gender'])?'Male':'Female';

        $udata[] = 'uid:'.$usr['id'];
        $udata[] = 'name:'.$usr['fullname'];
        $udata[] = 'email:'.$usr['email'];
        $udata[] = 'company:'.$usr['company'];
        $udata[] = 'active:'.$usr['active'];
        $udata[] = 'url:http://www.sinaptix.com';
/*
        $udata[] = 'created:'.$usr['created'];
        $udata[] = 'group:'.$usr['group'];        
        $udata[] = 'gender:'.$usr['gender'];
        $udata[] = 'dob:'.$usr['dob'];
        $udata[] = 'street:'.$usr['street'];
        $udata[] = 'city:'.$usr['city'];
        $udata[] = 'zip:'.$usr['zip'];
        $udata[] = 'country:'.$usr['country'];
*/
        $udata = implode("\r\n",$udata);
        
        $data['userdata'] = $usr;
        $data['qrfile'] = $this->_generateQR($this->session->userdata('id').'_qr.jpg',$udata);
        $data['qrpdf'] = $this->session->userdata('id').'_qr.pdf';
        
        $this->_createqrpdf($usr);
        
        
		// Display Page
		$data['header'] = $usr['fullname']."'s Profile";
		$data['page'] = $this->config->item('backendpro_template_admin') . 'user_profile';
		$data['module'] = 'user';
		$this->load->view($this->_container,$data);
	}

	function profile($id = null)
	{
        if(!is_user()){
            redirect('auth/login','location');
        }
        
        if(!is_null($id)){
            if(!check('Administrator',null,false) && !($id == $this->session->userdata('id'))){
                redirect('user/profile','location');
            }
        }
        
        $this->load->module_model('auth','user_model','users');
        $this->load->helper('form','qr_image_helper');
        if(is_user() && $id == null){
            $id = $this->session->userdata('id');
        }

        $usr = $this->users->getUsers(array('users.id'=>$id));

        $usr = $usr->row_array();

        $udata = array();

        $usr['active'] = ($usr['active'])?'yes':'no';
        $usr['gender'] = ($usr['gender'])?'Male':'Female';

        /*

        $udata[] = 'uid:'.$usr['id'];
        $udata[] = 'name:'.$usr['firstname'].' '.$usr['lastname'];
        $udata[] = 'email:'.$usr['email'];
        $udata[] = 'co:'.$usr['company'];

        $udata[] = 'created:'.$usr['created'];
        $udata[] = 'group:'.$usr['group'];        
        $udata[] = 'gender:'.$usr['gender'];
        $udata[] = 'dob:'.$usr['dob'];
        $udata[] = 'street:'.$usr['street'];
        $udata[] = 'city:'.$usr['city'];
        $udata[] = 'zip:'.$usr['zip'];
        $udata[] = 'country:'.$usr['country'];
        $udata = implode("\r\n",$udata);
        */
        $data['user'] = $usr;
        //$udata = $this->_qr_data($data);
        $udata = $this->qrdata($data);
        
        //print $udata;
        //get_avatar($id = null,$folder = 'qr/',$ext='.jpg',$pre = '',$sm = '')
        $data['userdata'] = $usr;
        //$data['userdata']['picture'] = get_avatar($this->session->userdata('id'),$this->config->item('public_folder').'avatar/','.jpg','','_sm');
        $data['userdata']['picture'] = get_avatar($this->session->userdata('id'),$this->config->item('public_folder').'avatar/');
        //$data['qrfile'] = $this->_generateQR($usr['id'].'_qr.png',$udata);
        $data['qrfile'] = $this->_generateBarcode($usr['id'].'_bar.png',$udata);
        $data['qrpdf'] = $this->session->userdata('id').'_qr.pdf';

        //$this->_createqrpdf($usr);
        
        $this->bep_site->set_crumb('Member Profile','user/profile');
        

		// Display Page
		$data['is_print'] = false;
		$data['header'] = "Member Profile";
		$data['page'] = $this->config->item('backendpro_template_admin') . 'register_success';
		$data['module'] = 'user';
		$this->load->view($this->_container,$data);
	}


	function visitor($id = null)
	{
        
        $this->load->module_model('auth','user_model','users');
        $this->load->helper('form','qr_image_helper');

        $usr = $this->users->getVisitors(array('users.id'=>$id));

        $usr = $usr->row_array();
        
        //print_r($usr);

        $udata = array();
        
        /*

        $udata[] = 'uid:'.$usr['id'];
        $udata[] = 'name:'.$usr['firstname'].' '.$usr['lastname'];
        $udata[] = 'email:'.$usr['email'];
        $udata[] = 'co:'.$usr['company'];

        $udata[] = 'created:'.$usr['created'];
        $udata[] = 'group:'.$usr['group'];        
        $udata[] = 'gender:'.$usr['gender'];
        $udata[] = 'dob:'.$usr['dob'];
        $udata[] = 'street:'.$usr['street'];
        $udata[] = 'city:'.$usr['city'];
        $udata[] = 'zip:'.$usr['zip'];
        $udata[] = 'country:'.$usr['country'];
        $udata = implode("\r\n",$udata);
        */
        $data['user'] = $usr;
        //$udata = $this->_qr_data($data);
        $udata = $this->qrdatavis($data);
        
        //print $udata;
        //get_avatar($id = null,$folder = 'qr/',$ext='.jpg',$pre = '',$sm = '')
        $data['userdata'] = $usr;
        //$data['userdata']['picture'] = get_avatar($this->session->userdata('id'),$this->config->item('public_folder').'avatar/','.jpg','','_sm');
        $data['userdata']['picture'] = get_avatar($usr['id'],$this->config->item('public_folder').'avatar/','.jpg','','_vis_sm');
        //$data['qrfile'] = $this->_generateQR($usr['id'].'_vis_qr.png',$udata);
        $data['qrfile'] = $this->_generateBarcode($usr['id'].'_vis_bar.png',$udata);
        $data['qrpdf'] = $this->session->userdata('id').'_qr.pdf';

        //$this->_createqrpdf($usr);
        
        $this->bep_site->set_crumb('Visitor Profile','user/profile');
        

		// Display Page
		$data['is_print'] = false;
		$data['header'] = "Visitor Profile";
		$data['page'] = $this->config->item('backendpro_template_admin') . 'visitor_success';
		$data['module'] = 'user';
		$this->load->view($this->_container,$data);
	}

	
	function _qr_data($data){
        $courses[] = ($data['user']['course_1'] > 0)?1:'_';
		$courses[] = ($data['user']['course_2'] > 0)?2:'_';
		$courses[] = ($data['user']['course_3'] > 0)?3:'_';
		$courses[] = ($data['user']['course_4'] > 0)?4:'_';
		$courses[] = ($data['user']['course_5'] > 0)?5:'_';
		
		$courses = implode('-',$courses);
		
        $udata[] = $data['user']['id'];
        $udata[] = $data['user']['firstname'].' '.$data['user']['lastname'];
        $udata[] = addslashes(str_replace(array('(',')','*','\'','"'),' ',$data['user']['company']));
        $udata[] = $data['user']['conv_id'];
        $udata[] = $data['user']['registrationtype'];
        $udata[] = 'Golf :'.($data['user']['golf'] == 'yes')?'Y':'N';
        $udata[] = 'Gala Dinner :'.($data['user']['galadinner'])?'Y':'N';
        
        $udata[] = $courses;
        
        //print_r($udata);
        $udata = implode("\n",$udata);
        
        return $udata;
    }
	
	function changepass($id){	    
	    
		$fields['password'] = $this->lang->line('userlib_password');
		$fields['confirm_password'] = $this->lang->line('userlib_confirm_password');
		
		$this->validation->set_fields($fields);

		$rules['password'] = 'trim|required|min_length['.$this->preference->item('min_password_length').']|matches[confirm_password]';

		if($this->preference->item('use_registration_captcha'))
		{
			$rules['recaptcha_response_field'] = 'trim|required|valid_captcha';
		}
		$this->validation->set_rules($rules);
		
		$user = $this->user_model->getUsers(array('users.id'=>$id));
		$user = $user->row_array();
		
		$this->bep_site->set_crumb($this->lang->line('userlib_new_password'),'user/changepass');
		
		$data['id'] = $id;
						
		if ( $this->validation->run() === FALSE )
		{
			// Output any errors
			$this->validation->output_errors();
			
    		$this->validation->set_default_value($user);

			$data['captcha'] = ($this->preference->item('use_registration_captcha')?$this->_generate_captcha():'');
    	    
    		$data['header'] = "Change Password - ".$user['fullname'];
    		
    		$data['module'] = 'user';
            $this->load->module_view('user','admin/form_pass_edit',$data);
		}
		else
		{
			// Submit form
			$this->_updatepass($id);
		}
	    
	    
	}
	

    function photobooth(){
        $data['header'] = "Change My Picture";
		$data['page'] = $this->config->item('backendpro_template_admin') . 'upload_avatar';
		$data['module'] = 'user';
		$this->load->view($this->_container,$data);
    }
	
	function changepic(){
        if(!is_user()){
            redirect('auth/login','location');
        }
	    $id=$this->session->userdata['id'];

	    $fields['doupload'] = $this->lang->line('userlib_scene');
		$this->validation->set_fields($fields);	    

	    $rules['doupload'] = 'trim|required';
		$this->validation->set_rules($rules);
		
		$this->bep_site->set_crumb('My Profile','user');
		$this->bep_site->set_crumb("Change My Picture",'user/changepic');
	    
	    if ( $this->validation->run() === FALSE )
		{
			// Output any errors
			$this->validation->output_errors();

			// Display page
    	    
    		$data['header'] = "Change My Picture";
    		$data['page'] = $this->config->item('backendpro_template_admin') . 'upload_avatar';
    		$data['module'] = 'user';
    		$this->load->view($this->_container,$data);
		}
		else
		{
			// Submit form
			$filename = $this->session->userdata['id'];
			
			$result = $this->_do_upload($filename,'avatar');
			
			flashMsg($result['status'],$result['msg']);
			redirect('user/profile','location');
		}
	}

	function changepicvis($id){

	    $fields['doupload'] = $this->lang->line('userlib_scene');
		$this->validation->set_fields($fields);	    

	    $rules['doupload'] = 'trim|required';
		$this->validation->set_rules($rules);
		
		$this->bep_site->set_crumb('Visitor Profile','user/visitor/'.$id);
		$this->bep_site->set_crumb("Change Visitor Picture",'user/changepic');
	    
	    if ( $this->validation->run() === FALSE )
		{
			// Output any errors
			$this->validation->output_errors();

			// Display page
    	    $data['id'] = $id;
    		$data['header'] = "Change Visitor Picture";
    		$data['page'] = $this->config->item('backendpro_template_admin') . 'upload_avatar_vis';
    		$data['module'] = 'user';
    		$this->load->view($this->_container,$data);
		}
		else
		{
			// Submit form
			$filename = $id.'_vis';
			
			$result = $this->_do_upload($filename,'avatar');
			
			flashMsg($result['status'],$result['msg']);
			redirect('user/visitor/'.$id,'location');
		}
	}
	

	function changepicoff($id){

	    $fields['doupload'] = $this->lang->line('userlib_scene');
		$this->validation->set_fields($fields);	    

	    $rules['doupload'] = 'trim|required';
		$this->validation->set_rules($rules);
		
		$this->bep_site->set_crumb('Official Profile','user/visitor/'.$id);
		$this->bep_site->set_crumb("Change Official Picture",'user/changepic');
	    
	    if ( $this->validation->run() === FALSE )
		{
			// Output any errors
			$this->validation->output_errors();

			// Display page
    	    $data['id'] = $id;
    		$data['header'] = "Change Visitor Picture";
    		$data['page'] = $this->config->item('backendpro_template_admin') . 'upload_avatar_vis';
    		$data['module'] = 'user';
    		$this->load->view($this->_container,$data);
		}
		else
		{
			// Submit form
			$filename = $id.'_vis';
			
			$result = $this->_do_upload($filename,'avatar');
			
			flashMsg($result['status'],$result['msg']);
			redirect('user/visitor/'.$id,'location');
		}
	}
	

	
	function pv($id){
	    $this->load->module_model('auth','user_model','users');
	    $this->load->helper('form');
	    $this->bep_assets->load_asset_group('PUBLIC');
		
        $usr = $this->users->getUsers(array('users.id'=>$id));
        $usr = $usr->row_array();
        
	    $this->load->plugin('to_pdf');
        $this->load->helper('file');
        // page info here, db calls, etc.     
        $data['qrfile'] = base_url().'public/qr/'.$usr['id'].'_qr.png';
        $data['userdata'] = $usr;

        $data['userdata']['picture'] = get_avatar($this->session->userdata('id'),$this->config->item('public_folder').'avatar/');

        $data['is_print'] = true;
        $data['header'] = "Member Information";
        $this->load->module_view('user','public/register_success', $data);
	}
	
	function pvis($id){
	    $this->load->module_model('auth','user_model','users');
	    $this->load->helper('form');
	    $this->bep_assets->load_asset_group('PUBLIC');
		
        $usr = $this->users->getVisitors(array('users.id'=>$id));
        $usr = $usr->row_array();
        
	    $this->load->plugin('to_pdf');
        $this->load->helper('file');
        // page info here, db calls, etc.     
        //$data['qrfile'] = base_url().'public/qr/'.$usr['id'].'_qr.png';
        $data['userdata'] = $usr;

        $data['user'] = $usr;
        //$udata = $this->_qr_data($data);
        $udata = $this->qrdatavis($data);
        
        //$data['userdata']['picture'] = get_avatar($this->session->userdata('id'),$this->config->item('public_folder').'avatar/');
        $data['userdata']['picture'] = get_avatar($usr['id'],$this->config->item('public_folder').'avatar/','.jpg','','_vis_sm');
        //$data['qrfile'] = $this->_generateQR($usr['id'].'_vis_qr.png',$udata);
        $data['qrfile'] = $this->_generateBarcode($usr['id'].'_vis_bar.png',$udata);

        $data['is_print'] = true;
        $data['header'] = "Visitor Information";
        $this->load->module_view('user','public/visitor_success', $data);
	}
	
    function pdf()
    {
        $this->load->library('cezpdf');
	    $this->load->module_model('auth','user_model','users');
        
        $id = $this->session->userdata('id');
        
        $usr = $this->users->getUsers(array('users.id'=>$id));
        $usr = $usr->row_array();
        $image = $this->config->item('qrcode_save_path').$usr['id'].'_bar.png';


        $this->cezpdf->ezText('36th IPA Annual Convention & Exhibition 2011', 14, array('justification' => 'left'));
        $this->cezpdf->addPngFromFile($image,0,420,300,300);
        $this->cezpdf->ezText("\n",10);
        $this->cezpdf->ezText($usr['firstname'].' '.$usr['lastname'],12,array('justification'=>'left'));
        $this->cezpdf->ezText($usr['email'],12);
        $this->cezpdf->ezText($usr['company'],12);
        //$this->cezpdf->ezImage($image,10,456,'none'); 
        
        //$image = base_url().'public/qr/'.$usr['id'].'_qr.png';
        
        //print $image;


        $this->cezpdf->ezStream();
        
    }	

    function bookingpdf()
    {
        $this->load->library('cezpdf');
	    $this->load->module_model('auth','user_model','users');
        
        /*
        $id = $this->session->userdata('id');
        
        $usr = $this->users->getUsers(array('users.id'=>$id));
        $usr = $usr->row_array();
        $image = $this->config->item('qrcode_save_path').$usr['id'].'_qr.png';
        */
        
        $this->cezpdf->ezText('Jakarta, 2011');
        $this->cezpdf->ezText("\n",10);
        $this->cezpdf->ezText('Subject: Commitment Letter');
        $this->cezpdf->ezText("\n",10);
        $quad_address = "For the attention of:\n";
        $quad_address .= "Quad MICE\n";
        $quad_address .= "Co-Organizer of the 35th IPA Annual Convention & Exhibition\n";
        $quad_address .= "Jl. Pangeran Antasari no. 16 Paas\n";
        $quad_address .= "Cipete Selatan\n";
        $quad_address .= "Jakarta 12410\n";
        
        $quad_address .= "Dear Sir / Madame,\n";
        $quad_address .= "We confirm our registration for booth space at the 35th IPA Annual Convention &\n";
        $quad_address .= "Exhibition 2011 as specified in your Confirmation Letter:\n";
        
        $this->cezpdf->ezText($quad_address,10);
        
        $booth = "1. Company :\n";
        $booth .= "2. Booth number :\n";
        $booth .= "3. Booth Size :\n";
        
        $this->cezpdf->ezText($booth,10,array('justification'=>'left'));

        $comply = "We have read and shall comply with the provisions set forth related to Payment, Terms and Conditions, and Cancellation policies.";
        $this->cezpdf->ezText($comply,10,array('justification'=>'left'));
        $this->cezpdf->ezText("\n",10);
        $this->cezpdf->ezText('Your sincerely,',10);
        $this->cezpdf->ezText("\n",10);
        $this->cezpdf->ezText("\n",10);
        $this->cezpdf->ezText("\n",10);
        $this->cezpdf->ezText("\n",10);
        $this->cezpdf->ezText("\n",10);
        $this->cezpdf->ezText('(signature, full name, company stamp)',10);

        $this->cezpdf->ezStream();
        
    }	
	
	
	function _do_upload($filename = null,$folder = null)
	{
		
		$result = False;
		
		$this->load->library('upload');
		$this->load->helper('date');
		
		$folder = (is_null($folder))?'video/source/':$folder.'/';
		
		$config['upload_path'] = $this->config->item('public_folder').$folder;
		//$config['file_name'] = $filename;
		$config['overwrite'] = TRUE;	
		if($folder == 'avatar/'){
    		$config['allowed_types'] = 'jpg|png|gif';
		}else{
    		$config['allowed_types'] = '3gp|3gpp|flv|mov|wmv|avi|mpg|mpeg|mp4|mp3|mp2|bzip|tgz|tar.gz|tar|zip|xls|doc|pdf|gif|jpg|png|txt';
		}	
		$config['max_size']	= '100000';
		$config['max_width']  = '4096';
		$config['max_height']  = '4096';
		
		$this->upload->initialize($config);	
		
		if ( ! $this->upload->do_upload('videofile'))
		{
			$result = array('status'=>'error','msg'=>$this->lang->line('userlib_upload_failed').$this->upload->display_errors());
		}	
		else
		{

			$filedata = $this->upload->data('videofile');
			$thumbname = '';

			if($filedata['is_image'] == 1){
				$mediatype ='image';
				$thumbname = 'th_'.$filedata['file_name'];
			}else if(preg_match('/video/',$filedata['file_type']) || $filedata['file_type'] =='application/octet-stream'){
				$mediatype ='video';
			}else if(preg_match('/audio/',$filedata['file_type'])){
				$mediatype ='audio';
			}else if(preg_match('/pdf$/',$filedata['file_name'])){
				$mediatype ='pdf';
			}else if(preg_match('/msword/',$filedata['file_type']) || preg_match('/doc$/',$filedata['file_name'])){
				$mediatype ='word';
			}else{
				$mediatype ='other';
			}

			$datestring = "Y-m-d H:i:s";

			$this->load->library('user_agent');

			$filedata['uid'] = $this->session->userdata('id');
			$filedata['section'] = 'uservideo';
			$filedata['fid'] = $folder;
			$filedata['mediatype'] = $mediatype;
			$filedata['timestamp'] = date($datestring,now());
			$filedata['thumbnail'] = $thumbname;
			$filedata['postvia'] = (is_m())?'mobile':'web';
			$filedata['process'] = 0;
			$filedata['hint'] = '';
			$filedata['title'] = $filedata['file_name'];
			$filedata['scene'] = $this->input->post('scene');
			
			$platform = (is_m())?$this->agent->platform().' on '.$this->agent->mobile():$this->agent->platform();
			$filedata['useragent'] = $this->agent->agent_string().' platform : '.$platform;
			
/*			
			$this->myfiles->deleteFile(array('uid'=>$this->session->userdata('id'),'scene'=>$this->input->post('scene')));
			$this->myfiles->registerFile($filedata);
*/			
			
			if($filedata['is_image']){
                $this->load->library('image_lib');

			    $config['image_library'] = 'gd2';
                $config['source_image'] = $filedata['full_path'];
                $config['create_thumb'] = FALSE;
                $config['maintain_ratio'] = TRUE;
                $config['width'] = 195;
                $config['height'] = 250;
                $config['new_image'] = $filedata['file_path'].$filename.strtolower($filedata['file_ext']);

                $this->image_lib->initialize($config);
                $this->image_lib->resize();
                
                $config['new_image'] = $filedata['file_path'].$filename.'_sm'.strtolower($filedata['file_ext']);
                $config['maintain_ratio'] = FALSE;
                $config['width'] = 70;
                $config['height'] = 70;
                
                $this->image_lib->initialize($config);
                $this->image_lib->resize();
                
			}			

            /*
			// image thumbnailing
			if($filedata['is_image']){

				$thumbname = $this->media_lib->createImageThumbnail($filedata);
				$this->myfiles->updateFile(array('fid'=>$filedata['fid']),array('thumbnail'=>$thumbname));

			}else if($filedata['mediatype'] == 'audio'){

				//get embedded image if any
				//$musicdata = $this->music_lib->getID3tag($filedata['full_path']);

				if(isset($musicdata)){

					//print $musicdata['id3v2']['APIC'][0]['data'];
					if(isset($musicdata['id3v2']['APIC'][0]['data'])){

						$music_pic = $filedata['file_path'].$filedata['raw_name'].'.jpg';

						if (!$handle = fopen($music_pic, 'wb')) {
					         echo "Cannot open file ($music_pic)";
					    }else{
						    // Write $somecontent to our opened file.
						    if (fwrite($handle, $musicdata['id3v2']['APIC'][0]['data']) === FALSE) {
						        echo "Cannot write to file ($music_pic)";
						    }

						    fclose($handle);

							$thumbraw = 'th_'.$filedata['raw_name'];

							$thumbname = $this->media_lib->createImageThumbnailFromFile($music_pic,$thumbraw);

							$this->myfiles->updateFile(array('fid'=>$filedata['fid']),array('thumbnail'=>$thumbname,'music_pic'=>$filedata['raw_name'].'.jpg'));
							$filedata['music_pic'] = $filedata['raw_name'].'.jpg';
					    }

					}else{
					    $filedata['music_pic'] = '';
					}
				}else{
				    $filedata['music_pic'] = '';
				}


			    $converted = $this->media_lib->createAudioThumbnail($filedata);
				$this->myfiles->updateFile(array('fid'=>$filedata['fid']),array('mp3_file'=>$converted['mp3_file'],'3gp_file'=>$converted['3gp_file']));


			}else 
			*/
			
			if($filedata['mediatype'] == 'video'){
			    $this->load->library('media_lib');
			    
			    $videoinfo = $this->media_lib->getVideoInfo($filedata['full_path']);
			    
			    //print_r($videoinfo);

			    $converted = $this->media_lib->createVideoThumbnail($filedata);
				$this->myfiles->updateFile(array('fid'=>$filedata['fid'],'duration'=>$videoinfo['duration'],'seconds'=>$videoinfo['seconds'],'thumbnail'=>$converted['thumbnail'],'flv_file'=>$converted['flv_file'],'3gp_file'=>$converted['3gp_file']),array('raw_name'=>$filedata['raw_name']));
				
				//print $this->db->last_query();
				/*
				if(file_exists($filedata['file_path'].$filedata['raw_name'].'.flv')){
				    @unlink($this->config->item('public_folder').'video/online/'.$filedata['raw_name'].'.flv');
				    copy($filedata['file_path'].$filedata['raw_name'].'.flv',$this->config->item('public_folder').'video/online/'.$filedata['raw_name'].'.flv');
				}
				*/

				if(file_exists($filedata['file_path'].$filedata['raw_name'].'.jpg')){
				    copy($filedata['file_path'].$filedata['raw_name'].'.jpg',$this->config->item('public_folder').'video/thumb/'.$filedata['raw_name'].'.jpg');
				}

				if(file_exists($filedata['file_path'].'th_'.$filedata['raw_name'].'.jpg')){
				    copy($filedata['file_path'].'th_'.$filedata['raw_name'].'.jpg',$this->config->item('public_folder').'video/thumb/th_'.$filedata['raw_name'].'.jpg');
				}
				
				$filedata['duration'] = $videoinfo['duration'];
				$filedata['seconds'] = $videoinfo['seconds'];
				$filedata['thumbnail'] = $converted['thumbnail'];
				$filedata['flv_file'] = $converted['flv_file'];
				$filedata['3gp_file'] = $converted['3gp_file'];
			}
			
			/*
			else if($filedata['mediatype'] == 'pdf'){
			    $input = $filedata['full_path'];
			    $previewfolder = "preview_".time();
			    $outdir = $filedata['file_path'].$previewfolder;
			    mkdir($outdir);
			    $output = $outdir."/page%d.jpg";
			    
			    $rs = $this->preview->PDFtoJPEGSeq($input, $output);
			    
			    $this->myfiles->updateFile(array('fid'=>$filedata['fid']),array('thumbnail'=>$previewfolder));

			}else if($filedata['mediatype'] == 'word'){
			    
			}

            */
			$data['fileuploaded'][] = $filedata;

			$result = array('status'=>'success','msg'=>$this->lang->line('userlib_upload_success'),'path'=>$filedata['fid'],'file'=>$filedata['file_name'],'ext'=>$filedata['file_ext'],'fullpath'=>$filedata['full_path']);
		}

		return $result;

	}	
	
	function _updatepass($id)
	{
		// Build

		/* Additional Infos */
		$data['users']['password'] = $this->userlib->encode_password($this->input->post('password'));

		$this->db->trans_begin();
		// Add user details to DB
		$this->user_model->update('Users',$data['users'],array('id'=>$id));

		if ($this->db->trans_status() === FALSE)
		{
			// Registration failed
			$this->db->trans_rollback();

			flashMsg('error',$this->lang->line('userlib_passwd_failed'));
			
			$data['header'] = "Change User Password";
    		
    		$data['msg'] = 'Failed to Updated Password';
    		$data['module'] = 'user';
            $this->load->module_view('user','admin/changepass_success',$data);
		}
		else
		{
			// User registered
			$this->db->trans_commit();
			$data['header'] = "Change User Password";
    		
    		$data['msg'] = 'Password Updated Successfully';
    		$data['module'] = 'user';
            $this->load->module_view('user','admin/changepass_success',$data);
		}
	}
	
	
	function _createqrpdf($usr){
	    $this->load->plugin('to_pdf');
        $this->load->helper('file');
        // page info here, db calls, etc.     
        $data['qrfile'] = $this->config->item('qrcode_save_path').$usr['id'].'_qr.png';
        $data['userdata'] = $usr;
        $data['is_print'] = false;
        $html = $this->load->module_view('user','public/badge', $data, true);
        write_file($this->config->item('qrcode_save_path').$usr['id'].'_qr.html', $html);
        
        pdf_create($html, $this->session->userdata('id').'_qr.pdf',false,$this->config->item('qrcode_save_path'));
	}
	
	function _generateQR($filename,$data){
	    
        $qrdata = array(
            'd' => $data,
            'e' => $this->config->item('e'),
            's' => $this->config->item('s'),
            'v' => $this->config->item('v'),
            't' => $this->config->item('t'),
            'f' => $filename
        );
        qrencode($qrdata);
        return $filename;
	}

        function _generateBarcode($filename,$data){
                $this->barcode->generateBarcode($filename,$data);
                return $filename;
        }
	
	function ajaxset($type){
	    $val = $this->input->post('update_value');
	    $name = $type;

        $status = $this->user_model->setOffline($name,$val);
	    $html = $val;
	    $msg = 'Update success';

	    //print json_encode(array('result'=>$html,'msg'=>$msg,'status'=>$status));    	    
	    print $html;
	}


	function lockconv($id){
	    $upd = $this->input->post('new_value');
        $result = $this->user_model->update('UserProfiles',array('conv_lock'=>$upd),array('user_id'=>$id));
	    
	    print json_encode(
	            array(
	                    'is_error'=>False,
	                    'error_text'=>'',
	                    'html'=>$this->input->post('new_option_text'),
	                    'lq' => $this->db->last_query()
	                )
	        );
	    
	}

	function locksc($id){
	    $upd = $this->input->post('new_value');
        $result = $this->user_model->update('UserProfiles',array('sc_lock'=>$upd),array('user_id'=>$id));
	    
	    print json_encode(
	            array(
	                    'is_error'=>False,
	                    'error_text'=>'',
	                    'html'=>$this->input->post('new_option_text'),
	                    'lq' => $this->db->last_query()
	                )
	        );
	    
	}

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
    

    function qrdatavis($data){

        $udata[] = $data['user']['id'];
        $udata[] = $data['user']['firstname'].' '.$data['user']['lastname'];
        $udata[] = substr(addslashes(str_replace(array('(',')','*','\'','"'),' ',$data['user']['company'])),0,54);
        $udata[] = $data['user']['conv_id'];
        $udata[] = $data['user']['registrationtype'];
        
        /*
        $udata[] = 'A:'.$info;
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


/* End of file welcome.php */
/* Location: ./modules/welcome/controllers/welcome.php */