<?php
/**
 * Kuuzu Cart
 *
 * @copyright (c) 2007 - 2017 osCommerce; http://www.oscommerce.com
 * @license BSD License; http://www.oscommerce.com/bsdlicense.txt
 *
 * @copyright Copyright c 2018 Kuuzu; https://kuuzu.org
 * @license MIT License; https://kuuzu.org/mitlicense.txt
 */

namespace Kuuzu\KU\Core\Site\Admin;

use Kuuzu\KU\Core\{
    Access,
    Cache,
    Hash,
    KUUZU,
    PDO,
    Registry
};

use Kuuzu\KU\Core\Site\Admin\Session;

class Controller implements \Kuuzu\KU\Core\SiteInterface
{
    protected static $_default_application = 'Dashboard';
    protected static $_guest_applications = [
        'Dashboard',
        'Login'
    ];

    public static function initialize()
    {
        Registry::set('MessageStack', new MessageStack());
        Registry::set('Cache', new Cache());
        Registry::set('PDO', PDO::initialize());

        foreach (KUUZU::callDB('Shop\GetConfiguration', null, 'Site') as $param) {
            define($param['cfgkey'], $param['cfgvalue']);
        }

        Registry::set('Session', Session::load('adminSid'));
        Registry::get('Session')->start();

        if (!isset($_SESSION[KUUZU::getSite()]['secure_token'])) {
            $_SESSION[KUUZU::getSite()]['secure_token'] = Hash::getRandomString(32);
        }

        Registry::set('Language', new Language());

        if (!self::hasAccess(KUUZU::getSiteApplication())) {
            if (!isset($_SESSION[KUUZU::getSite()]['id'])) {
                if (KUUZU::getSiteApplication() != 'Login') {
                    $_SESSION[KUUZU::getSite()]['redirect_origin'] = KUUZU::getSiteApplication();

                    KUUZU::redirect(KUUZU::getLink(null, 'Login'));
                }
            } else {
                Registry::get('MessageStack')->add('header', 'No access.', 'error');

                KUUZU::redirect(KUUZU::getLink(null, KUUZU::getDefaultSiteApplication()));
            }
        }

        Registry::set('Template', new Template());

        $application = 'Kuuzu\\KU\\Core\\Site\\Admin\\Application\\' . KUUZU::getSiteApplication() . '\\Controller';
        Registry::set('Application', new $application());

        $KUUZU_Template = Registry::get('Template');
        $KUUZU_Template->setApplication(Registry::get('Application'));

// HPDL move following checks elsewhere
// check if a default currency is set
        if (!defined('DEFAULT_CURRENCY')) {
            Registry::get('MessageStack')->add('header', KUUZU::getDef('ms_error_no_default_currency'), 'error');
        }

// check if a default language is set
        if (!defined('DEFAULT_LANGUAGE')) {
            Registry::get('MessageStack')->add('header', ERROR_NO_DEFAULT_LANGUAGE_DEFINED, 'error');
        }

        if (function_exists('ini_get') && ((bool)ini_get('file_uploads') == false)) {
            Registry::get('MessageStack')->add('header', KUUZU::getDef('ms_warning_uploads_disabled'), 'warning');
        }

// check if Work directories are writable
        $work_dirs = [];

        foreach (['Cache', 'CoreUpdate', 'Database', 'Logs', 'Session', 'Temp'] as $w) {
            if (!is_writable(KUUZU::BASE_DIRECTORY . 'Work/' . $w)) {
                $work_dirs[] = $w;
            }
        }

        if (!empty($work_dirs)) {
            Registry::get('MessageStack')->add('header', sprintf(KUUZU::getDef('ms_error_work_directories_not_writable'), KUUZU::BASE_DIRECTORY . 'Work/', implode(', ', $work_dirs)), 'error');
        }

        if (!KUUZU::configExists('time_zone', 'KUUZU')) {
            Registry::get('MessageStack')->add('header', KUUZU::getDef('ms_warning_time_zone_not_defined'), 'warning');
        }

        if (!KUUZU::configExists('dir_fs_public', 'KUUZU') || !file_exists(KUUZU::getConfig('dir_fs_public', 'KUUZU'))) {
            Registry::get('MessageStack')->add('header', KUUZU::getDef('ms_warning_dir_fs_public_not_defined'), 'warning');
        }

// check if the upload directory exists
        if (is_dir(KUUZU::getConfig('dir_fs_public', 'KUUZU') . 'upload')) {
            if (!is_writeable(KUUZU::getConfig('dir_fs_public', 'KUUZU') . 'upload')) {
                Registry::get('MessageStack')->add('header', sprintf(KUUZU::getDef('ms_error_upload_directory_not_writable'), KUUZU::getConfig('dir_fs_public', 'KUUZU') . 'upload'), 'error');
            }
        } else {
            Registry::get('MessageStack')->add('header', sprintf(KUUZU::getDef('ms_error_upload_directory_non_existant'), KUUZU::getConfig('dir_fs_public', 'KUUZU') . 'upload'), 'error');
        }
    }

    public static function getDefaultApplication(): string
    {
        return static::$_default_application;
    }

    public static function hasAccess($application): bool
    {
        return isset($_SESSION[KUUZU::getSite()]['id']) && Access::hasAccess(KUUZU::getSite(), $application);
    }

    public static function getGuestApplications(): array
    {
        return static::$_guest_applications;
    }
}
