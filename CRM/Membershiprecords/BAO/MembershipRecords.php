<?php
use CRM_Membershiprecords_ExtensionUtil as E;

class CRM_Membershiprecords_BAO_MembershipRecords extends CRM_Membershiprecords_DAO_MembershipRecords {

  /**
   * Create a new MembershipRecords based on array-data
   *
   * @param array $params key-value pairs
   * @return CRM_Membershiprecords_DAO_MembershipRecords|NULL
   *
  public static function create($params) {
    $className = 'CRM_Membershiprecords_DAO_MembershipRecords';
    $entityName = 'MembershipRecords';
    $hook = empty($params['id']) ? 'create' : 'edit';

    CRM_Utils_Hook::pre($hook, $entityName, CRM_Utils_Array::value('id', $params), $params);
    $instance = new $className();
    $instance->copyValues($params);
    $instance->save();
    CRM_Utils_Hook::post($hook, $entityName, $instance->id, $instance);

    return $instance;
  } */

}
