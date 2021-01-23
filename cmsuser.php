<?php

require_once 'cmsuser.civix.php';
// phpcs:disable
use CRM_Cmsuser_ExtensionUtil as E;
// phpcs:enable

/**
 * Implements hook_civicrm_config().
 *
 * @link https://docs.civicrm.org/dev/en/latest/hooks/hook_civicrm_config/
 */
function cmsuser_civicrm_config(&$config) {
  _cmsuser_civix_civicrm_config($config);
}

/**
 * Implements hook_civicrm_xmlMenu().
 *
 * @link https://docs.civicrm.org/dev/en/latest/hooks/hook_civicrm_xmlMenu
 */
function cmsuser_civicrm_xmlMenu(&$files) {
  _cmsuser_civix_civicrm_xmlMenu($files);
}

/**
 * Implements hook_civicrm_install().
 *
 * @link https://docs.civicrm.org/dev/en/latest/hooks/hook_civicrm_install
 */
function cmsuser_civicrm_install() {
  _cmsuser_civix_civicrm_install();
}

/**
 * Implements hook_civicrm_postInstall().
 *
 * @link https://docs.civicrm.org/dev/en/latest/hooks/hook_civicrm_postInstall
 */
function cmsuser_civicrm_postInstall() {
  _cmsuser_civix_civicrm_postInstall();
}

/**
 * Implements hook_civicrm_uninstall().
 *
 * @link https://docs.civicrm.org/dev/en/latest/hooks/hook_civicrm_uninstall
 */
function cmsuser_civicrm_uninstall() {
  _cmsuser_civix_civicrm_uninstall();
}

/**
 * Implements hook_civicrm_enable().
 *
 * @link https://docs.civicrm.org/dev/en/latest/hooks/hook_civicrm_enable
 */
function cmsuser_civicrm_enable() {
  _cmsuser_civix_civicrm_enable();
}

/**
 * Implements hook_civicrm_disable().
 *
 * @link https://docs.civicrm.org/dev/en/latest/hooks/hook_civicrm_disable
 */
function cmsuser_civicrm_disable() {
  _cmsuser_civix_civicrm_disable();
}

/**
 * Implements hook_civicrm_upgrade().
 *
 * @link https://docs.civicrm.org/dev/en/latest/hooks/hook_civicrm_upgrade
 */
function cmsuser_civicrm_upgrade($op, CRM_Queue_Queue $queue = NULL) {
  return _cmsuser_civix_civicrm_upgrade($op, $queue);
}

/**
 * Implements hook_civicrm_managed().
 *
 * Generate a list of entities to create/deactivate/delete when this module
 * is installed, disabled, uninstalled.
 *
 * @link https://docs.civicrm.org/dev/en/latest/hooks/hook_civicrm_managed
 */
function cmsuser_civicrm_managed(&$entities) {
  _cmsuser_civix_civicrm_managed($entities);

  $actions = civicrm_api3('CiviRuleAction', 'get', ['name' => ['IN' => ['cmsuser_create']]]);
  if (empty($actions['values'])) {
    civicrm_api3('CiviRuleAction', 'create', [
      'label' => 'Create CMS user',
      'name' => 'cmsuser_create',
      'class_name' => 'CRM_CivirulesActions_Cmsuser_Create',
      'is_active' => 1,
    ]);
  }

  $conditions = civicrm_api3('CiviRuleCondition', 'get', ['name' => ['IN' => ['cmsuser_get']]]);
  if (empty($conditions['values'])) {
    civicrm_api3('CiviRuleCondition', 'create', [
      'label' => 'Contact has CMS user',
      'name' => 'cmsuser_get',
      'class_name' => 'CRM_CivirulesConditions_Cmsuser_HasAccount',
      'is_active' => 1,
    ]);
  }
}

/**
 * Implements hook_civicrm_alterSettingsFolders().
 *
 * @link https://docs.civicrm.org/dev/en/latest/hooks/hook_civicrm_alterSettingsFolders
 */
function cmsuser_civicrm_alterSettingsFolders(&$metaDataFolders = NULL) {
  _cmsuser_civix_civicrm_alterSettingsFolders($metaDataFolders);
}

/**
 * Implements hook_civicrm_entityTypes().
 *
 * Declare entity types provided by this module.
 *
 * @link https://docs.civicrm.org/dev/en/latest/hooks/hook_civicrm_entityTypes
 */
function cmsuser_civicrm_entityTypes(&$entityTypes) {
  _cmsuser_civix_civicrm_entityTypes($entityTypes);
}
