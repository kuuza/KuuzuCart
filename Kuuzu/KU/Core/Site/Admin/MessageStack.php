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

use Kuuzu\KU\Core\HTML;
use Kuuzu\KU\Core\KUUZU;

class MessageStack extends \Kuuzu\KU\Core\MessageStack
{
    public function get(string $group = null) : string
    {
        if (empty($group)) {
            $group = KUUZU::getSiteApplication();
        }

        $result = '';

        if ($this->exists($group)) {
            $data = [];

            foreach ($this->_data[$group] as $message) {
                $data['messageStack' . ucfirst($message['type'])][] = $message['text'];
            }

            foreach ($data as $type => $messages) {
                $result .= '<div class="messageStack ' . HTML::outputProtected($type) . '" role="alert">';

                foreach ($messages as $message) {
                    $result .= '<p>' . HTML::outputProtected($message) . '</p>';
                }

                $result .= '</div>';
            }

            unset($this->_data[$group]);
        }

        return $result;
    }
}
