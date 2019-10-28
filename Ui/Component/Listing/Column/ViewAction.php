<?php
namespace AlexeyYermakov\ContactUs\Ui\Component\Listing\Column;

use AlexeyYermakov\ContactUs\Api\Data\RecordInterface;
use Magento\Framework\UrlInterface;
use Magento\Framework\View\Element\UiComponent\ContextInterface;
use Magento\Framework\View\Element\UiComponentFactory;
use Magento\Ui\Component\Listing\Columns\Column;

/**
 * Class ViewAction
 *
 * @package AlexeyYermakov\ContactUs\Ui\Component\Listing\Column
 * @author Alexey Yermakov slims.alex@gmail.com
 */
class ViewAction extends Column
{
    /**
     * @var UrlInterface
     */
    private $urlBuilder;

    /**
     * @param ContextInterface $context
     * @param UiComponentFactory $uiComponentFactory
     * @param UrlInterface $urlBuilder
     * @param array $components
     * @param array $data
     */
    public function __construct(
        ContextInterface $context,
        UiComponentFactory $uiComponentFactory,
        UrlInterface $urlBuilder,
        array $components = [],
        array $data = []
    ) {
        $this->urlBuilder = $urlBuilder;
        parent::__construct($context, $uiComponentFactory, $components, $data);
    }

    /**
     * @param array $dataSource
     * @return array
     */
    public function prepareDataSource(array $dataSource)
    {
        if (isset($dataSource['data']['items'])) {
            foreach ($dataSource['data']['items'] as &$item) {
                $item[$this->getData('name')]['edit'] = [
                    'href'          => $this->urlBuilder->getUrl(
                        'contactus/record/view',
                        [RecordInterface::RECORD_ID => $item[RecordInterface::RECORD_ID]]
                    ),
                    'label'         => __('View'),
                    'hidden'        => false,
                    '__disableTmpl' => true
                ];
                $item[$this->getData('name')]['reply'] = [
                    'href'          => $this->urlBuilder->getUrl(
                        'contactus/record/reply',
                        [RecordInterface::RECORD_ID => $item[RecordInterface::RECORD_ID]]
                    ),
                    'label'         => __('Reply'),
                    'hidden'        => false,
                    '__disableTmpl' => true
                ];
                $item[$this->getData('name')]['delete'] = [
                    'href'          => $this->urlBuilder->getUrl(
                        'contactus/record/delete',
                        [RecordInterface::RECORD_ID => $item[RecordInterface::RECORD_ID]]
                    ),
                    'label'         => __('Delete'),
                    'hidden'        => false,
                    '__disableTmpl' => true,
                    'confirm'       => [
                        'title'   => __('Delete record'),
                        'message' => __('Are you sure you want to delete a record with id: %1?', $item[RecordInterface::RECORD_ID])
                    ]
                ];
            }
        }

        return $dataSource;
    }
}
