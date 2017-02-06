
<div class="col-sm-9 col-sm-offset-3 col-lg-10 col-lg-offset-2 main">
    <div class="row">
        <ol class="breadcrumb">
            <li><a href="#"><svg class="glyph stroked home"><use xlink:href="#stroked-home"></use></svg></a></li>
            <li class="active">Dashboard</li>
        </ol>
    </div><!--/.row-->

    <div class="row">
        <div class="col-lg-12">
            <h1 class="page-header">Dashboard</h1>
        </div>
    </div><!--/.row-->

    <div class="row">
        <div class="col-xs-12 col-md-6 col-lg-3">
            <div class="panel panel-blue panel-widget ">
                <div class="row no-padding">
                    <div class="col-sm-3 col-lg-5 widget-left">
                        <svg class="glyph stroked blank document"><use xlink:href="#stroked-blank-document"></use></svg>
                    </div>
                    <div class="col-sm-9 col-lg-7 widget-right">
                        <div class="large"><?php echo $this->db->get("pesan")->num_rows(); ?></div>
                        <div class="text-muted">Surat Dibuat</div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-xs-12 col-md-6 col-lg-3">
            <div class="panel panel-teal panel-widget">
                <div class="row no-padding">
                    <div class="col-sm-3 col-lg-5 widget-left">
                        <svg class="glyph stroked male-user"><use xlink:href="#stroked-male-user"></use></svg>
                    </div>
                    <div class="col-sm-9 col-lg-7 widget-right">
                        <div class="large"><?php echo $this->db->get("pengguna")->num_rows(); ?></div>
                        <div class="text-muted">User Terdaftar</div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-xs-12 col-md-6 col-lg-3">
            <div class="panel panel-orange panel-widget">
                <div class="row no-padding">
                    <div class="col-sm-3 col-lg-5 widget-left">
                        <svg class="glyph stroked gear"><use xlink:href="#stroked-gear"></use></svg>
                    </div>
                    <div class="col-sm-9 col-lg-7 widget-right">
                        <div class="large"><?php echo $this->db->get("jabatan")->num_rows(); ?></div>
                        <div class="text-muted">Jabatan</div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-xs-12 col-md-6 col-lg-3">
            <div class="panel panel-red panel-widget">
                <div class="row no-padding">
                    <div class="col-sm-3 col-lg-5 widget-left">
                        <svg class="glyph stroked app-window-with-content"><use xlink:href="#stroked-app-window-with-content"></use></svg>
                    </div>
                    <div class="col-sm-9 col-lg-7 widget-right">
                        <div class="large"><?php echo $this->db->get("dinas")->num_rows(); ?></div>
                        <div class="text-muted">Dinas</div>
                    </div>
                </div>
            </div>
        </div>
    </div><!--/.row-->

    <hr>

    <div class="row">
        <div class="col-md-4">
            <div class="panel panel-default chat">
                <div class="panel-heading" id="accordion"><svg class="glyph stroked sound on"><use xlink:href="#stroked-sound-on"/></svg> Pemberitahuan</div>

                <div class="panel-body">
                    <ul>
<!--                        --><?php //for($i=0;$i<5;$i++): ?>
<!--                        <li class="clearfix">-->
<!--                            <div class="chat-body clearfix">-->
<!--                                <div class="header">-->
<!--                                    <strong class="primary-font">John Doe</strong> <small class="text-muted">32 mins ago</small>-->
<!--                                </div>-->
<!--                                <p>-->
<!--                                    Lorem ipsum dolor sit amet, consectetur adipiscing elit. Nulla ante turpis, rutrum ut ullamcorper sed, dapibus ac nunc. Vivamus luctus convallis mauris, eu gravida tortor aliquam ultricies.-->
<!--                                </p>-->
<!--                            </div>-->
<!--                        </li>-->
<!--                        --><?php //endfor; ?>
                    </ul>
                </div>

                <div class="panel-footer">
                </div>
            </div>
        </div>

        <div class="col-md-4">
            <div class="panel panel-blue">
                <div class="panel-heading dark-overlay"><svg class="glyph stroked clipboard-with-paper"><use xmlns:xlink="http://www.w3.org/1999/xlink" xlink:href="#stroked-clipboard-with-paper"></use></svg> Agenda Kerja</div>
                <div class="panel-body">
                    <ul class="todo-list" id="to_do_container" style="height: 266px; overflow-x: hidden;">
                    </ul>
                </div>
                <div class="panel-footer">
                    <div class="input-group">
                        <input id="deskripsi_baru" type="text" class="form-control input-md" placeholder="Tambah baru..">
                        <span class="input-group-btn">
								<button class="btn btn-primary btn-md" id="btn-todo">Tambah</button>
							</span>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-md-4">
            <div class="panel panel-red" style="height: 370px;">
                <div class="panel-heading dark-overlay"><svg class="glyph stroked calendar"><use xmlns:xlink="http://www.w3.org/1999/xlink" xlink:href="#stroked-calendar"></use></svg>Calendar</div>
                <div class="panel-body">
                    <div id="calendar" data-date="<?php echo date("m/d/Y"); ?>"></div>
                </div>
            </div>
        </div>

    </div>

<!--    <div class="row">-->
<!--        <div class="col-lg-12">-->
<!--            <div class="panel panel-default">-->
<!--                <div class="panel-heading">Grafik Pembuatan Surat</div>-->
<!--                <div class="panel-body">-->
<!--                    <div class="canvas-wrapper">-->
<!--                        <canvas class="main-chart" id="line-chart" height="200" width="600"></canvas>-->
<!--                    </div>-->
<!--                </div>-->
<!--            </div>-->
<!--        </div>-->
<!--    </div><!--/.row-->

</div>	<!--/.main-->

<script>

    BASE_URL = "http://eoffice.manadokota.go.id";

    function edit(str,id) {

        swal({
            title: "Edit Agenda",
            type: "input",
            showCancelButton: true
        },function(text) {
            if(text != false) {
                $.ajax({
                    method: "POST",
                    url: BASE_URL + "/ajax/edit_agenda/",
                    data: {
                        id_agenda: id,
                        deskripsi: text
                    },
                    success: function(response) {
                        ambil_agenda();
                    }
                });
            }
        });

        $(".sweet-alert input").val(str);

    }

    function hapus(id) {
        swal({
            title: "Hapus Agenda",
            type: "warning",
            showCancelButton: true,
            text: "Apa anda yakin ingin menghapus agenda ini?"
        },function(){
            $.ajax({
                method: "POST",
                url: BASE_URL + "/ajax/hapus_agenda/",
                data: {
                    id_agenda: id
                },
                success: function(response) {
                    ambil_agenda();
                }
            })
        });
    }

    function ambil_agenda() {
        $.ajax({
            method: "GET",
            url: BASE_URL + "/ajax/ambil_agenda",
            success: function(response) {

                content="";
                response.forEach(function(item){

                    var status = (item.selesai != 0) ? 'checked' : '';

                    content += "<li class=\"todo-list-item\">";
                    content += "                            <div class=\"checkbox\">";
                    content += "                                <input data-id=\"" + item.id_agenda + "\" type=\"checkbox\" id=\"checkbox" + item.id_agenda + "\" " + status + ">";
                    content += "                                <label data-id=\"" + item.id_agenda + "\" for=\"checkbox" + item.id_agenda + "\">" + item.deskripsi + "<\/label>";
                    content += "                            <\/div>";
                    content += "                            <div class=\"pull-right action-buttons\">";
                    content += "                                <a href=\"javascript:edit('" + item.deskripsi + "'," + item.id_agenda + ")\"><svg class=\"glyph stroked pencil\"><use xmlns:xlink=\"http:\/\/www.w3.org\/1999\/xlink\" xlink:href=\"#stroked-pencil\"><\/use><\/svg><\/a>";
                    content += "                                <a href=\"javascript:hapus(" + item.id_agenda + ")\" class=\"trash\"><svg class=\"glyph stroked trash\"><use xmlns:xlink=\"http:\/\/www.w3.org\/1999\/xlink\" xlink:href=\"#stroked-trash\"><\/use><\/svg><\/a>";
                    content += "                            <\/div>";
                    content += "                        <\/li>";

                });

                $("#to_do_container").html(content);

            }
        });
    }

    ambil_agenda();

    function check_selesai(id) {
        $.ajax({
            method: "POST",
            url: BASE_URL + "/ajax/check_selesai",
            data: { id_agenda: id }
        });
    }

    $("#btn-todo").on("click",function(){
        var deskripsi = $("#deskripsi_baru");

        $.ajax({
            method: "POST",
            url: BASE_URL + "/ajax/tambah_agenda",
            data: {
                deskripsi: deskripsi.val()
            },
            success: function(response) {
                console.log(response);
                if(response.status == "ok") {
                    ambil_agenda();
                    deskripsi.val("");
                }
            }
        });
    });

    $("#deskripsi_baru").on("keyup",function(ev){
        if(ev.keyCode == 13) {
            $("#btn-todo").trigger("click");
        }
    });

    $("#to_do_container").on("click",".checkbox input",function(){
        check_selesai($(this).data().id);
        ambil_agenda();
    });


</script>
