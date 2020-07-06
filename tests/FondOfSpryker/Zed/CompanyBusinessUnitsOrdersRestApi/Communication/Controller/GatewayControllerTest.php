<?php

namespace FondOfSpryker\Zed\CompanyBusinessUnitsOrdersRestApi\Communication\Controller;

use Codeception\Test\Unit;
use FondOfSpryker\Zed\CompanyBusinessUnitsOrdersRestApi\Business\CompanyBusinessUnitsOrdersRestApiFacade;
use Generated\Shared\Transfer\CompanyBusinessUnitOrderListTransfer;
use Generated\Shared\Transfer\RestCompanyBusinessUnitOrderListTransfer;
use Spryker\Zed\Kernel\Business\AbstractFacade;

class GatewayControllerTest extends Unit
{
    /**
     * @var \PHPUnit\Framework\MockObject\MockObject
     */
    protected $companyBusinessUnitsOrdersRestApiFacadeMock;

    /**
     * @var \PHPUnit\Framework\MockObject\MockObject|\Generated\Shared\Transfer\RestCompanyBusinessUnitOrderListTransfer
     */
    protected $restCompanyBusinessUnitOrderListTransferMock;

    /**
     * @var \PHPUnit\Framework\MockObject\MockObject|\Generated\Shared\Transfer\CompanyBusinessUnitOrderListTransfer
     */
    protected $companyBusinessUnitOrderListTransferMock;

    /**
     * @var \FondOfSpryker\Zed\CompanyBusinessUnitsOrdersRestApi\Communication\Controller\GatewayController
     */
    protected $gatewayController;

    /**
     * @return void
     */
    protected function _before(): void
    {
        parent::_before();

        $this->companyBusinessUnitsOrdersRestApiFacadeMock = $this->getMockBuilder(CompanyBusinessUnitsOrdersRestApiFacade::class)
            ->disableOriginalConstructor()
            ->getMock();

        $this->restCompanyBusinessUnitOrderListTransferMock = $this->getMockBuilder(RestCompanyBusinessUnitOrderListTransfer::class)
            ->disableOriginalConstructor()
            ->getMock();

        $this->companyBusinessUnitOrderListTransferMock = $this->getMockBuilder(CompanyBusinessUnitOrderListTransfer::class)
            ->disableOriginalConstructor()
            ->getMock();

        $this->gatewayController = new class ($this->companyBusinessUnitsOrdersRestApiFacadeMock) extends GatewayController {
            /**
             * @var \Spryker\Zed\Kernel\Business\AbstractFacade
             */
            protected $facade;

            public function __construct(AbstractFacade $facade)
            {
                $this->facade = $facade;
            }

            protected function getFacade(): AbstractFacade
            {
                return $this->facade;
            }
        };
    }

    /**
     * @return void
     */
    public function testFindOrdersAction(): void
    {
        $this->companyBusinessUnitsOrdersRestApiFacadeMock->expects($this->atLeastOnce())
            ->method('findOrders')
            ->with($this->restCompanyBusinessUnitOrderListTransferMock)
            ->willReturn($this->companyBusinessUnitOrderListTransferMock);

        $companyBusinessUnitOrderListTransfer = $this->gatewayController->findOrdersAction(
            $this->restCompanyBusinessUnitOrderListTransferMock
        );

        $this->assertEquals(
            $this->companyBusinessUnitOrderListTransferMock,
            $companyBusinessUnitOrderListTransfer
        );
    }
}
