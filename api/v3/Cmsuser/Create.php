<?php

use CRM_Cmsuser_ExtensionUtil as E;

/**
 * Cmsuser.Create API specification (optional)
 *
 * @param array $params description of fields supported by this API call
 */
function _civicrm_api3_cmsuser_create_spec(&$params) {
  $params['cms_name'] = [
    'title' => E::ts('CMS Username'),
    'type' => CRM_Utils_Type::T_STRING,
  ];
  $params['email'] = [
    'title' => E::ts('Email Address'),
    'type' => CRM_Utils_Type::T_EMAIL,
  ];
  $params['cms_pass'] = [
    'title' => E::ts('CMS Password'),
    'type' => CRM_Utils_Type::T_STRING,
  ];
  $params['contactID'] = [
    'title' => E::ts('Contact ID'),
    'description' => E::ts('CiviCRM contact ID'),
    'api.required' => TRUE,
    'type' => CRM_Utils_Type::T_INT,
  ];
  $params['notify'] = [
    'title' => E::ts('Notify User'),
    'description' => E::ts('Send an email to the user to notify them of account creation (drupal7/backdrop only).'),
    'type' => CRM_Utils_Type::T_BOOLEAN,
  ];
}

/**
 * Cmsuser.Create API
 *
 * @param array $params
 *
 * @return array
 */
function civicrm_api3_cmsuser_create($params) {
  // Check for existing contact
  if (CRM_Core_BAO_UFMatch::getUFId($params['contactID'])) {
    throw new CiviCRM_API3_Exception('The contact already has a CMS user account.');
  }

  // Get email (either from param or from contact record.
  if (empty($params['email'])) {
    $email = \Civi\Api4\Email::get(FALSE)
      ->addSelect('email')
      ->addWhere('is_primary', '=', TRUE)
      ->addWhere('contact_id', '=', $params['contactID'])
      ->execute()
      ->first();
    if (empty($email['email'])) {
      throw new CiviCRM_API3_Exception('Email is required and the contact has no email address.');
    }
    $params['email'] = $email['email'];
  }

  // If no cms_name (username) specified use email
  if (empty($params['cms_name'])) {
    $params['cms_name'] = $params['email'];
  }

  // If no password specified generate a random one
  if (empty($params['cms_pass'])) {
    $params['cms_pass'] = bin2hex(random_bytes(10));
  }

  $cmsUserParams = [
    'email' => $params['email'],
    'cms_name' => $params['cms_name'],
    'cms_pass' => $params['cms_pass'],
    'contactID' => $params['contactID'],
    'notify' => $params['notify'] ?? 1,
  ];

  $ufID = CRM_Core_BAO_CMSUser::create($cmsUserParams, 'email');
  if ($ufID) {
    return civicrm_api3_create_success(['ufmatch_id' => $ufID], $params);
  }

  throw new CiviCRM_API3_Exception('Failed to create CMS user account');
}
