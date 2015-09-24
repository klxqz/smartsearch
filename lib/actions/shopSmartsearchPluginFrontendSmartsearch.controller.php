<?php

class shopSmartsearchPluginFrontendSmartsearchController extends waJsonController {

    protected $plugin_id = array('shop', 'smartsearch');

    public function execute() {
        $app_settings_model = new waAppSettingsModel();

        $query = waRequest::get('term');
        $count = $app_settings_model->get($this->plugin_id, 'autocomplete_count');
        $collection = new shopProductsCollection('search/query=' . $query);
        $products = $collection->getProducts('*', 0, $count);
        $result = array();
        foreach ($products as $product) {
            $size = $app_settings_model->get($this->plugin_id, 'img_size');
            $product['value'] = $product['name'];
            $product['price_str'] = shop_currency($product['price']);
            $product['img_url'] = $product['image_id'] ? shopImage::getUrl(array(
                        'id'         => $product['image_id'],
                        'product_id' => $product['id'],
                        'filename'   => $product['image_filename'],
                        'ext'        => $product['ext']), $size) : '';
            array_push($result, $product);
        }

        $this->response = $result;
    }

}
