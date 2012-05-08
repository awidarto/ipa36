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
class Register extends Public_Controller
{
	function Register()
	{
		parent::Public_Controller();
		$this->load->library('validation');
		$this->load->helper('form');
		$this->load->config('ipa');
		$this->load->module_library('auth','User_email');
		
		// Set breadcrumb
		$this->bep_site->set_crumb('Home','http://www.ipa.or.id/convex');
		
		// Load any files directly related to the authentication module
		$this->bep_assets->load_asset_group('FORMS');
	}

	function index()
	{
		// Display Page
		$data['header'] = "Registration";
		$data['page'] = $this->config->item('backendpro_template_public') . 'register_main';
		$data['module'] = 'register';
		$this->load->view($this->_container,$data);
	}
	
	function fixnumber(){
        $usr = $this->user_model->getUsers(null, null,array('fields'=>'id','order'=>'asc'));
		$usr = $usr->result_array();
		
		print count($usr)."\r\n";
		print "user id -> reg number - conv seq - sc seq\r\n";
		$count = 0;
		foreach($usr as $user){
		    
		    
            //print_r($user);

            //print 'id = '.$id;

            $courses = $user['course_1'] + $user['course_2'] + $user['course_3'] + $user['course_4'] + $user['course_5'] ;
            $convention = $user['registertype'] + $user['galadinner'] + $user['golf'];


            if($user['sc_seq'] == 0 && $courses > 0){
    		    $new_sc = $this->_increment_field('sc_seq',$user['id']);
    		}else{
    		    $new_sc = $user['sc_seq'];
    		}

    		if($user['conv_seq'] == 0 && $user['registertype'] > 0){
    		    $new_conv = $this->_increment_field('conv_seq',$user['id']);
    		}else{
    		    $new_conv = $user['conv_seq'];
    		}

            $c_id = explode('-',$user['conv_id']);

    	    if($courses > 0 && $convention == 0){
        	    $seq_code = str_pad($new_sc, 6, "0", STR_PAD_LEFT);
    	    }else if($courses > 0 && $convention > 0){
        	    $seq_code = str_pad($new_conv, 6, "0", STR_PAD_LEFT);
    	    }else{
        	    $seq_code = str_pad($new_conv, 6, "0", STR_PAD_LEFT);
    	    }

    	    /*
    	    print $user['firstname']."\r\n";
    	    print $user['galadinner']."\r\n";
    	    print $user['golf']."\r\n";
            print $courses."+".$convention."\r\n";
            print $seq_code."\r\n";
    	    */

    		$c_id[2] = $seq_code;


    		//print_r($c_id);

    		$conv_id = implode('-',$c_id);
    		
    		print "\r\n<br />".$user['id']." ".$user['firstname']." : ".$user['company']." -> ".$conv_id." - ".$new_conv." - ".$new_sc."\r\n";

			$this->user_model->update('UserProfiles',array('conv_id'=>$conv_id),array('user_id'=>$user['id']));

    		
    		$udata = array();
    		
    		$udata[] = 'uid:'.$user['id'];
            $udata[] = 'name:'.$user['firstname'].' '.$user['lastname'];
            $udata[] = 'email:'.$user['email'];
            
            //print_r($udata);
            $udata = implode("\r\n",$udata);
			$data['qrfile'] = $this->_generateQR($user['id'].'_qr.png',$udata);
			
            $count++;
            //$this->user_model->update('UserProfiles',array('conv_id'=>$conv_id),array('user_id'=>$u['id']));
		    
		    /*
    		if(substr($u['conv_id'],2,1) != "-" && substr($u['conv_id'],5,1) != "-"){
                $count++;
                
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
                print $conv_code."-".$sc_code."-".$conv_id."\r\n";
                
                $conv_id = $conv_code."-".$sc_code."-".$conv_id;
    		}
    		*/
		}
		
		
		print "\r\n<br />end of process, ".$count." records processed";
        
		
		//$usr['conv_id'] = str_pad($usr['conv_id'], 8, "0", STR_PAD_LEFT);

		//$data['user_profiles']['conv_id'] = substr_replace($usr['conv_id'],$prefix,0,1);

		//$this->user_model->update('Users',$data['users'],array('id'=>$data['users']['id']));
	    
	}

	
	function fixcharges(){
        $usr = $this->user_model->getUsers(null, null,array('fields'=>'id','order'=>'asc'));
		$usr = $usr->result_array();
		
		print count($usr)."\r\n";
		print "user id -> charges - convention - shortcourse\r\n";
		$count = 0;
		foreach($usr as $user){

            $total_usd = $user['total_usd'];
            $total_idr = $user['total_idr'];
            $total_usd_sc = $user['total_usd_sc'];
            $total_idr_sc = $user['total_idr_sc'];
            
            print "============================================\r\n";
                
                print "User ID ".$user['id']."\r\n";
                print "USD ".$total_usd."\r\n";
                print "IDR ".$total_idr."\r\n";
                print "USD ".$total_usd_sc."\r\n";
                print "IDR ".$total_idr_sc."\r\n";
                print "foc : ".$user['foc']."\r\n";
		    
    		    if($user['foc'] == 1){
                    $total_usd = 0;
                    $total_idr = $user['galadinner'] + $user['golf'];
    		    }else{
    		        if($user['registrationtype'] == "Professional Overseas" || $user['registrationtype'] == "Student Overseas"){
                        $total_usd = $user['registertype'];
                        $total_idr = $user['galadinner'] + $user['golf'];
    		        }else if($user['registrationtype'] == "Professional Domestic" || $user['registrationtype'] == "Student Domestic"){
                        $total_usd = 0;
                        $total_idr = $user['registertype'] + $user['galadinner'] + $user['golf'];
    		        }
    		    }

                $total_idr_sc = 0;
                $total_usd_sc = $user['course_1'] + $user['course_2'] + $user['course_3'] + $user['course_4'] + $user['course_5'] ;
		    
    		    print "USD ".$total_usd."\r\n";
                print "IDR ".$total_idr."\r\n";
                print "USD ".$total_usd_sc."\r\n";
                print "IDR ".$total_idr_sc."\r\n";
            
            print "============================================\r\n";
		    
		    $charges = array(
		                    'total_usd' =>  $total_usd,
		                    'total_idr' =>  $total_idr, 
		                    'total_usd_sc' =>$total_usd_sc,
		                    'total_idr_sc' =>$total_idr_sc
		                );

			$this->user_model->update('UserProfiles',$charges,array('user_id'=>$user['id']));
			
            $count++;

		}
		
		
		print "\r\n<br />end of process, ".$count." records processed";
        
		
		//$usr['conv_id'] = str_pad($usr['conv_id'], 8, "0", STR_PAD_LEFT);

		//$data['user_profiles']['conv_id'] = substr_replace($usr['conv_id'],$prefix,0,1);

		//$this->user_model->update('Users',$data['users'],array('id'=>$data['users']['id']));
	    
	}


	/**
	 * Register form for individual
	 *
	 * Display the register form to the user
	 *
	 * @access public
	 * @param string $container View file container
	 */
	function user($id = null)
	{
        if(is_user() && $id == null){
            $id = $this->session->userdata('id');
            $header = 'Update Profile';
            $upd = 'update';
        }else{
            $header = 'Registration Form';
            $upd = 'create';
        }
        
        $validator = $this->_validator_setup($id,$upd);
		
		// Setup form default values
		if( ! is_null($id) AND ! $this->input->post('submit'))
		{
			// Modify form, first load
			$user = $this->user_model->getUsers(array('users.id'=>$id));
			$user = $user->row_array();
			
			//prepare dob pseudo field
			$dob = explode('-',$user['dob']);
			$user['dob_y'] = $dob[0];
			$user['dob_m'] = $dob[1];
			$user['dob_d'] = $dob[2];
			
			$this->validation->set_default_value('group',$user['group_id']);

			unset($user['group']);
			unset($user['group_id']);
			$this->validation->set_default_value($user);
		}
		elseif( is_null($id) AND ! $this->input->post('submit'))
		{
			// Create form, first load
			$this->validation->set_default_value('group',$this->preference->item('default_user_group'));
			$this->validation->set_default_value('active','1');

			// Setup profile defaults
			$this->_set_profile_defaults();
		}
		elseif( $this->input->post('submit'))
		{
			// Form submited, check rules
            $this->validation->set_fields($validator['fields']);
    		$this->validation->set_rules($validator['rules']);
		}

		if ( $this->validation->run() === FALSE )
		{
			// Output any errors
			$this->validation->output_errors();

			// Display page
			$data['header'] = $header;
			$data['upd'] = $upd;
			$data['captcha'] = ($this->preference->item('use_registration_captcha')?$this->_generate_captcha():'');
			$data['page'] = $this->config->item('backendpro_template_public') . 'my_form_register';
			$data['module'] = 'register';
			$this->load->view($this->_container,$data);
		}
		else
		{
			// Submit form
			$this->_register_individual($id,$upd);
		}
	}

	function convention($id = null)
	{
        if(!is_user()){
            redirect('auth/login','location');
        }
        
        $this->bep_site->set_crumb('Convention Registration','register/convention');
        
        if(is_user() && $id == null){
            $id = $this->session->userdata('id');
            $header = 'Registration Form - Convention';
            $upd = 'update';
        }else{
            $header = 'Registration Form - Convention';
            $upd = 'create';
        }
        
        $validator = $this->_validator_setup_cv($id,$upd);
		
		// Setup form default values
		if( ! is_null($id) AND ! $this->input->post('submit'))
		{
			// Modify form, first load
			$user = $this->user_model->getUsers(array('users.id'=>$id));
			$user = $user->row_array();
			
			$this->validation->set_default_value('group',$user['group_id']);
			
			$data['conv_id'] = $user['conv_id'];
			$data['conv_lock'] = $user['conv_lock'];
			$data['total_idr'] = $user['total_idr'];
			$data['total_usd'] = $user['total_usd'];			
			$data['golfwait'] = $user['golfwait'];			
			$data['conv_id'] = $user['conv_id'];			

			unset($user['group']);
			unset($user['group_id']);
			$this->validation->set_default_value($user);
		}
		elseif( is_null($id) AND ! $this->input->post('submit'))
		{
			// Create form, first load
			$this->validation->set_default_value('group',$this->preference->item('default_user_group'));
			$this->validation->set_default_value('active','1');

			// Setup profile defaults
			$this->_set_profile_defaults();
		}
		elseif( $this->input->post('submit'))
		{
			// Form submited, check rules
            $this->validation->set_fields($validator['fields']);
    		$this->validation->set_rules($validator['rules']);
		}

		if ( $this->validation->run() === FALSE )
		{
			// Output any errors
			$this->validation->output_errors();

			// Display page
			$data['header'] = $header;
			$data['upd'] = $upd;
			$data['captcha'] = ($this->preference->item('use_registration_captcha')?$this->_generate_captcha():'');
			$data['page'] = $this->config->item('backendpro_template_public') . 'my_form_register_2_conv';
			$data['module'] = 'register';
			$this->load->view($this->_container,$data);
		}
		else
		{
			// Submit form
			$this->_register_convention($id,$upd);
		}
	}


	function shortcourses($id = null)
	{
        if(!is_user()){
            redirect('auth/login','location');
        }
        
        $this->bep_site->set_crumb('Short Courses Registration','register/shortcourses');
        
        if(is_user() && $id == null){
            $id = $this->session->userdata('id');
            $header = 'Registration Form - Short Courses';
            $upd = 'update';
        }else{
            $header = 'Registration Form - Short Courses';
            $upd = 'create';
        }
        
        $validator = $this->_validator_setup_cv($id,$upd);
		
		// Setup form default values
		if( ! is_null($id) AND ! $this->input->post('submit'))
		{
			// Modify form, first load
			$user = $this->user_model->getUsers(array('users.id'=>$id));
			$user = $user->row_array();
			
			$this->validation->set_default_value('group',$user['group_id']);
			
			$data['sc_lock'] = $user['sc_lock'];
			$data['total_idr_sc'] = $user['total_idr_sc'];
			$data['total_usd_sc'] = $user['total_usd_sc'];
			$data['conv_id'] = $user['conv_id'];			

			unset($user['group']);
			unset($user['group_id']);
			$this->validation->set_default_value($user);
		}
		elseif( is_null($id) AND ! $this->input->post('submit'))
		{
			// Create form, first load
			$this->validation->set_default_value('group',$this->preference->item('default_user_group'));
			$this->validation->set_default_value('active','1');

			// Setup profile defaults
			$this->_set_profile_defaults();
		}
		elseif( $this->input->post('submit'))
		{
			// Form submited, check rules
            $this->validation->set_fields($validator['fields']);
    		$this->validation->set_rules($validator['rules']);
		}

		if ( $this->validation->run() === FALSE )
		{
			// Output any errors
			$this->validation->output_errors();

			// Display page
			$data['header'] = $header;
			$data['upd'] = $upd;
			$data['captcha'] = ($this->preference->item('use_registration_captcha')?$this->_generate_captcha():'');
			$data['page'] = $this->config->item('backendpro_template_public') . 'my_form_register_2_sc';
			$data['module'] = 'register';
			$this->load->view($this->_container,$data);
		}
		else
		{
			// Submit form
			$this->_register_shortcourses($id,$upd);
		}
	}


	function sponsor($id = null)
	{
        if(!is_user()){
            redirect('auth/login','location');
        }
        
        if(is_user() && $id == null){
            $id = $this->session->userdata('id');
            $header = 'Registration Form - Sponsorship';
            $upd = 'update';
        }else{
            $header = 'Registration Form - Sponsorship';
            $upd = 'create';
        }
        
        $validator = $this->_validator_setup_cv($id,$upd);
		
		// Setup form default values
		if( ! is_null($id) AND ! $this->input->post('submit'))
		{
			// Modify form, first load
			$user = $this->user_model->getUsers(array('users.id'=>$id));
			$user = $user->row_array();
			
			$this->validation->set_default_value('group',$user['group_id']);

			unset($user['group']);
			unset($user['group_id']);
			$this->validation->set_default_value($user);
		}
		elseif( is_null($id) AND ! $this->input->post('submit'))
		{
			// Create form, first load
			$this->validation->set_default_value('group',$this->preference->item('default_user_group'));
			$this->validation->set_default_value('active','1');

			// Setup profile defaults
			$this->_set_profile_defaults();
		}
		elseif( $this->input->post('submit'))
		{
			// Form submited, check rules
            $this->validation->set_fields($validator['fields']);
    		$this->validation->set_rules($validator['rules']);
		}

		if ( $this->validation->run() === FALSE )
		{
			// Output any errors
			$this->validation->output_errors();

			// Display page
			$data['header'] = $header;
			$data['upd'] = $upd;
			$data['captcha'] = ($this->preference->item('use_registration_captcha')?$this->_generate_captcha():'');
			$data['page'] = $this->config->item('backendpro_template_public') . 'my_form_register_3';
			$data['module'] = 'register';
			$this->load->view($this->_container,$data);
		}
		else
		{
			// Submit form
			$this->_register_convention($id,$upd);
		}
	}

	
	/**
	 * Register form for exhibitor
	 *
	 * Display the register form to the user
	 *
	 * @access public
	 * @param string $container View file container
	 */
	function exhibitor($id = null)
	{
        if(!is_user()){
            redirect('auth/login','location');
        }

        $this->bep_site->set_crumb('Exhibitor Registration','register/exhibitor');

        $validator = $this->_validator_setup_ex($id);
        
		// Setup form default values
		if( ! is_null($id) AND ! $this->input->post('submit'))
		{
			// Modify form, first load
			$user = $this->user_model->getUsers(array('users.id'=>$id));
			$user = $user->row_array();
			
			$this->validation->set_default_value('invoice_address',$user['street'].' '.$user['street2']);
			$this->validation->set_default_value('pic_id',$id);
			$this->validation->set_default_value('group',$user['group_id']);
			unset($user['group']);
			unset($user['group_id']);
			$this->validation->set_default_value($user);
            $booth = $this->user_model->getBoothDetail(array('orderby'=>$user['company']));
			$booth = $booth->result_array();
			$data['booth'] = $booth;
			if(is_array($booth)){
			    $p = 0;
			    $sqm = 0;
    			foreach($booth as $b){
    			    $p += $b['price_total'];
    			    $sqm += $b['area'];
    			}
			}
			
			$entitlement = ceil(($sqm/9)*2);
            $entitlement = ($entitlement <= 10)?$entitlement:10;
            
			$data['entitlement'] = $entitlement;
			$data['total_charge'] = 'USD '.number_format($p);
			
		}
		elseif( is_null($id) AND ! $this->input->post('submit'))
		{
			if(is_user() && $id == null){
                $id = $this->session->userdata('id');
    			$user = $this->user_model->getUsers(array('users.id'=>$id));
    			$user = $user->row_array();
    			
    			$this->validation->set_default_value('company',$user['company']);
    			$this->validation->set_default_value('invoice_address',$user['street'].', '.$user['street2']);
    			$this->validation->set_default_value('email',$user['email']);
    			$this->validation->set_default_value('phone',$user['phone']);
    			$this->validation->set_default_value('pic_id',$id);
    			$booth = $this->user_model->getBoothDetail(array('orderby'=>$user['company']));
    			$booth = $booth->result_array();
    			
    			$data['booth'] = $booth;
    			if(is_array($booth)){
    			    $p = 0;
    			    $sqm = 0;
        			foreach($booth as $b){
        			    $p += $b['price_total'];
        			    $sqm += $b['area'];
        			}
    			}
    			$entitlement = ceil(($sqm/9)*2);
                $entitlement = ($entitlement <= 10)?$entitlement:10;

    			$data['entitlement'] = $entitlement;
    			$data['total_charge'] = 'USD '.number_format($p);
                
            }
			
			// Create form, first load

			// Setup profile defaults
			//$this->_set_profile_defaults();
		}
		elseif( $this->input->post('submit'))
		{
			// Form submited, check rules
            $this->validation->set_fields($validator['fields']);
    		$this->validation->set_rules($validator['rules']);
		}

		if ( $this->validation->run() === FALSE )
		{
			// Output any errors
			$this->validation->output_errors();
			
			// Display page
			$data['header'] = 'Registration Form - Exhibitor';
			$data['captcha'] = ($this->preference->item('use_registration_captcha')?$this->_generate_captcha():'');
			$data['page'] = $this->config->item('backendpro_template_public') . 'my_form_register_1';
			$data['module'] = 'register';
			$this->load->view($this->_container,$data);
		}
		else
		{
			// Submit form
			$this->_register_exhibitor($id);
		}        
	}	
	
	/**
	 * Set Profile Defaults
	 *
	 * Specify what values should be shown in the profile fields when creating
	 * a new user by default
	 *
	 * @access private
	 */
	function _set_profile_defaults()
	{
		//$this->validation->set_default_value('field1','value');
		//$this->validation->set_default_value('field2','value');
		$this->validation->set_default_value('id','');
		$this->validation->set_default_value('salutation','Mr.');
		$this->validation->set_default_value('firstname','');
		$this->validation->set_default_value('lastname','');
		$this->validation->set_default_value('username','');
		$this->validation->set_default_value('password','');
		$this->validation->set_default_value('nationality','');
		$this->validation->set_default_value('email','');
		$this->validation->set_default_value('mobile','');
		$this->validation->set_default_value('fax','');
		$this->validation->set_default_value('phone','');
		$this->validation->set_default_value('ipaid','');
		$this->validation->set_default_value('company','');
		$this->validation->set_default_value('companycode','');
		$this->validation->set_default_value('position','');
		$this->validation->set_default_value('dob','1960-01-01');
		$this->validation->set_default_value('dob_y','1960');
		$this->validation->set_default_value('dob_m','01');
		$this->validation->set_default_value('dob_d','01');
		$this->validation->set_default_value('street','');
		$this->validation->set_default_value('street2','');
	    $this->validation->set_default_value('city','Jakarta');                                         
        $this->validation->set_default_value('zip','90210');     
		$this->validation->set_default_value('country','Indonesia');
		$this->validation->set_default_value('registertype','member_domestic');
		$this->validation->set_default_value('course_1','0');
		$this->validation->set_default_value('course_2','0');
		$this->validation->set_default_value('course_3','0');
		$this->validation->set_default_value('course_4','0');
		$this->validation->set_default_value('golf','0');
		$this->validation->set_default_value('judge','no');
		$this->validation->set_default_value('galadinner','0');
		$this->validation->set_default_value('boothassistant','0');
		$this->validation->set_default_value('domain',base_url());

		$this->validation->set_default_value('invoice_address','');
        
    }
    
    function _validator_setup_ex($id = null){
	    $fields['pic_id'] = "PIC ID";
	    $fields['company'] = 'Company';
		$fields['invoice_address'] = 'Invoice Address';
		$fields['email'] = $this->lang->line('userlib_email');
		$fields['phone'] = 'Phone';
		
        $rules['pic_id'] = 'trim';
		$rules['company'] = 'trim';
		$rules['invoice_address'] = 'trim';
		$rules['email'] = 'trim';
		$rules['phone'] = 'trim';
		
		return array('fields'=>$fields,'rules'=>$rules);
    }
	
	function _validator_setup($id = null,$is_update = null){
	    // Setup fields
	    $fields['id'] = "ID";
		$fields['username'] = $this->lang->line('userlib_username');
		$fields['password'] = $this->lang->line('userlib_password');
		$fields['confirm_password'] = $this->lang->line('userlib_confirm_password');
		$fields['email'] = $this->lang->line('userlib_email');
		$fields['recaptcha_response_field'] = $this->lang->line('userlib_captcha');
		
		if($this->preference->item('allow_user_profiles')){
    		$fields['firstname'] = 'First Name';
    		$fields['lastname'] = 'Last Name';
    		$fields['salutation'] = 'Salutation';
    		$fields['nationality'] = 'Last Name';
    		//$fields['mobile'] = 'Last Name';
    		$fields['company'] = 'Company';
    		$fields['position'] = 'Position';
    		//$fields['dob'] = 'Date of Birth';
    		//$fields['dob_y'] = 'Year of Birth';
    		//$fields['dob_m'] = 'Month of Birth';
    		//$fields['dob_d'] = 'Day of Birth';
    		$fields['street'] = 'Address 1';
    		$fields['street2'] = 'Address 2';
    		$fields['city'] = 'City';
    		$fields['zip'] = 'ZIP';
    		$fields['country'] = 'Country';
    		$fields['ipaid'] = 'IPA Membership Id';
    		$fields['phone'] = 'Telephone';
    		$fields['fax'] = 'Fax';
    		$fields['course_1'] = 'Course 1';
    		$fields['course_2'] = 'Course 2';
    		$fields['course_3'] = 'Course 3';
    		$fields['course_4'] = 'Course 4';
    		$fields['judge'] = 'Judge';
    		$fields['golf'] = 'Golf';
    		$fields['galadinner'] = 'Gala Dinner';
    		$fields['boothassistant'] = 'Booth Assistant';
    		$fields['domain'] = 'Domain';
		}

		// Set Rules
		if( $is_update == 'create'){
		    $rules['id'] = 'trim';
    		$rules['username'] = 'trim|required|max_length[32]|spare_username';
    		$rules['password'] = 'trim|required|min_length['.$this->preference->item('min_password_length').']|matches[confirm_password]';
    		$rules['email'] = 'trim|required|max_length[254]|valid_email|spare_email';
		}

		if($this->preference->item('allow_user_profiles')){
    		$rules['firstname'] = 'trim|required';
    		$rules['lastname'] = 'trim';
    		$rules['salutation'] = 'trim|required';
    		$rules['nationality'] = 'trim|required';
    		//$rules['mobile'] = 'trim|required';
    		$rules['company'] = 'trim|required';
    		$rules['position'] = 'trim';
    		//$rules['dob'] = 'trim';
    		//$rules['dob_y'] = 'trim';
    		//$rules['dob_m'] = 'trim';
    		//$rules['dob_d'] = 'trim';
    		$rules['street'] = 'trim';
    		$rules['street2'] = 'trim';
    		$rules['city'] = 'trim';
    		$rules['zip'] = 'trim';
    		$rules['country'] = 'trim';
    		$rules['phone'] = 'trim|required';
    		$rules['fax'] = 'trim';
    		$fields['ipaid'] = 'trim';
    		$rules['boothassistant'] = 'trim';
    		$rules['course_1'] = 'trim';
    		$rules['course_2'] = 'trim';
    		$rules['course_3'] = 'trim';
    		$rules['course_4'] = 'trim';
    		$rules['judge'] = 'trim';
    		$rules['golf'] = 'trim';
    		$rules['galadinner'] = 'trim';
    		$rules['domain'] = 'trim';
    		
		}

		if($this->preference->item('use_registration_captcha'))
		{
			$rules['recaptcha_response_field'] = 'trim|required|valid_captcha';
		}
		
		return array('fields'=>$fields,'rules'=>$rules);
	}

	function _validator_setup_cv($id = null,$is_update = null){
	    // Setup fields
	    $fields['id'] = "ID";
		
		if($this->preference->item('allow_user_profiles')){
    		$fields['ipaid'] = 'IPA Membership Id';
    		$fields['course_1'] = 'Course 1';
    		$fields['course_2'] = 'Course 2';
    		$fields['course_3'] = 'Course 3';
    		$fields['course_4'] = 'Course 4';
    		$fields['judge'] = 'Judge';
    		$fields['golf'] = 'Golf';
    		$fields['galadinner'] = 'Gala Dinner';
    		$fields['boothassistant'] = 'Booth Assistant';
    		$fields['domain'] = 'Domain';
		}

		// Set Rules

		if($this->preference->item('allow_user_profiles')){
    		$fields['ipaid'] = 'trim';
    		$rules['boothassistant'] = 'trim';
    		$rules['course_1'] = 'trim';
    		$rules['course_2'] = 'trim';
    		$rules['course_3'] = 'trim';
    		$rules['course_4'] = 'trim';
    		$rules['judge'] = 'trim';
    		$rules['golf'] = 'trim';
    		$rules['galadinner'] = 'trim';
    		$rules['domain'] = 'trim';
    		
		}

		if($this->preference->item('use_registration_captcha'))
		{
			$rules['recaptcha_response_field'] = 'trim|required|valid_captcha';
		}
		
		return array('fields'=>$fields,'rules'=>$rules);
	}
	
	/**
	 * Process registration
	 *
	 * Creat the new user accounts for the registered user. When this
	 * is called all the data should be valid and no more checks should
	 * be needed
	 *
	 * @access private
	 */
	function _register_exhibitor($id = null)
	{
        
    }
	
	/**
	 * Process registration
	 *
	 * Creat the new user accounts for the registered user. When this
	 * is called all the data should be valid and no more checks should
	 * be needed
	 *
	 * @access private
	 */
	function _register_individual($id = null, $is_update = null)
	{
		// Build
		//print $is_update;
		//print_r($_POST);
		$data['users']['id'] = $id;
		if($is_update == 'create'){
    		$data['users']['username'] = $this->input->post('username');
    		$data['users']['group'] = $this->preference->item('default_user_group');
		}
        
        if($this->input->post('password') != ''){
            $data['users']['password'] = $this->userlib->encode_password($this->input->post('password'));
        }
        
		$data['users']['email'] = $this->input->post('email');
		$data['users']['created'] = date("Y-m-d H:i:s",time());
		
		$data['user_profiles']['fullname'] = $this->input->post('firstname').' '.$this->input->post('lastname');
		$data['user_profiles']['firstname'] = $this->input->post('firstname');
		$data['user_profiles']['lastname'] = $this->input->post('lastname');
		$data['user_profiles']['gender'] = $this->input->post('gender'); 
		$data['user_profiles']['company'] = $this->input->post('company');
		$data['user_profiles']['nationality'] = $this->input->post('nationality');
		$data['user_profiles']['salutation'] = $this->input->post('salutation');
		
		$dob = $this->input->post('dob_y').'-'.$this->input->post('dob_m').'-'.$this->input->post('dob_d');
		$data['user_profiles']['dob'] = $dob;
		$data['user_profiles']['street'] = $this->input->post('street');
		$data['user_profiles']['position'] = $this->input->post('position');
		$data['user_profiles']['street2'] = $this->input->post('street2');
		$data['user_profiles']['city'] = $this->input->post('city');
		$data['user_profiles']['zip'] = $this->input->post('zip');
		$data['user_profiles']['mobile'] = $this->input->post('mobile');
		$data['user_profiles']['fax'] = $this->input->post('fax');
		$data['user_profiles']['phone'] = $this->input->post('phone');
		$data['user_profiles']['country'] = $this->input->post('country');
		$data['user_profiles']['domain'] = $this->input->post('domain');
		/*		
		$data['user_profiles']['registertype'] = $this->input->post('registertype');
		$data['user_profiles']['registrationtype'] = $this->input->post('registrationtype');
		$data['user_profiles']['boothassistant'] = ($this->input->post('boothassistant'))?1:0;
		$data['user_profiles']['course_1'] = $this->input->post('course_1');
		$data['user_profiles']['course_2'] = $this->input->post('course_2');
		$data['user_profiles']['course_3'] = $this->input->post('course_3');
		$data['user_profiles']['course_4'] = $this->input->post('course_4');
		$data['user_profiles']['judge'] = $this->input->post('judge');
		$data['user_profiles']['golf'] = $this->input->post('golf');
		$data['user_profiles']['galadinner'] = $this->input->post('galadinner');
		$data['user_profiles']['golfcurr'] = $this->input->post('golfcurr');
		$data['user_profiles']['galadinnercurr'] = $this->input->post('galadinnercurr');
		$data['user_profiles']['ipaid'] = $this->input->post('ipaid');
		$data['user_profiles']['total_usd'] = $this->input->post('total_usd');
		$data['user_profiles']['total_idr'] = $this->input->post('total_idr');
		*/

		// Check how the account should be activated
		switch($this->preference->item('activation_method'))
		{
			case 'none':
				// Send welcome email, account already activated
				$data['users']['active'] = 1;
				$activation_message = $this->lang->line('userlib_no_activation');
				break;

			case 'admin':
				// Admin must activate, do nothing
				$activation_message = $this->lang->line('userlib_admin_activation');
				break;

			default:
				// Send email with activation link
				$this->load->helper('string');
				$data['users']['activation_key'] = random_string('alnum',32);
				$activation_message = sprintf($this->lang->line('userlib_email_activation'), site_url('auth/activate/'.$data['users']['activation_key']), $this->preference->item('account_activation_time'));
				break;
		}

        if( is_null($id)){
    		$this->db->trans_begin();
    		// Add user details to DB
    		$this->user_model->insert('Users',$data['users']);

    		// Get the auto insert ID
    		$data['user_profiles']['user_id'] = $this->db->insert_id();
    		
    		$id = $data['user_profiles']['user_id'];
    		
    		$data['user_profiles']['conv_id'] = "00-00-".str_pad($id, 6, "0", STR_PAD_LEFT);

    		// Add user_profile details to DB
    		$this->user_model->insert('UserProfiles',$data['user_profiles']);
        }else{
            $data['users']['modified'] = date('Y-m-d H:i:s');
			
			if($this->input->post('password') == ''){
			    unset($data['users']['password']);
			}

    		//$id = $data['users']['id'];

    		//$data['user_profiles']['conv_id'] = "00-00-".str_pad($id, 6, "0", STR_PAD_LEFT);

			$this->db->trans_begin();
			$this->user_model->update('Users',$data['users'],array('id'=>$data['users']['id']));

			// The && count($profile) > 0 has been added here since if no update keys=>values
			// are passed to the update method it errors saying the set method must be set
			// See bug #51
			if($this->preference->item('allow_user_profiles') && count($data['user_profiles']) > 0)
			{
				$this->user_model->update('UserProfiles',$data['user_profiles'],array('user_id'=>$data['users']['id']));
			}
        }

		if ($this->db->trans_status() === FALSE)
		{
			// Registration failed
			$this->db->trans_rollback();

			flashMsg('error',$this->lang->line('userlib_registration_failed'));
			if($is_update == 'update'){
    			redirect('user/profile/update','location');
			}else{
    			redirect('register/user','location');
			}
		}
		else
		{
			// User registered
			$this->db->trans_commit();
			
			//print ($is_update)?'User profile updated successfully':$this->lang->line('userlib_registration_success');

			// Send email to user
			if($is_update == 'create'){
    			$edata = array(
                        'username'=> $data['users']['username'],
                        'salutation' => $data['user_profiles']['salutation'],
                        'fullname'=> $data['user_profiles']['firstname'].' '.$data['user_profiles']['lastname'],
                        'email'=> $data['users']['email'],
                        'password'=> $this->input->post('password'),
                        'activation_message' => $activation_message,
                        'site_name'=>$this->preference->item('site_name'),
                        'site_url'=>base_url()
    			);
			    $this->user_email->send($data['users']['email'],$this->lang->line('userlib_email_register'),'public/email_register',$edata);
			}
			
			flashMsg('success',($is_update == 'update')?'User profile updated successfully.':$this->lang->line('userlib_registration_success'));

			redirect('auth/login','location');
		}
	}

	/**
	 * Process registration
	 *
	 * Creat the new user accounts for the registered user. When this
	 * is called all the data should be valid and no more checks should
	 * be needed
	 *
	 * @access private
	 */
	function _register_convention($id = null, $is_update = null)
	{
		// Build
		//print $is_update;
		//print_r($_POST);
		$data['users']['id'] = $id;
		$data['user_profiles']['registertype'] = $this->input->post('registertype');
		$data['user_profiles']['registrationtype'] = $this->input->post('registrationtype');
		$data['user_profiles']['boothassistant'] = ($this->input->post('boothassistant'))?1:0;
		/*
		$data['user_profiles']['course_1'] = $this->input->post('course_1');
		$data['user_profiles']['course_2'] = $this->input->post('course_2');
		$data['user_profiles']['course_3'] = $this->input->post('course_3');
		$data['user_profiles']['course_4'] = $this->input->post('course_4');
		$data['user_profiles']['ipaid'] = $this->input->post('ipaid');
		*/
		$data['user_profiles']['judge'] = $this->input->post('judge');
		$data['user_profiles']['golf'] = $this->input->post('golf');
		$data['user_profiles']['galadinner'] = $this->input->post('galadinner');
		$data['user_profiles']['galadinneraux'] = $this->input->post('galadinneraux');
		$data['user_profiles']['golfcurr'] = $this->input->post('golfcurr');
		$data['user_profiles']['galadinnercurr'] = $this->input->post('galadinnercurr');
		$data['user_profiles']['total_usd'] = $this->input->post('total_usd');
		$data['user_profiles']['total_idr'] = $this->input->post('total_idr');
		
		$prefix = $this->config->item('convention_prefix');
        $prefix = $prefix[$data['user_profiles']['registrationtype']];
        
		$data['user_profiles']['conv_id'] = substr_replace($this->input->post('conv_id'),$prefix,1,1);

		// Check how the account should be activated
		switch($this->preference->item('activation_method'))
		{
			case 'none':
				// Send welcome email, account already activated
				$data['users']['active'] = 1;
				$activation_message = $this->lang->line('userlib_no_activation');
				break;

			case 'admin':
				// Admin must activate, do nothing
				$activation_message = $this->lang->line('userlib_admin_activation');
				break;

			default:
				// Send email with activation link
				$this->load->helper('string');
				$data['users']['activation_key'] = random_string('alnum',32);
				$activation_message = sprintf($this->lang->line('userlib_email_activation'), site_url('auth/activate/'.$data['users']['activation_key']), $this->preference->item('account_activation_time'));
				break;
		}

        if( is_null($id)){
      		$this->db->trans_begin();
      		// Add user details to DB
      		$this->user_model->insert('Users',$data['users']);

      		// Get the auto insert ID
      		$data['user_profiles']['user_id'] = $this->db->insert_id();
    		
      		$id = $data['user_profiles']['user_id'];

      		// Add user_profile details to DB
      		$this->user_model->insert('UserProfiles',$data['user_profiles']);
        }else{

            $data['users']['modified'] = date('Y-m-d H:i:s');

			$usr = $this->user_model->getUsers(array('users.id'=>$data['users']['id']));
			$usr = $usr->row_array();
			
			//$usr['conv_id'] = str_pad($usr['conv_id'], 8, "0", STR_PAD_LEFT);
			
			if($usr['conv_seq'] == 0){
			    $new_conv = $this->_increment_field('conv_seq',$data['users']['id']);
			}else{
			    $new_conv = $usr['conv_seq'];
			}

		    $conv_code = $prefix;
		    $seq_code = str_pad($new_conv, 6, "0", STR_PAD_LEFT);
			//$data['user_profiles']['conv_id'] = substr_replace($data['user_profiles']['conv_id'],$prefix,0,1);
            
            $c_id = explode('-',$data['user_profiles']['conv_id']);
    		$c_id[0] = str_pad($conv_code, 2, "0", STR_PAD_RIGHT);
    		$c_id[2] = $seq_code;
    		
    		//print_r($c_id);
    		    		
    		$data['user_profiles']['conv_id'] = implode('-',$c_id);

  

			$this->db->trans_begin();
			$this->user_model->update('Users',$data['users'],array('id'=>$data['users']['id']));
			

			// The && count($profile) > 0 has been added here since if no update keys=>values
			// are passed to the update method it errors saying the set method must be set
			// See bug #51
			if($this->preference->item('allow_user_profiles') && count($data['user_profiles']) > 0)
			{
                //print $data['user_profiles']['golf'];
    		    if($data['user_profiles']['golf'] == $this->config->item('golf_domestic') || $data['user_profiles']['golf'] == $this->config->item('golf_overseas')){
        			$wait = $this->user_model->addWaitList($data['users']['id']);
    			}else{
        			$data['user_profiles']['golfwait'] = 0;
    			}
    			
				$this->user_model->update('UserProfiles',$data['user_profiles'],array('user_id'=>$data['users']['id']));

    		    if($data['user_profiles']['golf'] == 0 && $data['user_profiles']['golfwait'] == 0){
        			$wait = $this->user_model->recalcWaitList();
    			}

			}
			
        }

		if ($this->db->trans_status() === FALSE)
		{
			// Registration failed
			$this->db->trans_rollback();

			flashMsg('error',$this->lang->line('userlib_registration_failed'));
			if($is_update == 'update'){
    			redirect('user/profile/update','location');
			}else{
    			redirect('register/user','location');
			}
		}
		else
		{
			// User registered
			$this->db->trans_commit();
			
	        
			//print $this->db->last_query();
			
			//print ($is_update)?'User profile updated successfully':$this->lang->line('userlib_registration_success');

			// Send email to user
			
            $edata = $this->_createnotification($id);
			
		    $this->user_email->send($edata['email'],'Convention & Short Course Registration','public/email_conv_sc',$edata);
			
			flashMsg('success',($is_update == 'update')?'User successfully registered':$this->lang->line('userlib_registration_success'));

			redirect('register/convention','location');
		}
	}

	/**
	 * Process registration
	 *
	 * Creat the new user accounts for the registered user. When this
	 * is called all the data should be valid and no more checks should
	 * be needed
	 *
	 * @access private
	 */
	function _register_shortcourses($id = null, $is_update = null)
	{
		// Build
		//print $is_update;
		//print_r($_POST);
		$data['users']['id'] = $id;
		$data['user_profiles']['course_1'] = $this->input->post('course_1');
		$data['user_profiles']['course_2'] = $this->input->post('course_2');
		$data['user_profiles']['course_3'] = $this->input->post('course_3');
		$data['user_profiles']['course_4'] = $this->input->post('course_4');
		$data['user_profiles']['course_5'] = $this->input->post('course_5');

		/*
		$data['user_profiles']['judge'] = $this->input->post('judge');
		$data['user_profiles']['ipaid'] = $this->input->post('ipaid');
		$data['user_profiles']['registertype'] = $this->input->post('registertype');
		$data['user_profiles']['registrationtype'] = $this->input->post('registrationtype');
		$data['user_profiles']['boothassistant'] = ($this->input->post('boothassistant'))?1:0;
		$data['user_profiles']['golf'] = $this->input->post('golf');
		$data['user_profiles']['galadinner'] = $this->input->post('galadinner');
		$data['user_profiles']['golfcurr'] = $this->input->post('golfcurr');
		$data['user_profiles']['galadinnercurr'] = $this->input->post('galadinnercurr');
		*/
		$data['user_profiles']['total_usd_sc'] = $this->input->post('total_usd_sc');
		$data['user_profiles']['total_idr_sc'] = $this->input->post('total_idr_sc');
		
		$sc_code = ($data['user_profiles']['course_1'] == 0)?0:1;
		$sc_code += ($data['user_profiles']['course_2'] == 0)?0:2;
		$sc_code += ($data['user_profiles']['course_3'] == 0)?0:4;
		$sc_code += ($data['user_profiles']['course_4'] == 0)?0:8;
		$sc_code += ($data['user_profiles']['course_5'] == 0)?0:16;
		
		$sc_code = str_pad($sc_code, 2, "0", STR_PAD_LEFT);
		
		$c_id = explode('-',$this->input->post('conv_id'));
		$c_id[1] = $sc_code;
		
		$data['user_profiles']['conv_id'] = implode('-',$c_id);
		
//		$data['user_profiles']['conv_id'] = substr_replace($this->input->post('conv_id'),$sc_code,3,0);
		
        
		// Check how the account should be activated
		switch($this->preference->item('activation_method'))
		{
			case 'none':
				// Send welcome email, account already activated
				$data['users']['active'] = 1;
				$activation_message = $this->lang->line('userlib_no_activation');
				break;

			case 'admin':
				// Admin must activate, do nothing
				$activation_message = $this->lang->line('userlib_admin_activation');
				break;

			default:
				// Send email with activation link
				$this->load->helper('string');
				$data['users']['activation_key'] = random_string('alnum',32);
				$activation_message = sprintf($this->lang->line('userlib_email_activation'), site_url('auth/activate/'.$data['users']['activation_key']), $this->preference->item('account_activation_time'));
				break;
		}

        if( is_null($id)){
      		$this->db->trans_begin();
      		// Add user details to DB
      		$this->user_model->insert('Users',$data['users']);

      		// Get the auto insert ID
      		$data['user_profiles']['user_id'] = $this->db->insert_id();
    		
      		$id = $data['user_profiles']['user_id'];

      		// Add user_profile details to DB
      		$this->user_model->insert('UserProfiles',$data['user_profiles']);
        }else{
            $data['users']['modified'] = date('Y-m-d H:i:s');

			$usr = $this->user_model->getUsers(array('users.id'=>$data['users']['id']));
			$usr = $usr->row_array();
						
			if($usr['sc_seq'] == 0){
			    $new_conv = $this->_increment_field('sc_seq',$data['users']['id']);
			}else{
			    $new_conv = $usr['sc_seq'];
			}

            $c_id = explode('-',$data['user_profiles']['conv_id']);
            $c_id[1] = $sc_code;

            if($usr['conv_seq'] == 0){
    		    $seq_code = str_pad($new_conv, 6, "0", STR_PAD_LEFT);
        		$c_id[2] = $seq_code;
            }
            
			//$data['user_profiles']['conv_id'] = substr_replace($data['user_profiles']['conv_id'],$prefix,0,1);
            
    		
    		//print_r($c_id);
    		    		
    		$data['user_profiles']['conv_id'] = implode('-',$c_id);
    		
			
			
			//$usr['conv_id'] = str_pad($usr['conv_id'], 8, "0", STR_PAD_LEFT);
			
			//$data['user_profiles']['conv_id'] = substr_replace($usr['conv_id'],$prefix,0,1);
			//$data['user_profiles']['conv_id'] = substr_replace($usr['conv_id'],$this->config->item('shortcourse_prefix'),3,1);
			

    			$this->db->trans_begin();
    			$this->user_model->update('Users',$data['users'],array('id'=>$data['users']['id']));

    			// The && count($profile) > 0 has been added here since if no update keys=>values
    			// are passed to the update method it errors saying the set method must be set
    			// See bug #51
    			if($this->preference->item('allow_user_profiles') && count($data['user_profiles']) > 0)
    			{
    				$this->user_model->update('UserProfiles',$data['user_profiles'],array('user_id'=>$data['users']['id']));
    			}
        }

		if ($this->db->trans_status() === FALSE)
		{
			// Registration failed
			$this->db->trans_rollback();

			flashMsg('error',$this->lang->line('userlib_registration_failed'));
			if($is_update == 'update'){
    			redirect('user/profile/update','location');
			}else{
    			redirect('register/user','location');
			}
		}
		else
		{
			// User registered
			$this->db->trans_commit();
			
	        
			//print $this->db->last_query();
			
			//print ($is_update)?'User profile updated successfully':$this->lang->line('userlib_registration_success');

			// Send email to user
			$user = $this->user_model->getUsers(array('users.id'=>$id));
			$user = $user->row_array();
			
			$edata = array(
                    'username'=> $user['username'],
                    'salutation' => $user['salutation'],
                    'fullname'=> $user['firstname'].' '.$user['lastname'],
                    'email'=> $user['email'],
                    'conv_id'=> $user['conv_id'],
                    'course_1' => $user['course_1'],
                    'course_2' => $user['course_2'],
                    'course_3' => $user['course_3'],
                    'course_4' => $user['course_4'],
                    'course_5' => $user['course_5'],
                    'total_usd' => $user['total_usd_sc'],
                    'total_idr' => $user['total_idr_sc'],
                    'site_name'=>$this->preference->item('site_name'),
                    'site_url'=>base_url()
			);
			
			$edata = $this->_createnotification($id);
            
		    $this->user_email->send($edata['email'],'Convention & Short Courses Registration','public/email_conv_sc',$edata);
			
			flashMsg('success',($is_update == 'update')?'User successfully registered':$this->lang->line('userlib_registration_success'));

			redirect('register/shortcourses','location');
		}
	}

	function ajaxcompany(){
	    $q = $this->input->post('term');
		$com = $this->user_model->getCompany($q);
		$com = $com->result_array();
		$co = array();
		foreach($com as $b){
		    $co[] = array('id'=>$b['company'],'label'=>$b['company'],'value'=>$b['company']);
		}
		print json_encode($co);
	}

	function ajaxuser(){
	    $q = $this->input->post('term');
		$com = $this->user_model->getUserCompany($q);
		$com = $com->result_array();
		$co = array();
		foreach($com as $b){
		    $co[] = array('id'=>$b['user_id'],'label'=>$b['firstname'].' '.$b['lastname'].', '.$b['company'],'value'=>$b['user_id'],'company'=>$b['company']);
		}
		print json_encode($co);
	}

	
	function ajaxbooth(){
	    $q = $this->input->post('term');
		$booth = $this->user_model->getBooth($q);
		//print $this->db->last_query();
		$booth = $booth->result_array();
		$bon = array();
		foreach($booth as $b){
		    if($b['orderstatus'] == 'open'){
		        $orderstatus = ' is '.$b['orderstatus'];
		    }else if($b['orderstatus'] == 'preassigned'){
		        $orderstatus = ' is '.$b['orderstatus'];
		    }else{
		        $orderstatus = ' is '.$b['orderstatus'].' by '.$b['orderby'];
		    }
		    $bon[] = array('id'=>$b['booth_number'],'label'=>$b['booth_number'].$orderstatus,'value'=>$b['booth_number']);
		}
		print json_encode($bon);
	}
	
	function ajaxbook(){
	    $b = $this->input->post('b');
	    $c = $this->input->post('c');
	    $p = $this->input->post('p');

	    $entitlement = 0;
        $price_total = 0;
	    	    
	    $booth = $this->user_model->getBoothDetail(array('booth_number'=>$b));
	    $bo = $booth->row_array();
	    if($bo['orderstatus'] != 'open' && $bo['orderby'] == $c){
	        $msg = 'Your company have already booked Booth '.$b;
	        $status = 'err';
	    }else if($bo['orderstatus'] != 'open' && $bo['orderby'] != $c){
	        $msg = 'Another company has already booked Booth '.$b;
	        $status = 'err';
	    }else if($bo['orderstatus'] == 'open'){

    	    $bor = $this->user_model->getBoothDetail(array('orderby'=>$c));
    	    
    	    if($bor->num_rows() >= $this->preference->item('booth_booking_limit')){
    	        $msg = 'Maximum order exceeded ( '.$this->preference->item('booth_booking_limit').' booths )';
    	        $status = 'err';
    	    }else if(!$this->_checkopen()){
    	        $msg = 'Booth Booking for Exhibitor is not open yet, please be patience.';
    	        $status = 'err';
    	    }else{
    	        $res = $this->user_model->update('Booth',array('orderstatus'=>'booked','pic_id'=>$p,'orderby'=>$c),array('booth_number'=>$b,'orderstatus'=>'open'));
                /*
                $result = $this->db->affected_rows();
                if($result < 0){
        	        $msg = 'Another company has already booked Booth '.$b;
        	        $status = 'err';
                }else{
                */
                    $msg = 'Congratulation ! You have successfully book Booth: '.$b.'. Please check your email for further instruction to complete the booking process.';
                    $status = 'success';
                /*
                }
                */
                /*send booking notification email*/
                
                $user = $this->user_model->getUsers(array('users.id'=>$p));
    			$user = $user->row_array();
    			
    			$bor = $this->user_model->getBoothDetail(array('booth_number'=>$b));
        	    $bor = $bor->row_array();
        	    
        	    $ord = $bor;
        	    $ord['actiontype'] = 'booking';
        	    unset($ord['id']);
    			$this->user_model->insert('BoothOrderHistory',$ord);
                
                $edata = array(
        			'salutation'=> $user['salutation'],
        			'firstname'=>$user['firstname'],
        			'lastname'=>$user['lastname'],
                    'company'=>$user['company'],
                    'street'=>$user['street'],
                    'street2'=>$user['street2'],
                    'city'=>$user['city'],
                    'zip'=>$user['zip'],
                    'country'=>$user['country'],
                    'username'=> $user['username'],
                    'booth_number'=> $b,
                    'hall'=> $bor['hall'],
                    'type'=> $bor['type'],
                    'width' => $bor['width'],
                    'length' =>$bor['length'],
                    'area'=>$bor['area'],
                    'pic_id'=>$p,
                    'letter_date' => date('d-m-Y',strtotime($bor['ordertimestamp'])),
                    'book_date'=>date('d-m-Y H:i:s',strtotime($bor['ordertimestamp']))
    			);
    			
    			$bookingpdf = @$this->_bookingpdf($edata);
    			
    			$attachment = array(
    			                        $this->config->item('attachment_path').$bookingpdf,
    			                        $this->config->item('attachment_path').'Ex_Terms_Conditions.pdf'
    			                    );
    			
    			$cc = array('quadmice@quadevent.com');
    			$subject = 'Booth Space Order Confirmation - Booth '.$bor['booth_number'].' - '.date('d-m-Y H:i:s',strtotime($bor['ordertimestamp'])).' - '.$this->preference->item('site_name');
			    $this->user_email->send($user['email'],$subject,'public/email_book',$edata,$cc,$attachment);
    			
    	    }
    	    
	    }

	    $booth = $this->user_model->getBoothDetail(array('orderby'=>$c));
	    $booth = $booth->result_array();
        $html = "<ol id='reservation'>";
        $price_total = 0;
        $sqm_total = 0;
        foreach($booth as $bot){
            if($bot['orderstatus'] == 'booked'){
                $statusto = 'booked by';
                $button = sprintf("<span class=\"cancel_button\" onClick=\"javascript:cancelBook('%s')\" >cancel</span>",$bot['booth_number']);
            }else if($bot['orderstatus'] == 'sold'){
                $statusto = 'sold to';
                $button = "<span class=\"sold_button\" >sold</span>";
            }else{
                $button = "";
            }
            $html.= sprintf("<li>Booth %s - %s sq m - %s %s on behalf of %s - %s %s %s</li>",
                    $bot['booth_number'],
                    $bot['area'],
                    $statusto,
                    $bot['firstname'].' '.$bot['lastname'],
                    $bot['orderby'],
                    $bot['type'],
                    'USD '.number_format($bot['price_total']),
                    $button
                    );
            
            /*
            $html.= sprintf("<li>Booth %s - %s sq m - booked by %s on behalf of %s - %s %s  <span class=\"cancel_button\" onClick=\"javascript:cancelBook('%s')\">cancel</span></li>",
                    $bot['booth_number'],
                    $bot['area'],
                    $bot['firstname'].' '.$bot['lastname'],
                    $bot['orderby'],
                    $bot['type'],
                    'USD '.number_format($bot['price_total']),
                    $bot['booth_number']
                    );
            */
            $price_total += $bot['price_total'];
	        $sqm_total +=$bot['area'];
        }
        if(count($booth) < $this->preference->item('booth_booking_limit')){
            for($i=0; $i < ($this->preference->item('booth_booking_limit') - count($booth));$i++){
                $html .= "<li>- empty slot -</li>";
            }
        }
        
        $html.="</ol>";
        $entitlement = ceil(($sqm_total / 9)*2);
        $entitlement = ($entitlement <= 10)?$entitlement:10;
        
        $price_total = 'USD '.number_format($price_total);


	    print json_encode(array('result'=>$html,'msg'=>$msg,'status'=>$status,'total_price'=>$price_total,'entitlement'=>$entitlement));
	}

	
	function ajaxcancel(){
	    $b = $this->input->post('b');
	    $c = $this->input->post('c');
	    $p = $this->input->post('p');

	    $entitlement = 0;
        $price_total = 0;
	    
	    $booth = $this->user_model->getBoothDetail(array('booth_number'=>$b));
	    $bo = $booth->row_array();
	    
	    $bore = $bo;
	    
	    $price_total = 0;
        $sqm_total = 0;
	    if($bo['orderstatus'] != 'open' && $bo['orderby'] == $c){
	        $res = $this->user_model->update('Booth',array('orderstatus'=>'open','pic_id'=>'','orderby'=>''),array('booth_number'=>$b));
            $msg ='Cancellation success. Booth: '.$b.' is now released and open for other booking.';
            $status = 'success';
            
            /*send booking notification email*/

            $user = $this->user_model->getUsers(array('users.id'=>$p));
			$user = $user->row_array();
			
    	    $ord = $bo;
    	    $ord['actiontype'] = 'cancel';
    	    unset($ord['id']);
			$this->user_model->insert('BoothOrderHistory',$ord);
			
            
            $edata = array(
    			'salutation'=> $user['salutation'],
    			'firstname'=>$user['firstname'],
    			'lastname'=>$user['lastname'],
                'company'=>$user['company'],
                'street'=>$user['street'],
                'street2'=>$user['street2'],
                'city'=>$user['city'],
                'zip'=>$user['zip'],
                'country'=>$user['country'],
                'username'=> $user['username'],
                'booth_number'=> $b,
                'hall'=> $bore['hall'],
                'type'=> $bore['type'],
                'width' => $bore['width'],
                'length' =>$bore['length'],
                'area'=>$bore['area'],
                'pic_id'=>$p,
                'book_date'=>date('d-m-Y H:i:s',strtotime($bore['ordertimestamp'])),
                'letter_date' => date('d-m-Y',strtotime($bore['ordertimestamp'])),
                'cancel_date'=>date('d-m-Y H:i:s',time())
			);
			$cc = array('quadmice@quadevent.com');
			$subject = 'Booth Space Order Cancellation - Booth '.$bore['booth_number'].' - '.date('d-m-Y H:i:s',time()).' - '.$this->preference->item('site_name');
		    $this->user_email->send($user['email'],$subject,'public/email_cancel',$edata,$cc);
            
            
	    }else if($bo['orderstatus'] != 'open' && $bo['orderby'] != $c){
	        $msg = 'Another company has already booked Booth '.$b;
	        $status = 'err';
	    }else if($bo['orderstatus'] == 'open'){
	        $msg = 'Booth '.$b.' already open';
	        $status = 'err';
	    }
	    
	    $booth = $this->user_model->getBoothDetail(array('orderby'=>$c));
	    $booth = $booth->result_array();
        $html = "<ol id='reservation'>";
        foreach($booth as $bot){
            if($bot['orderstatus'] == 'booked'){
                $statusto = 'booked by';
                $button = sprintf("<span class=\"cancel_button\" onClick=\"javascript:cancelBook('%s')\" >cancel</span>",$bot['booth_number']);
            }else if($bot['orderstatus'] == 'sold'){
                $statusto = 'sold to';
                $button = "<span class=\"sold_button\" >sold</span>";
            }else{
                $button = "";
            }
            $html.= sprintf("<li>Booth %s - %s sq m - %s %s on behalf of %s - %s %s %s</li>",
                    $bot['booth_number'],
                    $bot['area'],
                    $statusto,
                    $bot['firstname'].' '.$bot['lastname'],
                    $bot['orderby'],
                    $bot['type'],
                    'USD '.number_format($bot['price_total']),
                    $button
                    );
            /*
            $html.= sprintf("<li>Booth %s - %s sq m - booked by %s on behalf of %s - %s %s  <span class=\"cancel_button\" onClick=\"javascript:cancelBook('%s')\">cancel</span></li>",
                    $bot['booth_number'],
                    $bot['area'],
                    $bot['firstname'].' '.$bot['lastname'],
                    $bot['orderby'],
                    $bot['type'],
                    'USD '.number_format($bot['price_total']),
                    $bot['booth_number']
                    );
            */
            $price_total += $bot['price_total'];
	        $sqm_total +=$bot['area'];
        }
        if(count($booth) < $this->preference->item('booth_booking_limit')){
            for($i=0; $i < ($this->preference->item('booth_booking_limit') - count($booth));$i++){
                $html .= "<li>- empty slot -</li>";
            }
        }
        
        $entitlement = ceil(($sqm_total / 9)*2);
        $entitlement = ($entitlement <= 10)?$entitlement:10;
        
        $price_total = 'USD '.number_format($price_total);
        $html.="</ol>";
	    
	    print json_encode(array('result'=>$html,'msg'=>$msg,'status'=>$status,'total_price'=>$price_total,'entitlement'=>$entitlement));
	}
	
	function _bookingpdf($data)
    {
        $this->load->library('cezpdf');
        
        $this->cezpdf->ezText("Jakarta, ".$data['letter_date']);
        $this->cezpdf->ezText("\n",10);
        $this->cezpdf->ezText('Subject: Commitment Letter');
        $this->cezpdf->ezText("\n",10);
        $quad_address = "For the attention of:\n";
        $quad_address .= "Quad MICE\n";
        $quad_address .= "Co-Organizer of the 35th IPA Annual Convention & Exhibition 2011\n";
        $quad_address .= "Jl. Pangeran Antasari no. 16 Paas\n";
        $quad_address .= "Cipete Selatan\n";
        $quad_address .= "Jakarta 12410\n\n\n";
        
        $quad_address .= "Dear Sir / Madame,\n";
        $quad_address .= "We confirm our registration for booth space at the 35th IPA Annual Convention &\n";
        $quad_address .= "Exhibition 2011 as specified in your Confirmation Letter:\n";
        
        $this->cezpdf->ezText($quad_address,10);
        
        $booth_size = sprintf("%s m x %s m = %s sq m",$data['width'],$data['length'],$data['area']);
        
        $booth = "1. Company : ".$data['company']."\n";
        $booth .= "2. Booth number : ".$data['booth_number']."\n";
        $booth .= "3. Booth Size : ".$booth_size."\n";
        
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

        $pdfcode = $this->cezpdf->ezOutput();
        
        $filename = 'Commitment_Letter_IPA_'.$data['booth_number'].'_'.$data['pic_id'].'.pdf';
        
        $fp=fopen($this->config->item('attachment_path').$filename,'wb');
        fwrite($fp,$pdfcode);
        fclose($fp);
        
        return $filename;
    }
    
	function _termspdf($data)
    {
        $this->load->library('cezpdf');
        
        $this->cezpdf->ezText("Exhibitor – Terms and Conditions",12,array('justification'=>'center',));
        
        $this->cezpdf->ezText("Jakarta, ".$data['letter_date']);
        $this->cezpdf->ezText("\n",10);
        $this->cezpdf->ezText('Subject: Commitment Letter');
        $this->cezpdf->ezText("\n",10);
        $quad_address = "For the attention of:\n";
        $quad_address .= "Quad MICE\n";
        $quad_address .= "Co-Organizer of the 35th IPA Annual Convention & Exhibition 2011\n";
        $quad_address .= "Jl. Pangeran Antasari no. 16 Paas\n";
        $quad_address .= "Cipete Selatan\n";
        $quad_address .= "Jakarta 12410\n\n\n";
        
        $quad_address .= "Dear Sir / Madame,\n";
        $quad_address .= "We confirm our registration for booth space at the 35th IPA Annual Convention &\n";
        $quad_address .= "Exhibition 2011 as specified in your Confirmation Letter:\n";
        
        $this->cezpdf->ezText($quad_address,10);
        
        $booth_size = sprintf("%s m x %s m = %s sq m",$data['width'],$data['length'],$data['area']);
        
        $booth = "1. Company : ".$data['company']."\n";
        $booth .= "2. Booth number : ".$data['booth_number']."\n";
        $booth .= "3. Booth Size : ".$booth_size."\n";
        
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

        $pdfcode = $this->cezpdf->ezOutput();
        
        $filename = 'Commitment_Letter_IPA_'.$data['booth_number'].'_'.$data['pic_id'].'.pdf';
        
        $fp=fopen($this->config->item('attachment_path').$filename,'wb');
        fwrite($fp,$pdfcode);
        fclose($fp);
        
        return $filename;
    }    
	
	function _checkopen(){
	    $open = true;
        if( time() > strtotime($this->preference->item('exhibition_registration_date')) && $this->preference->item('exhibition_registration_date') != '' && $this->preference->item('exhibition_registration_date') != '[TBA]'){
            $open = true;
        }else{
            $open = false;
        }
        
        if($this->session->userdata('company') == 'Quad'){
            $open = true;
        }
        
        return $open;
	}
	
	function floorplan($image){
	    print '<img src='.base_url().'public/fp/'.$image.'.jpg />';
	}
	
	function clock($register, $random = null){
	    $open = true;
        if( time() > strtotime($this->preference->item($register.'_registration_date')) && $this->preference->item('exhibition_registration_date') != '' && $this->preference->item('exhibition_registration_date') != '[TBA]'){
            $open = true;
        }else{
            $open = false;
        }

        if($this->session->userdata('company') == 'Quad'){
            $open = true;
        }
        
        if($open == true){
            $html = 'open';
        }else{
    	    $html = date('d-m-Y H:i:s',time());
        }
        
        print $html;
	}
	
	function _createnotification($id){
	    
	    $user = $this->user_model->getUsers(array('users.id'=>$id));
		$user = $user->row_array();
		
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
            'golf' => ($user['golf'] == 0)?'No':'IDR '.number_format($user['golf']),
            'golfwait' => ($user['golfwait'] > 0)?'Yes':'No',
            'galadinner' => ($user['galadinner'] == 0)?'No':'IDR '.number_format($user['galadinner']),
            'total_usd' => number_format($user['total_usd']),
            'total_idr' => number_format($user['total_idr'])
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
        
        $this->load->library('parser');
                    
        if($is_conv){
            $convention_detail = $this->parser->parse('email/convention_detail',$convention);
        }else{
            $convention_detail = "Not Registered for Convention";
        }

        if($is_short){
            $shortcourse_detail = $this->parser->parse('email/shortcourse_detail',$short);
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
                
                'convention_detail'=>$convention_detail,
                'shortcourse_detail'=>$shortcourse_detail,

                'grand_total_usd' => $user['total_usd_sc'] + $user['total_usd'],
                'grand_total_idr' => $user['total_idr_sc'] + $user['total_idr'],
                
                'site_name'=>$this->preference->item('site_name'),
                'site_url'=>base_url(),
                'email'=>$user['email']
		);
		
		//print_r( $edata);
		
		return $edata;
	    
	}
	
	function _increment_field($field,$id){
	    return $this->user_model->increment_field($field,$id);
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

}


/* End of file welcome.php */
/* Location: ./modules/welcome/controllers/welcome.php */