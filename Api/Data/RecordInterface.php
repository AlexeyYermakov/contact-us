<?php
namespace AlexeyYermakov\ContactUs\Api\Data;

/**
 * Interface ContactDataInterface
 *
 * @package AlexeyYermakov\ContactUs\Api\Data
 */
interface RecordInterface
{
    /**
     * Constants for status
     */
    const STATUS_ANSWERED = 1;
    const STATUS_UNANSWERED = 0;

    /**
     * Constants for keys
     */
    const RECORD_ID = 'record_id';
    const NAME = 'name';
    const EMAIL = 'email';
    const COMMENT = 'comment';
    const REPLY = 'reply';
    const PHONE = 'phone';
    const CUSTOMER_ID = 'customer_id';
    const STATUS = 'status';

    /**
     * Get contact idx
     *
     * @return int
     */
    public function getRecordId(): int;

    /**
     * Get contact email
     *
     * @return string
     */
    public function getEmail(): string;

    /**
     * Set contact email
     *
     * @param string $email
     * @return void
     */
    public function setEmail($email);

    /**
     * Get contact name
     *
     * @return string
     */
    public function getName(): string;

    /**
     * Set contact name
     *
     * @param string $name
     * @return void
     */
    public function setName($name);

    /**
     * Get contact comment
     *
     * @return string
     */
    public function getComment(): string;

    /**
     * Set contact comment
     *
     * @param string $comment
     * @return void
     */
    public function setComment($comment);

    /**
     * Get contact admin reply
     *
     * @return string
     */
    public function getReply(): ?string;

    /**
     * Set contact reply
     *
     * @param string $reply
     * @return void
     */
    public function setReply(string $reply);

    /**
     * Get contact phone number
     *
     * @return string|null
     */
    public function getPhone(): ?string;

    /**
     * Set contact phone number
     *
     * @param string|null $phone
     * @return void
     */
    public function setPhone($phone);

    /**
     * Check if admin replied on this contact
     * For new entity should be false
     *
     * @return int
     */
    public function getStatus(): int;

    /**
     * Set status
     *
     * @param int $status
     * @return void
     */
    public function setStatus($status);

    /**
     * Get customer id
     *
     * @return int
     */
    public function getCustomerId(): int;

    /**
     * Customer id (if logged in)
     *
     * @param $customerId
     * @return void
     */
    public function setCustomerId(?int $customerId);
}
