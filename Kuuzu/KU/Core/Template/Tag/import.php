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

use Kuuzu\KU\Core\Registry;

class import extends \Kuuzu\KU\Core\Template\TagAbstract
{
    public static function execute($file): string
    {
        $result = '';

        if (!empty($file)) {
            if (file_exists($file)) {
// use only file_get_contents() when content pages no longer contain PHP; HPDL
                if (substr($file, strrpos($file, '.')+1) == 'html') {
                    $result = file_get_contents($file);
                } else {
                    $result = Registry::get('Template')->getContent($file);
                }
            } else {
                trigger_error('Template Tag {import}: File does not exist: ' . $file);
            }
        }

        return $result;
    }
}
