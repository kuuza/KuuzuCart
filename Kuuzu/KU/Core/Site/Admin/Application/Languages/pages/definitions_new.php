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
  use Kuuzu\KU\Core\ObjectInfo;
  use Kuuzu\KU\Core\KUUZU;
  use Kuuzu\KU\Core\Site\Admin\Application\Languages\Languages;

  $groups_array = array();

  foreach ( ObjectInfo::to(Languages::getGroups($_GET['id']))->get('entries') as $value ) {
    $groups_array[] = $value['content_group'];
  }
?>

<h1><?php echo $KUUZU_Template->getIcon(32) . HTML::link(KUUZU::getLink(), $KUUZU_Template->getPageTitle()); ?></h1>

<?php
  if ( $KUUZU_MessageStack->exists() ) {
    echo $KUUZU_MessageStack->get();
  }
?>

<div class="infoBox">
  <h3><?php echo HTML::icon('new.png') . ' ' . KUUZU::getDef('action_heading_new_language_definition'); ?></h3>

  <form name="lNew" class="dataForm" action="<?php echo KUUZU::getLink(null, null, 'InsertDefinition&Process&id=' . $_GET['id'] . (isset($_GET['group']) ? '&group=' . $_GET['group'] : '')); ?>" method="post">

  <p><?php echo KUUZU::getDef('introduction_new_language_definition'); ?></p>

  <fieldset>
    <p><label for="key"><?php echo KUUZU::getDef('field_definition_key'); ?></label><?php echo HTML::inputField('key'); ?></p>
    <p><label><?php echo KUUZU::getDef('field_definition_value'); ?></label>

<?php
  foreach ( $KUUZU_Language->getAll() as $l ) {
    echo '<br />' . $KUUZU_Language->showImage($l['code']) . '<br />' . HTML::textareaField('value[' . $l['id'] . ']');
  }
?>

    </p>
    <p><label for="defgroup"><?php echo KUUZU::getDef('field_definition_group'); ?></label><?php echo HTML::inputField('defgroup', (isset($_GET['group']) ? $_GET['group'] : null)); ?></p>
  </fieldset>

  <p><?php echo HTML::button(array('priority' => 'primary', 'icon' => 'check', 'title' => KUUZU::getDef('button_save'))) . ' ' . HTML::button(array('href' => KUUZU::getLink(null, null, 'id=' . $_GET['id'] . (isset($_GET['group']) ? '&group=' . $_GET['group'] : '')), 'priority' => 'secondary', 'icon' => 'close', 'title' => KUUZU::getDef('button_cancel'))); ?></p>

  </form>
</div>

<script type="text/javascript">
  var suggestGroups = <?php echo json_encode($groups_array); ?>;

  $("#defgroup").autocomplete({
    source: suggestGroups,
    minLength: 0
  });
</script>
