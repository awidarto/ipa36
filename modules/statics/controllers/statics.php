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
class Statics extends Public_Controller
{
	function Statics()
	{
	    
		parent::Public_Controller();
		$this->load->helper('date');
		// Set breadcrumb
		$this->bep_site->set_crumb('Home','http://www.ipa.or.id/convex');
        
	}

	function index($page = null)
	{
	    if(is_null($page)){
	        $page = 'main';
	    }
		// Display Page
		$data['header'] = "Main";
		$data['page'] = $this->config->item('backendpro_template_public') . $page;
		$data['module'] = 'statics';
		$this->load->view($this->_container,$data);
	}

	function howto()
	{

		// Display Page
		$data['header'] = "General Information";
        $this->bep_site->set_crumb($data['header'],'statics/howto');
        
		$data['page'] = $this->config->item('backendpro_template_public') . 'generalinfo';
		$data['module'] = 'statics';
		$this->load->view($this->_container,$data);
	}

	function terms()
	{
		// Display Page
		$data['header'] = "Terms & Condition";
        $this->bep_site->set_crumb($data['header'],'statics/terms');
		$data['page'] = $this->config->item('backendpro_template_public') . 'terms';
		$data['module'] = 'statics';
		$this->load->view($this->_container,$data);
	}

	function sponsorship()
	{
		// Display Page
		$data['header'] = "Sponsorship";
        $this->bep_site->set_crumb($data['header'],'statics/sponsorship');
		$data['page'] = $this->config->item('backendpro_template_public') . 'sponsorship';
		$data['module'] = 'statics';
		$this->load->view($this->_container,$data);
	}
	

}


/* End of file welcome.php */
/* Location: ./modules/welcome/controllers/welcome.php */