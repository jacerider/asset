<?php

class assetWidgetCaption extends assetWidget {

  public function instanceDefaults(){
    return array(
      'caption' => '',
    );
  }

  public function instanceForm() {
    $form = array();
    $settings = $this->getFormSettings();
    $values = $this->getValues();
    $form['caption'] = array(
      '#type' => 'textfield',
      '#title' => t('Caption'),
      '#size' => 60,
      '#maxlength' => 256,
      '#weight' => 1,
      '#default_value' => !empty($values['caption']) ? $values['caption'] : '',
    );
    return $form;
  }

  public function instanceRender(&$vars) {
    $values = $this->getValues();
    if(!empty($values['caption'])){
      $vars['content']['#attached']['css'][] = drupal_get_path('module', 'asset') . '/plugins/widget/css/assetWidgetCaption.css';
      $vars['classes_array'][] = 'asset-has-caption';
      $vars['content']['caption'] = array(
        '#markup' => '<div class="asset-caption">'.$values['caption'].'</div>',
        '#weight' => 90
      );
    }
  }

}
