<?php

namespace FondOfSpryker\Glue\CompanyBusinessUnitsOrdersRestApi\Processor\RestResponseBuilder;

use ArrayObject;
use Codeception\Test\Unit;
use FondOfSpryker\Glue\CompanyBusinessUnitsOrdersRestApi\CompanyBusinessUnitsOrdersRestApiConfig;
use FondOfSpryker\Glue\CompanyBusinessUnitsOrdersRestApi\Processor\Mapper\OrderMapperInterface;
use Generated\Shared\Transfer\CompanyBusinessUnitOrderListTransfer;
use Generated\Shared\Transfer\FilterTransfer;
use Generated\Shared\Transfer\OrderTransfer;
use Generated\Shared\Transfer\PaginationTransfer;
use Generated\Shared\Transfer\RestCompanyBusinessUnitOrderListTransfer;
use Generated\Shared\Transfer\RestErrorMessageTransfer;
use Generated\Shared\Transfer\RestOrderDetailsAttributesTransfer;
use Spryker\Glue\GlueApplication\Rest\JsonApi\RestLinkInterface;
use Spryker\Glue\GlueApplication\Rest\JsonApi\RestResourceBuilderInterface;
use Spryker\Glue\GlueApplication\Rest\JsonApi\RestResourceInterface;
use Spryker\Glue\GlueApplication\Rest\JsonApi\RestResponseInterface;
use Symfony\Component\HttpFoundation\Response;

class OrderRestResponseBuilderTest extends Unit
{
    /**
     * @var \PHPUnit\Framework\MockObject\MockObject|\Spryker\Glue\GlueApplication\Rest\JsonApi\RestResourceBuilderInterface
     */
    protected $restResourceBuilderMock;

    /**
     * @var \PHPUnit\Framework\MockObject\MockObject|\FondOfSpryker\Glue\CompanyBusinessUnitsOrdersRestApi\Processor\Mapper\OrderMapperInterface
     */
    protected $orderResourceMapperMock;

    /**
     * @var \PHPUnit\Framework\MockObject\MockObject|\Generated\Shared\Transfer\OrderTransfer
     */
    protected $orderTransferMock;

    /**
     * @var \PHPUnit\Framework\MockObject\MockObject|\Generated\Shared\Transfer\RestOrderDetailsAttributesTransfer
     */
    protected $restOrderDetailsAttributesTransferMock;

    /**
     * @var \PHPUnit\Framework\MockObject\MockObject|\Spryker\Glue\GlueApplication\Rest\JsonApi\RestResourceInterface
     */
    protected $restResourceMock;

    /**
     * @var \PHPUnit\Framework\MockObject\MockObject|\Spryker\Glue\GlueApplication\Rest\JsonApi\RestResponseInterface
     */
    protected $restResponseMock;

    /**
     * @var \PHPUnit\Framework\MockObject\MockObject|\Generated\Shared\Transfer\RestCompanyBusinessUnitOrderListTransfer
     */
    protected $restCompanyBusinessUnitOrderListTransferMock;

    /**
     * @var \PHPUnit\Framework\MockObject\MockObject|\Generated\Shared\Transfer\CompanyBusinessUnitOrderListTransfer
     */
    protected $companyBusinessUnitOrderListTransferMock;

    /**
     * @var \PHPUnit\Framework\MockObject\MockObject|\Generated\Shared\Transfer\FilterTransfer
     */
    protected $filterTransferMock;

    /**
     * @var \PHPUnit\Framework\MockObject\MockObject|\Generated\Shared\Transfer\PaginationTransfer
     */
    protected $paginationTransferMock;

    /**
     * @var \FondOfSpryker\Glue\CompanyBusinessUnitsOrdersRestApi\Processor\RestResponseBuilder\OrderRestResponseBuilder
     */
    protected $orderRestResponseBuilder;

    /**
     * @return void
     */
    protected function _before(): void
    {
        parent::_before();

        $this->restResourceBuilderMock = $this->getMockBuilder(RestResourceBuilderInterface::class)
            ->disableOriginalConstructor()
            ->getMock();

        $this->orderResourceMapperMock = $this->getMockBuilder(OrderMapperInterface::class)
            ->disableOriginalConstructor()
            ->getMock();

        $this->orderTransferMock = $this->getMockBuilder(OrderTransfer::class)
            ->disableOriginalConstructor()
            ->getMock();

        $this->restOrderDetailsAttributesTransferMock = $this->getMockBuilder(RestOrderDetailsAttributesTransfer::class)
            ->disableOriginalConstructor()
            ->getMock();

        $this->restResourceMock = $this->getMockBuilder(RestResourceInterface::class)
            ->disableOriginalConstructor()
            ->getMock();

        $this->restResponseMock = $this->getMockBuilder(RestResponseInterface::class)
            ->disableOriginalConstructor()
            ->getMock();

        $this->restCompanyBusinessUnitOrderListTransferMock = $this->getMockBuilder(RestCompanyBusinessUnitOrderListTransfer::class)
            ->disableOriginalConstructor()
            ->getMock();

        $this->companyBusinessUnitOrderListTransferMock = $this->getMockBuilder(CompanyBusinessUnitOrderListTransfer::class)
            ->disableOriginalConstructor()
            ->getMock();

        $this->filterTransferMock = $this->getMockBuilder(FilterTransfer::class)
            ->disableOriginalConstructor()
            ->getMock();

        $this->paginationTransferMock = $this->getMockBuilder(PaginationTransfer::class)
            ->disableOriginalConstructor()
            ->getMock();

        $this->orderRestResponseBuilder = new OrderRestResponseBuilder(
            $this->restResourceBuilderMock,
            $this->orderResourceMapperMock
        );
    }

    /**
     * @return void
     */
    public function testCreateOrderRestResponse(): void
    {
        $orderReference = 'DE-1';
        $companyBusinessUnitUuid = 'ff823d9b-36f9-4621-b71d-a8e4fcb3a11b';

        $this->orderResourceMapperMock->expects($this->atLeastOnce())
            ->method('mapOrderTransferToRestOrderDetailsAttributesTransfer')
            ->with($this->orderTransferMock)
            ->willReturn($this->restOrderDetailsAttributesTransferMock);

        $this->orderTransferMock->expects($this->atLeastOnce())
            ->method('getOrderReference')
            ->willReturn($orderReference);

        $this->restResourceBuilderMock->expects($this->atLeastOnce())
            ->method('createRestResource')
            ->with(
                CompanyBusinessUnitsOrdersRestApiConfig::RESOURCE_COMPANY_BUSINESS_UNIT_ORDERS,
                $orderReference,
                $this->restOrderDetailsAttributesTransferMock
            )->willReturn($this->restResourceMock);

        $this->restResourceMock->expects($this->atLeastOnce())
            ->method('getId')
            ->willReturn($orderReference);

        $this->restCompanyBusinessUnitOrderListTransferMock->expects($this->atLeastOnce())
            ->method('getCompanyBusinessUnitUuid')
            ->willReturn($companyBusinessUnitUuid);

        $this->restResourceMock->expects($this->atLeastOnce())
            ->method('addLink')
            ->with(
                RestLinkInterface::LINK_SELF,
                sprintf(
                    '%s/%s/%s/%s',
                    CompanyBusinessUnitsOrdersRestApiConfig::PARENT_RESOURCE_COMPANY_BUSINESS_UNITS,
                    $companyBusinessUnitUuid,
                    CompanyBusinessUnitsOrdersRestApiConfig::RESOURCE_COMPANY_BUSINESS_UNIT_ORDERS,
                    $orderReference
                )
            )->willReturn($this->restResourceMock);

        $this->restResourceBuilderMock->expects($this->atLeastOnce())
            ->method('createRestResponse')
            ->willReturn($this->restResponseMock);

        $this->restResponseMock->expects($this->atLeastOnce())
            ->method('addResource')
            ->with($this->restResourceMock)
            ->willReturn($this->restResponseMock);

        $restResponse = $this->orderRestResponseBuilder->createOrderRestResponse(
            $this->restCompanyBusinessUnitOrderListTransferMock,
            $this->orderTransferMock
        );

        $this->assertEquals($this->restResponseMock, $restResponse);
    }

    /**
     * @return void
     */
    public function testCreateOrderRestResource(): void
    {
        $orderReference = 'DE-1';
        $companyBusinessUnitUuid = 'ff823d9b-36f9-4621-b71d-a8e4fcb3a11b';

        $this->orderResourceMapperMock->expects($this->atLeastOnce())
            ->method('mapOrderTransferToRestOrderDetailsAttributesTransfer')
            ->with($this->orderTransferMock)
            ->willReturn($this->restOrderDetailsAttributesTransferMock);

        $this->orderTransferMock->expects($this->atLeastOnce())
            ->method('getOrderReference')
            ->willReturn($orderReference);

        $this->restResourceBuilderMock->expects($this->atLeastOnce())
            ->method('createRestResource')
            ->with(
                CompanyBusinessUnitsOrdersRestApiConfig::RESOURCE_COMPANY_BUSINESS_UNIT_ORDERS,
                $orderReference,
                $this->restOrderDetailsAttributesTransferMock
            )->willReturn($this->restResourceMock);

        $this->restResourceMock->expects($this->atLeastOnce())
            ->method('getId')
            ->willReturn($orderReference);

        $this->restCompanyBusinessUnitOrderListTransferMock->expects($this->atLeastOnce())
            ->method('getCompanyBusinessUnitUuid')
            ->willReturn($companyBusinessUnitUuid);

        $this->restResourceMock->expects($this->atLeastOnce())
            ->method('addLink')
            ->with(
                RestLinkInterface::LINK_SELF,
                sprintf(
                    '%s/%s/%s/%s',
                    CompanyBusinessUnitsOrdersRestApiConfig::PARENT_RESOURCE_COMPANY_BUSINESS_UNITS,
                    $companyBusinessUnitUuid,
                    CompanyBusinessUnitsOrdersRestApiConfig::RESOURCE_COMPANY_BUSINESS_UNIT_ORDERS,
                    $orderReference
                )
            )->willReturn($this->restResourceMock);

        $restResource = $this->orderRestResponseBuilder->createOrderRestResource(
            $this->restCompanyBusinessUnitOrderListTransferMock,
            $this->orderTransferMock
        );

        $this->assertEquals($this->restResourceMock, $restResource);
    }

    /**
     * @return void
     */
    public function testCreateCompanyBusinessUnitIdentifierMissingErrorResponse(): void
    {
        $this->restResourceBuilderMock->expects($this->atLeastOnce())
            ->method('createRestResponse')
            ->willReturn($this->restResponseMock);

        $this->restResponseMock->expects($this->atLeastOnce())
            ->method('addError')
            ->with(
                $this->callback(static function (RestErrorMessageTransfer $restErrorMessageTransfer) {
                    return $restErrorMessageTransfer->getStatus() === Response::HTTP_BAD_REQUEST
                    && $restErrorMessageTransfer->getCode() === CompanyBusinessUnitsOrdersRestApiConfig::RESPONSE_CODE_COMPANY_BUSINESS_UNIT_IDENTIFIER_MISSING
                    && $restErrorMessageTransfer->getDetail() === CompanyBusinessUnitsOrdersRestApiConfig::EXCEPTION_MESSAGE_COMPANY_BUSINESS_UNIT_IDENTIFIER_MISSING;
                })
            )->willReturn($this->restResponseMock);

        $restResponse = $this->orderRestResponseBuilder->createCompanyBusinessUnitIdentifierMissingErrorResponse();

        $this->assertEquals($this->restResponseMock, $restResponse);
    }

    /**
     * @return void
     */
    public function testCreateOrderNotFoundErrorResponse(): void
    {
        $this->restResourceBuilderMock->expects($this->atLeastOnce())
            ->method('createRestResponse')
            ->willReturn($this->restResponseMock);

        $this->restResponseMock->expects($this->atLeastOnce())
            ->method('addError')
            ->with(
                $this->callback(static function (RestErrorMessageTransfer $restErrorMessageTransfer) {
                    return $restErrorMessageTransfer->getStatus() === Response::HTTP_NOT_FOUND
                        && $restErrorMessageTransfer->getCode() === CompanyBusinessUnitsOrdersRestApiConfig::RESPONSE_CODE_CANT_FIND_ORDER
                        && $restErrorMessageTransfer->getDetail() === CompanyBusinessUnitsOrdersRestApiConfig::EXCEPTION_MESSAGE_CANT_FIND_ORDER;
                })
            )->willReturn($this->restResponseMock);

        $restResponse = $this->orderRestResponseBuilder->createOrderNotFoundErrorResponse();

        $this->assertEquals($this->restResponseMock, $restResponse);
    }

    /**
     * @return void
     */
    public function testCreateOrderListRestResponse(): void
    {
        $limit = 5;
        $totalItems = 10;
        $orderReference = 'DE-1';
        $companyBusinessUnitUuid = 'ff823d9b-36f9-4621-b71d-a8e4fcb3a11b';

        $this->restCompanyBusinessUnitOrderListTransferMock->expects($this->atLeastOnce())
            ->method('getFilter')
            ->willReturn($this->filterTransferMock);

        $this->companyBusinessUnitOrderListTransferMock->expects($this->atLeastOnce())
            ->method('getPagination')
            ->willReturn($this->paginationTransferMock);

        $this->filterTransferMock->expects($this->atLeastOnce())
            ->method('getLimit')
            ->willReturn($limit);

        $this->paginationTransferMock->expects($this->atLeastOnce())
            ->method('getNbResults')
            ->willReturn($totalItems);

        $this->restResourceBuilderMock->expects($this->atLeastOnce())
            ->method('createRestResponse')
            ->with($totalItems, $limit)
            ->willReturn($this->restResponseMock);

        $this->companyBusinessUnitOrderListTransferMock->expects($this->atLeastOnce())
            ->method('getOrders')
            ->willReturn(new ArrayObject([$this->orderTransferMock]));

        $this->orderResourceMapperMock->expects($this->atLeastOnce())
            ->method('mapOrderTransferToRestOrderDetailsAttributesTransfer')
            ->with($this->orderTransferMock)
            ->willReturn($this->restOrderDetailsAttributesTransferMock);

        $this->orderTransferMock->expects($this->atLeastOnce())
            ->method('getOrderReference')
            ->willReturn($orderReference);

        $this->restResourceBuilderMock->expects($this->atLeastOnce())
            ->method('createRestResource')
            ->with(
                CompanyBusinessUnitsOrdersRestApiConfig::RESOURCE_COMPANY_BUSINESS_UNIT_ORDERS,
                $orderReference,
                $this->restOrderDetailsAttributesTransferMock
            )->willReturn($this->restResourceMock);

        $this->restResourceMock->expects($this->atLeastOnce())
            ->method('getId')
            ->willReturn($orderReference);

        $this->restCompanyBusinessUnitOrderListTransferMock->expects($this->atLeastOnce())
            ->method('getCompanyBusinessUnitUuid')
            ->willReturn($companyBusinessUnitUuid);

        $this->restResourceMock->expects($this->atLeastOnce())
            ->method('addLink')
            ->with(
                RestLinkInterface::LINK_SELF,
                sprintf(
                    '%s/%s/%s/%s',
                    CompanyBusinessUnitsOrdersRestApiConfig::PARENT_RESOURCE_COMPANY_BUSINESS_UNITS,
                    $companyBusinessUnitUuid,
                    CompanyBusinessUnitsOrdersRestApiConfig::RESOURCE_COMPANY_BUSINESS_UNIT_ORDERS,
                    $orderReference
                )
            )->willReturn($this->restResourceMock);

        $this->restResponseMock->expects($this->atLeastOnce())
            ->method('addResource')
            ->with($this->restResourceMock)
            ->willReturn($this->restResponseMock);

        $restResponse = $this->orderRestResponseBuilder->createOrderListRestResponse(
            $this->restCompanyBusinessUnitOrderListTransferMock,
            $this->companyBusinessUnitOrderListTransferMock
        );

        $this->assertEquals($this->restResponseMock, $restResponse);
    }
}
