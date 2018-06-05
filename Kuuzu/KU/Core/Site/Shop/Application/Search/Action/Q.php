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

  namespace Kuuzu\KU\Core\Site\Shop\Application\Search\Action;

  use Kuuzu\KU\Core\ApplicationAbstract;
  use Kuuzu\KU\Core\Registry;
  use Kuuzu\KU\Core\KUUZU;

  class Q {
    public static function execute(ApplicationAbstract $application) {
      $KUUZU_Service = Registry::get('Service');
      $KUUZU_Breadcrumb = Registry::get('Breadcrumb');
      $KUUZU_Search = Registry::get('Search');
      $KUUZU_MessageStack = Registry::get('MessageStack');

      $application->setPageTitle(KUUZU::getDef('search_results_heading'));
      $application->setPageContent('results.php');

      if ( $KUUZU_Service->isStarted('Breadcrumb') ) {
        $KUUZU_Breadcrumb->add(KUUZU::getDef('breadcrumb_search_results'), KUUZU::getLink(null, null, KUUZU::getAllGET()));
      }

      $error = false;

      if ( isset($_GET['datefrom_days']) && is_numeric($_GET['datefrom_days']) && isset($_GET['datefrom_months']) && is_numeric($_GET['datefrom_months']) && isset($_GET['datefrom_years']) && is_numeric($_GET['datefrom_years']) ) {
        if ( checkdate($_GET['datefrom_months'], $_GET['datefrom_days'], $_GET['datefrom_years']) ) {
          $KUUZU_Search->setDateFrom(mktime(0, 0, 0, $_GET['datefrom_months'], $_GET['datefrom_days'], $_GET['datefrom_years']));
        } else {
          $error = true;

          $KUUZU_MessageStack->add('Search', KUUZU::getDef('error_search_invalid_from_date'));
        }
      }

      if ( isset($_GET['dateto_days']) && is_numeric($_GET['dateto_days']) && isset($_GET['dateto_months']) && is_numeric($_GET['dateto_months']) && isset($_GET['dateto_years']) && is_numeric($_GET['dateto_years']) ) {
        if ( checkdate($_GET['dateto_months'], $_GET['dateto_days'], $_GET['dateto_years']) ) {
          $KUUZU_Search->setDateTo(mktime(23, 59, 59, $_GET['dateto_months'], $_GET['dateto_days'], $_GET['dateto_years']));
        } else {
          $error = true;

          $KUUZU_MessageStack->add('Search', KUUZU::getDef('error_search_invalid_to_date'));
        }
      }

      if ( $KUUZU_Search->hasDateSet() ) {
        if ( $KUUZU_Search->getDateFrom() > $KUUZU_Search->getDateTo() ) {
          $error = true;

          $KUUZU_MessageStack->add('Search', KUUZU::getDef('error_search_to_date_less_than_from_date'));
        }
      }

      if ( isset($_GET['pfrom']) && !empty($_GET['pfrom']) ) {
        if ( settype($_GET['pfrom'], 'double') ) {
          $KUUZU_Search->setPriceFrom($_GET['pfrom']);
        } else {
          $error = true;

          $KUUZU_MessageStack->add('Search', KUUZU::getDef('error_search_price_from_not_numeric'));
        }
      }

      if ( isset($_GET['pto']) && !empty($_GET['pto']) ) {
        if ( settype($_GET['pto'], 'double') ) {
          $KUUZU_Search->setPriceTo($_GET['pto']);
        } else {
          $error = true;

          $KUUZU_MessageStack->add('Search', KUUZU::getDef('error_search_price_to_not_numeric'));
        }
      }

      if ( $KUUZU_Search->hasPriceSet('from') && $KUUZU_Search->hasPriceSet('to') && ($KUUZU_Search->getPriceFrom() >= $KUUZU_Search->getPriceTo()) ) {
        $error = true;

        $KUUZU_MessageStack->add('Search', KUUZU::getDef('error_search_price_to_less_than_price_from'));
      }

      if ( isset($_GET['Q']) && is_string($_GET['Q']) && !empty($_GET['Q']) ) {
        $KUUZU_Search->setKeywords(urldecode($_GET['Q']));

        if ( $KUUZU_Search->hasKeywords() === false ) {
          $error = true;

          $KUUZU_MessageStack->add('Search', KUUZU::getDef('error_search_invalid_keywords'));
        }
      }

      if ( !$KUUZU_Search->hasKeywords() && !$KUUZU_Search->hasPriceSet('from') && !$KUUZU_Search->hasPriceSet('to') && !$KUUZU_Search->hasDateSet('from') && !$KUUZU_Search->hasDateSet('to') ) {
        $error = true;

        $KUUZU_MessageStack->add('Search', KUUZU::getDef('error_search_at_least_one_input'));
      }

      if ( isset($_GET['category']) && is_numeric($_GET['category']) && ($_GET['category'] > 0) ) {
        $KUUZU_Search->setCategory($_GET['category'], (isset($_GET['recursive']) && ($_GET['recursive'] == '1') ? true : false));
      }

      if ( isset($_GET['manufacturer']) && is_numeric($_GET['manufacturer']) && ($_GET['manufacturer'] > 0) ) {
        $KUUZU_Search->setManufacturer($_GET['manufacturer']);
      }

      if ( isset($_GET['sort']) && !empty($_GET['sort']) ) {
        if ( strpos($_GET['sort'], '|d') !== false ) {
          $KUUZU_Search->setSortBy(substr($_GET['sort'], 0, -2), '-');
        } else {
          $KUUZU_Search->setSortBy($_GET['sort']);
        }
      }

      if ( $error === false ) {
        $KUUZU_Search->execute();
      } else {
        $application->setPageContent('main.php');
      }
    }
  }
?>
