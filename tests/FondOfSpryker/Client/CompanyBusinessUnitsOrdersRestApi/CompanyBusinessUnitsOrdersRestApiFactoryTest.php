<?php

namespace FondOfSpryker\Client\CompanyBusinessUnitsOrdersRestApi;

use Codeception\Test\Unit;
use FondOfSpryker\Client\CompanyBusinessUnitsOrdersRestApi\Dependency\Client\CompanyBusinessUnitsOrdersRestApiToZedRequestClientInterface;
use FondOfSpryker\Client\CompanyBusinessUnitsOrdersRestApi\Zed\CompanyBusinessUnitsOrdersRestApiZedStub;
use Spryker\Client\Kernel\Container;

class CompanyBusinessUnitsOrdersRestApiFactoryTest extends Unit
{
    /**
     * @var \PHPUnit\Framework\MockObject\MockObject|\Spryker\Client\Kernel\Container
     */
    protected $containerMock;

    /**
     * @var \PHPUnit\Framework\MockObject\MockObject|\Spryker\Client\ZedRequest\ZedRequestClientInterface
     */
    protected $zedRequestClientMock;

    /**
     * @var \FondOfSpryker\Client\CompanyBusinessUnitsOrdersRestApi\CompanyBusinessUnitsOrdersRestApiFactory
     */
    protected $companyBusinessUnitsOrdersRestApiFactory;

    /**
     * @return void
     */
    protected function _before(): void
    {
        parent::_before();

        $this->containerMock = $this->getMockBuilder(Container::class)
            ->disableOriginalConstructor()
            ->getMock();

        $this->zedRequestClientMock = $this->getMockBuilder(CompanyBusinessUnitsOrdersRestApiToZedRequestClientInterface::class)
            ->disableOriginalConstructor()
            ->getMock();

        $this->companyBusinessUnitsOrdersRestApiFactory = new CompanyBusinessUnitsOrdersRestApiFactory();
        $this->companyBusinessUnitsOrdersRestApiFactory->setContainer($this->containerMock);
    }

    /**
     * @return void
     */
    public function testCreateCompanyBusinessUnitsOrdersRestApiZedStub(): void
    {
        $this->containerMock->expects($this->atLeastOnce())
            ->method('has')
            ->willReturn(true);

        $this->containerMock->expects($this->atLeastOnce())
            ->method('get')
            ->with(CompanyBusinessUnitsOrdersRestApiDependencyProvider::CLIENT_ZED_REQUEST)
            ->willReturn($this->zedRequestClientMock);

        $this->assertInstanceOf(
            CompanyBusinessUnitsOrdersRestApiZedStub::class,
            $this->companyBusinessUnitsOrdersRestApiFactory->createCompanyBusinessUnitsOrdersRestApiZedStub()
        );
    }
}
