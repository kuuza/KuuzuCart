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

namespace Kuuzu\KU\Core\Template\Tag;

class json extends \Kuuzu\KU\Core\Template\TagAbstract
{
    public static function execute($string)
    {
        return json_encode($string);
    }
}
