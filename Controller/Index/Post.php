<?php
namespace AlexeyYermakov\ContactUs\Controller\Index;

use AlexeyYermakov\ContactUs\Api\Data\RecordInterfaceFactory;
use AlexeyYermakov\ContactUs\Api\RecordRepositoryInterface;
use AlexeyYermakov\ContactUs\Model\Record;
use Exception;
use Magento\Contact\Controller\Index;
use Magento\Contact\Model\ConfigInterface;
use Magento\Contact\Model\MailInterface;
use Magento\Customer\Model\Session;
use Magento\Framework\App\Action\Context;
use Magento\Framework\App\Request\DataPersistorInterface;
use Magento\Framework\App\ResponseInterface;
use Magento\Framework\Controller\Result\Redirect;
use Magento\Framework\Controller\ResultInterface;
use Magento\Framework\DataObject;
use Magento\Framework\Exception\LocalizedException;
use Psr\Log\LoggerInterface;
use function strpos;

/**
 * Class Post
 *
 * @package AlexeyYermakov\ContactUs\Controller\Index
 * @author Alexey Yermakov slims.alex@gmail.com
 */
class Post extends Index
{
    /**
     * @var DataPersistorInterface
     */
    private $dataPersistor;

    /**
     * @var Context
     */
    private $context;

    /**
     * @var MailInterface
     */
    private $mail;

    /**
     * @var LoggerInterface
     */
    private $logger;

    /**
     * @var RecordInterfaceFactory
     */
    private $recordFactory;

    /**
     * @var Session
     */
    private $customerSession;

    /**
     * @var RecordRepositoryInterface
     */
    private $recordRepository;

    /**
     * Post constructor.
     *
     * @param Context $context
     * @param ConfigInterface $contactsConfig
     * @param MailInterface $mail
     * @param DataPersistorInterface $dataPersistor
     * @param LoggerInterface $logger
     * @param Session $customerSession
     * @param RecordInterfaceFactory $recordFactory
     * @param RecordRepositoryInterface $recordRepository
     */
    public function __construct(
        Context $context,
        ConfigInterface $contactsConfig,
        MailInterface $mail,
        DataPersistorInterface $dataPersistor,
        LoggerInterface $logger,
        Session $customerSession,
        RecordInterfaceFactory $recordFactory,
        RecordRepositoryInterface $recordRepository
    ) {
        parent::__construct($context, $contactsConfig);
        $this->context = $context;
        $this->mail = $mail;
        $this->dataPersistor = $dataPersistor;
        $this->logger = $logger;
        $this->customerSession = $customerSession;
        $this->recordFactory = $recordFactory;
        $this->recordRepository = $recordRepository;
    }

    /**
     * Post user question
     *
     * @return ResponseInterface|Redirect|ResultInterface
     */
    public function execute()
    {
        if (!$this->getRequest()->isPost()) {
            return $this->resultRedirectFactory->create()->setPath('*/*/');
        }
        try {
            $params = $this->validatedParams();
            //$this->sendEmail($params);
            // Store data in database
            $this->saveRecord($params);
            $this->messageManager->addSuccessMessage(
                __('Thanks for contacting us with your comments and questions. We\'ll respond to you very soon.')
            );
            $this->dataPersistor->clear('contact_us');
        } catch (LocalizedException $e) {
            $this->messageManager->addErrorMessage($e->getMessage());
            $this->dataPersistor->set('contact_us', $this->getRequest()->getParams());
        } catch (Exception $e) {
            $this->logger->critical($e);
            $this->messageManager->addErrorMessage(
                __('An error occurred while processing your form. Please try again later.')
            );
            $this->dataPersistor->set('contact_us', $this->getRequest()->getParams());
        }

        return $this->resultRedirectFactory->create()->setPath('contact/index');
    }

    /**
     * @return array
     * @throws LocalizedException
     * @throws Exception
     */
    private function validatedParams()
    {
        $request = $this->getRequest();
        if (trim($request->getParam('name')) === '') {
            throw new LocalizedException(__('Enter the Name and try again.'));
        }
        if (trim($request->getParam('comment')) === '') {
            throw new LocalizedException(__('Enter the comment and try again.'));
        }
        if (false === strpos($request->getParam('email'), '@') && filter_var($request->getParam('email'), FILTER_VALIDATE_EMAIL)) {
            throw new LocalizedException(__('The email address is invalid. Verify the email address and try again.'));
        }
        if (trim($request->getParam('hideit')) !== '') {
            throw new Exception();
        }

        return $request->getParams();
    }

    /**
     * @param array $params
     * @return Record
     * @throws Exception
     */
    private function saveRecord(array $params)
    {
        /** @var Record $record */
        $record = $this->recordFactory->create();
        $record->setData($params);
        $record->setCustomerId($this->customerSession->getCustomerId());

        return $this->recordRepository->save($record);
    }

    /**
     * @param array $post Post data from contact form
     * @return void
     */
    private function sendEmail($post)
    {
        $this->mail->send(
            $post['email'],
            ['data' => new DataObject($post)]
        );
    }
}
