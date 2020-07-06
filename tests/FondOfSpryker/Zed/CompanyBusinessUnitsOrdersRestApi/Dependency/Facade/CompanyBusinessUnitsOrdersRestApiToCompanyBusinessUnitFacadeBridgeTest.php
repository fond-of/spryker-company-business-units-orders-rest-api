<?php

namespace FondOfSpryker\Zed\CompanyBusinessUnitsOrdersRestApi\Dependency\Facade;

use Codeception\Test\Unit;
use Generated\Shared\Transfer\CompanyBusinessUnitResponseTransfer;
use Generated\Shared\Transfer\CompanyBusinessUnitTransfer;
use Spryker\Zed\CompanyBusinessUnit\Business\CompanyBusinessUnitFacadeInterface;

class CompanyBusinessUnitsOrdersRestApiToCompanyBusinessUnitFacadeBridgeTest extends Unit
{
    /**
     * @var \PHPUnit\Framework\MockObject\MockObject|\Spryker\Zed\CompanyBusinessUnit\Business\CompanyBusinessUnitFacadeInterface
     */
    protected $companyBusinessUnitFacadeMock;

    /**
     * @var \PHPUnit\Framework\MockObject\MockObject|\Generated\Shared\Transfer\CompanyBusinessUnitTransfer
     */
    protected $companyBusinessUnitTransferMock;

    /**
     * @var \PHPUnit\Framework\MockObject\MockObject|\Generated\Shared\Transfer\CompanyBusinessUnitResponseTransfer
     */
    protected $companyBusinessUnitResponseTransferMock;

    /**
     * @var \FondOfSpryker\Zed\CompanyBusinessUnitsOrdersRestApi\Dependency\Facade\CompanyBusinessUnitsOrdersRestApiToCompanyBusinessUnitFacadeBridge
     */
    protected $companyBusinessUnitsOrdersRestApiToCompanyBusinessUnitFacadeBridge;

    /**
     * @return void
     */
    protected function _before(): void
    {
        parent::_before();

        $this->companyBusinessUnitFacadeMock = $this->getMockBuilder(CompanyBusinessUnitFacadeInterface::class)
            ->disableOriginalConstructor()
            ->getMock();

        $this->companyBusinessUnitTransferMock = $this->getMockBuilder(CompanyBusinessUnitTransfer::class)
            ->disableOriginalConstructor()
            ->getMock();

        $this->companyBusinessUnitResponseTransferMock = $this->getMockBuilder(CompanyBusinessUnitResponseTransfer::class)
            ->disableOriginalConstructor()
            ->getMock();

        $this->companyBusinessUnitsOrdersRestApiToCompanyBusinessUnitFacadeBridge = new CompanyBusinessUnitsOrdersRestApiToCompanyBusinessUnitFacadeBridge(
            $this->companyBusinessUnitFacadeMock
        );
    }

    /**
     * @return void
     */
    public function testFindCompanyBusinessUnitByUuid(): void
    {
        $this->companyBusinessUnitFacadeMock->expects($this->atLeastOnce())
            ->method('findCompanyBusinessUnitByUuid')
            ->with($this->companyBusinessUnitTransferMock)
            ->willReturn($this->companyBusinessUnitResponseTransferMock);

        $companyBusinessUnitResponseTransfer = $this->companyBusinessUnitsOrdersRestApiToCompanyBusinessUnitFacadeBridge
            ->findCompanyBusinessUnitByUuid($this->companyBusinessUnitTransferMock);

        $this->assertEquals($this->companyBusinessUnitResponseTransferMock, $companyBusinessUnitResponseTransfer);
    }
}
