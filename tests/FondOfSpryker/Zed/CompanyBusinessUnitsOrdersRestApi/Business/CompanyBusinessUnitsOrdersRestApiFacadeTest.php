<?php

namespace FondOfSpryker\Zed\CompanyBusinessUnitsOrdersRestApi\Business;

use Codeception\Test\Unit;
use FondOfSpryker\Zed\CompanyBusinessUnitsOrdersRestApi\Business\Model\OrderReaderInterface;
use Generated\Shared\Transfer\CompanyBusinessUnitOrderListTransfer;
use Generated\Shared\Transfer\RestCompanyBusinessUnitOrderListTransfer;

class CompanyBusinessUnitsOrdersRestApiFacadeTest extends Unit
{
    /**
     * @var \PHPUnit\Framework\MockObject\MockObject|CompanyBusinessUnitsOrdersRestApiBusinessFactory
     */
    protected $companyBusinessUnitsOrdersRestApiBusinessFactoryMock;

    /**
     * @var \PHPUnit\Framework\MockObject\MockObject|\Generated\Shared\Transfer\RestCompanyBusinessUnitOrderListTransfer
     */
    protected $restCompanyBusinessUnitOrderListTransferMock;

    /**
     * @var \PHPUnit\Framework\MockObject\MockObject|\Generated\Shared\Transfer\CompanyBusinessUnitOrderListTransfer
     */
    protected $companyBusinessUnitOrderListTransferMock;

    /**
     * @var \PHPUnit\Framework\MockObject\MockObject|\FondOfSpryker\Zed\CompanyBusinessUnitsOrdersRestApi\Business\Model\OrderReaderInterface
     */
    protected $orderReaderMock;

    /**
     * @var \FondOfSpryker\Zed\CompanyBusinessUnitsOrdersRestApi\Business\CompanyBusinessUnitsOrdersRestApiFacade
     */
    protected $companyBusinessUnitsOrdersRestApiFacade;

    /**
     * @return void
     */
    protected function _before(): void
    {
        parent::_before();

        $this->companyBusinessUnitsOrdersRestApiBusinessFactoryMock = $this->getMockBuilder(CompanyBusinessUnitsOrdersRestApiBusinessFactory::class)
            ->disableOriginalConstructor()
            ->getMock();

        $this->restCompanyBusinessUnitOrderListTransferMock = $this->getMockBuilder(RestCompanyBusinessUnitOrderListTransfer::class)
            ->disableOriginalConstructor()
            ->getMock();

        $this->companyBusinessUnitOrderListTransferMock = $this->getMockBuilder(CompanyBusinessUnitOrderListTransfer::class)
            ->disableOriginalConstructor()
            ->getMock();

        $this->orderReaderMock = $this->getMockBuilder(OrderReaderInterface::class)
            ->disableOriginalConstructor()
            ->getMock();

        $this->companyBusinessUnitsOrdersRestApiFacade = new CompanyBusinessUnitsOrdersRestApiFacade();
        $this->companyBusinessUnitsOrdersRestApiFacade->setFactory($this->companyBusinessUnitsOrdersRestApiBusinessFactoryMock);
    }

    /**
     * @return void
     */
    public function testFindOrders(): void
    {
        $this->companyBusinessUnitsOrdersRestApiBusinessFactoryMock->expects($this->atLeastOnce())
            ->method('createOrderReader')
            ->willReturn($this->orderReaderMock);

        $this->orderReaderMock->expects($this->atLeastOnce())
            ->method('find')
            ->with($this->restCompanyBusinessUnitOrderListTransferMock)
            ->willReturn($this->companyBusinessUnitOrderListTransferMock);

        $companyBusinessUnitOrderListTransfer = $this->companyBusinessUnitsOrdersRestApiFacade->findOrders(
            $this->restCompanyBusinessUnitOrderListTransferMock
        );

        $this->assertEquals(
            $this->companyBusinessUnitOrderListTransferMock,
            $companyBusinessUnitOrderListTransfer
        );
    }
}
