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

namespace Kuuzu\KU\Core;

use Kuuzu\KU\Core\{
    HTML,
    KUUZU,
    Registry
};

class ActionRecorder
{
    public static function save(array $action): bool
    {
        $KUUZU_PDO = Registry::get('PDO');

        $data = [
            'site' => $action['site'] ?? KUUZU::getSite(),
            'application' => $action['application'] ?? KUUZU::getSiteApplication(),
            'ip_address' => $action['ip_address'] ?? sprintf('%u', ip2long(KUUZU::getIPAddress()))
        ];

        if (isset($action['actions'])) {
            $actions = $action['actions'];
        } else {
            $actions = [];

            if (Registry::exists('Application')) {
                $actions = Registry::get('Application')->getRequestedActions();
            }
        }

        if (!empty($actions)) {
            $data['actions'] = implode('&', $actions);
        }

        if (isset($action['action'])) {
            $data['action'] = $action['action'];
        } else {
            trigger_error('ActionRecorder: \'action\' not defined.', E_USER_ERROR);

            $data['action'] = '';
        }

        if (isset($action['success'])) {
            $data['success'] = $action['success'];
        } else {
            trigger_error('ActionRecorder: \'success\' not defined.', E_USER_ERROR);

            $data['success'] = '';
        }

        if (isset($action['user_id'])) {
            $data['user_id'] = $action['user_id'];
        }

        if (isset($action['identifier'])) {
            $data['identifier'] = $action['identifier'];
        }

        if (isset($action['result'])) {
            $data['result'] = $action['result'];
        }

        $user_agent = $action['user_agent'] ?? $_SERVER['HTTP_USER_AGENT'] ?? '';
        $user_agent = HTML::sanitize($user_agent);

        if (strlen($user_agent) > 2048) {
            $user_agent = substr($user_agent, 0, 2048);
        }

        $data['user_agent'] = $user_agent;

        return ($KUUZU_PDO->save('action_recorder', $data) === 1);
    }
}
