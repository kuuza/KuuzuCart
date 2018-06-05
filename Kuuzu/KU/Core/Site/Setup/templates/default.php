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

  use Kuuzu\KU\Core\KUUZU;
?>

<!doctype html>

<html dir="<?php echo $KUUZU_Language->getTextDirection(); ?>" lang="<?php echo $KUUZU_Language->getCode(); ?>">

  <head>

    <meta http-equiv="Content-Type" content="text/html; charset=<?php echo $KUUZU_Language->getCharacterSet(); ?>" />

    <title>Kuuzu Cart</title>

    <link rel="icon" type="image/png" href="<?php echo KUUZU::getPublicSiteLink('images/kuuzu_icon.png'); ?>" />

    <meta name="generator" value="Kuuzu Cart" />
    <meta name="robots" content="noindex,nofollow" />

    <script type="text/javascript" src="public/external/jquery/jquery-1.7.1.min.js"></script>

    <link rel="stylesheet" type="text/css" href="public/external/jquery/ui/themes/smoothness/jquery-ui-1.8.17.custom.css" />
    <script type="text/javascript" src="public/external/jquery/ui/jquery-ui-1.8.17.custom.min.js"></script>

    <link rel="stylesheet" type="text/css" href="<?php echo KUUZU::getPublicSiteLink('templates/default/stylesheets/general.css'); ?>" />

  </head>

  <body>

    <div id="pageHeader">
      <div>
        <div style="float: right; padding-top: 40px; padding-right: 15px; color: #000000; font-weight: bold;"><a href="https://kuuzu.org" target="_blank">Kuuzu Website</a> &nbsp;|&nbsp; <a href="https://kuuzu.org/forum" target="_blank">Support</a></div>

        <a href="<?php echo KUUZU::getLink(null, KUUZU::getDefaultSiteApplication()); ?>"><img src="<?php echo KUUZU::getPublicSiteLink('images/kuuzu.png'); ?>" border="0" alt="" title="Kuuzu Cart v3.0" style="margin: 10px 10px 0px 10px;" /></a>
      </div>
    </div>

    <div id="pageContent">
      <?php require($KUUZU_Template->getPageContentsFile()); ?>
    </div>

    <div id="pageFooter">
      Copyright &copy; 2018 <a href="https://kuuzu.org" target="_blank">Kuuzu</a> </a>
    </div>

  </body>

</html>
