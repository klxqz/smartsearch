<?php

class shopSmartsearchPlugin extends shopPlugin {

    public function frontendHead() {

        if (!$this->getSettings('status')) {
            return false;
        }
        $view = wa()->getView();
        $view->assign('selector', $this->getSettings('autocomplete_selector'));
        $view->assign('minLength', $this->getSettings('autocomplete_minLength'));
        $view->assign('autocomplete_width', $this->getSettings('autocomplete_width'));
        $view->assign('smartsearch_theme', $this->getSettings('theme'));
        $view->assign('autocomplete_text_color', $this->getSettings('text_color'));
        $view->assign('autocomplete_text_color_hover', $this->getSettings('autocomplete_text_color_hover'));

        $view->assign('autocomplete_price_color', $this->getSettings('price_color'));
        $template_path = wa()->getAppPath('plugins/smartsearch/templates/Smartsearch.html', 'shop');
        $html = $view->fetch($template_path);
        return $html;
    }

}
