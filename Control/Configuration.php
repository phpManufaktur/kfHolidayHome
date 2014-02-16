<?php

/**
 * HolidayHome
 *
 * @author Team phpManufaktur <team@phpmanufaktur.de>
 * @link https://kit2.phpmanufaktur.de/event
 * @copyright 2014 Ralf Hertsch <ralf.hertsch@phpmanufaktur.de>
 * @license MIT License (MIT) http://www.opensource.org/licenses/MIT
 */

namespace phpManufaktur\HolidayHome\Control;

use Silex\Application;
use phpManufaktur\Basic\Data\CMS\Settings;

class Configuration
{
    protected $app = null;
    protected static $config = null;
    protected static $config_path = null;

    /**
     * Constructor
     *
     * @param Application $app
     */
    public function __construct(Application $app)
    {
        $this->app = $app;
        self::$config_path = MANUFAKTUR_PATH.'/HolidayHome/config.flexcontent.json';
        $this->readConfiguration();
    }

    /**
     * Return the default configuration array for HolidayHome
     *
     * @return array
     */
    public function getDefaultConfigArray()
    {
        $cmsSettings = new Settings($this->app);
        $default_language = $cmsSettings->getSetting('default_language');

        return array(

        );
    }

    /**
     * Read the configuration file
     */
    protected function readConfiguration()
    {
        if (!file_exists(self::$config_path)) {
            self::$config = $this->getDefaultConfigArray();
            $this->saveConfiguration();
        }
        self::$config = $this->app['utils']->readConfiguration(self::$config_path);
    }

    /**
     * Save the configuration file
     */
    public function saveConfiguration()
    {
        // write the formatted config file to the path
        file_put_contents(self::$config_path, $this->app['utils']->JSONFormat(self::$config));
        $this->app['monolog']->addDebug('Save configuration to '.basename(self::$config_path));
    }

    /**
     * Get the configuration array
     *
     * @return array
     */
    public function getConfiguration()
    {
        return self::$config;
    }

    /**
     * Set the configuration array
     *
     * @param array $config
     */
    public function setConfiguration($config)
    {
        self::$config = $config;
    }

}
