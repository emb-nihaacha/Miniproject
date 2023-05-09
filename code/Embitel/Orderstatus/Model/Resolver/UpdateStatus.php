<?php
namespace Embitel\Orderstatus\Model\Resolver;

use Magento\Framework\GraphQl\Config\Element\Field;
use Magento\Framework\GraphQl\Query\ResolverInterface;
use Magento\Framework\GraphQl\Schema\Type\ResolveInfo;
use Magento\Customer\Model\GroupFactory;
use Magento\Sales\Api\OrderRepositoryInterface;
use Magento\Sales\Model\orderFactory;

class UpdateStatus implements ResolverInterface
{
    protected $_group;
    protected $_orderFactory;
   
    public function __construct(
        GroupFactory $group,
        OrderFactory $orderFactory
    ) {
        $this->_group = $group;
        $this->orderFactory = $orderFactory;
    }
        public function resolve(
        Field $field,
        $context,
        ResolveInfo $info,
        array $value=null,
        array $args=null
    ) {
        try {
            if (empty($args['input']) || empty($args['input']['order_id'])) {
                throw new \Exception("Missing required input data");
            }
            
            
            $order_id = $args['input']['order_id'];
              
            $order = $this->orderFactory->create()->loadByIncrementId($order_id);


            if (!$order->hasInvoices() || !$order->hasShipments()) {
                throw new \Exception("Cannot update order status to Delivered without creating invoice and shipment");
            }

            $orderState = 'delivered';
            $order->setState($orderState)->setStatus($orderState)->save();

            return [
                'order_id' => $order->getIncrementId(),
                'success' => true
            ];
        } catch(\Throwable $th) {
            throw new \Exception($th->getMessage());
        }
    }
}

     
 