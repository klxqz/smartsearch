<?php

class shopSmartsearchPluginBackendSaveController extends waJsonController {

    protected $tmp_path = 'plugins/smartsearch/templates/Smartsearch.html';
    protected $plugin_id = array('shop', 'smartsearch');

    public function execute() {
        try {
            $app_settings_model = new waAppSettingsModel();
            $shop_smartsearch = waRequest::post('shop_smartsearch');
            foreach ($shop_smartsearch as $name => $value) {
                $app_settings_model->set($this->plugin_id, $name, $value);
            }



            if (waRequest::post('reset_tpl')) {
                $template_path = wa()->getDataPath($this->tmp_path, false, 'shop', true);
                @unlink($template_path);
            } else {
                $post_template = waRequest::post('template');
                if (!$post_template) {
                    throw new waException('Не определён шаблон');
                }

                $template_path = wa()->getDataPath($this->tmp_path, false, 'shop', true);
                if (!file_exists($template_path)) {
                    $template_path = wa()->getAppPath($this->tmp_path, 'shop');
                }

                $template = file_get_contents($template_path);
                if ($template != $post_template) {
                    $template_path = wa()->getDataPath($this->tmp_path, false, 'shop', true);

                    $f = fopen($template_path, 'w');
                    if (!$f) {
                        throw new waException('Не удаётся сохранить шаблон. Проверьте права на запись ' . $template_path);
                    }
                    fwrite($f, $post_template);
                    fclose($f);
                }
            }

            $this->response['message'] = "Сохранено";
        } catch (Exception $e) {
            $this->setError($e->getMessage());
        }
    }

}
