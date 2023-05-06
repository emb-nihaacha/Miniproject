<?php

/**
 * Copyright © Magento, Inc. All rights reserved.
 * See COPYING.txt for license details.
 */

 namespace Embitel\Orderstatus\Block\Adminhtml\Order;

 use Magento\Sales\Model\ConfigInterface;

/**
 * Adminhtml sales order view
 * @api
 * @SuppressWarnings(PHPMD.CouplingBetweenObjects)
 * @since 100.0.2
 */

 class View extends \Magento\Sales\Block\Adminhtml\Order\View

 {
    protected function _construct()
    {
        
        parent::_construct();
        $order = $this->getOrder();

        if (!$order) 
        {
            return;
        }
     
    /*Hiding the Deliver Button untill the order status has to update as Dispatched*/
    
    if ($order->getStatus() !== 'complete') {
        $this->removeButton('send_notification');
        return;
    }
    
    if ($order->canCreditmemo()) 
    {
            $message = __('Are you sure you want to  change order status?');
            $this->addButton(
            
            'send_notification',
             [
                'label' => __('Deliver'),
                'class' => 'send-email',
                'onclick' => "confirmSetLocation('{$message}','{$this->getDeliverUrl()}')",
                'id' => 'deliver_button'
             ]
                            );
    }


     /*Hiding the Deliver Button after the order status has to update as Delivered*/
    
    if ($order->getStatus() == 'elivered') {
    $this->removeButton('send_notification');
    
    }
    
    }

    
    public function getDeliverUrl()
    {
        return $this->getUrl('orderstatus/deliver/deliver');
    }
}
