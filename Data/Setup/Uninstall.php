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

class Uninstall
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

            return $app['translator']->trans('Successfull uninstalled the extension %extension%.',
                array('%extension%' => 'HolidayHome'));
        } catch (\Exception $e) {
            throw new \Exception($e);
        }
    }
}
