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

namespace Kuuzu\KU\Core\Site\RPC;

use Kuuzu\KU\Core\{
    HTML,
    HttpRequest,
    KUUZU
};

class Controller implements \Kuuzu\KU\Core\SiteInterface
{
    const STATUS_ERROR = -1;
    const STATUS_SUCCESS = 1;
    const STATUS_REDIRECT_DETECTED = -10;
    const STATUS_NO_MODULE = -20;
    const STATUS_NO_ACCESS = -50;
    const STATUS_CLASS_NONEXISTENT = -60;
    const STATUS_NO_ACTION = -70;
    const STATUS_ACTION_NONEXISTENT = -71;

    protected static $_default_application = 'Index';

    public static function initialize()
    {
        KUUZU::setIsRPC();

        header('X-Robots-Tag: none');
        header('Content-Type: application/json; charset=utf-8');
        header('Expires: Mon, 26 Jul 1997 05:00:00 GMT');
        header('Last-Modified: ' . gmdate('D, d M Y H:i:s') . ' GMT');
        header('Cache-Control: no-store, no-cache, must-revalidate');
        header('Cache-Control: post-check=0, pre-check=0', false);
        header('Pragma: no-cache');

        try {
            if (empty($_GET)) {
                throw new \Exception(self::STATUS_NO_MODULE);
            } elseif (count($_GET) < 2) {
                throw new \Exception(self::STATUS_NO_ACTION);
            }

            $run_pos = 1;

            $site = HTML::sanitize(basename(key(array_slice($_GET, $run_pos, 1, true))));

            if (KUUZU::siteExists($site)) {
                $run_pos++;
            } else {
                $site = KUUZU::getDefaultSite();
            }

            KUUZU::setSite($site);

            $application = HTML::sanitize(basename(key(array_slice($_GET, $run_pos, 1,  true))));

            if (KUUZU::siteApplicationExists($application)) {
                $run_pos++;

                $rpc = HTML::sanitize(basename(key(array_slice($_GET, $run_pos, 1,  true))));

                if (empty($rpc) || !static::siteApplicationRPCExists($rpc, $application)) {
                    $application = KUUZU::getDefaultSiteApplication();

                    $run_pos -= 1;
                }
            } else {
                $application = KUUZU::getDefaultSiteApplication();
            }

            KUUZU::setSiteApplication($application);

            ob_start(function($buffer) {
                foreach (headers_list() as $h) {
                    if (stripos($h, 'Location:') !== false) {
                        header_remove('Location');

                        \Kuuzu\KU\Core\HttpRequest::setResponseCode(403); // ob_start() needs full namespace

                        $buffer = json_encode([
                            'rpcStatus' => constant('Kuuzu\\KU\\Core\\Site\\RPC\\Controller::STATUS_REDIRECT_DETECTED')
                        ]);

                        break;
                    }
                }

                return $buffer;
            });

            call_user_func([
                'Kuuzu\\KU\\Core\\Site\\' . $site . '\\Controller',
                'initialize'
            ]);

            ob_end_flush();

            if (!call_user_func(['Kuuzu\\KU\\Core\\Site\\' . $site . '\\Controller', 'hasAccess'], $application)) {
                throw new \Exception(self::STATUS_NO_ACCESS);
            }

            $rpc_called = false;

            $rpc = [];

            for ($i = $run_pos, $n = count($_GET); $i < $n; $i++) {
                $subrpc = HTML::sanitize(basename(key(array_slice($_GET, $i, 1, true))));

                $rpc[] = $subrpc;

                if (static::siteApplicationRPCExists(implode('\\', $rpc))) {
                    call_user_func(['Kuuzu\\KU\\Core\\Site\\' . KUUZU::getSite() . '\\Application\\' . KUUZU::getSiteApplication() . '\\RPC\\' . implode('\\', $rpc), 'execute']);

                    $rpc_called = true;
                } else {
                    break;
                }
            }

            if ($rpc_called === false) {
                throw new \Exception(self::STATUS_NO_ACTION);
            }
        } catch (\Exception $e) {
            HttpRequest::setResponseCode(403);

            echo json_encode([
                'rpcStatus' => $e->getMessage()
            ]);
        }

        exit;
    }

    public static function getDefaultApplication()
    {
        return self::$_default_application;
    }

    public static function hasAccess($application)
    {
        return true;
    }

    public static function siteApplicationRPCExists($rpc, $application = null)
    {
        if (!isset($application)) {
            $application = KUUZU::getSiteApplication();
        }

        return class_exists('Kuuzu\\KU\\Core\\Site\\' . KUUZU::getSite() . '\\Application\\' . $application . '\\RPC\\' . $rpc);
    }
}
