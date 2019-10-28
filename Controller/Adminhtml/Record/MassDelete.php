<?php
namespace AlexeyYermakov\ContactUs\Controller\Adminhtml\Record;

use AlexeyYermakov\ContactUs\Api\Data\RecordInterface;
use AlexeyYermakov\ContactUs\Api\RecordRepositoryInterface;
use AlexeyYermakov\ContactUs\Model\Record;
use AlexeyYermakov\ContactUs\Model\ResourceModel\Record\CollectionFactory;
use Magento\Backend\App\Action;
use Magento\Backend\App\Action\Context;
use Magento\Framework\Controller\ResultInterface;
use Magento\Framework\Exception\LocalizedException;
use Magento\Ui\Component\MassAction\Filter;

/**
 * Class MassDelete
 *
 * @package AlexeyYermakov\ContactUs\Controller\Adminhtml\Record
 * @author Alexey Yermakov slims.alex@gmail.com
 */
class MassDelete extends Action
{
    /**
     * @see _isAllowed()
     */
    const ADMIN_RESOURCE = 'AlexeyYermakov_ContactUs::record';

    /**
     * @var Filter
     */
    private $massActionFilter;

    /**
     * @var RecordRepositoryInterface
     */
    private $recordRepository;

    /**
     * @var CollectionFactory
     */
    private $recordCollection;

    /**
     * @param Context $context
     * @param RecordRepositoryInterface $recordRepository
     * @param Filter $massActionFilter
     * @param CollectionFactory $recordCollection
     */
    public function __construct(
        Context $context,
        RecordRepositoryInterface $recordRepository,
        Filter $massActionFilter,
        CollectionFactory $recordCollection
    ) {
        parent::__construct($context);
        $this->massActionFilter = $massActionFilter;
        $this->recordRepository = $recordRepository;
        $this->recordCollection = $recordCollection;
    }

    /**
     * @return ResultInterface
     * @throws LocalizedException
     */
    public function execute(): ResultInterface
    {
        if ($this->getRequest()->isPost() !== true) {
            $this->messageManager->addErrorMessage(__('Wrong request.'));

            return $this->resultRedirectFactory->create()->setPath('contactus/index/index');
        }

        $collection = $this->massActionFilter->getCollection($this->recordCollection->create());
        foreach ($collection->getItems() as $record) {
            /** @var RecordInterface|Record $record */
            $this->recordRepository->delete($record);
        }
        $this->messageManager->addSuccessMessage(__('You deleted %1 record(s).', $collection->count()));

        return $this->resultRedirectFactory->create()->setPath('contactus/index/index');
    }
}
