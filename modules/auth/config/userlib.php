<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
/**
 * Userlib Configurations
 *
 * Contains all config settings for the Userlib class
 *
 * @package		BackendPro
 * @subpackage 	Configurations
 * @author		Adam Price
 * @copyright	Copyright (c) 2008, Adam Price
 * @license		http://www.gnu.org/licenses/lgpl.html
 * @link		http://www.kaydoo.co.uk/projects/backendpro
 * @filesource
 */

// ------------------------------------------------------------------------

/**
 * Authentication Actions
 *
 * These are all the actions performed when an auth process
 * has been completed DO NOT SEND THE LOGIN ACTIONS BACK TO
 * THE LOGIN CONTROLLER, IT WILL CAUSE AN INFINITE LOOP
 */
$config['userlib_action_login'] = 'user/profile';
$config['userlib_action_logout'] = '';
$config['userlib_action_register'] ='';
$config['userlib_action_activation'] ='';
$config['userlib_action_forgotten_password'] = 'auth/login';
$config['userlib_action_admin_login'] = 'admin';
$config['userlib_action_admin_logout'] = '';

/**
 * User Profile Fields
 *
 * Define here all custom user profile fields and their respective rules.
 * To define a new custom profile field, you must specify an
 * associative array from the database column name => Full Name/Rule.
 * If no rule is given for a specific field it will not be validated.
 */
 
//
  
$config['userlib_profile_fields'] = array(
    'fullname'    => 'Full Name',
    'salutation'    => 'Salutation',
    'firstname'    => 'Full Name',
    'lastname'    => 'Full Name',
    'nationality'    => 'Nationality',
    'mobile'    => 'Cellphone',
    'fax'    => 'Fax',
    'phone'    => 'Telephone',
    'registertype'    => 'Registration Type',
    'gender' => 'Gender', 	
    'dob'     => 'Date of Birth',
	'dob_y' => 'Year of Birth',
	'dob_m' => 'Month of Birth',
	'dob_d' => 'Day of Birth',
    'street' => 'Address 1', 	
    'street2' => 'Address 2', 	
    'city'     => 'City', 	
    'zip'     => 'ZIP', 	
    'ipaid'     => 'IPA Membership Id', 	
    'company'     => 'Company', 	
    'position'     => 'Position', 	
    'country'    => 'Country', 	
    'domain'    => 'domain',
    'boothassistant' => 'Booth Assistant',
    'course_1' => 'Course 1',
    'course_2' => 'Course 2',
    'course_3' => 'Course 3',
    'course_4' => 'Course 4',
    'course_5' => 'Course 5',
    'judge' => 'Judge',
    'galadinner' => 'Gala Dinner',
    'galadinneraux' => 'Accompanying Person',
    'golf' => 'Golf',
    'golfwait' => 'Golf Waiting List',
    'galadinnercurr' => 'Gala Dinner Currency',
    'golfcurr' => 'Golf Currency',
    'total_idr' => 'Total IDR',
    'total_usd' => 'Total USD',
    'total_idr_sc' => 'Total IDR Short Courses',
    'total_usd_sc' => 'Total USD Short Courses',
    'registrationtype'    => 'Registration Type',
    'invoice_address_conv' => 'Invoice Address for Convention',
    'invoice_address_sc' => 'Invoice Address for Short Courses',
    'invoice_address_ex' => 'Invoice Address for Exhibitor',
    'conv_id' => 'Convention ID Number',
    'conv_lock' => 'Convention Lock',
    'sc_lock' => 'Short Courses Lock',
    'conv_seq' => 'Convention Registration Sequence',
    'sc_seq' => 'Short Courses Registration Sequence',
    'ex_seq' => 'Exhibitor Registration Sequence',
    'exhibitor'=> 'Exhibitor',
    'foc'=> 'Exhibitor Entitlement',
    'ba30'=> 'Booth Assistant 30',
    'ba150'=> 'Booth Assistant 150',
    'media' => 'Media'
    
);
$config['userlib_profile_rules'] = array(
    'fullname'    => 'trim|required',
    'salutation'    => 'trim',
    'firstname'    => 'trim',
    'lastname'    => 'trim',
    'nationality'    => 'trim',
    'mobile'    => 'trim',
    'fax'    => 'trim',
    'phone'    => 'trim',
    'registertype'    => 'trim',
    'gender' => 'trim', 	
    'dob'     => 'trim',
	'dob_y' => 'trim',
	'dob_m' => 'trim',
	'dob_d' => 'trim',
    'street' => 'trim', 	
    'street2' => 'trim', 	
    'city'     => 'trim', 	
    'zip'     => 'trim', 	
    'ipaid'     => 'trim', 	
    'company'     => 'trim', 	
    'position'     => 'trim', 	
    'country'    => 'trim', 	
    'domain'    => 'trim',
    'boothassistant' => 'trim',
    'course_1' => 'trim',
    'course_2' => 'trim',
    'course_3' => 'trim',
    'course_4' => 'trim',
    'course_5' => 'trim',
    'judge' => 'trim',
    'galadinner' => 'trim',
    'galadinneraux' => 'trim',
    'golf' => 'trim',
    'golfwait' => 'trim',
    'galadinnercurr' => 'trim',
    'golfcurr' => 'trim',
    'total_idr' => 'trim',
    'total_usd' => 'trim',
    'total_idr_sc' => 'trim',
    'total_usd_sc' => 'trim',
    'registrationtype'    => 'trim',
    'invoice_address_conv' => 'trim',
    'invoice_address_sc' => 'trim',
    'invoice_address_ex' => 'trim',
    'conv_id' => 'trim',
    'conv_lock' => 'trim',
    'sc_lock' => 'trim',
    'conv_seq' => 'trim',
    'sc_seq' => 'trim',
    'ex_seq' => 'trim',
    'exhibitor'=> 'trim',
    'ba30'=> 'trim',
    'ba150'=> 'trim',
    'foc'=> 'trim',
    'media' => 'trim'

);

/* End of file userlib.php */
/* Location: ./modules/auth/config/userlib.php */