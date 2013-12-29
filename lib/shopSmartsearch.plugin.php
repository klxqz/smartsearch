<?php

class shopSmartsearchPlugin extends shopPlugin {

    public function frontendNav() {
        if ($this->getSettings('default_output')) {
            return shopSmartsearchPlugin::display();
        }
    }

    public function frontendHead() {
        $view = wa()->getView();
        $view->assign('selector', $this->getSettings('autocomplete_selector'));
        $view->assign('minLength', $this->getSettings('autocomplete_minLength'));
        $view->assign('autocomplete_width', $this->getSettings('autocomplete_width'));
        $view->assign('smartsearch_theme', $this->getSettings('theme'));
        $view->assign('autocomplete_text_color', $this->getSettings('text_color'));
        $view->assign('autocomplete_text_color_hover', $this->getSettings('autocomplete_text_color_hover'));

        $view->assign('autocomplete_price_color', $this->getSettings('price_color'));
        $template_path = wa()->getAppPath('plugins/smartsearch/templates/Autocomplete.html', 'shop');
        $html = $view->fetch($template_path);
        return $html;
    }

    public function frontendCategory($categoty) {
        /*
          if ($this->getSettings('default_output')) {
          return shopSmartsearchPlugin::display($categoty);
          }
         * 
         */
    }

    public function display() {
        $category_model = new shopCategoryModel();
        if (waRequest::param('category_id')) {
            $category = $category_model->getById(waRequest::param('category_id'));
        } else {
            $category = $category_model->getByField(waRequest::param('url_type') == 1 ? 'url' : 'full_url', waRequest::param('category_url'));
        }

        if ($category) {
            $tree = $category_model->getTree($category['id']);
        } else {
            $tree = $category_model->getFullTree();
        }
        $categoryIds = array();
        foreach ($tree as $item) {
            $categoryIds[] = $item['id'];
        }
        $price_range = $this->getPriceRange($categoryIds);
        $price_min = waRequest::request('price_min') ? waRequest::request('price_min') : $price_range['min'];
        $price_max = waRequest::request('price_max') ? waRequest::request('price_max') : $price_range['max'];
        $view = wa()->getView();
        $currency = wa('shop')->getConfig()->getCurrency(false);
        $currency_sign = wa()->getConfig()->getCurrencies($currency);
        $view->assign('currency_sign', $currency_sign[$currency]['sign']);
        $view->assign('price_min', $price_min);
        $view->assign('price_max', $price_max);
        $view->assign('price_range', $price_range);
        $template_path = wa()->getDataPath('plugins/smartsearch/templates/Smartsearch.html', false, 'shop', true);
        if (!file_exists($template_path)) {
            $template_path = wa()->getAppPath('plugins/smartsearch/templates/Smartsearch.html', 'shop');
        }
        $html = $view->fetch($template_path);
        return $html;
    }

    public function getPriceRange($categoryIds) {
        $routing = wa()->getRouting();
        $domain = wa()->getConfig()->getDomain();
        $domain_routes = $routing->getByApp('shop');
        if (!isset($domain_routes[$domain])) {
            return false;
        }
        $routes = $domain_routes[$domain];
        $type_ids = array();
        foreach ($routes as $route) {
            if ($route['type_id'] && is_array($route['type_id'])) {
                $type_ids = array_merge($type_ids, $route['type_id']);
            }
        }

        $add_where = '';
        if ($type_ids) {
            $add_where = " AND `sp`.`type_id` IN (" . implode($type_ids) . ") ";
        }
        $db = new waModel();

        $price_range = $db->query("SELECT MAX(`max_price`) as `max`, MIN(`min_price`) as `min`
                            FROM `shop_product` as `sp`
                            LEFT JOIN `shop_category_products` as `scp` ON `sp`.`id` = `scp`.`product_id`
                            WHERE `sp`.`status` = 1 AND
                            (`scp`.`category_id` IN (" . implode(',', $categoryIds) . ") OR
                            `sp`.`category_id` IN (" . implode(',', $categoryIds) . "))   " . $add_where . "
                            LIMIT 0, 1")->fetch();
        $price_range['min'] = round(shop_currency($price_range['min'], null, null, false), 2);
        $price_range['max'] = round(shop_currency($price_range['max'], null, null, false), 2);
        return $price_range;
    }

}
