<!DOCTYPE html>
<html>
<head>
	<title>News</title>

	<meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
    <link rel="stylesheet" href="https://unpkg.com/leaflet@1.5.1/dist/leaflet.css" integrity="sha512-xwE/Az9zrjBIphAcBb3F6JVqxf46+CDLwfLMHloNu6KEQCAWi6HcDUbeOfBIptF7tcCzusKFjFw2yuvEpDL9wQ==" crossorigin=""/>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.10.2/css/all.css"/>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/jqueryui/1.12.1/jquery-ui.min.css" />
    <link rel="stylesheet" href="fontawesome-free/css/all.min.css">
</head>
<body>
	<style>
	body {
	    padding: 0;
	    margin: 0;
	}
	html, body, #mapid {
	    height: 100%;
	}

	</style>
	<nav class="navbar-light bg-light sticky-top">
		<form class="">
			<div class="d-flex">
				<div class="mr-auto p-1" style="margin-left: 20px;">
					<img width="40" src="assets/icon/icon.png">
				</div>
				<div class="p-1">
					<input class="form-control" type="search" placeholder="Search" aria-label="Search">
				</div>
				<div class="p-1">
					<button class="btn btn-light" type="submit"><i class="fas fa-search"></i></button>
				</div>
			</div>
		</form>
	</nav>

	<div style="padding-bottom: 40px">
	<?php foreach($news as $newsdata) : ?>
		<div class="card m-2" data-toggle="modal" data-target="#news<?=$newsdata['id'];?>">
			<div class="d-flex">
				<div class="p-2 text-center">
					<img src="<?=$newsdata['image'];?>" width="100" height="100">
				</div>
				<div class="p-1">
					<div class="col">
						<b style="font-size: 12px;"><?=$newsdata['title'];?></b><hr style="margin-top: 5px; margin-bottom: 5px">
					</div>
					<div class="col text-justify" style="font-size: 10px">
						<p><?=$newsdata['short_content'];?></p>
					</div>
				</div>
			</div>
		</div>
	<?php endforeach ?>
	</div>
	
	<!-- The Modal -->
	<?php foreach($news as $newsdata) : ?>
	<div class="modal fade" id="news<?=$newsdata['id'];?>">
		<div class="modal-dialog modal-lg">
			<div class="modal-content">
				<!-- Modal Header -->
				<div class="modal-header">
					<div class="mr-auto" style="margin-left: 20px;">
						<img width="30" src="assets/icon/icon.png">
					</div>
					<h5 class="modal-title">ISPUMAP</h5>
					<button type="button" class="close" data-dismiss="modal">&times;</button>
				</div>
				<!-- Modal body -->
				<div class="modal-body">
					<h5 class="text-center"><?=$newsdata['title'];?></h5>
					<img src="<?=$newsdata['image'];?>" width="100%">
					<?=$newsdata['content'];?>
				</div>

			</div>
		</div>
	</div>
	<?php endforeach ?>
	<!-- end modal -->

    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
	<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.16.0/umd/popper.min.js"></script>
	<script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.4.1/js/bootstrap.min.js"></script>

</body>
</html>