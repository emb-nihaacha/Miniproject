<?php
/**
 * Copyright © Magento, Inc. All rights reserved.
 * See COPYING.txt for license details.
 */
namespace Embitel\Orderstatus\Model;

use Magento\Framework\App\Action\Action;
use Magento\Framework\App\Action\Context;
use Magento\Framework\App\ResponseInterface;
use Magento\Framework\Controller\Result\JsonFactory;

class StatusService implements \Embitel\Orderstatus\Api\OrderStatusInterface
{
    /**
     * @var \Magento\Sales\Model\OrderFactory
     */
    protected $orderFactory;

    /**
     * @var \Magento\Framework\Controller\Result\JsonFactory
     */
    protected $resultJsonFactory;
  
    public function __construct(
        \Magento\Sales\Model\OrderFactory $orderFactory,
        \Magento\Framework\Controller\Result\JsonFactory $resultJsonFactory
    ) 
    {
        $this->orderFactory = $orderFactory;
        $this->resultJsonFactory = $resultJsonFactory;
    }

    /**
     * Update order status by increment ID
     *
     * @param string $order_id
     * @return array
     * @throws \Exception
     */
    public function updateOrderStatus($order_id)
    {
        try {
            $order = $this->orderFactory->create()->loadByIncrementId($order_id);

            if (!$order->hasInvoices() || !$order->hasShipments()) {
                throw new \Exception("Cannot update order status to Delivered without creating invoice and shipment");
            }

            $orderState = 'delivered'; 
            $order->setState($orderState)->setStatus($orderState)->save();
            
            return [
                'success' => true
            ];
        } catch (\Exception $e) {
            throw new \Exception($e->getMessage());
        }
    }
}
