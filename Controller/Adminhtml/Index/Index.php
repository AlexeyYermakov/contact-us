<?php
namespace AlexeyYermakov\ContactUs\Controller\Adminhtml\Index;

use Magento\Backend\App\Action;
use Magento\Backend\Model\View\Result\Page;
use Magento\Framework\Controller\ResultFactory;
use Magento\Framework\Controller\ResultInterface;

/**
 * Class Index
 *
 * @package AlexeyYermakov\ContactUs\Controller\Adminhtml\Index
 * @author Alexey Yermakov slims.alex@gmail.com
 */
class Index extends Action
{
    /**
     * @see _isAllowed()
     */
    const ADMIN_RESOURCE = 'AlexeyYermakov_ContactUs::record';

    /**
     * @return ResultInterface
     */
    public function execute(): ResultInterface
    {
        /** @var Page $resultPage */
        $resultPage = $this->resultFactory->create(ResultFactory::TYPE_PAGE);
        $resultPage->setActiveMenu('AlexeyYermakov_ContactUs::record')
            ->addBreadcrumb(__('Contact Us - Records'), __('List'));
        $resultPage->getConfig()->getTitle()->prepend(__('Contact Us - Records'));

        return $resultPage;
    }
}
