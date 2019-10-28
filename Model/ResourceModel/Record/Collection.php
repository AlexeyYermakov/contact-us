<?php
namespace AlexeyYermakov\ContactUs\Model\ResourceModel\Record;

use AlexeyYermakov\ContactUs\Api\Data\RecordInterface;
use AlexeyYermakov\ContactUs\Model\Record;
use AlexeyYermakov\ContactUs\Model\ResourceModel\Record as RecordResourceModel;
use Magento\Framework\Model\ResourceModel\Db\Collection\AbstractCollection;

/**
 * Class Collection
 *
 * @package AlexeyYermakov\ContactUs\Model\ResourceModel\Record
 * @author Alexey Yermakov slims.alex@gmail.com
 */
class Collection extends AbstractCollection
{
    /**
     * Define resource model
     *
     * @return void
     */
    protected function _construct()
    {
        $this->_init(Record::class, RecordResourceModel::class);
        $this->_setIdFieldName(RecordInterface::RECORD_ID);
    }
}
