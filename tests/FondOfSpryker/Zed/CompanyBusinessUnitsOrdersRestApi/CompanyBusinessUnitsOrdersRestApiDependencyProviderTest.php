<?php

namespace FondOfSpryker\Zed\CompanyBusinessUnitsOrdersRestApi;

use Codeception\Test\Unit;
use FondOfSpryker\Zed\CompanyBusinessUnitSales\Business\CompanyBusinessUnitSalesFacadeInterface;
use FondOfSpryker\Zed\CompanyBusinessUnitsOrdersRestApi\Dependency\Facade\CompanyBusinessUnitsOrdersRestApiToCompanyBusinessUnitFacadeBridge;
use FondOfSpryker\Zed\CompanyBusinessUnitsOrdersRestApi\Dependency\Facade\CompanyBusinessUnitsOrdersRestApiToCompanyBusinessUnitSalesFacadeBridge;
use Spryker\Shared\Kernel\BundleProxy;
use Spryker\Zed\CompanyBusinessUnit\Business\CompanyBusinessUnitFacadeInterface;
use Spryker\Zed\Kernel\Locator;
use Spryker\Zed\Testify\Locator\Business\Container;

class CompanyBusinessUnitsOrdersRestApiDependencyProviderTest extends Unit
{
    /**
     * @var \PHPUnit\Framework\MockObject\MockObject|\Spryker\Zed\Kernel\Container
     */
    protected $containerMock;

    /**
     * @var \PHPUnit\Framework\MockObject\MockObject|\Spryker\Zed\Kernel\Locator
     */
    protected $locatorMock;

    /**
     * @var \PHPUnit\Framework\MockObject\MockObject|\Spryker\Shared\Kernel\BundleProxy
     */
    protected $bundleProxyMock;

    /**
     * @var \PHPUnit\Framework\MockObject\MockObject|\Spryker\Zed\CompanyBusinessUnit\Business\CompanyBusinessUnitFacadeInterface
     */
    protected $companyBusinessUnitFacadeMock;

    /**
     * @var \PHPUnit\Framework\MockObject\MockObject|\FondOfSpryker\Zed\CompanyBusinessUnitSales\Business\CompanyBusinessUnitSalesFacadeInterface
     */
    protected $companyBusinessUnitSalesFacadeMock;

    /**
     * @var \FondOfSpryker\Zed\CompanyBusinessUnitsOrdersRestApi\CompanyBusinessUnitsOrdersRestApiDependencyProvider
     */
    protected $companyBusinessUnitsOrdersRestApiDependencyProvider;

    /**
     * @return void
     */
    protected function _before(): void
    {
        parent::_before();

        $this->containerMock = $this->getMockBuilder(Container::class)
            ->setMethodsExcept(['factory', 'set', 'offsetSet', 'get', 'offsetGet'])
            ->getMock();

        $this->locatorMock = $this->getMockBuilder(Locator::class)
            ->disableOriginalConstructor()
            ->getMock();

        $this->bundleProxyMock = $this->getMockBuilder(BundleProxy::class)
            ->disableOriginalConstructor()
            ->getMock();

        $this->companyBusinessUnitFacadeMock = $this->getMockBuilder(CompanyBusinessUnitFacadeInterface::class)
            ->disableOriginalConstructor()
            ->getMock();

        $this->companyBusinessUnitSalesFacadeMock = $this->getMockBuilder(CompanyBusinessUnitSalesFacadeInterface::class)
            ->disableOriginalConstructor()
            ->getMock();

        $this->companyBusinessUnitsOrdersRestApiDependencyProvider = new CompanyBusinessUnitsOrdersRestApiDependencyProvider();
    }

    /**
     * @return void
     */
    public function testProvideBusinessLayerDependencies(): void
    {
        $this->containerMock->expects($this->atLeastOnce())
            ->method('getLocator')
            ->willReturn($this->locatorMock);

        $this->locatorMock->expects($this->atLeastOnce())
            ->method('__call')
            ->withConsecutive(['companyBusinessUnit'], ['companyBusinessUnitSales'])
            ->willReturn($this->bundleProxyMock);

        $this->bundleProxyMock->expects($this->atLeastOnce())
            ->method('__call')
            ->with('facade')
            ->willReturnOnConsecutiveCalls(
                $this->companyBusinessUnitFacadeMock,
                $this->companyBusinessUnitSalesFacadeMock
            );

        $container = $this->companyBusinessUnitsOrdersRestApiDependencyProvider->provideBusinessLayerDependencies(
            $this->containerMock
        );

        $this->assertEquals($this->containerMock, $container);
        $this->assertInstanceOf(
            CompanyBusinessUnitsOrdersRestApiToCompanyBusinessUnitFacadeBridge::class,
            $container[CompanyBusinessUnitsOrdersRestApiDependencyProvider::FACADE_COMPANY_BUSINESS_UNIT]
        );
        $this->assertInstanceOf(
            CompanyBusinessUnitsOrdersRestApiToCompanyBusinessUnitSalesFacadeBridge::class,
            $container[CompanyBusinessUnitsOrdersRestApiDependencyProvider::FACADE_COMPANY_BUSINESS_UNIT_SALES]
        );
    }
}
