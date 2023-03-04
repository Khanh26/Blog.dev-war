<?php

namespace Drupal\home_expand\Controller;

use Drupal\Core\Controller\ControllerBase;
use Drupal\Core\Url;
use Symfony\Component\HttpFoundation\RedirectResponse;

class ConfigHomePageController extends ControllerBase {

  /** @var \Drupal\node\Entity\Node $node */
  protected $node;

  /**@var string $content_type */
  protected $content_type = 'home_page';

  public function isNodeHomePage() {
    $query = \Drupal::entityQuery('node')
      ->condition('type', $this->content_type)
      ->accessCheck(TRUE);
    $nids = $query->execute();
    if (empty($nids)) {
      $add_node_form = \Drupal::formBuilder()
        ->getForm('Drupal\home_expand\Form\ConfigHomePageForm');
      return $add_node_form;
    }
    $array = array_reverse($nids);
    $nid = array_pop($array);
    $url = Url::fromRoute('entity.node.edit_form', ['node' => $nid]);
    return new RedirectResponse($url->toString());
  }
}