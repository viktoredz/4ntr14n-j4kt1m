<?php
class Cli_model extends CI_Model {

    function __construct() {
        parent::__construct();
    }

    function reset_pasien_bpjs_nohp_null(){
        $this->db->where('bpjs <>','');
        $this->db->where('nomor','-');
        $pasien = $this->db->update('cl_pasien',array('nomor'=>''));

        return $pasien;
    }

    function get_pasien_bpjs_nohp_null(){
        $this->db->where('bpjs <>','');
        $this->db->where('nomor','');
        $pasien = $this->db->get('cl_pasien')->row();

        return $pasien;
    }

    function update_pasien_bpjs_nohp_null($cl_pid,$res){
        $nohp = str_replace(" ","",trim($res['noHP']));
        $nohp = str_replace("-","",$nohp);
    	$nohp = str_replace("'","",$nohp);
        if(strlen($nohp) < 10){
            $data['nomor'] = "-";
        }else{
            if(substr($nohp, 0, 1)=="0"){
                $nohp = substr($nohp, 1);
            }
            $data['nomor'] = $nohp;
        }

      	echo $cl_pid." : ".$res['nama']." : ".$data['nomor'] ." : ".$res['kdProviderPst']['nmProvider'];

    	$this->db->where('cl_pid',$cl_pid);
    	return $this->db->update('cl_pasien',$data);
    }

    function exclude_cl_pid($puskesmas){
    	$data = array();

    	$this->db->select('username,cl_pid');
    	$this->db->where('code',substr($puskesmas,1));
    	$this->db->where('cl_pid !=','');

    	$pasien = $this->db->get('app_users_epus')->result_array();
    	foreach ($pasien as $value) {
    		$data[] = $value['cl_pid'];
    	}
    	return "('".implode("','", $data)."')";
    }

    function update_antrian($dt,$cl_phc){
        $this->db->where('reg_id',$dt['reg_id']);
        $check = $this->db->get('cl_reg')->row();
        if(empty($check->reg_id)){
            $antrian = array(
                'reg_id'            => $dt['reg_id'],
                'reg_time'          => $dt['reg_time'],
                'cl_pid'            => $dt['cl_pid'],
                'reg_antrian_poli'  => $dt['reg_antrian_poli'],
                'reg_antrian'       => $dt['reg_antrian'],
                'reg_poli'          => $dt['reg_poli'],
                'status_periksa'    => $dt['status_periksa'],
                'status_lab'        => $dt['status_lab'],
                'status_apotek'     => $dt['status_apotek'],
                'status_kasir'      => $dt['status_kasir']
            );
            if($this->db->insert('cl_reg',$antrian)){
                $this->db->where('cl_pid',$dt['cl_pid']);
                $check2 = $this->db->get('cl_pasien')->row();
                if(empty($check2->cl_pid)){
                    return "notexisted";
                }else{
                    return "insert";
                }
            }else{
                return "error";
            }

        }else{
            $antrian = array(
                'status_periksa'    => $dt['status_periksa'],
                'status_lab'        => $dt['status_lab'],
                'status_apotek'     => $dt['status_apotek'],
                'status_kasir'      => $dt['status_kasir']
            );
            $this->db->where('reg_id',$dt['reg_id']);
            if($this->db->update('cl_reg',$antrian)){
                $this->db->where('cl_pid',$dt['cl_pid']);
                $check2 = $this->db->get('cl_pasien')->row();
                if(empty($check2->cl_pid)){
                    return "notexisted";
                }else{
                    return "update";
                }
            }else{
                return "error";
            }
        }
    }

    function register($dt,$cl_phc){

        $this->db->where('cl_phc',$cl_phc);
        $this->db->where('cl_pid',$dt['id']);
        $check = $this->db->get('cl_pasien')->row();
        if(empty($check->cl_pid)){
            $pbk = array(
                'cl_pid'    => $dt['id'],
                'cl_phc'    => $cl_phc,
                'bpjs'      => $dt['no_bpjs'],
                'nomor'     => substr($dt['nohp'],0,20),
                'alamat'    => $dt['alamat'],
                'nik'       => $dt['nik'],
                'nama'      => $dt['nama_lengkap']
            );
            if($this->db->insert('cl_pasien',$pbk)){
                return "insert";
            }else{
                return "error";
            }

        }else{
            if(strlen($dt['nohp']) < 10){
                $pbk = array(
                    'bpjs'      => $dt['no_bpjs'],
                    'alamat'    => $dt['alamat'],
                    'nik'       => $dt['nik'],
                    'nama'      => $dt['nama_lengkap']
                );
            }else{
                $pbk = array(
                    'bpjs'      => $dt['no_bpjs'],
                    'nomor'     => substr($dt['nohp'],0,20),
                    'nik'       => $dt['nik'],
                    'alamat'    => $dt['alamat'],
                    'nama'      => $dt['nama_lengkap']
                );
            }
            $this->db->where('cl_pid',$dt['id']);
            $this->db->where('cl_phc',$cl_phc);
            if($this->db->update('cl_pasien',$pbk)){
                return "update";
            }else{
                return "error";
            }
        }
    }

    function getlastpanggilanid(){
        $this->db->order_by('panggilan_id','desc');
        $panggilan = $this->db->get('cl_panggilan')->row();
        if(!empty($panggilan->panggilan_id)){
            return $panggilan->panggilan_id;
        }else{
            return "0";
        }

    }

    function insert_panggilan($dt){
        if(isset($dt['panggilan_id'])){
            $data = array(
                'panggilan_id'  => $dt['panggilan_id'],
                'reg_id'        => $dt['reg_id'],
                'status_panggil'          => 0
            );
            if($this->db->insert('cl_panggilan',$data)){
                return "insert";
            }else{
                return "error";
            }
        }else{
            return "no data";
        }
    }

   function insert_kunjungan($dt, $username, $puskesmas){
        $this->db->select('MAX(id_kunjungan) as id');
        $this->db->where('code',$puskesmas);
        $this->db->where('tgl',date("Y-m-d",$dt['waktu_register']));
        $id = $this->db->get('kunjungan')->row();
        if(!empty($id->id)){
            $tmp = intval(substr($id->id, -3))+1;

            $number = str_repeat("0",3-strlen($tmp)).$tmp;
        }else{
            $number="001";
        }

    	$data['id_kunjungan']    = $puskesmas.date('Ymd',$dt['waktu_register']).$number;
        $data['username']        = $username;
        $data['code']            = $puskesmas;
        $data['tgl']             = date("Y-m-d",$dt['waktu_register']);
        $data['waktu']           = date("H:i:s",$dt['waktu_register']);
        $data['tb']            	 = $dt['anamnesa']['tinggi_badan'] != '' ? $dt['anamnesa']['tinggi_badan'] : 0;
        $data['bb']            	 = $dt['anamnesa']['berat_badan'] != '' ? $dt['anamnesa']['berat_badan'] : 0;
        $data['systolic']        = $dt['anamnesa']['sistole'] != '' ? $dt['anamnesa']['sistole'] : 0;
        $data['diastolic']       = $dt['anamnesa']['diastole'] != '' ? $dt['anamnesa']['diastole'] : 0;

        $data['pulse']       		= $dt['anamnesa']['detak_nadi'] != '' ? $dt['anamnesa']['detak_nadi'] : 0;
        $data['respiratory_rate']	= $dt['anamnesa']['nafas'] != '' ? $dt['anamnesa']['nafas'] : 0;
        $data['temperature']       	= $dt['anamnesa']['suhu_badan'] != '' ? $dt['anamnesa']['suhu_badan'] : 0;

        $data['cl_sdm_code']       	= $dt['kode_pemeriksa'] != '' ? $dt['kode_pemeriksa'] : '';
        $data['kdsadar']       		= $dt['anamnesa']['kesadaran'] != '' ? $dt['anamnesa']['kesadaran'] : '01';
        $data['status_antri']    	= "selesai";
        $data['reg_id']       		= $dt['register_id'] != '' ? $dt['register_id'] : '';
        $data['status_updated']     = 1;

        $kelainan['id_kunjungan']	= $data['id_kunjungan'];
        $kelainan['kepala']			= $dt['anamnesa']['kepala'];
        $kelainan['mata']			= $dt['anamnesa']['mata'];
        $kelainan['hidung']			= $dt['anamnesa']['hidung'];
        $kelainan['telinga']		= $dt['anamnesa']['telinga'];
        $kelainan['mulut']			= $dt['anamnesa']['mulut'];
        $kelainan['leher']			= $dt['anamnesa']['leher'];
        $kelainan['dada']			= $dt['anamnesa']['dada'];
        $kelainan['punggung']		= $dt['anamnesa']['punggung'];
        $kelainan['cp']				= $dt['anamnesa']['cp'];
        $kelainan['perut']			= $dt['anamnesa']['perut'];
        $kelainan['hl']				= $dt['anamnesa']['hl'];
        $kelainan['kelamin']		= $dt['anamnesa']['kelamin'];
        $kelainan['exatas']			= $dt['anamnesa']['exatas'];
        $kelainan['exbawah']		= $dt['anamnesa']['exbawah'];

 	   	if($this->db->insert('kunjungan',$data)){
    		$diagnosa = $dt['diagnosa'];
    		if(count($diagnosa)>0){
    			foreach ($diagnosa as $dt) {
					$this->insert_diagnosa($dt, $data['id_kunjungan']);
    			}
    		}

			$this->db->insert('kunjungan_kelainan', $kelainan);
 	   	}
   	}

    function insert_diagnosa($dt, $id_kunjungan){
    	$data['id_kunjungan']    	= $id_kunjungan;
    	$data['code_icdx']    		= $dt['id_diagnosa'];
    	$data['jenis_kasus']    	= $dt['diag_kasus']==1 ? 'Lama' : 'Baru';
    	$data['jenis_diagnosa']    	= $dt['diag_jenis']==1 ? 'sekunder' : ($dt['diag_jenis']==2 ? 'komplikasi' : 'primer');
    	$data['status_updated']    	= 0;

    	return $this->db->insert('kunjungan_icdx',$data);
    }

    function _prep_password($password){
        return $this->encrypt->sha1($password.$this->config->item('encryption_key'));
    }

}
