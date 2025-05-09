<?php

namespace App\ExternalApi\ApiClient;

enum ApiResourcesEnum: string
{
    case SHOP_PRODUCT_SEARCH = 'shop.product.search';
    case SHOP_CUSTOMER_ADD = 'shop.customer.add';
    case SHOP_CUSTOMER_SEARCH = 'shop.customer.search';
    case SHOP_ORDER_ADD = 'shop.order.add';
    case SHOP_ORDER_COMPLETE = 'shop.order.complete';
    case SHOP_ORDER_ACTION = 'shop.order.action';
    case SHOP_ORDER_SEARCH = 'shop.order.search';
}
