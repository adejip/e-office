<?php

/**
 * Created by PhpStorm.
 * User: edgar
 * Date: 1/26/2017
 * Time: 4:53 PM
 */
defined("BASEPATH") OR exit("Akses ditolak!");
class Disposisi_model extends CI_Model {

    public function __construct() {
        parent::__construct();
        $this->load->model("Pemberitahuan_model","pemberitahuan");
    }

    public function kirim($post,$id_pesan) {
        unset($post["btnSubmit"]);
        $to_user = $post["penerima"];
        if(count($to_user) == 0) return false;
        unset($post["penerima"]);
        $insert = $this->db->insert("disposisi",$post);
        $id_disposisi = $this->db->insert_id();
        $kode_disposisi = sha1(uniqid("ID_")."-".$id_disposisi);
        if($insert) {
            $this->tandai_disposisi($id_pesan,$id_disposisi . "/" . $kode_disposisi);
            foreach($to_user as $user) {
                $relasi = array(
                    "id_disposisi" => $id_disposisi,
                    "id_pesan" => $id_pesan,
                    "dari_user" => $this->session->userdata("id_pengguna"),
                    "ke_user" => $user,
                    "kode_disposisi" => $kode_disposisi
                );
                $this->db->insert("relasi_disposisi",$relasi);
                $this->pemberitahuan->buat(array(
                    "id_pengguna" => $user,
                    "dari_pengguna" => $this->session->userdata("id_pengguna"),
                    "judul" => "Disposisi",
                    "pesan" => $post["isi_disposisi"],
                    "link" => "baca_disposisi_masuk/" . $id_disposisi . "/" . $kode_disposisi
                ));
            }
            return true;
        } else return false;
    }

    private function tandai_disposisi($id_pesan,$kode) {
        $this->db->where("id_pesan",$id_pesan);
        $this->db->where("ke_user",$this->session->userdata("id_pengguna"));
        $this->db->update("relasi_pesan",array(
            "disposed" => $kode
        ));
        return true;
    }

    public function ambil_disposisi_keluar() {
        $this->db->select("relasi_disposisi.*");
        $this->db->select("disposisi.*");
        $this->db->from("relasi_disposisi");
        $this->db->join("disposisi","relasi_disposisi.id_disposisi = disposisi.id_disposisi","left");
        $this->db->where("relasi_disposisi.dari_user",$this->session->userdata("id_pengguna"));
        $this->db->group_by("relasi_disposisi.kode_disposisi");
        $this->db->order_by("disposisi.waktu_kirim","desc");

        $data = $this->db->get()->result();

        foreach($data as $key=>$masuk) {
            $this->db->select("pengguna.nama_lengkap,relasi_disposisi.kode_disposisi,relasi_disposisi.dibaca,relasi_disposisi.selesai AS selesai_ditangani,relasi_disposisi.catatan_selesai");
            $this->db->from("pengguna");
            $this->db->join("relasi_disposisi","relasi_disposisi.ke_user = pengguna.id_pengguna","left");
            $this->db->where("relasi_disposisi.id_disposisi",$masuk->id_disposisi);
            $this->db->where("relasi_disposisi.kode_disposisi",$masuk->kode_disposisi);

            $data[$key]->penerima = $this->db->get()->result();
        }

        return $data;
    }

    public function ambil_satu_disposisi($id_disposisi,$kode_disposisi) {
        $this->db->select("disposisi.*");
        $this->db->where("disposisi.id_disposisi",$id_disposisi);
        $this->db->from("disposisi");

        $data = $this->db->get()->row();

        $this->db->select("pengguna.nama_lengkap,relasi_disposisi.kode_disposisi,relasi_disposisi.dibaca,relasi_disposisi.selesai AS selesai_ditangani,relasi_disposisi.catatan_selesai");
        $this->db->from("pengguna");
        $this->db->join("relasi_disposisi","relasi_disposisi.ke_user = pengguna.id_pengguna","left");
        $this->db->where("relasi_disposisi.id_disposisi",$id_disposisi);
        $this->db->where("relasi_disposisi.kode_disposisi",$kode_disposisi);

        $pengguna = $this->db->get()->result();

        $id_pesan = $this->db->select("id_pesan")->from("relasi_disposisi")->where("kode_disposisi",$kode_disposisi)
            ->limit(1)->get()->row()->id_pesan;

        $lampiran_pesan = $this->db->where("id_pesan",$id_pesan)->get("pesan")->row();

        $data->penerima = $pengguna;
        $data->lampiran_surat = $lampiran_pesan;

        return $data;
    }

    public function ambil_satu_disposisi_masuk($id_disposisi,$kode_disposisi) {
        $this->db->select("disposisi.*");
        $this->db->where("disposisi.id_disposisi",$id_disposisi);
        $this->db->from("disposisi");

        $data = $this->db->get()->row();

        $this->db->select("pengguna.nama_lengkap AS pengirim,relasi_disposisi.kode_disposisi,relasi_disposisi.dibaca,relasi_disposisi.selesai AS selesai_ditangani,relasi_disposisi.catatan_selesai,relasi_disposisi.starred,relasi_disposisi.id_relasi_disposisi");
        $this->db->from("pengguna");
        $this->db->join("relasi_disposisi","relasi_disposisi.dari_user = pengguna.id_pengguna","left");
        $this->db->where("relasi_disposisi.id_disposisi",$id_disposisi);
        $this->db->where("relasi_disposisi.kode_disposisi",$kode_disposisi);
        $this->db->where("relasi_disposisi.ke_user",$this->session->userdata("id_pengguna"));

        $pengguna = $this->db->get()->row();

        $id_pesan = $this->db->select("id_pesan")->from("relasi_disposisi")->where("kode_disposisi",$kode_disposisi)
            ->limit(1)->get()->row()->id_pesan;

        $lampiran_pesan = $this->db->where("id_pesan",$id_pesan)->get("pesan")->row();

        $data->penerima = $pengguna;
        $data->lampiran_surat = $lampiran_pesan;

        return $data;
    }

    public function ambil_disposisi_masuk() {
        $get = $this->input->get();
        if(isset($get["inst"])) {
            $this->db->where("disposisi.instruksi_disposisi",$get["inst"]);
        }

        $this->db->select("relasi_disposisi.*");
        $this->db->select("relasi_disposisi.selesai AS pengguna_selesai");
        $this->db->select("disposisi.*");
        $this->db->select("disposisi.selesai AS disposisi_selesai");
        $this->db->select("pengguna.nama_lengkap");
        $this->db->from("relasi_disposisi");
        $this->db->join("disposisi","relasi_disposisi.id_disposisi = disposisi.id_disposisi");
        $this->db->join("pengguna","relasi_disposisi.dari_user = pengguna.id_pengguna","left");
        $this->db->where("relasi_disposisi.ke_user",$this->session->userdata("id_pengguna"));
        $this->db->group_by("relasi_disposisi.kode_disposisi");
        $this->db->order_by("disposisi.waktu_kirim","desc");

        $data = $this->db->get()->result();
        return $data;
    }

    public function ambil_disposisi_per_tanggal($tgl) {
        $this->db->where("DATE(waktu_kirim)",$tgl);
        return $this->db->get("disposisi")->num_rows();
    }

    public function baca_disposisi($id_disposisi,$kode_disposisi) {
        $this->db->where("id_disposisi",$id_disposisi)
            ->where("kode_disposisi",$kode_disposisi)
            ->where("ke_user",$this->session->userdata("id_pengguna"))
            ->update("relasi_disposisi",array("dibaca"=>1));
        return true;
    }

    public function selesai($catatan,$id_disposisi,$kode_disposisi) {
        $this->db->where("id_disposisi",$id_disposisi)
            ->where("kode_disposisi",$kode_disposisi)
            ->where("ke_user",$this->session->userdata("id_pengguna"))
            ->update("relasi_disposisi",array("selesai"=>1,"catatan_selesai"=>$catatan));
        return true;
    }

    public function update_star($id_relasi_disposisi,$stat) {
        $this->db->where("id_relasi_disposisi",$id_relasi_disposisi);
        $this->db->update("relasi_disposisi",array(
            "starred" => $stat
        ));
    }

}