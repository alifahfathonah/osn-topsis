<!doctype html>
<html>
    <head>
        <title>harviacode.com - codeigniter crud generator</title>
        <link rel="stylesheet" href="<?php echo base_url('assets/bootstrap/css/bootstrap.min.css') ?>"/>
        <style>
            body{
                padding: 15px;
            }
        </style>
    </head>
    <body>
        <h2 style="margin-top:0px">Topsis List</h2>
        <div class="row" style="margin-bottom: 10px">
            <div class="col-md-4">
                <?php echo anchor(site_url('topsis/create'),'Create', 'class="btn btn-primary"'); ?>
            </div>
            <div class="col-md-4 text-center">
                <div style="margin-top: 8px" id="message">
                    <?php echo $this->session->userdata('message') <> '' ? $this->session->userdata('message') : ''; ?>
                </div>
            </div>            
        </div>
        <h1>Normalisasi</h1>
        <table class="table table-bordered" style="margin-bottom: 10px">
            <tr>
                <th>Alternatif</th>
                <?php
                    foreach ($kriteria as $key => $val) {
                ?>
                    <th><?php echo $val->kode ?></th>
                <?php
                    }
                ?>
            </tr>
            <?php
                foreach ($alternatif as $key => $val) {
            ?>
                <tr>
                    <td>
                        <?php echo $val->nama ?>
                    </td>
                    <?php
                        foreach ($topsis_data[$val->id] as $tp_data) {
                    ?>
                        <td>
                            <?php 
                                // echo $tp_data->nilai
                                // echo $r[$tp_data->kode][$val->id]  //ini R
                                
                             ?>
                        </td>
                    <?php
                        }
                    ?>
                </tr>
            <?php
                }
            ?>
        </table>
        <h1> Ranking Siswa</h1>
        <table class="table table-bordered" style="margin-bottom: 10px">
            <tr>
                <th>No</th>
                <th>Hasil</th>
            </tr>
            <?php
            $start = 0;
            foreach ($hasil as $key => $val) {
            ?>
                <tr>
                    <td width="80px"><?php echo ++$start ?></td>
                    <td><?php echo $val ?></td>
                    <!-- <td><?php echo $topsis->kriteria_id ?></td>
                    <td><?php echo $topsis->nilai ?></td>
                    <td style="text-align:center" width="200px">
                        <?php 
                        // echo anchor(site_url('topsis/read/'.$topsis->id),'Read'); 
                        // echo ' | '; 
                        // echo anchor(site_url('topsis/update/'.$topsis->id),'Update'); 
                        // echo ' | '; 
                        // echo anchor(site_url('topsis/delete/'.$topsis->id),'Delete','onclick="javasciprt: return confirm(\'Are You Sure ?\')"'); 
                        ?>
                    </td> -->
                </tr>
            <?php
            }
            ?>
        </table>
			<?php echo anchor(site_url(''), 'Back', 'class="btn btn-primary"'); ?>
	    </div>
        </div>
    </body>
</html>