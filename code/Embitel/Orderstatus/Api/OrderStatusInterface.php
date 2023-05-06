<?php
namespace Embitel\Orderstatus\Api;

interface OrderStatusInterface
{
    /**
     * Update order status
     *
     * @api
     * @param string $order_id
     * @return bool
     */
    public function updateOrderStatus($order_id);
}
