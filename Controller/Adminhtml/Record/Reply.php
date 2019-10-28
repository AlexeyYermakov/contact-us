<?php
namespace AlexeyYermakov\ContactUs\Controller\Adminhtml\Record;

use AlexeyYermakov\ContactUs\Api\Data\RecordInterface;
use AlexeyYermakov\ContactUs\Api\RecordRepositoryInterface;
use Magento\Backend\App\Action;
use Magento\Backend\Model\View\Result\Redirect;
use Magento\Framework\Controller\ResultFactory;
use Magento\Framework\Controller\ResultInterface;
use Magento\Framework\Exception\NoSuchEntityException;
use Magento\Framework\View\Result\Page;

/**
 * Class Reply
 *
 * @package AlexeyYermakov\ContactUs\Controller\Adminhtml\Record
 * @author Alexey Yermakov slims.alex@gmail.com
 */
class Reply extends Action
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
        $recordId = (int)$this->getRequest()->getParam(RecordInterface::RECORD_ID);
        try {
            $record = $this->recordRepository->getById($recordId);
            /** @var Page $result */
            $result = $this->resultFactory->create(ResultFactory::TYPE_PAGE);
            $result->setActiveMenu('AlexeyYermakov_ContactUs::record')
                ->addBreadcrumb(__('Reply Record'), __('Reply Record'));
            $result->getConfig()
                ->getTitle()
                ->prepend(__('Reply to %name', ['name' => $record->getName()]));
        } catch (NoSuchEntityException $e) {
            /** @var Redirect $result */
            $result = $this->resultRedirectFactory->create();
            $this->messageManager->addErrorMessage(
                __('Record with id "%value" does not exist.', ['value' => $recordId])
            );
            $result->setPath('contactus/index/index');
        }

        return $result;
    }
}
