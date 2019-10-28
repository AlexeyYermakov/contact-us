<?php
namespace AlexeyYermakov\ContactUs\Controller\Adminhtml\Record;

use AlexeyYermakov\ContactUs\Api\Data\RecordInterface;
use AlexeyYermakov\ContactUs\Api\RecordRepositoryInterface;
use Exception;
use Magento\Backend\App\Action;
use Magento\Contact\Model\MailInterface;
use Magento\Framework\Controller\ResultInterface;
use Magento\Framework\Exception\LocalizedException;

/**
 * Class ReplyPost
 *
 * @package AlexeyYermakov\ContactUs\Controller\Adminhtml\Record
 * @author Alexey Yermakov slims.alex@gmail.com
 */
class ReplyPost extends Action
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
     * @var MailInterface
     */
    private $mail;

    /**
     * @param Action\Context $context
     * @param RecordRepositoryInterface $recordRepository
     * @param MailInterface $mail
     */
    public function __construct(
        Action\Context $context,
        RecordRepositoryInterface $recordRepository,
        MailInterface $mail
    ) {
        parent::__construct($context);
        $this->recordRepository = $recordRepository;
        $this->mail = $mail;
    }

    /**
     * @return ResultInterface
     */
    public function execute(): ResultInterface
    {
        $resultRedirect = $this->resultRedirectFactory->create();
        $requestData = $this->getRequest()->getParams();
        $recordId = isset($requestData['general'][RecordInterface::RECORD_ID])
            ? (int)$requestData['general'][RecordInterface::RECORD_ID]
            : null;

        if ($recordId === null) {
            $this->messageManager->addErrorMessage(__('Wrong request.'));
            return $resultRedirect->setPath('*/*');
        }
        try {
            if (!isset($requestData['general'][RecordInterface::REPLY])) {
                throw new LocalizedException(__('Enter the reply text and try again.'));
            }
            $record = $this->recordRepository->getById($recordId);
            $record->setStatus(RecordInterface::STATUS_ANSWERED);
            $record->setReply($requestData['general'][RecordInterface::REPLY]);
            $this->recordRepository->save($record);
            $this->mail->send($record->getEmail(), ['data' => $record->getReply()]);
            $this->messageManager->addSuccessMessage(__('The Record has been saved.'));
            $resultRedirect->setPath('contactus/index/index');
        } catch (Exception $e) {
            $this->messageManager->addErrorMessage($e->getMessage());
            $resultRedirect->setPath('contactus/record/reply', [
                RecordInterface::RECORD_ID => $recordId,
                '_current'                 => true,
            ]);
        }

        return $resultRedirect;
    }
}
