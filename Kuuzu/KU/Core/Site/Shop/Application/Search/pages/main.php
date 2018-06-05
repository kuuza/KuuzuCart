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

  use Kuuzu\KU\Core\HTML;
  use Kuuzu\KU\Core\KUUZU;
?>

<h1><?php echo $KUUZU_Template->getPageTitle(); ?></h1>

<?php
  if ( $KUUZU_MessageStack->exists('Search') ) {
    echo $KUUZU_MessageStack->get('Search');
  }
?>

<form name="search" action="<?php echo KUUZU::getLink(null, null, null, 'NONSSL', false); ?>" method="get" onsubmit="return check_form(this);">

<?php
  echo HTML::hiddenField('Search', null);
?>

<div class="moduleBox">
  <h6><?php echo KUUZU::getDef('search_criteria_title'); ?></h6>

  <div class="content">
    <?php echo HTML::inputField('Q', null, 'style="width: 99%;"'); ?>
  </div>
</div>

<div class="submitFormButtons">
  <span style="float: right;"><?php echo HTML::button(array('icon' => 'search', 'title' => KUUZU::getDef('button_search'))); ?></span>

  <?php echo HTML::link('javascript:popupWindow(\'' . KUUZU::getLink(null, null, 'Help') . '\');', KUUZU::getDef('search_help_tips')); ?>
</div>

<div class="moduleBox">
  <h6><?php echo KUUZU::getDef('advanced_search_heading'); ?></h6>

  <div class="content">
    <ol>
      <li>

<?php
  echo HTML::label(KUUZU::getDef('field_search_categories'), 'category');

  $KUUZU_CategoryTree->setSpacerString('&nbsp;', 2);

  $categories_array = array(array('id' => '',
                                  'text' => KUUZU::getDef('filter_all_categories')));

  foreach ( $KUUZU_CategoryTree->buildBranchArray(0) as $category ) {
    $categories_array[] = array('id' => $category['id'],
                                'text' => $category['title']);
  }

  echo HTML::selectMenu('category', $categories_array);
?>

      </li>
      <li><?php echo HTML::checkboxField('recursive', array(array('id' => '1', 'text' => KUUZU::getDef('field_search_recursive'))), true); ?></li>
      <li>

<?php
  echo HTML::label(KUUZU::getDef('field_search_manufacturers'), 'manufacturer');

  $manufacturers_array = array(array('id' => '', 'text' => KUUZU::getDef('filter_all_manufacturers')));

  $Qmanufacturers = $KUUZU_PDO->query('select manufacturers_id, manufacturers_name from :table_manufacturers order by manufacturers_name');
  $Qmanufacturers->execute();

  while ( $Qmanufacturers->fetch() ) {
    $manufacturers_array[] = array('id' => $Qmanufacturers->valueInt('manufacturers_id'),
                                   'text' => $Qmanufacturers->value('manufacturers_name'));
  }

  echo HTML::selectMenu('manufacturer', $manufacturers_array);
?>

      </li>
      <li><?php echo HTML::label(KUUZU::getDef('field_search_price_from'), 'pfrom') . HTML::inputField('pfrom'); ?></li>
      <li><?php echo HTML::label(KUUZU::getDef('field_search_price_to'), 'pto') . HTML::inputField('pto'); ?></li>
      <li><?php echo HTML::label(KUUZU::getDef('field_search_date_from'), 'datefrom_days') . HTML::dateSelectMenu('datefrom', null, false, null, null, date('Y') - $KUUZU_Search->getMinYear(), 0); ?></li>
      <li><?php echo HTML::label(KUUZU::getDef('field_search_date_to'), 'dateto_days') . HTML::dateSelectMenu('dateto', null, null, null, null, date('Y') - $KUUZU_Search->getMaxYear(), 0); ?></li>
    </ol>
  </div>
</div>

<?php
  echo HTML::hiddenSessionIDField();
?>

</form>
