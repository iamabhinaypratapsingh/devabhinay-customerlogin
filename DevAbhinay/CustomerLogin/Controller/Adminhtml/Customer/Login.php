<?php
/**
 *Developed by @DevAbhinay
 *gmail:abhinay111222@gmail.com
 *linked: https://www.linkedin.com/in/singh-abhinay/
 * This code is used for public.
 */
namespace DevAbhinay\CustomerLogin\Controller\Adminhtml\Customer;

use Magento\Customer\Model\CustomerFactory;
use Magento\Framework\Url;

class Login extends \Magento\Backend\App\Action
{
    /**
     * @var CustomerFactory
     */
    protected $customerFactory;
    /**
     * @var \Magento\Store\Model\StoreManagerInterface
     */
    protected $_storeManager;

    /**
     * Login constructor.
     * @param \Magento\Backend\App\Action\Context $context
     * @param CustomerFactory $customerFactory
     * @param \Magento\Store\Model\StoreManagerInterface $storeManager
     */
    public function __construct(
        \Magento\Backend\App\Action\Context $context,
        CustomerFactory $customerFactory,
        \Magento\Store\Model\StoreManagerInterface $storeManager
    ) {
        $this->_storeManager = $storeManager;
        $this->customerFactory = $customerFactory;
        $this->_messageManager = $context->getMessageManager();
        parent::__construct($context);
    }

    /**
     * @return \Magento\Framework\App\ResponseInterface|\Magento\Framework\Controller\ResultInterface
     * @throws \Magento\Framework\Exception\NoSuchEntityException
     */
    public function execute()
    {
        /*getting customer id*/
        $cId = $this->getRequest()->getParam('id');

        /*loading customer for check existence*/
        $customer = $this->customerFactory->create()->load($cId);
        if ((!$customer) || (!$customer->getId())) {
            $this->_messageManager->addErrorMessage(__('Customer does not exist.'));
            return $this->_redirect('customer/*/*');
        }

        /*getting current store*/
        $storeId = $customer->getStoreId();
        $store = $this->getCustomerStore($storeId);
        $loginUrl = $this->_objectManager->create(Url::class)
            ->setScope($store)
            ->getUrl('customerlogin/customer/login', ['id' => $cId]);
        return $this->getResponse()->setRedirect($loginUrl);
    }

    /**
     * @param $storeId
     * @return \Magento\Store\Api\Data\StoreInterface|null
     * @throws \Magento\Framework\Exception\NoSuchEntityException
     */
    public function getCustomerStore($storeId){
        if (!empty($storeId)) {
            return $this->_storeManager->getStore($storeId);
        }
        return $this->_storeManager->getDefaultStoreView();
    }
}
