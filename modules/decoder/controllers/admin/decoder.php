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
class Decoder extends Admin_Controller
{
	function Decoder()
	{
		parent::Admin_Controller();
	}
	
	function index()
	{
	    // Display Page
		$data['header'] = "Badge Decoder";
		$data['page'] = $this->config->item('backendpro_template_admin') . 'decoder';
		$data['module'] = 'decoder';
		$this->load->view($this->_container,$data);
	}
	
	function quick()
	{
	    $this->bep_site->set_crumb('Quick Scanner','decoder');
		
	    // Display Page
		$data['header'] = "Quick Badge Scanner";
		$data['page'] = $this->config->item('backendpro_template_admin') . 'quickdecoder';
		$data['module'] = 'decoder';
		$this->load->view($this->_container,$data);
	}	
	
}

?>