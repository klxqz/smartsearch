<?php

$plugin_id = array('shop', 'smartsearch');
$app_settings_model = new waAppSettingsModel();
$app_settings_model->set($plugin_id, 'status', '1');
$app_settings_model->set($plugin_id, 'theme', 'base');
$app_settings_model->set($plugin_id, 'autocomplete_width', 'auto');
$app_settings_model->set($plugin_id, 'autocomplete_selector', '#search');
$app_settings_model->set($plugin_id, 'autocomplete_minLength', '2');
$app_settings_model->set($plugin_id, 'autocomplete_count', '10');
$app_settings_model->set($plugin_id, 'img_size', '48x48');
$app_settings_model->set($plugin_id, 'text_color', '#000000');
$app_settings_model->set($plugin_id, 'text_color_hover', '#000000');
$app_settings_model->set($plugin_id, 'price_color', '#FF0000');
