<?php

namespace FondOfSpryker\Zed\CompanyBusinessUnitsOrdersRestApi\Business\Model;

use Codeception\Test\Unit;
use FondOfSpryker\Zed\CompanyBusinessUnitsOrdersRestApi\Dependency\Facade\CompanyBusinessUnitsOrdersRestApiToCompanyBusinessUnitFacadeInterface;
use Generated\Shared\Transfer\CompanyBusinessUnitResponseTransfer;
use Generated\Shared\Transfer\CompanyBusinessUnitTransfer;
use Generated\Shared\Transfer\RestCompanyBusinessUnitOrderListTransfer;

class CompanyBusinessUnitReaderTest extends Unit
{
    /**
     * @var \PHPUnit\Framework\MockObject\MockObject|\Generated\Shared\Transfer\RestCompanyBusinessUnitOrderListTransfer
     */
    protected $restCompanyBusinessUnitOrderListTransferMock;

    /**
     * @var \PHPUnit\Framework\MockObject\MockObject|\FondOfSpryker\Zed\CompanyBusinessUnitsOrdersRestApi\Dependency\Facade\CompanyBusinessUnitsOrdersRestApiToCompanyBusinessUnitFacadeInterface
     */
    protected $companyBusinessUnitFacadeMock;

    /**
     * @var \PHPUnit\Framework\MockObject\MockObject|\Generated\Shared\Transfer\CompanyBusinessUnitResponseTransfer
     */
    protected $companyBusinessUnitResponseTransferMock;

    /**
     * @var \PHPUnit\Framework\MockObject\MockObject|\Generated\Shared\Transfer\CompanyBusinessUnitTransfer
     */
    protected $companyBusinessUnitTransferMock;

    /**
     * @var string
     */
    protected $companyBusinessUnitUuid;

    /**
     * @var \FondOfSpryker\Zed\CompanyBusinessUnitsOrdersRestApi\Business\Model\CompanyBusinessUnitReader
     */
    protected $companyBusinessUnitReader;

    /**
     * @return void
     */
    protected function _before(): void
    {
        parent::_before();

        $this->restCompanyBusinessUnitOrderListTransferMock = $this->getMockBuilder(RestCompanyBusinessUnitOrderListTransfer::class)
            ->disableOriginalConstructor()
            ->getMock();

        $this->companyBusinessUnitFacadeMock = $this->getMockBuilder(CompanyBusinessUnitsOrdersRestApiToCompanyBusinessUnitFacadeInterface::class)
            ->disableOriginalConstructor()
            ->getMock();

        $this->companyBusinessUnitResponseTransferMock = $this->getMockBuilder(CompanyBusinessUnitResponseTransfer::class)
            ->disableOriginalConstructor()
            ->getMock();

        $this->companyBusinessUnitTransferMock = $this->getMockBuilder(CompanyBusinessUnitTransfer::class)
            ->disableOriginalConstructor()
            ->getMock();

        $this->companyBusinessUnitUuid = '8428430d-ec72-4d1b-beb4-ce139df9c5aa';

        $this->companyBusinessUnitReader = new CompanyBusinessUnitReader(
            $this->companyBusinessUnitFacadeMock
        );
    }

    /**
     * @return void
     */
    public function testGetByRestCompanyBusinessUnitOrderListWithoutCompanyBusinessUnitUuid(): void
    {
        $this->restCompanyBusinessUnitOrderListTransferMock->expects($this->atLeastOnce())
            ->method('getCompanyBusinessUnitUuid')
            ->willReturn(null);

        $this->companyBusinessUnitFacadeMock->expects($this->never())
            ->method('findCompanyBusinessUnitByUuid');

        $companyBusinessUnitTransfer = $this->companyBusinessUnitReader->getByRestCompanyBusinessUnitOrderList(
            $this->restCompanyBusinessUnitOrderListTransferMock
        );

        $this->assertEquals(null, $companyBusinessUnitTransfer);
    }

    /**
     * @return void
     */
    public function testGetByRestCompanyBusinessUnitOrderListWithoutExistingCompanyBusinessUnit(): void
    {
        $this->restCompanyBusinessUnitOrderListTransferMock->expects($this->atLeastOnce())
            ->method('getCompanyBusinessUnitUuid')
            ->willReturn($this->companyBusinessUnitUuid);

        $self = $this;

        $this->companyBusinessUnitFacadeMock->expects($this->atLeastOnce())
            ->method('findCompanyBusinessUnitByUuid')
            ->with(
                $this->callback(
                    static function (CompanyBusinessUnitTransfer $companyBusinessUnitTransfer) use ($self) {
                        return $companyBusinessUnitTransfer->getUuid() === $self->companyBusinessUnitUuid;
                    }
                )
            )->willReturn($this->companyBusinessUnitResponseTransferMock);

        $this->companyBusinessUnitResponseTransferMock->expects($this->atLeastOnce())
            ->method('getIsSuccessful')
            ->willReturn(false);

        $companyBusinessUnitTransfer = $this->companyBusinessUnitReader->getByRestCompanyBusinessUnitOrderList(
            $this->restCompanyBusinessUnitOrderListTransferMock
        );

        $this->assertEquals(null, $companyBusinessUnitTransfer);
    }

    /**
     * @return void
     */
    public function testGetByRestCompanyBusinessUnitOrderList(): void
    {
        $this->restCompanyBusinessUnitOrderListTransferMock->expects($this->atLeastOnce())
            ->method('getCompanyBusinessUnitUuid')
            ->willReturn($this->companyBusinessUnitUuid);

        $self = $this;

        $this->companyBusinessUnitFacadeMock->expects($this->atLeastOnce())
            ->method('findCompanyBusinessUnitByUuid')
            ->with(
                $this->callback(
                    static function (CompanyBusinessUnitTransfer $companyBusinessUnitTransfer) use ($self) {
                        return $companyBusinessUnitTransfer->getUuid() === $self->companyBusinessUnitUuid;
                    }
                )
            )->willReturn($this->companyBusinessUnitResponseTransferMock);

        $this->companyBusinessUnitResponseTransferMock->expects($this->atLeastOnce())
            ->method('getIsSuccessful')
            ->willReturn(true);

        $this->companyBusinessUnitResponseTransferMock->expects($this->atLeastOnce())
            ->method('getCompanyBusinessUnitTransfer')
            ->willReturn($this->companyBusinessUnitTransferMock);

        $companyBusinessUnitTransfer = $this->companyBusinessUnitReader->getByRestCompanyBusinessUnitOrderList(
            $this->restCompanyBusinessUnitOrderListTransferMock
        );

        $this->assertEquals($this->companyBusinessUnitTransferMock, $companyBusinessUnitTransfer);
    }
}
