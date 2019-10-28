<?php
namespace AlexeyYermakov\ContactUs\Api;

use AlexeyYermakov\ContactUs\Model\Record;
use Magento\Framework\Exception\NoSuchEntityException;

/**
 * Interface RecordRepositoryInterface
 *
 * @package AlexeyYermakov\ContactUs\Api
 */
interface RecordRepositoryInterface
{
    /**
     * Create a record.
     *
     * @param Record $record
     * @return Record
     */
    public function save(Record $record): Record;

    /**
     * @param $recordId
     * @return Record
     * @throws NoSuchEntityException
     */
    public function getById($recordId): Record;

    /**
     * @param Record $record
     * @return mixed
     */
    public function delete(Record $record);
}
