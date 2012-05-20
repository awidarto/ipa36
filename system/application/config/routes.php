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
| 	example.com/class/method/id/
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
| There are two reserved routes:
|
|	$route['default_controller'] = 'welcome';
|
| This route indicates which controller class should be loaded if the
| URI contains no data. In the above example, the "welcome" class
| would be loaded.
|
|	$route['scaffolding_trigger'] = 'scaffolding';
|
| This route lets you set a "secret" word that will trigger the
| scaffolding feature for added security. Note: Scaffolding must be
| enabled in the controller in which you intend to use it.   The reserved
| routes must come before any wildcard or regular expression routes.
|
*/

$route['default_controller'] = "statics/howto";
$route['scaffolding_trigger'] = "";

$route['admin'] = 'admin/home';

$route['expo/admin/exhibition/deletefile'] = 'expo/admin/exhibition/deletefile';
$route['expo/admin/exhibition/:any'] = 'expo/admin/exhibition';

$route['user/profile/update'] = 'register/user';

$route['media/admin/usermedia/deletefile'] = 'media/admin/usermedia/deletefile';
$route['media/admin/usermedia/:any'] = 'media/admin/usermedia';

$route['media/admin/convex/deletefile'] = 'media/admin/convex/deletefile';
$route['media/admin/convex/:any'] = 'media/admin/convex';

$route['media/admin/officials/delusr'] = 'media/admin/officials/delusr';
$route['media/admin/officials/:any'] = 'media/admin/officials';

$route['media/admin/visitors/delusr'] = 'media/admin/visitors/delusr';
$route['media/admin/visitors/:any'] = 'media/admin/visitors';

$route['media/admin/attendance/:any'] = 'media/admin/attendance';
$route['media/admin/attendanceoff/:any'] = 'media/admin/attendanceoff';
$route['media/admin/attendancevis/:any'] = 'media/admin/attendancevis';


$route['media/admin/convention/deletefile'] = 'media/admin/convention/deletefile';
$route['media/admin/convention/:any'] = 'media/admin/convention';

$route['media/admin/conventionsd/deletefile'] = 'media/admin/conventionsd/deletefile';
$route['media/admin/conventionsd/:any'] = 'media/admin/conventionsd';

$route['media/admin/conventionso/deletefile'] = 'media/admin/conventionso/deletefile';
$route['media/admin/conventionso/:any'] = 'media/admin/conventionso';

$route['media/admin/conventionpd/deletefile'] = 'media/admin/conventionpd/deletefile';
$route['media/admin/conventionpd/:any'] = 'media/admin/conventionpd';

$route['media/admin/conventionpo/deletefile'] = 'media/admin/conventionpo/deletefile';
$route['media/admin/conventionpo/:any'] = 'media/admin/conventionpo';

$route['media/admin/golf/deletefile'] = 'media/admin/golf/deletefile';
$route['media/admin/golf/:any'] = 'media/admin/golf';

$route['media/admin/judge/deletefile'] = 'media/admin/judge/deletefile';
$route['media/admin/judge/:any'] = 'media/admin/judge';

$route['media/admin/galadinner/deletefile'] = 'media/admin/galadinner/deletefile';
$route['media/admin/galadinner/:any'] = 'media/admin/galadinner';

$route['media/admin/shortcourses/deletefile'] = 'media/admin/shortcourses/deletefile';
$route['media/admin/shortcourses/:any'] = 'media/admin/shortcourses';

$route['media/admin/foc/deletefile'] = 'media/admin/foc/deletefile';
$route['media/admin/foc/:any'] = 'media/admin/foc';

$route['media/admin/mp/deletefile'] = 'media/admin/mp/deletefile';
$route['media/admin/mp/:any'] = 'media/admin/mp';

$route['media/admin/boothbuyer/deletefile'] = 'media/admin/boothbuyer/deletefile';
$route['media/admin/boothbuyer/:any'] = 'media/admin/boothbuyer';

$route['media/admin/outbox/deletefile'] = 'media/admin/outbox/deletefile';
$route['media/admin/outbox/doprint/(:num)'] = 'media/admin/outbox/doprint/$1';
$route['media/admin/outbox/:any'] = 'media/admin/outbox';

//

$route['company/admin/convention/deletefile'] = 'company/admin/convention/deletefile';
$route['company/admin/convention/:any'] = 'company/admin/convention';
$route['company/admin/conventionsd/deletefile'] = 'company/admin/conventionsd/deletefile';
$route['company/admin/conventionsd/:any'] = 'company/admin/conventionsd';
$route['company/admin/conventionso/deletefile'] = 'company/admin/conventionso/deletefile';
$route['company/admin/conventionso/:any'] = 'company/admin/conventionso';
$route['company/admin/conventionpd/deletefile'] = 'company/admin/conventionpd/deletefile';
$route['company/admin/conventionpd/:any'] = 'company/admin/conventionpd';
$route['company/admin/conventionpo/deletefile'] = 'company/admin/conventionpo/deletefile';
$route['company/admin/conventionpo/:any'] = 'company/admin/conventionpo';
$route['company/admin/golf/deletefile'] = 'company/admin/golf/deletefile';
$route['company/admin/golf/:any'] = 'company/admin/golf';
$route['company/admin/galadinner/deletefile'] = 'company/admin/galadinner/deletefile';
$route['company/admin/galadinner/:any'] = 'company/admin/galadinner';
$route['company/admin/shortcourses/deletefile'] = 'company/admin/shortcourses/deletefile';
$route['company/admin/shortcourses/:any'] = 'company/admin/shortcourses';
$route['company/admin/foc/deletefile'] = 'company/admin/foc/deletefile';
$route['company/admin/foc/:any'] = 'company/admin/foc';
$route['company/admin/mp/deletefile'] = 'company/admin/mp/deletefile';
$route['company/admin/mp/:any'] = 'company/admin/mp';
$route['company/admin/boothbuyer/deletefile'] = 'company/admin/boothbuyer/deletefile';
$route['company/admin/boothbuyer/:any'] = 'company/admin/boothbuyer';




/* End of file routes.php */
/* Location: ./system/application/config/routes.php */
