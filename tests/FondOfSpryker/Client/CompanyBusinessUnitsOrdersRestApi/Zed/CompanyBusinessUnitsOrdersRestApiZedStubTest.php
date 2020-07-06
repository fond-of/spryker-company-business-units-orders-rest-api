<?php

namespace FondOfSpryker\Client\CompanyBusinessUnitsOrdersRestApi\Zed;

use Codeception\Test\Unit;
use FondOfSpryker\Client\CompanyBusinessUnitsOrdersRestApi\Dependency\Client\CompanyBusinessUnitsOrdersRestApiToZedRequestClientInterface;
use Generated\Shared\Transfer\CompanyBusinessUnitOrderListTransfer;
use Generated\Shared\Transfer\RestCompanyBusinessUnitOrderListTransfer;

class CompanyBusinessUnitsOrdersRestApiZedStubTest extends Unit
{
    /**
     * @var \PHPUnit\Framework\MockObject\MockObject|\FondOfSpryker\Client\CompanyBusinessUnitsOrdersRestApi\Dependency\Client\CompanyBusinessUnitsOrdersRestApiToZedRequestClientInterface
     */
    protected $zedRequestClientMock;

    /**
     * @var \PHPUnit\Framework\MockObject\MockObject|\Generated\Shared\Transfer\RestCompanyBusinessUnitOrderListTransfer
     */
    protected $restCompanyBusinessUnitOrderListTransferMock;

    /**
     * @var \PHPUnit\Framework\MockObject\MockObject|\Generated\Shared\Transfer\CompanyBusinessUnitOrderListTransfer
     */
    protected $companyBusinessUnitOrderListTransferMock;

    /**
     * @var \FondOfSpryker\Client\CompanyBusinessUnitsOrdersRestApi\Zed\CompanyBusinessUnitsOrdersRestApiZedStub
     */
    protected $companyBusinessUnitsOrdersRestApiZedStub;

    /**
     * @return void
     */
    protected function _before(): void
    {
        parent::_before();

        $this->zedRequestClientMock = $this->getMockBuilder(CompanyBusinessUnitsOrdersRestApiToZedRequestClientInterface::class)
            ->disableOriginalConstructor()
            ->getMock();

        $this->restCompanyBusinessUnitOrderListTransferMock = $this->getMockBuilder(RestCompanyBusinessUnitOrderListTransfer::class)
            ->disableOriginalConstructor()
            ->getMock();

        $this->companyBusinessUnitOrderListTransferMock = $this->getMockBuilder(CompanyBusinessUnitOrderListTransfer::class)
            ->disableOriginalConstructor()
            ->getMock();

        $this->companyBusinessUnitsOrdersRestApiZedStub = new CompanyBusinessUnitsOrdersRestApiZedStub(
            $this->zedRequestClientMock
        );
    }

    /**
     * @return void
     */
    public function testFindOrders(): void
    {
        $this->zedRequestClientMock->expects($this->atLeastOnce())
            ->method('call')
            ->with(
                '/company-business-units-orders-rest-api/gateway/find-orders',
                $this->restCompanyBusinessUnitOrderListTransferMock
            )->willReturn($this->companyBusinessUnitOrderListTransferMock);

        $companyBusinessUnitOrderListTransfer = $this->companyBusinessUnitsOrdersRestApiZedStub->findOrders(
            $this->restCompanyBusinessUnitOrderListTransferMock
        );

        $this->assertEquals(
            $this->companyBusinessUnitOrderListTransferMock,
            $companyBusinessUnitOrderListTransfer
        );
    }
}
