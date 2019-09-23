<?php
/**
 *Developed by @DevAbhinay
 *gmail:abhinay111222@gmail.com
 *linked: https://www.linkedin.com/in/singh-abhinay/
 * This code is used for public.
 */
namespace DevAbhinay\CustomerLogin\Controller\Customer;

use Magento\Customer\Model\Account\Redirect as AccountRedirect;
use Magento\Customer\Model\Session as CustomerSession;


class Login extends \Magento\Framework\App\Action\Action
{
    /**
     * @var $_accountRedirect
     */
    protected $_accountRedirect;
    /**
     * @var $customerSession
     */
    protected $customerSession;
    /**
     * @var $pageFactory
     */
    protected $pageFactory;


    /**
     * Login constructor.
     * @param \Magento\Framework\App\Action\Context $context
     * @param \Magento\Framework\View\Result\PageFactory $pageFactory
     * @param CustomerSession $customerSession
     * @param AccountRedirect $accountRedirect
     */

    public function __construct(
        \Magento\Framework\App\Action\Context $context,
        \Magento\Framework\View\Result\PageFactory $pageFactory,
        CustomerSession $customerSession,
        AccountRedirect $accountRedirect
    ) {
        $this->_customerSession = $customerSession;
        $this->_accountRedirect = $accountRedirect;
        parent::__construct($context);
    }

    /**
     * @return \Magento\Framework\App\ResponseInterface|\Magento\Framework\Controller\Result\Forward|\Magento\Framework\Controller\Result\Redirect|\Magento\Framework\Controller\ResultInterface
     */
    public function execute()
    {
        $cId = $this->getRequest()->getParam('id');
        try {
            $this->_customerSession->loginById($cId);
            $this->_customerSession->regenerateId();
            $redirectUrl = $this->_accountRedirect->getRedirectCookie();
            $this->_accountRedirect->clearRedirectCookie();
            $resultRedirect = $this->resultRedirectFactory->create();
            $resultRedirect->setUrl($this->_redirect->success('customer/account/index'));
            return $resultRedirect;

        } catch (Exception $e) {
            $this->messageManager->addError(
                __('Something went wrong while login as a customer.')
            );
        }
        return $this->_accountRedirect->getRedirect();
    }
}
