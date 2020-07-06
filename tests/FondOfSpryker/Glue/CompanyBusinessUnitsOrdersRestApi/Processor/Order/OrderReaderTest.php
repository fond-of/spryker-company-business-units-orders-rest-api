<?php

namespace FondOfSpryker\Glue\CompanyBusinessUnitsOrdersRestApi\Processor\Order;

use Codeception\Test\Unit;
use FondOfSpryker\Client\CompanyBusinessUnitsOrdersRestApi\CompanyBusinessUnitsOrdersRestApiClientInterface;
use FondOfSpryker\Glue\CompanyBusinessUnitsOrdersRestApi\CompanyBusinessUnitsOrdersRestApiConfig;
use FondOfSpryker\Glue\CompanyBusinessUnitsOrdersRestApi\Processor\RestResponseBuilder\OrderRestResponseBuilderInterface;
use Generated\Shared\Transfer\CompanyBusinessUnitOrderListTransfer;
use Generated\Shared\Transfer\RestCompanyBusinessUnitOrderListTransfer;
use Generated\Shared\Transfer\RestUserTransfer;
use Spryker\Glue\GlueApplication\Rest\JsonApi\RestResourceInterface;
use Spryker\Glue\GlueApplication\Rest\JsonApi\RestResponseInterface;
use Spryker\Glue\GlueApplication\Rest\Request\Data\PageInterface;
use Spryker\Glue\GlueApplication\Rest\Request\Data\RestRequestInterface;

class OrderReaderTest extends Unit
{
    /**
     * @var \PHPUnit\Framework\MockObject\MockObject|\FondOfSpryker\Client\CompanyBusinessUnitsOrdersRestApi\CompanyBusinessUnitsOrdersRestApiClientInterface
     */
    protected $clientMock;

    /**
     * @var \PHPUnit\Framework\MockObject\MockObject|\FondOfSpryker\Glue\CompanyBusinessUnitsOrdersRestApi\Processor\RestResponseBuilder\OrderRestResponseBuilderInterface
     */
    protected $orderRestResponseBuilderMock;

    /**
     * @var \PHPUnit\Framework\MockObject\MockObject|\Spryker\Glue\GlueApplication\Rest\Request\Data\RestRequestInterface
     */
    protected $restRequestMock;

    /**
     * @var \PHPUnit\Framework\MockObject\MockObject|\Spryker\Glue\GlueApplication\Rest\JsonApi\RestResponseInterface
     */
    protected $restResponseMock;

    /**
     * @var \PHPUnit\Framework\MockObject\MockObject|\Spryker\Glue\GlueApplication\Rest\JsonApi\RestResourceInterface
     */
    protected $restResourceMock;

    /**
     * @var string
     */
    protected $companyBusinessUnitUuid;

    /**
     * @var int
     */
    protected $idCustomer;

    /**
     * @var \PHPUnit\Framework\MockObject\MockObject
     */
    protected $restUserTransferMock;

    /**
     * @var \PHPUnit\Framework\MockObject\MockObject|\Spryker\Glue\GlueApplication\Rest\Request\Data\PageInterface
     */
    protected $pageMock;

    /**
     * @var \PHPUnit\Framework\MockObject\MockObject|\Generated\Shared\Transfer\CompanyBusinessUnitOrderListTransfer
     */
    protected $companyBusinessUnitOrderListTransferMock;

    /**
     * @var \FondOfSpryker\Glue\CompanyBusinessUnitsOrdersRestApi\Processor\Order\OrderReaderInterface
     */
    protected $orderReader;

    /**
     * @return void
     */
    protected function _before(): void
    {
        parent::_before();

        $this->clientMock = $this->getMockBuilder(CompanyBusinessUnitsOrdersRestApiClientInterface::class)
            ->disableOriginalConstructor()
            ->getMock();

        $this->orderRestResponseBuilderMock = $this->getMockBuilder(OrderRestResponseBuilderInterface::class)
            ->disableOriginalConstructor()
            ->getMock();

        $this->restRequestMock = $this->getMockBuilder(RestRequestInterface::class)
            ->disableOriginalConstructor()
            ->getMock();

        $this->restResponseMock = $this->getMockBuilder(RestResponseInterface::class)
            ->disableOriginalConstructor()
            ->getMock();

        $this->restResourceMock = $this->getMockBuilder(RestResourceInterface::class)
            ->disableOriginalConstructor()
            ->getMock();

        $this->restUserTransferMock = $this->getMockBuilder(RestUserTransfer::class)
            ->disableOriginalConstructor()
            ->getMock();

        $this->pageMock = $this->getMockBuilder(PageInterface::class)
            ->disableOriginalConstructor()
            ->getMock();

        $this->companyBusinessUnitOrderListTransferMock = $this->getMockBuilder(CompanyBusinessUnitOrderListTransfer::class)
            ->disableOriginalConstructor()
            ->getMock();

        $this->companyBusinessUnitUuid = '0fc338f9-9ffa-4276-93da-37d21ffcecb7';
        $this->idCustomer = 1;

        $this->orderReader = new OrderReader(
            $this->clientMock,
            $this->orderRestResponseBuilderMock
        );
    }

    /**
     * @return void
     */
    public function testFindOrders(): void
    {
        $this->restRequestMock->expects($this->atLeastOnce())
            ->method('findParentResourceByType')
            ->with(CompanyBusinessUnitsOrdersRestApiConfig::PARENT_RESOURCE_COMPANY_BUSINESS_UNITS)
            ->willReturn($this->restResourceMock);

        $this->restResourceMock->expects($this->atLeastOnce())
            ->method('getId')
            ->willReturn($this->companyBusinessUnitUuid);

        $this->orderRestResponseBuilderMock->expects($this->never())
            ->method('createCompanyBusinessUnitIdentifierMissingErrorResponse');

        $this->restRequestMock->expects($this->atLeastOnce())
            ->method('getRestUser')
            ->willReturn($this->restUserTransferMock);

        $this->restUserTransferMock->expects($this->atLeastOnce())
            ->method('getSurrogateIdentifier')
            ->willReturn($this->idCustomer);

        $this->restRequestMock->expects($this->atLeastOnce())
            ->method('getPage')
            ->willReturn($this->pageMock);

        $this->pageMock->expects($this->atLeastOnce())
            ->method('getLimit')
            ->willReturn(10);

        $this->pageMock->expects($this->atLeastOnce())
            ->method('getOffset')
            ->willReturn(0);

        $self = $this;
        $this->clientMock->expects($this->atLeastOnce())
            ->method('findOrders')
            ->with(
                $this->callback(
                    static function (RestCompanyBusinessUnitOrderListTransfer $restCompanyBusinessUnitOrderListTransfer) use ($self) {
                        return $restCompanyBusinessUnitOrderListTransfer->getIdCustomer() === $self->idCustomer
                            && $restCompanyBusinessUnitOrderListTransfer->getCompanyBusinessUnitUuid() === $self->companyBusinessUnitUuid
                            && $restCompanyBusinessUnitOrderListTransfer->getFilter() !== null;
                    }
                )
            )->willReturn($this->companyBusinessUnitOrderListTransferMock);

        $this->orderRestResponseBuilderMock->expects($this->atLeastOnce())
            ->method('createOrderListRestResponse')
            ->willReturn($this->restResponseMock);

        $this->assertEquals($this->restResponseMock, $this->orderReader->findOrders($this->restRequestMock));
    }

    /**
     * @return void
     */
    public function testFindOrdersWithoutPagination(): void
    {
        $this->restRequestMock->expects($this->atLeastOnce())
            ->method('findParentResourceByType')
            ->with(CompanyBusinessUnitsOrdersRestApiConfig::PARENT_RESOURCE_COMPANY_BUSINESS_UNITS)
            ->willReturn($this->restResourceMock);

        $this->restResourceMock->expects($this->atLeastOnce())
            ->method('getId')
            ->willReturn($this->companyBusinessUnitUuid);

        $this->orderRestResponseBuilderMock->expects($this->never())
            ->method('createCompanyBusinessUnitIdentifierMissingErrorResponse');

        $this->restRequestMock->expects($this->atLeastOnce())
            ->method('getRestUser')
            ->willReturn($this->restUserTransferMock);

        $this->restUserTransferMock->expects($this->atLeastOnce())
            ->method('getSurrogateIdentifier')
            ->willReturn($this->idCustomer);

        $this->restRequestMock->expects($this->atLeastOnce())
            ->method('getPage')
            ->willReturn(null);

        $self = $this;
        $this->clientMock->expects($this->atLeastOnce())
            ->method('findOrders')
            ->with(
                $this->callback(
                    static function (RestCompanyBusinessUnitOrderListTransfer $restCompanyBusinessUnitOrderListTransfer) use ($self) {
                        return $restCompanyBusinessUnitOrderListTransfer->getIdCustomer() === $self->idCustomer
                            && $restCompanyBusinessUnitOrderListTransfer->getCompanyBusinessUnitUuid() === $self->companyBusinessUnitUuid
                            && $restCompanyBusinessUnitOrderListTransfer->getFilter() === null;
                    }
                )
            )->willReturn($this->companyBusinessUnitOrderListTransferMock);

        $this->orderRestResponseBuilderMock->expects($this->atLeastOnce())
            ->method('createOrderListRestResponse')
            ->willReturn($this->restResponseMock);

        $this->assertEquals($this->restResponseMock, $this->orderReader->findOrders($this->restRequestMock));
    }

    /**
     * @return void
     */
    public function testFindOrdersWithoutParentResource(): void
    {
        $this->restRequestMock->expects($this->atLeastOnce())
            ->method('findParentResourceByType')
            ->with(CompanyBusinessUnitsOrdersRestApiConfig::PARENT_RESOURCE_COMPANY_BUSINESS_UNITS)
            ->willReturn(null);

        $this->restResourceMock->expects($this->never())
            ->method('getId');

        $this->orderRestResponseBuilderMock->expects($this->atLeastOnce())
            ->method('createCompanyBusinessUnitIdentifierMissingErrorResponse')
            ->willReturn($this->restResponseMock);

        $this->restRequestMock->expects($this->never())
            ->method('getRestUser');

        $this->restRequestMock->expects($this->never())
            ->method('getPage');

        $self = $this;
        $this->clientMock->expects($this->never())
            ->method('findOrders');

        $this->orderRestResponseBuilderMock->expects($this->never())
            ->method('createOrderListRestResponse');

        $this->assertEquals($this->restResponseMock, $this->orderReader->findOrders($this->restRequestMock));
    }
}
