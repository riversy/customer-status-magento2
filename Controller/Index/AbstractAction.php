<?php

namespace Riversy\CustomerStatus\Controller\Index;

use Magento\Customer\Model\Session;
use Magento\Customer\Model\Url;
use Magento\Framework\App\Action\Context;
use Magento\Framework\App\ActionInterface;
use Magento\Framework\App\RequestInterface;
use Magento\Framework\View\Result\PageFactory;


abstract class AbstractAction extends \Magento\Framework\App\Action\Action
{
    /**
     * @var Session
     */
    protected $customerSession;

    /**
     * @var PageFactory
     */
    protected $resultPageFactory;

    /**
     * @var Url
     */
    private $customerUrl;

    /**
     * View constructor.
     * @param Context $context
     * @param Url $customerUrl
     * @param Session $customerSession
     */
    public function __construct(
        Context $context,
        Url $customerUrl,
        Session $customerSession
    ) {
        parent::__construct($context);
        $this->customerSession = $customerSession;
        $this->customerUrl = $customerUrl;
    }

    /**
     * Authenticate user
     *
     * @param ActionInterface $subject
     * @param RequestInterface $request
     * @return void
     * @SuppressWarnings(PHPMD.UnusedFormalParameter)
     */
    public function beforeDispatch(ActionInterface $subject, RequestInterface $request)
    {
        $loginUrl = $this->customerUrl->getLoginUrl();

        if (!$this->customerSession->authenticate($loginUrl)) {
            $subject->getActionFlag()->set('', $subject::FLAG_NO_DISPATCH, true);
        }
    }
}