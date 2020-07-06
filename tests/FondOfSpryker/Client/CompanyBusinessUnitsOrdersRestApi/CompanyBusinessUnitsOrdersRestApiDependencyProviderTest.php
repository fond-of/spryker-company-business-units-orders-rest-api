<?php

namespace FondOfSpryker\Client\CompanyBusinessUnitsOrdersRestApi;

use Codeception\Test\Unit;
use FondOfSpryker\Client\CompanyBusinessUnitsOrdersRestApi\Dependency\Client\CompanyBusinessUnitsOrdersRestApiToZedRequestClientBridge;
use Spryker\Client\Kernel\Container;
use Spryker\Client\Kernel\Locator;
use Spryker\Client\ZedRequest\ZedRequestClientInterface;
use Spryker\Shared\Kernel\BundleProxy;

class CompanyBusinessUnitsOrdersRestApiDependencyProviderTest extends Unit
{
    /**
     * @var \PHPUnit\Framework\MockObject\MockObject|\Spryker\Client\Kernel\Container
     */
    protected $containerMock;

    /**
     * @var \PHPUnit\Framework\MockObject\MockObject|\Spryker\Client\Kernel\Locator
     */
    protected $locatorMock;

    /**
     * @var \PHPUnit\Framework\MockObject\MockObject|\Spryker\Shared\Kernel\BundleProxy
     */
    protected $bundleProxyMock;

    /**
     * @var \PHPUnit\Framework\MockObject\MockObject|\Spryker\Client\ZedRequest\ZedRequestClientInterface
     */
    protected $zedRequestClientMock;

    /**
     * @var \FondOfSpryker\Client\CompanyBusinessUnitsOrdersRestApi\CompanyBusinessUnitsOrdersRestApiDependencyProvider
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

        $this->zedRequestClientMock = $this->getMockBuilder(ZedRequestClientInterface::class)
            ->disableOriginalConstructor()
            ->getMock();

        $this->companyBusinessUnitsOrdersRestApiDependencyProvider = new CompanyBusinessUnitsOrdersRestApiDependencyProvider();
    }

    /**
     * @return void
     */
    public function testProvideServiceLayerDependencies(): void
    {
        $this->containerMock->expects($this->atLeastOnce())
            ->method('getLocator')
            ->willReturn($this->locatorMock);

        $this->locatorMock->expects($this->atLeastOnce())
            ->method('__call')
            ->with('zedRequest')
            ->willReturn($this->bundleProxyMock);

        $this->bundleProxyMock->expects($this->atLeastOnce())
            ->method('__call')
            ->with('client')
            ->willReturn($this->zedRequestClientMock);

        $container = $this->companyBusinessUnitsOrdersRestApiDependencyProvider->provideServiceLayerDependencies(
            $this->containerMock
        );

        $this->assertEquals($this->containerMock, $container);
        $this->assertInstanceOf(
            CompanyBusinessUnitsOrdersRestApiToZedRequestClientBridge::class,
            $container[CompanyBusinessUnitsOrdersRestApiDependencyProvider::CLIENT_ZED_REQUEST]
        );
    }
}
