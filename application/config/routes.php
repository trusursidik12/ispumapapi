<?php
defined('BASEPATH') OR exit('No direct script access allowed');

$route['api/get/aqm_data']			= 'api/aqmdata';
$route['api/get/aqm_ispu']			= 'api/aqmispu';
$route['api/post/aqm_data']			= 'aqm_post/index_post';

$route['default_controller']		= 'api';
$route['404_override']				= '';
$route['translate_uri_dashes']		= FALSE;
