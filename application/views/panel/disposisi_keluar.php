
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
                                            echo "<p style='cursor: pointer;' onclick=\"swal('','$p->catatan_selesai','success')\" class='alert-success'><b>" . $key . " . $p->nama_lengkap <i class='fa fa-check fa-lg fa-fw'></i>" . "</b></p>";
                                        elseif($p->dibaca == 1)
                                            echo "<p style='background-color: rgba(52, 152, 219, 0.76); color: white;'><b>" . $key . " . $p->nama_lengkap <i class='fa fa-eye fa-lg fa-fw'></i></b></p> ";
                                        else
                                            echo "<p><b>" . $key . " . $p->nama_lengkap </b></p>";
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
