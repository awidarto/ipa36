<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
/**
 * BackendPro
 *
 * A website backend system for developers for PHP 4.3.2 or newer
 *
 * @package         BackendPro
 * @author          Adam Price
 * @copyright       Copyright (c) 2008
 * @license         http://www.gnu.org/licenses/lgpl.html
 * @link            http://www.kaydoo.co.uk/projects/backendpro
 * @filesource
 */

// ---------------------------------------------------------------------------

/**
 * Members
 *
 * Allow the user to manage website users
 *
 * @package         BackendPro
 * @subpackage      Controllers
 */
class Import extends Admin_Controller
{
	function Import()
	{
		parent::Admin_Controller();

		$this->load->helper('form');
		$this->load->module_config('register','ipa');
		$this->load->module_library('auth','User_email');

		// Load userlib language
		$this->lang->load('userlib');

		// Set breadcrumb
		$this->bep_site->set_crumb('Import','auth/admin/import');

		// Check for access permission
		//check('Members');

		// Load the validation library
		$this->load->library('validation');

		log_message('debug','BackendPro : Members class loaded');
	}
	
	function index(){
	    if(!is_user()){
            redirect('auth/login','location');
        }
	    $id=$this->session->userdata['id'];

	    $fields['doupload'] = 'xls file ( Excel)';
		$this->validation->set_fields($fields);	    

	    $rules['doupload'] = 'trim|required';
		$this->validation->set_rules($rules);
		
		$this->bep_site->set_crumb('Import Excel File','auth/import');
	    
	    if ( $this->validation->run() === FALSE )
		{
			// Output any errors
			$this->validation->output_errors();

			// Display page
    	    
    		$data['header'] = "Import Excel File";
    		$data['page'] = $this->config->item('backendpro_template_admin') . 'import/form_upload';
    		$data['module'] = 'auth';
    		$this->load->view($this->_container,$data);
		}
		else
		{
			// Submit form
			$filename = $this->session->userdata['id'].time();

			$this->session->set_userdata('picemail', '');
			$this->session->set_userdata('picemail', $this->input->post('picemail'));

			$this->session->set_userdata('picname', '');
			$this->session->set_userdata('picname', $this->input->post('picname'));

			$this->session->set_userdata('company', '');
			$this->session->set_userdata('company', $this->input->post('company'));

			$this->session->set_userdata('companyaddress', '');
			$this->session->set_userdata('companyaddress', $this->input->post('companyaddress'));
			
			$result = $this->_do_upload($filename,'xls');
			
			if($result['status'] == 'error'){
    			flashMsg($result['status'],$result['msg']);
    			redirect('auth/admin/import','location');
			}else{
    			flashMsg($result['status'],$result['msg']);
    			redirect('auth/admin/import/preview/'.$result['file'],'location');
			}
		}
	}

    function preview($file){
        
        $data['file'] = $file;
		
        $file = $this->config->item('public_folder').'xls/'.$file;
        
		// Load the spreadsheet reader library
		$this->load->library('spreadsheet_excel_reader');

		// Set output Encoding.
		//$this->spreadsheet_excel_reader->setOutputEncoding('CP1251');

		@$this->spreadsheet_excel_reader->read($file);

		error_reporting(~E_ALL || ~E_STRICT);
		// Sheet 1
		$xlsdata = @$this->spreadsheet_excel_reader->sheets[0] ;
		
		//validating

        $invalids = array();
        $email_col = 0;
        $dup_email = 0;
        $dup_user = 0;
        
        $validator = array_merge($this->config->item('import_valid_column'),$this->config->item('sc_valid'),$this->config->item('conv_valid'),$this->config->item('ex_valid'));
        for ($i = 2; $i <= $xlsdata['numRows']; $i++) {
    		for ($j = 1; $j <= $xlsdata['numCols']; $j++) {
    		    if($i == 2){
        		    if(!$xlsdata['cells'][$i][$j] == '' && !in_array($xlsdata['cells'][$i][$j],$validator)){
        		        $invalids[] = array('col'=>$j,'val'=>$xlsdata['cells'][$i][$j]);
        		    }
        	        if($xlsdata['cells'][$i][$j] == 'email'){
        	            $email_col = $j;
        	        }
        	        if($xlsdata['cells'][$i][$j] == 'username'){
        	            $user_col = $j;
        	        }
    		    }else if($j == $email_col && $i > 1){
    		        if(!$this->validation->spare_email($xlsdata['cells'][$i][$email_col])){
        		        $dup_email++;
        		    }
    		    }else if($j == $user_col && $i > 1){
    		        if(!$this->validation->spare_username($xlsdata['cells'][$i][$user_col])){
        		        $dup_user++;
        		    }
    		    }
    		}
        }
		
		$data['pic'] = $this->session->userdata('picemail');
		$data['picname'] = $this->session->userdata('picname');
		$data['company'] = $this->session->userdata('company');
	    $data['companyaddress'] = $this->session->userdata('companyaddress');
		$data['invalids'] = $invalids;
		$data['email_col'] = $email_col;
		$data['dup_email'] = $dup_email;
		$data['dup_user'] = $dup_user;
		$data['sheet'] =  $this->spreadsheet_excel_reader->dump(true,true);
		
		$data['xlsdata'] = $xlsdata;

		// Display page
	    
		$data['header'] = "Uploaded Excel Preview";
		$data['page'] = $this->config->item('backendpro_template_admin') . 'import/preview';
		$data['module'] = 'auth';
		$this->load->view($this->_container,$data);
    }
    

    function save($file){
        $file = $this->config->item('public_folder').'xls/'.$file;
        
		// Load the spreadsheet reader library
		$this->load->library('spreadsheet_excel_reader');

		// Set output Encoding.
		//$this->spreadsheet_excel_reader->setOutputEncoding('CP1251');

		@$this->spreadsheet_excel_reader->read($file);

		//error_reporting(E_ALL ^ E_NOTICE);
		error_reporting(~E_ALL || ~E_STRICT);

		// Sheet 1
		$xlsdata = $this->spreadsheet_excel_reader->sheets[0] ;
		
		//required data
	    $picemail = $this->input->post('picemail');
	    $picname = $this->input->post('picname');
	    $affect = $this->input->post('affect');
	    $dupaction = $this->input->post('dupaction');
	    $company = $this->input->post('company');
	    $companyaddress = $this->input->post('companyaddress');

        $picarray = array(
    	    'picemail' => $picemail,
    	    'picname' => $picname,
    	    'company' => $company, 
    	    'companyaddress' => $companyaddress 
        );

		//validating

        $invalids = array();
        $email_col = 0;
        $dup_email = 0;
        $dup_user = 0;
        
        //getting indices
	    $heads = array();

        $validator = array_merge($this->config->item('import_valid_column'),$this->config->item('sc_valid'),$this->config->item('conv_valid'),$this->config->item('ex_valid'));
		
		for ($j = 1; $j <= $xlsdata['numCols']; $j++) {
    	    if(in_array($xlsdata['cells'][2][$j],$validator)){
    	        $heads['main'][$xlsdata['cells'][2][$j]] = $j;
    	        if($xlsdata['cells'][1][$j] == 'email'){
        	        $heads['email'] = $j;
    	        }
    	        if($xlsdata['cells'][1][$j] == 'username'){
        	        $heads['username'] = $j;
    	        }
    	        
    	    }
        }
        //print_r($this->config->item('conv_valid'));
        //print_r($heads);
        
        $regs = array();
        $reg_idx = 0;
        
        for ($i = 3; $i <= $xlsdata['numRows']; $i++) {
            foreach($heads['main'] as $key=>$val){
                $regs[$reg_idx][$key] = $xlsdata['cells'][$i][$val];
            }
            $email = $xlsdata['cells'][$i][ $heads['main']['email'] ];
            
            if(trim($email) == ''){
                unset($regs[$reg_idx]);
            }else{
                if($this->validation->spare_email($email)){
                    $regs[$reg_idx]['action'] = 'insert';
                }else{
                    $regs[$reg_idx]['action'] = 'update';
                }
            }
            $reg_idx++;
        }
        
        //print $affect."\r\n";
        //print $dupaction."\r\n";
        
        $inserts = 0;
        $updates = 0;
        
        $summarydata = array();
        
        foreach($regs as $user){
            //print_r($user);
            //print "\r\n====================\r\n";
    		$data['users']['username'] = $user['username'];
    		$data['users']['group'] = 1;
            
            $user['password'] = 'ipa'.rand(1,1000);
            $data['users']['password'] = $this->userlib->encode_password($user['password']);

    		$data['users']['email'] = $user['email'];
    		$data['users']['created'] = date("Y-m-d H:i:s",time());
    		$data['users']['active'] = 1;
    		
    		$data['user_profiles']['fullname'] = $user['firstname'].' '.$user['lastname'];
    		$data['user_profiles']['firstname'] = $user['firstname'];
    		$data['user_profiles']['lastname'] = $user['lastname'];
    		$data['user_profiles']['gender'] = $user['gender']; 
    		$data['user_profiles']['company'] = $user['company'];
    		$data['user_profiles']['nationality'] = $user['nationality'];
    		$data['user_profiles']['salutation'] = $user['salutation'];

    		$data['user_profiles']['dob'] = $user['dob'];
    		$data['user_profiles']['street'] = $user['street'];
    		$data['user_profiles']['position'] = $user['position'];
    		$data['user_profiles']['street2'] = $user['street2'];
    		$data['user_profiles']['city'] = $user['city'];
    		$data['user_profiles']['zip'] = $user['zip'];
    		$data['user_profiles']['mobile'] = $user['mobile'];
    		$data['user_profiles']['fax'] = $user['fax'];
    		$data['user_profiles']['phone'] = $user['phone'];
    		$data['user_profiles']['country'] = $user['country'];
    		
    		//exhibitor related
    		$data['user_profiles']['exhibitor'] = ($user['exhibitor'] == 'Yes')?1:0;
    		$data['user_profiles']['foc'] = ($user['foc'] == 'Yes')?1:0;
    		$data['user_profiles']['media'] = ($user['media'] == 'Yes')?1:0;

            $total_usd = 0;
            $total_idr = 0;

            //convention

            $rt = strtoupper($user['registertype']);     
            if($rt == 'PO'){
                $user['registertype'] = $this->config->item('member_overseas');
                $user['registrationtype'] = 'Professional Overseas';
                $total_usd += $user['registertype'];
            }                                                    
            if($rt == 'PD'){
                $user['registertype'] = $this->config->item('member_domestic');
                $user['registrationtype'] = 'Professional Domestic';
                $total_idr += $user['registertype'];
            }                                                  
            if($rt == 'SO'){
                $user['registertype'] = $this->config->item('student_overseas');
                $user['registrationtype'] = 'Student Overseas';
                $total_usd += $user['registertype'];
            }                                                      
            if($rt == 'SD'){
                $user['registertype'] = $this->config->item('student_domestic');
                $user['registrationtype'] = 'Student Domestic';
                $total_idr += $user['registertype'];
            }                                                      

            $data['user_profiles']['registertype'] = $user['registertype'];
            $data['user_profiles']['registrationtype'] = $user['registrationtype'];

            if(isset($user['judge'])){                                                             
                $user['judge'] = ($user['judge'] == 'Yes')?'yes':'no';
                $data['user_profiles']['judge'] = $user['judge'];
            }

            if(isset($user['golf'])){                                                             
                $user['golf'] = ($user['golf'] == 'Yes')?$this->config->item('golf_domestic'):0;
                $total_idr += $user['golf'];
                $user['golfcurr'] = 'IDR';
                // must recalc wait list after insert
                $data['user_profiles']['golf'] = $user['golf'];
                $data['user_profiles']['golfcurr'] = $user['golfcurr'];

            }

            if(isset($user['galadinner'])){                                                             
                $user['galadinner'] = ($user['galadinner'] == 'Yes')?$this->config->item('galadinner_domestic'):0;
                $total_idr += $user['galadinner'];
                $user['galadinnercurr'] = 'IDR';

                $data['user_profiles']['galadinner'] = $user['galadinner'];
                $data['user_profiles']['galadinnercurr'] = $user['galadinnercurr'];
            }

            if(isset($user['galadinneraux'])){                                                             
                $user['galadinneraux'] = ($user['galadinneraux'] == 'Yes')?$this->config->item('galadinner_domestic'):0;
                $total_idr += $user['galadinner'];

                $data['user_profiles']['galadinneraux'] = $user['galadinneraux'];
            }

            $user['total_idr'] = $total_idr;
            $user['total_usd'] = $total_usd;

            $data['user_profiles']['total_idr'] = $user['total_idr'];
            $data['user_profiles']['total_usd'] = $user['total_usd'];

            if($user['invoice_address_conv'] != ''){
                $data['user_profiles']['invoice_address_conv'] = $user['invoice_address_conv'];
            }

            //short course
            if($user['member'] == 'Yes'){
                $cindex = 'member';
            }else{
                $cindex = 'non_member';
            }

            $user['course_1'] = ($user['course_1'] == 'Yes')?$this->config->item('course_1_'.$cindex):0;
            $user['course_2'] = ($user['course_2'] == 'Yes')?$this->config->item('course_2_'.$cindex):0;
            $user['course_3'] = ($user['course_3'] == 'Yes')?$this->config->item('course_3_'.$cindex):0;
            $user['course_4'] = ($user['course_4'] == 'Yes')?$this->config->item('course_4_'.$cindex):0;
            $user['course_5'] = ($user['course_5'] == 'Yes')?$this->config->item('course_5_'.$cindex):0;

            $user['total_idr_sc'] = 0;
            $user['total_usd_sc'] = $user['course_1'] + $user['course_2'] + $user['course_3'] + $user['course_4'] + $user['course_5'];
            
            if($user['total_usd_sc'] != 0 || $user['total_idr_sc'] != 0){
                $data['user_profiles']['course_1'] = $user['course_1'];
                $data['user_profiles']['course_2'] = $user['course_2'];
                $data['user_profiles']['course_3'] = $user['course_3'];
                $data['user_profiles']['course_4'] = $user['course_4'];
                $data['user_profiles']['course_5'] = $user['course_5'];
                if($user['invoice_address_sc'] != ''){
                    $data['user_profiles']['invoice_address_sc'] = $user['invoice_address_sc'];
                }
                $data['user_profiles']['total_idr_sc'] = $user['total_idr_sc'];
                $data['user_profiles']['total_usd_sc'] = $user['total_usd_sc'];
            }
                        
            foreach($data['user_profiles'] as $key=>$val){
    		    if(is_null($val)){
    		        unset($data['user_profiles'][$key]);
    		    }
    		}


            if($user['action'] == 'insert'){
                $inserts++;
                //$this->user_model->insert('Users',$data['users']);
                $user_id = $this->user_model->insertUser($data['users']);
        		// Get the auto insert ID
        		//$user_id = $this->db->insert_id();
        		$data['user_profiles']['user_id'] = $user_id;

        		$user['id'] = $user_id;
        		$data['user_profiles']['conv_id'] = $this->_updatenumbersingle($user);
                
                //print_r($data['user_profiles']);
        		$this->user_model->insert('UserProfiles',$data['user_profiles']);

                if($data['user_profiles']['golf'] == $this->config->item('golf_domestic') || $data['user_profiles']['golf'] == $this->config->item('golf_overseas')){
        			$wait = $this->user_model->addWaitList($user_id);
    			}else{
        			$data['user_profiles']['golfwait'] = 0;
    			}

                $this->user_model->update('UserProfiles',$data['user_profiles'],array('user_id'=>$user_id));

    		    if($data['user_profiles']['golf'] == 0 && $data['user_profiles']['golfwait'] == 0){
        			$wait = $this->user_model->recalcWaitList();
    			}
        		
            }
            
            if($user['action'] == 'update' && $dupaction == 'update'){
                $updates++;
                $usr = $this->user_model->getUsers('users.email=\''.$data['users']['email'].'\'');
        		$usr = $usr->row_array();
        		$user['id'] = $usr['id'];
        		$data['user_profiles']['conv_id'] = $this->_updatenumbersingle($user);
        		
                if(isset($data['user_profiles']) && count($data['user_profiles']) > 0){
                    //print_r($data['user_profiles']); 
                    if($data['user_profiles']['golf'] == $this->config->item('golf_domestic') || $data['user_profiles']['golf'] == $this->config->item('golf_overseas')){
            			$wait = $this->user_model->addWaitList($usr['id']);
        			}else{
            			$data['user_profiles']['golfwait'] = 0;
        			}
        			
                    $this->user_model->update('UserProfiles',$data['user_profiles'],array('user_id'=>$usr['id']));

        		    if($data['user_profiles']['golf'] == 0 && $data['user_profiles']['golfwait'] == 0){
            			$wait = $this->user_model->recalcWaitList();
        			}
                }

            }

            $data['action'] = $user['action'];
            $data['users']['password'] = $user['password'];
            
            $summarydata[] = $data;
			
        }//end foreach


        //print "summary data\r\n";
        //print $picemail." | ".$picname."\r\n"; 
        
        //print_r($summarydata);
        

        
        foreach($summarydata as $udata){
            // send to individual
            if($udata['action'] == 'insert'){
                // send notification to each user
                //$this->_sendregistermail($udata,$picarray);
            }

            $edata = $this->_sendnotification($picemail,$picname,$udata);
            
        }
        
        $this->_sendtopic($picemail,$picname,$company,$companyaddress,$summarydata);
        
		$data['inserts_count'] = $inserts;
		$data['updates_count'] = $updates;
		$data['pic'] = $this->session->userdata('picemail');
		$data['invalids'] = $invalids;
		$data['email_col'] = $email_col;
		$data['dup_email'] = $dup_email;
		$data['dup_user'] = $dup_user;
		$data['sheet'] =  $this->spreadsheet_excel_reader->dump(true,true);
		$data['file'] = $file;
		$data['users'] = $regs;
		
		$data['xlsdata'] = $xlsdata;

		// Display page
	    
		$data['header'] = "Excel File Imported";
		$data['page'] = $this->config->item('backendpro_template_admin') . 'import/save';
		$data['module'] = 'auth';
		$this->load->view($this->_container,$data);
    }
    
    
    function _updatenumber(){
        $usr = $this->user_model->getUsers();
		$usr = $usr->result_array();
		$count = 0;
		foreach($usr as $u){
            $conv_id = str_pad($u['id'], 6, "0", STR_PAD_LEFT);
    		
    		$sc_code = ($u['course_1'] == 0)?0:1;
    		$sc_code += ($u['course_2'] == 0)?0:2;
    		$sc_code += ($u['course_3'] == 0)?0:4;
    		$sc_code += ($u['course_4'] == 0)?0:8;
    		$sc_code += ($u['course_5'] == 0)?0:16;

    		$sc_code = str_pad($sc_code, 2, "0", STR_PAD_LEFT);

    		$prefix = $this->config->item('convention_prefix');
            $prefix = ($u['registertype']=='' || is_null($u['registertype']) || $u['registertype'] == 0)?'00':$prefix[$u['registrationtype']];
            
            $conv_code = str_pad($prefix, 2, "0", STR_PAD_RIGHT);
            //print $conv_code."-".$sc_code."-".$conv_id."\r\n";
            
            $conv_id = $conv_code."-".$sc_code."-".$conv_id;
            
            $this->user_model->update('UserProfiles',array('conv_id'=>$conv_id),array('user_id'=>$u['id']));
		}
    }

    function _updatenumbersingle($user){
        $conv_id = str_pad($user['id'], 6, "0", STR_PAD_LEFT);
		
		$sc_code = ($user['course_1'] == 0)?0:1;
		$sc_code += ($user['course_2'] == 0)?0:2;
		$sc_code += ($user['course_3'] == 0)?0:4;
		$sc_code += ($user['course_4'] == 0)?0:8;
		$sc_code += ($user['course_5'] == 0)?0:16;

		$sc_code = str_pad($sc_code, 2, "0", STR_PAD_LEFT);

		$prefix = $this->config->item('convention_prefix');
        $prefix = ($user['registertype']=='' || is_null($user['registertype']) || $user['registertype'] == 0)?'00':$prefix[$user['registrationtype']];
        
        $conv_code = str_pad($prefix, 2, "0", STR_PAD_RIGHT);
        //print $conv_code."-".$sc_code."-".$conv_id."\r\n";
        
        $conv_id = $conv_code."-".$sc_code."-".$conv_id;
        
        return $conv_id;

    }
    
    
    
    function upload(){
        $this->load->library('upload');
        $this->load->helper('date');
        
        $data['emails'] = $this->input->post('email');
        $data['files'] = $this->input->post('pics');
        
        $data['ids'] = array();
        $data['results'] = array();

        foreach($data['emails'] as $email){
            $id = $this->getId($email);
            $data['ids'][] = $id;
        }
        
        $folder = 'avatar';
        
        $index = 0;
                
	    foreach($_FILES as $key => $value){
    		$folder = (is_null($folder))?'video/source/':$folder.'/';
            
            $filename = $data['ids'][$index];
            

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

    		if ( ! $this->upload->do_upload($key)){
    			$data['results'][$index] = array('status'=>'error','msg'=>$this->upload->display_errors());
    		}else{

    			$filedata = $this->upload->data();
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

    			$data['fileuploaded'][] = $filedata;

    			$data['results'][$index] = array('status'=>'success','id'=>$filename,'msg'=>$this->lang->line('userlib_upload_success'),'path'=>$filedata['fid'],'file'=>$filedata['file_name'],'ext'=>$filedata['file_ext'],'fullpath'=>$filedata['full_path']);
    		}
    		
    		$index++;
            
        }
        
        $data['header'] = "Picture File Uploads";
		$data['page'] = $this->config->item('backendpro_template_admin') . 'import/upload';
		$data['module'] = 'auth';
		$this->load->view($this->_container,$data);
    }
    
    function getId($email){
        $usr = $this->user_model->getUsers('users.email=\''.$email.'\'');
		$usr = $usr->row_array();
		return $usr['id'];
    }
	
	function _do_upload($filename = null,$folder = null)
	{

		$result = False;

		$this->load->library('upload');
		$this->load->helper('date');

		$folder = (is_null($folder))?'video/source/':$folder.'/';

		$config['upload_path'] = $this->config->item('public_folder').$folder;
		//print $config['upload_path'];
		//$config['file_name'] = $filename;
		$config['overwrite'] = TRUE;	
		$config['allowed_types'] = 'xl|xls';
		$config['max_size']	= '100000';
		$config['max_width']  = '4096';
		$config['max_height']  = '4096';

		$this->upload->initialize($config);	

		if ( ! $this->upload->do_upload('excelfile'))
		{
			$result = array('status'=>'error','msg'=>$this->lang->line('userlib_upload_failed').$this->upload->display_errors());
		}	
		else
		{

			$filedata = $this->upload->data('excelfile');
			$result = array('status'=>'success','msg'=>$this->lang->line('userlib_upload_success'),'path'=>$filedata['full_path'],'file'=>$filedata['file_name'],'ext'=>$filedata['file_ext'],'fullpath'=>$filedata['full_path']);
		}

		return $result;

	}

	function _sendregistermail($data,$pic){
	    $edata = array(
                'username'=> $data['users']['username'],
                'salutation' => $data['user_profiles']['salutation'],
                'fullname'=> $data['user_profiles']['firstname'].' '.$data['user_profiles']['lastname'],
                'email'=> $data['users']['email'],
                'password'=> $data['users']['password'],
                'picname'=> $pic['picname'],
                'picemail'=> $pic['picemail'],
                'company'=> $pic['company'],
                'companyaddress'=> $pic['companyaddress'],
                'site_name'=>$this->preference->item('site_name'),
                'site_url'=>base_url()
		);

	    $this->user_email->send($data['users']['email'],$this->lang->line('userlib_email_register'),'public/email_register_nopass',$edata);
		
	}

    function _sendtopic($picemail,$picname,$company,$companyaddress,$summarydata){
        //print $address;

        //print_r($summarydata['users']);
        
        $recapdata = array();
        
        for($i = 0;$i < count($summarydata);$i++){
            $rt = array();
            foreach($summarydata[$i]['users'] as $key=>$val){
                $rt[$key] = $val;
            }
            foreach($summarydata[$i]['user_profiles'] as $key=>$val){
                $rt[$key] = $val;
            }
            $recapdata[]=$rt;
        }
        //print_r($recapdata);
        
        $recap = '';
        
        $grand_total_usd_sc = 0;
        $grand_total_idr_sc = 0;
        $grand_total_usd = 0;
        $grand_total_idr = 0;
        
        $this->load->library('parser');
        
        foreach($recapdata as $user){
            
            //print_r($user);
            
    		$street2 = ($user['street2'] =='')?"":"\r\n".$user['street2'];

    		$is_conv = ($user['registrationtype'] == '')?false:true;
    		$is_short = ($user['course_1'] + $user['course_2'] + $user['course_3'] + $user['course_4'] + $user['course_5'] == 0)?false:true;
            
            if($user['foc'] > 0){
                $user['total_usd'] = $user['total_usd'] - $user['registertype'];
                $user['total_idr'] = $user['total_idr'] - $user['registertype'];
            }
            
            $grand_total_usd_sc += $user['total_usd_sc'];
            $grand_total_idr_sc += $user['total_idr_sc'];
            $grand_total_usd += $user['total_usd'];
            $grand_total_idr += $user['total_idr'];
            
            $userdetail = array(
                'fullname'=>$user['fullname']
            );
            
            //convention
            $convention = array(
                'registercurr'=> ($user['registrationtype'] == 'Professional Domestic' || $user['registrationtype'] == 'Student Domestic')?'IDR':'USD',
                'registertype'=> ($user['foc'] == 0)?number_format($user['registertype']):'FoC Exhibitor',
                'registrationtype'=> $user['registrationtype'],
                'judge' => ($user['judge'] == 'yes')?'Yes':'No',
                'golf' => ($user['golf'] == 0)?'No':'IDR '.number_format($user['golf']),
                'golfwait' => ($user['golfwait'] > 0)?'Yes':'No',
                'galadinner' => ($user['galadinner'] == 0)?'No':'IDR '.number_format($user['galadinner']),
                'total_usd' => ($user['foc'] == 0)?number_format($user['total_usd']):'FoC Exhibitor',
                'total_idr' => ($user['foc'] == 0)?number_format($user['total_idr']):'FoC Exhibitor'
            );

            $short = array(
                //short course
                'course_1' => ($user['course_1'] == 0)?'Not Attending':'USD '.$user['course_1'],
                'course_2' => ($user['course_2'] == 0)?'Not Attending':'USD '.$user['course_2'],
                'course_3' => ($user['course_3'] == 0)?'Not Attending':'USD '.$user['course_3'],
                'course_4' => ($user['course_4'] == 0)?'Not Attending':'USD '.$user['course_4'],
                'course_5' => ($user['course_5'] == 0)?'Not Attending':'USD '.$user['course_5'],
                'total_usd_sc' => number_format($user['total_usd_sc']),
                'total_idr_sc' => number_format($user['total_idr_sc'])
            );


            $ex = array(
                //short course
                'exhibitor' => ($user['exhibitor'] == 0)?'No':'Yes',
                'foc' => ($user['foc'] == 0)?'No':'Yes',
                'media' => ($user['media'] == 0)?'No':'Yes'
            );

            
            
            $user_detail = $this->parser->parse('email/user_detail',$userdetail,true);
            $ex_detail = $this->parser->parse('email/exhibitor_detail_cp',$ex,true);

            if($is_conv){
                $convention_detail = $this->parser->parse('email/convention_detail_pic',$convention,true);
            }else{
                $convention_detail = "Not Registered for Convention";
            }

            if($is_short){
                $shortcourse_detail = $this->parser->parse('email/shortcourse_detail_pic',$short,true);
            }else{
                $shortcourse_detail = "Not registered to attend any Short Course";
            }
            
            $recap .= $user_detail."\r\n".$convention_detail."\r\n".$shortcourse_detail."\r\n".$ex_detail;
        }
        
        
        $edata = array(
		        'reg_date'=>date('d-m-Y', time()),
                'company' =>$company,
                'companyaddress'=>$companyaddress,
                'picemail'=>$picemail,
                'picname'=>$picname,
                
                'recapdata' => $recap,
                'grand_total_usd' => number_format($grand_total_usd),
                'grand_total_idr' => number_format($grand_total_idr),
                'grand_total_usd_sc' => number_format($grand_total_usd_sc),
                'grand_total_idr_sc' => number_format($grand_total_idr_sc),
                
                'site_name'=>$this->preference->item('site_name'),
                'site_url'=>base_url()
		);
		
		//print_r($edata);
	    $this->user_email->send($picemail,$this->lang->line('userlib_email_register'),'public/email_pic_digest',$edata);
    }
	
	function _sendnotification($picemail,$picname,$data){
	    
	    //$user = $this->user_model->getUsers(array('users.id'=>$id));
		//$user = $user->row_array();
		
		$user = $data['users'];
		$profile = $data['user_profiles'];
		$user = array_merge($user,$profile);
		
		//print_r($user);
		
		$street2 = ($user['street2'] =='')?"":"\r\n".$user['street2'];
		
		$is_conv = ($user['registrationtype'] == '')?false:true;
		$is_short = ($user['course_1'] + $user['course_2'] + $user['course_3'] + $user['course_4'] + $user['course_5'] == 0)?false:true;

        //convention
        $convention = array(
            'registercurr'=> ($user['registrationtype'] == 'Professional Domestic' || $user['registrationtype'] == 'Student Domestic')?'IDR':'USD',
            'registertype'=> number_format($user['registertype']),
            'registrationtype'=> $user['registrationtype'],
            'judge' => ($user['judge'] == 'yes')?'Yes':'No',
            'golf' => ($user['golf'] == 0)?'No':'Yes',
            'golfwait' => ($user['golfwait'] > 0)?'Yes':'No',
            'galadinner' => ($user['galadinner'] == 0)?'No':'Yes',
            'total_usd' => number_format($user['total_usd']),
            'total_idr' => number_format($user['total_idr'])
        );

        $short = array(
            //short course
            'course_1' => ($user['course_1'] == 0)?'No':'Yes',
            'course_2' => ($user['course_2'] == 0)?'No':'Yes',
            'course_3' => ($user['course_3'] == 0)?'No':'Yes',
            'course_4' => ($user['course_4'] == 0)?'No':'Yes',
            'course_5' => ($user['course_5'] == 0)?'No':'Yes',
            'total_usd_sc' => number_format($user['total_usd_sc']),
            'total_idr_sc' => number_format($user['total_idr_sc'])
        );
        
        $ex = array(
            //exhibitor
            'exhibitor' => ($user['exhibitor'] == 1)?'Yes':'No',
            'foc' => ($user['foc'] == 1)?'Yes':'No',
            'media' => ($user['media'] == 1)?'Yes':'No'
        );

        $this->load->library('parser');
        
        $exhibitor_detail = $this->parser->parse('email/exhibitor_detail_cp',$ex,true);
        
                    
        if($is_conv){
            $convention_detail = $this->parser->parse('email/convention_detail_cp',$convention,true);
        }else{
            $convention_detail = "Not Registered for Convention";
        }

        if($is_short){
            $shortcourse_detail = $this->parser->parse('email/shortcourse_detail_cp',$short,true);
        }else{
            $shortcourse_detail = "Not registered to attend any Short Course";
        }
		
		
		$edata = array(
		        'reg_date'=>date('d-m-Y', time()),
                'username'=> $user['username'],
                'salutation' => $user['salutation'],
                'fullname'=> $user['firstname'].' '.$user['lastname'],
                'company' =>$user['company'],
                'companyaddress'=>$user['street'].$street2."\r\n".$user['city']." ".$user['zip']."\r\n".$user['country'],
                'email'=> $user['email'],
                'conv_id'=> $user['conv_id'],
                'picemail'=>$picemail,
                'picname'=>$picname,
                
                'convention_detail'=>$convention_detail,
                'shortcourse_detail'=>$shortcourse_detail,
                'exhibitor_detail'=>$exhibitor_detail,

                'grand_total_usd' => $user['total_usd_sc'] + $user['total_usd'],
                'grand_total_idr' => $user['total_idr_sc'] + $user['total_idr'],
                
                'site_name'=>$this->preference->item('site_name'),
                'site_url'=>base_url(),
                'email'=>$user['email']
		);
		
		//print_r( $edata);
	    $this->user_email->send($edata['email'],'Convention & Short Courses Registration','public/email_member_bulk',$edata);
	    
	}
	

}