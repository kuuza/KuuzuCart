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
  use Kuuzu\KU\Core\Registry;
?>

<!doctype html>

<html dir="<?php echo $KUUZU_Language->getTextDirection(); ?>" lang="<?php echo $KUUZU_Language->getCode(); ?>">

<head>

<meta http-equiv="Content-Type" content="text/html; charset=<?php echo $KUUZU_Language->getCharacterSet(); ?>" />

<title><?php echo STORE_NAME . ($KUUZU_Template->hasPageTitle() ? ': ' . $KUUZU_Template->getPageTitle() : ''); ?></title>

<link rel="icon" type="image/png" href="<?php echo KUUZU::getPublicSiteLink('images/store_icon.png'); ?>" />

<meta name="generator" value="Kuuzu Cart" />

<script type="text/javascript" src="public/external/jquery/jquery-1.7.1.min.js"></script>

<link rel="stylesheet" type="text/css" href="public/external/jquery/ui/themes/start/jquery-ui-1.8.17.custom.css" />
<script type="text/javascript" src="public/external/jquery/ui/jquery-ui-1.8.17.custom.min.js"></script>

<link rel="stylesheet" type="text/css" href="<?php echo KUUZU::getPublicSiteLink('templates/kuuzu/stylesheets/general.css'); ?>" />

<?php
  if ( $KUUZU_Template->hasPageTags() ) {
    echo $KUUZU_Template->getPageTags();
  }

  if ($KUUZU_Template->hasJavascript()) {
    $KUUZU_Template->getJavascript();
  }
?>

</head>

<body>

<div id="pageBlockLeft">
  <div id="pageContent">

<?php
  if ( $KUUZU_MessageStack->exists('header') ) {
    echo $KUUZU_MessageStack->get('header');
  }

  if ( $KUUZU_Template->hasPageContentModules() ) {
    foreach ( $KUUZU_Service->getCallBeforePageContent() as $service ) {
      Registry::get($service[0])->$service[1]();
    }

    foreach ( $KUUZU_Template->getContentModules('before') as $content_module ) {
      $KUUZU_ContentModule = new $content_module();
      $KUUZU_ContentModule->initialize();

      if ( $KUUZU_ContentModule->hasContent() ) { // HPDL move logic elsewhere
        if ( $KUUZU_Template->getCode() == DEFAULT_TEMPLATE ) {
          include(KUUZU::BASE_DIRECTORY . 'Core/Site/' . KUUZU::getSite() . '/Module/Content/' . $KUUZU_ContentModule->getCode() . '/pages/main.php');
        } else { //HPDL old
          if (file_exists('templates/' . $Kuu_Template->getCode() . '/modules/content/' . $Kuu_Box->getCode() . '.php')) {
            include('templates/' . $Kuu_Template->getCode() . '/modules/content/' . $Kuu_Box->getCode() . '.php');
          } else {
            include('templates/' . DEFAULT_TEMPLATE . '/modules/content/' . $Kuu_Box->getCode() . '.php');
          }
        }
      }

      unset($KUUZU_ContentModule);
    }
  }

  if ( $KUUZU_Template->getCode() == DEFAULT_TEMPLATE ) {
    include(KUUZU::BASE_DIRECTORY . 'Core/Site/' . KUUZU::getSite() . '/Application/' . KUUZU::getSiteApplication() . '/pages/' . $KUUZU_Template->getPageContentsFilename());
  } else { // HPDL old
    if (file_exists('templates/' . $Kuu_Template->getCode() . '/content/' . $Kuu_Template->getGroup() . '/' . $Kuu_Template->getPageContentsFilename())) {
      include('templates/' . $Kuu_Template->getCode() . '/content/' . $Kuu_Template->getGroup() . '/' . $Kuu_Template->getPageContentsFilename());
    } else {
      include('templates/' . DEFAULT_TEMPLATE . '/content/' . $Kuu_Template->getGroup() . '/' . $Kuu_Template->getPageContentsFilename());
    }
  }
?>

<div style="clear: both;"></div>

<?php
  if ( $KUUZU_Template->hasPageContentModules() ) {
    foreach ( $KUUZU_Service->getCallAfterPageContent() as $service ) {
      Registry::get($service[0])->$service[1]();
    }

    foreach ( $KUUZU_Template->getContentModules('after') as $content_module ) {
      $KUUZU_ContentModule = new $content_module();
      $KUUZU_ContentModule->initialize();

      if ( $KUUZU_ContentModule->hasContent() ) { // HPDL move logic elsewhere
        if ( $KUUZU_Template->getCode() == DEFAULT_TEMPLATE ) {
          include(KUUZU::BASE_DIRECTORY . 'Core/Site/' . KUUZU::getSite() . '/Module/Content/' . $KUUZU_ContentModule->getCode() . '/pages/main.php');
        } else { //HPDL old
          if (file_exists('templates/' . $Kuu_Template->getCode() . '/modules/content/' . $Kuu_Box->getCode() . '.php')) {
            include('templates/' . $Kuu_Template->getCode() . '/modules/content/' . $Kuu_Box->getCode() . '.php');
          } else {
            include('templates/' . DEFAULT_TEMPLATE . '/modules/content/' . $Kuu_Box->getCode() . '.php');
          }
        }
      }

      unset($KUUZU_ContentModule);
    }
  }
?>

  </div>

<?php
  $content_left = '';

  if ( $KUUZU_Template->hasPageBoxModules() ) {
    ob_start();

    foreach ( $KUUZU_Template->getBoxModules('left') as $box ) {
      $KUUZU_Box = new $box();
      $KUUZU_Box->initialize();

      if ( $KUUZU_Box->hasContent() ) { // HPDL move logic elsewhere
        if ( $KUUZU_Template->getCode() == DEFAULT_TEMPLATE ) {
          include(KUUZU::BASE_DIRECTORY . 'Core/Site/' . KUUZU::getSite() . '/Module/Box/' . $KUUZU_Box->getCode() . '/pages/main.php');
        } else { //HPDL old
          if (file_exists('templates/' . $Kuu_Template->getCode() . '/modules/boxes/' . $Kuu_Box->getCode() . '.php')) {
            include('templates/' . $Kuu_Template->getCode() . '/modules/boxes/' . $Kuu_Box->getCode() . '.php');
          } else {
            include('templates/' . DEFAULT_TEMPLATE . '/modules/boxes/' . $Kuu_Box->getCode() . '.php');
          }
        }
      }

      unset($KUUZU_Box);
    }

    $content_left = ob_get_contents();
    ob_end_clean();
  }

  if ( !empty($content_left) ) {
?>

  <div id="pageColumnLeft">
    <div class="boxGroup">

<?php
    echo $content_left;
?>

    </div>
  </div>

<?php
  } else {
?>

<style type="text/css">
#pageContent {
  width: 99%;
  padding-left: 5px;
}
</style>

<?php
  }
?>

</div>

<?php
  $content_right = '';

  if ( $KUUZU_Template->hasPageBoxModules() ) {
    ob_start();

    foreach ( $KUUZU_Template->getBoxModules('right') as $box ) {
      $KUUZU_Box = new $box();
      $KUUZU_Box->initialize();

      if ( $KUUZU_Box->hasContent() ) { // HPDL move logic elsewhere
        if ( $KUUZU_Template->getCode() == DEFAULT_TEMPLATE ) {
          include(KUUZU::BASE_DIRECTORY . 'Core/Site/' . KUUZU::getSite() . '/Module/Box/' . $KUUZU_Box->getCode() . '/pages/main.php');
        } else { //HPDL old
          if (file_exists('templates/' . $Kuu_Template->getCode() . '/modules/boxes/' . $Kuu_Box->getCode() . '.php')) {
            include('templates/' . $Kuu_Template->getCode() . '/modules/boxes/' . $Kuu_Box->getCode() . '.php');
          } else {
            include('templates/' . DEFAULT_TEMPLATE . '/modules/boxes/' . $Kuu_Box->getCode() . '.php');
          }
        }
      }

      unset($KUUZU_Box);
    }

    $content_right = ob_get_contents();
    ob_end_clean();
  }

  if (!empty($content_right)) {
?>

<div id="pageColumnRight">
  <div class="boxGroup">

<?php
    echo $content_right;
?>

  </div>
</div>

<?php
  } elseif (empty($content_left)) {
?>

<style type="text/css"><!--
#pageBlockLeft {
  width: 99%;
}
//--></style>

<?php
  } else {
?>

<style type="text/css"><!--
#pageContent {
  width: 82%;
  padding-right: 5px;
}

#pageBlockLeft {
  width: 99%;
}

#pageColumnLeft {
  width: 16%;
}
//--></style>

<?php
  }

  unset($content_left);
  unset($content_right);

  if ( $KUUZU_Template->hasPageHeader() ) {
?>

<div id="pageHeader">

<?php
    echo HTML::link(KUUZU::getLink(KUUZU::getDefaultSite(), KUUZU::getDefaultSiteApplication()), HTML::image(KUUZU::getPublicSiteLink('images/store_logo.png'), STORE_NAME), 'id="siteLogo"');
?>

  <div id="navigationIcons">

<?php
    echo HTML::button(array('title' => KUUZU::getDef('cart_contents') . ($KUUZU_ShoppingCart->numberOfItems() > 0 ? ' (' . $KUUZU_ShoppingCart->numberOfItems() . ')' : ''), 'icon' => 'cart', 'href' => KUUZU::getLink(null, 'Cart'))) .
         HTML::button(array('title' => KUUZU::getDef('checkout'), 'icon' => 'triangle-1-e', 'href' => KUUZU::getLink(null, 'Checkout', null, 'SSL'))) .
         HTML::button(array('title' => KUUZU::getDef('my_account'), 'icon' => 'person', 'href' => KUUZU::getLink(null, 'Account', null, 'SSL')));

    if ( $KUUZU_Customer->isLoggedOn() ) {
      echo HTML::button(array('title' => KUUZU::getDef('sign_out'), 'href' => KUUZU::getLink(null, 'Account', 'LogOff', 'SSL')));
    }
?>

  </div>

  <script type="text/javascript">
    $('#navigationIcons').buttonset();
  </script>

  <div id="navigationBar">

<?php
    if ( $KUUZU_Service->isStarted('Breadcrumb') ) {
?>

    <div id="breadcrumbPath" class="ui-widget">
      <div class="ui-widget-header">
        <span style="padding-left: 5px;">
<?php
      echo $KUUZU_Breadcrumb->getPath();
?>

        </span>
      </div>
    </div>

<?php
    }
?>

  </div>
</div>

<?php
  } // ($Kuu_Template->hasPageHeader())

  if ( $KUUZU_Template->hasPageFooter() ) {
?>

<div id="pageFooter">

<?php
    echo sprintf(KUUZU::getDef('footer'), date('Y'), KUUZU::getLink(), STORE_NAME);
?>

</div>

<?php
    if ( $KUUZU_Service->isStarted('banner') && $KUUZU_Banner->exists('468x60') ) {
      echo '<p align="center">' . $KUUZU_Banner->display() . '</p>';
    }
  }
?>

</body>

</html>
