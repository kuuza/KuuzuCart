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

<table border="0" width="100%" cellspacing="0" cellpadding="2">
  <tr>

<?php
    if ( sizeof($KUUZU_Category->getPathArray()) > 1 ) {
// check to see if there are deeper categories within the current category
      $category_links = array_reverse($KUUZU_Category->getPathArray());

      for( $i=0, $n=sizeof($category_links); $i<$n; $i++ ) {
        $Qcategories = $KUUZU_PDO->prepare('select count(*) as total from :table_categories c, :table_categories_description cd where c.parent_id = :parent_id and c.categories_id = cd.categories_id and cd.language_id = :language_id');
        $Qcategories->bindInt(':parent_id', $category_links[$i]);
        $Qcategories->bindInt(':language_id', $KUUZU_Language->getID());
        $Qcategories->execute();

        if ( $Qcategories->valueInt('total') < 1 ) {
          // do nothing, go through the loop
        } else {
          $Qcategories = $KUUZU_PDO->prepare('select c.categories_id, cd.categories_name, c.categories_image, c.parent_id from :table_categories c, :table_categories_description cd where c.parent_id = :parent_id and c.categories_id = cd.categories_id and cd.language_id = :language_id order by sort_order, cd.categories_name');
          $Qcategories->bindInt(':parent_id', $category_links[$i]);
          $Qcategories->bindInt(':language_id', $KUUZU_Language->getID());
          $Qcategories->execute();

          break; // we've found the deepest category the customer is in
        }
      }
    } else {
      $Qcategories = $KUUZU_PDO->prepare('select c.categories_id, cd.categories_name, c.categories_image, c.parent_id from :table_categories c, :table_categories_description cd where c.parent_id = :parent_id and c.categories_id = cd.categories_id and cd.language_id = :language_id order by sort_order, cd.categories_name');
      $Qcategories->bindInt(':parent_id', $KUUZU_Category->getID());
      $Qcategories->bindInt(':language_id', $KUUZU_Language->getID());
      $Qcategories->execute();
    }

    $result = $Qcategories->fetchAll();
    $number_of_categories = count($result);

    $width = (int)(100 / MAX_DISPLAY_CATEGORIES_PER_ROW) . '%';

    $rows = 0;

    foreach ( $result as $c ) {
      $rows++;

      echo '    <td align="center" class="smallText" width="' . $width . '" valign="top">' . HTML::link(KUUZU::getLink(null, 'Index', 'cPath=' . $KUUZU_CategoryTree->buildBreadcrumb($c['categories_id'])), HTML::image('public/categories/' . $c['categories_image'], $c['categories_name']) . '<br />' . $c['categories_name']) . '</td>' . "\n";

      if ( (($rows / MAX_DISPLAY_CATEGORIES_PER_ROW) == floor($rows / MAX_DISPLAY_CATEGORIES_PER_ROW)) && ($rows != $number_of_categories) ) {
        echo '  </tr>' . "\n" .
             '  <tr>' . "\n";
      }
    }
?>

  </tr>
</table>
