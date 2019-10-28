<?php
namespace AlexeyYermakov\ContactUs\Controller\Adminhtml\Record;

use AlexeyYermakov\ContactUs\Api\Data\RecordInterface;
use AlexeyYermakov\ContactUs\Api\RecordRepositoryInterface;
use Exception;
use Magento\Backend\App\Action;
use Magento\Framework\Controller\ResultInterface;
use Magento\Framework\Exception\LocalizedException;

/**
 * Class Save saving only record status
 * all other data will not be changed
 *
 * @package AlexeyYermakov\ContactUs\Controller\Adminhtml\Record
 * @author Alexey Yermakov slims.alex@gmail.com
 */
class SavePost extends Action
{
    /**
     * @see _isAllowed()
     */
    const ADMIN_RESOURCE = 'AlexeyYermakov_ContactUs::record';

    /**
     * @var RecordRepositoryInterface
     */
    private $recordRepository;

    /**
     * SavePost constructor.
     *
     * @param Action\Context $context
     * @param RecordRepositoryInterface $recordRepository
     */
    public function __construct(
        Action\Context $context,
        RecordRepositoryInterface $recordRepository
    ) {
        parent::__construct($context);
        $this->recordRepository = $recordRepository;
    }

    /**
     * @return ResultInterface
     */
    public function execute(): ResultInterface
    {
        $resultRedirect = $this->resultRedirectFactory->create();
        $requestData = $this->getRequest()->getParams();
        try {
            $recordId = isset($requestData['general'][RecordInterface::RECORD_ID])
                ? (int)$requestData['general'][RecordInterface::RECORD_ID]
                : null;
            if ($recordId === null) {
                throw new LocalizedException(__('Wrong request.'));
            }
            $recordStatus = (int)$requestData['general'][RecordInterface::STATUS];
            if (!in_array($recordStatus, [RecordInterface::STATUS_ANSWERED, RecordInterface::STATUS_UNANSWERED])) {
                throw new LocalizedException(__('You try set wrong status for record.'));
            }
            $record = $this->recordRepository->getById($recordId);
            $record->setStatus($recordStatus);
            $this->recordRepository->save($record);
            $this->messageManager->addSuccessMessage(__('The Record has been saved.'));
            $resultRedirect->setPath('contactus/index/index');
        } catch (Exception $e) {
            $this->messageManager->addErrorMessage($e->getMessage());
            $resultRedirect->setPath('contactus/record/view', [
                RecordInterface::RECORD_ID => $recordId,
                '_current'                 => true,
            ]);
        }

        return $resultRedirect;
    }
}
