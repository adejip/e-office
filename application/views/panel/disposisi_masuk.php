
<div class="col-sm-9 col-sm-offset-3 col-lg-10 col-lg-offset-2 main">
<div class="row">
    <ol class="breadcrumb">
        <li><a href="#"><svg class="glyph stroked home"><use xlink:href="#stroked-home"></use></svg></a></li>
        <li class="active">Disposisi Masuk</li>
    </ol>
</div><!--/.row--><br />

<div class="row" id="inbox-div">
    <div class="col-lg-12">
        <div class="panel panel-default">
            <div class="panel-heading">Disposisi Masuk</div>
            <div class="panel-body">
                <b><i class="fa fa-filter fa-lg"></i> Filter &nbsp;&nbsp;</b>
                <div class="btn-group">
                    <a href="?all" class="btn <?php echo (isset($_GET["all"])) ? "btn-success active" : "btn-primary"; ?>"><i class="fa fa-list fa-lg"></i> Semua</a>
                    <a href="?read" class="btn <?php echo (isset($_GET["read"])) ? "btn-success active" : "btn-primary"; ?>"><i class="fa fa-eye fa-lg"></i> Dibaca</a>
                    <a href="?unread" class="btn <?php echo (isset($_GET["unread"])) ? "btn-success active" : "btn-primary"; ?>"><i class="fa fa-eye-slash fa-lg"></i> Belum dibaca</a>
                    <div class="btn-group">
                        <a class="btn btn-primary dropdown-toggle" data-toggle="dropdown">
                            <i class="fa fa-bullhorn fa-lg"></i> Instruksi (<?php echo (isset($_GET["inst"]) && $_GET["inst"] != "") ? $_GET["inst"] : "Semua" ?>) <span class="caret"></span></a>
                        <ul class="dropdown-menu" role="menu">
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
                        <th data-field="starred">Star</th>
                        <th data-field="nama_lengkap"  data-sortable="true">Pengirim</></th>
                        <th data-field="waktu_kirim" data-sortable="true">Tanggal Kirim</th>
                        <th data-field="instruksi_disposisi"  data-sortable="true">Instruksi</></th>
                        <th data-field="selesai" data-sortable="true">Status</th>
                        <th>Pilihan</th>
                    </tr>
                    </thead>
                    <tbody>
                    <?php foreach($disposisi as $d): ?>
                        <tr class="<?php echo ($d->dibaca == 0) ? "warning" : ""; ?>">
                            <td><i data-toggle='tooltip' title='Tandai surat' class="fa fa-star fa-lg star <?php echo ($d->starred == 1) ? "star-active" : ""; ?>" data-starred="<?php echo $d->starred; ?>" data-id="<?php echo $d->id_relasi_disposisi; ?>"></i><span style="display: none;"><?php echo ($d->starred == 1) ? $d->id_relasi_disposisi : 0; ?></span></td>
                            <td><?php echo $d->nama_lengkap; ?></td>
                            <td><?php echo $d->waktu_kirim; ?></td>
                            <td><?php echo $d->instruksi_disposisi; ?></td>
                            <td>
                                <?php
                                if($d->pengguna_selesai == 0)
                                    echo "<b><i class='fa fa-times fa-lg fa-fw'></i> Belum selesai</b>";
                                else
                                    echo "<b><i class='fa fa-check fa-lg fa-fw'></i> Selesai</b>";
                                ?>
                            </td>
                            <td>
                                <a href="<?php echo base_url("panel/baca_disposisi_masuk/" . $d->id_disposisi . "/" . $d->kode_disposisi); ?>" class="btn btn-success">Baca</a>
                                <a href="#" class="btn btn-warning">Hapus</a>
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

<script>
    $(document).ready(function(){
        setTimeout(function() {
            $('[data-toggle="tooltip').tooltip();
        },1000);

        $("#inbox-div").on("click",".star.fa-star",function(){
            var curStar = $(this);
            update_star(curStar);
            curStar.removeClass("fa-star").addClass("fa-spinner fa-pulse");
        });
    });

    function update_star(curStar) {
        $.ajax({
            url: BASE_URL + "/ajax/update_star_disposisi/",
            method: "POST",
            data: {
                id_relasi_disposisi: curStar.data().id,
                starred: (curStar.data().starred == 1) ? 0 : 1
            },
            success: function(response){
                if(curStar.data().starred == 0) {
                    curStar.data("starred",1);
                    curStar.addClass("star-active");
                    curStar.parent().children("span").html(1)
                } else {
                    curStar.data("starred",0);
                    curStar.removeClass("star-active");
                    curStar.parent().children('span').html(0);
                }
                curStar.removeClass('fa-spinner fa-pulse');
                curStar.addClass("fa-star");
            }
        });
    }
</script>