<?php

class CRM_Parametres_Config {
  private static $singleton;

  public function __construct() {
  }

/**********************************************************/
/* CODE POUR LANCER LA CREATION DES DIFFERENTS PARAMETRES */
/**********************************************************/
//Ce code est nécessaire pour la création effective

  public function checkConfig() {
    // general settings
    $this->setDateFormat();
    $this->setMoneyFormat();
    $this->setAddressAndDisplayFormat();
    
    // tags / étiquettes
    $this->createTags(['Intervenant externe', 'Officiels - interreligieux', 'Officiels - pasteurs', 'Officiels - politiques', 'Officiels - Quai Saint Thomas', 'Organisation : Eglises et oeuvres', 'Organisation : Entreprise', 'Organisation :  Partenaire musical']);


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
    $this->getRelationshipType_PetitEnfantDe();
    $this->getRelationshipType_estParoissienDe();
    $this->getRelationshipType_estReceveurDe();
    $this->getRelationshipType_estDelegueDe();
    $this->getRelationshipType_estParrainMarraineDe();

    // custom fields Etat Civil
    $this->getCustomField_etatCivilDetailNomNaissance();
    $this->getCustomField_etatCivilDetailLieuNaissance();
    $this->getCustomField_etatCivilDetailDateMariage();
    $this->getCustomField_etatCivilDetailDateBenedictionNuptiale();
    $this->getCustomField_etatCivilDetailParoisseMariage();
    $this->getCustomField_etatCivilDetailVersetMariage();
    $this->getCustomField_etatCivilDetailDivorce();
    $this->getCustomField_etatCivilDetailDateDivorce();
    $this->getCustomField_etatCivilDetailDateVeuvage();
    $this->getCustomField_etatCivilDetailDateObseques();
    $this->getCustomField_etatCivilDetailParoisseEnterrement();
    $this->getCustomField_etatCivilDetailSecuriteSociale();
    $this->getCustomField_etatCivilDetailGuso();
    $this->getCustomField_etatCivilDetailFonctionnaire();
    // custom fields Information Religion
    $this->getCustomField_religionDetailReligion();
    $this->getCustomField_religionDetailDatePresentation();
    $this->getCustomField_religionDetailParoissePresentation();
    $this->getCustomField_religionDetailDateBapteme();
    $this->getCustomField_religionDetailParoisseBapteme();
    $this->getCustomField_religionDetailVersetBapteme();
    $this->getCustomField_religionDetailDateConfirmation();
    $this->getCustomField_religionDetailParoisseConfirmation();
    $this->getCustomField_religionDetailVersetConfirmation();    
    // custom fields Competences
    $this->getCustomField_competencesDetailMusiqueInstrument();
    $this->getCustomField_competencesDetailMusiqueChant();
    // custom fields Informations Complémentaires Foyer
    $this->getCustomField_complements_foyerDetailQuartier();
    // types de membres
    $this->getMembershipType_Electeur();
    $this->getMembershipType_InscritEnfant();
    $this->getMembershipType_AmiParoisse();
    $this->getMembershipType_PasInteresse();
   
  }


/***********************************/
/* DEBUT DEFINITION DES ETIQUETTES */
/***********************************/
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

/**********************************/
/* DEBUT DEFINITION DES RELATIONS */
/**********************************/
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

  public function getRelationshipType_PetitEnfantDe() {
    $params = [
      'name_a_b' => 'petit_enfant_de',
      'label_a_b' => 'Petit Enfant de',
      'name_b_a' => 'grand_parent_de',
      'label_b_a' => 'Grand Parent de',
      'contact_type_a' => 'Individual',
      'contact_type_b' => 'Individual',
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

  public function getRelationshipType_estReceveurDe() {
    $params = [
      'name_a_b' => 'est_receveur_de',
      'label_a_b' => 'est Receveur·e de',
      'name_b_a' => 'a_pour_receveur',
      'label_b_a' => 'a pour Receveur·e',
      'contact_type_a' => 'Individual',
      'contact_type_b' => 'Organization',
      'is_reserved' => '0',
      'is_active' => '1'
    ];
    return  $this->createOrGetRelationshipType($params);
  }

  public function getRelationshipType_estDelegueDe() {
    $params = [
      'name_a_b' => 'est_delegue_de',
      'label_a_b' => 'est Délégué·e de',
      'name_b_a' => 'a_pour_delegue',
      'label_b_a' => 'a pour Délégué·e',
      'contact_type_a' => 'Individual',
      'contact_type_b' => 'Organization',
      'is_reserved' => '0',
      'is_active' => '1'
    ];
    return  $this->createOrGetRelationshipType($params);
  }

  public function getRelationshipType_estParrainMarraineDe() {
    $params = [
      'name_a_b' => 'est_parrain_de',
      'label_a_b' => 'est Parrain ou Marraine de',
      'name_b_a' => 'a_pour_parrain',
      'label_b_a' => 'a pour Parrain ou Marraine',
      'contact_type_a' => 'Individual',
      'contact_type_b' => 'Individual',
      'is_reserved' => '0',
      'is_active' => '1'
    ];
    return  $this->createOrGetRelationshipType($params);
  }



/*************************************************/
/* DEBUT DEFINITION DES GROUPES de CUSTOM FIELDS */
/*************************************************/
  public function getCustomGroup_EtatCivil() {
    $params = [
      'name' => 'etat_civil',
      'title' => 'Etat Civil',
      'extends' => 'Individual',
      /* ???'extends_entity_column_value' => [
          'paroisse'
      ],*/
      'style' => 'Inline',
      'collapse_display' => '0',
      'weight' => '1',
      'is_active' => '1',
      'table_name' => 'civicrm_value_etat_civil',
      'is_multiple' => '0',
      'collapse_adv_display' => '0',
      'is_reserved' => '0',
      'is_public' => '0'
    ];
    return $this->createOrGetCustomGroup($params);
  }

  public function getCustomGroup_InformationsReligion() {
    $params = [
      'name' => 'informations_religion',
      'title' => 'Information Religion',
      'extends' => 'Individual',
      /* ??'extends_entity_column_value' => [
        'ministre'
      ],*/
      'style' => 'Inline',
      'collapse_display' => '0',
      'weight' => '2',
      'is_active' => '1',
      'table_name' => 'civicrm_value_informations_religion',
      'is_multiple' => '0',
      'collapse_adv_display' => '0',
      'is_reserved' => '0',
      'is_public' => '0'
    ];
    return $this->createOrGetCustomGroup($params);
  }

  public function getCustomGroup_Competences() {
    $params = [
      'name' => 'competences',
      'title' => 'Compétences',
      'extends' => 'Individual',
      /* ??'extends_entity_column_value' => [
        'ministre'
      ],*/
      'style' => 'Inline',
      'collapse_display' => '0',
      'weight' => '3',
      'is_active' => '1',
      'table_name' => 'civicrm_value_competences',
      'is_multiple' => '0',
      'collapse_adv_display' => '0',
      'is_reserved' => '0',
      'is_public' => '0'
    ];
    return $this->createOrGetCustomGroup($params);
  }

    public function getCustomGroup_ComplementsFoyer() {
    $params = [
      'name' => 'complements_foyer',
      'title' => 'Informations supplémentaires',
      'extends' => 'Household',
      /* ???'extends_entity_column_value' => [
          'paroisse'
      ],*/
      'style' => 'Inline',
      'collapse_display' => '0',
      'weight' => '1',
      'is_active' => '1',
      'table_name' => 'civicrm_value_complements_foyer',
      'is_multiple' => '0',
      'collapse_adv_display' => '0',
      'is_reserved' => '0',
      'is_public' => '0'
    ];
    return $this->createOrGetCustomGroup($params);
  }


/* FIN DE LA DEFINITION DES GROUPES de CUSTOM FIELD */

/**********************************************************/
/* DEBUT DE LA DEFINITION DES CHAMPS DU GROUPE ETAT CIVIL */
/**********************************************************/
/* Nom de naissance */
  public function getCustomField_etatCivilDetailNomNaissance() {
    $params = [
      'custom_group_id' => $this->getCustomGroup_EtatCivil()['id'],
      'name' => 'nom_naissance',
      'label' => 'Nom de naissance',
      'data_type' => 'String',
      'html_type' => 'Text',
      'is_searchable' => '1',
      'is_search_range' => '0',
      'weight' => '1',
      'is_active' => '1',
      'text_length' => '255',
      'note_columns' => '60',
      'note_rows' => '4',
      'column_name' => 'nom_naissance',
      'in_selector' => '0'
    ];
    return $this->createOrGetCustomField($params);
  }

/* Lieu de naissance */
  public function getCustomField_etatCivilDetailLieuNaissance() {
    $params = [
      'custom_group_id' => $this->getCustomGroup_EtatCivil()['id'],
      'name' => 'lieu_naissance',
      'label' => 'Lieu de naissance',
      'data_type' => 'String',
      'html_type' => 'Text',
      'is_searchable' => '1',
      'is_search_range' => '0',
      'weight' => '2',
      'is_active' => '1',
      'text_length' => '255',
      'note_columns' => '60',
      'note_rows' => '4',
      'column_name' => 'lieu_naissance',
      'in_selector' => '0'
    ];
    return $this->createOrGetCustomField($params);
  }

/* Date de mariage */  
  public function getCustomField_etatCivilDetailDateMariage() {
    $params = [
      'custom_group_id' => $this->getCustomGroup_EtatCivil()['id'],
      'name' => 'date_mariage',
      'label' => 'Date de mariage',
      'data_type' => 'Date',
      'html_type' => 'Select Date',
      'is_searchable' => '1',
      'is_search_range' => '1',
      'weight' => '3',
      'is_active' => '1',
      'text_length' => '255',
      'start_date_years' => '120',
      'end_date_years' => '5',
      'date_format' => 'dd/mm/yy',
      'note_columns' => '60',
      'note_rows' => '4',
      'column_name' => 'date_mariage',
      'in_selector' => '0'
    ];
    return $this->createOrGetCustomField($params);
  }

/* Date de bénédiction nuptiale */  
  public function getCustomField_etatCivilDetailDateBenedictionNuptiale() {
    $params = [
      'custom_group_id' => $this->getCustomGroup_EtatCivil()['id'],
      'name' => 'date_benediction_nuptiale',
      'label' => 'Date de la bénédiction nuptiale',
      'data_type' => 'Date',
      'html_type' => 'Select Date',
      'is_searchable' => '1',
      'is_search_range' => '1',
      'weight' => '4',
      'is_active' => '1',
      'text_length' => '255',
      'start_date_years' => '120',
      'end_date_years' => '5',
      'date_format' => 'dd/mm/yy',
      'note_columns' => '60',
      'note_rows' => '4',
      'column_name' => 'date_benediction_nuptiale',
      'in_selector' => '0'
    ];
    return $this->createOrGetCustomField($params);
  }

/* Paroisse de mariage */  
  public function getCustomField_etatCivilDetailParoisseMariage() {
    $params = [
      'custom_group_id' => $this->getCustomGroup_EtatCivil()['id'],
      'name' => 'paroisse_mariage',
      'label' => 'Paroisse de mariage',
      'data_type' => 'String',
      'html_type' => 'Select',
      'is_searchable' => '1',
      'is_search_range' => '0',
      'weight' => '5',
      'is_active' => '1',
      'text_length' => '255',
      'note_columns' => '60',
      'note_rows' => '4',
      'column_name' => 'paroisse_mariage',
      'option_group_id' => $this->getOptionGroup_ListeParoisses()['id'],      
      'in_selector' => '0'
    ];
    return $this->createOrGetCustomField($params);
  }

/* Verset de mariage */
  public function getCustomField_etatCivilDetailVersetMariage() {
    $params = [
      'custom_group_id' => $this->getCustomGroup_EtatCivil()['id'],
      'name' => 'verset_mariage',
      'label' => 'Verset de mariage',
      'data_type' => 'Memo',
      'html_type' => 'TextArea',
      'is_searchable' => '1',
      'is_search_range' => '0',
      'weight' => '6',
      'is_active' => '1',
      'attributes' => 'rows=4, cols=60',
      'note_columns' => '60',
      'note_rows' => '1',
      'column_name' => 'verset_mariage',
      'in_selector' => '0'
    ];
    return $this->createOrGetCustomField($params);
  }



/* Divorcé ? */  
  public function getCustomField_etatCivilDetailDivorce() {
    $params = [
      'custom_group_id' => $this->getCustomGroup_EtatCivil()['id'],
      'name' => 'divorce',
      'label' => 'Divorcé·e ?',
      'data_type' => 'Boolean',
      'html_type' => 'Radio',
      'is_searchable' => '1',
      'is_search_range' => '0',
      'weight' => '7',
      'is_active' => '1',
      'text_length' => '255',
      'note_columns' => '60',
      'note_rows' => '4',
      'column_name' => 'divorce',
      'in_selector' => '0'
    ];
    return $this->createOrGetCustomField($params);
  }

/* Date de divorce */  
  public function getCustomField_etatCivilDetailDateDivorce() {
    $params = [
      'custom_group_id' => $this->getCustomGroup_EtatCivil()['id'],
      'name' => 'date_divorce',
      'label' => 'Date de divorce',
      'data_type' => 'Date',
      'html_type' => 'Select Date',
      'is_searchable' => '1',
      'is_search_range' => '1',
      'weight' => '8',
      'is_active' => '1',
      'text_length' => '255',
      'start_date_years' => '120',
      'end_date_years' => '5',
      'date_format' => 'dd/mm/yy',
      'note_columns' => '60',
      'note_rows' => '4',
      'column_name' => 'date_divorce',
      'in_selector' => '0'
    ];
    return $this->createOrGetCustomField($params);
  }

/* Date de veuvage */  
  public function getCustomField_etatCivilDetailDateVeuvage() {
    $params = [
      'custom_group_id' => $this->getCustomGroup_EtatCivil()['id'],
      'name' => 'date_veuvage',
      'label' => 'Date de veuvage',
      'data_type' => 'Date',
      'html_type' => 'Select Date',
      'is_searchable' => '1',
      'is_search_range' => '1',
      'weight' => '9',
      'is_active' => '1',
      'text_length' => '255',
      'start_date_years' => '120',
      'end_date_years' => '5',
      'date_format' => 'dd/mm/yy',
      'note_columns' => '60',
      'note_rows' => '4',
      'column_name' => 'date_veuvage',
      'in_selector' => '0'
    ];
    return $this->createOrGetCustomField($params);
  }

/* Date des obsèques */  
  public function getCustomField_etatCivilDetailDateObseques() {
    $params = [
      'custom_group_id' => $this->getCustomGroup_EtatCivil()['id'],
      'name' => 'date_obseques',
      'label' => 'Date des obsèques',
      'data_type' => 'Date',
      'html_type' => 'Select Date',
      'is_searchable' => '1',
      'is_search_range' => '1',
      'weight' => '10',
      'is_active' => '1',
      'text_length' => '255',
      'start_date_years' => '120',
      'end_date_years' => '5',
      'date_format' => 'dd/mm/yy',
      'note_columns' => '60',
      'note_rows' => '4',
      'column_name' => 'date_enterrement',
      'in_selector' => '0'
    ];
    return $this->createOrGetCustomField($params);
  }

/* Paroisse d\'enterrement' */  
  public function getCustomField_etatCivilDetailParoisseEnterrement() {
    $params = [
      'custom_group_id' => $this->getCustomGroup_EtatCivil()['id'],
      'name' => 'paroisse_enterrement',
      'label' => 'Paroisse d\'enterrement',
      'data_type' => 'String',
      'html_type' => 'Select',
      'is_searchable' => '1',
      'is_search_range' => '0',
      'weight' => '11',
      'is_active' => '1',
      'text_length' => '255',
      'note_columns' => '60',
      'note_rows' => '4',
      'column_name' => 'paroisse_enterrement',
      'option_group_id' => $this->getOptionGroup_ListeParoisses()['id'],      
      'in_selector' => '0'
    ];
    return $this->createOrGetCustomField($params);
  }

/* Numéro de Sécurité Sociale */
  public function getCustomField_etatCivilDetailSecuriteSociale() {
    $params = [
      'custom_group_id' => $this->getCustomGroup_EtatCivil()['id'],
      'name' => 'securite_sociale',
      'label' => 'Numéro de Sécurité Sociale',
      'data_type' => 'String',
      'html_type' => 'Text',
      'is_searchable' => '1',
      'is_search_range' => '0',
      'weight' => '12',
      'is_active' => '1',
      'text_length' => '255',
      'note_columns' => '60',
      'note_rows' => '4',
      'column_name' => 'securite_sociale',
      'in_selector' => '0'
    ];
    return $this->createOrGetCustomField($params);
  }

/* Numéro de Guso */
  public function getCustomField_etatCivilDetailGuso() {
    $params = [
      'custom_group_id' => $this->getCustomGroup_EtatCivil()['id'],
      'name' => 'guso',
      'label' => 'Numéro de GUSO',
      'data_type' => 'String',
      'html_type' => 'Text',
      'is_searchable' => '1',
      'is_search_range' => '0',
      'weight' => '13',
      'is_active' => '1',
      'text_length' => '255',
      'note_columns' => '60',
      'note_rows' => '4',
      'column_name' => 'guso',
      'in_selector' => '0'
    ];
    return $this->createOrGetCustomField($params);
  }

/* Status Fonctionnaire ? */  
  public function getCustomField_etatCivilDetailFonctionnaire() {
    $params = [
      'custom_group_id' => $this->getCustomGroup_EtatCivil()['id'],
      'name' => 'fonctionnaire',
      'label' => 'Fonctionnaire ?',
      'data_type' => 'Boolean',
      'html_type' => 'Radio',
      'is_searchable' => '1',
      'is_search_range' => '0',
      'weight' => '14',
      'is_active' => '1',
      'text_length' => '255',
      'note_columns' => '60',
      'note_rows' => '4',
      'column_name' => 'fonctionnaire',
      'in_selector' => '0'
    ];
    return $this->createOrGetCustomField($params);
  }

/*********************************************************************/
/* DEBUT DE LA DEFINITION DES CHAMPS DU GROUPE INFORMATIONS RELIGION */
/*********************************************************************/
/* Religion' */  
  public function getCustomField_religionDetailReligion() {
    $params = [
      'custom_group_id' => $this->getCustomGroup_InformationsReligion()['id'],
      'name' => 'religion',
      'label' => 'Religion',
      'data_type' => 'String',
      'html_type' => 'Select',
      'is_searchable' => '1',
      'is_search_range' => '0',
      'weight' => '1',
      'is_active' => '1',
      'text_length' => '255',
      'note_columns' => '60',
      'note_rows' => '4',
      'column_name' => 'religion',
      'option_group_id' => $this->getOptionGroup_Religion()['id'],      
      'in_selector' => '0'
    ];
    return $this->createOrGetCustomField($params);
  }

/* Date de présentation */  
  public function getCustomField_religionDetailDatePresentation() {
    $params = [
      'custom_group_id' => $this->getCustomGroup_InformationsReligion()['id'],
      'name' => 'date_presentation',
      'label' => 'Date de présentation',
      'data_type' => 'Date',
      'html_type' => 'Select Date',
      'is_searchable' => '1',
      'is_search_range' => '1',
      'weight' => '2',
      'is_active' => '1',
      'text_length' => '255',
      'start_date_years' => '120',
      'end_date_years' => '5',
      'date_format' => 'dd/mm/yy',
      'note_columns' => '60',
      'note_rows' => '4',
      'column_name' => 'date_presentation',
      'in_selector' => '0'
    ];
    return $this->createOrGetCustomField($params);
  }

/* Paroisse de présentation */  
  public function getCustomField_religionDetailParoissePresentation() {
    $params = [
      'custom_group_id' => $this->getCustomGroup_InformationsReligion()['id'],
      'name' => 'paroisse_presentation',
      'label' => 'Paroisse de présentation',
      'data_type' => 'String',
      'html_type' => 'Select',
      'is_searchable' => '1',
      'is_search_range' => '0',
      'weight' => '3',
      'is_active' => '1',
      'text_length' => '255',
      'note_columns' => '60',
      'note_rows' => '4',
      'column_name' => 'paroisse_presentation',
      'option_group_id' => $this->getOptionGroup_ListeParoisses()['id'],      
      'in_selector' => '0'
    ];
    return $this->createOrGetCustomField($params);
  }

/* Date de baptême */  
  public function getCustomField_religionDetailDateBapteme() {
    $params = [
      'custom_group_id' => $this->getCustomGroup_InformationsReligion()['id'],
      'name' => 'date_bapteme',
      'label' => 'Date de baptême',
      'data_type' => 'Date',
      'html_type' => 'Select Date',
      'is_searchable' => '1',
      'is_search_range' => '1',
      'weight' => '4',
      'is_active' => '1',
      'text_length' => '255',
      'start_date_years' => '120',
      'end_date_years' => '5',
      'date_format' => 'dd/mm/yy',
      'note_columns' => '60',
      'note_rows' => '4',
      'column_name' => 'date_bapteme',
      'in_selector' => '0'
    ];
    return $this->createOrGetCustomField($params);
  }

/* Paroisse de baptême */  
  public function getCustomField_religionDetailParoisseBapteme() {
    $params = [
      'custom_group_id' => $this->getCustomGroup_InformationsReligion()['id'],
      'name' => 'paroisse_bapteme',
      'label' => 'Paroisse de baptême',
      'data_type' => 'String',
      'html_type' => 'Select',
      'is_searchable' => '1',
      'is_search_range' => '0',
      'weight' => '5',
      'is_active' => '1',
      'text_length' => '255',
      'note_columns' => '60',
      'note_rows' => '4',
      'column_name' => 'paroisse_bapteme',
      'option_group_id' => $this->getOptionGroup_ListeParoisses()['id'],      
      'in_selector' => '0'
    ];
    return $this->createOrGetCustomField($params);
  }

/* Verset de baptême */
  public function getCustomField_religionDetailVersetBapteme() {
    $params = [
      'custom_group_id' => $this->getCustomGroup_InformationsReligion()['id'],
      'name' => 'verset_bapteme',
      'label' => 'Verset de baptême',
      'data_type' => 'Memo',
      'html_type' => 'TextArea',
      'is_searchable' => '1',
      'is_search_range' => '0',
      'weight' => '6',
      'is_active' => '1',
      'attributes' => 'rows=4, cols=60',
      'note_columns' => '60',
      'note_rows' => '1',
      'column_name' => 'verset_bapteme',
      'in_selector' => '0'
    ];
    return $this->createOrGetCustomField($params);
  }

/* Date de confirmation */  
  public function getCustomField_religionDetailDateConfirmation() {
    $params = [
      'custom_group_id' => $this->getCustomGroup_InformationsReligion()['id'],
      'name' => 'date_confirmation',
      'label' => 'Date de confirmation',
      'data_type' => 'Date',
      'html_type' => 'Select Date',
      'is_searchable' => '1',
      'is_search_range' => '1',
      'weight' => '7',
      'is_active' => '1',
      'text_length' => '255',
      'start_date_years' => '120',
      'end_date_years' => '5',
      'date_format' => 'dd/mm/yy',
      'note_columns' => '60',
      'note_rows' => '4',
      'column_name' => 'date_confirmation',
      'in_selector' => '0'
    ];
    return $this->createOrGetCustomField($params);
  }

/* Paroisse de confirmation */  
  public function getCustomField_religionDetailParoisseConfirmation() {
    $params = [
      'custom_group_id' => $this->getCustomGroup_InformationsReligion()['id'],
      'name' => 'paroisse_confirmation',
      'label' => 'Paroisse de confirmation',
      'data_type' => 'String',
      'html_type' => 'Select',
      'is_searchable' => '1',
      'is_search_range' => '0',
      'weight' => '8',
      'is_active' => '1',
      'text_length' => '255',
      'note_columns' => '60',
      'note_rows' => '4',
      'column_name' => 'paroisse_confirmation',
      'option_group_id' => $this->getOptionGroup_ListeParoisses()['id'],      
      'in_selector' => '0'
    ];
    return $this->createOrGetCustomField($params);
  }

/* Verset de confirmation */
  public function getCustomField_religionDetailVersetConfirmation() {
    $params = [
      'custom_group_id' => $this->getCustomGroup_InformationsReligion()['id'],
      'name' => 'verset_confirmation',
      'label' => 'Verset de confirmation',
      'data_type' => 'Memo',
      'html_type' => 'TextArea',
      'is_searchable' => '1',
      'is_search_range' => '0',
      'weight' => '9',
      'is_active' => '1',
      'attributes' => 'rows=4, cols=60',
      'note_columns' => '60',
      'note_rows' => '1',
      'column_name' => 'verset_confirmation',
      'in_selector' => '0'
    ];
    return $this->createOrGetCustomField($params);
  }

/***********************************************************/
/* DEBUT DE LA DEFINITION DES CHAMPS DU GROUPE COMPETENCES */
/***********************************************************/
/* Compétences Instrument de musique */  
  public function getCustomField_competencesDetailMusiqueInstrument() {
    $params = [
      'custom_group_id' => $this->getCustomGroup_Competences()['id'],
      'name' => 'musique_instrument',
      'label' => 'Musique : instrument',
      'data_type' => 'String',
      'html_type' => 'Multi-Select',
      'is_searchable' => '1',
      'is_search_range' => '0',
      'weight' => '20',
      'is_active' => '1',
      'text_length' => '255',
      'note_columns' => '60',
      'note_rows' => '4',
      'column_name' => 'musique_instrument',
      'option_group_id' => $this->getOptionGroup_Instruments()['id'],      
      'in_selector' => '0'
    ];
    return $this->createOrGetCustomField($params);
  }

/* Compétences Chant, voix */  
  public function getCustomField_competencesDetailMusiqueChant() {
    $params = [
      'custom_group_id' => $this->getCustomGroup_Competences()['id'],
      'name' => 'musique_chant',
      'label' => 'Musique : chant',
      'data_type' => 'String',
      'html_type' => 'Select',
      'is_searchable' => '1',
      'is_search_range' => '0',
      'weight' => '21',
      'is_active' => '1',
      'text_length' => '255',
      'note_columns' => '60',
      'note_rows' => '4',
      'column_name' => 'musique_chant',
      'option_group_id' => $this->getOptionGroup_VoixChant()['id'],      
      'in_selector' => '0'
    ];
    return $this->createOrGetCustomField($params);
  }

/**********************************************************************************/
/* DEBUT DE LA DEFINITION DES CHAMPS DU GROUPE INFORMATIONS SUPPLEMENTAIRES FOYER */
/**********************************************************************************/
/* Quartier (distribution, visiteurs, ...)' */  
  public function getCustomField_complements_foyerDetailQuartier() {
    $params = [
      'custom_group_id' => $this->getCustomGroup_ComplementsFoyer()['id'],
      'name' => 'quartier',
      'label' => 'Quartier (distribution, visiteurs, ...)',
      'data_type' => 'String',
      'html_type' => 'Select',
      'is_searchable' => '1',
      'is_search_range' => '0',
      'weight' => '1',
      'is_active' => '1',
      'text_length' => '255',
      'note_columns' => '60',
      'note_rows' => '4',
      'column_name' => 'quartier',
      'option_group_id' => $this->getOptionGroup_Quartier()['id'],      
      'in_selector' => '0'
    ];
    return $this->createOrGetCustomField($params);
  }




/***********************************************/
/* DEBUT DE LA DEFINITION DES TYPES DE MEMBRES */
/***********************************************/
/* Electeur */  
  public function getMembershipType_Electeur() {
    $params = [
      'domain_id' => '1',
      'name' => 'Electeur·trice',
      'description' => 'Personne inscrite sur la liste électorale de la paroisse',
      'member_of_contact_id' => '1', // Contact de référence
      'financial_type_id' => '2', // Cotisation des Membres
      'minimum_fee' => '0.000000000',
      'duration_unit' => 'lifetime',
      'duration_interval' => '1',
      'period_type' => 'rolling',
      'visibility' => 'Admin',
      'weight' => '1',
      'auto_renew' => '0',
      'is_active' => '1',
      'contribution_type_id' => '2' // Cotisation variable ?
    ];
    return $this->createOrGetMembershipType($params);
  }

/* Inscrit Enfant */  
  public function getMembershipType_InscritEnfant() {
    $params = [
      'domain_id' => '1',
      'name' => 'Inscrit·e Enfant',
      'description' => 'Enfant inscrit à la paroisse, sans être électeur',
      'member_of_contact_id' => '1', // Contact de référence
      'financial_type_id' => '2', // Cotisation des Membres
      'minimum_fee' => '0.000000000',
      'duration_unit' => 'lifetime',
      'duration_interval' => '1',
      'period_type' => 'rolling',
      'visibility' => 'Admin',
      'weight' => '2',
      'auto_renew' => '0',
      'is_active' => '1',
      'contribution_type_id' => '2' // Cotisation variable ?
    ];
    return $this->createOrGetMembershipType($params);
  }

/* Ami de la paroisse */  
  public function getMembershipType_AmiParoisse() {
    $params = [
      'domain_id' => '1',
      'name' => 'Ami·e de la paroisse',
      'description' => 'Personne non inscrite à la paroisse, et participant aux activités',
      'member_of_contact_id' => '1', // Contact de référence
      'financial_type_id' => '2', // Cotisation des Membres
      'minimum_fee' => '0.000000000',
      'duration_unit' => 'lifetime',
      'duration_interval' => '1',
      'period_type' => 'rolling',
      'visibility' => 'Admin',
      'weight' => '3',
      'auto_renew' => '0',
      'is_active' => '1',
      'contribution_type_id' => '2' // Cotisation variable ?
    ];
    return $this->createOrGetMembershipType($params);
  }

/* Pas intéressé */  
  public function getMembershipType_PasInteresse() {
    $params = [
      'domain_id' => '1',
      'name' => 'Pas intéressé·e',
      'description' => 'Personne pas intéressée par les informations de la paroisse',
      'member_of_contact_id' => '1', // Contact de référence
      'financial_type_id' => '2', // Cotisation des Membres
      'minimum_fee' => '0.000000000',
      'duration_unit' => 'lifetime',
      'duration_interval' => '1',
      'period_type' => 'rolling',
      'visibility' => 'Admin',
      'weight' => '2',
      'auto_renew' => '0',
      'is_active' => '1',
      'contribution_type_id' => '2' // Cotisation variable ?
    ];
    return $this->createOrGetMembershipType($params);
  }



 /*******************************************/
 /* DEFINITION DES OPTIONS DE CUSTOM FIELDS */ 
 /*******************************************/
/* Définition des options pour le champ Paroisse */  
  public function getOptionGroup_ListeParoisses() {
    $params = [
      'name' => 'liste_paroisses',
      'title' => 'Liste des paroisses',
      'data_type' => 'String',
      'is_reserved' => '0',
      'is_active' => '1',
      'is_locked' => '0'  /* PARAMETRE A REVOIR ??*/
    ];
    $options = [
      'Bischwiller',
      'Illkirch',
      'Keskastel',
      'Riquewihr',
      'Strasbourg - Le Bouclier',
      'Strasbourg - Saint Guillaume',
      'Autres'
    ];
    return $this->createOrGetOptionGroup($params, $options, 'Actif');
  }

/* Définition des options pour le Champ Religion */
  public function getOptionGroup_Religion() {
    $params = [
      'name' => 'religion',
      'title' => 'Religion',
      'data_type' => 'String',
      'is_reserved' => '0',
      'is_active' => '1',
      'is_locked' => '0'
    ];
    $options = [
      'Protestante',
      'Catholique',
      'Juive',
      'Musulmane'];
    return $this->createOrGetOptionGroup($params, $options);
  }
/* Définition des options pour le Champ Instrument */
  public function getOptionGroup_Instruments() {
    $params = [
      'name' => 'instruments',
      'title' => 'Instruments de musique',
      'data_type' => 'String',
      'is_reserved' => '0',
      'is_active' => '1',
      'is_locked' => '0'
    ];
    $options = [
      'Accordéon',
      'Basson',
      'Clarinette',
      'Clavecin',
      'Contre-basse',
      'Cor',
      'Flûte à bec',
      'Flûte traversière',
      'Guitare',
      'Harpe',
      'Hautbois',
      'Orgue',
      'Piano',
      'Saxophone',
      'Trompette',
      'Violon',
      'Violon alto',
      'Violoncelle',
      'Timbale'
      ];
    return $this->createOrGetOptionGroup($params, $options);
  }

/* Définition des options pour le Champ Voix / Chant */
  public function getOptionGroup_VoixChant() {
    $params = [
      'name' => 'voix_chant',
      'title' => 'Chant : voix',
      'data_type' => 'String',
      'is_reserved' => '0',
      'is_active' => '1',
      'is_locked' => '0'
    ];
    $options = [
      'Alto',
      'Soprane',
      'Ténor',
      'Basse'];
    return $this->createOrGetOptionGroup($params, $options);
  }

/* Définition des options pour le Champ Quartier (définitions de départ) */
  public function getOptionGroup_Quartier() {
    $params = [
      'name' => 'quartier',
      'title' => 'Quartier (distribution, visiteurs, ....)',
      'data_type' => 'String',
      'is_reserved' => '0',
      'is_active' => '1',
      'is_locked' => '0'
    ];
    $options = [
      'Nord',
      'Sud',
      'Est',
      'Ouest'];
    return $this->createOrGetOptionGroup($params, $options);
  }



 /**********************************/
 /* CREATION DES DIFFERENTS CHAMPS */
 /**********************************/ 
/* Création des types de relation */  
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

/* Création des types de Membres */
  private function createOrGetMembershipType($params) {
    try {
      $memType = civicrm_api3('MembershipType', 'getsingle', [
        'name' => $params['name'],
      ]);
    }
    catch (Exception $e) {
      $memType = civicrm_api3('MembershipType', 'create', $params);
    }

    return $memType;
  }

/* Création des groupes de Custom Fields */
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
/* Création des champs dans les Custom Fields */
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
/* Création des options dans les champs */
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
/*************************/
/*  PARAMETRAGES GLOBAUX */
/*************************/
/* Définition des formats de date */
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
/* Définition des formats monétaires */
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
/* Définition des formats d'adresses */
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

/* A REVOIR */

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