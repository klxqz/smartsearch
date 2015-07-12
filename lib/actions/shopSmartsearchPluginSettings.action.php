<?php

class shopSmartsearchPluginSettingsAction extends waViewAction {

    protected $tmp_path = 'plugins/smartsearch/templates/Smartsearch.html';
    protected $plugin_id = array('shop', 'smartsearch');
    protected $themes = array(
        'base',
        'black-tie',
        'blitzer',
        'cupertino',
        'dark-hive',
        'dot-luv',
        'eggplant',
        'excite-bike',
        'flick',
        'hot-sneaks',
        'humanity',
        'le-frog',
        'mint-choc',
        'overcast',
        'pepper-grinder',
        'redmond',
        'smoothness',
        'south-street',
        'start',
        'sunny',
        'swanky-purse',
        'trontastic',
        'ui-darkness',
        'ui-lightness',
        'vader',
    );

    public function execute() {
        $app_settings_model = new waAppSettingsModel();
        $settings = $app_settings_model->get($this->plugin_id);
        $change_tpl = false;
        $template_path = wa()->getDataPath($this->tmp_path, false, 'shop', true);
        if (file_exists($template_path)) {
            $change_tpl = true;
        } else {
            $template_path = wa()->getAppPath($this->tmp_path, 'shop');
        }
        $template = file_get_contents($template_path);
        $this->view->assign('settings', $settings);
        $this->view->assign('themes', $this->themes);
        $this->view->assign('template', $template);
        $this->view->assign('change_tpl', $change_tpl);
    }

}
