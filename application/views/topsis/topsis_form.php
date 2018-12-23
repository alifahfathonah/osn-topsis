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
        <h2 style="margin-top:0px">Topsis <?php echo $button ?></h2>
        <form action="<?php echo $action; ?>" method="post">
	    <div class="form-group">
            <label for="int">Alternatif<?php echo form_error('alternatif_id') ?></label>
            <select class="form-control" name="alternatif_id" id="alternatif_id">
                <option value="">---option---</option>
            <?php
                foreach($alternatif as $alt){
            ?>
                <option value="<?= $alt->id ?>"><?= $alt->nama ?></option>
            <?php
                }
            ?>
            </select>
        </div>
	    
    <?php
        foreach($kriteria as $krt){
    ?>
        <div class = "row">
            <div class="col-md-6">
                <div class="form-group">            
                    <label for="int"><?= $krt->name ?></label>
                    <select class="form-control" name="kriteria_<?= $krt->kode ?>">
                        <option value="">---option---</option>
                        <?php   
                            $count = count($rating_val[$krt->id]['id']);
                            for ($i=0; $i < $count; $i++) { 
                            ?>
                                <option value="<?= $rating_val[$krt->id]['rating'][$i] ?>"><?= $rating_val[$krt->id]['keterangan'][$i] ?> (<?= $rating_val[$krt->id]['name'][$i] ?>) </option>
                            <?php
                            }
                        ?>
                    </select>
                </div>
            </div>
        </div>
    <?php
        }
    ?>

	    <input type="hidden" name="id" value="<?php echo $id; ?>" /> 
	    <button type="submit" class="btn btn-primary"><?php echo $button ?></button> 
	    <a href="<?php echo site_url('topsis') ?>" class="btn btn-default">Cancel</a>
	</form>
    </body>
</html>