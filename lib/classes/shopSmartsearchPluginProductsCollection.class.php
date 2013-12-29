<?php

class shopSmartsearchPluginProductsCollection extends shopProductsCollection {

    public function getPriceRange($categoryIds) {
        if ($this->filtered) {
            return;
        }
        $this->where[] = '`category_id` IN (' . implode(',', $categoryIds) . ')';
        $this->filtered = true;
    }

}
