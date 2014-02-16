<?php

/**
 * HolidayHome
 *
 * @author Team phpManufaktur <team@phpmanufaktur.de>
 * @link https://addons.phpmanufaktur.de/flexContent
 * @copyright 2014 Ralf Hertsch <ralf.hertsch@phpmanufaktur.de>
 * @license MIT License (MIT) http://www.opensource.org/licenses/MIT
 */

namespace phpManufaktur\HolidayHome\Control\Admin;

use Silex\Application;
use phpManufaktur\HolidayHome\Control\Configuration;
use phpManufaktur\Basic\Control\Pattern\Alert;

class Admin extends Alert
{

    protected static $usage = null;
    protected static $usage_param = null;
    protected static $config = null;

    /**
     * Initialize the class with the needed parameters
     *
     * @param Application $app
     */
    protected function initialize(Application $app)
    {
        parent::initialize($app);

        $cms = $this->app['request']->get('usage');
        self::$usage = is_null($cms) ? 'framework' : $cms;
        self::$usage_param = (self::$usage != 'framework') ? '?usage='.self::$usage : '';
        // set the locale from the CMS locale
        if (self::$usage != 'framework') {
            $app['translator']->setLocale($this->app['session']->get('CMS_LOCALE', 'en'));
        }
        $Configuration = new Configuration($app);
        self::$config = $Configuration->getConfiguration();
    }

    /**
     * Get the toolbar for all backend dialogs
     *
     * @param string $active dialog
     * @return array
     */
    public function getToolbar($active) {
        $toolbar_array = array(
            'about' => array(
                'name' => 'about',
                'text' => 'About',
                'hint' => 'Information about HolidayHome',
                'link' => FRAMEWORK_URL.'/holidayhome/editor/about'.self::$usage_param,
                'active' => ($active == 'about')
                ),
        );

        return $toolbar_array;
    }

 }
