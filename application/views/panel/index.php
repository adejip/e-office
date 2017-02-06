
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
                    <div id="calendar"><div class="datepicker datepicker-inline"><div class="datepicker-days" style="display: block;"><table class=" table-condensed"><thead><tr><th class="prev" style="visibility: visible;">«</th><th colspan="5" class="datepicker-switch">February 2017</th><th class="next" style="visibility: visible;">»</th></tr><tr><th class="dow">Su</th><th class="dow">Mo</th><th class="dow">Tu</th><th class="dow">We</th><th class="dow">Th</th><th class="dow">Fr</th><th class="dow">Sa</th></tr></thead><tbody><tr><td class="old day">29</td><td class="old day">30</td><td class="old day">31</td><td class="day">1</td><td class="day">2</td><td class="day">3</td><td class="day">4</td></tr><tr><td class="day">5</td><td class="day">6</td><td class="day">7</td><td class="day">8</td><td class="day">9</td><td class="day">10</td><td class="day">11</td></tr><tr><td class="day">12</td><td class="day">13</td><td class="day">14</td><td class="day">15</td><td class="day">16</td><td class="day">17</td><td class="day">18</td></tr><tr><td class="day">19</td><td class="day">20</td><td class="day">21</td><td class="day">22</td><td class="day">23</td><td class="day">24</td><td class="day">25</td></tr><tr><td class="day">26</td><td class="day">27</td><td class="day">28</td><td class="new day">1</td><td class="new day">2</td><td class="new day">3</td><td class="new day">4</td></tr><tr><td class="new day">5</td><td class="new day">6</td><td class="new day">7</td><td class="new day">8</td><td class="new day">9</td><td class="new day">10</td><td class="new day">11</td></tr></tbody><tfoot><tr><th colspan="7" class="today" style="display: none;">Today</th></tr><tr><th colspan="7" class="clear" style="display: none;">Clear</th></tr></tfoot></table></div><div class="datepicker-months" style="display: none;"><table class="table-condensed"><thead><tr><th class="prev" style="visibility: visible;">«</th><th colspan="5" class="datepicker-switch">2017</th><th class="next" style="visibility: visible;">»</th></tr></thead><tbody><tr><td colspan="7"><span class="month">Jan</span><span class="month">Feb</span><span class="month">Mar</span><span class="month">Apr</span><span class="month">May</span><span class="month">Jun</span><span class="month">Jul</span><span class="month">Aug</span><span class="month">Sep</span><span class="month">Oct</span><span class="month">Nov</span><span class="month">Dec</span></td></tr></tbody><tfoot><tr><th colspan="7" class="today" style="display: none;">Today</th></tr><tr><th colspan="7" class="clear" style="display: none;">Clear</th></tr></tfoot></table></div><div class="datepicker-years" style="display: none;"><table class="table-condensed"><thead><tr><th class="prev" style="visibility: visible;">«</th><th colspan="5" class="datepicker-switch">2010-2019</th><th class="next" style="visibility: visible;">»</th></tr></thead><tbody><tr><td colspan="7"><span class="year old">2009</span><span class="year">2010</span><span class="year">2011</span><span class="year">2012</span><span class="year">2013</span><span class="year">2014</span><span class="year">2015</span><span class="year">2016</span><span class="year">2017</span><span class="year">2018</span><span class="year">2019</span><span class="year new">2020</span></td></tr></tbody><tfoot><tr><th colspan="7" class="today" style="display: none;">Today</th></tr><tr><th colspan="7" class="clear" style="display: none;">Clear</th></tr></tfoot></table></div></div></div>
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
