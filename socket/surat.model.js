/**
 * Created by edgar on 6/8/17.
 */
var settings = {
    host: "localhost",
    database: "disposisi",
    user: "root",
    password: ""
};

var db = require("node-querybuilder").QueryBuilder(settings,"mysql","single");

module.exports = {


    ambil_daftar_surat_masuk: function(id_user,callback) {
        db.select("relasi_pesan.id_pesan,relasi_pesan.starred,relasi_pesan.dibaca,relasi_pesan.disposed,pesan.id_pesan,pesan.isi_pesan,pesan.waktu_kirim,pengguna.nama_lengkap AS pengirim");
        db.join("pesan","relasi_pesan.id_pesan = pesan.id_pesan","left");
        db.join("pengguna","relasi_pesan.dari_user = pengguna.id_pengguna","left");
        db.where("relasi_pesan.ke_user",id_user)
        db.get("relasi_pesan",callback);
    }



};