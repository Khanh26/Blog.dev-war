<?php

namespace Drupal\home_expand\Form;

use Drupal\Core\Form\FormBase;
use Drupal\Core\Form\FormStateInterface;
use Drupal\Core\Url;
use Drupal\node\Entity\Node;

class ConfigHomePageForm extends FormBase {

  protected string $title_home_default = 'Home';

  protected string $url_home_default = '/home';

  protected string $id_form = 'config_home_page_form';

  public function getFormId(): string {
    return $this->id_form;
  }

  public function buildForm(array $form, FormStateInterface $form_state): array {
    $form['title_home'] = [
      '#type' => 'textfield',
      '#title' => $this->t('Title:'),
      '#default_value' => $this->title_home_default,
      '#required' => TRUE,
    ];
    $form['actions']['#type'] = 'actions';
    $form['actions']['submit'] = [
      '#type' => 'submit',
      '#value' => $this->t('Create'),
      '#button_type' => 'primary',
    ];
    return $form;
  }

  public function validateForm(array &$form, FormStateInterface $form_state) {
    parent::validateForm($form, $form_state);
  }

  /**
   * @throws \Drupal\Core\Entity\EntityStorageException
   */
  public function submitForm(array &$form, FormStateInterface $form_state) {
    // Create node
    $node = Node::create([
      'type' => 'home_page',
      'title' => $form_state->getValue('title_home'),
      'status' => 1,
    ]);
    $node->save();
    // Get path
    $path = URL::fromRoute('entity.node.canonical', ['node' => $node->id()])
      ->toString();
    // Set <Front>
    \Drupal::service('config.factory')
      ->getEditable('system.site')
      ->set('page.front', $path ?? '/home')
      ->save();
  }
}
