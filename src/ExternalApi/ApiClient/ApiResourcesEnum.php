<?php

namespace App\ExternalApi\ApiClient;

enum ApiResourcesEnum: string
{
    case SHOP_PRODUCT_SEARCH = 'shop.product.search';
    case SHOP_CUSTOMER_ADD = 'shop.customer.add';
}
