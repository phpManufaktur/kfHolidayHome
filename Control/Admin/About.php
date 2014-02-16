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

use phpManufaktur\HolidayHome\Control\Admin\Admin;
use Silex\Application;

class About extends Admin {

    /**
     * Show the about dialog for HolidayHome
     *
     * @return string rendered dialog
     */
    public function Controller(Application $app)
    {
        $this->initialize($app);

        $extension = $this->app['utils']->readJSON(MANUFAKTUR_PATH.'/holidayhome/extension.json');

        return $this->app['twig']->render($this->app['utils']->getTemplateFile(
            '@phpManufaktur/HolidayHome/Template', 'admin/about.twig'),
            array(
                'usage' => self::$usage,
                'toolbar' => $this->getToolbar('about'),
                'extension' => $extension
            ));
    }

}
