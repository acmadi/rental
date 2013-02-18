<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');

/*
|--------------------------------------------------------------------------
| File and Directory Modes
|--------------------------------------------------------------------------
|
| These prefs are used when checking and setting modes when working
| with the file system.  The defaults are fine on servers with proper
| security, but you may wish (or even need) to change the values in
| certain environments (Apache running a separate process for each
| user, PHP under CGI with Apache suEXEC, etc.).  Octal values should
| always be used to set the mode correctly.
|
*/
define('FILE_READ_MODE', 0644);
define('FILE_WRITE_MODE', 0666);
define('DIR_READ_MODE', 0755);
define('DIR_WRITE_MODE', 0777);

/*
|--------------------------------------------------------------------------
| File Stream Modes
|--------------------------------------------------------------------------
|
| These modes are used when working with fopen()/popen()
|
*/

define('FOPEN_READ',							'rb');
define('FOPEN_READ_WRITE',						'r+b');
define('FOPEN_WRITE_CREATE_DESTRUCTIVE',		'wb'); // truncates existing file data, use with care
define('FOPEN_READ_WRITE_CREATE_DESTRUCTIVE',	'w+b'); // truncates existing file data, use with care
define('FOPEN_WRITE_CREATE',					'ab');
define('FOPEN_READ_WRITE_CREATE',				'a+b');
define('FOPEN_WRITE_CREATE_STRICT',				'xb');
define('FOPEN_READ_WRITE_CREATE_STRICT',		'x+b');

define('SHA_SECRET',							'raHa5!4');
define('PAGE_COUNT',							15);
define('COMPANY_ID_SIMETRI',					2);

define('CAR_CONDITION',							'car_condition');
define('COMPANY',								'company');
define('COMPANY_USER',							'company_user');
define('CONFIG',								'config');
define('CUSTOMER',								'customer');
define('DEVICE',								'members');
define('DEVICE_COMPANY',						'device_company');
define('DRIVER',								'driver');
define('RENTAL',								'rental');
define('RENTAL_DETAIL',							'rental_detail');
define('RENTAL_STATUS',							'rental_status');
define('RESERVASI',								'reservasi');
define('RESERVASI_STATUS',						'reservasi_status');
define('ROSTER',								'roster');
define('SCHEDULE',								'schedule');
define('USER',									'users');


/* End of file constants.php */
/* Location: ./application/config/constants.php */