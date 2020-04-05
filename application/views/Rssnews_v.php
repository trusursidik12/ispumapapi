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
		<div class="card m-2" data-toggle="modal" data-target="#news1">
			<div class="d-flex">
				<div class="p-2 text-center">
					<img src="assets/news/karhutla.jpeg" width="100" height="100">
				</div>
				<div class="p-1">
					<div class="col">
						<b style="font-size: 12px;">Titik Api di Sumsel-Riau Bertambah, Kualitas Udara Berbahaya!</b><hr style="margin-top: 5px; margin-bottom: 5px">
					</div>
					<div class="col text-justify" style="font-size: 10px">
						<p>&nbsp;&nbsp;&nbsp;&nbsp;Kebakaran hutan dan lahan (karhutla) di sejumlah wilayah di Pulau Sumatera makin menjadi-jadi. Titik api di sejumlah wilayah bertambah. ..</p>
					</div>
				</div>
			</div>
		</div>
		<div class="card m-2" data-toggle="modal" data-target="#news2">
			<div class="d-flex">
				<div class="p-2 text-center">
					<img src="assets/news/karhutla2.jpeg" width="100" height="100">
				</div>
				<div class="p-1">
					<div class="col">
						<b style="font-size: 12px;">Karhutla Belum Padam, Udara di Kalteng-Kalbar-Riau Berbahaya!</b><hr style="margin-top: 5px; margin-bottom: 5px">
					</div>
					<div class="col text-justify" style="font-size: 10px">
						<p>&nbsp;&nbsp;&nbsp;&nbsp;Kebakaran hutan dan lahan (karhutla) yang terjadi pada sejumlah wilayah di Indonesia belum juga padam. Efeknya, ..</p>
					</div>
				</div>
			</div>
		</div>
		<div class="card m-2" data-toggle="modal" data-target="#news3">
			<div class="d-flex">
				<div class="p-2 text-center">
					<img src="assets/news/udara.jpeg" width="100" height="100">
				</div>
				<div class="p-1">
					<div class="col">
						<b style="font-size: 12px;">Minggu Pagi, Kualitas Udara Jakarta Terburuk di Dunia</b><hr style="margin-top: 5px; margin-bottom: 5px">
					</div>
					<div class="col text-justify" style="font-size: 10px">
						<p>&nbsp;&nbsp;&nbsp;&nbsp;Jakarta kembali menempati posisi pertama kota paling berpolusi di dunia versi AirVisual hari ini. ..</p>
					</div>
				</div>
			</div>
		</div>
	</div>
	<!-- The Modal -->
	<div class="modal fade" id="news1">
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
					<h5 class="text-center">Titik Api di Sumsel-Riau Bertambah, Kualitas Udara Berbahaya!</h5>
					<img src="assets/news/karhutla.jpeg" width="100%">
					<p>&nbsp;&nbsp;&nbsp;&nbsp;Kebakaran hutan dan lahan (karhutla) di sejumlah wilayah di Pulau Sumatera makin menjadi-jadi. Titik api di sejumlah wilayah bertambah.</p>
					<p>Berdasarkan data dari Badan Nasional Penanggulangan Bencana (BNPB) pada Jumat (20/9/2019) pukul 09.00 WIB, jumlah titik api di Sumatera Selatan (Sumsel) mencapai 532 titik. Padahal pada Kamis (19/9) pukul 16.00 WIB, titik api berjumlah 194 titik.</p>
					<p>Selain di Sumsel, titik api bertambah di Jambi, dari sebelumnya 105 titik menjadi 695 titik api. Titik panas karhutla di Riau yang pada Kamis (19/9) berjumlah 14 titik kini bertambah menjadi 187 titik.</p>
					<p>Kualitas udara di ketiga wilayah itu pun dinyatakan tak sehat karena kabut asap yang timbul. Bahkan kualitas udara di Sumsel dikategorikan berbahaya.</p>
					<p>Bukan cuma di Pulau Sumatera, karhutla di Kalimantan juga masih terjadi. Di Kalimantan Barat, misalnya, yang kemarin terdapat 1.150 titik api, jumlahnya bertambah hari ini menjadi 1.384 titik api dan membuat udara tidak sehat.</p>
					<p>Titik panas di Kalimantan Tengah (Kalteng) berjumlah 1.443 titik dan membuat udara berbahaya. Karhutla juga terjadi di Kalimantan Selatan dengan jumlah titik api 169 titik.</p>
					<p>Secara total, ada 5.086 titik panas yang terdapat di Indonesia hari ini. Luas lahan yang terbakar mencapai 328 ribu hektare sejak Januari hingga Agustus 2019.</p>
					<p>Pemerintah juga terus melakukan upaya pemadaman. Ada 270 juta liter air yang digunakan untuk water bombing dari 34 unit helikopter yang dikerahkan. | sumber detik.com</p>
				</div>

			</div>
		</div>
	</div>
	<!-- end modal -->
	<!-- The Modal -->
	<div class="modal fade" id="news2">
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
					<h5 class="text-center">Karhutla Belum Padam, Udara di Kalteng-Kalbar-Riau Berbahaya!</h5>
					<img src="assets/news/karhutla2.jpeg" width="100%">
					<p>&nbsp;&nbsp;&nbsp;&nbsp;Kebakaran hutan dan lahan (karhutla) yang terjadi pada sejumlah wilayah di Indonesia belum juga padam. Efeknya, kualitas udara di provinsi yang mengalami karhutla tersebut menjadi berbahaya.</p>
					<p>Berdasarkan data dari BNPB, Rabu (18/9/2019) pukul 09.00 WIB, kualitas udara berbahaya itu berada terjadi di Kalimantan Tengah (Kalteng), Kalimantan Barat (Kalbar), dan Riau.</p>
					<p>Menurut data BNPB, ada 281 titik api di Kalteng. Hal itu membuat kualitas udara Kalteng berada di angkat 460 alias berbahaya. Selain Kalteng, titik api berada di Kalbar dengan jumlah 346 titik, yang turut membuat udara di provinsi itu berbahaya.</p>
					<p>Karhutla dan kualitas udara berbahaya juga masih terjadi di Riau dengan jumlah titik api 388 titik. Jambi, Sumatera Selatan, dan Kalimantan Selatan juga mengalami karhutla yang membuat kualitas udara di provinsi tersebut berada di kategori sedang hingga tidak sehat.</p>
					<p>Secara total, terdapat 2.719 titik api yang tersebar di seluruh Indonesia. Upaya pemadaman juga terus dilakukan dengan mengerahkan 44 helikopter dan 9.072 personel yang tersebar di berbagai wilayah. | sumber detik.com</p>
				</div>

			</div>
		</div>
	</div>
	<!-- end modal -->
	<!-- The Modal -->
	<div class="modal fade" id="news3">
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
					<h5 class="text-center">Minggu Pagi, Kualitas Udara Jakarta Terburuk di Dunia</h5>
					<img src="assets/news/udara.jpeg" width="100%">
					<p>&nbsp;&nbsp;&nbsp;&nbsp;Jakarta kembali menempati posisi pertama kota paling berpolusi di dunia versi AirVisual hari ini. Tingkat polusi udara di Jakarta di bawah kota Kabul, Afghanistan dan Krasnoyarsk, Rusia.</p>
					<p>Berdasarkan data dari AirVisual Minggu, (18/8/2019), pukul 09.05 WIB, Air Quality Index (AQI) Jakarta berada di 172 alias kategori tidak sehat. Namun, tingkat polusi ini tidak tetap dan dapat berubah sewaktu-waktu.</p>
					<p>Air Quality Index (AQI) merupakan indeks yang digunakan AirVisual untuk menggambarkan tingkat polusi udara di suatu daerah. AQI dihitung berdasarkan enam jenis polutan utama, yaitu PM 2,5, PM 10, karbon monoksida, asam belerang, nitrogen dioksida, dan ozon permukaan tanah.</p>
					<p>Berdasarkan data AirVisual, kandungan PM2.5 di Jakarta berada di angka 89,1 µg/m³. Data itu diperoleh dari alat pemantau udara Airvisual yang ada di Kedutaan Amerika Serikat, Pegadungan, Kemayoran, Pejanten Barat, Rawamangun, dan Mangga Dua.</p>
					<p>AQI mempunyai rentang nilai antara 0-500. Makin tinggi nilai AQI, artinya makin tinggi tingkat polusi udara di wilayah tersebut.</p>
					<p>Skor 0-5 berarti kualitas udara bagus, 51-100 berarti moderat, 101-150 tidak sehat bagi orang yang sensitif, 151-200 tidak sehat, 201-300 sangat tidak sehat, dan 301-500 ke atas berarti berbahaya.</p>
					<p>Terkait polusi udara ini, Pemprov DKI Jakarta sudah membuat sejumlah langkah untuk mengurangi polusi udara ibu kota. Langkah tersebut tertera dalam Instruksi Gubernur Nomor 66 Tahun 2019 tentang Pengendalian Kualitas Udara. | sumber detik.com</p>
				</div>

			</div>
		</div>
	</div>
	<!-- end modal -->

    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
	<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.16.0/umd/popper.min.js"></script>
	<script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.4.1/js/bootstrap.min.js"></script>

</body>
</html>