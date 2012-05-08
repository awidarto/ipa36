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
$config['userlib_action_login'] = 'user';
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
$config['member_domestic'] = '4000000';
$config['member_overseas'] = '450';

$config['non_member_domestic'] = '3500000';
$config['non_member_overseas'] = '390';

$config['student_domestic'] = '300000';
$config['student_overseas'] = '90';

$config['boothassistant'] = '75';
  
$config['course_1_member'] = '1100';
$config['course_1_non_member'] = '1150';
                                
$config['course_2_member'] = '900';
$config['course_2_non_member'] = '950';
                                
$config['course_3_member'] = '1100';
$config['course_3_non_member'] = '1150';
                                
$config['course_4_member'] = '900';
$config['course_4_non_member'] = '950';

$config['course_5_member'] = '1100';
$config['course_5_non_member'] = '1150';

$config['golf_domestic'] = '2500000';
$config['golf_overseas'] = '225';

$config['galadinner_domestic'] = '450000';
$config['galadinner_overseas'] = '40';
$config['galadinner_sponsor'] = '0';

$config['ba30'] = '30000';
$config['ba150'] = '150000';

$config['pro_domestic_label'] = 'Professional Domestic';
$config['pro_overseas_label'] = 'Professional Overseas';
$config['student_domestic_label'] = 'Student Domestic';
$config['student_overseas_label'] = 'Student Overseas';
$config['booth_assistant_label'] = 'Booth Assistant';

$config['convention_prefix']['Professional Domestic'] = 1;
$config['convention_prefix']['Professional Overseas'] = 2;
$config['convention_prefix']['Student Domestic'] = 3;
$config['convention_prefix']['Student Overseas'] = 4;
$config['convention_prefix']['Booth Assistant'] = 5;
$config['shortcourse_prefix'] = 1;

$config['golf_quota'] = 120;
$config['golf_sponsor_quota'] = 24;
$config['galadinner_quota'] = 350;
$config['galadinner_sponsor_quota'] = 50;

$config['import_valid_column'] = array(
    'salutation',
    'username',
    'email',
    'firstname',
    'lastname',
    'nationality',
    'gender',
    'dob',
    'street',
    'street2',
    'city',
    'zip',
    'mobile',
    'company',
    'position',
    'fax',
    'phone',
    'country',
	'photo_filename'
);

$config['conv_valid'] = array(
    'registertype',
    'golf',
    'galadinner',
    'galadinneraux1',
    'galadinneraux2',
    'invoice_address_conv',
    'judge'
);

$config['sc_valid'] = array(
    'member',
    'course_1',
    'course_2',
    'course_3',
    'course_4',
    'course_5',
    'invoice_address_sc'
);

$config['ex_valid'] = array(
    'exhibitor',
    'foc',
    'media',
    'ba30',
    'ba150',
    'invoice_address_ex'
);


$config['off_roles'] = array(
    'Committee'=>'Committee',
    'Media'=>'Media',
    'Organizer'=>'Organizer',
    'Security'=>'Security',
    'Contractor'=>'Contractor',
    'Worker'=>'Worker',
    'Booth Assistant 30'=>'Booth Assistant 30',
    'Booth Assistant 150'=>'Booth Assistant 150',
    'Student Volunteer'=>'Student Volunteer',
    'EC Participant'=>'EC Participant',
    'Technical Assistant Pre-Event'=>'Technical Assistant Pre-Event',
    'On Site Technical Support'=>'On-Site Technical Support'
);

$config['off_prefix'] = array(
    'Committee'=>'COM',
    'Media'=>'MED',
    'Organizer'=>'ORG',
    'Security'=>'SEC',
    'Contractor'=>'CTR',
    'Worker'=>'WRK',
    'Booth Assistant 30'=>'B30',
    'Booth Assistant 150'=>'B15',
    'Student Volunteer'=>'SVO',
    'EC Participant'=>'ECP',
    'Technical Assistant Pre-Event'=>'TAP',
    'On-Site Technical Support'=>'OTS'
);

/* from 35th event
$config['off_roles'] = array(
    'Committee'=>'Committee',
    'VVIP'=>'VVIP',
    'VIP'=>'VIP',
    'VIP Assistant'=>'VIP Assistant',
    'Booth Assistant 30'=>'Booth Assistant 30',
    'Booth Assistant 150'=>'Booth Assistant 150',
    'Media'=>'Media',
    'Media Partner'=>'Media Partner',
    'Speaker'=>'Speaker',
    'Student Volunteer'=>'Student Volunteer',
    'Guest'=>'Guest',
    'Organizer'=>'Organizer',
    'IPA BOD'=>'IPA BOD',
    'Student'=>'Student',
    'Participant'=>'Participant',
    'Exhibitor'=>'Exhibitor',
    'Cocktail'=>'Cocktail'              
);
*/

/* End of file userlib.php */
/* Location: ./modules/auth/config/userlib.php */