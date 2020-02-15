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
$route['default_controller'] = 'welcome';
$route['404_override'] = '';
$route['translate_uri_dashes'] = FALSE;

$route['adminLogin'] = 'admin/adminLogin';
$route['validate'] = 'admin/adminLogin/validate';
$route['admin'] = 'admin/AdminController';
$route['cases'] = 'admin/AdminController/cases';
$route['rules'] = 'admin/AdminController/rules';
$route['deadline'] = 'admin/AdminController/deadline';
$route['users'] = 'admin/AdminController/users';
$route['adminSettings'] = 'admin/AdminController/adminSettings';
$route['adminLogout'] = 'admin/AdminLogin/logout';
$route['adduser'] = 'admin/AdminController/adduser';

$route['addCase'] = 'user/MainController/addCase';
$route['AddNewCase'] = 'admin/AdminController/cases';
$route['editCase'] = 'user/MainController/editCase';
$route['deleteSelectedCases'] = 'user/MainController/deleteSelectedCases';
$route['deleteSelectedRules'] = 'admin/AdminController/deleteSelectedRules';
$route['deleteSelectedUserRules'] = 'user/MainController/deleteSelectedUserRules';
$route['addRule'] = 'admin/AdminController/addRule';
$route['addUserRule'] = 'user/MainController/addUserRule';
$route['editDeadline'] = 'admin/AdminController/editDeadline';
$route['editUserDeadline'] = 'user/MainController/editUserDeadline';
$route['addDeadline'] = 'admin/AdminController/addDeadline';
$route['addUserDeadline'] = 'user/MainController/addUserDeadline';
$route['editRule'] = 'admin/AdminController/editRule';
$route['editUserRule'] = 'user/MainController/editUserRule';
$route['changeAdminCredentials'] = 'admin/AdminController/changeAdminCredentials';
$route['recoverAdminPassword'] = 'admin/AdminLogin/recoverAdminPassword';
$route['adminRecoverPasswordSendEmail'] = 'admin/AdminLogin/adminRecoverPasswordSendEmail';

$route['populatedRules'] = 'user/MainController/populatedRules';
$route['userRules'] = 'user/MainController/userRules';
$route['populatedCase'] = 'user/MainController/populatedCase';
$route['signupUser'] = 'user/UserController/signupUser';
$route['loginUser'] = 'user/UserController/loginUser';
$route['registerUser'] = 'user/UserController/registerUser';
$route['home'] = 'user/MainController';
$route['validateUser'] = 'user/UserController/validateUser';
$route['userLogout'] = 'user/UserController/userLogout';
$route['recoverPassword'] = 'user/UserController/recoverPassword';
$route['recoverPasswordSendEmail'] = 'user/UserController/recoverPasswordSendEmail';
$route['newPassword'] = 'user/UserController/newPassword';
$route['setNewPassword'] = 'user/UserController/setNewPassword';
$route['userCases'] = 'user/MainController/userCases';
$route['listedRules'] = 'user/MainController/listedRules';
$route['saveCase'] = 'user/MainController/saveCase';
$route['userProfile'] = 'user/UserProfile';



$route['setAdminNewPassword'] = 'admin/AdminLogin/setAdminNewPassword';
$route['newAdminPassword'] = 'admin/AdminLogin/newAdminPassword';