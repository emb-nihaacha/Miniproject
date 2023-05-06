<?php
/**
 * Copyright © Magento, Inc. All rights reserved.
 * See COPYING.txt for license details.
 */
namespace Embitel\Orderstatus\Controller\Adminhtml\Deliver;

use Magento\Framework\App\Action\Action;
use Magento\Framework\App\Action\Context;
use Magento\Framework\App\ResponseInterface;
use Magento\Framework\Controller\Result\RedirectFactory;

class Deliver extends Action
{
   /**
    * @var \Magento\Framework\Controller\Result\JsonFactory
    */
    protected $resultJsonFactory;  
    protected $_orderRepository ;
    
   
    public function __construct(
         Context $context,
         \Magento\Sales\Model\OrderRepository $orderRepository,
         \Magento\Framework\Controller\Result\JsonFactory $resultJsonFactory,
         \Magento\Framework\Controller\Result\RedirectFactory $resultRedirectFactory
           ) 
    {
        parent::__construct($context);
        $this->resultJsonFactory = $resultJsonFactory;
        $this->_orderRepository = $orderRepository;
        $this->resultRedirectFactory = $resultRedirectFactory;
    }  
    
   /**
    * Dispatch request
    *
    * @return \Magento\Framework\Controller\ResultInterface|ResponseInterface
    * @throws \Magento\Framework\Exception\NotFoundException
    */
   
    public function execute()
    {
        $order_id = $this->getRequest()->getParam('order_id');

        $order = $this->_orderRepository->get($order_id);
      
        $orderState = 'delivered'; 
        $order->setState($orderState)->setStatus($orderState)->save();
 
        $message = __('Order status has been updated as DELIVERED');
        $this->messageManager->addSuccessMessage($message);
        

        $resultRedirect = $this->resultRedirectFactory->create();
        $resultRedirect->setPath('sales/order/view', ['order_id' => $order_id]);
        return $resultRedirect;
}


}

    
    

   





    

    