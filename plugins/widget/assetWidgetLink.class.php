<?php

class assetWidgetLink extends assetWidget {

  public function instanceForm() {
    $form = array();
    $settings = $this->getFormSettings();
    $values = $this->getValues();

    $form['link'] = array(
      '#id' => 'instance-asset-link',
      '#type' => 'textfield',
      '#title' => t('Link URL'),
      '#size' => 60,
      '#maxlength' => 128,
      '#weight' => 2,
      '#default_value' => !empty($values['link']) ? $values['link'] : '',
    );

    if(module_exists('linkit')){

      $plugins = linkit_profile_field_load_all();
      if(!empty($plugins)){
        // Load the profile.
        $profile = array_pop($plugins);
        // Load the insert plugin for the profile.
        $insert_plugin = linkit_insert_plugin_load($profile->data['insert_plugin']['plugin']);

        $element = &$form['link'];

        // Set the field ID.
        $field_id = $element['#id'];

        $js_settings = array(
          'helper' => 'field',
          'source' => $field_id,
          'profile' => $profile->name,
          'insertPlugin' => $profile->data['insert_plugin']['plugin'],
        );

        // Attach js files and settings Linkit needs.
        $element['#attached']['library'][] = array('linkit', 'base');
        $element['#attached']['library'][] = array('linkit', 'field');
        $element['#attached']['js'][] = $insert_plugin['javascript'];
        // $element['#attached']['js'][] = $field_js;

        $element['#attached']['js'][] = array(
          'type' => 'setting',
          'data' => array(
            'linkit' => array('fields' => array($js_settings)),
          ),
        );

        $button_text = !empty($instance['settings']['linkit']['button_text']) ? $instance['settings']['linkit']['button_text'] : t('Search Local Content');
        $element['#field_suffix'] = '<a class="button tiny expand secondary linkit-field-button linkit-field-' . $field_id . '" href="#"><i class="fa fa-search"></i> ' . $button_text . '</a>';
      }
    }

    $form['new'] = array(
      '#type' => 'checkbox',
      '#title' => t('Open link in a new window'),
      '#id' => 'exo-link-new',
      '#weight' => 3,
      '#default_value' => !empty($values['new']) ? $values['new'] : '',
      '#states' => array(
        'visible' => array(
          ':input[name="data[link]"]' => array('filled' => TRUE),
        ),
      ),
    );
    return $form;
  }

  public function instanceRender(&$vars) {
    $values = $this->getValues();
    if(!empty($values['link'])){
      $attributes = array();
      $attributes['href'] = url($values['link']);
      if(!empty($values['new'])){
        $attributes['target'] = '_blank';
      }
      $vars['content']['link_prefix'] = array(
        '#markup' => '<a '.drupal_attributes($attributes).'>',
        '#weight' => -100
      );
      $vars['content']['link_suffix'] = array(
        '#markup' => '</a>',
        '#weight' => 100
      );
    }
  }

}
