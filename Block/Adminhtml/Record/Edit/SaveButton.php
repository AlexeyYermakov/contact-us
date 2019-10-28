<?php
namespace AlexeyYermakov\ContactUs\Block\Adminhtml\Record\Edit;

use Magento\Backend\Block\Template;
use Magento\Framework\View\Element\UiComponent\Control\ButtonProviderInterface;

/**
 * Class SaveButton
 *
 * @package AlexeyYermakov\ContactUs\Block\Adminhtml\Record\View
 * @author Alexey Yermakov slims.alex@gmail.com
 */
class SaveButton extends Template implements ButtonProviderInterface
{
    /**
     * @return array
     */
    public function getButtonData()
    {
        return [
            'label' => __('Save'),
            'class' => 'save primary',
            'data_attribute' => [
                'mage-init' => ['button' => ['event' => 'save']],
                'form-role' => 'save',
            ],
            'sort_order' => 90,
        ];
    }
}
