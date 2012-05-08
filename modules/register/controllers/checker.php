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
class Checker extends Public_Controller
{
	function Checker()
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
	    $file = $this->config->item('public_folder').'xls/before2.csv';
        $row = 1;
        $missing = 0;
        if (($handle = fopen($file, "r")) !== FALSE) {
            while (($data = fgetcsv($handle, 1000, ",")) !== FALSE) {
                $num = count($data);
                if($num == 2){
                    if($data[0] != "" && $data[1] != ""){
                        $data[0] = addslashes($data[0]);
                        $data[1] = addslashes($data[1]);
                        $where = "profiles.company like '%".$data[0]."%' and ( users.username like '%".$data[1]."%' or profiles.fullname like '%".$data[1]."%' )";
                        //$where = "users.username like '%".$data[1]."%'";
                        $usr = $this->user_model->getUsers($where);
                        //print $usr->num_rows();
                        //print $this->db->last_query();
                        //print $row." : ".$data[0]." : ".$data[1]." -> ".$usr->num_rows()."<br />\r\n";
                        if($usr->num_rows() == 0){
                            $missing++;
                            //print "\"".$row."\",\"".$data[0]."\",\"".$data[1]."\"\r\n";
                            print "\"".$data[0]."\",\"".$data[1]."\"\r\n";
                        }
                    }
                }
                $row++;
            }
            fclose($handle);
        }
        
        print 'total rows '.$row.' missing data '.$missing;
	}
	
}