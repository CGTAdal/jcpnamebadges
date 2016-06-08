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

/*
 * user define 
 */
define('DEFAULT_BADGES_PRICE','2.75');	/// Handling charge per order
define('HANDLING_CHARGE_PER_ORDER','4.25');	/// Handling charge per order
define('ACCESSORIES_EXT_PRICE', '7.50');	/// Adhesive Charm Extender/pack of 5
define('ACCESSORIES_BAR_PRICE', '9.75');	/// Salon Magnetic Charm Bar/pack of 5
define('EXTRA_MAGNETS_PRICE', '7.50');		/// Magnets/pack of 5
define('EXTRA_PINS_PRICE', '5.00');			/// Pins/pack of 5
define('EACH_CHARM_PRICE', '6.50');			/// each pack of Charm price

define('BADGES_NET_PRICE', '1.96');			 /// each bages net price
define('CHARMS_NET_PRICE', '3.70');			 /// each charms net price
define('ACCESSORIES_EXT_NET_PRICE', '5.00'); /// each accessories Extender net price
define('ACCESSORIES_BAR_NET_PRICE', '6.35'); /// each accessories Bar net price
define('EXTRA_MAGNETS_NET_PRICE', '5.00');		 /// each Magnets net price
define('EXTRA_PINS_NET_PRICE', '3.50');		 /// each Pins net price
define('SELECTED_STORE_NO', '9900');		 /// Store no. for change add & Aor no.

/* End of file constants.php */
/* Location: ./application/config/constants.php */