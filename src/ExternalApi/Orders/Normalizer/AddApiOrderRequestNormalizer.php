<?php

namespace App\ExternalApi\Orders\Normalizer;

use App\ExternalApi\Orders\Model\ApiOrderRequestDto;

class AddApiOrderRequestNormalizer
{
    public function normalize(ApiOrderRequestDto $orderDto): array
    {
        $order = [];
        $order['contact_id'] = $orderDto->contactId;
        $order['create_datetime'] = $orderDto->creatDatetime->format('Y-m-d H:i:s');
        $order['params']['force_affiliate'] = $orderDto->forceAffiliate;

        foreach ($orderDto->orderItems as $orderItem) {
            $order['items'][] = [
                'sku_id' => $orderItem->skuId,
                'quantity' => $orderItem->quantity,
            ];
        }

        return $order;
    }
}
