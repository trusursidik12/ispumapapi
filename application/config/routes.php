<?php
defined('BASEPATH') OR exit('No direct script access allowed');

// $route['api/get/aqm_data']			= 'api/aqmdata';
// $route['api/get/aqm_ispu']			= 'api/aqmispu';
// $route['api/post/aqm_data']			= 'aqm_post/index_post';

$route['api/post/aqmabout/data']	= 'about/index';
$route['api/put/aqmabout/data']		= 'about/index_put';
$route['api/delete/aqmabout/data']	= 'about/index_delete';

$route['api/post/aqmfaqs/data']		= 'faq/index';
$route['api/put/aqmfaqs/data']		= 'faq/index_put';
$route['api/delete/aqmfaqs/data']	= 'faq/index_delete';

$route['api/post/aqmnews/data']		= 'news/index';
$route['api/put/aqmnews/data']		= 'news/index_put';
$route['api/delete/aqmnews/data']	= 'news/index_delete';

$route['default_controller']		= 'api';
$route['404_override']				= '';
$route['translate_uri_dashes']		= FALSE;
