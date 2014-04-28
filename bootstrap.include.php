<?php

/**
 * HilidayHome
 *
 * @author Team phpManufaktur <team@phpmanufaktur.de>
 * @link https://kit2.phpmanufaktur.de/flexContent
 * @copyright 2014 Ralf Hertsch <ralf.hertsch@phpmanufaktur.de>
 * @license MIT License (MIT) http://www.opensource.org/licenses/MIT
 */

use phpManufaktur\Basic\Control\CMS\EmbeddedAdministration;

// not really needed but make error control more easy ...
global $app;

// grant the ROLE hierarchy for the HolidayHome ROLES
$roles = $app['security.role_hierarchy'];
if (!in_array('ROLE_HOLIDAYHOME_ADMIN', $roles)) {
    $roles['ROLE_ADMIN'][] = 'ROLE_HOLIDAYHOME_ADMIN';
    $roles['ROLE_HOLIDAYHOME_ADMIN'][] = 'ROLE_HOLIDAYHOME_EDITOR';
    $app['security.role_hierarchy'] = $roles;
}

// add a protected area and access rules
$access_rules = $app['security.access_rules'];
if (!in_array('^/holidayhome/editor', $access_rules)) {
    $access_rules[] = array('^/holidayhome/editor', 'ROLE_HOLIDAYHOME_EDITOR');
    $app['security.access_rules'] = $access_rules;
}

// add a access point for HolidayHome
$entry_points = $app['security.role_entry_points'];
if (!in_array('ROLE_HOLIDAYHOME_EDITOR', $entry_points)) {
    $entry_points['ROLE_HOLIDAYHOME_EDITOR'] = array(
        array(
            'route' => '/holidayhome/editor',
            'name' => 'HolidayHome',
            'info' => 'Administrate Holiday Homes',
            'icon' => array(
                'path' => '/extension/phpmanufaktur/phpManufaktur/HolidayHome/extension.jpg',
                'url' => MANUFAKTUR_URL.'/HolidayHome/extension.jpg'
            )
        )
    );
    $app['security.role_entry_points'] = $entry_points;
}

// add all ROLES provided and used by HolidayHome
$roles = array(
    'ROLE_HOLIDAYHOME_ADMIN',
    'ROLE_HOLIDAYHOME_EDITOR'
);
$roles_provided = $app['security.roles_provided'];
if (!in_array($roles, $roles_provided)) {
    foreach ($roles as $role) {
        if (!in_array($role, $roles_provided)) {
            $roles_provided[] = $role;
        }
    }
    $app['security.roles_provided'] = $roles_provided;
}


$app->get('/admin/holidayhome/setup',
    'phpManufaktur\HolidayHome\Data\Setup\Setup::Controller');
$app->get('/admin/holidayhome/update',
    'phpManufaktur\HolidayHome\Data\Setup\Update::Controller');
$app->get('/admin/holidayhome/uninstall',
    'phpManufaktur\HolidayHome\Data\Setup\Uninstall::Controller');

/**
 * Use the EmbeddedAdministration feature to connect the extension with the CMS
 *
 * @link https://github.com/phpManufaktur/kitFramework/wiki/Extensions-%23-Embedded-Administration
*/
$app->get('/holidayhome/cms/{cms_information}', function ($cms_information) use ($app) {
    $administration = new EmbeddedAdministration($app);
    return $administration->route('/holidayhome/editor/about', $cms_information, 'ROLE_HOLIDAYHOME_EDITOR');
});

/**
 * EDITOR routes (PROTECTED)
 */

$app->get('/holidayhome/editor',
    'phpManufaktur\HolidayHome\Control\Admin\About::Controller');
$app->get('/holidayhome/editor/about',
    'phpManufaktur\HolidayHome\Control\Admin\About::Controller');
