<?php
namespace Drupal\dashboard_expand\Controller;

use Drupal\Core\Controller\ControllerBase;
class dashboardExpandController extends ControllerBase {

  public function content() {
    return [
      '#markup' => 'this is Dashborad',
    ];
  }
}