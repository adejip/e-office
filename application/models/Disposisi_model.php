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
        $get = $this->input->get();
        if(isset($get["inst"])) {
            $this->db->where("disposisi.instruksi_disposisi",$get["inst"]);
        }
        $this->db->select("relasi_disposisi.*");
        $this->db->select("disposisi.*");
        $this->db->select("pesan.subjek");
        $this->db->from("relasi_disposisi");
        $this->db->join("disposisi","relasi_disposisi.id_disposisi = disposisi.id_disposisi","left");
        $this->db->join("pesan","relasi_disposisi.id_pesan = pesan.id_pesan","left");
        $this->db->where("relasi_disposisi.dari_user",$this->session->userdata("id_pengguna"));
        $this->db->group_by("relasi_disposisi.kode_disposisi");
        $this->db->order_by("disposisi.waktu_kirim","desc");

        $data = $this->db->get()->result();

        foreach($data as $key=>$masuk) {
            $this->db->select("pengguna.nama_lengkap,relasi_disposisi.kode_disposisi,relasi_disposisi.dibaca");
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

        $this->db->select("pengguna.nama_lengkap,relasi_disposisi.dari_user,relasi_disposisi.ke_user,relasi_disposisi.kode_disposisi,relasi_disposisi.dibaca");
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

        $this->db->select("pengguna.nama_lengkap AS pengirim,relasi_disposisi.dari_user,relasi_disposisi.ke_user,relasi_disposisi.kode_disposisi,relasi_disposisi.dibaca,relasi_disposisi.starred,relasi_disposisi.id_relasi_disposisi");
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
        $this->db->select("disposisi.*");
        $this->db->select("pesan.subjek");
        $this->db->select("disposisi.selesai AS disposisi_selesai");
        $this->db->select("pengguna.nama_lengkap");
        $this->db->from("relasi_disposisi");
        $this->db->join("disposisi","relasi_disposisi.id_disposisi = disposisi.id_disposisi");
        $this->db->join("pengguna","relasi_disposisi.dari_user = pengguna.id_pengguna","left");
        $this->db->join("pesan","relasi_disposisi.id_pesan = pesan.id_pesan","left");
        $this->db->where("relasi_disposisi.ke_user",$this->session->userdata("id_pengguna"));
        $this->db->group_by("relasi_disposisi.kode_disposisi");
        $this->db->order_by("disposisi.waktu_kirim","desc");

        $data = $this->db->get()->result();
        return $data;
    }

    public function ambil_disposisi_per_tanggal() {
        $this->db->select("COUNT(relasi_disposisi.id_relasi_disposisi) AS jumlah");
        $this->db->select("DATE(disposisi.waktu_kirim) AS waktu_kirim");
        $this->db->from("relasi_disposisi");
        $this->db->join("disposisi","relasi_disposisi.id_disposisi = disposisi.id_disposisi","left");

        if($this->session->userdata("id_jabatan") != 1)
            $this->db->where("relasi_disposisi.ke_user",$this->session->userdata("id_pengguna"));

        $this->db->group_by("DATE(disposisi.waktu_kirim)");

        return $this->db->get()->result();
    }

    public function baca_disposisi($id_disposisi,$kode_disposisi) {
        $this->db->where("id_disposisi",$id_disposisi)
            ->where("kode_disposisi",$kode_disposisi)
            ->where("ke_user",$this->session->userdata("id_pengguna"))
            ->update("relasi_disposisi",array("dibaca"=>1));
        return true;
    }

    public function selesai($id_disposisi,$kode_disposisi,$targetNotif) {
        foreach($targetNotif as $penerimaNotif) {
            $this->pemberitahuan->buat(array(
                "id_pengguna" => $penerimaNotif,
                "dari_pengguna" => $this->session->userdata("id_pengguna"),
                "judul" => "Disposisi selesai",
                "pesan" => "Pembuat disposisi menyatakan disposisi sudah selesai",
                "link" => "baca_disposisi_masuk/" . $id_disposisi . "/" . $kode_disposisi
            ));
        }
        $this->db->where("id_disposisi",$id_disposisi)
            ->update("disposisi",array("selesai"=>1));
        return true;
    }

    public function follow_up($post,$id_disposisi,$kode_disposisi,Array $targetNotif = null) {
        if($targetNotif == null) {
            $this->pemberitahuan->buat(array(
                "id_pengguna" => $post["pembuat"],
                "dari_pengguna" => $this->session->userdata("id_pengguna"),
                "judul" => "Respon disposisi",
                "pesan" => "Disposisi anda sudah direspon",
                "link" => "baca_disposisi_keluar/" . $id_disposisi . "/" . $kode_disposisi
            ));
        } else {
            foreach($targetNotif as $penerimaNotif) {
                $this->pemberitahuan->buat(array(
                    "id_pengguna" => $penerimaNotif,
                    "dari_pengguna" => $this->session->userdata("id_pengguna"),
                    "judul" => "Respon disposisi",
                    "pesan" => "Pembuat disposisi yang anda terima merespon",
                    "link" => "baca_disposisi_masuk/" . $id_disposisi . "/" . $kode_disposisi
                ));
            }
        }
        if(isset($post["pembuat"]))
            unset($post["pembuat"]);
        if(isset($post["penerima"]))
            unset($post["penerima"]);
        return $this->db->insert("follow_up_disposisi",$post);
    }

    public function ambil_follow_up($id_disposisi) {
        $this->db->select("follow_up_disposisi.*,pengguna.nama_lengkap");
        $this->db->from("follow_up_disposisi");
        $this->db->join("pengguna","follow_up_disposisi.id_pengguna = pengguna.id_pengguna","left");
        return $this->db
            ->where("id_disposisi",$id_disposisi)
            ->get()->result();
    }

    public function update_star($id_relasi_disposisi,$stat) {
        $this->db->where("id_relasi_disposisi",$id_relasi_disposisi);
        $this->db->update("relasi_disposisi",array(
            "starred" => $stat
        ));
    }

}