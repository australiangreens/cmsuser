<?php

use CRM_Cmsuser_ExtensionUtil as E;

/**
 * Cmsuser.Get API specification (optional)
 *
 * @param array $params description of fields supported by this API call
 */
function _civicrm_api3_cmsuser_get_spec(&$params) {
  $params['contact_id'] = [
    'title' => 'Contact ID',
    'description' => 'CiviCRM contact ID',
    'api.required' => TRUE,
    'type' => CRM_Utils_Type::T_INT,
  ];
}

/**
 * Cmsuser.Get API
 *
 * @param array $params
 *
 * @return array
 */
function civicrm_api3_cmsuser_get($params) {
  $user = CRM_Core_Config::singleton()->userSystem->getUser($params['contact_id']);
  $result = [];
  if ($user) {
    $result[$params['contact_id']] = [
      'uf_id' => $user['id'],
      'uf_name' => $user['name'],
      'contact_id' => $params['contact_id'],
    ];
  }
  return civicrm_api3_create_success($result);
}
