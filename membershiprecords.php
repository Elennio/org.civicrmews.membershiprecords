<?php

require_once 'membershiprecords.civix.php';
use CRM_Membershiprecords_ExtensionUtil as E;

function membershiprecords_civicrm_pre($op, $objectName, $id, &$params){
  //$myObjectRefKeysExternal = explorationArray($params);

  if ($objectName == 'Membership' && $op == 'edit'){  
    //Getting the contact ID
    $resultGetMembership = civicrm_api3('Membership', 'get', array(
      'sequential' => 1,
      'return' => array("contact_id"),
      'id' => $id,
    ));

    if ($resultGetMembership['count'] > 0){
      
      $result = civicrm_api3('MembershipRecords', 'create', array(
        'contact_id' => $resultGetMembership['values'][0]['contact_id'],
        'membership_id' => $id,
        'start_date' => $params['log_start_date'],
        'end_date' => $params['end_date'],
        'contribution_id' => "",
      ));
    }

  }
  if ($objectName == 'MembershipPayment' && $op == 'create' && $params['version'] != '3'){

    $result = civicrm_api3('MembershipRecords', 'get', array(
      'sequential' => 1,
      'membership_id' => $params['membership_id'],
      'options' => array('limit' => 0),
    ));

    $doItResult = civicrm_api3('MembershipRecords', 'create', array(
      'id' => $result['values'][($result['count'] - 1)]['id'],
      'contribution_id' => $params['contribution_id'],
    ));
  }

}
function membershiprecords_civicrm_post($op, $objectName, $objectId, &$objectRef) {

  if ($objectName == 'Membership' && $op == 'create') {
    
    $result = civicrm_api3('Membership', 'get', array(
      'sequential' => 1,
      'return' => array("contact_id", "start_date", "end_date"),
      'id' => $objectId,
    ));
    
    $result = civicrm_api3('MembershipRecords', 'create', array(
      'contact_id' => $result['values']['0']['contact_id'],
      'membership_id' => $result['values']['0']['id'],
      'start_date' => $result['values']['0']['start_date'],
      'end_date' => $result['values']['0']['end_date'],
      'contribution_id' => "",
    ));
  }

}

/**
* Implemented to look inside some objects that I pretend to use after all
*/
function explorationArray ($arrReceived) {
  $result = '';
  foreach($arrReceived as $key => $value) {
    
    $result = $result .' ' . $key . '->'. $arrReceived[$key];
  }
  return $result;
}

function getMembershipRecordsByContactId($id){

  $result = civicrm_api3('MembershipRecords', 'get', array(
      'sequential' => 1,
      'contact_id' => $id,
      'options' => array('limit' => 0),
    ));

  return $result;
}

/*
* Populating the content.
*/
function contentPopulator($actualContent, $actualKeyDos, $actualMembershipRecordsResult, $actualCounter){

  switch ($actualKeyDos) {
    case "id":
        $actualContent = $actualContent . '<tr><td>' . '<h3> Membership: ' . $actualCounter . '</h3></tr></td>';
        break;
    case "start_date":
        $startDate = date_create($actualMembershipRecordsResult['start_date']);
        $startDate = date_format($startDate, 'd/m/Y');
        $actualContent = $actualContent . '<tr><td><b> Start Date: </b>' . $startDate . '</tr></td>';
        break;
    case "end_date":
        $endDate = date_create($actualMembershipRecordsResult['end_date']);
        $endDate = date_format($endDate, 'd/m/Y');
        $actualContent = $actualContent . '<tr><td><b> End Date: </b>' . $endDate . '</tr></td>';
        break;
    case "membership_id":
        $actualContent = $actualContent . '<tr><td><a href="/civicrm/contact/view/membership?action=view&reset=1&cid='.$actualMembershipRecordsResult['contact_id'].'&id='.$actualMembershipRecordsResult[$actualKeyDos].'&context=membership&selectedChild=member">Membership</a></tr></td>';
        break;
    case "contribution_id":
        $actualContent = $actualContent . '<tr><td><a href="/civicrm/contact/view/contribution?reset=1&id='.$actualMembershipRecordsResult[$actualKeyDos].'&cid='.$actualMembershipRecordsResult['contact_id'].'&action=view&context=contribution&selectedChild=contribute">Contribution</a></tr></td>';
        break;
  }

  return $actualContent;
}
/**
* Transforming the Frontend.
**/
function membershiprecords_civicrm_summary( $contactID, &$content, &$contentPlacement = CRM_Utils_Hook::SUMMARY_BELOW ){
  
  $contador = 1;
  $membershipRecordsResult = getMembershipRecordsByContactId($contactID);
  $content = '<table> <tr><th> Membership Records: '. $membershipRecordsResult['count'] .'</th></tr>';
  if($membershipRecordsResult['count'] < 1){

  }else{
    foreach ($membershipRecordsResult['values'] as $key => $value) {
    
      foreach ($membershipRecordsResult['values'][$key] as $keyDos => $value) {

        $content = contentPopulator($content, $keyDos, $membershipRecordsResult['values'][$key], $contador);
        
        if($keyDos == 'id'){

          $contador++;
        }
      }
    }
  }
  /*foreach ($membershipRecordsResult['values'] as $key => $value) {
    
    foreach ($membershipRecordsResult['values'][$key] as $keyDos => $value) {

      $content = contentPopulator($content, $keyDos, $membershipRecordsResult['values'][$key], $contador);
      
      if($keyDos == 'id'){

        $contador++;
      }
    }
  }*/

  $content = $content . '</table>';

}

/**
 * Implementation of hook_civicrm_entityTypes
 */
function membershiprecords_civicrm_entityTypes(&$entityTypes) {
  $entityTypes[] = array(
    'name'  => 'MembershipRecords',
    'class' => 'CRM_Membershiprecords_DAO_MembershipRecords',
    'table' => 'civicrm_membershiprecords',
  );
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
