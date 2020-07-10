<?php

namespace FondOfSpryker\Glue\CompanyBusinessUnitsOrdersRestApi\Processor\RestResponseBuilder;

use FondOfSpryker\Glue\CompanyBusinessUnitsOrdersRestApi\CompanyBusinessUnitsOrdersRestApiConfig;
use FondOfSpryker\Glue\CompanyBusinessUnitsOrdersRestApi\Processor\Mapper\OrderMapperInterface;
use Generated\Shared\Transfer\CompanyBusinessUnitOrderListTransfer;
use Generated\Shared\Transfer\OrderTransfer;
use Generated\Shared\Transfer\RestCompanyBusinessUnitOrderListTransfer;
use Generated\Shared\Transfer\RestErrorMessageTransfer;
use Spryker\Glue\GlueApplication\Rest\JsonApi\RestLinkInterface;
use Spryker\Glue\GlueApplication\Rest\JsonApi\RestResourceBuilderInterface;
use Spryker\Glue\GlueApplication\Rest\JsonApi\RestResourceInterface;
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
     * @param \Generated\Shared\Transfer\OrderTransfer $orderTransfer
     *
     * @return \Spryker\Glue\GlueApplication\Rest\JsonApi\RestResourceInterface
     */
    public function createOrderRestResource(
        RestCompanyBusinessUnitOrderListTransfer $restCompanyBusinessUnitOrderListTransfer,
        OrderTransfer $orderTransfer
    ): RestResourceInterface {
        $restOrderDetailsAttributesTransfer = $this->orderResourceMapper
            ->mapOrderTransferToRestOrderDetailsAttributesTransfer($orderTransfer);

        $orderRestResource = $this->restResourceBuilder->createRestResource(
            CompanyBusinessUnitsOrdersRestApiConfig::RESOURCE_COMPANY_BUSINESS_UNIT_ORDERS,
            $orderTransfer->getOrderReference(),
            $restOrderDetailsAttributesTransfer
        );

        return $this->addSelfLinkToOrderRestResource($orderRestResource, $restCompanyBusinessUnitOrderListTransfer);
    }

    /**
     * @param \Spryker\Glue\GlueApplication\Rest\JsonApi\RestResourceInterface $orderRestResource
     * @param \Generated\Shared\Transfer\RestCompanyBusinessUnitOrderListTransfer $restCompanyBusinessUnitOrderListTransfer
     *
     * @return \Spryker\Glue\GlueApplication\Rest\JsonApi\RestResourceInterface
     */
    protected function addSelfLinkToOrderRestResource(
        RestResourceInterface $orderRestResource,
        RestCompanyBusinessUnitOrderListTransfer $restCompanyBusinessUnitOrderListTransfer
    ): RestResourceInterface {
        return $orderRestResource->addLink(
            RestLinkInterface::LINK_SELF,
            sprintf(
                '%s/%s/%s/%s',
                CompanyBusinessUnitsOrdersRestApiConfig::PARENT_RESOURCE_COMPANY_BUSINESS_UNITS,
                $restCompanyBusinessUnitOrderListTransfer->getCompanyBusinessUnitUuid(),
                CompanyBusinessUnitsOrdersRestApiConfig::RESOURCE_COMPANY_BUSINESS_UNIT_ORDERS,
                $orderRestResource->getId()
            )
        );
    }

    /**
     * @param \Generated\Shared\Transfer\RestCompanyBusinessUnitOrderListTransfer $restCompanyBusinessUnitOrderListTransfer
     * @param \Generated\Shared\Transfer\OrderTransfer $orderTransfer
     *
     * @return \Spryker\Glue\GlueApplication\Rest\JsonApi\RestResponseInterface
     */
    public function createOrderRestResponse(
        RestCompanyBusinessUnitOrderListTransfer $restCompanyBusinessUnitOrderListTransfer,
        OrderTransfer $orderTransfer
    ): RestResponseInterface {
        $orderRestResource = $this->createOrderRestResource($restCompanyBusinessUnitOrderListTransfer, $orderTransfer);

        return $this->restResourceBuilder->createRestResponse()
            ->addResource($orderRestResource);
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
            $orderRestResource = $this->createOrderRestResource(
                $restCompanyBusinessUnitOrderListTransfer,
                $orderTransfer
            );

            $restResponse = $restResponse->addResource($orderRestResource);
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

    /**
     * @return \Spryker\Glue\GlueApplication\Rest\JsonApi\RestResponseInterface
     */
    public function createOrderNotFoundErrorResponse(): RestResponseInterface
    {
        $restErrorTransfer = (new RestErrorMessageTransfer())
            ->setCode(CompanyBusinessUnitsOrdersRestApiConfig::RESPONSE_CODE_CANT_FIND_ORDER)
            ->setStatus(Response::HTTP_NOT_FOUND)
            ->setDetail(CompanyBusinessUnitsOrdersRestApiConfig::EXCEPTION_MESSAGE_CANT_FIND_ORDER);

        return $this->restResourceBuilder->createRestResponse()->addError($restErrorTransfer);
    }
}
