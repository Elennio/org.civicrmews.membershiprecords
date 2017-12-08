<?php

require_once 'membershiprecords.civix.php';
use CRM_Membershiprecords_ExtensionUtil as E;

function membershiprecords_civicrm_pre($op, $objectName, $id, &$params){
  
//CRM_Core_Session::setStatus(ts($id + 'something here'), $id, 'no-popup');
  echo "<pre>";
  print_r($op);
  echo "</pre>";

  echo "<pre>";
  print_r($objectName);
  echo "</pre>";
  //echo "\r\n";
  echo "<pre>";
  print_r($id);
  echo "</pre>";
  //echo $params;
  echo "<pre>"; 
  ///home/rzcodert/buildkit/bin
  //PATH="/home/rzcodert/buildkit/bin:$PATH"
  print_r($params);
  //PATH=/home/rzcodert/buildkit/bin:$PATH 
  echo "/<pre>"; 
 /*die($op);
  $result = civicrm_api3('MembershipRecords', 'create', array(
    'contact_id' => 203,
    'membership_id' => "",
    'start_date' => "",
    'end_date' => "",
    'contribution_id' => "",
  ));  */
}
function membershiprecords_civicrm_post($op, $objectName, $objectId, &$objectRef) {
  /*if ($objectName == 'Membership' && $op == 'create') {
    CRM_Core_Transaction::addCallback(CRM_Core_Transaction::PHASE_POST_COMMIT,
      'updateMembershipCustomField', array($objectRef->id));
    break;
  }*/
  echo "POST";
  echo "<pre>";
  print_r($objectRef);
  echo "</pre>";
  die('COWABUNGA');
}

/**
 * Implements hook_civicrm_config().
 *
 * @link http://wiki.civicrm.org/confluence/display/CRMDOC/hook_civicrm_config
 */
function membershiprecords_civicrm_config(&$config) {
  _membershiprecords_civix_civicrm_config($config);
}

/**
 * Implements hook_civicrm_xmlMenu().
 *
 * @link http://wiki.civicrm.org/confluence/display/CRMDOC/hook_civicrm_xmlMenu
 */
function membershiprecords_civicrm_xmlMenu(&$files) {
  _membershiprecords_civix_civicrm_xmlMenu($files);
}

/**
 * Implements hook_civicrm_install().
 *
 * @link http://wiki.civicrm.org/confluence/display/CRMDOC/hook_civicrm_install
 */
function membershiprecords_civicrm_install() {
  _membershiprecords_civix_civicrm_install();
}

/**
 * Implements hook_civicrm_postInstall().
 *
 * @link http://wiki.civicrm.org/confluence/display/CRMDOC/hook_civicrm_postInstall
 */
function membershiprecords_civicrm_postInstall() {
  _membershiprecords_civix_civicrm_postInstall();
}

/**
 * Implements hook_civicrm_uninstall().
 *
 * @link http://wiki.civicrm.org/confluence/display/CRMDOC/hook_civicrm_uninstall
 */
function membershiprecords_civicrm_uninstall() {
  _membershiprecords_civix_civicrm_uninstall();
}

/**
 * Implements hook_civicrm_enable().
 *
 * @link http://wiki.civicrm.org/confluence/display/CRMDOC/hook_civicrm_enable
 */
function membershiprecords_civicrm_enable() {
  _membershiprecords_civix_civicrm_enable();
}

/**
 * Implements hook_civicrm_disable().
 *
 * @link http://wiki.civicrm.org/confluence/display/CRMDOC/hook_civicrm_disable
 */
function membershiprecords_civicrm_disable() {
  _membershiprecords_civix_civicrm_disable();
}

/**
 * Implements hook_civicrm_upgrade().
 *
 * @link http://wiki.civicrm.org/confluence/display/CRMDOC/hook_civicrm_upgrade
 */
function membershiprecords_civicrm_upgrade($op, CRM_Queue_Queue $queue = NULL) {
  return _membershiprecords_civix_civicrm_upgrade($op, $queue);
}

/**
 * Implements hook_civicrm_managed().
 *
 * Generate a list of entities to create/deactivate/delete when this module
 * is installed, disabled, uninstalled.
 *
 * @link http://wiki.civicrm.org/confluence/display/CRMDOC/hook_civicrm_managed
 */
function membershiprecords_civicrm_managed(&$entities) {
  _membershiprecords_civix_civicrm_managed($entities);
}

/**
 * Implements hook_civicrm_caseTypes().
 *
 * Generate a list of case-types.
 *
 * Note: This hook only runs in CiviCRM 4.4+.
 *
 * @link http://wiki.civicrm.org/confluence/display/CRMDOC/hook_civicrm_caseTypes
 */
function membershiprecords_civicrm_caseTypes(&$caseTypes) {
  _membershiprecords_civix_civicrm_caseTypes($caseTypes);
}

/**
 * Implements hook_civicrm_angularModules().
 *
 * Generate a list of Angular modules.
 *
 * Note: This hook only runs in CiviCRM 4.5+. It may
 * use features only available in v4.6+.
 *
 * @link http://wiki.civicrm.org/confluence/display/CRMDOC/hook_civicrm_angularModules
 */
function membershiprecords_civicrm_angularModules(&$angularModules) {
  _membershiprecords_civix_civicrm_angularModules($angularModules);
}

/**
 * Implements hook_civicrm_alterSettingsFolders().
 *
 * @link http://wiki.civicrm.org/confluence/display/CRMDOC/hook_civicrm_alterSettingsFolders
 */
function membershiprecords_civicrm_alterSettingsFolders(&$metaDataFolders = NULL) {
  _membershiprecords_civix_civicrm_alterSettingsFolders($metaDataFolders);
}

// --- Functions below this ship commented out. Uncomment as required. ---

/**
 * Implements hook_civicrm_preProcess().
 *
 * @link http://wiki.civicrm.org/confluence/display/CRMDOC/hook_civicrm_preProcess
 *
function membershiprecords_civicrm_preProcess($formName, &$form) {

} // */

/**
 * Implements hook_civicrm_navigationMenu().
 *
 * @link http://wiki.civicrm.org/confluence/display/CRMDOC/hook_civicrm_navigationMenu
 *
function membershiprecords_civicrm_navigationMenu(&$menu) {
  _membershiprecords_civix_insert_navigation_menu($menu, NULL, array(
    'label' => E::ts('The Page'),
    'name' => 'the_page',
    'url' => 'civicrm/the-page',
    'permission' => 'access CiviReport,access CiviContribute',
    'operator' => 'OR',
    'separator' => 0,
  ));
  _membershiprecords_civix_navigationMenu($menu);
} // */
