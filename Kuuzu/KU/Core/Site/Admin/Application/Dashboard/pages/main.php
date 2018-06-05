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
  use Kuuzu\KU\Core\Site\Admin\Application\Dashboard\Dashboard;
?>

<h1><?php echo $KUUZU_Template->getIcon(32) . HTML::link(KUUZU::getLink(), $KUUZU_Template->getPageTitle()); ?></h1>

<table border="0" width="100%" cellspacing="0" cellpadding="2">

<?php
  $col = 0;

  $modules = Dashboard::getModules();

  foreach ( $modules as $module ) {
    if ( $col === 0 ) {
      echo '  <tr>' . "\n";
    }

    $col++;

    if ( $col <= 2 ) {
      echo '    <td width="50%" valign="top">' . "\n";
    }

    echo '<h2>';

    if ( isset($module['link']) ) {
      echo '<a href="' . $module['link'] . '">';
    }

    echo $module['title'];

    if ( isset($module['link']) ) {
      echo '</a>';
    }

    echo '</h2>';

    echo $module['data'];

    if ( $col <= 2 ) {
      echo '    </td>' . "\n";
    }

    if ( (next($modules) === false) || ($col === 2) ) {
      $col = 0;

      echo '  </tr>' . "\n";
    }
  }
?>

</table>
