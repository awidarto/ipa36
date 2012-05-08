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
class Booth extends Admin_Controller
{
	function Booth()
	{
		parent::Admin_Controller();

		$this->load->helper('form');
		$this->load->module_config('register','ipa');
		$this->load->module_library('auth','User_email');

		// Load userlib language
		$this->lang->load('userlib');

		// Set breadcrumb
		$this->bep_site->set_crumb('Booth','auth/admin/booth');

		// Check for access permission
		//check('Members');

		// Load the validation library
		$this->load->library('validation');

		log_message('debug','BackendPro : Members class loaded');
	}

	/**
	 * View Members
	 *
	 * @access public
	 */
	function index()
	{
		// Get Member Infomation
		$data['members'] = $this->user_model->getBoothDetail();
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
        
        $data['total_rev'] = $total_rev;
        $data['total_book'] = $total_book;
        $data['total_sold_rev'] = $total_sold_rev;
        $data['total_sold'] = $total_sold;
        $data['total_booth'] = count($result);
        $data['total_area'] = $total_area;
        $data['total_book_area'] = $total_book_area;
        $data['total_sold_area'] = $total_sold_area;
        
		// Display Page
		$data['header'] = 'Exhibition Booth';
		$data['page'] = $this->config->item('backendpro_template_admin') . "booth/view";
		$data['module'] = 'auth';
		$this->load->view($this->_container,$data);
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
	    //price_sqm 	price_total 	type 	orderstatus 	orderby 	pic_id 	ordertimestamp
		//$this->validation->set_default_value('field1','value');
		//$this->validation->set_default_value('field2','value');
		$this->validation->set_default_value('booth_number','');
		$this->validation->set_default_value('hall','');
		$this->validation->set_default_value('width','3');
		$this->validation->set_default_value('length','3');
		$this->validation->set_default_value('type','Regular');
		$this->validation->set_default_value('price_sqm','');
    }


	/**                                       
	 * Get User Details                        
	 *
	 * Load user detail values from the submited form
	 *
	 * @access private
	 * @return array
	 */
	function _get_user_details()
	{
		$data['id'] = $this->input->post('id');
		$data['username'] = $this->input->post('username');
		$data['email'] = $this->input->post('email');
		$data['group'] = $this->input->post('group');
		$data['active'] = $this->input->post('active');

		// Only if password is set encode it
		if($this->input->post('password') != '')
		{
			$data['password'] = $this->userlib->encode_password($this->input->post('password'));
		}

		return $data;
	}

	/**
	 * Get Profile Details
	 *
	 * Load user profile detail values from the submited form
	 *
	 * @access private
	 * @return array
	 */
	function _get_profile_details()
	{
		$data = array();
		//$data['field1'] = $this->input->post('field1');
		//$data['field2'] = $this->input->post('field2');
		//$data['field3'] = $this->input->post('field3');
		$data['gender'] = $this->input->post('gender'); 
		$data['fullname'] = $this->input->post('fullname');
		$dob = $this->input->post('dob_y').'-'.$this->input->post('dob_m').'-'.$this->input->post('dob_d');
		$data['dob'] = $dob;
		$data['company'] = $this->input->post('company');
		$data['street'] = $this->input->post('street');
		$data['city'] = $this->input->post('city');
		$data['zip'] = $this->input->post('zip');
		$data['country'] = $this->input->post('country');
		$data['domain'] = $this->input->post('domain');
		return $data;
	}

	/**
	 * Display Member Form
	 *
	 * @access public
	 * @param integer $id Member ID
	 */
	function form($id = NULL)
	{
		// VALIDATION FIELDS
		$fields['id'] = 'ID'; 	
		$fields['booth_number'] = 'Booth Number'; 	
		$fields['hall'] = 'Position'; 	
		$fields['width'] = 'Width'; 	
		$fields['length'] = 'Length'; 	
		$fields['area'] = 'Area'; 	
		$fields['price_sqm'] = 'Price / Sq Meter'; 	
		$fields['price_total'] = 'Total Price'; 	
		$fields['type'] = 'Type'; 	
		$fields['orderstatus'] = 'Order Status'; 	
		$fields['orderby'] = 'Order By'; 	
		$fields['pic_id'] = 'PIC ID';
		$this->validation->set_fields($fields);
		
		$rules['id'] = 'trim'; 	
		$rules['booth_number'] = 'trim'; 	
		$rules['hall'] = 'trim'; 	
		$rules['width'] = 'trim'; 	
		$rules['length'] = 'trim'; 	
		$rules['area'] = 'trim'; 	
		$rules['price_sqm'] = 'trim'; 	
		$rules['price_total'] = 'trim'; 	
		$rules['type'] = 'trim'; 	
		$rules['orderstatus'] = 'trim'; 	
		$rules['orderby'] = 'trim'; 	
		$rules['pic_id'] = 'trim';

		// Setup validation rules
		if( is_null($id))
		{
			// Use create user rules (make sure no-one has the same email)
		}
		else
		{
			// Use edit user rules (make sure no-one other than the current user has the same email)
		}

		// Setup form default values
		if( ! is_null($id) AND ! $this->input->post('submit'))
		{
			// Modify form, first load
			$booth = $this->user_model->getBoothDetail(array('id'=>$id));
			$booth = $booth->row_array();
			$this->validation->set_default_value($booth);
		}
		elseif( is_null($id) AND ! $this->input->post('submit'))
		{

		}
		elseif( $this->input->post('submit'))
		{
			// Form submited, check rules
			$this->validation->set_rules($rules);
		}

		// RUN
		if ($this->validation->run() === FALSE)
		{
			// Display form
			$this->validation->output_errors();
			$data['header'] = ( is_null($id)?'New Booth':'Book Booth');
			$this->bep_site->set_crumb($data['header'],'auth/admin/booth/form/'.$id);
			$data['page'] = $this->config->item('backendpro_template_admin') . "booth/form_booth";
			$data['module'] = 'auth';
			$this->load->view($this->_container,$data);
		}
		else
		{
			// Save form
			if( is_null($id))
			{
				// CREATE
				// Fetch form values

			}
			else
			{
				// SAVE
				
        		$p = $this->input->post('booker');
        		$b = $this->input->post('booth_number');
        		$c = $this->input->post('company');

    	        $res = $this->user_model->update('Booth',array('orderstatus'=>'booked','pic_id'=>$p,'orderby'=>$c),array('booth_number'=>$b,'orderstatus'=>'preassigned'));
                $msg = 'Congratulation ! You have successfully book Booth: '.$b.'. Notification email will be sent to Company\'s Person in Charge';
                $status = 'success';

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

				redirect('auth/admin/booth');
			}
		}
	}
	
	
	function ajaxsold(){
	    $b = $this->input->post('b');

	    $entitlement = 0;
        $price_total = 0;

        $res = $this->user_model->update('Booth',array('orderstatus'=>'sold'),array('booth_number'=>$b,'orderstatus'=>'booked'));
		
		$bor = $this->user_model->getBoothDetail(array('booth_number'=>$b));
	    $bor = $bor->row_array();
	    
	    $ord = $bor;
	    $ord['actiontype'] = 'finalize';
	    unset($ord['id']);
	    $ord['actionby'] = $this->session->userdata('id').':'.$this->session->userdata('username');
		$this->user_model->insert('BoothOrderHistory',$ord);

	    $row = $bor;

        $html = '<td>'.$row['id'].'</td>';
        $html .='<td>'.$row['booth_number'].'</td>';
        $html .='<td>'.$row['width'].' m x '.$row['length'].' m</td>';
        $html .='<td>'.$row['area'].' sqm</td>';
        $html .='<td>'.$row['type'].'</td>';
        $html .='<td>'.$row['hall'].'</td>';
        $html .='<td>USD '.number_format($row['price_sqm']).'</td>';
        $html .='<td>USD '.number_format($row['price_total']).'</td>';
        $html .='<td class="'.$row['orderstatus'].'" >'.$row['orderstatus'].'</td>';
        $html .='<td>'.$row['orderby'].'</td>';
        $html .='<td>'.$row['ordertimestamp'].'</td>';
        $html .='<td class="middle"></td>';
        
        $status = 'success';
        $msg = 'Booth number : '.$b.' sold to '.$row['orderby'];


	    print json_encode(array('result'=>$html,'msg'=>$msg,'status'=>$status,'total_price'=>$price_total,'entitlement'=>$entitlement));
	}
	

	
	function ajaxrelease(){
	    $b = $this->input->post('b');

	    $entitlement = 0;
        $price_total = 0;

        //$res = $this->user_model->update('Booth',array('orderstatus'=>'open','orderby'=>'','pic_id'=>''),array('booth_number'=>$b,'orderstatus'=>'booked'));
		$res = $this->user_model->update('Booth',array('orderstatus'=>'open','orderby'=>'','pic_id'=>''),array('booth_number'=>$b));
        
		$bor = $this->user_model->getBoothDetail(array('booth_number'=>$b));
	    $bor = $bor->row_array();
	    
	    $ord = $bor;
	    $ord['actiontype'] = 'release';
	    unset($ord['id']);
	    $ord['firstname'] = '';
	    $ord['lastname'] = '';
	    $ord['actionby'] = $this->session->userdata('id').':'.$this->session->userdata('username');
		$this->user_model->insert('BoothOrderHistory',$ord);

	    $row = $bor;

        $html = '<td>'.$row['id'].'</td>';
        $html .='<td>'.$row['booth_number'].'</td>';
        $html .='<td>'.$row['width'].' m x '.$row['length'].' m</td>';
        $html .='<td>'.$row['area'].' sqm</td>';
        $html .='<td>'.$row['type'].'</td>';
        $html .='<td>'.$row['hall'].'</td>';
        $html .='<td>USD '.number_format($row['price_sqm']).'</td>';
        $html .='<td>USD '.number_format($row['price_total']).'</td>';
        $html .='<td class="'.$row['orderstatus'].'" >'.$row['orderstatus'].'</td>';
        $html .='<td>'.$row['orderby'].'</td>';
        $html .='<td>'.$row['ordertimestamp'].'</td>';
        $html .='<td class="middle"></td>';
        
        $status = 'success';
        $msg = 'Booth number : '.$b.' has been released back to market';


	    print json_encode(array('result'=>$html,'msg'=>$msg,'status'=>$status,'total_price'=>$price_total,'entitlement'=>$entitlement));
	}
	

	/**
	 * Delete
	 *
	 * Delete the selected users from the system
	 *
	 * @access public
	 */
	function delete()
	{
		if(FALSE === ($selected = $this->input->post('select')))
		{
			redirect('auth/admin/members','location');
		}

		foreach($selected as $user)
		{
			if($user != 1)
			{	// Delete as long as its not the Administrator account
				$this->user_model->delete('Users',array('id'=>$user));
			}
			else
			{
				flashMsg('error',$this->lang->line('userlib_administrator_delete'));
			}
		}

		flashMsg('success',$this->lang->line('userlib_user_deleted'));
		redirect('auth/admin/members','location');
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
	
}
/* End of file members.php */
/* Location: ./modules/auth/controllers/admin/members.php */