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

		$this->spreadsheet_excel_reader->read($file);

		error_reporting(E_ALL ^ E_NOTICE);

		// Sheet 1
		$xlsdata = $this->spreadsheet_excel_reader->sheets[0] ;
		
		//validating

        $invalids = array();
        $email_col = 0;
        $dup_email = 0;
        $dup_user = 0;
        
        $validator = array_merge($this->config->item('import_valid_column'),$this->config->item('sc_valid'),$this->config->item('conv_valid'),$this->config->item('ex_valid'));
        for ($i = 1; $i <= $xlsdata['numRows']; $i++) {
    		for ($j = 1; $j <= $xlsdata['numCols']; $j++) {
    		    if($i == 1){
        		    if(!$xlsdata['cells'][1][$j] == '' && !in_array($xlsdata['cells'][1][$j],$validator)){
        		        $invalids[] = array('col'=>$j,'val'=>$xlsdata['cells'][1][$j]);
        		    }
        	        if($xlsdata['cells'][1][$j] == 'email'){
        	            $email_col = $j;
        	        }
        	        if($xlsdata['cells'][1][$j] == 'username'){
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
		$data['invalids'] = $invalids;
		$data['email_col'] = $email_col;
		$data['dup_email'] = $dup_email;
		$data['dup_user'] = $dup_user;
		$data['sheet'] =  $this->spreadsheet_excel_reader->dump(true,true);
		
		$data['xlsdata'] = $xlsdata;
        /*
		print_r($this->spreadsheet_excel_reader);
		for ($i = 1; $i <= $data['numRows']; $i++) {
			for ($j = 1; $j <= $data['numCols']; $j++) {
				echo "\"".$data['cells'][$i][$j]."\",";
			}
			echo "<br />";
		}
		*/

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

		$this->spreadsheet_excel_reader->read($file);

		error_reporting(E_ALL ^ E_NOTICE);

		// Sheet 1
		$xlsdata = $this->spreadsheet_excel_reader->sheets[0] ;
		
		//required data
	    $picemail = $this->input->post('picemail');
	    $picname = $this->input->post('picname');
	    $affect = $this->input->post('affect');
	    $dupaction = $this->input->post('dupaction');

		//validating

        $invalids = array();
        $email_col = 0;
        $dup_email = 0;
        $dup_user = 0;
        
        //getting indices
	    $heads = array();

        $validator = array_merge($this->config->item('import_valid_column'),$this->config->item('sc_valid'),$this->config->item('conv_valid'),$this->config->item('ex_valid'));
		
		for ($j = 1; $j <= $xlsdata['numCols']; $j++) {
    	    if(in_array($xlsdata['cells'][1][$j],$validator)){
    	        $heads['main'][$xlsdata['cells'][1][$j]] = $j;
    	        if($xlsdata['cells'][1][$j] == 'email'){
        	        $heads['email'] = $j;
    	        }
    	        if($xlsdata['cells'][1][$j] == 'username'){
        	        $heads['username'] = $j;
    	        }
    	        
    	    }

    	    if(in_array($xlsdata['cells'][1][$j],$this->config->item('sc_valid'))){
    	        $heads['sc'][$xlsdata['cells'][1][$j]] = $j;
    	    }

    	    if(in_array($xlsdata['cells'][1][$j],$this->config->item('conv_valid'))){
    	        $heads['conv'][$xlsdata['cells'][1][$j]] = $j;
    	    }

    	    if(in_array($xlsdata['cells'][1][$j],$this->config->item('ex_valid'))){
    	        $heads['ex'][$xlsdata['cells'][1][$j]] = $j;
    	    }
        }
        //print_r($this->config->item('conv_valid'));
        //print_r($heads);
        
        $inserts = array();
        $updates = array();
        
        for ($i = 2; $i <= $xlsdata['numRows']; $i++) {
            $email = $xlsdata['cells'][$i][ $heads['email'] ];
            if($this->validation->spare_email($email)){
                //insert
                $arr = array();
                foreach($this->config->item('import_valid_column') as $main){
                    $arr[$main] = $xlsdata['cells'][$i][ $heads['main'][$main] ];
                }
                
                if(isset($heads['sc'])){
                    foreach($this->config->item('sc_valid') as $main){
                        $arr[$main] = $xlsdata['cells'][$i][ $heads['sc'][$main] ];
                    }
                }

                if(isset($heads['ex'])){
                    foreach($this->config->item('ex_valid') as $main){
                        $arr[$main] = $xlsdata['cells'][$i][ $heads['ex'][$main] ];
                    }
                }

                if(isset($heads['conv'])){
                    foreach($this->config->item('conv_valid') as $main){
                        $arr[$main] = $xlsdata['cells'][$i][ $heads['conv'][$main] ];
                    }
                }
                
                $arr['password'] = 'ipa123456';
                
                $inserts[] = $arr;
            }else{
                //update
                if($dupaction == 'update'){
                    if($affect == 'all'){
                        $arr = array();
                        foreach($this->config->item('import_valid_column') as $main){
                            $arr[$main] = $xlsdata['cells'][$i][ $heads['main'][$main] ];
                        }
                        
                        if(isset($heads['sc'])){
                            foreach($this->config->item('sc_valid') as $main){
                                $arr[$main] = $xlsdata['cells'][$i][ $heads['sc'][$main] ];
                            }
                        }

                        if(isset($heads['ex'])){
                            foreach($this->config->item('ex_valid') as $main){
                                $arr[$main] = $xlsdata['cells'][$i][ $heads['ex'][$main] ];
                            }
                        }

                        if(isset($heads['conv'])){
                            foreach($this->config->item('conv_valid') as $main){
                                $arr[$main] = $xlsdata['cells'][$i][ $heads['conv'][$main] ];
                            }
                        }

                        $updates[] = $arr;
                        
                    }else{
                        if(isset($heads[$affect])){
                            $arr = array();
                            $arr['email'] = $xlsdata['cells'][$i][ $heads['main']['email'] ];
                            
                            if($affect == 'sc'){
                                foreach($this->config->item('sc_valid') as $main){
                                    $arr[$main] = $xlsdata['cells'][$i][ $heads['sc'][$main] ];
                                }
                            }else if($affect == 'conv'){
                                foreach($this->config->item('conv_valid') as $main){
                                    $arr[$main] = $xlsdata['cells'][$i][ $heads['conv'][$main] ];
                                }
                            }else if($affect == 'ex'){
                                foreach($this->config->item('ex_valid') as $main){
                                    $arr[$main] = $xlsdata['cells'][$i][ $heads['ex'][$main] ];
                                }
                            }
                            
                            $updates[] = $arr;
                            
                        }//else do nothing
                    }
                }
            }
        }
        
        
        //print_r($inserts);
        //print "=======\r\n";
        //print_r($updates);
        
        for($i = 0;$i < count($inserts);$i++){
            
            // short course related
            if(isset($inserts[$i]['member'])){
                $total_usd_sc = 0;
                if($inserts[$i]['member'] == 'Yes'){
                    $cindex = 'member';
                }else{
                    $cindex = 'non_member';
                }
                if(isset($inserts[$i]['course_1'])){
                    $inserts[$i]['course_1'] = ($inserts[$i]['course_1'] == 'Yes')?$this->config->item('course_1_'.$cindex):0;
                    $total_usd_sc += $inserts[$i]['course_1'];
                }
                if(isset($inserts[$i]['course_2'])){
                    $inserts[$i]['course_2'] = ($inserts[$i]['course_2'] == 'Yes')?$this->config->item('course_2_'.$cindex):0;
                    $total_usd_sc += $inserts[$i]['course_2'];
                }                                                                                                
                if(isset($inserts[$i]['course_3'])){                                                             
                    $inserts[$i]['course_3'] = ($inserts[$i]['course_3'] == 'Yes')?$this->config->item('course_3_'.$cindex):0;
                    $total_usd_sc += $inserts[$i]['course_3'];
                }                                                                                                
                if(isset($inserts[$i]['course_4'])){                                                             
                    $inserts[$i]['course_4'] = ($inserts[$i]['course_4'] == 'Yes')?$this->config->item('course_4_'.$cindex):0;
                    $total_usd_sc += $inserts[$i]['course_4'];
                }                                                                                                
                if(isset($inserts[$i]['course_5'])){                                                             
                    $inserts[$i]['course_5'] = ($inserts[$i]['course_5'] == 'Yes')?$this->config->item('course_5_'.$cindex):0;
                    $total_usd_sc += $inserts[$i]['course_5'];
                }
                
                $inserts[$i]['total_usd_sc'] = $total_usd_sc;
            }
            
            // convention related
            $total_usd = 0;
            $total_idr = 0;
            if(isset($inserts[$i]['golf'])){                                                             
                $inserts[$i]['golf'] = ($inserts[$i]['golf'] == 'Yes')?$this->config->item('golf_domestic'):0;
                $total_idr += $inserts[$i]['golf'];
                $inserts[$i]['golfcurr'] = 'IDR';
                // must recalc wait list after insert
            }

            if(isset($inserts[$i]['galadinner'])){                                                             
                $inserts[$i]['galadinner'] = ($inserts[$i]['galadinner'] == 'Yes')?$this->config->item('galadinner_domestic'):0;
                $total_idr += $inserts[$i]['galadinner'];
                $inserts[$i]['galadinnercurr'] = 'IDR';
            }
            
            if(isset($inserts[$i]['registertype'])){  
                $rt = strtoupper($inserts[$i]['registertype']);     
                if($rt == 'PO'){
                    $inserts[$i]['registertype'] = $this->config->item('member_overseas');
                    $inserts[$i]['registrationtype'] = 'Professional Overseas';
                    $total_usd += $inserts[$i]['registertype'];
                }                                                      
                if($rt == 'PD'){
                    $inserts[$i]['registertype'] = $this->config->item('member_domestic');
                    $inserts[$i]['registrationtype'] = 'Professional Domestic';
                    $total_idr += $inserts[$i]['registertype'];
                }                                                      
                if($rt == 'SO'){
                    $inserts[$i]['registertype'] = $this->config->item('student_overseas');
                    $inserts[$i]['registrationtype'] = 'Student Overseas';
                    $total_usd += $inserts[$i]['registertype'];
                }                                                      
                if($rt == 'SD'){
                    $inserts[$i]['registertype'] = $this->config->item('student_domestic');
                    $inserts[$i]['registrationtype'] = 'Student Domestic';
                    $total_idr += $inserts[$i]['registertype'];
                }                                                      
            }
            
            $inserts[$i]['total_idr'] = $total_idr;
            $inserts[$i]['total_usd'] = $total_usd;
            
            
        }

        for($i = 0;$i < count($updates);$i++){
            if(isset($updates[$i]['member'])){
                $total_usd_sc = 0;
                if($updates[$i]['member'] == 'Yes'){
                    $cindex = 'member';
                }else{
                    $cindex = 'non_member';
                }
                
                if(isset($updates[$i]['course_1'])){
                    $updates[$i]['course_1'] = ($updates[$i]['course_1'] == 'Yes')?$this->config->item('course_1_'.$cindex):0;
                    $total_usd_sc += $updates[$i]['course_1'];
                }
                if(isset($updates[$i]['course_2'])){
                    $updates[$i]['course_2'] = ($updates[$i]['course_2'] == 'Yes')?$this->config->item('course_2_'.$cindex):0;
                    $total_usd_sc += $updates[$i]['course_2'];
                }                                                                                                
                if(isset($updates[$i]['course_3'])){                                                             
                    $updates[$i]['course_3'] = ($updates[$i]['course_3'] == 'Yes')?$this->config->item('course_3_'.$cindex):0;
                    $total_usd_sc += $updates[$i]['course_3'];
                }                                                                                                
                if(isset($updates[$i]['course_4'])){                                                             
                    $updates[$i]['course_4'] = ($updates[$i]['course_4'] == 'Yes')?$this->config->item('course_4_'.$cindex):0;
                    $total_usd_sc += $updates[$i]['course_4'];
                }                                                                                                
                if(isset($updates[$i]['course_5'])){                                                             
                    $updates[$i]['course_5'] = ($updates[$i]['course_5'] == 'Yes')?$this->config->item('course_5_'.$cindex):0;
                    $total_usd_sc += $updates[$i]['course_5'];
                }
                
                $updates[$i]['total_usd_sc'] = $total_usd_sc;
            }

            if(isset($updates[$i]['registertype'])){  
                $rt = strtoupper($updates[$i]['registertype']);                                                           
                if($rt == 'PO'){
                    $updates[$i]['registertype'] = $this->config->item('member_overseas');
                    $updates[$i]['registrationtype'] = 'Professional Overseas';
                    $total_usd += $updates[$i]['registertype'];
                }
                if($rt == 'PD'){
                    $updates[$i]['registertype'] = $this->config->item('member_domestic');
                    $updates[$i]['registrationtype'] = 'Professional Domestic';
                    $total_idr += $updates[$i]['registertype'];
                }
                if($rt == 'SO'){
                    $updates[$i]['registertype'] = $this->config->item('student_overseas');
                    $updates[$i]['registrationtype'] = 'Student Overseas';
                    $total_usd += $updates[$i]['registertype'];
                }
                if($rt == 'SD'){
                    $updates[$i]['registertype'] = $this->config->item('student_domestic');
                    $updates[$i]['registrationtype'] = 'Student Domestic';
                    $total_idr += $updates[$i]['registertype'];
                }
            }            
            
        }

        //print_r($inserts);
        //print "=======\r\n";
        //print_r($updates);
        if(isset($inserts) && count($inserts) > 0){
            print_r($inserts);
            foreach($inserts as $user){

                $data['users']['id'] = $id;
        		$data['users']['username'] = $user['username'];
        		$data['users']['group'] = $this->preference->item('default_user_group');

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

                //convention
                if(isset($user['registertype'])){  
                    $data['user_profiles']['registertype'] = $user['registertype'];
                    $data['user_profiles']['registrationtype'] = $user['registrationtype'];
                    $data['user_profiles']['total_idr'] = $user['total_idr'];
                    $data['user_profiles']['total_usd'] = $user['total_usd'];
                    $data['user_profiles']['judge'] = $user['judge'];
                    $data['user_profiles']['golf'] = $user['golf'];
                    $data['user_profiles']['golfcurr'] = $user['golfcurr'];
                    $data['user_profiles']['galadinner'] = $user['galadinner'];
                    $data['user_profiles']['galadinnercurr'] = $user['galadinnercurr'];
                }

                //short course
                if(isset($user['member'])){
                    $data['user_profiles']['course_1'] = $user['course_1'];
                    $data['user_profiles']['course_1'] = $user['course_2'];
                    $data['user_profiles']['course_1'] = $user['course_3'];
                    $data['user_profiles']['course_1'] = $user['course_4'];
                    $data['user_profiles']['course_1'] = $user['course_5'];
                    $data['user_profiles']['total_idr_sc'] = $user['total_idr_sc'];
                    $data['user_profiles']['total_usd_sc'] = $user['total_usd_sc'];
                }

                //print_r($data['users']);

        		$this->user_model->insert('Users',$data['users']);

        		// Get the auto insert ID
        		$data['user_profiles']['user_id'] = $this->db->insert_id();
        		
                print_r($data['user_profiles']);
        		//print $data['user_profiles']['user_id'];

        		$id = $data['user_profiles']['user_id'];

        		$data['user_profiles']['conv_id'] = str_pad($id, 8, "0", STR_PAD_LEFT);

        		// Add user_profile details to DB
        		$this->user_model->insert('UserProfiles',$data['user_profiles']);

        		$activation_message = $this->lang->line('userlib_no_activation');

        		$edata = array(
                        'username'=> $data['users']['username'],
                        'salutation' => $data['user_profiles']['salutation'],
                        'fullname'=> $data['user_profiles']['firstname'].' '.$data['user_profiles']['lastname'],
                        'email'=> $data['users']['email'],
                        'password'=> $user['password'],
                        'activation_message' => $activation_message,
                        'site_name'=>$this->preference->item('site_name'),
                        'site_url'=>base_url()
    			);
    		    $this->user_email->send($data['users']['email'],$this->lang->line('userlib_email_register'),'public/email_register',$edata);

            }
        }
        
        if(isset($updates) && count($updates) > 0){
            foreach($updates as $user){
                if($affect == 'all'){
                    /*
                    $data['users']['id'] = $id;
            		$data['users']['username'] = $user['username'];
            		$data['users']['group'] = $this->preference->item('default_user_group');

                    $data['users']['password'] = $this->userlib->encode_password($user['password']);

            		$data['users']['email'] = $user['email'];
            		$data['users']['created'] = date("Y-m-d H:i:s",time());
            		$data['users']['active'] = 1;
                    */
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
                }

                //convention
                if($affect == 'conv'){  
                    $data['user_profiles']['registertype'] = $user['registertype'];
                    $data['user_profiles']['registrationtype'] = $user['registrationtype'];
                    $data['user_profiles']['total_idr'] = $user['total_idr'];
                    $data['user_profiles']['total_usd'] = $user['total_usd'];
                    $data['user_profiles']['judge'] = $user['judge'];
                    $data['user_profiles']['golf'] = $user['golf'];
                    $data['user_profiles']['golfcurr'] = $user['golfcurr'];
                    $data['user_profiles']['galadinner'] = $user['galadinner'];
                    $data['user_profiles']['galadinnercurr'] = $user['galadinnercurr'];

            		$prefix = $this->config->item('convention_prefix');
                    $prefix = $prefix[$data['user_profiles']['registrationtype']];

            		$data['user_profiles']['conv_id'] = substr_replace($this->input->post('conv_id'),$prefix,0,1);

                }

                //short course
                if($affect == 'sc'){
                    $data['user_profiles']['course_1'] = $user['course_1'];
                    $data['user_profiles']['course_1'] = $user['course_2'];
                    $data['user_profiles']['course_1'] = $user['course_3'];
                    $data['user_profiles']['course_1'] = $user['course_4'];
                    $data['user_profiles']['course_1'] = $user['course_5'];
                    $data['user_profiles']['total_idr_sc'] = $user['total_idr_sc'];
                    $data['user_profiles']['total_usd_sc'] = $user['total_usd_sc'];

            		//$data['user_profiles']['conv_id'] = substr_replace($this->input->post('conv_id'),$this->config->item('shortcourse_prefix'),1,1);

                }

                //short course
                if($affect == 'ex'){

                }

                //$this->user_model->update('Users',$data['users'],array('id'=>$data['users']['id']));

    			$this->user_model->update('UserProfiles',$data['user_profiles'],array('user_id'=>$data['users']['id']));



        		// Add user_profile details to DB
        		$this->user_model->insert('UserProfiles',$data['user_profiles']);

        		$activation_message = $this->lang->line('userlib_no_activation');

        		$edata = array(
                        'username'=> $data['users']['username'],
                        'salutation' => $data['user_profiles']['salutation'],
                        'fullname'=> $data['user_profiles']['firstname'].' '.$data['user_profiles']['lastname'],
                        'email'=> $data['users']['email'],
                        'password'=> $user['password'],
                        'activation_message' => $activation_message,
                        'site_name'=>$this->preference->item('site_name'),
                        'site_url'=>base_url()
    			);
    		    $this->user_email->send($data['users']['email'],$this->lang->line('userlib_email_register'),'public/email_register',$edata);

            }
        }

		$data['inserts'] = $inserts;
		$data['updates'] = $updates;
		$data['inserts_count'] = count($inserts);
		$data['updates_count'] = count($updates);
		$data['pic'] = $this->session->userdata('picemail');
		$data['invalids'] = $invalids;
		$data['email_col'] = $email_col;
		$data['dup_email'] = $dup_email;
		$data['dup_user'] = $dup_user;
		$data['sheet'] =  $this->spreadsheet_excel_reader->dump(true,true);
		$data['file'] = $file;
		
		$data['xlsdata'] = $xlsdata;
        /*
		print_r($this->spreadsheet_excel_reader);
		for ($i = 1; $i <= $data['numRows']; $i++) {
			for ($j = 1; $j <= $data['numCols']; $j++) {
				echo "\"".$data['cells'][$i][$j]."\",";
			}
			echo "<br />";
		}
		*/

		// Display page
	    
		$data['header'] = "Excel File Imported";
		$data['page'] = $this->config->item('backendpro_template_admin') . 'import/save';
		$data['module'] = 'auth';
		$this->load->view($this->_container,$data);
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

}