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

  namespace Kuuzu\KU\Core\Site\Admin\Application\ZoneGroups\Model;

  use Kuuzu\KU\Core\KUUZU;
  use Kuuzu\KU\Core\Registry;

  class getJSList {
    public static function execute($country, $form, $field) {
      $KUUZU_PDO = Registry::get('PDO');

      $num_country = 1;
      $output_string = '';

      $Qcountries = $KUUZU_PDO->query('select distinct zone_country_id from :table_zones order by zone_country_id');
      $Qcountries->execute();

      while ( $Qcountries->fetch() ) {
        if ( $num_country == 1 ) {
          $output_string .= '  if (' . $country . ' == "' . $Qcountries->valueInt('zone_country_id') . '") {' . "\n";
        } else {
          $output_string .= '  } else if (' . $country . ' == "' . $Qcountries->valueInt('zone_country_id') . '") {' . "\n";
        }

        $num_state = 1;

        $Qzones = $KUUZU_PDO->prepare('select zone_name, zone_id from :table_zones where zone_country_id = :zone_country_id order by zone_name');
        $Qzones->bindInt(':zone_country_id', $Qcountries->valueInt('zone_country_id'));
        $Qzones->execute();

        while ( $Qzones->fetch() ) {
          if ( $num_state == '1' ) {
            $output_string .= '    ' . $form . '.' . $field . '.options[0] = new Option("' . KUUZU::getDef('all_zones') . '", "");' . "\n";
          }

          $output_string .= '    ' . $form . '.' . $field . '.options[' . $num_state . '] = new Option("' . $Qzones->value('zone_name') . '", "' . $Qzones->valueInt('zone_id') . '");' . "\n";

          $num_state++;
        }

        $num_country++;
      }

      $output_string .= '  } else {' . "\n" .
                        '    ' . $form . '.' . $field . '.options[0] = new Option("' . KUUZU::getDef('all_zones') . '", "");' . "\n" .
                        '  }' . "\n";

      return $output_string;
    }
  }
?>
