<?php

namespace FondOfSpryker\Zed\CompanyBusinessUnitsOrdersRestApi\Business\Model;

use Codeception\Test\Unit;
use FondOfSpryker\Zed\CompanyBusinessUnitsOrdersRestApi\Dependency\Facade\CompanyBusinessUnitsOrdersRestApiToCompanyBusinessUnitSalesFacadeInterface;
use Generated\Shared\Transfer\CompanyBusinessUnitOrderListRequestTransfer;
use Generated\Shared\Transfer\CompanyBusinessUnitOrderListTransfer;
use Generated\Shared\Transfer\CompanyBusinessUnitTransfer;
use Generated\Shared\Transfer\RestCompanyBusinessUnitOrderListTransfer;

class OrderReaderTest extends Unit
{
    /**
     * @var \PHPUnit\Framework\MockObject\MockObject|\FondOfSpryker\Zed\CompanyBusinessUnitsOrdersRestApi\Business\Model\CompanyBusinessUnitReaderInterface
     */
    protected $companyBusinessUnitReaderMock;

    /**
     * @var \PHPUnit\Framework\MockObject\MockObject|\FondOfSpryker\Zed\CompanyBusinessUnitsOrdersRestApi\Dependency\Facade\CompanyBusinessUnitsOrdersRestApiToCompanyBusinessUnitSalesFacadeInterface
     */
    protected $companyBusinessUnitSalesFacadeMock;

    /**
     * @var \PHPUnit\Framework\MockObject\MockObject|\FondOfSpryker\Zed\CompanyBusinessUnitsOrdersRestApi\Business\Model\RestCompanyBusinessUnitOrderListMapperInterface
     */
    protected $restCompanyBusinessUnitOrderListMapperMock;

    /**
     * @var \PHPUnit\Framework\MockObject\MockObject|\Generated\Shared\Transfer\RestCompanyBusinessUnitOrderListTransfer
     */
    protected $restCompanyBusinessUnitOrderListTransferMock;

    /**
     * @var \PHPUnit\Framework\MockObject\MockObject|\Generated\Shared\Transfer\CompanyBusinessUnitTransfer
     */
    protected $companyBusinessUnitTransferMock;

    /**
     * @var \PHPUnit\Framework\MockObject\MockObject|\Generated\Shared\Transfer\CompanyBusinessUnitOrderListRequestTransfer
     */
    protected $companyBusinessUnitOrderListRequestTransferMock;

    /**
     * @var \PHPUnit\Framework\MockObject\MockObject|\Generated\Shared\Transfer\CompanyBusinessUnitOrderListTransfer
     */
    protected $companyBusinessUnitOrderListTransferMock;

    /**
     * @var \FondOfSpryker\Zed\CompanyBusinessUnitsOrdersRestApi\Business\Model\OrderReaderInterface
     */
    protected $orderReader;

    /**
     * @return void
     */
    protected function _before(): void
    {
        parent::_before();

        $this->companyBusinessUnitReaderMock = $this->getMockBuilder(CompanyBusinessUnitReaderInterface::class)
            ->disableOriginalConstructor()
            ->getMock();

        $this->companyBusinessUnitSalesFacadeMock = $this->getMockBuilder(CompanyBusinessUnitsOrdersRestApiToCompanyBusinessUnitSalesFacadeInterface::class)
            ->disableOriginalConstructor()
            ->getMock();

        $this->restCompanyBusinessUnitOrderListMapperMock = $this->getMockBuilder(RestCompanyBusinessUnitOrderListMapperInterface::class)
            ->disableOriginalConstructor()
            ->getMock();

        $this->restCompanyBusinessUnitOrderListTransferMock = $this->getMockBuilder(RestCompanyBusinessUnitOrderListTransfer::class)
            ->disableOriginalConstructor()
            ->getMock();

        $this->companyBusinessUnitOrderListRequestTransferMock = $this->getMockBuilder(CompanyBusinessUnitOrderListRequestTransfer::class)
            ->disableOriginalConstructor()
            ->getMock();

        $this->companyBusinessUnitOrderListTransferMock = $this->getMockBuilder(CompanyBusinessUnitOrderListTransfer::class)
            ->disableOriginalConstructor()
            ->getMock();

        $this->companyBusinessUnitTransferMock = $this->getMockBuilder(CompanyBusinessUnitTransfer::class)
            ->disableOriginalConstructor()
            ->getMock();

        $this->orderReader = new OrderReader(
            $this->companyBusinessUnitReaderMock,
            $this->companyBusinessUnitSalesFacadeMock,
            $this->restCompanyBusinessUnitOrderListMapperMock
        );
    }

    /**
     * @return void
     */
    public function testFind(): void
    {
        $idCompanyBusinessUnit = 1;

        $this->restCompanyBusinessUnitOrderListMapperMock->expects($this->atLeastOnce())
            ->method('mapToCompanyBusinessUnitOrderListRequestTransfer')
            ->with($this->restCompanyBusinessUnitOrderListTransferMock)
            ->willReturn($this->companyBusinessUnitOrderListRequestTransferMock);

        $this->companyBusinessUnitReaderMock->expects($this->atLeastOnce())
            ->method('getByRestCompanyBusinessUnitOrderList')
            ->with($this->restCompanyBusinessUnitOrderListTransferMock)
            ->willReturn($this->companyBusinessUnitTransferMock);

        $this->companyBusinessUnitTransferMock->expects($this->atLeastOnce())
            ->method('getIdCompanyBusinessUnit')
            ->willReturn($idCompanyBusinessUnit);

        $this->companyBusinessUnitOrderListRequestTransferMock->expects($this->atLeastOnce())
            ->method('setIdCompanyBusinessUnit')
            ->with($idCompanyBusinessUnit)
            ->willReturn($this->companyBusinessUnitOrderListRequestTransferMock);

        $this->companyBusinessUnitSalesFacadeMock->expects($this->atLeastOnce())
            ->method('findOrders')
            ->with($this->companyBusinessUnitOrderListRequestTransferMock)
            ->willReturn($this->companyBusinessUnitOrderListTransferMock);

        $companyBusinessUnitOrderListTransfer = $this->orderReader
            ->find($this->restCompanyBusinessUnitOrderListTransferMock);

        $this->assertEquals(
            $this->companyBusinessUnitOrderListTransferMock,
            $companyBusinessUnitOrderListTransfer
        );
    }

    /**
     * @return void
     */
    public function testFindWithoutExistingCompanyBusinessUnit(): void
    {
        $this->restCompanyBusinessUnitOrderListMapperMock->expects($this->atLeastOnce())
            ->method('mapToCompanyBusinessUnitOrderListRequestTransfer')
            ->with($this->restCompanyBusinessUnitOrderListTransferMock)
            ->willReturn($this->companyBusinessUnitOrderListRequestTransferMock);

        $this->companyBusinessUnitReaderMock->expects($this->atLeastOnce())
            ->method('getByRestCompanyBusinessUnitOrderList')
            ->with($this->restCompanyBusinessUnitOrderListTransferMock)
            ->willReturn(null);

        $this->companyBusinessUnitSalesFacadeMock->expects($this->atLeastOnce())
            ->method('findOrders')
            ->with($this->companyBusinessUnitOrderListRequestTransferMock)
            ->willReturn($this->companyBusinessUnitOrderListTransferMock);

        $companyBusinessUnitOrderListTransfer = $this->orderReader
            ->find($this->restCompanyBusinessUnitOrderListTransferMock);

        $this->assertEquals(
            $this->companyBusinessUnitOrderListTransferMock,
            $companyBusinessUnitOrderListTransfer
        );
    }
}
