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
 * User_model
 *
 * Provides functionaly to query all tables related to the
 * user.
 *
 * @package   	BackendPro
 * @subpackage  Models
 */
class User_model extends Base_model
{
	function User_model()
	{
		parent::Base_model();

		$this->_prefix = $this->config->item('backendpro_table_prefix');
		$this->_TABLES = array(    'Users' => $this->_prefix . 'users',
                                    'UserProfiles' => $this->_prefix . 'user_profiles',
                                    'Visitors' => $this->_prefix . 'visitors',
                                    'Officials' => $this->_prefix . 'officials',
                                    'Checkin' => $this->_prefix . 'checkin',
                                    'Booth' => $this->_prefix . 'booth',
                                    'BoothOrderHistory' => $this->_prefix . 'booth_history',
                                    'Offline' => $this->_prefix . 'offline'
                                    );

		log_message('debug','BackendPro : User_model class loaded');
	}

	/**
	 * Validate Login
	 *
	 * Verify that the given login_field and password
	 * are correct
	 *
	 * @access public
	 * @param string $login_field Email/Username
	 * @param string $password Users password
	 * @return array('valid'=>bool,'query'=>Query)
	 */
	function validateLogin($login_field, $password)
	{
		if( !$password OR !$login_field)
		{
			// If there is no password
			return array('valid'=>FALSE,'query'=>NULL);
		}

		switch($this->preference->item('login_field'))
		{
			case'email':
				$this->db->where('email',$login_field);
				break;

			case 'username':
				$this->db->where('username',$login_field);
				break;

			default:
			    $this->db->where('(email = '.$this->db->escape($login_field).' OR username = '.$this->db->escape($login_field).')');
			    break;
		}

		$this->db->where('password',$password);

		$query = $this->fetch('Users','id,active');
		
		$found = ($query->num_rows() == 1);
		return array('valid'=>$found,'query'=>$query);
	}

	/**
	 * Update Login Date
	 *
	 * Updates a users last_visit record to the current time
	 *
	 * @access public
	 * @param integer $user_id Users user_id
	 */
	function updateUserLogin($id)
	{
		$this->update('Users',array('last_visit'=>date ("Y-m-d H:i:s")),array('id'=>$id));
	}
	
	/**
	 * Valid Email
	 *
	 * Checks the given email is one that belongs to a valid email
	 *
	 * @access public
	 * @param string $email Email to validate
	 * @return boolean
	 */
	function validEmail($email)
	{
		$query = $this->fetch('Users',NULL,NULL,array('email'=>$email));
		return ($query->num_rows() == 0) ? FALSE : TRUE;
	}

	/**
	 * Activate User Account
	 *
	 * When given an activation_key, make that user account active
	 *
	 * @access public
	 * @param string $key Activation Key
	 * @return boolean
	 */
	function activateUser($key)
	{
		$this->update('Users', array('active'=>'1','activation_key'=>NULL), array('activation_key'=>$key));

		return ($this->db->affected_rows() == 1) ? TRUE : FALSE;
	}

	/**
	 * Get Users
	 *
	 * @access public
	 * @param mixed $where Where query string/array
	 * @param array $limit Limit array including offset and limit values
	 * @return object
	 */
	function getUsers($where = NULL, $limit = array('limit' => NULL, 'offset' => ''),$order = array('fields'=>'created','order'=>'desc'))
	{
		// Load the khacl config file so we can get the correct table name
		$this->load->config('khaos', true, true);
		$options = $this->config->item('acl', 'khaos');
		$acl_tables = $options['tables'];

		// If Profiles are enabled load get their values also
		$profile_columns = '';
		if($this->preference->item('allow_user_profiles'))
		{
			// Select only the column names of the profile fields
			$profile_fields_array = array_keys($this->config->item('userlib_profile_fields'));
			//unset pseudo field
			unset($profile_fields_array[11]);
			unset($profile_fields_array[12]);
			unset($profile_fields_array[13]);

			// Implode and seperate with comma
			$profile_columns = implode(', profiles.',$profile_fields_array);
			$profile_columns = (empty($profile_fields_array)) ? '': ', profiles.'.$profile_columns;
		}

		$this->db->select('users.id, users.username, users.email, users.password, users.active, users.last_visit, users.created, users.modified, groups.name `group`, groups.id group_id'.$profile_columns,false);
		$this->db->from($this->_TABLES['Users'] . " users");
		$this->db->join($this->_TABLES['UserProfiles'] . " profiles",'users.id=profiles.user_id');
		$this->db->join($acl_tables['aros'] . " groups",'groups.id=users.group');
		if( ! is_null($where))
		{
			$this->db->where($where,null,false);
		}
		if( ! is_null($limit['limit']))
		{
			$this->db->limit($limit['limit'],( isset($limit['offset'])?$limit['offset']:''));
		}
		
		if( ! is_null($order['fields'])){
		    $this->db->order_by($order['fields'],$order['order']);
		}
		
		return $this->db->get();
	}

	/**
	 * Get Users
	 *
	 * @access public
	 * @param mixed $where Where query string/array
	 * @param array $limit Limit array including offset and limit values
	 * @return object
	 */
	function getUserAttendances($where = NULL, $limit = array('limit' => NULL, 'offset' => ''),$order = array('fields'=>'created','order'=>'desc'))
	{

		// If Profiles are enabled load get their values also
		$profile_columns = '';
		if($this->preference->item('allow_user_profiles'))
		{
			// Select only the column names of the profile fields
			$profile_fields_array = array_keys($this->config->item('userlib_profile_fields'));
			//unset pseudo field
			unset($profile_fields_array[11]);
			unset($profile_fields_array[12]);
			unset($profile_fields_array[13]);

			// Implode and seperate with comma
			$profile_columns = implode(', profiles.',$profile_fields_array);
			$profile_columns = (empty($profile_fields_array)) ? '': ', profiles.'.$profile_columns;
		}

		$this->db->select('users.*,'.$profile_columns,false);
		$this->db->from($this->_TABLES['Checkin'] . " users");
		$this->db->join($this->_TABLES['UserProfiles'] . " profiles",'users.user_id=profiles.user_id', 'left');
		if( ! is_null($where))
		{
			$this->db->where($where,null,false);
		}
		if( ! is_null($limit['limit']))
		{
			$this->db->limit($limit['limit'],( isset($limit['offset'])?$limit['offset']:''));
		}
		
		if( ! is_null($order['fields'])){
		    $this->db->order_by($order['fields'],$order['order']);
		}
		
		return $this->db->get();
	}


	/**
	 * Get Users
	 *
	 * @access public
	 * @param mixed $where Where query string/array
	 * @param array $limit Limit array including offset and limit values
	 * @return object
	 */
	function getUserAttendancesVis($where = NULL, $limit = array('limit' => NULL, 'offset' => ''),$order = array('fields'=>'created','order'=>'desc'))
	{

		// If Profiles are enabled load get their values also
		$profile_columns = '';
		if($this->preference->item('allow_user_profiles'))
		{
			// Select only the column names of the profile fields
			$profile_fields_array = array_keys($this->config->item('userlib_profile_fields'));
			//unset pseudo field
			unset($profile_fields_array[11]);
			unset($profile_fields_array[12]);
			unset($profile_fields_array[13]);

			// Implode and seperate with comma
			$profile_columns = implode(', profiles.',$profile_fields_array);
			$profile_columns = (empty($profile_fields_array)) ? '': ', profiles.'.$profile_columns;
		}

		$this->db->select('users.*,'.$profile_columns,false);
		$this->db->from($this->_TABLES['Checkin'] . " users");
		$this->db->join($this->_TABLES['Visitors'] . " profiles",'users.user_id=profiles.id', 'left');
		if( ! is_null($where))
		{
			$this->db->where($where,null,false);
		}
		if( ! is_null($limit['limit']))
		{
			$this->db->limit($limit['limit'],( isset($limit['offset'])?$limit['offset']:''));
		}
		
		if( ! is_null($order['fields'])){
		    $this->db->order_by($order['fields'],$order['order']);
		}
		
		return $this->db->get();
	}

	/**
	 * Get Users
	 *
	 * @access public
	 * @param mixed $where Where query string/array
	 * @param array $limit Limit array including offset and limit values
	 * @return object
	 */
	function getUserAttendancesOff($where = NULL, $limit = array('limit' => NULL, 'offset' => ''),$order = array('fields'=>'created','order'=>'desc'))
	{

		// If Profiles are enabled load get their values also
		$profile_columns = '';
		if($this->preference->item('allow_user_profiles'))
		{
			// Select only the column names of the profile fields
			$profile_fields_array = array_keys($this->config->item('userlib_profile_fields'));
			//unset pseudo field
			unset($profile_fields_array[11]);
			unset($profile_fields_array[12]);
			unset($profile_fields_array[13]);

			// Implode and seperate with comma
			$profile_columns = implode(', profiles.',$profile_fields_array);
			$profile_columns = (empty($profile_fields_array)) ? '': ', profiles.'.$profile_columns;
		}

		$this->db->select('users.*,'.$profile_columns,false);
		$this->db->from($this->_TABLES['Checkin'] . " users");
		$this->db->join($this->_TABLES['Officials'] . " profiles",'users.user_id=profiles.id', 'left');
		if( ! is_null($where))
		{
			$this->db->where($where,null,false);
		}
		if( ! is_null($limit['limit']))
		{
			$this->db->limit($limit['limit'],( isset($limit['offset'])?$limit['offset']:''));
		}
		
		if( ! is_null($order['fields'])){
		    $this->db->order_by($order['fields'],$order['order']);
		}
		
		return $this->db->get();
	}


	/**
	 * Get Users
	 *
	 * @access public
	 * @param mixed $where Where query string/array
	 * @param array $limit Limit array including offset and limit values
	 * @return object
	 */
	function getVisitors($where = NULL, $limit = array('limit' => NULL, 'offset' => ''),$order = array('fields'=>'id','order'=>'desc'))
	{

		// If Profiles are enabled load get their values also
		$profile_columns = '';
		if($this->preference->item('allow_user_profiles'))
		{
			// Select only the column names of the profile fields
			$profile_fields_array = array_keys($this->config->item('userlib_profile_fields'));
			//unset pseudo field
			unset($profile_fields_array[11]);
			unset($profile_fields_array[12]);
			unset($profile_fields_array[13]);
            $profile_fields_array[] = 'id';
            $profile_fields_array[] = 'email';
            $profile_fields_array[] = 'created';
            $profile_fields_array[] = 'modified';
			// Implode and seperate with comma
			$profile_columns = implode(', users.',$profile_fields_array);
			$profile_columns = (empty($profile_fields_array)) ? '': ', users.'.$profile_columns;
		}

		$this->db->select($profile_columns,false);
		$this->db->from($this->_TABLES['Visitors'] . " users");

		if( ! is_null($where))
		{
			$this->db->where($where,null,false);
		}
		if( ! is_null($limit['limit']))
		{
			$this->db->limit($limit['limit'],( isset($limit['offset'])?$limit['offset']:''));
		}
		
		if( ! is_null($order['fields'])){
		    $this->db->order_by($order['fields'],$order['order']);
		}
		
		return $this->db->get();
	}

	function getOfficials($where = NULL, $limit = array('limit' => NULL, 'offset' => ''),$order = array('fields'=>'id','order'=>'desc'))
	{

		// If Profiles are enabled load get their values also
		$profile_columns = '';
		if($this->preference->item('allow_user_profiles'))
		{
			// Select only the column names of the profile fields
			$profile_fields_array = array_keys($this->config->item('userlib_profile_fields'));
			//unset pseudo field
			unset($profile_fields_array[11]);
			unset($profile_fields_array[12]);
			unset($profile_fields_array[13]);
            $profile_fields_array[] = 'id';
            $profile_fields_array[] = 'email';
            $profile_fields_array[] = 'created';
            $profile_fields_array[] = 'modified';
			// Implode and seperate with comma
			$profile_columns = implode(', users.',$profile_fields_array);
			$profile_columns = (empty($profile_fields_array)) ? '': ', users.'.$profile_columns;
		}

		$this->db->select($profile_columns,false);
		$this->db->from($this->_TABLES['Officials'] . " users");

		if( ! is_null($where))
		{
			$this->db->where($where,null,false);
		}
		if( ! is_null($limit['limit']))
		{
			$this->db->limit($limit['limit'],( isset($limit['offset'])?$limit['offset']:''));
		}
		
		if( ! is_null($order['fields'])){
		    $this->db->order_by($order['fields'],$order['order']);
		}
		
		return $this->db->get();
	}
	
	
	function getAttendeeCount($type,$date){
	    $query = "SELECT DISTINCT user_id FROM be_checkin WHERE registrationtype = '".$type."' AND date_format( `check_datetime` , '%Y-%m-%d' ) = '".$date."'";
	    
	    $result = $this->db->query($query);
	    
	    return $result;
	}

	function getNonOfficialCount($type,$date){
	    //$query = "SELECT DISTINCT user_id FROM be_checkin WHERE registrationtype = '".$type."' AND date_format( `check_datetime` , '%Y-%m-%d' ) = '".$date."'";

        $query = "SELECT DISTINCT users.user_id FROM be_checkin users LEFT JOIN be_officials profiles ON users.user_id = profiles.id WHERE users.registrationtype = 'Official' AND profiles.registrationtype = '".$type."' AND date_format( users.check_datetime , '%Y-%m-%d' ) = '".$date."'";
	    
	    $result = $this->db->query($query);
	    
	    //print $this->db->last_query();
	    
	    return $result;
	}

	function getNationalityCount(){

        $query = "SELECT distinct nationality,count(*) as natcount FROM be_user_profiles group by nationality order by nationality";
	    
	    $result = $this->db->query($query);
	    
	    //print $this->db->last_query();
	    
	    return $result;
	}


	/**
	 * Get Users
	 *
	 * @access public
	 * @param mixed $where Where query string/array
	 * @param array $limit Limit array including offset and limit values
	 * @return object
	 */
	function getUserBooths($where = NULL, $limit = array('limit' => NULL, 'offset' => ''),$order = array('fields'=>'created','order'=>'desc'))
	{
		// Load the khacl config file so we can get the correct table name
		$this->load->config('khaos', true, true);
		$options = $this->config->item('acl', 'khaos');
		$acl_tables = $options['tables'];

		// If Profiles are enabled load get their values also
		$profile_columns = '';
		if($this->preference->item('allow_user_profiles'))
		{
			// Select only the column names of the profile fields
			$profile_fields_array = array_keys($this->config->item('userlib_profile_fields'));
			//unset pseudo field
			unset($profile_fields_array[11]);
			unset($profile_fields_array[12]);
			unset($profile_fields_array[13]);

			// Implode and seperate with comma
			$profile_columns = implode(', profiles.',$profile_fields_array);
			$profile_columns = (empty($profile_fields_array)) ? '': ', profiles.'.$profile_columns;
		}

		$this->db->select('booth.* , users.id, users.username, users.email, users.password, users.active, users.last_visit, users.created, users.modified, groups.name `group`, groups.id group_id'.$profile_columns,false);
		$this->db->from($this->_TABLES['Booth'] . " booth");
		$this->db->join($this->_TABLES['Users'] . " users",'users.id=booth.pic_id','left');
		$this->db->join($this->_TABLES['UserProfiles'] . " profiles",'users.id=profiles.user_id','left');
		$this->db->join($acl_tables['aros'] . " groups",'groups.id=users.group','left');
		if( ! is_null($where))
		{
			$this->db->where($where,null,false);
		}
		if( ! is_null($limit['limit']))
		{
			$this->db->limit($limit['limit'],( isset($limit['offset'])?$limit['offset']:''));
		}
		
		if( ! is_null($order['fields'])){
		    $this->db->order_by($order['fields'],$order['order']);
		}
		
		return $this->db->get();
	}

	/**
	 * Delete Users
	 *
	 * Extend the delete users function to make sure we delete all data related
	 * to the user
	 *
	 * @access private
	 * @param mixed $where Delete user where
	 * @return boolean
	 */
	function _delete_Users($where)
	{
		// Get the ID's of the users to delete
		$query = $this->fetch('Users','id',NULL,$where);
		foreach($query->result() as $row)
		{
			$this->db->trans_begin();
			// -- ADD USER REMOVAL QUERIES/METHODS BELOW HERE

			// Delete main user details
			$this->db->delete($this->_TABLES['Users'],array('id'=>$row->id));

			// Delete user profile
			$this->delete('UserProfiles',array('user_id'=>$row->id));

			// -- DON'T CHANGE BELOW HERE
			// Check all the tasks completed
			if ($this->db->trans_status() === FALSE)
			{
				$this->db->trans_rollback();
				return FALSE;
			} else
			{
				$this->db->trans_commit();
			}
		}
		return TRUE;
	}
	
	function insertUser($data){
	    //$this->db->protect_identifiers($this->_TABLES['Users']);
        //$this->db->insert($this->db->protect_identifiers($this->_TABLES['Users']), $data,true);
        $ql = sprintf("INSERT INTO be_users (`username`, `group`, `password`, `email`, `created`, `active`) VALUES ('%s', 1, '%s', '%s', '%s', 1)",
            $data['username'],
            $data['password'],
            $data['email'],
            $data['created']
        );
        
        $this->db->query($ql);
        return $this->db->insert_id();
	}

	function getBoothDetail($where = NULL, $limit = array('limit' => NULL, 'offset' => '')){
	    $this->db->select('booth.*,profiles.firstname,profiles.lastname');
		$this->db->from($this->_TABLES['Booth']. " booth");
		$this->db->join($this->_TABLES['UserProfiles'] . " profiles",'booth.pic_id=profiles.user_id','left');

		if( ! is_null($where))
		{
			$this->db->where($where);
		}
		if( ! is_null($limit['limit']))
		{
			$this->db->limit($limit['limit'],( isset($limit['offset'])?$limit['offset']:''));
		}
		return $this->db->get();
	}
	
	function getBooth($where = NULL, $limit = array('limit' => NULL, 'offset' => '')){
	    $this->db->select('booth.*,profiles.firstname,profiles.lastname');
		$this->db->from($this->_TABLES['Booth']. " booth");
		$this->db->join($this->_TABLES['UserProfiles'] . " profiles",'booth.pic_id=profiles.user_id','left');
		
		if( ! is_null($where))
		{
			//$this->db->where($where);
			$this->db->like('booth.booth_number', $where,'both'); 
		}
		if( ! is_null($limit['limit']))
		{
			$this->db->limit($limit['limit'],( isset($limit['offset'])?$limit['offset']:''));
		}
		return $this->db->get();
	}



	function getCompany($where = NULL, $limit = array('limit' => NULL, 'offset' => '')){
	    $this->db->select('company');
	    $this->db->distinct();
		$this->db->from($this->_TABLES['UserProfiles']);
		if( ! is_null($where))
		{
			//$this->db->where($where);
			$this->db->like('company', $where,'both'); 
		}
		if( ! is_null($limit['limit']))
		{
			$this->db->limit($limit['limit'],( isset($limit['offset'])?$limit['offset']:''));
		}
		
		return $this->db->get();
	}

	function getUserByCompany($where = NULL, $limit = array('limit' => NULL, 'offset' => ''),$order = array('fields'=>'created','order'=>'desc')){
	    $this->db->select('company',false);
	    $this->db->distinct();
		$this->db->from($this->_TABLES['UserProfiles']." profiles");
	    $this->db->groupby('company');
		
		if( ! is_null($where))
		{
			$this->db->where($where);
			//$this->db->like('company', $where,'both'); 
		}
		if( ! is_null($limit['limit']))
		{
			$this->db->limit($limit['limit'],( isset($limit['offset'])?$limit['offset']:''));
		}
		
		if( ! is_null($order['fields'])){
		    $this->db->order_by($order['fields'],$order['order']);
		}
		
		$companies = $this->db->get();
		
		$last_query = $this->db->last_query();
		
		$t = array(
		    'company' => '',
            'boothassistant' => 0,
            'course_1' => 0,
            'course_2' => 0,
            'course_3' => 0,
            'course_4' => 0,
            'course_5' => 0,
            'judge' => 0,
            'galadinner' => 0,
            'galadinneraux' => 0, 
            'golf' => 0,
            'golfwait' => 0,
            'total_idr' => 0,
            'total_usd' => 0,
            'total_idr_sc' => 0,
            'total_usd_sc' => 0,
            'registrationtype' => 0,
            'po'=> 0,
            'pd'=> 0,
            'so'=> 0,
            'sd'=> 0,
            'conv_lock' => 0,
            'sc_lock' => 0,
            'conv_seq' => 0,
            'sc_seq' => 0,
            'exhibitor' => 0,
            'foc' => 0,
            'media' => 0
		);
		
		$result = array();
		
		if($companies->num_rows() > 0){
    		foreach($companies->result() as $co){
    		    $res = $this->getUsers("company = '".$co->company."'");
    		    //print $this->db->last_query();
    		    //print_r($res->result());
    		     
    		    
    		    foreach($res->result() as $r){
    		        $entry = $t;
    		        
        		    $entry['company'] = $r->company;
                    $entry['course_1'] += ($r->course_1 == 0)?0:1; 
                    $entry['course_2'] += ($r->course_2 == 0)?0:1;
                    $entry['course_3'] += ($r->course_3 == 0)?0:1;
                    $entry['course_4'] += ($r->course_4 == 0)?0:1;
                    $entry['course_5'] += ($r->course_5 == 0)?0:1;
                    $entry['judge'] += ($r->judge == 'yes')?1:0;
                    $entry['galadinner'] += ($r->galadinner == 0)?0:1;
                    $entry['galadinneraux']  += ($r->galadinneraux == 0)?0:1;
                    $entry['golf'] += ($r->golf == 0)?0:1;
                    $entry['golfwait'] += ($r->golfwait > 0)?1:0;
                    $entry['total_idr'] += $r->total_idr;
                    $entry['total_usd'] += $r->total_usd;
                    $entry['total_idr_sc'] += $r->total_idr_sc;
                    $entry['total_usd_sc'] += $r->total_usd_sc;
                    //$entry['registrationtype']
                    $entry['po'] += ($r->registrationtype == 'Professional Overseas')?1:0;
                    $entry['pd'] += ($r->registrationtype == 'Professional Domestic')?1:0;
                    $entry['so'] += ($r->registrationtype == 'Student Overseas')?1:0;
                    $entry['sd'] += ($r->registrationtype == 'Student Domestic')?1:0;
                    $entry['conv_lock'] += ($r->conv_lock == 0)?0:1;
                    $entry['sc_lock'] += ($r->sc_lock == 0)?0:1;
                    $entry['conv_seq'] += ($r->conv_seq == 0)?0:1;
                    $entry['sc_seq'] += ($r->sc_seq == 0)?0:1;
                    $entry['exhibitor'] += ($r->exhibitor == 0)?0:1;
                    $entry['foc'] += ($r->foc == 0)?0:1;
                    $entry['media'] += ($r->media == 0)?0:1;
    		    }
    		    
    		    $result[] = $entry;
    		}
		}else{
		    return false;
		}
		
		//print_r($result);
		
		$result['last_query'] = $last_query;
		
		return $result;
	}


	function getUserCompany($where = NULL, $limit = array('limit' => NULL, 'offset' => '')){
	    $this->db->select('user_id,firstname,lastname,company');
		$this->db->from($this->_TABLES['UserProfiles']);
		if( ! is_null($where))
		{
			//$this->db->where($where);
			$this->db->like('firstname', $where,'both'); 
			$this->db->or_like('lastname', $where,'both'); 
			$this->db->or_like('company', $where,'both'); 
		}
		if( ! is_null($limit['limit']))
		{
			$this->db->limit($limit['limit'],( isset($limit['offset'])?$limit['offset']:''));
		}
		return $this->db->get();
	}
	
	function addWaitList($id){
	    //print 'SELECT * from '.$this->_TABLES['UserProfiles'].' where golf > 0';
	    $res = $this->db->query('SELECT * from '.$this->_TABLES['UserProfiles'].' where golf > 0');
	    
	    //print $this->db->lastquery();
	    
	    if($res->num_rows() < $this->config->item('golf_quota')){
	        return false;
	    }else{
	        $res = $this->db->query('SELECT max(golfwait) as maxwait from '.$this->_TABLES['UserProfiles'].' where golf > 0');
	        
	        $maxwait = $res->row();
	        $maxwait = $maxwait->maxwait + 1;
    	    
    	    $this->db->query('UPDATE '.$this->_TABLES['UserProfiles'].' SET golfwait = '.$maxwait.' where user_id ='.$id.' AND golfwait = 0');
    	    return true;
	    }
	}
	
	function refreshWaitList($id){
	    //recalculate wait list, only for position after currently changed wait list
	    $waitres = $this->db->query('SELECT golfwait from '.$this->_TABLES['UserProfiles'].' where user_id ='.$id);
	    if($waitres->num_rows() > 0){
    	    $wait = $waitres->row();
    	    $wait = $wait->golfwait;
    	    
    	    //print 'UPDATE '.$this->_TABLES['UserProfiles'].' SET golfwait = golfwait - 1 WHERE golfwait > '.$wait;
    	    $this->db->query('UPDATE '.$this->_TABLES['UserProfiles'].' SET golfwait = golfwait - 1 WHERE golfwait > '.$wait );
    	    //avoid negative wait list
    	    //$this->db->query('UPDATE '.$this->_TABLES['UserProfiles'].' SET golfwait = 0 where golfwait < 0' );
	    }
	    return true;
	}

	function recalcWaitList(){
	    //recalculate wait list, brute force
	    $waitres = $this->db->query('SELECT user_id,golfwait from '.$this->_TABLES['UserProfiles'].' where golfwait > 0 order by golfwait asc');
	    if($waitres->num_rows() > 0){
	        $w = 0;
	        foreach($waitres->result() as $r){
	            $w++;
	            $query = sprintf('UPDATE %s SET golfwait = %s WHERE user_id = %s',$this->_TABLES['UserProfiles'],$w,$r->user_id );
        	    $this->db->query($query);
	        }
	    }
	    return true;
	}
	
	function increment_field($field,$id){
	    $max = $this->db->query('SELECT max('.$field.') as maxval from '.$this->_TABLES['UserProfiles']);
	    if($max->num_rows() > 0){
	        $maxfield = $max->row();
	        $maxfield = $maxfield->maxval;

    		$this->update('UserProfiles', array($field=>$maxfield + 1), array('user_id'=>$id));
    		return ($this->db->affected_rows() == 1) ? $maxfield + 1 : false;
	    }else{
    	    return false;
	    }
	}

	function getOffline($name){
	    $this->update('Offline', array('param_val'=>$val), array('param_name'=>$name));
		return ($this->db->affected_rows() == 1) ? TRUE : FALSE;
	}
	
	function setOffline($name,$val){
	    $this->update('Offline', array('param_val'=>$val), array('param_name'=>$name));
		return ($this->db->affected_rows() == 1) ? TRUE : FALSE;
	}


}

/* End of file: user_model.php */
/* Location: ./modules/auth/controllers/admin/user_model.php */