<?php if (!defined('BASEPATH')) exit('No direct script access allowed');
    /**
     * BackendPro
     *
     * A website backend system for developers for PHP 4.3.2 or newer
     *
     * @package			BackendPro
     * @author				Adam Price
     * @copyright			Copyright (c) 2008
     * @license				http://www.gnu.org/licenses/lgpl.html
     * @tutorial				BackendPro.pkg
     */

     // ---------------------------------------------------------------------------

    /**
     * Auth
     *
     * Authentication Controller
     *
     * @package			BackendPro
     * @subpackage		Controllers
     */
	class Conventionpo extends Admin_Controller
	{
		/**
		 * Constructor
		 */
		function Conventionpo()
		{
			// Call parent constructor
			parent::Admin_Controller();
			$this->load->model('Media_model','docs');
			$this->load->module_model('auth','User_model','usermodel');
            $this->load->library('pager');
            $this->load->library('search');
            $this->load->library('upload');
            $this->load->library('preview');
            $this->load->library('CustomEmail');
            $this->load->library('media_lib');
            $this->load->config('pager');
            $this->load->config('media');
            $this->load->dbutil();
            $this->load->helper('download');
            $this->controller = 'media/admin/conventionpo';
            $this->section = 'ConventionProOverseas';
            $this->header = 'Convention - Professional Overseas';
            $this->where = null;
            $this->bep_site->set_crumb('Convention','media/admin/conventionpo');
            
            
			log_message('debug','Bids Class Initialized');
			
		}

        function index()
        {
            if(!is_user()){
                redirect('auth/login','location');
            }
            // Check if first access to plain index
            
            //print $this->uri->segment(7);
            
            $type = ($this->uri->segment(4))?$this->uri->segment(4):"list";
            $page = ($this->uri->segment(5))?$this->uri->segment(5):"0";   
            $count = ($this->uri->segment(6))?$this->uri->segment(6):$this->config->item('records_per_page');
            $orderby = ($this->uri->segment(7))?$this->uri->segment(7):"users.id";
            $sort = ($this->uri->segment(8))?$this->uri->segment(8):"desc";



            //if this is a plain call to index, then jump to long url format
            if(!$this->uri->segment(4)){
                $jump = array(
                    $type,
                    $page,
                    $count,
                    $orderby,
                    $sort
                    );
                $jump = $this->controller.'/'.implode("/",$jump);
                redirect($jump,'location');
            }
            
            
            
            $datefield = ($this->uri->segment(9))?$this->uri->segment(9):"none";
            $from = ($this->uri->segment(10))?$this->uri->segment(10):"none";
            $to = ($this->uri->segment(11))?$this->uri->segment(11):"none";
            $searchscope = ($this->uri->segment(12))?$this->uri->segment(12):"all";
            $searchstring = ($this->uri->segment(13))?$this->uri->segment(13):"";
            
            $fromsearch = $from;
            $tosearch = $to;
            
            // Display Page
            
            //start sql acrobats here 
            
            
            if($fromsearch != "none"){
                $this->where.= " ( ".$datefield." >= '".$fromsearch." 00:00:00'";
                $this->where.= " and ".$datefield." <= '".$tosearch." 23:59:59' )";
            }
            
            if($searchscope != "none" && $searchstring != ""){
                if($searchscope == "all"){
                    $scopes = array();
                    foreach($this->config->item('documents_scope_array') as $key=>$val){
                        if($key != "all"){
                            $scopes[] = $key." like '%".$searchstring."%'";
                        }
                    }
                    $scopes = implode(" or ",$scopes);
                    $this->where .= " and ( ".$scopes." )";
                }else{
                    $this->where.= " and ".$searchscope." like '%".$searchstring."%'";
                }
            }
            
            if($orderby == 'profiles.golfwait'){
                if($this->where == ''){
                    $this->where.= ' golfwait > 0';
                }else{
                    $this->where.= ' and golfwait > 0';
                }
            }
            
            /*
            $convql = ' ( registertype > 0 and (course_1 + course_2 + course_3 + course_4 + course_5 = 0))'; 
            $convql .= ' or ( registertype = 0 and (course_1 + course_2 + course_3 + course_4 + course_5 > 0))'; 
            $convql .= ' or ( registertype > 0 and (course_1 + course_2 + course_3 + course_4 + course_5 > 0))'; 
            */
            
            $convql = ' ((conv_seq > 0 or (conv_seq = 0 and foc = 1)) and registrationtype = \'Professional Overseas\' and users.group = 1) '; 

            
            if($this->where == ''){
                $this->where.= $convql;
            }else{
                $this->where.= ' and '.$convql ;
            }
            
            

            //get total number of result
            //$query = $this->docs->getUser($this->where, null,$this->where,array('field'=>$orderby,'dir'=>$sort));
            //$query = $this->usermodel->fetch('Users', '*', null , $this->where,array('field'=>$orderby,'dir'=>$sort));            
            $query = $this->usermodel->getUsers($this->where, null,array('fields'=>$orderby,'order'=>$sort)); 
            $total = $query->num_rows();
            
            $summary_obj = $query->result();
            
            $query->free_result();
            
            /* === paging options ================ */
            $options['page_total'] = $total;
            $options['page_pos'] = 5;
            $options['page_num'] = $page;
            $options['page_count'] = $count;
            $options['page_order'] = $orderby;
            $options['page_sort'] = $sort;
            $options['page_pad'] = 9;
            $options['page_attrib'] = null;
            $options['page_order_array'] = $this->config->item('documents_sort_array');
            $options['page_controller'] = $this->controller;
            
            $data['paging'] = $this->pager->createPager($options);
            $data['exportlink'] = $this->pager->createPager($options,true);

            /* === searchbox options ================ */
            
            $this->search->initSearchForm();
            
            $qdf = $this->docs->getOldestDate('Users','created');
            $odate = $qdf->row();
            $odate = explode(' ',$odate->created);
            $odate = explode('-',$odate[0]);
            
            $ndate = getdate();
            
            if($from != 'none'){
                $from = explode('-',$from);
                $to = explode('-',$to);
                $doptions['yearfrom'] = $from[0];
                $doptions['monthfrom'] = $from[1];
                $doptions['dayfrom'] = $from[2];
                $doptions['yearto'] = $to[0];
                $doptions['monthto'] = $to[1];
                $doptions['dayto'] = $to[2];
            }else{
                $doptions['yearfrom'] = $odate[0];
                $doptions['monthfrom'] = $odate[1];
                $doptions['dayfrom'] = $odate[2];
                $doptions['yearto'] = $ndate['year'];
                $doptions['monthto'] = $ndate['mon'];
                $doptions['dayto'] = $ndate['mday'];
            }
            
            $doptions['date_label'] = 'When';
            $doptions['labelstyle'] = 'style="font-weight:bold;"';
            $doptions['datefield_name'] = 'datefield';
            $doptions['datefield_array'] = $this->config->item('documents_datefield_array');
            $doptions['datefield_selected'] = $datefield;
            
            
            $this->search->addDateRangeForm($doptions);
            
            
            $scoptions['scope_name'] = 'searchscope';
            $scoptions['scope_selected'] = $searchscope;
            $scoptions['scope_array'] = $this->config->item('documents_scope_array');
            $scoptions['search_label'] = 'Search by keyword';
            $scoptions['labelstyle'] = 'style="font-weight:bold;"';
            $scoptions['searchvalue_name'] = 'searchkeyword';
            $scoptions['searchvalue'] = $searchstring;
            $scoptions['prev_search'] = false;
            
            $this->search->addScopeForm($scoptions);
            $this->search->closeSearchForm();

            $data['search'] = $this->search->printSearchForm();
            /* === end searchbox options ================ */
            
            if(!(($type == 'csv' || $type == 'print') && $page == 'all')){
                $limit = array('limit' => $count, 'offset' => ($page*$count));
            }else{
                $limit = null;
            }
            
            //$fields = 'id,datecreated,filename,mediatype,duration,seconds,ownerid,ownername,thumbnail,title';            
            //$query = $this->docs->fetch('Documents', $fields , $limit , $this->where,array('field'=>$orderby,'dir'=>$sort));            

            $fields = '*';    
            
            $query = $this->usermodel->getUsers($this->where, $limit,array('fields'=>$orderby,'order'=>$sort));   
            $page_query = $this->db->last_query();     
            
            /* main result */
            $data['documents'] = $query->result();

            $data['controller'] = $this->controller;
            
            $data['page_query'] = $page_query;
            $data['reset_search']=($type == 'result')?anchor($this->controller,'Clear Search'):'';
            
            if(($type == 'result')){
                $this->bep_site->set_crumb('Search Result','media/admin/conventionpo');
            }
            
            /*create summary*/
            $tco = 0;
            $co = 0;
            $sco = 0;
            $co_sc = 0;
            $golf = 0;
            $gala = 0;
            $galaaux = 0;
            $cfoc = 0;
            
            foreach($summary_obj as $so){
                if($so->conv_seq > 0 && $so->sc_seq == 0){
                    $co++;
                    $tco++;
                }

                if($so->conv_seq == 0 && $so->sc_seq > 0){
                    $sco++;
                }

                if($so->conv_seq > 0 && $so->sc_seq > 0){
                    $co_sc++;
                    $tco++;
                }
                
                if($so->conv_seq == 0 && $so->foc == 1){
                    $co++;
                    $tco++;
                    $cfoc++;
                }
                
                if($so->galadinner > 0){
                    $gala++;
                }

                if($so->galadinneraux > 0){
                    $galaaux++;
                }
                
                if($so->golf > 0){
                    $golf++;
                }
            }
            
            $summary_list = array();
            
            $summary_list['Total Professional Overseas Attendance'] = $tco;
            $summary_list['Convention Only Attendance'] = $co;
            $summary_list['Convention and Short Course Attendance'] = $co_sc;
            $summary_list['Convention Attendance by Exhibitor Entitlement'] = $cfoc;
            
            $data['summary_list'] = $summary_list;
            

            $data['header'] = $this->header;
            if($type == 'xml'){
                $config = array (
                                  'root'    => 'root',
                                  'element' => 'element',
                                  'newline' => "\n",
                                  'tab'    => "\t"
                                );
                $xmldata = $this->dbutil->xml_from_result($query, $config);
                $xmldata = explode("\n",$xmldata);
                
                $xml_file_name = $this->section.'_page_'.$page.'_'.date('Ymd',time()).'.xml';
                
                if(file_exists($this->config->item('attachment_path').'tmp/'.$xml_file_name)){
                    unlink($this->config->item('attachment_path').'tmp/'.$xml_file_name);
                }
                
                $fp = fopen($this->config->item('attachment_path').'tmp/'.$xml_file_name, 'a');
                foreach ($xmldata as $line) {
                    fwrite($fp, $line."\r\n");
                }
                fclose($fp);
                
                clearstatcache();
      	        $filesize = filesize($this->config->item('attachment_path').'tmp/'.$xml_file_name);
    	        
      			
    	        header("Content-type: text/xml");
                header("Content-disposition: attachment; filename=".$xml_file_name);
                header("Pragma: no-cache");
      	        $this->_stream_file($this->config->item('attachment_path').'tmp/'.$xml_file_name);
                
            }elseif($type == 'csv'){
                $csvdata = $query->result_array();
                $rows = array();
                foreach($csvdata as $csvrow){
                    $r = array();
                    $h = array();
                    foreach($csvrow as $key=>$val){
                        $r[] = '"'.$val.'"';
                        $h[] = '"'.$key.'"';
                    }
                    $csvhead[0] = implode(',',$h);
                    $rows[]= implode(',',$r);
                }
                
                $csvdata = array_merge($csvhead,$rows);
                //print_r($csvdata);
                
                $csv_file_name = $this->section.'_page_'.$page.'_'.date('Ymd',time()).'.csv';
                
                if(file_exists($this->config->item('attachment_path').'tmp/'.$csv_file_name)){
                    unlink($this->config->item('attachment_path').'tmp/'.$csv_file_name);
                }
                
                $fp = fopen($this->config->item('attachment_path').'tmp/'.$csv_file_name, 'a');
                foreach ($csvdata as $line) {
                    fwrite($fp, $line."\r\n");
                }
                fclose($fp);
                
                clearstatcache();
      	        $filesize = filesize($this->config->item('attachment_path').'tmp/'.$csv_file_name);
    	        
      			
    	        header("Content-type: application/vnd.ms-excel");
                header("Content-disposition: attachment; filename=".$csv_file_name);
                header("Pragma: no-cache");
      	        $this->_stream_file($this->config->item('attachment_path').'tmp/'.$csv_file_name);
      	        
            }elseif($type == 'print'){
                $data['print'] = true;
                $data['search'] = false;
                $data['page_query'] = false;
                $data['reset_search'] = false;
                $page = $this->config->item('backendpro_template_admin') . "convention_list";
                $this->load->view($page,$data);
            }else{
                $data['page'] = $this->config->item('backendpro_template_admin') . "convention_list";
                $data['module'] = 'media';
                $this->load->view($this->_container,$data);
            }
            return;
        }
        
        function form($id = NULL)
        {
            if(!is_user()){
                redirect('auth/login','location');
            }
            // VALIDATION FIELDS & RULES
            
            $datestring = "Y-m-d H:i:s";
            
            foreach($this->config->item('documents_validation_array') as $key=>$val){
                $fields[$key] = $val['field'];
                $rules[$key] = $val['rule'];
            }
            
            $this->validation->set_fields($fields);
            
            // SETUP FORM DEFAULT VALUES
            if( !is_null($id) && ! $this->input->post('submit'))
            {
                // Modify form, first load
                $query = $this->docs->fetch('Documents', '*' , array('limit' => 1, 'offset' => 0), 'id = '.$id);            
                $document = $query->row_array();
                $document['doc_route'] = $this->_getRoutes($id);
                $document['doc_custody'] = $this->_getCustody($id);
                $document['doc_keyword'] = $this->_getTags($id,$this->section);
                
                $this->validation->set_default_value($document);                
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
                
                $data['locations'] = $this->_getLocations();
                $data['companies'] = $this->_getCompanies();
                $data['callnumbers'] = $this->_getCallNumbers($this->section);
                $data['users'] = $this->_getUsers();
                
                $this->validation->output_errors();
                $data['header'] = (is_null($id))?'Create Document':'Edit Document : '.$id;
                $this->page->set_crumb($data['header'],'documents/form/'.$id);
                $data['page'] = $this->config->item('backendpro_template_public') . "form_document";
                $data['module'] = 'documents';
                $data['controller'] = $this->controller;
                $this->load->view($this->_container,$data);                 
            }
            else
            {
                
                // Save form
                if( is_null($id))
                {
                    // CREATE
                    // Fetch form values
                    $data = $this->_getPostData();

                    //pre-condition values
                    $data['doc_date_create'] = date($datestring,now());
                    $data['doc_call_seq'] = str_pad($data['doc_call_seq'], 3, "0", STR_PAD_LEFT);
            		$data['doc_callnumber'] = $data['doc_call_main'].'-'.$data['doc_call_company'].'-'.$data['doc_call_date'].'-'.$data['doc_call_seq'] ; 	

                    //insert value and get new id
                    $this->docs->insert('Documents',$data);
                    $did = $this->db->insert_id();

                    //post-process values
                    $data['doc_keyword'] = trim($data['doc_keyword']);

                    $msg = $this->_processRoute($data['doc_route'],$did);
                    $this->_processCustody($data['doc_custody'],$did);
                    $this->_processKeywords($data['doc_keyword'],$did,$this->section);
                    
                    $uploaded = $this->_do_upload();
                    if($uploaded == false){
                        $data['doc_file_id'] = 'no_file';
                    }else{
                        $data['doc_file_id'] = $uploaded['path'];
                        $data['doc_file_active'] = $uploaded['file'];
                        $msg[] = $uploaded['file'].' uploaded';
                    }
                    
                    unset($data['id']);
                    $this->docs->update('Documents',$data,array('id'=>$did));
                    
                    flashMsg('info',implode("<br />",$msg));
                    redirect($this->controller);
                }
                else
                {
                    // SAVE
                    $data = $this->_getPostData();
                    unset($data['id']);
                    //print_r($data);
                    //print $id;
                    $data['doc_call_seq'] = str_pad($data['doc_call_seq'], 3, "0", STR_PAD_LEFT);
            		$data['doc_callnumber'] = $data['doc_call_main'].'-'.$data['doc_call_company'].'-'.$data['doc_call_date'].'-'.$data['doc_call_seq'] ; 	
                    
                    $this->docs->update('Documents',$data,array('id'=>$id));

                    $msg = $this->_processRoute($data['doc_route'],$id);
                    $this->_processCustody($data['doc_custody'],$id);
                    $this->_processKeywords($data['doc_keyword'],$id,$this->section);
                    /*
                    $docdata['doc_file_id'] = $this->_do_upload();
                    $docdata['doc_file_id'] = ($docdata['doc_file_id'] == False)?'no_file':$docdata['doc_file_id'];
                    */
                    flashMsg('info',implode("<br />",$msg));
                    redirect($this->controller);
                }
            }         
        }
        
        function delete($id = null){
            if(is_null($id)){
                redirect($this->controller);
            }else{
                //print $id;
                $this->docs->delete('Documents','id ='.$id);
                redirect($this->controller);
            }
        }
        
        function searchUsers(){
            $searchstring = $this->input->post('q');
            $query = $this->docs->searchUser($searchstring);
            if($query->num_rows() > 0){
                $users = array();
        		foreach ($query->result() as $row)
        	        	{
                    	    $users[] = $row->username."|".$row->id;
        	        	}
        	    $query->free_result();
        	    print implode("\n",$users);
            }else{
                print "";
            }

        }

        function searchKeywords(){
            $searchstring = $this->input->post('q');
            $query = $this->docs->searchKeywords($searchstring);
            if($query->num_rows() > 0){
                $tags = array();
        		foreach ($query->result() as $row)
        	        	{
                    	    $tags[] = $row->tag."|".$row->id;
        	        	}
        	    $query->free_result();
        	    print implode("\n",$tags);
            }else{
                print "";
            }
        }

        function searchFolders(){
            $searchstring = $this->input->post('q');
            $query = $this->docs->searchFolder($searchstring);
            if($query->num_rows() > 0){
                $folders = array();
        		foreach ($query->result() as $row)
        	        	{
                    	    $folders[] = $row->doc_loc_folder;
        	        	}
        	    $query->free_result();
        	    print implode("\n",$folders);
            }else{
                print "";
            }
        }

        function callseq($callmain = null){
            $query = $this->docs->getCallSeq($this->input->post('callmain'));
    	    $row = $query->row();
    	    $callseq = (int)$row->doc_call_seq;
    	    $callseq = str_pad($callseq+1,3,'0',STR_PAD_LEFT);
    	    $query->free_result();
    	    
    	    print "{callseq:'".$callseq."'}";
        }

        function preview($id){
            $query = $this->docs->fetch('Documents', '*' , null , array('id'=>$id));            
            //print_r($query->row_array());
            
            $row = $query->row();
            
            $url = sprintf(base_url().'public/media/%s/%s',$row->mediatype,basename($row->filename));
            
            $out = sprintf('
                <object id="player" classid="clsid:D27CDB6E-AE6D-11cf-96B8-444553540000" name="player" width="500" height="400">
            		<param name="movie" value="'.base_url().'public/mediaplayer/player.swf" />
            		<param name="allowfullscreen" value="true" />
            		<param name="allowscriptaccess" value="always" />
            		<param name="flashvars" value="file=%s&image=preview.jpg&width=500&height=400" />
            		<object type="application/x-shockwave-flash" data="'.base_url().'public/mediaplayer/player.swf" width="500" height="400">
            			<param name="movie" value="player.swf" />
            			<param name="allowfullscreen" value="true" />
            			<param name="allowscriptaccess" value="always" />
            			<param name="flashvars" value="file=%s&image=preview.jpg&width=500&height=400" />
            			<p><a href="http://get.adobe.com/flashplayer">Get Flash</a> to see this player.</p>
            		</object>
            	</object>
            ',$url,$url);
            
            print $out;
        }
        
        function deletefile(){
            $filename = $this->input->post('f');
            if(@unlink($this->config->item('public_folder').'video/online/'.$filename)){
                print json_encode(array('result'=>true,'msg'=>'File deleted'));
            }else{
                print json_encode(array('result'=>false,'msg'=>'Failed to delete file, possibly not exist or permission denied'));
            }
        }

    	function gen($fid = null)
    	{	
            if(!is_null($fid)){
            		$query = $this->myfiles->getFileByFID($fid);
            		$files = $query->result();
            		$file = $files[0];
            /*
            	        clearstatcache();
            	        $filesize = filesize($file->full_path);
            	        $headers = array(
            		        'Pragma: public',
            		        'Expires: 0',
            		        'Cache-Control: must-revalidate, post-check=0, pre-check=0, private',
            		        'Content-Type: '. $file->file_type,
            		        'Content-Length: '. $filesize,
            		        'Content-Disposition: attachment; filename="'.$file->orig_name.'"',
            		        'Content-Transfer-Encoding: binary',
            			);
            			//print_r($headers);
            	      // required for IE, otherwise Content-disposition is ignored
            			$this->_stream_audio($file->full_path,$headers);
            */
                    $data = file_get_contents($file->full_path); // Read the file's contents
                    $name = $file->orig_name;

                    force_download($name, $data);
            }
    	}
    	
	
    	function dispatch($id)
    	{   
    		$data['doc_loc_warehouse'] = $this->input->post('doc_loc_warehouse');
    		$data['doc_loc_warehouse_box'] = $this->input->post('doc_loc_warehouse_box');
    	    $this->docs->update('Documents',$data,array('id'=>$id));    	    
    	    $res = $this->db->affected_rows(); 	
    	    if($res == 0){
    	        print json_encode(array("result"=>"failed"));
    	    }else{
    	        print json_encode(array("result"=>"ok","warehouse"=>$data['doc_loc_warehouse'],"box"=>$data['doc_loc_warehouse_box']));
    	    }
        }

    	function undispatch($id)
    	{   
    	    $data['doc_loc_warehouse'] = '';
    		$data['doc_loc_warehouse_box'] = '';
    	    $this->docs->update('Documents',$data,array('id'=>$id));   
    	    $res = $this->db->affected_rows(); 	
    	    if($res == 0){
    	        print json_encode(array("result"=>"failed"));
    	    }else{
    	        print json_encode(array("result"=>"ok"));
    	    }
        }


    	
    	function stream($fid = null){
            if(!is_null($fid)){
            		$query = $this->myfiles->getFileByFID($fid);
            		$files = $query->result();
            		$file = $files[0];
            
            	        clearstatcache();
            	        $filesize = filesize($file->full_path);
            	        $headers = array(
            		        'Pragma: public',
            		        'Expires: 0',
            		        'Cache-Control: must-revalidate, post-check=0, pre-check=0, private',
            		        'Content-Type: '. $file->file_type,
            		        'Content-Length: '. $filesize,
            		        'Content-Disposition: attachment; filename="'.$file->orig_name.'"',
            		        'Content-Transfer-Encoding: binary',
            			);
            			//print_r($headers);
            	      // required for IE, otherwise Content-disposition is ignored
            			$this->_stream_file($file->full_path,$headers);
                    /*
                    $data = file_get_contents($file->full_path); // Read the file's contents
                    $name = $file->orig_name;

                    force_download($name, $data);
                    */
            }
    	}
        
        function _getCustody($id){
            $query = $this->docs->fetch('Custodian','custodian',null,'doc_id = '.$id);
            if($query->num_rows() > 0){
                $custodians = $query->result_array();
                $c = array();
                foreach($custodians as $co){
                    $c[] = $co['custodian'];
                }
                return implode(", ",$c);
            }else{
                return "";
            }
        }

        function _getRoutes($id){
            $query = $this->docs->fetch('Routes','user_name',null,'doc_id = '.$id);
            if($query->num_rows() > 0){
                $routes = $query->result_array();
                $r = array();
                foreach($routes as $ro){
                    $r[] = $ro['user_name'];
                }
                return implode(", ",$r);
            }else{
                return "";
            }
        }
        
        function _getActiveFile($folder,$filename){
            $query = $this->docs->fetch('Files','*',null,"fid = '".$folder."' and file_name = '".$filename."'");
            if($query->num_rows() > 0){
                return $query->row();
            }else{
                return false;
            }
        }

        function _getFiles($folder){
            $query = $this->docs->fetch('Files','*',null,"fid = '".$folder."'");
            if($query->num_rows() > 0){
                return $query->result();
            }else{
                return false;
            }
        }

        function _getUserFiles($userid){
            $result_files = array();
            for($i = 1;$i<4;$i++){
//                print $this->config->item('public_folder').'video/online/'.$userid.'_'.$i.'.flv';
                if(file_exists($this->config->item('public_folder').'video/online/'.$userid.'_'.$i.'.flv')){
                    clearstatcache();
                    $finfo = stat($this->config->item('public_folder').'video/online/'.$userid.'_'.$i.'.flv');
                    $finfo['filename'] = $userid.'_'.$i.'.flv';
                    $result_files[] = $finfo;
                }
            }
            
            if(count($result_files) == 0 OR empty($result_files)){
                return false;
            }else{
                return $result_files;
            }
            
        }

        function _getPreviews($dir,$previewpath){
            $files = array();
            $dir = $dir.$previewpath;
            if (is_dir($dir)) {
                if ($dh = opendir($dir)) {
                    while (($file = readdir($dh)) !== false) {
                        if(!($file == "." || $file == "..")){
                            $files[] = $file;
                        }
                    }
                    closedir($dh);
                }
            }
            
            if(count($files) > 0){
                return $files;
            }else{
                return false;
            }
        }

        function _getTags($id,$section){
            $query = $this->docs->getTags($id,$section);
            if($query->num_rows() > 0){
                $tags = $query->result_array();
                $t = array();
                foreach($tags as $tag){
                    $t[] = $tag['tag'];
                }
                return implode(", ",$t);
            }else{
                return "";
            }
        }
        
        function _getPostData(){
            foreach($this->config->item('documents_validation_array') as $key=>$val){
                $data[$key] = $this->input->post($key);
            }

            //return array('post'=>$data,'route'=>$routing_array,'custody'=>$custody_array);
            return $data;
        }

    	function _getLocations(){
            $query = $this->docs->getLocMain();
            $rd = array();
    		foreach ($query->result() as $row)
    	        	{
                	    $rd[$row->loc_code] = '['.$row->loc_code.'] '.$row->loc_description;
    	        	}
    	    $query->free_result();
    	    return $rd;
    	}
    	
    	function _getCallNumbers($section){
            $query = $this->docs->getCallMain($section);
            $rd = array();
    		foreach ($query->result() as $row)
    	        	{
                	    $rd[$row->call_code] = '['.$row->call_code.'] '.$row->call_description;
    	        	}
    	    $query->free_result();
    	    return $rd;
    	}

    	function _getCompanies(){
            $query = $this->docs->getCompanies();
            $rd = array();
    		foreach ($query->result() as $row)
    	        	{
                	    $rd[$row->co_code] = '['.$row->co_code.'] '.$row->co_name;
    	        	}
    	    $query->free_result();
    	    return $rd;
    	}
    	
        function _getCompanyName($id){
            $query = $this->docs->getCompanyName($id);
            $rd = array();
            if ($query->num_rows() > 0){
                $result = $query->row();
                $co_name = $result->co_description; 	
            }

    	    $query->free_result();
    	    return $co_name;
        }
    	
    	function _getUsers(){
            $query = $this->docs->getUsers();
    	    return $query;
    	}
        
        
    	function _stream_file($source)
    	{
    	    ob_start();
    	    if ($fd = fopen($source, 'rb')) {
    		    if (!ini_get('safe_mode')){
    		        set_time_limit(0);
    		    }
    		    while (!feof($fd)) {
    		        print fread($fd, 1024);
    		        ob_flush();
    		        flush();
    		    }
    		    fclose($fd);
    	    }
    		ob_end_clean();
    	    exit();
    	}

	
    	function _processRoute($routestring,$did){
    	    $routes = trim(str_replace(array('\n','\r',''),'',$routestring));
    	    $route_array = explode(',',$routes);
	    
    	    //clean up old routes
            $this->docs->delete('Routes','doc_id = '.$did);
            $result = array();
    	    foreach($route_array as $route){
    	        if(trim($route) != ''){
                    $data = array('doc_id'=>$did,'user_name'=>$route);
                    $this->docs->insert('Routes',$data);
                    if($email = $this->_userExist($route)){
                        $subject = 'Cedar Document Update';
                        $message = $this->config->item('cedar_email_message');
                        if($rs = $this->customemail->sendCustomEmail($email,$subject,$message)){
                            $result[] = sprintf('Notification email sent to %s',$email);
                        }
                    }
    	        }
    	    }	    
    	    
    	    return $result;
    	}

    	function _processCustody($custodianstring,$did){
    	    $custodian = trim(str_replace(array('\n','\r'),'',$custodianstring));
    	    $custodian_array = explode(',',$custodian);
	    
    	    //clean up old custodians
            $this->docs->delete('Custodian','doc_id = '.$did);
	    
    	    foreach($custodian_array as $custody){
    	        if(trim($custody) != ''){
    	            $data = array('doc_id'=>$did,'custodian'=>$custody);
                    $this->docs->insert('Custodian',$data);
    	        }
    	    }	    
    	}

    	function _processKeywords($keywordstring,$did,$section){
    	    $keywordstring = trim(str_replace(array('\n','\r'),'',$keywordstring));
    	    $keyword_array = explode(',',$keywordstring);
	    
    	    //clean up old keywords
            $this->docs->delete('SectionTags','did = '.$did);
	    
    	    foreach($keyword_array as $keyword){
    	        if(trim($keyword) != ''){
    	            $tag = $this->_keywordCheck($keyword);
    	            $data = array('did'=>$did,'tagid'=>$tag['id'],'section'=>$section);
                    $this->docs->insert('SectionTags',$data);
    	        }
    	    }	    
    	}
    	
    	function _keywordCheck($keyword){
    	    $keyword = strtolower(trim($keyword));
    	    $query = $this->docs->fetch('Tags', 'id,tag', null, array('tag'=>$keyword));
    	    if($query->num_rows() > 0){
    	        $tag = $query->row_array();
    	    }else{
    	        $this->docs->insert('Tags',array('tag'=>$keyword));
    	        $tagid = $this->db->insert_id();
    	        $tag = array('id'=>$tagid,'tag'=>$keyword);
    	    }
	        return $tag;
    	}

    	function _userExist($username){
            $query = $this->docs->getUsers($username);
            if($query->num_rows() > 0){
                $row = $query->row();
                $email = $row->email;
                $query->free_result();
                return $email;
            }else{
                $query->free_result();
        	    return false;
            }
    	}

    	function _do_upload($folder = null)
    	{

    		$result = False;
    		if(is_array($_FILES) && !empty($_FILES)){
    			foreach($_FILES as $key => $value){
    			    if(is_null($folder)){
        				$folder = md5(microtime().mt_rand());
        				$longpath = realpath('./public/storage/');
        				mkdir($longpath.'/'.$folder);
    			    }

    				$config['upload_path'] = './public/storage/'.$folder.'/';
    				$config['allowed_types'] = 'bzip|tgz|tar.gz|tar|zip|xls|doc|pdf|gif|jpg|png|3gp|3gpp|flv|mov|wmv|avi|mpg|mpeg|mp4|mp3|mp2';
    				$config['max_size']	= '10000';
    				$config['max_width']  = '4096';
    				$config['max_height']  = '4096';

    				$this->upload->initialize($config);				

    				if ( ! $this->upload->do_upload($key))
    				{

    					$result = False;
    					//$err .= $this->upload->display_errors();
    					rmdir($longpath.'/'.$folder);				
    				}	
    				else
    				{

    					$filedata = $this->upload->data();
    					$thumbname = '';

    					if($filedata['is_image'] == 1){
    						$mediatype ='image';
    						$thumbname = 'th_'.$filedata['file_name'];
    					}else if(preg_match('/video/',$filedata['file_type']) || $filedata['file_type'] =='application/octet-stream'){
    						$mediatype ='video';
    					}else if(preg_match('/audio/',$filedata['file_type'])){
    						$mediatype ='audio';
    					}else if(preg_match('/pdf$/',$filedata['file_name'])){
    						$mediatype ='pdf';
    					}else if(preg_match('/msword/',$filedata['file_type']) || preg_match('/doc$/',$filedata['file_name'])){
    						$mediatype ='word';
    					}else{
    						$mediatype ='other';
    					}

    					$datestring = "Y-m-d H:i:s";

    					$filedata['uid'] = $this->session->userdata('id');
    					$filedata['section'] = 'document';
    					$filedata['fid'] = $folder;
    					$filedata['mediatype'] = $mediatype;
    					$filedata['timestamp'] = date($datestring,now());
    					$filedata['thumbnail'] = $thumbname;
    					$filedata['postvia'] = 'web';
    					$filedata['process'] = 0;
    					$filedata['hint'] = '';
    					$filedata['title'] = $filedata['file_name'];
    					$filedata['message'] = $_POST['doc_subject'];										
    					$this->myfiles->insertFile($filedata);

    					// image thumbnailing
    					if($filedata['is_image']){

    						$thumbname = $this->media_lib->createImageThumbnail($filedata);
    						$this->myfiles->updateFile(array('fid'=>$filedata['fid']),array('thumbnail'=>$thumbname));

    					}else if($filedata['mediatype'] == 'audio'){

    						//get embedded image if any
    						//$musicdata = $this->music_lib->getID3tag($filedata['full_path']);

    						if(isset($musicdata)){

        						//print $musicdata['id3v2']['APIC'][0]['data'];
        						if(isset($musicdata['id3v2']['APIC'][0]['data'])){

        							$music_pic = $filedata['file_path'].$filedata['raw_name'].'.jpg';

        							if (!$handle = fopen($music_pic, 'wb')) {
        						         echo "Cannot open file ($music_pic)";
        						    }else{
            						    // Write $somecontent to our opened file.
            						    if (fwrite($handle, $musicdata['id3v2']['APIC'][0]['data']) === FALSE) {
            						        echo "Cannot write to file ($music_pic)";
            						    }

            						    fclose($handle);

            							$thumbraw = 'th_'.$filedata['raw_name'];

            							$thumbname = $this->media_lib->createImageThumbnailFromFile($music_pic,$thumbraw);

            							$this->myfiles->updateFile(array('fid'=>$filedata['fid']),array('thumbnail'=>$thumbname,'music_pic'=>$filedata['raw_name'].'.jpg'));
            							$filedata['music_pic'] = $filedata['raw_name'].'.jpg';
        						    }

        						}else{
        						    $filedata['music_pic'] = '';
        						}
    						}else{
    						    $filedata['music_pic'] = '';
    						}


    					    $converted = $this->media_lib->createAudioThumbnail($filedata);
    						$this->myfiles->updateFile(array('fid'=>$filedata['fid']),array('mp3_file'=>$converted['mp3_file'],'3gp_file'=>$converted['3gp_file']));


    					}else if($filedata['mediatype'] == 'video'){

    					    $converted = $this->media_lib->createVideoThumbnail($filedata);
    						$this->myfiles->updateFile(array('fid'=>$filedata['fid']),array('thumbnail'=>$converted['thumbnail'],'flv_file'=>$converted['flv_file'],'3gp_file'=>$converted['3gp_file']));
    						$filedata['thumbnail'] = $converted['thumbnail'];
    						$filedata['flv_file'] = $converted['flv_file'];
    						$filedata['3gp_file'] = $converted['3gp_file'];
    					}else if($filedata['mediatype'] == 'pdf'){
    					    $input = $filedata['full_path'];
    					    $previewfolder = "preview_".time();
    					    $outdir = $filedata['file_path'].$previewfolder;
    					    mkdir($outdir);
    					    $output = $outdir."/page%d.jpg";
    					    
    					    $rs = $this->preview->PDFtoJPEGSeq($input, $output);
    					    
    					    $this->myfiles->updateFile(array('fid'=>$filedata['fid']),array('thumbnail'=>$previewfolder));

    					}else if($filedata['mediatype'] == 'word'){
    					    
    					}

    					$data['fileuploaded'][] = $filedata;

    					$result = array('path'=>$filedata['fid'],'file'=>$filedata['file_name']);
    				}
    			}
    		}else if(!is_array($_FILES) && !empty($_FILES)){
    			if ( ! $this->upload->do_upload())
    			{
    				$this->uploadstatus[] = $this->upload->display_errors();
    			}	
    			else
    			{

    				$filedata = $this->upload->data();
    				$filedata['uid'] = $this->db_session->userdata('id');
    				$filedata['section'] = 'mymedia';
    				$filedata['fid'] = $folder;
    				$filedata['mediatype'] = 'media';
    				$filedata['timestamp'] = 'now()';
    				$filedata['thumbnail'] = 'thumb';
    				$filedata['postvia'] = 'web';
    				$filedata['process'] = 0;
    				$filedata['hint'] = '';
    				$this->myfiles->insertFile($filedata);
    			}
    		}

    		return $result;

    	}		
        
        function ajaxlock($type){
    	    $b = $this->input->post('u');

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
    	
    	function contactlog(){
    	    $data['page'] = $this->config->item('backendpro_template_admin') . "contact_overlay";
            $data['module'] = 'media';
            $this->load->view($this->_container,$data);
    	}
    	

	}
?>