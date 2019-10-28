<?php
namespace AlexeyYermakov\ContactUs\Model;

use AlexeyYermakov\ContactUs\Api\Data\RecordInterface;
use AlexeyYermakov\ContactUs\Model\ResourceModel\Record as RecordResourceModel;
use Magento\Framework\Model\AbstractExtensibleModel;

/**
 * Class ContactUs
 *
 * @package AlexeyYermakov\ContactUs\Model
 * @author Alexey Yermakov slims.alex@gmail.com
 */
class Record extends AbstractExtensibleModel implements RecordInterface
{
    /**
     * Cache tag name
     */
    const CACHE_TAG = 'alexeyyermakov_contactus_record';

    /**
     * @var string
     */
    protected $_cacheTag = 'alexeyyermakov_contactus_record';

    /**
     * @var string
     */
    protected $_eventPrefix = 'alexeyyermakov_contactus_record';

    /**
     * @return array
     */
    public function getIdentities()
    {
        return [self::CACHE_TAG . '_' . $this->getRecordId()];
    }

    /**
     * Get record id
     *
     * @return int
     */
    public function getRecordId(): int
    {
        return $this->getData(self::RECORD_ID);
    }

    public function getDefaultValues()
    {
        $values = [];

        return $values;
    }

    /**
     * Get record email
     *
     * @return string
     */
    public function getEmail(): string
    {
        return $this->getData(self::EMAIL);
    }

    /**
     * Set record email
     *
     * @param string $email
     * @return void
     */
    public function setEmail($email)
    {
        $this->setData(self::EMAIL, $email);
    }

    /**
     * Get record name
     *
     * @return string
     */
    public function getName(): string
    {
        return $this->getData(self::NAME);
    }

    /**
     * Set record name
     *
     * @param string $name
     * @return void
     */
    public function setName($name)
    {
        $this->setData(self::NAME, $name);
    }

    /**
     * Get record comment
     *
     * @return string
     */
    public function getComment(): string
    {
        return $this->getData(self::COMMENT);
    }

    /**
     * Set record comment
     *
     * @param string $comment
     * @return void
     */
    public function setComment($comment)
    {
        $this->setData(self::COMMENT, $comment);
    }

    /**
     * Get record admin reply
     *
     * @return string
     */
    public function getReply(): ?string
    {
        return $this->getData(self::REPLY);
    }

    /**
     * Set record reply
     *
     * @param string $reply
     * @return void
     */
    public function setReply(string $reply)
    {
        $this->setData(self::REPLY, $reply);
    }

    /**
     * Get record phone number
     *
     * @return string|null
     */
    public function getPhone(): ?string
    {
        return $this->getData(self::PHONE);
    }

    /**
     * Set record phone number
     *
     * @param string|null $phone
     * @return void
     */
    public function setPhone($phone)
    {
        $this->setData(self::PHONE, $phone);
    }

    /**
     * Check if admin replied on this record
     * For new entity should be false
     *
     * @return int
     */
    public function getStatus(): int
    {
        return $this->getData(self::STATUS);
    }

    /**
     * Set status
     *
     * @param int $status
     * @return void
     */
    public function setStatus($status)
    {
        $this->setData(self::STATUS, $status);
    }

    /**
     * Get customer id
     *
     * @return int
     */
    public function getCustomerId(): int
    {
        return $this->getData(self::CUSTOMER_ID);
    }

    /**
     * Customer id (if logged in)
     *
     * @param $customerId
     * @return void
     */
    public function setCustomerId(?int $customerId)
    {
        $this->setData(self::CUSTOMER_ID, $customerId);
    }

    /**
     *
     */
    protected function _construct()
    {
        $this->_init(RecordResourceModel::class);
    }
}
