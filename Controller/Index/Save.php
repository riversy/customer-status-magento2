<?php
namespace Riversy\CustomerStatus\Controller\Index;

use Magento\Customer\Model\Url;
use Magento\Customer\Model\Session;
use Magento\Framework\App\Action\Context;
use Magento\Framework\Data\Form\FormKey\Validator;
use Magento\Framework\App\Action\HttpPostActionInterface;
use Magento\Customer\Api\CustomerRepositoryInterface;

class Save extends AbstractAction implements HttpPostActionInterface
{
    /**
     * @var Validator
     */
    private $formKeyValidator;

    /**
     * @var CustomerRepository
     */
    private $customerRepository;

    /**
     * Save constructor.
     * @param Context $context
     * @param Url $customerUrl
     * @param Session $customerSession
     * @param Validator $formKeyValidator
     * @param CustomerRepositoryInterface $customerRepository
     */
    public function __construct(
        Context $context,
        Url $customerUrl,
        Session $customerSession,
        Validator $formKeyValidator,
        CustomerRepositoryInterface $customerRepository
    ) {
        parent::__construct($context, $customerUrl, $customerSession);
        $this->formKeyValidator = $formKeyValidator;
        $this->customerRepository = $customerRepository;
    }

    /**
     * @inheritdoc
     */
    public function execute()
    {
        $request = $this->getRequest();

        if (!$this->formKeyValidator->validate($request)) {
            $this->messageManager->addErrorMessage(__('The request is invalid.'));
            return $this->_redirect('*/*/view');
        }

        $customerStatus = $this->getStatusValue();

        $customerSession = $this->customerSession;
        $customerId = $customerSession->getCustomerId();

        try {
            $customer = $this->customerRepository->getById($customerId);

            $extensionAttributes = $customer->getExtensionAttributes();
            $extensionAttributes->setCustomerStatus($customerStatus);
            $customer->setExtensionAttributes($extensionAttributes);

            $this->customerRepository->save($customer);
            
            if ($customerStatus) {
                $this->messageManager->addSuccessMessage(__("Your status changed to \"%1\".", $customerStatus));
            } else {
                $this->messageManager->addSuccessMessage(__("Your status changed to empty string."));
            }
        } catch (\Exception $e) {

            $this->messageManager->addErrorMessage($e->getMessage());
        }


        $this->_redirect('*/*/view');
    }

    private function getStatusValue()
    {
        return $this->getRequest()->getPost('status');
    }
    
}
