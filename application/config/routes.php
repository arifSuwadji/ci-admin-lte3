<?php
defined('BASEPATH') OR exit('No direct script access allowed');

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
|	https://codeigniter.com/user_guide/general/routing.html
|
| -------------------------------------------------------------------------
| RESERVED ROUTES
| -------------------------------------------------------------------------
|
| There are three reserved routes:
|
|	$route['default_controller'] = 'welcome';
|
| This route indicates which controller class should be loaded if the
| URI contains no data. In the above example, the "welcome" class
| would be loaded.
|
|	$route['404_override'] = 'errors/page_missing';
|
| This route will tell the Router which controller/method to use if those
| provided in the URL cannot be matched to a valid route.
|
|	$route['translate_uri_dashes'] = FALSE;
|
| This is not exactly a route, but allows you to automatically route
| controller and method names that contain dashes. '-' isn't a valid
| class or method name character, so it requires translation.
| When you set this option to TRUE, it will replace ALL dashes in the
| controller and method URI segments.
|
| Examples:	my-controller/index	-> my_controller/index
|		my-controller/my-method	-> my_controller/my_method
*/

/*****************web admin*********************/
$route['admin/updateHakAkses'] = 'admin/user/updateHakAkses';
$route['admin/hakAkses/(:num)'] = 'admin/user/hakAkses';
$route['admin/updatePassword'] = 'admin/user/updatePassword';
$route['admin/gantiPassword/(:num)'] = 'admin/user/gantiPassword';
$route['admin/hapusGrup'] = 'admin/user/hapusGrup';
$route['admin/updateGrup'] = 'admin/user/updateGrup';
$route['admin/editGrup/(:num)'] = 'admin/user/editGrup';
$route['admin/tambahGrupBaru'] = 'admin/user/tambahGrupBaru';
$route['admin/tambahGrup'] = 'admin/user/tambahGrup';
$route['admin/penggunaGrupJson'] = 'admin/user/dataGrupJson';
$route['admin/penggunaGrup'] = 'admin/user/grup';
$route['admin/excelPengguna'] = 'admin/user/excel';
$route['admin/pdfPengguna'] = 'admin/user/pdf';
$route['admin/hapusPengguna'] = 'admin/user/hapus';
$route['admin/updatePengguna'] = 'admin/user/update';
$route['admin/editPengguna/(:num)'] = 'admin/user/edit';
$route['admin/tambahPenggunaBaru'] = 'admin/user/tambahBaru';
$route['admin/tambahPengguna'] = 'admin/user/tambah';
$route['admin/penggunaJson'] = 'admin/user/dataJson';
$route['admin/pengguna'] = 'admin/user';
$route['admin/hapusMenu'] = 'admin/menu/hapus';
$route['admin/updateMenu'] = 'admin/menu/update';
$route['admin/editMenu/(:num)'] = 'admin/menu/edit';
$route['admin/tambahMenuBaru'] = 'admin/menu/tambahBaru';
$route['admin/tambahMenu'] = 'admin/menu/tambah';
$route['admin/menuJson'] = 'admin/menu/dataJson';
$route['admin/menu'] = 'admin/menu';
$route['admin/logout'] = 'admin/Logout';
$route['admin/login/action'] = 'admin/Login/action';
$route['admin/login'] = 'admin/Login';
$route['admin'] = 'AdminPages/view';

$route['default_controller'] = 'AdminPages/view';
$route['404_override'] = '';
$route['translate_uri_dashes'] = FALSE;
