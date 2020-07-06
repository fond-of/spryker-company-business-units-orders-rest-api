<?php

namespace FondOfSpryker\Client\CompanyBusinessUnitsOrdersRestApi;

use Codeception\Test\Unit;
use FondOfSpryker\Client\CompanyBusinessUnitsOrdersRestApi\Zed\CompanyBusinessUnitsOrdersRestApiZedStubInterface;
use Generated\Shared\Transfer\CompanyBusinessUnitOrderListTransfer;
use Generated\Shared\Transfer\RestCompanyBusinessUnitOrderListTransfer;

class CompanyBusinessUnitsOrdersRestApiClientTest extends Unit
{
    /**
     * @var \PHPUnit\Framework\MockObject\MockObject|\FondOfSpryker\Client\CompanyBusinessUnitsOrdersRestApi\CompanyBusinessUnitsOrdersRestApiFactory
     */
    protected $companyBusinessUnitsOrdersRestApiFactoryMock;

    /**
     * @var \PHPUnit\Framework\MockObject\MockObject|\FondOfSpryker\Client\CompanyBusinessUnitsOrdersRestApi\Zed\CompanyBusinessUnitsOrdersRestApiZedStubInterface
     */
    protected $companyBusinessUnitsOrdersRestApiZedStubMock;

    /**
     * @var \PHPUnit\Framework\MockObject\MockObject|\Generated\Shared\Transfer\RestCompanyBusinessUnitOrderListTransfer
     */
    protected $restCompanyBusinessUnitOrderListTransferMock;

    /**
     * @var \PHPUnit\Framework\MockObject\MockObject|\Generated\Shared\Transfer\CompanyBusinessUnitOrderListTransfer
     */
    protected $companyBusinessUnitOrderListTransferMock;

    /**
     * @var \FondOfSpryker\Client\CompanyBusinessUnitsOrdersRestApi\CompanyBusinessUnitsOrdersRestApiClient
     */
    protected $companyBusinessUnitsOrdersRestApiClient;

    /**
     * @return void
     */
    protected function _before(): void
    {
        parent::_before();

        $this->companyBusinessUnitsOrdersRestApiFactoryMock = $this->getMockBuilder(CompanyBusinessUnitsOrdersRestApiFactory::class)
            ->disableOriginalConstructor()
            ->getMock();

        $this->companyBusinessUnitsOrdersRestApiZedStubMock = $this->getMockBuilder(CompanyBusinessUnitsOrdersRestApiZedStubInterface::class)
            ->disableOriginalConstructor()
            ->getMock();

        $this->restCompanyBusinessUnitOrderListTransferMock = $this->getMockBuilder(RestCompanyBusinessUnitOrderListTransfer::class)
            ->disableOriginalConstructor()
            ->getMock();

        $this->companyBusinessUnitOrderListTransferMock = $this->getMockBuilder(CompanyBusinessUnitOrderListTransfer::class)
            ->disableOriginalConstructor()
            ->getMock();

        $this->companyBusinessUnitsOrdersRestApiClient = new CompanyBusinessUnitsOrdersRestApiClient();
        $this->companyBusinessUnitsOrdersRestApiClient->setFactory($this->companyBusinessUnitsOrdersRestApiFactoryMock);
    }

    /**
     * @return void
     */
    public function testFindOrders(): void
    {
        $this->companyBusinessUnitsOrdersRestApiFactoryMock->expects($this->atLeastOnce())
            ->method('createCompanyBusinessUnitsOrdersRestApiZedStub')
            ->willReturn($this->companyBusinessUnitsOrdersRestApiZedStubMock);

        $this->companyBusinessUnitsOrdersRestApiZedStubMock->expects($this->atLeastOnce())
            ->method('findOrders')
            ->with($this->restCompanyBusinessUnitOrderListTransferMock)
            ->willReturn($this->companyBusinessUnitOrderListTransferMock);

        $companyBusinessUnitOrderListTransfer = $this->companyBusinessUnitsOrdersRestApiClient->findOrders(
            $this->restCompanyBusinessUnitOrderListTransferMock
        );

        $this->assertEquals($this->companyBusinessUnitOrderListTransferMock, $companyBusinessUnitOrderListTransfer);
    }
}
