<?php
namespace AlexeyYermakov\ContactUs\Controller\Adminhtml\Record;

use AlexeyYermakov\ContactUs\Api\Data\RecordInterface;
use AlexeyYermakov\ContactUs\Api\RecordRepositoryInterface;
use Exception;
use Magento\Backend\App\Action;
use Magento\Framework\Controller\ResultInterface;

/**
 * Class Delete
 *
 * @package AlexeyYermakov\ContactUs\Controller\Adminhtml\Record
 * @author Alexey Yermakov slims.alex@gmail.com
 */
class Delete extends Action
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
     * Delete constructor.
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
        $this->resultRedirectFactory = $context->getResultRedirectFactory();
    }

    /**
     * @return ResultInterface
     */
    public function execute(): ResultInterface
    {
        $result = $this->resultRedirectFactory->create();
        $recordId = (int)$this->getRequest()->getParam(RecordInterface::RECORD_ID);
        try {
            $record = $this->recordRepository->getById($recordId);
            $this->recordRepository->delete($record);
            $this->messageManager->addSuccessMessage(__('The Record has been deleted.'));
            $result->setPath('contactus/index/index');
        } catch (Exception $e) {
            $this->messageManager->addErrorMessage($e->getMessage());
            $result->setPath('contactus/index/index', [
                RecordInterface::RECORD_ID => $recordId,
                '_current'                 => true,
            ]);
        }

        return $result;
    }
}
