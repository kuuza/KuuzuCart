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

  use Kuuzu\KU\Core\Access;
  use Kuuzu\KU\Core\HTML;
  use Kuuzu\KU\Core\KUUZU;
  use Kuuzu\KU\Core\Registry;
?>

<!doctype html>

<html dir="<?php echo $KUUZU_Language->getTextDirection(); ?>" lang="<?php echo $KUUZU_Language->getCode(); ?>">

<head>

<meta http-equiv="Content-Type" content="text/html; charset=<?php echo $KUUZU_Language->getCharacterSet(); ?>" />

<title><?php echo STORE_NAME . ': ' . KUUZU::getDef('administration_title') . ($KUUZU_Template->hasPageTitle() ? ': ' . $KUUZU_Template->getPageTitle() : ''); ?></title>

<link rel="icon" type="image/png" href="<?php echo KUUZU::getPublicSiteLink('images/kuuzu_icon.png'); ?>" />

<meta name="generator" value="Kuuzu Cart" />
<meta name="robots" content="noindex,nofollow" />

<script type="text/javascript" src="public/external/jquery/jquery-1.7.1.min.js"></script>
<script type="text/javascript" src="public/external/jquery/jquery.cookie.js"></script>
<script type="text/javascript" src="public/external/jquery/jquery.json-2.2.min.js"></script>
<script type="text/javascript" src="public/external/jquery/jquery.tinysort.min.js"></script>
<script type="text/javascript" src="public/external/jquery/jquery.ocupload-1.1.2.packed.js"></script>
<script type="text/javascript" src="public/external/jquery/jquery.hoverIntent.minified.js"></script>
<script type="text/javascript" src="public/external/jquery/jquery.placeholder.min.js"></script>
<script type="text/javascript" src="public/external/jquery/jquery.droppy.js"></script>
<script type="text/javascript" src="public/external/jquery/jquery.blockUI.js"></script>
<script type="text/javascript" src="public/external/jquery/jquery.md5.js"></script>

<script type="text/javascript" src="public/external/jquery/tipsy/jquery.tipsy.js"></script>
<link rel="stylesheet" type="text/css" href="public/external/jquery/tipsy/tipsy.css" />

<script src="public/external/jquery/jquery.netchanger.min.js"></script>
<script src="public/external/jquery/jquery.safetynet.js"></script>

<script src="public/sites/Admin/javascript/jquery/jquery.buttonsetTabs.js"></script>
<script src="public/sites/Admin/javascript/jquery/jquery.equalResize.js"></script>
<script src="public/sites/Admin/javascript/jquery/jquery.imageSelector.js"></script>

<link rel="stylesheet" type="text/css" href="public/external/fileuploader/fileuploader.css" />
<script src="public/external/fileuploader/fileuploader.min.js"></script>

<link rel="stylesheet" type="text/css" href="public/external/jquery/ui/themes/smoothness/jquery-ui-1.8.17.custom.css" />
<script type="text/javascript" src="public/external/jquery/ui/jquery-ui-1.8.17.custom.min.js"></script>

<script type="text/javascript" src="public/external/alexei/sprintf.js"></script>

<script type="text/javascript" src="<?php echo KUUZU::getPublicSiteLink('javascript/general.js'); ?>"></script>
<script type="text/javascript" src="<?php echo KUUZU::getPublicSiteLink('javascript/datatable.js'); ?>"></script>

<link rel="stylesheet" type="text/css" href="<?php echo KUUZU::getPublicSiteLink('templates/kuuzu/stylesheets/general.css'); ?>" />

<script type="text/javascript">
  var pageURL = '<?php echo KUUZU::getLink(); ?>';
  var pageModule = '<?php echo KUUZU::getSiteApplication(); ?>';

  var batchSize = parseInt('<?php echo MAX_DISPLAY_SEARCH_RESULTS; ?>');
  var batchTotalPagesText = '<?php echo addslashes(KUUZU::getDef('batch_results_number_of_entries')); ?>';
  var batchCurrentPageset = '<?php echo addslashes(KUUZU::getDef('result_set_current_page')); ?>';
  var batchIconNavigationBack = '<?php echo HTML::icon('nav_back.png'); ?>';
  var batchIconNavigationBackGrey = '<?php echo HTML::icon('nav_back_grey.png'); ?>';
  var batchIconNavigationForward = '<?php echo HTML::icon('nav_forward.png'); ?>';
  var batchIconNavigationForwardGrey = '<?php echo HTML::icon('nav_forward_grey.png'); ?>';
  var batchIconNavigationReload = '<?php echo HTML::icon('reload.png'); ?>';
  var batchIconProgress = '<?php echo HTML::icon('progress_ani.gif'); ?>';

  var taxDecimalPlaces = parseInt('<?php echo TAX_DECIMAL_PLACES; ?>');
</script>

<meta name="application-name" content="Kuuzu Dashboard" />
<meta name="msapplication-tooltip" content="Kuuzu Administration Dashboard" />
<meta name="msapplication-window" content="width=1024;height=768" />
<meta name="msapplication-navbutton-color" content="#ff7900" />
<meta name="msapplication-starturl" content="<?php echo KUUZU::getLink(null, KUUZU::getDefaultSiteApplication(), null, 'SSL', false); ?>" />

</head>

<body>

<?php
  if ( $KUUZU_Template->hasPageHeader() ) {
    include($KUUZU_Template->getTemplateFile('header.php'));
  }
?>

<div id="appContent">

<?php
  if ( Registry::get('MessageStack')->exists('header') ) {
    echo Registry::get('MessageStack')->get('header');
  }

  require($KUUZU_Template->getPageContentsFile());
?>

</div>

<?php
  if ( $KUUZU_Template->hasPageFooter() ) {
?>

<div id="footer">
  <?php include($KUUZU_Template->getTemplateFile('footer.php')); ?>
</div>

<?php
  }
?>

</body>

</html>
