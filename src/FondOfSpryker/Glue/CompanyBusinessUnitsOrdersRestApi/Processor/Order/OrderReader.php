<?php

namespace FondOfSpryker\Glue\CompanyBusinessUnitsOrdersRestApi\Processor\Order;

use FondOfSpryker\Client\CompanyBusinessUnitsOrdersRestApi\CompanyBusinessUnitsOrdersRestApiClientInterface;
use FondOfSpryker\Glue\CompanyBusinessUnitsOrdersRestApi\CompanyBusinessUnitsOrdersRestApiConfig;
use FondOfSpryker\Glue\CompanyBusinessUnitsOrdersRestApi\Processor\RestResponseBuilder\OrderRestResponseBuilderInterface;
use Generated\Shared\Transfer\FilterTransfer;
use Generated\Shared\Transfer\RestCompanyBusinessUnitOrderListTransfer;
use Spryker\Glue\GlueApplication\Rest\JsonApi\RestResponseInterface;
use Spryker\Glue\GlueApplication\Rest\Request\Data\RestRequestInterface;

class OrderReader implements OrderReaderInterface
{
    /**
     * @var \FondOfSpryker\Client\CompanyBusinessUnitsOrdersRestApi\CompanyBusinessUnitsOrdersRestApiClientInterface
     */
    protected $client;

    /**
     * @var \FondOfSpryker\Glue\CompanyBusinessUnitsOrdersRestApi\Processor\RestResponseBuilder\OrderRestResponseBuilderInterface
     */
    protected $orderRestResponseBuilder;

    /**
     * @param \FondOfSpryker\Client\CompanyBusinessUnitsOrdersRestApi\CompanyBusinessUnitsOrdersRestApiClientInterface $client
     * @param \FondOfSpryker\Glue\CompanyBusinessUnitsOrdersRestApi\Processor\RestResponseBuilder\OrderRestResponseBuilderInterface $orderRestResponseBuilder
     */
    public function __construct(
        CompanyBusinessUnitsOrdersRestApiClientInterface $client,
        OrderRestResponseBuilderInterface $orderRestResponseBuilder
    ) {
        $this->client = $client;
        $this->orderRestResponseBuilder = $orderRestResponseBuilder;
    }

    /**
     * @param \Spryker\Glue\GlueApplication\Rest\Request\Data\RestRequestInterface $restRequest
     *
     * @return \Spryker\Glue\GlueApplication\Rest\JsonApi\RestResponseInterface
     */
    public function findOrders(RestRequestInterface $restRequest): RestResponseInterface
    {
        if ($this->findCompanyBusinessUnitIdentifier($restRequest) === null) {
            return $this->orderRestResponseBuilder->createCompanyBusinessUnitIdentifierMissingErrorResponse();
        }

        $restCompanyBusinessUnitOrderListTransfer = $this->createRestCompanyBusinessUnitOrderListTransfer($restRequest)
            ->setFilter($this->createFilterTransfer($restRequest));

        $companyBusinessUnitOrderListTransfer = $this->client->findOrders($restCompanyBusinessUnitOrderListTransfer);

        return $this->orderRestResponseBuilder->createOrderListRestResponse(
            $restCompanyBusinessUnitOrderListTransfer,
            $companyBusinessUnitOrderListTransfer
        );
    }

    /**
     * @param string $orderReference
     * @param \Spryker\Glue\GlueApplication\Rest\Request\Data\RestRequestInterface $restRequest
     *
     * @return \Spryker\Glue\GlueApplication\Rest\JsonApi\RestResponseInterface
     */
    public function getOrder(string $orderReference, RestRequestInterface $restRequest): RestResponseInterface
    {
        if ($this->findCompanyBusinessUnitIdentifier($restRequest) === null) {
            return $this->orderRestResponseBuilder->createCompanyBusinessUnitIdentifierMissingErrorResponse();
        }

        $restCompanyBusinessUnitOrderListTransfer = $this->createRestCompanyBusinessUnitOrderListTransfer($restRequest);
        $restCompanyBusinessUnitOrderListTransfer->setOrderReference($orderReference);

        $companyBusinessUnitOrderListTransfer = $this->client->findOrders($restCompanyBusinessUnitOrderListTransfer);

        $orderTransfers = $companyBusinessUnitOrderListTransfer->getOrders();

        if ($orderTransfers->count() !== 1) {
            return $this->orderRestResponseBuilder->createOrderNotFoundErrorResponse();
        }

        return $this->orderRestResponseBuilder->createOrderRestResponse(
            $restCompanyBusinessUnitOrderListTransfer,
            $orderTransfers->offsetGet(0)
        );
    }

    /**
     * @param \Spryker\Glue\GlueApplication\Rest\Request\Data\RestRequestInterface $restRequest
     *
     * @return \Generated\Shared\Transfer\RestCompanyBusinessUnitOrderListTransfer
     */
    protected function createRestCompanyBusinessUnitOrderListTransfer(
        RestRequestInterface $restRequest
    ): RestCompanyBusinessUnitOrderListTransfer {
        return (new RestCompanyBusinessUnitOrderListTransfer())
            ->setIdCustomer($restRequest->getRestUser()->getSurrogateIdentifier())
            ->setCompanyBusinessUnitUuid($this->findCompanyBusinessUnitIdentifier($restRequest));
    }

    /**
     * @param \Spryker\Glue\GlueApplication\Rest\Request\Data\RestRequestInterface $restRequest
     *
     * @return \Generated\Shared\Transfer\FilterTransfer|null
     */
    protected function createFilterTransfer(RestRequestInterface $restRequest): ?FilterTransfer
    {
        $page = $restRequest->getPage();

        if ($page === null) {
            return null;
        }

        return (new FilterTransfer())->setLimit($page->getLimit())
            ->setOffset($page->getOffset());
    }

    /**
     * @param \Spryker\Glue\GlueApplication\Rest\Request\Data\RestRequestInterface $restRequest
     *
     * @return string|null
     */
    protected function findCompanyBusinessUnitIdentifier(RestRequestInterface $restRequest): ?string
    {
        $companyBusinessUnitsResource = $restRequest->findParentResourceByType(
            CompanyBusinessUnitsOrdersRestApiConfig::PARENT_RESOURCE_COMPANY_BUSINESS_UNITS
        );

        if ($companyBusinessUnitsResource) {
            return $companyBusinessUnitsResource->getId();
        }

        return null;
    }
}
