<?php

class CRM_Parametres_Exceptions {
  private static $singleton;

  public function __construct() {
  }

/**********************************************************/
/* CODE POUR LANCER LA CREATION DES DIFFERENTS PARAMETRES */
/**********************************************************/
//Ce code est nécessaire pour la création effective des données

  public function setExceptions() {
    $this->desactivateCustomField_religionDetailReligion();
  }

/* Religion' */  
  public function desactivateCustomField_religionDetailReligion() {
    $params = [
      'custom_group_id' => 'informations_religion',
      'name' => 'religion',
      'id' => '1',
      'is_active' => '0'
    ];
    return $this->desactivateCustomField($params);
  }





/* Création des champs dans les Custom Fields */
  private function desactivateCustomField($params) {

/*    $customField = civicrm_api3('CustomField', 'create', $params);
*/
/*    try {
      $customField = civicrm_api3('CustomField', 'getsingle', [
        'custom_group_id' => $params['custom_group_id'],
        'name' => $params['name'],
        'id' => $params['id'],
        'is_active' => $params['is_active']
      ]);
    }
    catch (Exception $e) {
      $customField = civicrm_api3('CustomField', 'create', $params);
    }
*/
    return $customField;
  }




}
