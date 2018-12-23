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
        <h2 style="margin-top:0px">Kriteria_rating <?php echo $button ?></h2>
        <form action="<?php echo $action; ?>" method="post">
	    <div class="form-group">
            <label for="int">Kriteria Id <?php echo form_error('kriteria_id') ?></label>
            <input type="text" class="form-control" name="kriteria_id" id="kriteria_id" placeholder="Kriteria Id" value="<?php echo $kriteria_id; ?>" />
        </div>
	    <div class="form-group">
            <label for="int">Rating Id <?php echo form_error('rating_id') ?></label>
            <input type="text" class="form-control" name="rating_id" id="rating_id" placeholder="Rating Id" value="<?php echo $rating_id; ?>" />
        </div>
	    <input type="hidden" name="id" value="<?php echo $id; ?>" /> 
	    <button type="submit" class="btn btn-primary"><?php echo $button ?></button> 
	    <a href="<?php echo site_url('kriteria_rating') ?>" class="btn btn-default">Cancel</a>
	</form>
    </body>
</html>