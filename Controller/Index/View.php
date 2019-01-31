<?php
namespace Riversy\CustomerStatus\Controller\Index;

use Magento\Customer\Model\Session;
use Magento\Customer\Model\Url;
use Magento\Framework\App\Action\Context;
use Magento\Framework\App\Action\HttpGetActionInterface;
use Magento\Framework\App\ActionInterface;
use Magento\Framework\App\RequestInterface;
use Magento\Framework\View\Result\Page;
use Magento\Framework\View\Result\PageFactory;

class View extends \Magento\Framework\App\Action\Action implements HttpGetActionInterface
{
    /**
     * @var Session
     */
    private $customerSession;

    /**
     * @var PageFactory
     */
    private $resultPageFactory;

    /**
     * @var Url
     */
    private $customerUrl;

    /**
     * View constructor.
     * @param Context $context
     * @param Url $customerUrl
     * @param Session $customerSession
     * @param PageFactory $resultPageFactory
     */
    public function __construct(
        Context $context,
        Url $customerUrl,
        Session $customerSession,
        PageFactory $resultPageFactory
    ) {
        parent::__construct($context);
        $this->customerSession = $customerSession;
        $this->resultPageFactory = $resultPageFactory;
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

    /**
     * @inheritdoc
     */
    public function execute()
    {
        /** @var Page $resultPage */
        $resultPage = $this->resultPageFactory->create();
        return $resultPage;
    }
}
