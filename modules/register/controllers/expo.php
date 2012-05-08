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
class Expo extends Public_Controller
{
	function Expo()
	{
		parent::Public_Controller();
		$this->load->library('validation');
		$this->load->helper('form');
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
	

	/**
	 * Register form for individual
	 *
	 * Display the register form to the user
	 *
	 * @access public
	 * @param string $container View file container
	 */
	function package($id = null)
	{
        
        $validator = $this->_validator_setup($id);

		
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
			$data['header'] = $this->lang->line('userlib_register');
			$data['captcha'] = ($this->preference->item('use_registration_captcha')?$this->_generate_captcha():'');
			$data['page'] = $this->config->item('backendpro_template_public') . 'my_form_register_1';
			$data['module'] = 'register';
			$this->load->view($this->_container,$data);
		}
		else
		{
			// Submit form
			$this->_register_individual($id);
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
        
        $validator = $this->_validator_setup();
        
        $this->validation->set_fields($validator['fields']);
		$this->validation->set_rules($validator['rules']);
		

		if ( $this->validation->run() === FALSE )
		{
			// Output any errors
			$this->validation->output_errors();

			// Display page
			$data['header'] = $this->lang->line('userlib_register');
			$data['captcha'] = ($this->preference->item('use_registration_captcha')?$this->_generate_captcha():'');
			$data['page'] = $this->config->item('backendpro_template_public') . 'my_form_register';
			$data['module'] = 'register';
			$this->load->view($container,$data);
		}
		else
		{
			// Submit form
			$this->_register();
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
		$this->validation->set_default_value('company','Some Company');
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
		$this->validation->set_default_value('boothassistant','1');
		$this->validation->set_default_value('domain',base_url());
    }
	
	function _validator_setup($id = null){
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
    		$fields['mobile'] = 'Last Name';
    		$fields['company'] = 'Company';
    		$fields['dob'] = 'Date of Birth';
    		$fields['dob_y'] = 'Year of Birth';
    		$fields['dob_m'] = 'Month of Birth';
    		$fields['dob_d'] = 'Day of Birth';
    		$fields['street'] = 'Address 1';
    		$fields['street2'] = 'Address 2';
    		$fields['city'] = 'City';
    		$fields['zip'] = 'ZIP';
    		$fields['country'] = 'Country';
    		$fields['phone'] = 'Phone';
    		$fields['fax'] = 'Fax';
    		$fields['boothassistant'] = 'Booth Assistant';
    		$fields['domain'] = 'Domain';
		}

		// Set Rules
		if( is_null($id)){
    		$rules['username'] = 'trim|required|max_length[32]|spare_username';
    		$rules['password'] = 'trim|required|min_length['.$this->preference->item('min_password_length').']|matches[confirm_password]';
    		$rules['email'] = 'trim|required|max_length[254]|valid_email|spare_email';
		}

		if($this->preference->item('allow_user_profiles')){
    		$rules['firstname'] = 'trim|required';
    		$rules['lastname'] = 'trim';
    		$rules['salutation'] = 'trim|required';
    		$rules['nationality'] = 'trim|required';
    		$rules['mobile'] = 'trim|required';
    		$rules['company'] = 'trim';
    		//$rules['dob'] = 'trim';
    		$rules['dob_y'] = 'trim';
    		$rules['dob_m'] = 'trim';
    		$rules['dob_d'] = 'trim';
    		$rules['street'] = 'trim';
    		$rules['street2'] = 'trim';
    		$rules['city'] = 'trim';
    		$rules['zip'] = 'trim';
    		$rules['country'] = 'trim';
    		$rules['phone'] = 'trim';
    		$rules['fax'] = 'trim';
    		$rules['boothassistant'] = 'trim';
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
	function _register_individual($id = null)
	{
		// Build
		$data['users']['id'] = $id;
		$data['users']['username'] = $this->input->post('username');
		$data['users']['email'] = $this->input->post('email');
		$data['users']['password'] = $this->userlib->encode_password($this->input->post('password'));
		$data['users']['group'] = $this->preference->item('default_user_group');
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
		$data['user_profiles']['street2'] = $this->input->post('street2');
		$data['user_profiles']['city'] = $this->input->post('city');
		$data['user_profiles']['zip'] = $this->input->post('zip');
		$data['user_profiles']['mobile'] = $this->input->post('mobile');
		$data['user_profiles']['fax'] = $this->input->post('fax');
		$data['user_profiles']['phone'] = $this->input->post('phone');
		$data['user_profiles']['registertype'] = $this->input->post('registertype');
		$data['user_profiles']['boothassistant'] = ($this->input->post('boothassistant'))?1:0;
		$data['user_profiles']['country'] = $this->input->post('country');
		$data['user_profiles']['domain'] = $this->input->post('domain');

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

    		// Add user_profile details to DB
    		$this->user_model->insert('UserProfiles',$data['user_profiles']);
        }else{
            $data['users']['modified'] = date('Y-m-d H:i:s');
			
			if($this->input->post('password') == ''){
			    unset($data['users']['password']);
			}

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
			redirect('register/individual/'.$data['users']['id'],'location');
		}
		else
		{
			// User registered
			$this->db->trans_commit();
/*
			// Send email to user
			$edata = array(
                    'username'=> $data['users']['username'],
                    'email'=> $data['users']['email'],
                    'password'=> $this->input->post('password'),
                    'activation_message' => $activation_message,
                    'site_name'=>$this->preference->item('site_name'),
                    'site_url'=>base_url()
			);
			$this->user_email->send($data['users']['email'],$this->lang->line('userlib_email_register'),'public/email_register',$edata);
			flashMsg('success',$this->lang->line('userlib_registration_success'));
*/
			redirect('register/individual/'.$data['users']['id'],'location');
		}
	}


}


/* End of file welcome.php */
/* Location: ./modules/welcome/controllers/welcome.php */