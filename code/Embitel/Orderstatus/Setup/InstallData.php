<?php
namespace Embitel\Orderstatus\Setup;

use Exception;
use Magento\Framework\Exception\AlreadyExistsException;
use Magento\Framework\Setup\InstallDataInterface;
use Magento\Framework\Setup\ModuleContextInterface;
use Magento\Framework\Setup\ModuleDataSetupInterface;
use Magento\Sales\Model\Order;
use Magento\Sales\Model\Order\Status;
use Magento\Sales\Model\Order\StatusFactory;
use Magento\Sales\Model\ResourceModel\Order\Status as StatusResource;
use Magento\Sales\Model\ResourceModel\Order\StatusFactory as StatusResourceFactory;

/**
 * Class InstallData
 */

 class InstallData implements InstallDataInterface

 {
    /**
     * Custom Processing Order-Status code
     */
    const ORDER_STATUS_DELIVERED = 'Delivered';

    /**
     * Custom Processing Order-Status label
     */
    const ORDER_STATUS_DELIVERED_LABEL = 'Delivered';

    /**
     * Status Factory
     *
     * @var StatusFactory
     */
    protected $statusFactory;

    /**
     * Status Resource Factory
     *
     * @var StatusResourceFactory
     */
    protected $statusResourceFactory;

    /**
     * InstallData constructor
     *
     * @param StatusFactory $statusFactory
     * @param StatusResourceFactory $statusResourceFactory
     */
    public function __construct(
        StatusFactory $statusFactory,
        StatusResourceFactory $statusResourceFactory
    ) {
        $this->statusFactory = $statusFactory;
        $this->statusResourceFactory = $statusResourceFactory;
    }

    /**
     * Installs data for a module
     *
     * @param ModuleDataSetupInterface $setup
     * @param ModuleContextInterface $context
     *
     * @return void
     *
     * @throws Exception
     */
    public function install(ModuleDataSetupInterface $setup, ModuleContextInterface $context)
    {
        $this->addNewOrderDeliveredStatus();
        $this->addNewOrderStateAndStatus();
    }

    /**
     * Create new order processing status and assign it to the existent state
     *
     * @return void
     *
     * @throws Exception
     */
    
     protected function addNewOrderDeliveredStatus()
    {
        /** @var StatusResource $statusResource */
        $statusResource = $this->statusResourceFactory->create();
        /** @var Status $status */
        $status = $this->statusFactory->create();
        $status->setData([
            'status' => self::ORDER_STATUS_DELIVERED,
            'label' => self::ORDER_STATUS_DELIVERED_LABEL,
        ]);

        try {
            $statusResource->save($status);
        } catch (AlreadyExistsException $exception) {

            return;
        }

        $status->assignState(Order::STATE_PROCESSING, true, true);
    }

    /**
     * Create new custom order status and assign it to the new custom order state
     *
     * @return void
     *
     * @throws Exception
     */
    
     protected function addNewOrderStateAndStatus()
    {
        /** @var StatusResource $statusResource */
        $statusResource = $this->statusResourceFactory->create();
        /** @var Status $status */
        $status = $this->statusFactory->create();
        $status->setData([
            'status' => self::ORDER_STATUS_DELIVERED,
            'label' => self::ORDER_STATUS_DELIVERED_LABEL,
        ]);

        try {
            $statusResource->save($status);
        } catch (AlreadyExistsException $exception) {

            return;
        }

        $status->assignState(self::ORDER_STATUS_DELIVERED, true, true);
    }
}
