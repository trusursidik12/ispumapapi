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
		
// get aqm_data :
	link = http://localhost/ispumapapi/api/aqmdata
	key = api_trusur_key : VHJ1c3VyVW5nZ3VsVGVrbnVzYV9wVA==
	authorization = username : admin, password : cHQudHJ1c3VydW5nZ3VsdGVrbnVzYQ==
	
// get aqm_ispu :
	link = http://localhost/ispumapapi/api/aqmispu
	key = api_trusur_key : VHJ1c3VyVW5nZ3VsVGVrbnVzYV9wVA==
	authorization = username : admin, password : cHQudHJ1c3VydW5nZ3VsdGVrbnVzYQ==
	
// get aqm_stasiun :
	link = http://localhost/ispumapapi/api/aqmstasiun
	key = api_trusur_key : VHJ1c3VyVW5nZ3VsVGVrbnVzYV9wVA==
	authorization = username : admin, password : cHQudHJ1c3VydW5nZ3VsdGVrbnVzYQ==
	
	
		
		
	