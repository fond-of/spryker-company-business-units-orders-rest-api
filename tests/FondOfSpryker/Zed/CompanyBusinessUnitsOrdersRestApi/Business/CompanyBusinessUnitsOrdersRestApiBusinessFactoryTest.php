<?php

namespace FondOfSpryker\Zed\CompanyBusinessUnitsOrdersRestApi\Business;

use Codeception\Test\Unit;
use FondOfSpryker\Zed\CompanyBusinessUnitsOrdersRestApi\Business\Model\OrderReader;
use FondOfSpryker\Zed\CompanyBusinessUnitsOrdersRestApi\CompanyBusinessUnitsOrdersRestApiDependencyProvider;
use FondOfSpryker\Zed\CompanyBusinessUnitsOrdersRestApi\Dependency\Facade\CompanyBusinessUnitsOrdersRestApiToCompanyBusinessUnitFacadeInterface;
use FondOfSpryker\Zed\CompanyBusinessUnitsOrdersRestApi\Dependency\Facade\CompanyBusinessUnitsOrdersRestApiToCompanyBusinessUnitSalesFacadeInterface;
use Spryker\Zed\Kernel\Container;

class CompanyBusinessUnitsOrdersRestApiBusinessFactoryTest extends Unit
{
    /**
     * @var \PHPUnit\Framework\MockObject\MockObject|\Spryker\Zed\Kernel\Container
     */
    protected $containerMock;

    /**
     * @var \PHPUnit\Framework\MockObject\MockObject|\FondOfSpryker\Zed\CompanyBusinessUnitsOrdersRestApi\Dependency\Facade\CompanyBusinessUnitsOrdersRestApiToCompanyBusinessUnitFacadeInterface
     */
    protected $companyBusinessUnitFacadeMock;

    /**
     * @var \PHPUnit\Framework\MockObject\MockObject|\FondOfSpryker\Zed\CompanyBusinessUnitsOrdersRestApi\Dependency\Facade\CompanyBusinessUnitsOrdersRestApiToCompanyBusinessUnitSalesFacadeInterface
     */
    protected $companyBusinessUnitSalesFacadeMock;

    /**
     * @var \FondOfSpryker\Zed\CompanyBusinessUnitsOrdersRestApi\Business\CompanyBusinessUnitsOrdersRestApiBusinessFactory
     */
    protected $companyBusinessUnitsOrdersRestApiBusinessFactory;

    /**
     * @return void
     */
    protected function _before(): void
    {
        parent::_before();

        $this->containerMock = $this->getMockBuilder(Container::class)
            ->disableOriginalConstructor()
            ->getMock();

        $this->companyBusinessUnitFacadeMock = $this->getMockBuilder(CompanyBusinessUnitsOrdersRestApiToCompanyBusinessUnitFacadeInterface::class)
            ->disableOriginalConstructor()
            ->getMock();

        $this->companyBusinessUnitSalesFacadeMock = $this->getMockBuilder(CompanyBusinessUnitsOrdersRestApiToCompanyBusinessUnitSalesFacadeInterface::class)
            ->disableOriginalConstructor()
            ->getMock();

        $this->companyBusinessUnitsOrdersRestApiBusinessFactory = new CompanyBusinessUnitsOrdersRestApiBusinessFactory();
        $this->companyBusinessUnitsOrdersRestApiBusinessFactory->setContainer($this->containerMock);
    }

    /**
     * @return void
     */
    public function testCreateOrderReader(): void
    {
        $this->containerMock->expects($this->atLeastOnce())
            ->method('has')
            ->willReturn(true);

        $this->containerMock->expects($this->atLeastOnce())
            ->method('get')
            ->withConsecutive(
                [CompanyBusinessUnitsOrdersRestApiDependencyProvider::FACADE_COMPANY_BUSINESS_UNIT],
                [CompanyBusinessUnitsOrdersRestApiDependencyProvider::FACADE_COMPANY_BUSINESS_UNIT_SALES]
            )
            ->willReturnOnConsecutiveCalls(
                $this->companyBusinessUnitFacadeMock,
                $this->companyBusinessUnitSalesFacadeMock
            );

        $orderReader = $this->companyBusinessUnitsOrdersRestApiBusinessFactory->createOrderReader();

        $this->assertInstanceOf(
            OrderReader::class,
            $orderReader
        );
    }
}
