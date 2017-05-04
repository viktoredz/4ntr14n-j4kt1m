<?php
class Bpjs_model extends CI_Model {

    var $tabel    = 'app_config';

    function __construct() {
        parent::__construct();
        $this->load->dbutil();
    }
    
    function get_data_bpjs(){
    	$data = array();
    	$this->db->where('code',$this->session->userdata('klinik'));
    	$query = $this->db->get('cl_clinic');
        if ($query->num_rows() > 0){
            $data = $query->row_array();
        }
        $query->free_result();    
        return $data;
    }
    
    function get_server_bpjs(){
		$data=array();
		$this->db->where('key','bpjs_server');
    	$query = $this->db->get('app_config');
        if ($query->num_rows() > 0){
            $data = $query->row_array();
        }
        $query->free_result();    
        return $data['value'];
	}
    
    function checkBPJS($code=""){
        //$kode = lcfirst($code);
        if ($this->dbutil->database_exists("epuskesmas_live_jaktim_$code"))
        {
            $this->load->database("epuskesmas_live_jaktim_".$code, FALSE, TRUE);

            $row = array();
            $data = $this->db->get('bpjs_setting')->result_array();
            foreach ($data as $dt) {
                $row[$dt['name']] = $dt['value'];
            }

            $data = array(
                'code' => $code,
                'server'    => $row['bpjs_server'],
                'username'  => $row['bpjs_username'],
                'password'  => $row['bpjs_password'],
                'consid'    => $row['bpjs_consid'],
                'secretkey' => $row['bpjs_secret']
            );

            $this->load->database("default", FALSE, TRUE);
            $this->db->delete('cl_phc_bpjs', array('code' => $code));
            $this->db->insert('cl_phc_bpjs', $data);

            return $data;
        }else{
            $data = array(
                'code' => "kosong",
            );
            return $data;
        }
    }
    
    function insert_dataembalase(){
		$id=$this->session->userdata('klinik');
    	$this->db->where('code',$id);
    	$query = $this->db->get('cl_clinic');
        if ($query->num_rows() > 0){
            $dataup = array(
            	'embalase' => $this->input->post('embalase'),
            	'embalase_harga' => $this->input->post('embalase_harga')
            );
            
            $this->db->where('code',$id);
            $this->db->update('cl_clinic',$dataup);
            
            echo '1';
        }else{
        	echo '0';
        }
	}
	function insert_puskesmas(){
        $id=$this->session->userdata('klinik');
        $this->db->where('code',$id);
        $query = $this->db->get('cl_clinic');
        if ($query->num_rows() > 0){
            $dataup = array(
                'cd_puskesmas' => $this->input->post('puskesmas'),
            );
            
            $this->db->where('code',$id);
            $this->db->update('cl_clinic',$dataup);
            
            echo '1';
        }else{
            echo '0';
        }
    }
    function insert_databpjs($value=0){
    	$id=$this->session->userdata('klinik');
    	$this->db->where('code',$id);
    	$query = $this->db->get('cl_clinic');
        if ($query->num_rows() > 0){
            $dataup = array(
            	'username' => $this->input->post('usernamebpjs'),
            	'password' => $this->input->post('passwordbpjs'),
            	'consid' => $this->input->post('considbpjs'),
            	'secretkey' => $this->input->post('keybpjs'),
            );
            $this->db->where('code',$id);
            $this->db->update('cl_clinic',$dataup);
        }else{
        	$data = array(
            	'username' => $this->input->post('usernamebpjs'),
            	'password' => $this->input->post('passwordbpjs'),
            	'consid' => $this->input->post('considbpjs'),
            	'secretkey' => $this->input->post('keybpjs'),
            	'code' => $id,
            );
            $this->db->insert('cl_clinic',$data);
        }
    }
    
    function get_data_klinik(){
    	$this->db->where('code',$this->session->userdata('klinik'));
    	return $this->db->get('cl_clinic')->result();
    }

    function get_data()
    {
        $query = $this->db->get($this->tabel);
		foreach($query->result_array() as $key=>$value){
			if($value['key']!='district') $data[$value['key']]=$value['value'];
		}
        return $data;
    }

    function get_theme()
    {
        $query = $this->db->get('app_theme');
        foreach($query->result_array() as $key=>$dt){
			$data[$dt['id_theme']]=$dt['name']." :: ".$dt['folder'];
		}
		$query->free_result();    
		return $data;
    }
	
    function update_entry()
    {
		$theme_default['value']=$this->input->post('theme_default');
		$this->db->update($this->tabel, $theme_default, array('key' => 'theme_default'));

		$theme_offline['value']=$this->input->post('theme_offline');
		$this->db->update($this->tabel, $theme_offline, array('key' => 'theme_offline'));

		$title['value']=$this->input->post('title');
		$this->db->update($this->tabel, $title, array('key' => 'title'));

		if($this->input->post('online')){
			$online['value']=1;
		}else{
			$online['value']=0;
		}
		$this->db->update($this->tabel, $online, array('key' => 'online'));

		$description['value']=$this->input->post('description');
		$this->db->update($this->tabel, $description, array('key' => 'description'));

		$keywords['value']=$this->input->post('keywords');
		$this->db->update($this->tabel, $keywords, array('key' => 'keywords'));
		
		$bpjs_server['value']=$this->input->post('serverbpjs');
		$this->db->update($this->tabel, $bpjs_server, array('key' => 'bpjs_server'));
		
		return true;
    }
	function get_puskesmas($start=0,$limit=99999){
        return $this->db->get('cl_phc',$limit,$start)->result_array();
    }
    function get_data_puskesmas(){
        $this->db->select('cd_puskesmas');
        $this->db->where('code',$this->session->userdata('klinik'));
        return $this->db->get('cl_clinic')->row_array();   
    }
    function get_nmpuskesmas(){
        $this->db->select("cl_phc.value");
        $this->db->join('cl_phc','cl_phc.code = cl_clinic.cd_puskesmas');
        $this->db->where('cl_clinic.code',$this->session->userdata('klinik'));
        $query = $this->db->get('cl_clinic');
        if ($query->num_rows() > 0) {
            $dt = $query->row_array();
            $data = $dt['value'];
        }else{
            $data = '-';
        }
        return $data;
    }
}


