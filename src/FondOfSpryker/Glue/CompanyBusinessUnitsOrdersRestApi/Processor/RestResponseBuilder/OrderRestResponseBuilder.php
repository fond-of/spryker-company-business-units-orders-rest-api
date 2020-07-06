<?php

namespace FondOfSpryker\Glue\CompanyBusinessUnitsOrdersRestApi\Processor\RestResponseBuilder;

use FondOfSpryker\Glue\CompanyBusinessUnitsOrdersRestApi\CompanyBusinessUnitsOrdersRestApiConfig;
use FondOfSpryker\Glue\CompanyBusinessUnitsOrdersRestApi\Processor\Mapper\OrderMapperInterface;
use Generated\Shared\Transfer\CompanyBusinessUnitOrderListTransfer;
use Generated\Shared\Transfer\RestCompanyBusinessUnitOrderListTransfer;
use Generated\Shared\Transfer\RestErrorMessageTransfer;
use Spryker\Glue\GlueApplication\Rest\JsonApi\RestResourceBuilderInterface;
use Spryker\Glue\GlueApplication\Rest\JsonApi\RestResponseInterface;
use Symfony\Component\HttpFoundation\Response;

class OrderRestResponseBuilder implements OrderRestResponseBuilderInterface
{
    /**
     * @var \Spryker\Glue\GlueApplication\Rest\JsonApi\RestResourceBuilderInterface
     */
    protected $restResourceBuilder;

    /**
     * @var \FondOfSpryker\Glue\CompanyBusinessUnitsOrdersRestApi\Processor\Mapper\OrderMapperInterface
     */
    protected $orderResourceMapper;

    /**
     * @param \Spryker\Glue\GlueApplication\Rest\JsonApi\RestResourceBuilderInterface $restResourceBuilder
     * @param \FondOfSpryker\Glue\CompanyBusinessUnitsOrdersRestApi\Processor\Mapper\OrderMapperInterface $orderResourceMapper
     */
    public function __construct(
        RestResourceBuilderInterface $restResourceBuilder,
        OrderMapperInterface $orderResourceMapper
    ) {
        $this->restResourceBuilder = $restResourceBuilder;
        $this->orderResourceMapper = $orderResourceMapper;
    }

    /**
     * @param \Generated\Shared\Transfer\RestCompanyBusinessUnitOrderListTransfer $restCompanyBusinessUnitOrderListTransfer
     * @param \Generated\Shared\Transfer\CompanyBusinessUnitOrderListTransfer $companyBusinessUnitOrderListTransfer
     *
     * @return \Spryker\Glue\GlueApplication\Rest\JsonApi\RestResponseInterface
     */
    public function createOrderListRestResponse(
        RestCompanyBusinessUnitOrderListTransfer $restCompanyBusinessUnitOrderListTransfer,
        CompanyBusinessUnitOrderListTransfer $companyBusinessUnitOrderListTransfer
    ): RestResponseInterface {
        $filterTransfer = $restCompanyBusinessUnitOrderListTransfer->getFilter();
        $paginationTransfer = $companyBusinessUnitOrderListTransfer->getPagination();

        $limit = $filterTransfer === null || $filterTransfer->getLimit() === null ? 0 : $filterTransfer->getLimit();
        $totalItems = $paginationTransfer === null || $paginationTransfer->getNbResults() === null ? 0 : $paginationTransfer->getNbResults();

        $restResponse = $this->restResourceBuilder->createRestResponse($totalItems, $limit);

        foreach ($companyBusinessUnitOrderListTransfer->getOrders() as $orderTransfer) {
            $restOrdersAttributesTransfer = $this->orderResourceMapper
                ->mapOrderTransferToRestOrderDetailsAttributesTransfer($orderTransfer);

            $restResponse = $restResponse->addResource(
                $this->restResourceBuilder->createRestResource(
                    CompanyBusinessUnitsOrdersRestApiConfig::RESOURCE_COMPANY_BUSINESS_UNIT_ORDERS,
                    $orderTransfer->getOrderReference(),
                    $restOrdersAttributesTransfer
                )
            );
        }

        return $restResponse;
    }

    /**
     * @return \Spryker\Glue\GlueApplication\Rest\JsonApi\RestResponseInterface
     */
    public function createCompanyBusinessUnitIdentifierMissingErrorResponse(): RestResponseInterface
    {
        $restErrorMessageTransfer = (new RestErrorMessageTransfer())
            ->setStatus(Response::HTTP_BAD_REQUEST)
            ->setCode(CompanyBusinessUnitsOrdersRestApiConfig::RESPONSE_CODE_COMPANY_BUSINESS_UNIT_IDENTIFIER_MISSING)
            ->setDetail(CompanyBusinessUnitsOrdersRestApiConfig::EXCEPTION_MESSAGE_COMPANY_BUSINESS_UNIT_IDENTIFIER_MISSING);

        return $this->restResourceBuilder
            ->createRestResponse()
            ->addError($restErrorMessageTransfer);
    }
}
