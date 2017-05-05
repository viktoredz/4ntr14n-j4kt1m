<?php
class Bpjs_model extends CI_Model {

    var $tabel    = 'app_config';
    var $server;
    var $consid;
    var $secretkey;
    var $username;
    var $password;
    var $xtime;
    var $xauth;
    var $data;
    var $signature;
    var $xsign;

    function __construct() {
        parent::__construct();

        require_once(APPPATH.'third_party/httpful.phar');

        $this->get_data_bpjs();
    }

    function get_data_bpjs(){
        $data = $this->get_data();

        $this->server       = $data['bpjs_server'];
        $this->username     = $data['bpjs_username'];
        $this->password     = $data['bpjs_password'];
        $this->consid       = $data['bpjs_consid'];
        $this->secretkey    = $data['bpjs_secret'];
        $this->xtime        = time();
        $this->maxxtimeget  = 15;
        $this->maxxtimepost = 120;
        $this->xauth        = base64_encode($this->username.':'.$this->password.':095');
        $this->data         = $this->consid."&".$this->xtime;
        $this->signature    = hash_hmac('sha256', $this->data, $this->secretkey, true);
        $this->xsign        = base64_encode($this->signature);

        return $data;
    }

    function getApi($url="",$ver = 1){
       $this->get_data_bpjs();
       if($ver!=1){
            $this->server = str_replace("v1", "v2", $this->server);
       }

       try
        {
          $response = \Httpful\Request::get($this->server.$url)
          ->xConsId($this->consid)
          ->xTimestamp($this->xtime)
          ->xSignature($this->xsign)
          ->xAuthorization("Basic ".$this->xauth)
          ->timeout($this->maxxtimeget)
          ->send();
           $data = json_decode($response,true);
        }
        catch(Exception $E)
        {
          $reflector = new \ReflectionClass($E);
          $classProperty = $reflector->getProperty('message');
          $classProperty->setAccessible(true);
          $data = $classProperty->getValue($E);
          $data = "Tidak dapat terkoneksi ke server BPJS, silakan dicoba lagi";
          $data = array("metaData"=>array("message" =>'error',"code"=>777));
          //die(json_encode(array("res"=>"error","msg"=>$data)));

        }

        if($data["metaData"]["code"]=="500"){
          die(json_encode(array("res"=>"500","msg"=>$data["metaData"]["message"])));
        }
        /*update message ketika nomor kartu tidak ditemukan--> kasus no kartu tidak sama dengan 13*/
        if($data["metaData"]["code"]=="412"){
          die(json_encode(array("res"=>"412","msg"=>$data["response"][0]["message"])));
        }

        return $data;
    }

    function postApi($url="", $data=array()){
        $this->get_data_bpjs("live");

       try
        {
          $response = \Httpful\Request::post($this->server.$url)
          ->xConsId($this->consid)
          ->xTimestamp($this->xtime)
          ->xSignature($this->xsign)
          ->xAuthorization("Basic ".$this->xauth)
          ->body($data)
          ->sendsJson()
          ->timeout($this->maxxtimepost)
          ->send();
          $data = json_decode($response,true);
        }
        catch(Exception $E)
        {
          $reflector = new \ReflectionClass($E);
          $classProperty = $reflector->getProperty('message');
          $classProperty->setAccessible(true);
          $data = $classProperty->getValue($E);
          $data = "Tidak dapat terkoneksi ke server BPJS, silakan dicoba lagi";
          $data = array("metaData"=>array("message" =>'error',"code"=>777));
          //die(json_encode(array("res"=>"error","msg"=>$data)));
        }
        //die(print_r($response));
        // if($response["metaData"]["code"]=="201"){

        // }elseif($response["metaData"]["code"]=="304"){

        // }else{

        // }

        return $data;
    }

    function putApi($url="", $data=array()){
       $this->get_data_bpjs();
       try
        {
          $response = \Httpful\Request::post($this->server.$url)
          ->xConsId($this->consid)
          ->xTimestamp($this->xtime)
          ->xSignature($this->xsign)
          ->xAuthorization("Basic ".$this->xauth)
          ->body($data)
          ->sendsJson()
          ->timeout($this->maxxtimepost)
          ->send();
        }
        catch(Exception $E)
        {
          $reflector = new \ReflectionClass($E);
          $classProperty = $reflector->getProperty('message');
          $classProperty->setAccessible(true);
          $data = $classProperty->getValue($E);
          $data = "Tidak dapat terkoneksi ke server BPJS, silakan dicoba lagi";
          die(json_encode(array("res"=>"error","msg"=>$data)));
        }
        $data = json_decode($response,true);

        if($response["metaData"]["code"]=="200"){

        }else{

        }

        return $data;
    }

    function deleteApi($url=""){
       $this->get_data_bpjs();
       try
        {
          $response = \Httpful\Request::delete($this->server.$url)
          ->xConsId($this->consid)
          ->xTimestamp($this->xtime)
          ->xSignature($this->xsign)
          ->xAuthorization("Basic ".$this->xauth)
          ->send();
          $data = json_decode($response,true);
        }
        catch(Exception $E)
        {
          $reflector = new \ReflectionClass($E);
          $classProperty = $reflector->getProperty('message');
          $classProperty->setAccessible(true);
          $data = $classProperty->getValue($E);
          $data = "Tidak dapat terkoneksi ke server BPJS, silakan dicoba lagi";
          $data = array("metaData"=>array("message" =>'error',"code"=>777));
        }
        return $data;
    }

    function bpjs_search($by="nik",$no){
        if($by == "nik"){
            $data = $this->getApi('peserta/nik/'.$no,2);
        }else{
            $data = $this->getApi('peserta/'.$no,2);
        }

        return $data;
    }

    function get_data()
    {
        $query = $this->db->get($this->tabel);
		foreach($query->result_array() as $key=>$value){
			if($value['key']!='district') $data[$value['key']]=$value['value'];
		}
        return $data;
    }

    function update_bpjs()
    {
		$consid['value']=$this->input->post('bpjs_consid');
		$this->db->update($this->tabel, $consid, array('key' => 'bpjs_consid'));

        $secret['value']=$this->input->post('bpjs_secret');
        $this->db->update($this->tabel, $secret, array('key' => 'bpjs_secret'));

        $username['value']=$this->input->post('bpjs_username');
        $this->db->update($this->tabel, $username, array('key' => 'bpjs_username'));

        $password['value']=$this->input->post('bpjs_password');
        $this->db->update($this->tabel, $password, array('key' => 'bpjs_password'));

        $status['value']=$this->input->post('bpjs_status');
        $this->db->update($this->tabel, $status, array('key' => 'bpjs_status'));
		
		return true;
    }
}


