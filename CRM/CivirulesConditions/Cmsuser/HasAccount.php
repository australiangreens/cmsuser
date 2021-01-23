<?php
/**
 * Class for CiviRules Cmsuser HasAccount condition
 *
 * @author MJW Consulting <mjw@mjwconsult.co.uk>
 * @license AGPL-3.0
 */

class CRM_CivirulesConditions_Cmsuser_HasAccount extends CRM_Civirules_Condition {

  protected $conditionParams = [];

  /**
   * Method to set the Rule Condition data
   *
   * @param array $ruleCondition
   */
  public function setRuleConditionData(array $ruleCondition) {
    parent::setRuleConditionData($ruleCondition);
    $this->conditionParams = [];
    if (!empty($this->ruleCondition['condition_params'])) {
      $this->conditionParams = unserialize($this->ruleCondition['condition_params']);
    }
  }

  /**
   * This method returns TRUE or FALSE when an condition is valid or not
   *
   * @param CRM_Civirules_TriggerData_TriggerData $triggerData
   *
   * @return bool
   */
  public function isConditionValid(CRM_Civirules_TriggerData_TriggerData $triggerData): bool {
    $isConditionValid = FALSE;
    $entityID = $triggerData->getEntityId();

    if (empty($entityID)) {
      return FALSE;
    }

    $cmsuser = civicrm_api3('Cmsuser', 'get', ['contact_id' => $entityID]);
    if (!empty($cmsuser['id'])) {
      $isConditionValid = TRUE;
    }

    return $isConditionValid;
  }

  /**
   * This function validates whether this condition works with the selected trigger.
   *
   * @param CRM_Civirules_Trigger $trigger
   * @param CRM_Civirules_BAO_Rule $rule
   *
   * @return bool
   */
  public function doesWorkWithTrigger(CRM_Civirules_Trigger $trigger, CRM_Civirules_BAO_Rule $rule) {
    if ($trigger->doesProvideEntity('Contact')) {
      return TRUE;
    }
    return FALSE;
  }

}
