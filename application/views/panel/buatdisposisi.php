
<div class="col-sm-9 col-sm-offset-3 col-lg-10 col-lg-offset-2 main">
    <div class="row">
        <ol class="breadcrumb">
            <li><a href="#"><svg class="glyph stroked home"><use xlink:href="#stroked-home"></use></svg></a></li>
            <li><a href="<?php echo base_url("panel/inbox/"); ?>">Surat Masuk</a></li>
            <li><a href="<?php echo base_url("panel/baca/".$pesan->id_pesan); ?>"><?php echo $pesan->subjek; ?></a></li>
            <li class="active">Buat Disposisi : <?php echo $pesan->subjek; ?></li>
        </ol>
    </div><!--/.row-->

    <hr/>

    <div class="row">
        <div class="col-lg-12">
            <div class="panel panel-default">
                <div class="panel-heading">Isi detail disposisi</div>
                <div class="panel-body">
                    <form action="" method="POST" enctype="multipart/form-data">
                        <div class="form-group">
                            <label>Penerima [<a href="#" data-toggle="modal" data-target="#modal_manage">Manage</a>]: </label>
                            <select name="penerima[]" class="form-control penerima" multiple required>
                                <?php foreach($daftar_pengguna as $daftar_dinas => $group_pengguna): ?>
                                    <optgroup label="<?php echo $daftar_dinas ?>">
                                        <?php foreach($group_pengguna as $pengguna):?>
                                            <option value="<?php echo $pengguna->id_pengguna; ?>" <?php echo (termasuk_penerima($pengguna->id_pengguna,$penerima_otomatis)) ? "selected" : ""; ?>><?php echo $pengguna->nama_lengkap . ", " . $pengguna->nama_jabatan . " - " . $daftar_dinas; ?></option>
                                        <?php endforeach;?>
                                    </optgroup>
                                <?php endforeach; ?>
                            </select>
                        </div>
                        <div class="form-group">
                            <label for="">Instruksi Disposisi</label>
                            <select name="instruksi_disposisi" id="instruksi" class="form-control" required>
                                <option value=""></option>
                                <option value="Ditindak Lanjuti">Ditindak Lanjuti</option>
                                <option value="Ditanggapi Tertulis">Ditanggapi Tertulis</option>
                                <option value="Disiapkan makalah/sambutan/presentasi sesuai tema">Disiapkan makalah/sambutan/presentasi sesuai tema</option>
                                <option value="Koordinasikan dengan">Koordinasikan dengan</option>
                                <option value="Diwakili dan laporkan hasilnya">Diwakili dan laporkan hasilnya</option>
                                <option value="Dihadiri dan laporkan hasilkan">Dihadiri dan laporkan hasilkan</option>
                                <option value="Disiapkan surat/memo dinas internal">Disiapkan surat/memo dinas internal</option>
                                <option value="Arsip/File">Arsip/File</option>
                                <option value="Lain-lain">Lain-lain</option>
                                <option value="Diketahui">Diketahui</option>
                                <option value="Diperhatikan">Diperhatikan</option>
                                <option value="Diberi Penjelasan">Diberi Penjelasan</option>
                                <option value="Diwakili">Diwakili</option>
                                <option value="Dibicarakan dengan saya">Dibicarakan dengan saya</option>
                                <option value="Diproses sesuai ketentuan yang berlaku">Diproses sesuai ketentuan yang berlaku</option>
                                <option value="Dilaksanakan/Diselesaikan/Disempurnakan">Dilaksanakan/Diselesaikan/Disempurnakan</option>
                                <option value="Dijawab dengan surat">Dijawab dengan surat</option>
                                <option value="Disiapkan sambutan tertulis">Disiapkan sambutan tertulis</option>
                                <option value="Disiapkan atau saran-saran">Disiapkan atau saran-saran</option>
                            </select>
                        </div>
                        <div class="form-group">
                            <label for="">Tanggal Selesai</label>
                            <input type="text" name="tanggal_selesai" class="form-control" id="tanggal">
                        </div>
<!--                        <div class="form-group">-->
<!--                            <label for="">Keamanan</label>-->
<!--                            <select name="keamanan" id="keamanan" class="form-control">-->
<!--                                <option value=""></option>-->
<!--                                <option value="Biasa">Biasa</option>-->
<!--                                <option value="Rahasia terbatas">Rahasia terbatas</option>-->
<!--                                <option value="Rahasia">Rahasia</option>-->
<!--                                <option value="Sangat Rahasia">Sangat Rahasia</option>-->
<!--                            </select>-->
<!--                        </div>-->
<!--                        <div class="form-group">-->
<!--                            <label for="">Kecepatan</label>-->
<!--                            <select name="kecepatan" id="kecepatan" class="form-control">-->
<!--                                <option value=""></option>-->
<!--                                <option value="Biasa">Biasa</option>-->
<!--                                <option value="Segera">Segera</option>-->
<!--                                <option value="Amat Segera">Amat Segera</option>-->
<!--                            </select>-->
<!--                        </div>-->
                        <hr />
                        <textarea name="isi_disposisi" id="msg" required></textarea><br />
                        <p>Lampiran</p>
                        <input type="file" multiple id="attach" name="attach[]" class="form-control"><br />
                        <input type="submit" name="btnSubmit" class="btn btn-success" value="Kirim">
                    </form>
                </div>
            </div>
        </div>
    </div><!--/.row-->

</div>	<!--/.main-->


<div id="modal_manage" class="modal fade" role="dialog">
    <div class="modal-dialog">

        <form action="<?php echo base_url("panel/tambah_penerima_otomatis/"); ?>" method="POST">

            <!-- Modal content-->
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                    <h4 class="modal-title">Manage Pengguna Otomatis</h4>
                </div>
                <div class="modal-body">
                    <p><i>Pengguna yang dipilih di bawah ini akan otomatis tertera dalam form penerima surat saat membuat surat</i></p>
                    <p><b>Penerima</b></p>
                    <select style="width: 100%;" name="penerima[]" class="form-control penerima" multiple>
                        <?php foreach($daftar_pengguna as $daftar_dinas => $group_pengguna): ?>
                            <optgroup label="<?php echo $daftar_dinas ?>">
                                <?php foreach($group_pengguna as $pengguna):?>
                                    <option value="<?php echo $pengguna->id_pengguna; ?>" <?php echo (termasuk_penerima($pengguna->id_pengguna,$penerima_otomatis)) ? "selected" : ""; ?>><?php echo $pengguna->nama_lengkap . ", " . $pengguna->nama_jabatan . " - " . $daftar_dinas; ?></option>
                                <?php endforeach;?>
                            </optgroup>
                        <?php endforeach; ?>
                    </select>
                </div>
                <div class="modal-footer">
                    <button type="submit" class="btn btn-success">Simpan</button>
                    <button type="button" class="btn btn-default" data-dismiss="modal">Tutup</button>
                </div>
            </div>

        </form>

    </div>
</div>

<script>
    $(document).ready(function(){
        $("#msg").froalaEditor({
            height: 300
        });
        $(".penerima").select2();
        $("#instruksi").select2({
            placeholder: "Pilih item",
            allowClear: true
        });
        $("#keamanan").select2({
            placeholder: "Pilih item",
            allowClear: true
        });
        $("#kecepatan").select2({
            placeholder: "Pilih item",
            allowClear: true
        })
        $("#tanggal").datepicker({
            format: "yyyy-mm-dd"
        });
        $("#attach").fileinput({'showUpload':false, 'previewFileType':'any'});
    })
</script>