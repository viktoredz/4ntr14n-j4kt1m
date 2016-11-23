<?php
class Morganisasi_model extends CI_Model {

    var $tabel     = 'app_theme';

    function __construct() {
        parent::__construct();
    }

    function get_data_puskesmas($start=0,$limit=999999,$options=array())
    {
    	$this->db->order_by('value','asc');
      $query = $this->db->get('cl_phc',$limit,$start);
      return $query->result();
    }

    function get_data_pasien(){
      $data = $this->db->get('cl_pasien')->result_array();

      return $data;
    }

    function get_jml_pasien(){
      $data = $this->db->get('cl_pasien')->num_rows();

      return $data;
    }

    function get_datawhere($code,$condition,$table){
        $this->db->select("*");
        $this->db->like($condition,$code);
        return $this->db->get($table)->result();
    }

    function get_poli(){
    	$this->db->where('is_antrian','1');
      	$data = $this->db->get('cl_clinic')->result_array();

      	return $data;
    }

    function get_antrian(){
    	$tgl = "RJ".date("Ymd");
    	$this->db->like('reg_id',$tgl);
    	$this->db->select('cl_pasien.cl_pid,cl_pasien.nama,cl_reg.reg_antrian,cl_reg.reg_poli,cl_reg.reg_antrian_poli');
    	$this->db->join('cl_pasien','cl_pasien.cl_pid=cl_reg.cl_pid');
    	$this->db->order_by('reg_time','asc');
    	$this->db->where('status_periksa','0');
		$data = $this->db->get('cl_reg',9)->result_array();

		return $data;
    }

    function get_panggilan(){
    	$this->db->select('cl_pasien.nama,cl_panggilan.reg_id,cl_reg.reg_poli,cl_reg.reg_antrian,cl_reg.reg_antrian_poli,cl_panggilan.panggilan_id');
    	$this->db->join('cl_reg','cl_reg.reg_id=cl_panggilan.reg_id');
    	$this->db->join('cl_pasien','cl_pasien.cl_pid=cl_reg.cl_pid');
    	$this->db->order_by('panggilan_id','asc');
    	$this->db->where('status_panggil','0');

		$data = $this->db->get('cl_panggilan')->row_array();

		return $data;
    }

    function call_antrian($panggilan_id){
    	$data 	= array();
    	$data['status_panggil'] = 1;

    	$this->db->where('panggilan_id',$panggilan_id);
    	$this->db->update('cl_panggilan',$data);
    }

	function get_profile($username=""){
		$data = array();
		if($username!=""){
			$options = array('app_users_list.username' => $username);
		}else{
   		     $options = array('app_users_list.username'=>$this->session->userdata('username'), 'app_users_list.code'=>$this->session->userdata('puskesmas'));
		}

		$this->db->join("app_users_profile","app_users_profile.username=app_users_list.username AND app_users_profile.code=app_users_list.code","INNER");

		$this->db->where($options);

		$query = $this->db->get_where('app_users_list');
		if ($query->num_rows() > 0){
			$data = $query->row_array();
		}

		$query->free_result();
		return $data;
	}

	function cek_session()
	{
		$this->db->select('*');
		$this->db->from('app_users_list');
		$this->db->where('username', $this->session->userdata('id_session'));
		$query=$this->db->get();
		return $query->num_rows();
	}

	function get_session()
	{
		$this->db->select('*');
		$this->db->from('app_users_list a, app_users_profile b');
		$this->db->where('a.username = b.username');
		$this->db->where('a.username', $this->session->userdata('id_session'));
		$query=$this->db->get();
		{
			if ($query->num_rows() > 0)
			{
				return $data = $query->row_array();
			}
		}
	}

	function check_email($str){
		$uid = ($this->session->userdata('username')!="") ? $this->session->userdata('username') : "";
        $this->db->where('email',$str);
		$this->db->where('username <>', $uid);
        $query = $this->db->get('app_users_profile');
		return $query->num_rows();
	}

	function check_password(){
		// $uid = ($this->session->userdata('username')!="") ? $this->session->userdata('username') : "";
        $this->db->where('password',$this->encrypt->sha1($this->input->post('password').$this->config->item('encryption_key')));
		$this->db->where('code', $this->session->userdata('puskesmas'));
		$this->db->where('username', $this->input->post('username'));
        $query = $this->db->get('app_users_list');
		return $query->num_rows();
	}

	function check_password2(){
		$uid = ($this->session->userdata('username')!="") ? $this->session->userdata('username') : "";
        $this->db->where('password',$this->encrypt->sha1($this->input->post('password').$this->config->item('encryption_key')));
		$this->db->where('code', $this->session->userdata('puskesmas'));
		$this->db->where('username', $uid);
        $query = $this->db->get('app_users_list');
		return $query->num_rows();
	}

	function check_username($str){
		$uid = ($this->session->userdata('username')!="") ? $this->session->userdata('username') : "";
        $this->db->where('username',$str);
		$this->db->where('username <>', $uid);
        $query = $this->db->get('app_users_profile');
		return $query->num_rows();
	}

    function insert_entry(){

        $data['username']=$this->input->post('username');
        $data['level']="member";
        $data['password']=$this->encrypt->sha1($this->input->post('password').$this->config->item('encryption_key'));
        $data['status_active']=1;
        $data['status_aproved']=0;
        $data['online']=0;
        $data['last_login']=0;
        $data['last_active']=0;
        $data['datereg']=time();

		$this->db->select('*');
		$this->db->from('app_users_list');
		$this->db->where('username', "".$this->input->post('username'));
		$query=$this->db->get();
		if ($query->num_rows() > 0) {
			$profile['email']=$this->input->post('email');
			$profile['nama']=$this->input->post('nama');
			$profile['phone_number']=$this->input->post('phone_number');
			if($this->db->update('app_users_profile',  $profile, array('username' => $this->input->post('username')))){
				return $this->input->post('username');
			}
		} else {
			if($this->db->insert("app_users_list", $data)) {

				$profile = array();
				//$profile['trup']=$this->createTRUP();
				$profile['username']=$this->input->post('username');
				$profile['email']=$this->input->post('email');
				$profile['nama']=$this->input->post('nama');
				$profile['phone_number']=$this->input->post('phone_number');
				if($this->db->insert("app_users_profile", $profile)){
					return $this->input->post('username');
				}
			} else {
				return false;
			}
		}
    }

    function update_profile()
    {
    	$profile['email']=$this->input->post('email');
    	$profile['nama']=$this->input->post('nama');
    	$profile['phone_number']=$this->input->post('phone_number');

    	$check = $this->db->get_where('app_users_profile', array('username' => $this->session->userdata('username'),'code'=>$this->session->userdata('puskesmas')));
		$check = $check->num_rows();

    	if($check>0){
    		$this->db->where('username',$this->session->userdata('username'));
    		$this->db->where('code',$this->session->userdata('puskesmas'));
	    	return $this->db->update('app_users_profile',  $profile);
	    } else {
	    	return 0;
	    }
    }

	function update_profile2()
    {
		$profile['nama']=$this->input->post('nama');
		$profile['phone_number']=$this->input->post('phone_number');
		$profile['no_hp']=$this->input->post('no_hp');
		$profile['email']=$this->input->post('email');

		$check = $this->db->get_where('app_users_profile', array('username' => $this->session->userdata('username')));
		$check = $check->num_rows();

		if($check>0){
			$oke=$this->db->update('app_users_profile', $profile, array('username' => $this->session->userdata('username')));
			if($oke)
			{
				$update['username'] = $this->session->userdata('username');
				$update['dateupdate']=time();
				$update['Keterangan']="User ".$this->session->userdata('username'). " Telah Mengubah Data Pengguna";
				return $this->db->replace('app_users_update', $update);
			}
			return $oke;
		}else{
			$profile['username'] = $this->session->userdata('username');
			$profile['username']=$this->session->userdata('username');
			return $this->db->insert('app_users_profile', $profile);
		}

    }

	function update_status()
    {
		$check = $this->db->get_where('app_users_profile', array('username' => $this->session->userdata('username')));
		$check = $check->num_rows();
		if($check>0)
		{
			$status['status_aproved']=0;
			$oke=$this->db->update('app_users_list', $status, array('username' => $this->session->userdata('username')));

			$lama['status']="Lama";

		}

    }

    function update_entry()
    {
		$options['username']		= $this->session->userdata('username');
		$options['username']		= $this->session->userdata('username');

		if($this->input->post('password')!="password" && $this->input->post('password2')!="password"){
			$data['password']=$this->encrypt->sha1($this->input->post('password').$this->config->item('encryption_key'));
		}

		$oke= $this->db->update('app_users_list', $data, $options);
		if($oke)
		{
			$update['username'] = $this->session->userdata('username');
			$update['dateupdate']=time();
			$update['Keterangan']="User ".$this->session->userdata('username')." Telah Mengubah Password";
			return $this->db->replace('app_users_update', $update);
		}
		return $oke;

    }

    function update_password($username) {
    	// $options['username']=$this->session->userdata('username');
    	$this->db->where('username',$username);
    	$this->db->where('code',$this->session->userdata('puskesmas'));
    	$data['password']=$this->encrypt->sha1($this->input->post('npassword').$this->config->item('encryption_key'));
    	return $this->db->update('app_users_list', $data);
    }

    function update_password2() {
    	// $options['username']=$this->session->userdata('username');
    	$this->db->where('username',$this->session->userdata('username'));
    	$this->db->where('code',$this->session->userdata('puskesmas'));
    	$data['password']=$this->encrypt->sha1($this->input->post('npassword').$this->config->item('encryption_key'));
    	return $this->db->update('app_users_list', $data);
    }

}
