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
        <h2 style="margin-top:0px">Kriteria_rating Read</h2>
        <table class="table">
	    <tr><td>Kriteria Id</td><td><?php echo $kriteria_id; ?></td></tr>
	    <tr><td>Rating Id</td><td><?php echo $rating_id; ?></td></tr>
	    <tr><td></td><td><a href="<?php echo site_url('kriteria_rating') ?>" class="btn btn-default">Cancel</a></td></tr>
	</table>
        </body>
</html>