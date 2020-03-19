API Request
	req : id_stasiun list
		?
	respon
		json: 001 => Cilegon, 002 => Merak ...
		
	req : params (param apa aja yg ada di stasiun X)
		?id_stasiun=???
	respon
		json : pm10,pm25,....
		
	req : realtime value 
		all param
			?id_stasiun=???
		some param
			?id_stasiun=???&param_id=???
	respon
		json:
			pm10[ug/m3]:xxx
			pm10[PPM]:xxx
			pm10[PPB]:xxx
			pm25:xxx
			
	req : ispu value 
		all param
			?id_stasiun=???
		some param
			?id_stasiun=???&param_id=???
	respon
		json:
			pm10[ug/m3]:xxx
			pm10[PPM]:xxx
			pm10[PPB]:xxx
			pm25:xxx
	
	req : kategori
		?id_stasiun
	respon
		json "baik","berbahaya",...
		
	req: most_danger_param
		?id_satsiun
	respon:
		json: "SO2" => 500
		
// get aqm_data : by id
	link = http://localhost/ispumapapi/api/aqmdata
	key = api_trusur_key : VHJ1c3VyVW5nZ3VsVGVrbnVzYV9wVA==
	authorization = username : admin, password : cHQudHJ1c3VydW5nZ3VsdGVrbnVzYQ==
	
// get aqm_ispu : by id
	link = http://localhost/ispumapapi/api/aqmispu
	key = api_trusur_key : VHJ1c3VyVW5nZ3VsVGVrbnVzYV9wVA==
	authorization = username : admin, password : cHQudHJ1c3VydW5nZ3VsdGVrbnVzYQ==
	
// get aqm_stasiun : by id
	link = http://localhost/ispumapapi/api/aqmstasiun
	key = api_trusur_key : VHJ1c3VyVW5nZ3VsVGVrbnVzYV9wVA==
	authorization = username : admin, password : cHQudHJ1c3VydW5nZ3VsdGVrbnVzYQ==
	
// get aqm_province : by provinsi
	link = http://localhost/ispumapapi/api/aqmprovince
	key = api_trusur_key : VHJ1c3VyVW5nZ3VsVGVrbnVzYV9wVA==
	authorization = username : admin, password : cHQudHJ1c3VydW5nZ3VsdGVrbnVzYQ==

// get aqm_province_list : by provinsi
	link = http://localhost/ispumapapi/api/aqmprovincelist
	key = api_trusur_key : VHJ1c3VyVW5nZ3VsVGVrbnVzYV9wVA==
	authorization = username : admin, password : cHQudHJ1c3VydW5nZ3VsdGVrbnVzYQ==
	
		
//query add table category
create table aqm_index
(
	id int not null primary key auto_increment,
	id_stasiun varchar(50) not null,
	worst_param varchar(15) not null,
	worst_value varchar(10) not null,
	province varchar(50) not null,
	xtimetamp timestamp not null
);

insert into `aqm_index1 (`id`, `id_stasiun`, `worst_param`, `worst_value`, `province`) VALUES
(1, 'PALANGKARAYA', 'so2', 200, 'Kalimantan Tengah'),
(2, 'PALEMBANG', 'so2', 200, 'Sumatera Selatan'),
(3, 'JAMBI', 'so2', 200, 'Jambi'),
(4, 'KALTARA', 'so2', 200, 'Kalimantan Utara'),
(5, 'PADANG', 'so2', 200, 'Sumatera Barat'),
(6, 'PEKANBARU', 'so2', 200, 'Riau'),
(7, 'PONTIANAK', 'so2', 200, 'Kalimantan Barat'),
(8, 'BANJARMASIN', 'so2', 200, 'Kalimantan Selatan'),
(9, 'JAKARTA', 'so2', 200, 'DKI Jakarta'),
(10, 'ACEH', 'so2', 200, 'NAD'),
	