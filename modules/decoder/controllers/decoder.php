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
class Decoder extends Public_Controller
{
	function Decoder()
	{
		parent::Public_Controller();
		
		$this->bep_site->set_crumb('Home','http://www.ipa.or.id/convex');
		
	}
	
	function index()
	{
	    $this->bep_site->set_crumb('Scanner','decoder');
		
	    // Display Page
		$data['header'] = "Badge Scanner";
		$data['page'] = $this->config->item('backendpro_template_public') . 'decoder';
		$data['module'] = 'decoder';
		$this->load->view($this->_container,$data);
	}

	function quick()
	{
	    $this->bep_site->set_crumb('Quick Scanner','decoder');
		
	    // Display Page
		$data['header'] = "Quick Badge Scanner";
		$data['page'] = $this->config->item('backendpro_template_public') . 'quickdecoder';
		$data['module'] = 'decoder';
		$this->load->view($this->_container,$data);
	}

}

?>