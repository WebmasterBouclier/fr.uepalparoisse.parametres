<?php

class CRM_Parametres_Config {
  private static $singleton;

  public function __construct() {
  }

  public function checkConfig() {
    // general settings
    $this->setDateFormat();
    $this->setMoneyFormat();
    $this->setAddressAndDisplayFormat();
    
    // tags
    $this->createTags(['Intervenant externe', 'Officiels - interreligieux', 'Officiels - pasteurs', 'Officiels - politiques', 'Officiels - Quai Saint Thomas', 'Organisation : Eglises et oeuvres', 'Organisation : Entreprise', 'Organisation :  Partenaire musical']);

/* A TRAVAILLER
    // relationships
    $this->getRelationshipType_estMembreEluDe();
    $this->getRelationshipType_estMembreCoopteDe();
    $this->getRelationshipType_estMembreInviteDe();
    $this->getRelationshipType_estMembreDeDroitDe();
    $this->getRelationshipType_estPasteurDe();
    $this->getRelationshipType_estDiacreDe();
    $this->getRelationshipType_estPresidentDe();
    $this->getRelationshipType_estVicePresidentDe();
    $this->getRelationshipType_estTresorierDe();
    $this->getRelationshipType_estSecretaireDe();
    $this->getRelationshipType_estAnimateurDe();
    $this->getRelationshipType_estPetitEnfantDe();
    $this->getRelationshipType_estParoissienDe();

    // custom fields
    $this->getCustomField_paroisseDetailEglise();
    $this->getCustomField_paroisseDetailTheologie();
    $this->getCustomField_paroisseDetailInspectionConsistoireReforme();
    $this->getCustomField_paroisseDetailConsistoireLutherien();
    $this->getCustomField_paroisseDetailNombreParoissiens();
    $this->getCustomField_paroisseDetailNombreElecteurs();

    $this->getCustomField_ministreDetailAnneeConsecration();
    $this->getCustomField_ministreDetailAnneeEntreeMinistere();
    $this->getCustomField_ministreDetailAnneeEntreePosteActuel();
    $this->getCustomField_ministreDetailDateCAFP();
    $this->getCustomField_ministreDetailDiplomes();
    $this->getCustomField_ministreDetailRemunerePar();
    $this->getCustomField_ministreDetailStatut();
  }
*/
  public function createTags($tags) {
    // delete default tags
    $defaultCiviTags = [
      [1,'À but non lucratif'],
      [2,'Entreprise'],
      [3,'Organisation gouvernementale'],
      [4,'Donateur majeur'],
      [5,'Bénévole'],
    ];
    foreach ($defaultCiviTags as $defaultCiviTag) {
      $sql = "delete from civicrm_tag where id = %1 and name = %2 and description is not null";
      $sqlParams = [
        1 => [$defaultCiviTag[0], 'Integer'],
        2 => [$defaultCiviTag[1], 'String'],
      ];
      CRM_Core_DAO::executeQuery($sql, $sqlParams);
    }

    // create the new ones
    foreach ($tags as $tag) {
      // check if it exists
      $params = [
        'sequential' => 1,
        'name' => $tag,
        'is_selectable' => '1',
        'is_reserved' => '0',
        'is_tagset' => '0',
        'used_for' => 'civicrm_contact',
      ];
      $result = civicrm_api3('Tag', 'get', $params);
      if ($result['count'] == 0) {
        // create the tag
        $result = civicrm_api3('Tag', 'create', $params);
      }
    }
  }

  public function getRelationshipType_estMembreEluDe() {
    $params = [
      'name_a_b' => 'est_membre_elu_de',
      'label_a_b' => 'est Membre élu·e de',
      'name_b_a' => 'a_pour_membre_elu',
      'label_b_a' => 'a pour Membre élu·e',
      'contact_type_a' => 'Individual',
      'contact_type_b' => 'Organization',
      'is_reserved' => '0',
      'is_active' => '1'
    ];
    return  $this->createOrGetRelationshipType($params);
  }

  public function getRelationshipType_estMembreCoopteDe() {
    $params = [
      'name_a_b' => 'est_membre_coopte_de',
      'label_a_b' => 'est Membre coopté·e de',
      'name_b_a' => 'a_pour_membre_coopte',
      'label_b_a' => 'a pour Membre coopté·e',
      'contact_type_a' => 'Individual',
      'contact_type_b' => 'Organization',
      'is_reserved' => '0',
      'is_active' => '1'
    ];
    return  $this->createOrGetRelationshipType($params);
  }

  public function getRelationshipType_estMembreInviteDe() {
    $params = [
      'name_a_b' => 'est_membre_invite_de',
      'label_a_b' => 'est Membre invité·e de',
      'name_b_a' => 'a_pour_membre_invite',
      'label_b_a' => 'a pour Membre invité·e',
      'contact_type_a' => 'Individual',
      'contact_type_b' => 'Organization',
      'is_reserved' => '0',
      'is_active' => '1'
    ];
    return  $this->createOrGetRelationshipType($params);
  }

  public function getRelationshipType_estMembreDeDroitDe() {
    $params = [
      'name_a_b' => 'est_membre_de_droit_de',
      'label_a_b' => 'est Membre de Droit de',
      'name_b_a' => 'a_pour_membre_de_droit',
      'label_b_a' => 'a pour Membre de Droit',
      'contact_type_a' => 'Individual',
      'contact_type_b' => 'Organization',
      'is_reserved' => '0',
      'is_active' => '1'
    ];
    return  $this->createOrGetRelationshipType($params);
  }

  public function getRelationshipType_estPasteurDe() {
    $params = [
      'name_a_b' => 'est_pasteur_de',
      'label_a_b' => 'est Pasteur de',
      'name_b_a' => 'a_pour_pasteur',
      'label_b_a' => 'a pour Pasteur',
      'contact_type_a' => 'Individual',
      'contact_type_b' => 'Organization',
      'is_reserved' => '0',
      'is_active' => '1'
    ];
    return  $this->createOrGetRelationshipType($params);
  }


  public function getRelationshipType_estDiacreDe() {
    $params = [
      'name_a_b' => 'est_diacre_de',
      'label_a_b' => 'est Diacre de',
      'name_b_a' => 'a_pour_diacre',
      'label_b_a' => 'a pour Diacre',
      'contact_type_a' => 'Individual',
      'contact_type_b' => 'Organization',
      'is_reserved' => '0',
      'is_active' => '1'
    ];
    return  $this->createOrGetRelationshipType($params);
  }

  public function getRelationshipType_estPresidentDe() {
    $params = [
      'name_a_b' => 'est_president_de',
      'label_a_b' => 'est Président·e de',
      'name_b_a' => 'a_pour_president',
      'label_b_a' => 'a pour Président·e',
      'contact_type_a' => 'Individual',
      'contact_type_b' => 'Organization',
      'is_reserved' => '0',
      'is_active' => '1'
    ];
    return  $this->createOrGetRelationshipType($params);
  }

  public function getRelationshipType_estVicePresidentDe() {
    $params = [
      'name_a_b' => 'est_vice_president_de',
      'label_a_b' => 'est Vice-Président·e de',
      'name_b_a' => 'a_pour_vice_president',
      'label_b_a' => 'a pour Vice-Président·e',
      'contact_type_a' => 'Individual',
      'contact_type_b' => 'Organization',
      'is_reserved' => '0',
      'is_active' => '1'
    ];
    return  $this->createOrGetRelationshipType($params);
  }

  public function getRelationshipType_estTresorierDe() {
    $params = [
      'name_a_b' => 'est_tresorier_de',
      'label_a_b' => 'est Trésorier·ère de',
      'name_b_a' => 'a_pour_tresorier',
      'label_b_a' => 'a pour Trésorier·ère',
      'contact_type_a' => 'Individual',
      'contact_type_b' => 'Organization',
      'is_reserved' => '0',
      'is_active' => '1'
    ];
    return  $this->createOrGetRelationshipType($params);
  }

  public function getRelationshipType_estSecretaireDe() {
    $params = [
      'name_a_b' => 'est_secretaire_de',
      'label_a_b' => 'est Secrétaire de',
      'name_b_a' => 'a_pour_secretaire',
      'label_b_a' => 'a pour Secrétaire',
      'contact_type_a' => 'Individual',
      'contact_type_b' => 'Organization',
      'is_reserved' => '0',
      'is_active' => '1'
    ];
    return  $this->createOrGetRelationshipType($params);
  }

  public function getRelationshipType_estAnimateurDe() {
    $params = [
      'name_a_b' => 'est_animateur_de',
      'label_a_b' => 'est Animateur·trice de',
      'name_b_a' => 'a_pour_animateur',
      'label_b_a' => 'a pour Animateur·trice',
      'contact_type_a' => 'Individual',
      'contact_type_b' => 'Organization',
      'is_reserved' => '0',
      'is_active' => '1'
    ];
    return  $this->createOrGetRelationshipType($params);
  }

  public function getRelationshipType_estPetitEnfantDe() {
    $params = [
      'name_a_b' => 'est_petit_enfant_de',
      'label_a_b' => 'est Petit Enfant de',
      'name_b_a' => 'a_pour_petit_enfant',
      'label_b_a' => 'a pour Petit Enfant',
      'contact_type_a' => 'Individual',
      'contact_type_b' => 'Organization',
      'is_reserved' => '0',
      'is_active' => '1'
    ];
    return  $this->createOrGetRelationshipType($params);
  }

  public function getRelationshipType_estParoissienDe() {
    $params = [
      'name_a_b' => 'est_paroissien_de',
      'label_a_b' => 'est Paroissien·ne de',
      'name_b_a' => 'a_pour_paroissien',
      'label_b_a' => 'a pour Paroissien·ne',
      'contact_type_a' => 'Individual',
      'contact_type_b' => 'Organization',
      'is_reserved' => '0',
      'is_active' => '1'
    ];
    return  $this->createOrGetRelationshipType($params);
  }
/* A TRAVAILLER
  public function getCustomGroup_ParoisseDetail() {
    $params = [
      'name' => 'paroisse_detail',
      'title' => 'Paroisse Detail',
      'extends' => 'Organization',
      'extends_entity_column_value' => [
          'paroisse'
      ],
      'style' => 'Inline',
      'collapse_display' => '0',
      'weight' => '1',
      'is_active' => '1',
      'table_name' => 'civicrm_value_paroisse_detail',
      'is_multiple' => '0',
      'collapse_adv_display' => '0',
      'is_reserved' => '0',
      'is_public' => '0'
    ];
    return $this->createOrGetCustomGroup($params);
  }

  public function getCustomGroup_MinistreDetail() {
    $params = [
      'name' => 'ministre_detail',
      'title' => 'Ministre Detail',
      'extends' => 'Individual',
      'extends_entity_column_value' => [
        'ministre'
      ],
      'style' => 'Inline',
      'collapse_display' => '0',
      'weight' => '1',
      'is_active' => '1',
      'table_name' => 'civicrm_value_ministre_detail',
      'is_multiple' => '0',
      'collapse_adv_display' => '0',
      'is_reserved' => '0',
      'is_public' => '0'
    ];
    return $this->createOrGetCustomGroup($params);
  }

  public function getCustomField_ministreDetailAnneeConsecration() {
    $params = [
      'custom_group_id' => $this->getCustomGroup_MinistreDetail()['id'],
      'name' => 'annee_consecration',
      'label' => 'Année de consécration',
      'data_type' => 'Int',
      'html_type' => 'Text',
      'is_searchable' => '1',
      'is_search_range' => '1',
      'weight' => '1',
      'is_active' => '1',
      'text_length' => '255',
      'note_columns' => '60',
      'note_rows' => '4',
      'column_name' => 'annee_consecration',
      'in_selector' => '0'
    ];
    return $this->createOrGetCustomField($params);
  }

  public function getCustomField_ministreDetailAnneeEntreeMinistere() {
    $params = [
      'custom_group_id' => $this->getCustomGroup_MinistreDetail()['id'],
      'name' => 'annee_entree_ministere',
      'label' => 'Année d\'entrée au ministère',
      'data_type' => 'Int',
      'html_type' => 'Text',
      'is_searchable' => '1',
      'is_search_range' => '1',
      'weight' => '2',
      'is_active' => '1',
      'text_length' => '255',
      'note_columns' => '60',
      'note_rows' => '4',
      'column_name' => 'annee_entree_ministere',
      'in_selector' => '0'
    ];
    return $this->createOrGetCustomField($params);
  }

  public function getCustomField_ministreDetailAnneeEntreePosteActuel() {
    $params = [
      'custom_group_id' => $this->getCustomGroup_MinistreDetail()['id'],
      'name' => 'annee_poste_actuel',
      'label' => 'Année d\'entrée poste actuel',
      'data_type' => 'Int',
      'html_type' => 'Text',
      'is_searchable' => '1',
      'is_search_range' => '1',
      'weight' => '3',
      'is_active' => '1',
      'text_length' => '255',
      'note_columns' => '60',
      'note_rows' => '4',
      'column_name' => 'annee_poste_actuel',
      'in_selector' => '0'
    ];
    return $this->createOrGetCustomField($params);
  }

  public function getCustomField_ministreDetailDateCAFP() {
    $params = [
      'custom_group_id' => $this->getCustomGroup_MinistreDetail()['id'],
      'name' => 'date_cafp',
      'label' => 'Date CAFP',
      'data_type' => 'Date',
      'html_type' => 'Select Date',
      'is_searchable' => '1',
      'is_search_range' => '1',
      'weight' => '5',
      'is_active' => '1',
      'text_length' => '255',
      'date_format' => 'dd/mm/yy',
      'note_columns' => '60',
      'note_rows' => '4',
      'column_name' => 'date_cafp',
      'in_selector' => '0'
    ];
    return $this->createOrGetCustomField($params);
  }

  public function getCustomField_ministreDetailDiplomes() {
    $params = [
      'custom_group_id' => $this->getCustomGroup_MinistreDetail()['id'],
      'name' => 'diplomes',
      'label' => 'Diplômes',
      'data_type' => 'Memo',
      'html_type' => 'TextArea',
      'is_search_range' => '0',
      'weight' => '6',
      'attributes' => 'rows=4, cols=60',
      'is_active' => '1',
      'note_columns' => '60',
      'note_rows' => '6',
      'column_name' => 'diplomes',
      'in_selector' => '0'
    ];
    return $this->createOrGetCustomField($params);
  }

  public function getCustomField_ministreDetailRemunerePar() {
    $params = [
      'custom_group_id' => $this->getCustomGroup_MinistreDetail()['id'],
      'name' => 'remunere_par',
      'label' => 'Rémunéré par',
      'data_type' => 'String',
      'html_type' => 'Select',
      'is_searchable' => '1',
      'is_search_range' => '0',
      'weight' => '7',
      'is_active' => '1',
      'text_length' => '255',
      'note_columns' => '60',
      'note_rows' => '4',
      'column_name' => 'remunere_par',
      'option_group_id' => $this->getOptionGroup_RemunerePar()['id'],
      'in_selector' => '0'
    ];
    return $this->createOrGetCustomField($params);
  }

  public function getCustomField_ministreDetailStatut() {
    $params = [
      'custom_group_id' => $this->getCustomGroup_MinistreDetail()['id'],
      'name' => 'statut',
      'label' => 'Statut',
      'data_type' => 'String',
      'html_type' => 'Select',
      'is_searchable' => '1',
      'is_search_range' => '0',
      'weight' => '8',
      'is_active' => '1',
      'text_length' => '255',
      'note_columns' => '60',
      'note_rows' => '4',
      'column_name' => 'statut',
      'option_group_id' => $this->getOptionGroup_StatutPasteur()['id'],
      'in_selector' => '0'
    ];
    return $this->createOrGetCustomField($params);
  }

  public function getCustomField_paroisseDetailEglise() {
    $params = [
      'custom_group_id' => $this->getCustomGroup_ParoisseDetail()['id'],
      'name' => 'eglise',
      'label' => 'Eglise',
      'data_type' => 'String',
      'html_type' => 'Select',
      'is_searchable' => '1',
      'is_search_range' => '0',
      'weight' => '1',
      'is_active' => '1',
      'text_length' => '255',
      'note_columns' => '60',
      'note_rows' => '4',
      'column_name' => 'eglise',
      'option_group_id' => $this->getOptionGroup_Eglises()['id'],
      'in_selector' => '0'
    ];
    return $this->createOrGetCustomField($params);
  }

  public function getCustomField_paroisseDetailTheologie() {
    $params = [
      'custom_group_id' => $this->getCustomGroup_ParoisseDetail()['id'],
      'name' => 'theologie',
      'label' => 'Théologie',
      'data_type' => 'String',
      'html_type' => 'CheckBox',
      'is_searchable' => '1',
      'is_search_range' => '0',
      'weight' => '2',
      'is_active' => '1',
      'options_per_line' => '1',
      'text_length' => '255',
      'note_columns' => '60',
      'note_rows' => '4',
      'column_name' => 'theologie',
      'option_group_id' => $this->getOptionGroup_Theologie()['id'],
      'in_selector' => '0'
    ];
    return $this->createOrGetCustomField($params);
  }

  public function getCustomField_paroisseDetailInspectionConsistoireReforme() {
    $params = [
      'custom_group_id' => $this->getCustomGroup_ParoisseDetail()['id'],
      'name' => 'inspection_consistoire_reforme',
      'label' => 'Inspection / Consistoire réformé',
      'data_type' => 'ContactReference',
      'html_type' => 'Autocomplete-Select',
      'is_searchable' => '1',
      'is_search_range' => '0',
      'weight' => '3',
      'is_active' => '1',
      'text_length' => '255',
      'note_columns' => '60',
      'note_rows' => '4',
      'column_name' => 'inspection_consistoire_reforme',
      'filter' => 'action=get&contact_sub_type=inspection_consistoire_reforme',
      'in_selector' => '0'
    ];
    return $this->createOrGetCustomField($params);
  }

  public function getCustomField_paroisseDetailConsistoireLutherien() {
    $params = [
      'custom_group_id' => $this->getCustomGroup_ParoisseDetail()['id'],
      'name' => 'consistoire_lutherien',
      'label' => 'Consistoire luthérien',
      'data_type' => 'ContactReference',
      'html_type' => 'Autocomplete-Select',
      'is_searchable' => '1',
      'is_search_range' => '0',
      'weight' => '4',
      'is_active' => '1',
      'text_length' => '255',
      'note_columns' => '60',
      'note_rows' => '4',
      'column_name' => 'consistoire_lutherien',
      'filter' => 'action=get&contact_sub_type=consistoire_lutherien',
      'in_selector' => '0'
    ];
    return $this->createOrGetCustomField($params);
  }

  public function getCustomField_paroisseDetailNombreParoissiens() {
    $params = [
      'custom_group_id' => $this->getCustomGroup_ParoisseDetail()['id'],
      'name' => 'nombre_paroissiens',
      'label' => 'Nombre de paroissiens',
      'data_type' => 'Int',
      'html_type' => 'Text',
      'is_searchable' => '1',
      'is_search_range' => '1',
      'weight' => '5',
      'is_active' => '1',
      'text_length' => '255',
      'note_columns' => '60',
      'note_rows' => '4',
      'column_name' => 'nombre_paroissiens',
      'in_selector' => '0'
    ];
    return $this->createOrGetCustomField($params);
  }

  public function getCustomField_paroisseDetailNombreElecteurs() {
    $params = [
      'custom_group_id' => $this->getCustomGroup_ParoisseDetail()['id'],
      'name' => 'nombre_electeurs',
      'label' => 'Nombre d\'électeurs',
      'data_type' => 'Int',
      'html_type' => 'Text',
      'is_searchable' => '1',
      'is_search_range' => '1',
      'weight' => '6',
      'is_active' => '1',
      'text_length' => '255',
      'note_columns' => '60',
      'note_rows' => '4',
      'column_name' => 'nombre_electeurs',
      'in_selector' => '0'
    ];
    return $this->createOrGetCustomField($params);
  }

  public function getOptionGroup_StatutPasteur() {
    $params = [
      'name' => 'statut_pasteur',
      'title' => 'Statut pasteur',
      'data_type' => 'String',
      'is_reserved' => '0',
      'is_active' => '1',
      'is_locked' => '0'
    ];
    $options = ['Actif', 'En congé', 'Retraité'];
    return $this->createOrGetOptionGroup($params, $options, 'Actif');
  }

  public function getOptionGroup_RemunerePar() {
    $params = [
      'name' => 'remunere_par',
      'title' => 'Rémunéré par',
      'data_type' => 'String',
      'is_reserved' => '0',
      'is_active' => '1',
      'is_locked' => '0'
    ];
    $options = ['Bureau des cultes', 'ESP'];
    return $this->createOrGetOptionGroup($params, $options);
  }

  public function getOptionGroup_Eglises() {
    $params = [
      'name' => 'eglises',
      'title' => 'Eglises',
      'data_type' => 'String',
      'is_reserved' => '0',
      'is_active' => '1',
      'is_locked' => '0'
    ];
    $options = ['EPRAL', 'EPCAAL'];
    return $this->createOrGetOptionGroup($params, $options);
  }

  public function getOptionGroup_Theologie() {
    $params = [
      'name' => 'theologies',
      'title' => 'Théologies',
      'data_type' => 'String',
      'is_reserved' => '0',
      'is_active' => '1',
      'is_locked' => '0'
    ];
    $options = ['Réformée', 'Luthérienne'];
    return $this->createOrGetOptionGroup($params, $options);
  }

  private function createOrGetRelationshipType($params) {
    try {
      $relType = civicrm_api3('RelationshipType', 'getsingle', [
        'name_a_b' => $params['name_a_b'],
        'name_b_a' => $params['name_b_a'],
      ]);
    }
    catch (Exception $e) {
      $relType = civicrm_api3('RelationshipType', 'create', $params);
    }

    return $relType;
  }

  private function createOrGetCustomGroup($params) {
    try {
      $customGroup = civicrm_api3('CustomGroup', 'getsingle', [
        'name' => $params['name'],
      ]);
    }
    catch (Exception $e) {
      $customGroup = civicrm_api3('CustomGroup', 'create', $params);
    }

    return $customGroup;
  }

  private function createOrGetCustomField($params) {
    try {
      $customField = civicrm_api3('CustomField', 'getsingle', [
        'custom_group_id' => $params['custom_group_id'],
        'name' => $params['name'],
      ]);
    }
    catch (Exception $e) {
      $customField = civicrm_api3('CustomField', 'create', $params);
    }

    return $customField;
  }

  private function createOrGetOptionGroup($params, $options, $defaultOption = '') {
    // in Development mode we force the recreation of the options
    $recreateOptions = FALSE;
    if (Civi::settings()->get('environment') == 'Development') {
      $recreateOptions = TRUE;
    }

    try {
      $optionGroup = civicrm_api3('OptionGroup', 'getsingle', [
        'name' => $params['name'],
      ]);
    }
    catch (Exception $e) {
      $optionGroup = civicrm_api3('OptionGroup', 'create', $params);
      $recreateOptions = TRUE;
    }

    if ($recreateOptions) {
      // delete existing options
      $sql = "delete from civicrm_option_value where option_group_id = " . $optionGroup['id'];
      CRM_Core_DAO::executeQuery($sql);

      // add the options
      $i = 1;
      foreach ($options as $option) {
        civicrm_api3('OptionValue', 'create', [
          'option_group_id' => $optionGroup['id'],
          'label' => $option,
          'value' => $i,
          'name' => CRM_Utils_String::munge($option, '_', 64),
          'is_default' => ($option == $defaultOption) ? 1 : '0',
          'weight' => $i,
          'is_optgroup' => '0',
          'is_reserved' => '0',
          'is_active' => '1'
        ]);
        $i++;
      }
    }

    return $optionGroup;
  }
*/
/*VERIFICATION FAITE*/
  private function setDateFormat() {
    //Civi\Api4\Setting::set()
    civicrm_api4('Setting', 'set', [
      'values' => [
        'dateformatDatetime' => '%e %B %Y %H:%M',
        'dateformatFull' => '%e %B %Y',
        'dateformatTime' => '%H:%M',
        'dateformatFinancialBatch' => '%d/%m/%Y',
        'dateformatshortdate' => '%d/%m/%Y',
        'dateInputFormat' => 'dd/mm/yy',
        'timeInputFormat' => '2',
        'weekBegins' => '1',
      ],
      'domainId' => 1,
    ]);
  }
/*VERIFICATION FAITE*/
  private function setMoneyFormat() {
    civicrm_api4('Setting', 'set', [
      'values' => [
        'monetaryThousandSeparator' => ' ',
        'monetaryDecimalPoint' => ',',
        'moneyformat' => '%a %c',
        'moneyvalueformat' => '%!i',
        'defaultCurrency' => 'EUR',
      ],
    ]);
  }
/*VERIFICATION FAITE*/
  private function setAddressAndDisplayFormat() {
    civicrm_api4('Setting', 'set', [
      'values' => [
        'address_format' => "{contact.address_name}\n{contact.street_address}\n{contact.supplemental_address_1}\n{contact.supplemental_address_2}\n{contact.supplemental_address_3}\n{contact.postal_code}{ }{contact.city}\n{contact.country}",
        'mailing_format' => "{contact.addressee}\n{contact.street_address}\n{contact.supplemental_address_1}\n{contact.supplemental_address_2}\n{contact.supplemental_address_3}\n{contact.postal_code}{ }{contact.city}\n{contact.country}",
        'display_name_format' => '{contact.individual_prefix}{ }{contact.first_name}{ }{contact.last_name}{ }{contact.individual_suffix}',
        'sort_name_format' => '{contact.last_name}{, }{contact.first_name}',
        'defaultContactCountry' => 1076,
      ],
    ]);
/*VERIFICATION FAITE*/
    // set email_greeting and postal_greeting (e.g. Chère Mme la pasteure DUPOND, Cher M. PIF)
    $format = '{capture assign=c}{contact.communication_style}{/capture}{capture assign=p}{contact.individual_prefix}{/capture}{if $p=="Mme"}Chère{else}Cher{/if} {if $c=="Familiar"}{contact.first_name}{else}{$p} {contact.formal_title} {contact.last_name}{/if}';
    $sql = "
      update
        civicrm_option_value v
      inner join
        civicrm_option_group g on v.option_group_id = g.id
      set
        label = '$format'
      where
        g.name in ('email_greeting', 'postal_greeting')
      and
        v.value = 1
    ";
    CRM_Core_DAO::executeQuery($sql);

    // see civicrm/admin/setting/preferences/display?reset=1, section "Editing Contacts" (Informations éditables)
    // select everything except Other name and OpenID (= 10, 15)
    $prefs = [1,2,3,4,5,6,7,8,9,11,12,13,14,16,17];
    $transformedPrefs = serialize(CRM_Core_DAO::VALUE_SEPARATOR . implode(CRM_Core_DAO::VALUE_SEPARATOR, $prefs) . CRM_Core_DAO::VALUE_SEPARATOR);
    $sql = "update civicrm_setting set value = %1 where name = 'contact_edit_options'";
    $sqlParams = [
      1 => [$transformedPrefs, 'String'],
    ];
    CRM_Core_DAO::executeQuery($sql, $sqlParams);

  }


}