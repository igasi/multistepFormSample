<?php

namespace Drupal\multistep_form\Form;

use Drupal\Core\Form\FormBase;
use Drupal\Core\Form\FormStateInterface;
use Symfony\Component\DependencyInjection\ContainerInterface;
use Drupal\Core\Entity\EntityManager;

/**
 * Class MultiStepSample.
 *
 * @package Drupal\multistep_form\Form
 */
class MultiStepSample extends FormBase {

  protected $step = 1;

  /**
   * Drupal\Core\Entity\EntityManager definition.
   *
   * @var \Drupal\Core\Entity\EntityManager
   */
  protected $entityManager;
  public function __construct(
    EntityManager $entity_manager
  ) {
    $this->entityManager = $entity_manager;
  }

  public static function create(ContainerInterface $container) {
    return new static(
      $container->get('entity.manager')
    );
  }


  /**
   * {@inheritdoc}
   */
  public function getFormId() {
    return 'multi_step_sample';
  }

  /**
   * {@inheritdoc}
   */
  public function buildForm(array $form, FormStateInterface $form_state) {

    // Step 1
    if($this->step == 1) {

      $form['personal_data'] = [
          '#type' => 'fieldset',
          '#title' => $this->t('Personal data'),
      ];
      $form['personal_data']['first_name'] = [
          '#type' => 'textfield',
          '#title' => $this->t('First Name'),
          '#maxlength' => 64,
          '#size' => 64,
      ];
      $form['personal_data']['last_name'] = [
          '#type' => 'textfield',
          '#title' => $this->t('Last Name'),
          '#maxlength' => 64,
          '#size' => 64,
      ];
      $form['personal_data']['gender'] = [
          '#type' => 'radios',
          '#title' => $this->t('Gender'),
          '#options' => array('Male' => $this->t('Male'), 'Female' => $this->t('Female')),
      ];
    }

    // Step 2
    if($this->step == 2) {

      $form['address_information'] = [
          '#type' => 'fieldset',
          '#title' => $this->t('Address information'),
      ];
      $form['address_information']['address'] = [
          '#type' => 'textfield',
          '#title' => $this->t('Address'),
          '#maxlength' => 64,
          '#size' => 64,
      ];
      $form['address_information']['state'] = [
          '#type' => 'textfield',
          '#title' => $this->t('State'),
          '#maxlength' => 64,
          '#size' => 64,
      ];
      $form['address_information']['city'] = [
          '#type' => 'textfield',
          '#title' => $this->t('City'),
          '#maxlength' => 64,
          '#size' => 64,
      ];
      $form['address_information']['zipcode'] = [
          '#type' => 'textfield',
          '#title' => $this->t('ZipCode'),
          '#maxlength' => 64,
          '#size' => 64,
      ];
    }

    //
    if($this->step < 2) {
      $button_label = $this->t('Next');
    }
    else {
      $button_label = $this->t('Complete!!');
    }

    $form['submit'] = [
        '#type' => 'submit',
        '#value' => $button_label,
    ];

    return $form;
  }

  /**
    * {@inheritdoc}
    */
  public function validateForm(array &$form, FormStateInterface $form_state) {
    parent::validateForm($form, $form_state);
  }

  /**
   * {@inheritdoc}
   */
  public function submitForm(array &$form, FormStateInterface $form_state) {

    // Display result.
    if($this->step < 2 ) {
      $form_state->setRebuild();
      $this->step++;
      drupal_set_message('Step 1 Completed!!');
    }
    else {
      drupal_set_message('Step 2 Completed!!');
      foreach ($form_state->getValues() as $key => $value) {
        drupal_set_message($key . ': ' . $value);
      }
    }


  }

}
