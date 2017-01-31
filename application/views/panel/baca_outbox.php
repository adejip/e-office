
<div class="col-sm-9 col-sm-offset-3 col-lg-10 col-lg-offset-2 main">
    <div class="row">
        <ol class="breadcrumb">
            <li><a href="#"><svg class="glyph stroked home"><use xlink:href="#stroked-home"></use></svg></a></li>
            <li><a href="<?php echo base_url("panel/outbox/"); ?>">Surat Terkirim</a></li>
            <li class="active"><?php echo $pesan->subjek; ?></li>
        </ol>
    </div><!--/.row-->

    <hr/>

    <div class="row">
        <div class="col-lg-12">
            <div class="panel panel-default">
                <div class="panel-heading">
                    Subjek : <?php echo $pesan->subjek; ?>
                </div>
                <div class="panel-body">
                    <p>Penerima</p>
                    <ul class="list-group">
                        <?php foreach($pesan->dikirim as $penerima): ?>
                        <li class="list-group-item"><?php echo $penerima->nama_lengkap; ?></li>
                        <?php endforeach;?>
                    </ul>
                    <?php echo $pesan->isi_pesan; ?>
                </div>
                <div class="panel-footer">
                    <?php
                    if($pesan->lampiran != null):
                        $lampiran = json_decode($pesan->lampiran);
                        ?>
                        <h4>Lampiran</h4>
                    <ul class="list-group">
                        <?php foreach($lampiran as $item):
                            $ext = explode(".",$item->file);
                            $cls = (is_doc(end($ext))) ? "attach-doc" : "attach-img";
                            ?>
                            <li class="list-group-item"><a href="<?php echo base_url("assets/uploads/lampiran/".$item->file); ?>" class="<?php echo $cls; ?>" data-judul="<?php echo $item->judul; ?>"><?php echo $item->judul; ?></a></li>
                        <?php endforeach; ?>
                    </ul>
                    <?php endif;?>
                </div>
            </div>
        </div>
    </div><!--/.row-->

</div>	<!--/.main-->

<script>
    $(document).ready(function(){
        $(".attach-img").magnificPopup({
            type: "image"
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
        })
    })
</script>