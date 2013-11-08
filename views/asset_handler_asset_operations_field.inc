<?php

/**
 * This field handler aggregates operations that can be done on a asset
 * under a single field providing a more flexible way to present them in a view
 */
class asset_handler_asset_operations_field extends views_handler_field {
  function construct() {
    parent::construct();

    $this->additional_fields['id'] = 'id';
  }

  function query() {
    $this->ensure_my_table();
    $this->add_additional_fields();
  }

  function render($values) {

    $links = menu_contextual_links('asset', 'admin/content/assets/asset', array($this->get_value($values, 'id')));

    if (!empty($links)) {
      return theme('links', array('links' => $links, 'attributes' => array('class' => array('links', 'inline', 'operations'))));
    }
  }
}