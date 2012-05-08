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
 * Statistic_widget Class
 *
 * This class contains the code to create the statistic widget.
 */
class Ipa_stat_widget
{
	function Ipa_stat_widget()
	{
		$this->CI =& get_instance();

		$this->CI->load->module_model('auth','user_model');
		$this->CI->load->module_config('register','ipa');
		
	}

	function create()
	{
		// Get total number of members
		$query = $this->CI->user_model->getUsers('users.group = 1');
		$data['total_members'] = $query->num_rows();

		// Get total number of unactivated members
		$query = $this->CI->user_model->getUsers('((conv_seq > 0 or (conv_seq = 0 and foc = 1)) OR (profiles.course_1 + profiles.course_2 + profiles.course_3 + profiles.course_4 + profiles.course_5 > 0)) and users.group = 1 ');
		$data['total_convex_members'] = $query->num_rows();

		$query = $this->CI->user_model->getUsers('(conv_seq > 0 or (conv_seq = 0 and foc = 1)) and users.group = 1 ');
		$data['total_convention_members'] = $query->num_rows();
		
		//print $this->CI->db->last_query();

        $convql = ' ( registertype > 0 and (course_1 + course_2 + course_3 + course_4 + course_5 = 0))'; 
        $convql .= ' or ( registertype = 0 and (course_1 + course_2 + course_3 + course_4 + course_5 > 0))'; 
        $convql .= ' or ( registertype > 0 and (course_1 + course_2 + course_3 + course_4 + course_5 > 0))';

		$query = $this->CI->user_model->getUsers('profiles.registertype > 0 and (profiles.course_1 + profiles.course_2 + profiles.course_3 + profiles.course_4 + profiles.course_5 > 0) and users.group = 1 ');
		$data['total_convention_shortcourse_members'] = $query->num_rows();

		$query = $this->CI->user_model->getUsers('profiles.registertype > 0 and (profiles.course_1 + profiles.course_2 + profiles.course_3 + profiles.course_4 + profiles.course_5 = 0) and users.group = 1 ');
		$data['total_convention_only_members'] = $query->num_rows();

		$query = $this->CI->user_model->getUsers('profiles.registertype = 0 and (profiles.course_1 + profiles.course_2 + profiles.course_3 + profiles.course_4 + profiles.course_5 > 0) and users.group = 1 ');
		$data['total_shortcourse_only_members'] = $query->num_rows();

		$query = $this->CI->user_model->getUsers('profiles.registrationtype != \'\' and conv_lock = 1 and users.group = 1 ');
		$data['total_paid_convention_members'] = $query->num_rows();

		$query = $this->CI->user_model->getUsers('profiles.course_1 + profiles.course_2 + profiles.course_3 + profiles.course_4 + profiles.course_5 > 0 and sc_lock = 1 and users.group = 1 ');
		$data['total_paid_shortcourse_members'] = $query->num_rows();

        // courses drill down
		$query = $this->CI->user_model->getUsers('profiles.registertype = 0 and profiles.course_1 = '.$this->CI->config->item('course_1_member').' and users.group = 1 ');
		$data['total_course_1_only_member'] = $query->num_rows();

		$query = $this->CI->user_model->getUsers('profiles.registertype = 0 and profiles.course_1 = '.$this->CI->config->item('course_1_non_member').' and users.group = 1 ');
		$data['total_course_1_only_non_member'] = $query->num_rows();

		$query = $this->CI->user_model->getUsers('profiles.registertype = 0 and profiles.course_2 = '.$this->CI->config->item('course_2_member').' and users.group = 1 ');
		$data['total_course_2_only_member'] = $query->num_rows();

		$query = $this->CI->user_model->getUsers('profiles.registertype = 0 and profiles.course_2 = '.$this->CI->config->item('course_2_non_member').' and users.group = 1 ');
		$data['total_course_2_only_non_member'] = $query->num_rows();

		$query = $this->CI->user_model->getUsers('profiles.registertype = 0 and profiles.course_3 = '.$this->CI->config->item('course_3_member').' and users.group = 1 ');
		$data['total_course_3_only_member'] = $query->num_rows();

		$query = $this->CI->user_model->getUsers('profiles.registertype = 0 and profiles.course_3 = '.$this->CI->config->item('course_3_non_member').' and users.group = 1 ');
		$data['total_course_3_only_non_member'] = $query->num_rows();

		$query = $this->CI->user_model->getUsers('profiles.registertype = 0 and profiles.course_4 = '.$this->CI->config->item('course_4_member').' and users.group = 1 ');
		$data['total_course_4_only_member'] = $query->num_rows();

		$query = $this->CI->user_model->getUsers('profiles.registertype = 0 and profiles.course_4 = '.$this->CI->config->item('course_4_non_member').' and users.group = 1 ');
		$data['total_course_4_only_non_member'] = $query->num_rows();

		$query = $this->CI->user_model->getUsers('profiles.registertype = 0 and profiles.course_5 = '.$this->CI->config->item('course_5_member').' and users.group = 1 ');
		$data['total_course_5_only_member'] = $query->num_rows();

		$query = $this->CI->user_model->getUsers('profiles.registertype = 0 and profiles.course_5 = '.$this->CI->config->item('course_5_non_member').' and users.group = 1 ');
		$data['total_course_5_only_non_member'] = $query->num_rows();

        //course with convention
        $query = $this->CI->user_model->getUsers('profiles.registertype > 0 and profiles.course_1 = '.$this->CI->config->item('course_1_member').' and users.group = 1 ');
		$data['total_course_1_member'] = $query->num_rows();

		$query = $this->CI->user_model->getUsers('profiles.registertype > 0 and profiles.course_1 = '.$this->CI->config->item('course_1_non_member').' and users.group = 1 ');
		$data['total_course_1_non_member'] = $query->num_rows();

		$query = $this->CI->user_model->getUsers('profiles.registertype > 0 and profiles.course_2 = '.$this->CI->config->item('course_2_member').' and users.group = 1 ');
		$data['total_course_2_member'] = $query->num_rows();

		$query = $this->CI->user_model->getUsers('profiles.registertype > 0 and profiles.course_2 = '.$this->CI->config->item('course_2_non_member').' and users.group = 1 ');
		$data['total_course_2_non_member'] = $query->num_rows();

		$query = $this->CI->user_model->getUsers('profiles.registertype > 0 and profiles.course_3 = '.$this->CI->config->item('course_3_member').' and users.group = 1 ');
		$data['total_course_3_member'] = $query->num_rows();

		$query = $this->CI->user_model->getUsers('profiles.registertype > 0 and profiles.course_3 = '.$this->CI->config->item('course_3_non_member').' and users.group = 1 ');
		$data['total_course_3_non_member'] = $query->num_rows();

		$query = $this->CI->user_model->getUsers('profiles.registertype > 0 and profiles.course_4 = '.$this->CI->config->item('course_4_member').' and users.group = 1 ');
		$data['total_course_4_member'] = $query->num_rows();

		$query = $this->CI->user_model->getUsers('profiles.registertype > 0 and profiles.course_4 = '.$this->CI->config->item('course_4_non_member').' and users.group = 1 ');
		$data['total_course_4_non_member'] = $query->num_rows();

		$query = $this->CI->user_model->getUsers('profiles.registertype > 0 and profiles.course_5 = '.$this->CI->config->item('course_5_member').' and users.group = 1 ');
		$data['total_course_5_member'] = $query->num_rows();

		$query = $this->CI->user_model->getUsers('profiles.registertype > 0 and profiles.course_5 = '.$this->CI->config->item('course_5_non_member').' and users.group = 1 ');
		$data['total_course_5_non_member'] = $query->num_rows();
		
		
		$data['total_convention_members'] = $data['total_convention_shortcourse_members'] + $data['total_convention_only_members'] + $data['total_shortcourse_only_members'];
		
		$query = $this->CI->user_model->getUsers("(conv_seq > 0) and foc = 0 and profiles.registrationtype ='Professional Domestic' and users.group = 1 ");
		$data['pro_domestic_convention'] = $query->num_rows(); 

		$query = $this->CI->user_model->getUsers("(conv_seq > 0) and foc = 0 and profiles.registrationtype ='Professional Overseas' and users.group = 1 ");
		$data['pro_overseas_convention'] = $query->num_rows();

		$query = $this->CI->user_model->getUsers("(conv_seq > 0) and foc = 0 and profiles.registrationtype ='Student Domestic' and users.group = 1 ");
		$data['student_domestic_convention'] = $query->num_rows();

		$query = $this->CI->user_model->getUsers("(conv_seq > 0) and foc = 0 and profiles.registrationtype ='Student Overseas' and users.group = 1 ");
		$data['student_overseas_convention'] = $query->num_rows();

		$query = $this->CI->user_model->getUsers("(conv_seq > 0) and foc = 0 and profiles.registrationtype !='' and users.group = 1 ");
		$data['total_convention_attendees'] = $query->num_rows();

		$query = $this->CI->user_model->getUsers("(conv_seq > 0 or (conv_seq = 0 and foc = 1)) and users.group = 1 ");
		$data['total_convention_plus_foc_attendees'] = $query->num_rows();

		$query = $this->CI->user_model->getUsers('conv_seq = 0 and profiles.foc = 1 and profiles.exhibitor = 1 and users.group = 1 ');
		$data['convention_by_exhibitor_entitlement'] = $query->num_rows();

		 
		$query = $this->CI->user_model->getUsers('profiles.golf > 0 and profiles.golfwait <= 0 and users.group = 1');
		$data['golf_members'] = $query->num_rows();

		$query = $this->CI->user_model->getUsers('profiles.golf > 0 and profiles.golfwait > 0 and users.group = 1 ');
		$data['golfwait_members'] = $query->num_rows();

		$query = $this->CI->user_model->getUsers('profiles.galadinner > 0 and users.group = 1 ');
		$data['galadinner_members'] = $query->num_rows();

		$query = $this->CI->user_model->getUsers('profiles.galadinneraux > 0 and users.group = 1 ');
		$data['galadinneraux_members'] = $query->num_rows();

		$query = $this->CI->user_model->getUsers('profiles.judge = \'yes\' and (profiles.registrationtype =\'Professional Domestic\' or profiles.registrationtype =\'Professional Overseas\') and users.group = 1 ');
		$data['judge_members'] = $query->num_rows();
		
		

		$query = $this->CI->user_model->getUsers('profiles.foc = 1 and users.group = 1 ');
		$data['exhibitor_entitlement'] = $query->num_rows();

		$query = $this->CI->user_model->getUsers('profiles.foc = 0 and profiles.exhibitor = 1 and users.group = 1 ');
		$data['exhibitor_non_entitlement'] = $query->num_rows();

		$query = $this->CI->user_model->getUsers('profiles.exhibitor = 1 and users.group = 1 ');
		$data['exhibitor_personnel'] = $query->num_rows();

		$query = $this->CI->user_model->getUsers('profiles.foc = 1  and profiles.exhibitor = 1 and profiles.registrationtype =\'\'  and users.group = 1 ');
		$data['entitled_convention'] = $query->num_rows();
        
        //non convention participants
        
        $query = $this->CI->user_model->getVisitors();
		$data['visitors'] = $query->num_rows();
		
        foreach($this->CI->config->item('off_roles') as $item){
            $query = $this->CI->user_model->getOfficials(array("registrationtype"=>"'".$item."'"));
    		$data[str_replace(" ","_",strtolower($item))."_num"] = $query->num_rows();
        }
        
        //attendees count by day
		
		$date = '2011-05-18';
		$query = $this->CI->user_model->getAttendeeCount('Attendee',$date);
		$data['convention_18'] = $query->num_rows();

		$query = $this->CI->user_model->getAttendeeCount('Official',$date);
		$data['official_18'] = $query->num_rows();
		
		$data['total_official_18'] = 0;
		foreach($this->CI->config->item('off_roles') as $item){
            $query = $this->CI->user_model->getNonOfficialCount($item,$date);
    		$data[str_replace(" ","_",strtolower($item))."_18"] = $query->num_rows();
    		$data['total_official_18'] += $data[str_replace(" ","_",strtolower($item))."_18"];
        }

		$query = $this->CI->user_model->getAttendeeCount('Visitor',$date);
		$data['visitor_18'] = $query->num_rows();

		$date = '2011-05-19';
		$query = $this->CI->user_model->getAttendeeCount('Attendee',$date);
		$data['convention_19'] = $query->num_rows();

		$query = $this->CI->user_model->getAttendeeCount('Official',$date);
		$data['official_19'] = $query->num_rows();

		$data['total_official_19'] = 0;
		foreach($this->CI->config->item('off_roles') as $item){
            $query = $this->CI->user_model->getNonOfficialCount($item,$date);
    		$data[str_replace(" ","_",strtolower($item))."_19"] = $query->num_rows();
    		$data['total_official_19'] += $data[str_replace(" ","_",strtolower($item))."_19"];
        }

		$query = $this->CI->user_model->getAttendeeCount('Visitor',$date);
		$data['visitor_19'] = $query->num_rows();

		$date = '2011-05-20';
		$query = $this->CI->user_model->getAttendeeCount('Attendee',$date);
		$data['convention_20'] = $query->num_rows();

		$query = $this->CI->user_model->getAttendeeCount('Official',$date);
		$data['official_20'] = $query->num_rows();

		$data['total_official_20'] = 0;
		foreach($this->CI->config->item('off_roles') as $item){
            $query = $this->CI->user_model->getNonOfficialCount($item,$date);
    		$data[str_replace(" ","_",strtolower($item))."_20"] = $query->num_rows();
    		$data['total_official_20'] += $data[str_replace(" ","_",strtolower($item))."_20"];
        }

		$query = $this->CI->user_model->getAttendeeCount('Visitor',$date);
		$data['visitor_20'] = $query->num_rows();
		
		$data['total_visitor_attending'] = $data['convention_18'] + $data['official_18'] + $data['visitor_18'];
		$data['total_visitor_attending'] += $data['convention_19'] + $data['official_19'] + $data['visitor_19'];
		$data['total_visitor_attending'] += $data['convention_20'] + $data['official_20'] + $data['visitor_20'];
		
		$query = $this->CI->user_model->getNationalityCount();
		$data['nationality_count'] = $query->result_array();

		//offline additional
		$query = $this->CI->user_model->fetch('Offline','param_val',null,array('param_name'=>'golf'));
		$g = $query->row_array();
		
		$data['golf_offline_members'] = $g['param_val'];

		$data['golf_total_members'] = $data['golf_members'] + $data['golf_offline_members'];

		$query = $this->CI->user_model->fetch('Offline','param_val',null,array('param_name'=>'galadinner'));
		$g = $query->row_array();

		$data['galadinner_offline_members'] = $g['param_val'];

		$data['galadinner_total_members'] = $data['galadinner_members'] + $data['galadinneraux_members'] + $data['galadinner_offline_members'];
		
		$query = $this->CI->user_model->fetch('Offline','param_val',null,array('param_name'=>'boothassistant'));
		$g = $query->row_array();
		
		$data['booth_assistant'] = $g['param_val'];
		
		$data['exhibitor_personnel'] = $data['exhibitor_entitlement'] + $data['booth_assistant'];
		
        
		
		$data['members'] = $this->CI->user_model->getBoothDetail();
		$total_rev = 0;
		$total_book = 0;
		$total_sold = 0;
		$total_sold_rev = 0;
		$total_area = 0;
		$total_book_area = 0;
		$total_sold_area = 0;
		
		$result = $data['members']->result_array();
		foreach($result as $row){
            if($row['orderstatus'] == 'booked'){
                $total_rev += $row['price_total'];
                $total_book++;
                $total_book_area += $row['area'];
            }
            if($row['orderstatus'] == 'sold'){
                $total_sold_rev += $row['price_total'];
                $total_sold++;
                $total_sold_area += $row['area'];
            }
            $total_area += $row['area'];
		}
        
        $data['booth_total_rev'] = $total_rev;
        $data['booth_total_book'] = $total_book;
        $data['booth_total_sold_rev'] = $total_sold_rev;
        $data['booth_total_sold'] = $total_sold;
        $data['booth_total_booth'] = count($result);
        $data['booth_total_area'] = $total_area;
        $data['booth_total_book_area'] = $total_book_area;
        $data['booth_total_sold_area'] = $total_sold_area;
        $data['booth_open_booth'] = $data['booth_total_booth'] - ( $total_sold + $total_book );
        $data['booth_open_booth_area'] = $data['booth_total_area'] - ( $total_sold_area + $total_book_area );
		
//		print_r($data);

		return $this->CI->load->module_view('dashboard',$this->CI->config->item('backendpro_template_admin') . 'dashboard/ipa_stats',$data,TRUE);
	}
}

/* End of file Statistic_Widget.php */
/* Location: ./modules/dashboard/libraries/Statistic_Widget.php */