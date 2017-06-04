
<div class="col-sm-9 col-sm-offset-3 col-lg-10 col-lg-offset-2 main">
    <div class="row">
        <ol class="breadcrumb">
            <li><a href="#"><svg class="glyph stroked home"><use xlink:href="#stroked-home"></use></svg></a></li>
            <li><a href="<?php echo base_url("panel/disposisi_masuk/"); ?>">Disposisi Masuk</a></li>
            <li class="active">Baca Disposisi</li>
        </ol>
    </div><!--/.row-->

    <hr/>

    <div class="row">
        <div class="col-lg-6" id="disposisi">
            <div class="panel panel-default">
                <?php if(isset($_GET["err"])): ?>
                    <div class="alert bg-danger" role="alert">
                        <svg class="glyph stroked cancel"><use xmlns:xlink="http://www.w3.org/1999/xlink" xlink:href="#stroked-cancel"></use></svg> Gagal mengirim respon! Coba lagi nanti <a href="#" class="pull-right"><span class="glyphicon glyphicon-remove"></span></a>
                    </div>
                <?php elseif(isset($_GET["succ"])):?>
                    <div class="alert bg-success" role="alert">
                        <svg class="glyph stroked checkmark"><use xmlns:xlink="http://www.w3.org/1999/xlink" xlink:href="#stroked-checkmark"></use></svg> Respon berhasil dikirim ke tujuan! <a href="#" class="pull-right"><span class="glyphicon glyphicon-remove"></span></a>
                    </div>
                <?php endif; ?>
                <div class="panel-heading">
                    <h5>Detail disposisi</h5>
                    <i style="float: right; display: block; margin-top: -27px;" data-toggle='tooltip' title='Tandai surat' class="fa fa-star fa-lg star <?php echo ($disposisi->penerima->starred == 1) ? "star-active" : ""; ?>" data-starred="<?php echo $disposisi->penerima->starred; ?>" data-id="<?php echo $disposisi->penerima->id_relasi_disposisi; ?>"></i>
                </div>
                <div class="panel-body">
                    <form action="" method="POST" enctype="multipart/form-data">
                    <table class="table table-responsive">
                        <tr>
                            <td><b>Pengirim</b></td>
                            <td><?php echo $disposisi->penerima->pengirim; ?></td>
                        </tr>
                        <tr>
                            <td><b>Tanggal Kirim</b></td>
                            <td><?php echo $disposisi->waktu_kirim; ?></td>
                        </tr>
                        <tr>
                            <td><b>Instruksi</b></td>
                            <td><?php echo $disposisi->instruksi_disposisi; ?></td>
                        </tr>
                        <tr>
                            <td><b>Tanggal Selesai</b></td>
                            <td><?php echo $disposisi->tanggal_selesai; ?></td>
                        </tr>
                        <tr>
                            <td><b>Keamanan</b></td>
                            <td><?php echo $disposisi->keamanan; ?></td>
                        </tr>
                        <tr>
                            <td><b>Kecepatan</b></td>
                            <td><?php echo $disposisi->kecepatan; ?></td>
                        </tr>
                        <tr>
                            <td><b>Isi disposisi</b></td>
                            <td id="isi_disposisi" style="text-align: justify;"><?php echo $disposisi->isi_disposisi; ?></td>
                        </tr>
                        <?php
                        $lampiran = $disposisi->lampiran;
                        if($lampiran != null):
                        $lampiran = json_decode($lampiran);
                        ?>
                        <tr>
                            <td><b>Lampiran</b></td>
                            <td>
                                <ol>
                                    <?php foreach($lampiran as $l):
                                        $cls = (is_doc($l->file)) ? "attach-doc" : "attach-img";
                                        ?>
                                        <a class="<?php echo $cls; ?>" href="<?php echo base_url("assets/uploads/lampiran/".$l->file); ?>" data-judul="<?php echo $l->judul; ?>"><li><?php echo $l->judul; ?></li></a>
                                    <?php endforeach;?>
                                </ol>
                            </td>
                        </tr>
                        <?php endif;?>
                        <tr>
                            <td><b>Follow Up</b></td>
                            <td>
                                <div id="followUp" style="max-height: 200px;overflow-x: scroll;">
                                    <?php
                                    if(empty($follow_up)):
                                        ?>
                                        <b>Belum ada follow-up untuk disposisi ini</b>
                                    <?php else:?>
                                        <ul style="list-style-position: inside; margin: 0; padding: 0; list-style-type: square">
                                            <?php foreach($follow_up as $fu):?>
                                                <?php if($fu->lampiran_follow_up == null): ?>
                                                    <li data-placement="left" data-toggle="tooltip" title="<?php echo $fu->waktu_kirim; ?>">
                                                        <b>[<?php echo ($fu->id_pengguna == $this->session->userdata("id_pengguna")) ? "Anda" : $fu->nama_lengkap; ?>]</b>
                                                        <?php echo $fu->isi_follow_up; ?>
                                                    </li>
                                                <?php else:?>
                                                    <li data-placement="left" data-toggle="tooltip" title="<?php echo $fu->waktu_kirim; ?>">
                                                        <a href="#" class="attach" data-file='<?php echo $fu->lampiran_follow_up; ?>'>
                                                            <b>[<?php echo ($fu->id_pengguna == $this->session->userdata("id_pengguna")) ? "Anda" : $fu->nama_lengkap; ?>] <i class="fa fa-paperclip fa-lg"></i> </b>
                                                            <?php echo $fu->isi_follow_up; ?>
                                                        </a>
                                                    </li>
                                                <?php endif;?>
                                            <?php endforeach;?>
                                        </ul>
                                    <?php endif;?>
                                </div>
                            </td>
                        </tr>
                        <?php if($disposisi->selesai != 1): ?>
                        <tr>
                            <td></td>
                            <td>
                                <hr />
                                <input type="hidden" name="pembuat" value="<?php echo $disposisi->penerima->dari_user; ?>">
                                <textarea name="isi_follow_up" class="form-control" placeholder="Ketik follow-up.." required></textarea>
                                <input type="file" name="lampiran_follow_up[]" id="attach" multiple>
                            </td>
                        </tr>
                        <tr>
                            <td></td>
                            <td><button class="btn btn-success" name="btnSubmit" type="submit"><i class="fa fa-send fa-lg fa-fw"></i> Kirim</button></td>
                        </tr>
                        <?php else: ?>
                        <tr style="text-align: center;color: #2ecc71;">
                            <td colspan="2"><i class="fa fa-check fa-lg"></i> Disposisi selesai</td>
                        </tr>
                        <?php endif; ?>
                    </table>
                    </form>
                </div>
            </div>
        </div>
        <div class="col-lg-6" id="surat">
            <div class="panel panel-default">
                <div class="panel-heading">
                    <h5>Lampiran surat terkait</h5>
                </div>
                <?php if($disposisi->lampiran_surat != null):?>
                <div class="panel-body">
                    <b>Subjek : <?php echo $disposisi->lampiran_surat->subjek; ?></b><br />
                    <i>Waktu kirim : <?php echo $disposisi->lampiran_surat->waktu_kirim; ?></i>
                    <p><?php echo $disposisi->lampiran_surat->isi_pesan; ?></p>

                    <?php
                    $lampiran = $disposisi->lampiran_surat->lampiran;
                    if($lampiran != null):
                    $lampiran = json_decode($lampiran);
                    ?>
                    <p>Lampiran:</p>
                    <ol>
                        <?php foreach($lampiran as $l):
                            $cls = (is_doc($l->file)) ? "attach-doc" : "attach-img";
                            ?>
                            <li><a class="<?php echo $cls; ?>" href="<?php echo base_url("assets/uploads/lampiran/".$l->file); ?>" data-judul="<?php echo $l->judul; ?>"><?php echo $l->judul; ?></a></li>
                        <?php endforeach;?>
                    </ol>
                    <?php endif; ?>
                </div>
                <div class="panel-footer">
                    <button onclick="$.print('#disposisi')" class="btn btn-primary"><i class="fa fa-print fa-lg fa-fw"></i> Print Lembar Disposisi</button>
                    <button onclick="$.print('#surat')" class="btn btn-success"><i class="fa fa-print fa-lg fa-fw"></i> Print Lampiran Surat</button>
                </div>
                <?php else:?>
                    <div class="panel-body">
                        <h3 style="color: #999999;text-align: center;">Tidak ada lampiran surat</h3>
                    </div>
                    <div class="panel-footer">

                    </div>
                <?php endif;?>
            </div>
        </div>
    </div><!--/.row-->

</div>	<!--/.main-->

<script>
    $(document).ready(function(){
        $(".attach-img").magnificPopup({
            type: "image"
        });

        setTimeout(function() {
            $('[data-toggle="tooltip').tooltip();
        },1000);

        $("#attach").fileinput({'showUpload':false});

        var followUpContainer = $("#followUp");
        var followUpContainerHeight = followUpContainer[0].scrollHeight;
        followUpContainer.scrollTop(followUpContainerHeight);

        $(".attach").on("click",function(ev){
            var data_file = $(this).data().file;
            var content = "<ol>";

            $.each(data_file,function(key,item){
                var cls = item.file.split(".").length;
                var tipe_gambar = ["jpg","png","jpeg","bmp","gif"];
                cls = ($.inArray(item.file.split(".")[cls-1],tipe_gambar) == -1) ? "attach-doc" : "attach-img";
                content += "" +
                    "<li><a class='"+cls+"' href='"+BASE_URL+"assets/uploads/lampiran/follow_up_disposisi/"+item.file+"'>"+item.judul+"</a></li>";
            });

            content += "</ol>";

            bootbox.alert({
                size: "normal",
                title: "Lampiran follow-up",
                message: content
            });


            $(".attach-img").magnificPopup({
                type: "image"
            });


            $('.attach-doc').on('click',function(){
                var pdf_link = $(this).attr('href');
                var title = $(this).data().judul;
                var iframe = '<div class="iframe-container"><iframe src="http://docs.google.com/gview?url='+pdf_link+'&embedded=true"></iframe></div>'
                $.createModal({
                    title: title,
                    message: iframe,
                    closeButton:true,
                    scrollable:false,
                    link: pdf_link
                });
                $("#myModal").css("z-index",2000);
                return false;
            });


            ev.preventDefault();
        });

        $("#isi_disposisi").shorten({
            moreText: "Selengkapnya",
            lessText: "Kecilkan",
            showChars: 300
        });

        $(function(){
            $('.attach-doc').on('click',function(){
                var pdf_link = $(this).attr('href');
                var title = $(this).data().judul;
                var iframe = '<div class="iframe-container"><iframe src="http://docs.google.com/gview?url='+pdf_link+'&embedded=true"></iframe></div>'
                $.createModal({
                    title: title,
                    message: iframe,
                    closeButton:true,
                    scrollable:false,
                    link: pdf_link
                });
                return false;
            });
        });

        $(".star.fa-star").on("click",function(){
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