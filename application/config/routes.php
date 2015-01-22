<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');
/*
| -------------------------------------------------------------------------
| URI ROUTING
| -------------------------------------------------------------------------
| This file lets you re-map URI requests to specific controller functions.
|
| Typically there is a one-to-one relationship between a URL string
| and its corresponding controller class/method. The segments in a
| URL normally follow this pattern:
|
|	example.com/class/method/id/
|
| In some instances, however, you may want to remap this relationship
| so that a different class/function is called than the one
| corresponding to the URL.
|
| Please see the user guide for complete details:
|
|	http://codeigniter.com/user_guide/general/routing.html
|
| -------------------------------------------------------------------------
| RESERVED ROUTES
| -------------------------------------------------------------------------
|
| There area two reserved routes:
|
|	$route['default_controller'] = 'welcome';
|
| This route indicates which controller class should be loaded if the
| URI contains no data. In the above example, the "welcome" class
| would be loaded.
|
|	$route['404_override'] = 'errors/page_missing';
|
| This route will tell the Router what URI segments to use if those provided
| in the URL cannot be matched to a valid route.
|
*/

$route['login'] = "homepage/login";
$route['default_controller'] = "homepage/login";
$route['404_override'] = '';
#$route['ortu'] = 'sos/siswa';
$route['ortu'] = 'siswa/mainsiswa';
$route['contentsekolah/(:any)'] = 'sos/sekolah/content/$1';
$route['profile/(:any)'] = 'sos/sekolah/detail_sekolah/$1';
$route['siswa'] = 'sos/siswa';
$route['admin'] = 'admin/login';
$route['sekolah'] = 'sos/sekolah';
$route['sekolah/get_kota'] = 'sos/sekolah/get_kota';
$route['sekolah/daftar_sekolah'] = 'sos/sekolah/daftar_sekolah';
$route['u/(:any)'] = 'akademik/shorturl/short/$1';
$route['editakun'] = 'sos/pegawai/edit_pegawai';
$route['editakunsiswa'] = 'sos/siswa/edit_siswa';


/* End of file routes.php */
/* Location: ./application/config/routes.php */