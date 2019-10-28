<?php
namespace AlexeyYermakov\ContactUs\Model;

use AlexeyYermakov\ContactUs\Api\RecordRepositoryInterface;
use AlexeyYermakov\ContactUs\Model\ResourceModel\Record as RecordResourceModel;
use Codeception\Exception\ConnectionException;
use Exception;
use Magento\Framework\Exception\AlreadyExistsException;
use Magento\Framework\Exception\CouldNotDeleteException;
use Magento\Framework\Exception\CouldNotSaveException;
use Magento\Framework\Exception\NoSuchEntityException;
use Magento\Framework\Exception\ValidatorException;

/**
 * Class ContactRepository
 *
 * @package AlexeyYermakov\ContactUs\Model\ResourceModel
 * @author Alexey Yermakov slims.alex@gmail.com
 */
class RecordRepository implements RecordRepositoryInterface
{
    /**
     * @var RecordFactory
     */
    private $recordFactory;

    /**
     * @var RecordResourceModel
     */
    private $recordResourceModel;

    /**
     * RecordRepository constructor.
     *
     * @param RecordFactory $recordFactory
     * @param RecordResourceModel $recordResourceModel
     */
    public function __construct(
        RecordFactory $recordFactory,
        RecordResourceModel $recordResourceModel
    ) {
        $this->recordFactory = $recordFactory;
        $this->recordResourceModel = $recordResourceModel;
    }

    /**
     * Create new record
     *
     * @param Record $record
     * @return Record
     * @throws AlreadyExistsException
     * @throws CouldNotSaveException
     * @throws NoSuchEntityException
     */
    public function save(Record $record): Record
    {
        try {
            $this->recordResourceModel->save($record);
        } catch (ConnectionException $exception) {
            throw new CouldNotSaveException(
                __('Database connection error'),
                $exception,
                $exception->getCode()
            );
        } catch (CouldNotSaveException $e) {
            throw new CouldNotSaveException(__('Unable to save item'), $e);
        } catch (ValidatorException $e) {
            throw new CouldNotSaveException(__($e->getMessage()));
        }

        return $this->getById($record->getId());
    }

    /**
     * @param $recordId
     * @return Record|mixed
     * @throws NoSuchEntityException
     */
    public function getById($recordId): Record
    {
        $record = $this->recordFactory->create();
        $this->recordResourceModel->load($record, $recordId);
        if (!$record->getId()) {
            throw new NoSuchEntityException(__('Requested item doesn\'t exist'));
        }

        return $record;
    }

    /**
     * @param Record $record
     * @return mixed|void
     * @throws CouldNotDeleteException
     * @throws Exception
     */
    public function delete(Record $record)
    {
        try {
            $this->recordResourceModel->delete($record);
        } catch (ConnectionException $exception) {
            throw new CouldNotDeleteException(
                __('Database connection error'),
                $exception,
                $exception->getCode()
            );
        } catch (CouldNotSaveException $e) {
            throw new CouldNotDeleteException(__('Unable to save item'), $e);
        } catch (ValidatorException $e) {
            throw new CouldNotDeleteException(__($e->getMessage()));
        }
    }
}
