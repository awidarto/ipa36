<?php if (!defined('BASEPATH')) exit('No direct script access allowed');
/**
 * Document_model
 *
 * Provides functionaly to query all tables related to the
 * documents.
 *
 * @package         Cedar2
 * @subpackage      Models
 */
    class Media_model extends Base_model
    {
        /**
         * Constructor
         */
        function Media_model()
        {
            // Inherit from parent class
            parent::Base_model();

            $this->_TABLES = array('Documents' => 'ci_files','Routes'=>'ci_doc_routes','Custodian'=>'ci_doc_custodian','LocationMain'=>'ci_loc_main','Companies'=>'ci_companies','CallNumbers'=>'ci_call_main','Users'=>'be_users','Tags'=>'ci_tag','SectionTags'=>'ci_object_tag','Files'=>'ci_files','UserProfiles'=>'be_user_profiles');

            log_message('debug','Document_model Class Initialized');
        }
        
        function getMedia($where = NULL, $limit = array('limit' => NULL, 'offset' => ''),$orderby = array('field'=>null,'dir'=>'desc'))
        {
            $this->db->select('*');
            $this->db->from($this->_TABLES['Documents']);
            $this->db->join($this->_TABLES['Users'],$this->_TABLES['Documents'].'.uid = '.$this->_TABLES['Users'].'.id','left');
            if( ! is_null($where)){ $this->db->where($where,false);}
            if( ! is_null($limit)){ $this->db->limit($limit['limit'],( isset($limit['offset'])?$limit['offset']:''));}
            if( ! is_null($orderby['field'])){ $this->db->orderby($orderby['field'],$orderby['dir']);}
            return $this->db->get();
        }

        function getUserMedia($where = NULL, $limit = array('limit' => NULL, 'offset' => ''),$orderby = array('field'=>null,'dir'=>'desc'))
        {
            $this->db->select('*');
            $this->db->from($this->_TABLES['Users']);
            $this->db->join($this->_TABLES['Documents'],$this->_TABLES['Documents'].'.uid = '.$this->_TABLES['Users'].'.id','left');
            if( ! is_null($where)){ $this->db->where($where,false);}
            if( ! is_null($limit)){ $this->db->limit($limit['limit'],( isset($limit['offset'])?$limit['offset']:''));}
            if( ! is_null($orderby['field'])){ $this->db->orderby($orderby['field'],$orderby['dir']);}
            return $this->db->get();
        }


        function getUser($where = NULL, $limit = array('limit' => NULL, 'offset' => ''),$orderby = array('field'=>null,'dir'=>'desc'))
        {
            $this->db->select("*,date_format(be_users.created,'%d-%m-%Y %H:%i:%s') as fcreated",false);
            $this->db->from($this->_TABLES['Users']);
            if( ! is_null($where)){ $this->db->where($where,null,false);}
            if( ! is_null($limit)){ $this->db->limit($limit['limit'],( isset($limit['offset'])?$limit['offset']:''));}
            if( ! is_null($orderby['field'])){ $this->db->orderby($orderby['field'],$orderby['dir']);}
            return $this->db->get();
        }
        
        function getUserFile($where = NULL, $limit = array('limit' => NULL, 'offset' => ''),$orderby = array('field'=>null,'dir'=>'desc'))
        {
            $this->db->select('*');
            $this->db->from($this->_TABLES['Documents']);
            if( ! is_null($where)){ $this->db->where($where,false);}
            if( ! is_null($limit)){ $this->db->limit($limit['limit'],( isset($limit['offset'])?$limit['offset']:''));}
            if( ! is_null($orderby['field'])){ $this->db->orderby($orderby['field'],$orderby['dir']);}
            return $this->db->get();
        }
        

        function fetch($name, $fields=null, $limit=null, $where=null,$orderby = array('field'=>null,'dir'=>'desc'))
        {
			
            if( ! is_null($fields)){ $this->db->select($fields);}            
            if( ! is_null($where)){ $this->db->where($where,null,false);}
            if( ! is_null($limit['limit'])){ $this->db->limit($limit['limit'],( isset($limit['offset'])?$limit['offset']:''));}
            if( ! is_null($orderby['field'])){ $this->db->orderby($orderby['field'],$orderby['dir']);}
			return $this->db->get($this->_TABLES[$name]);
        }
                
        function getLocMain()
    	{	
    		$this->db->select('*');
    		return $this->db->get($this->_TABLES['LocationMain']);
    		//returns the query string
    	}

        function getCallSeq($callmain)
    	{	
    		$this->db->select_max('doc_call_seq');
    		$this->db->where("doc_call_date = '".$callmain."'");
    		return $this->db->get($this->_TABLES['Documents']);
    		//returns the query string
    	}

        function getOldestDate($table,$datefield)
    	{	
    		$this->db->select_min($datefield);
    		return $this->db->get($this->_TABLES[$table]);
    		//returns the query string
    	}

        function getCallMain($section)
    	{	
    		$this->db->select('*');
    		$this->db->where("call_section = '".$section."'");
    		return $this->db->get($this->_TABLES['CallNumbers']);
    		//returns the query string
    	}

        function getCompanies()
    	{	
    		$this->db->select('*');
    		return $this->db->get($this->_TABLES['Companies']);
    		//returns the query string
    	}

        function getCompanyName($id)
    	{	
    		$this->db->select('*');
    		$this->db->where(array('co_code'=>$id));
    		return $this->db->get($this->_TABLES['Companies']);
    		//returns the query string
    	}

        function getUsers($username = null)
    	{	
    		$this->db->select('*');
    		if(!is_null($username)){
        		$this->db->where(array('username'=>$username));
    		}
    		return $this->db->get($this->_TABLES['Users']);
    		//returns the query string
    	}

        function getFiles($fid = null)
    	{	
    		$this->db->select('*');
    		if(!is_null($fid)){
        		$this->db->where(array('fid'=>$fid));
    		}
    		return $this->db->get($this->_TABLES['Files']);
    		//returns the query string
    	}
    	
    	function getTags($id,$section){
    		$this->db->select($this->_TABLES['Tags'].'.tag as tag');
    		$this->db->from($this->_TABLES['Tags']);
    		$this->db->join($this->_TABLES['SectionTags'],$this->_TABLES['SectionTags'].'.tagid = '.$this->_TABLES['Tags'].'.id');
    		$this->db->where(array($this->_TABLES['SectionTags'].'.did'=>$id,$this->_TABLES['SectionTags'].'.section'=>$section));
    		return $this->db->get();
    	}

        function searchUser($search)
    	{	
    		$this->db->select('*');
    		$this->db->like(array('username'=>$search));
    		return $this->db->get($this->_TABLES['Users']);
    		//returns the query string
    	}

        function searchFolder($search)
    	{	
    		$this->db->distinct();
    		//$this->db->select('doc_loc_folder');
    		$this->db->like(array('doc_loc_folder'=>$search));
    		return $this->db->get($this->_TABLES['Documents']);
    		//returns the query string
    	}

        function searchKeywords($search)
    	{	
    		$this->db->select('*');
    		$this->db->like(array('tag'=>$search));
    		return $this->db->get($this->_TABLES['Tags']);
    		//returns the query string
    	}


    }
?>