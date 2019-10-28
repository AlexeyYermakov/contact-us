<?php
namespace AlexeyYermakov\ContactUs\Model\ResourceModel;

use AlexeyYermakov\ContactUs\Api\Data\RecordInterface;
use Magento\Framework\Model\ResourceModel\Db\AbstractDb;
use Magento\Framework\Model\ResourceModel\Db\Context;

/**
 * Class Contact
 *
 * @package AlexeyYermakov\ContactUs\Model\ResourceModel
 * @author Alexey Yermakov slims.alex@gmail.com
 */
class Record extends AbstractDb
{
    /**
     * Table name
     */
    const TABLE_NAME = 'ay_contactus_records';

    /**
     * Contact constructor.
     *
     * @param Context $context
     */
    public function __construct(Context $context)
    {
        parent::__construct($context);
    }

    /**
     * @return void
     */
    protected function _construct()
    {
        $this->_init(self::TABLE_NAME, RecordInterface::RECORD_ID);
    }
}
