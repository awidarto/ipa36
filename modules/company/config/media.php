<?php  if (!defined('BASEPATH')) exit('No direct script access allowed');

$config['absolute_upload_path'] = '/Applications/xampp/htdocs/runner2/public/uploads/';
$config['absolute_media_path'] = '/Applications/xampp/htdocs/runner2/public/media/';

$config['documents_scope_array']    = array(
     	'profiles.company'=>'Company',  	
    );
    
$config['documents_sort_array'] = array(
     	'profiles.company'=>'Company'
    );

$config['order_validation_array'] = array(
        'id'=>array('field'=>'ID','rule'=>'trim|xss_clean'),
        'ordername'=>array('field'=>'Title','rule'=>'trim|xss_clean'),
        'clientid'=>array('field'=>'Client','rule'=>'trim|xss_clean'),
        'mediaid'=>array('field'=>'Media ID','rule'=>'trim|xss_clean'),
        'mediatype'=>array('field'=>'Media Type','rule'=>'trim|xss_clean'),
        'monthstart'=>array('field'=>'Start Month','rule'=>'trim|xss_clean'),
        'monthend'=>array('field'=>'End Month','rule'=>'trim|xss_clean'),
        'yearstart'=>array('field'=>'Start Year','rule'=>'trim|xss_clean'),
        'yearend'=>array('field'=>'End Year','rule'=>'trim|xss_clean'),
        'descriptions' =>array('field'=>'Descriptions','rule'=>'trim|xss_clean'),
    );

$config['documents_validation_array'] = array(
        'title'=>array('field'=>'Title','rule'=>'trim|xss_clean'),
        'mediatype'=>array('field'=>'Media Type','rule'=>'trim|xss_clean'),
    );

    
$config['documents_types'] = array(
    "Fax"=>"Fax",
    "Letter"=>"Letter",
    "Memo"=>"Memo",
    "Contract"=>"Contract"
    );

$config['documents_groups'] = array(
    "Incoming"=>"Incoming",
    "Outgoing"=>"Outgoing",
    "Internal"=>"Internal"
    );

$config['documents_classifications'] = array('Confidential'=>'Confidential','Regular'=>'Regular');
    
$config['documents_datefield_array']    = array(
        'created'=>'Date Created'
    );
