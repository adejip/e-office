
<div class="col-sm-9 col-sm-offset-3 col-lg-10 col-lg-offset-2 main">
<div class="row">
    <ol class="breadcrumb">
        <li><a href="#"><svg class="glyph stroked home"><use xlink:href="#stroked-home"></use></svg></a></li>
        <li class="active">Disposisi Keluar</li>
    </ol>
</div><!--/.row--><br />

<div class="row">
    <div class="col-lg-12">
        <div class="panel panel-default">
            <div class="panel-heading">Disposisi Keluar</div>
            <div class="panel-body">
                <b><i class="fa fa-filter fa-lg"></i> Filter &nbsp;&nbsp;</b>
                <div class="btn-group">
                    <a href="?all" class="btn <?php echo (isset($_GET["all"])) ? "btn-success active" : "btn-primary"; ?>"><i class="fa fa-list fa-lg"></i> Semua</a>
                    <div class="btn-group">
                        <a class="btn btn-primary dropdown-toggle" data-toggle="dropdown">
                            <i class="fa fa-bullhorn fa-lg"></i> Instruksi (<?php echo (isset($_GET["inst"]) && $_GET["inst"] != "") ? $_GET["inst"] : "Semua" ?>) <span class="caret"></span></a>
                        <ul class="dropdown-menu" role="menu">
                            <li><a href="?">Semua Instruksi</a></li>
                            <li><a href="?inst=Ditindak Lanjuti">Ditindak Lanjuti</a></li>
                            <li><a href="?inst=Ditanggapi Tertulis">Ditanggapi Tertulis</a></li>
                            <li><a href="?inst=Disiapkan makalah/sambutan/presentasi sesuai tema">Disiapkan makalah/sambutan/presentasi sesuai tema</a></li>
                            <li><a href="?inst=Koordinasikan dengan">Koordinasikan dengan</a></li>
                            <li><a href="?inst=Diwakili dan laporkan hasilnya">Diwakili dan laporkan hasilnya</a></li>
                            <li><a href="?inst=Dihadiri dan laporkan hasilkan">Dihadiri dan laporkan hasilkan</a></li>
                            <li><a href="?inst=Disiapkan surat/memo dinas internal">Disiapkan surat/memo dinas internal</a></li>
                            <li><a href="?inst=Arsip/File">Arsip/File</a></li>
                            <li><a href="?inst=Lain-lain">Lain-lain</a></li>
                            <li><a href="?inst=Diketahui">Diketahui</a></li>
                            <li><a href="?inst=Diperhatikan">Diperhatikan</a></li>
                            <li><a href="?inst=Diberi Penjelasan">Diberi Penjelasan</a></li>
                            <li><a href="?inst=Diwakili">Diwakili</a></li>
                            <li><a href="?inst=Dibicarakan dengan saya">Dibicarakan dengan saya</a></li>
                            <li><a href="?inst=Diproses sesuai ketentuan yang berlaku">Diproses sesuai ketentuan yang berlaku</a></li>
                            <li><a href="?inst=Dilaksanakan/Diselesaikan/Disempurnakan">Dilaksanakan/Diselesaikan/Disempurnakan</a></li>
                            <li><a href="?inst=Dijawab dengan surat">Dijawab dengan surat</a></li>
                            <li><a href="?inst=Disiapkan sambutan tertulis">Disiapkan sambutan tertulis</a></li>
                            <li><a href="?inst=Disiapkan atau saran-saran">Disiapkan atau saran-saran</a></li>
                        </ul>
                    </div>
                </div>
                <table data-toggle="table" data-url="<?php //echo base_url("panel/json_inbox");?>"  data-show-refresh="true" data-show-toggle="true" data-show-columns="true" data-search="true" data-select-item-name="toolbar1" data-pagination="true" data-sort-name="name" data-sort-order="desc">
                    <thead>
                    <tr>
                        <th data-field="instruksi_disposisi"  data-sortable="true">Instruksi</th>
                        <th data-field="penerima">Penerima</th>
                        <th data-field="waktu_kirim" data-sortable="true">Tanggal Kirim</th>
<!--                        <th data-field="tanggal_selesai"  data-sortable="true">Tanggal Selesai</th>-->
                        <!--<th data-field="selesai" data-sortable="true">Status</th>-->
                        <th>Pilihan</th>
                    </tr>
                    </thead>
                    <tbody>
                    <?php foreach($disposisi as $d): ?>
                        <tr>
                            <td><?php echo $d->instruksi_disposisi; ?></td>
                            <td>
                                <?php
                                    foreach($d->penerima as $key=>$p):
                                        $key += 1;
                                        if ($p->selesai_ditangani == 1)
                                            echo "<p data-toggle='tooltip' data-placement='left' title='Direspon (Klik untuk melihat respon)' style='padding: 5px;cursor: pointer;' onclick=\"swal('','$p->catatan_selesai','success')\" class='alert-success'><b>" . $key . " . $p->nama_lengkap <i class='fa fa-check fa-lg fa-fw'></i>" . "</b></p>";
                                        elseif($p->dibaca == 1)
                                            echo "<p data-toggle='tooltip' data-placement='left' title='Dibaca' style='padding: 5px;background-color: rgba(52, 152, 219, 0.76); color: white;'><b>" . $key . " . $p->nama_lengkap <i class='fa fa-eye fa-lg fa-fw'></i></b></p> ";
                                        else
                                            echo "<p data-toggle='tooltip' data-placement='left' title='Terkirim' style='padding: 5px;background-color: rgba(241, 196, 15,.76); color: white;'><b>" . $key . " . $p->nama_lengkap </b></p>";
                                    endforeach;
                                ?>
                            </td>
                            <td><?php echo $d->waktu_kirim; ?></td>
<!--                            <td>--><?php //echo $d->tanggal_selesai; ?><!--</td>-->
                            <!--<td>
                                <?php
//                                if($d->selesai == 0)
//                                    echo "<b class='btn btn-danger'><i class='fa fa-times fa-lg fa-fw'></i> Belum selesai</b>";
//                                else
//                                    echo "<b class='btn btn-success'><i class='fa fa-plus fa-lg fa-fw'></i> Selesai</b>";
                                ?>
                            </td>-->
                            <td>
                                <a href="<?php echo base_url("panel/baca_disposisi_keluar/" . $d->id_disposisi . "/" . $d->kode_disposisi); ?>" class="btn btn-success">Baca</a>
<!--                                <a href="#" class="btn btn-warning">Hapus</a>-->
                            </td>
                        </tr>
                    <?php endforeach; ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div><!--/.row-->

</div><!--/.main-->
