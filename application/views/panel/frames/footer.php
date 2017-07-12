
<div id="compose_email_container" class="tutup">
    <div id="compose_header">
        <i class="fa fa-envelope fa-lg"></i>&nbsp;&nbsp;Kirim Email Eksternal
    </div>
    <div id="compose_body">
        <form action="" method="post" id="email_form">
            <div id="pampele"></div>
            <div class="form-group">
                Pengirim [<a href="#">Ubah</a>]<input id="pengirim_email" name="pengirim" type="text" disabled="disabled" style="width: 85%;"/>
            </div>
            <div class="form-group">
                Penerima <input id="penerima_email" name="penerima" type="text" data-role="tagsinput">
            </div>
            <div class="form-group">
                Perihal <input type="subjek" name="subjek" style="border: none;">
            </div>
            <div class="form-group" style="padding: 0;">
                <textarea name="isi" id="isi_email" cols="30" rows="10"></textarea>
            </div>
            <div class="form-group">
                <button class="btn btn-primary" id="send_email" type="button"><i class="fa fa-send fa-lg"></i> Kirim</button> <b id="errors"><i class="fa fa-warning fa-lg"></i> Isi semua field</b>
            </div>
        </form>
    </div>
</div>

<script src="<?php echo base_url("assets/js/bootstrap.min.js");?>"></script>
<script src="<?php echo base_url("assets/js/chart.min.js");?>"></script>
<!--<script src="--><?php //echo base_url("assets/js/chart-data.js");?><!--"></script>-->
<script src="<?php echo base_url("assets/js/easypiechart.js");?>"></script>
<!--<script src="--><?php //echo base_url("assets/js/easypiechart-data.js");?><!--"></script>-->
<script src="<?php echo base_url("assets/js/bootstrap-datepicker.js");?>"></script>
<script src="<?php echo base_url("assets/js/bootstrap-table.js");?>"></script>
<script src="<?php echo base_url("assets/js/notif.js");?>"></script>
<script src="<?php echo base_url("assets/js/bootstrap-tagsinput.min.js");?>"></script>

<script src="<?php echo base_url("assets/js/email.js"); ?>"></script>

<script>

    $("#calendar").datepicker({});

    $("#isi_email").froalaEditor({
        height: 300,
        toolbarSticky: false
    });

    setTimeout(function(){
        $('[data-toggle="tooltip"]').tooltip();
    },1000);

    !function ($) {
        $(document).on("click","ul.nav li.parent > a > span.icon", function(){
            $(this).find('em:first').toggleClass("glyphicon-minus");
        });
        $(".sidebar span.icon").find('em:first').addClass("glyphicon-plus");
    }(window.jQuery);

    $(window).on('resize', function () {
        if ($(window).width() > 768) $('#sidebar-collapse').collapse('show')
    });
    $(window).on('resize', function () {
        if ($(window).width() <= 767) $('#sidebar-collapse').collapse('hide')
    });

    $(".glyphicon.glyphicon-remove").parent().on("click",function(){
        $(".alert").hide();
    });

    (function(a){a.createModal=function(b){defaults={title:"",message:"Your Message Goes Here!",closeButton:true,scrollable:false};var b=a.extend({},defaults,b);var c=(b.scrollable===true)?'style="max-height: 420px;overflow-y: auto;"':"";html='<div class="modal fade" id="myModal">';html+='<div class="modal-dialog">';html+='<div class="modal-content">';html+='<div class="modal-header">';html+='<button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>';if(b.title.length>0){html+='<h4 class="modal-title">'+b.title+"</h4>"}html+="</div>";html+='<div class="modal-body" '+c+">";html+=b.message;html+="</div>";html+='<div class="modal-footer">';if(b.closeButton===true){html+=' <a href="'+b.link+'" class="btn btn-success"><i class="fa fa-download fa-lg fa-fw"></i> Download</a><button type="button" class="btn btn-primary" data-dismiss="modal">Close</button>'}html+="</div>";html+="</div>";html+="</div>";html+="</div>";a("body").prepend(html);a("#myModal").modal().on("hidden.bs.modal",function(){a(this).remove()})}})(jQuery);


    $("#notifWrap").on("click",function(ev){
        ev.stopPropagation();
    });

    $("#pengaturan").on("click",function(){

        $.ajax({
            method: "GET",
            url: BASE_URL + "/ajax/ambil_data_pengguna",
            success: function(response){
                swal({
                    title: "Pengaturan",
                    text: "" +
                    "<form action='' method='POST' id='form_pengaturan'>" +
                    "   <b>&raquo; Username</b>" +
                    "   <input type='text' name='username' value='" + response.data.username + "'>" +
                    "   <b>&raquo; Password</b>" +
                    "   <input type='password' name='password' placeholder='Kosongkan jika tidak ingin merubah password'>" +
                    "   <b>&raquo; Input password lama (Wajib)</p>" +
                    "   <input type='password' name='cpassword'>" +
                    "</form>",
                    html: true,
                    showCancelButton: true,
                    closeOnConfirm: false,
                    showLoaderOnConfirm: true
                },function(){
                    var data = $("#form_pengaturan").serialize();
                    window.rt = false;
                    $.ajax({
                        url: BASE_URL + "/ajax/edit_data_pengguna",
                        method: "POST",
                        data: data,
                        success: function(response) {
                            if(response.statusCode === 1) {
                                swal.showInputError("Data tidak lengkap!");
                                window.rt = false;
                            } else if(response.statusCode == 2) {
                                swal.showInputError("Password lama tidak cocok!");
                                window.rt = false;
                            } else if(response.statusCode === 3) {
                                window.rt = true;
                                swal("Sukses!","Data berhasil diupdate!","success");
                            }
                        }
                    });
                    return window.rt;
                });


            }
        });
    })

</script>
</body>

</html>
