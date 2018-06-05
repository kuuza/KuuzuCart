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

  namespace Kuuzu\KU\Core\Site\Setup\Application\Install\SQL\MySQL\V5;

  use Kuuzu\KU\Core\KUUZU;
  use Kuuzu\KU\Core\Registry;

  class ImportFK {
    public static function execute($data) {
      $KUUZU_PDO = Registry::get('PDO');

      $sql_file = KUUZU::BASE_DIRECTORY . 'Core/Site/Setup/sql/kuuzu_innodb.sql';

      $KUUZU_PDO->importSQL($sql_file, $data['table_prefix']);

      $KUUZU_PDO->exec('DROP PROCEDURE IF EXISTS CountriesGetAll;
CREATE PROCEDURE CountriesGetAll (IN pageset INT, IN maxresults INT)
BEGIN
  IF pageset is null THEN
    SELECT SQL_CALC_FOUND_ROWS c.*, COUNT(z.zone_id) AS total_zones
    FROM kuu_countries c
    LEFT JOIN kuu_zones z ON (c.countries_id = z.zone_country_id)
    GROUP BY c.countries_id
    ORDER BY c.countries_name;
  ELSE
    PREPARE STMT FROM
      "SELECT SQL_CALC_FOUND_ROWS c.*, COUNT(z.zone_id) AS total_zones
       FROM kuu_countries c
       LEFT JOIN kuu_zones z ON (c.countries_id = z.zone_country_id)
       GROUP BY c.countries_id
       ORDER BY c.countries_name
       LIMIT ?, ?";
    SET @START = pageset;
    SET @LIMIT = maxresults;
    EXECUTE STMT USING @START, @LIMIT;
  END IF;

  SELECT FOUND_ROWS() as total;
END;');
    }
  }
?>
