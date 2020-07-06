<?php

namespace FondOfSpryker\Zed\CompanyBusinessUnitsOrdersRestApi\Dependency\Facade;

use Codeception\Test\Unit;
use FondOfSpryker\Zed\CompanyBusinessUnitSales\Business\CompanyBusinessUnitSalesFacadeInterface;
use Generated\Shared\Transfer\CompanyBusinessUnitOrderListRequestTransfer;
use Generated\Shared\Transfer\CompanyBusinessUnitOrderListTransfer;

class CompanyBusinessUnitsOrdersRestApiToCompanyBusinessUnitSalesFacadeBridgeTest extends Unit
{
    /**
     * @var \PHPUnit\Framework\MockObject\MockObject|\FondOfSpryker\Zed\CompanyBusinessUnitSales\Business\CompanyBusinessUnitSalesFacadeInterface
     */
    protected $companyBusinessUnitSalesFacadeMock;

    /**
     * @var \PHPUnit\Framework\MockObject\MockObject|\Generated\Shared\Transfer\CompanyBusinessUnitOrderListRequestTransfer
     */
    protected $companyBusinessUnitOrderListRequestTransferMock;

    /**
     * @var \PHPUnit\Framework\MockObject\MockObject|\Generated\Shared\Transfer\CompanyBusinessUnitOrderListTransfer
     */
    protected $companyBusinessUnitOrderListTransferMock;

    /**
     * @var \FondOfSpryker\Zed\CompanyBusinessUnitsOrdersRestApi\Dependency\Facade\CompanyBusinessUnitsOrdersRestApiToCompanyBusinessUnitSalesFacadeBridge
     */
    protected $companyBusinessUnitsOrdersRestApiToCompanyBusinessUnitSalesFacadeBridge;

    /**
     * @return void
     */
    protected function _before(): void
    {
        parent::_before();

        $this->companyBusinessUnitSalesFacadeMock = $this->getMockBuilder(CompanyBusinessUnitSalesFacadeInterface::class)
            ->disableOriginalConstructor()
            ->getMock();

        $this->companyBusinessUnitOrderListRequestTransferMock = $this->getMockBuilder(CompanyBusinessUnitOrderListRequestTransfer::class)
            ->disableOriginalConstructor()
            ->getMock();

        $this->companyBusinessUnitOrderListTransferMock = $this->getMockBuilder(CompanyBusinessUnitOrderListTransfer::class)
            ->disableOriginalConstructor()
            ->getMock();

        $this->companyBusinessUnitsOrdersRestApiToCompanyBusinessUnitSalesFacadeBridge = new CompanyBusinessUnitsOrdersRestApiToCompanyBusinessUnitSalesFacadeBridge(
            $this->companyBusinessUnitSalesFacadeMock
        );
    }

    /**
     * @return void
     */
    public function testFindOrders(): void
    {
        $this->companyBusinessUnitSalesFacadeMock->expects($this->atLeastOnce())
            ->method('findOrders')
            ->with($this->companyBusinessUnitOrderListRequestTransferMock)
            ->willReturn($this->companyBusinessUnitOrderListTransferMock);

        $companyBusinessUnitOrderListTransfer = $this->companyBusinessUnitsOrdersRestApiToCompanyBusinessUnitSalesFacadeBridge
            ->findOrders($this->companyBusinessUnitOrderListRequestTransferMock);

        $this->assertEquals($companyBusinessUnitOrderListTransfer, $this->companyBusinessUnitOrderListTransferMock);
    }
}
