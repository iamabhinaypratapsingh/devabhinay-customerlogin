<?php
/**
 *Developed by @DevAbhinay
 *gmail:abhinay111222@gmail.com
 *linked: https://www.linkedin.com/in/singh-abhinay/
 * This code is used for public.
 */
namespace DevAbhinay\CustomerLogin\Ui\Component\Listing\Column;

use Magento\Framework\View\Element\UiComponent\ContextInterface;
use Magento\Framework\View\Element\UiComponentFactory;
use Magento\Ui\Component\Listing\Columns\Column;
use Magento\Framework\UrlInterface;

class Actions extends Column
{
    /**
     * @var UrlInterface
     */
    protected $urlBuilder;

    /**
     * Actions constructor.
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
            $storeId = $this->context->getFilterParam('store_id');

            foreach ($dataSource['data']['items'] as &$item) {
                $item[$this->getData('name')] = [
                    'edit' => [
                            'href' => $this->urlBuilder->getUrl(
                            'customer/*/edit',
                            ['id' => $item['entity_id'], 'store' => $storeId]
                        ),
                            'label' => __('Edit')
                        ],
                    'delete' => [
                            'href' => $this->urlBuilder->getUrl(
                            'customerlogin/customer/login',
                            ['id' => $item['entity_id'], 'store' => $storeId]
                        ),
                            'label' => __('Login As Customer'),
                            'confirm' => [
                                'title' => __('Login As Customer "${ $.$data.name }"'),
                                'message' => __('Are you sure you wan\'t to login as a customer')
                            ]
                        ]
                ];
            }
        }

        return $dataSource;
    }
}
