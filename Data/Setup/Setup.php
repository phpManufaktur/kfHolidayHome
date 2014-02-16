<?php

/**
 * HolidayHome
 *
 * @author Team phpManufaktur <team@phpmanufaktur.de>
 * @link https://kit2.phpmanufaktur.de/flexContent
 * @copyright 2014 Ralf Hertsch <ralf.hertsch@phpmanufaktur.de>
 * @license MIT License (MIT) http://www.opensource.org/licenses/MIT
 */

namespace phpManufaktur\HolidayHome\Data\Setup;

use Silex\Application;
use phpManufaktur\Basic\Control\CMS\InstallAdminTool;

class Setup
{
    protected $app = null;

    /**
     * Execute all steps needed to setup HolidayHome
     *
     * @param Application $app
     * @throws \Exception
     */
    public function Controller(Application $app)
    {
        try {
            $this->app = $app;

            // setup kit_framework_holidayhome as Add-on in the CMS
            $admin_tool = new InstallAdminTool($app);
            $admin_tool->exec(MANUFAKTUR_PATH.'/HolidayHome/extension.json', '/holidayhome/cms');

            return $app['translator']->trans('Successfull installed the extension %extension%.',
                array('%extension%' => 'HolidayHome'));
        } catch (\Exception $e) {
            throw new \Exception($e);
        }
    }
}
