<?php

namespace FondOfSpryker\Glue\CompanyBusinessUnitsOrdersRestApi\Plugin\GlueApplicationExtension;

use Codeception\Test\Unit;
use FondOfSpryker\Glue\CompanyBusinessUnitsOrdersRestApi\CompanyBusinessUnitsOrdersRestApiConfig;
use Generated\Shared\Transfer\RestOrdersAttributesTransfer;
use Spryker\Glue\GlueApplicationExtension\Dependency\Plugin\ResourceRouteCollectionInterface;

class CompanyBusinessUnitsOrdersResourceRoutePluginTest extends Unit
{
    /**
     * @var \PHPUnit\Framework\MockObject\MockObject|\Spryker\Glue\GlueApplicationExtension\Dependency\Plugin\ResourceRouteCollectionInterface
     */
    protected $resourceRouteCollectionMock;

    /**
     * @var \FondOfSpryker\Glue\CompanyBusinessUnitsOrdersRestApi\Plugin\GlueApplicationExtension\CompanyBusinessUnitsOrdersResourceRoutePlugin
     */
    protected $companyBusinessUnitsOrdersResourceRoutePlugin;

    /**
     * @return void
     */
    protected function _before(): void
    {
        parent::_before();

        $this->resourceRouteCollectionMock = $this->getMockBuilder(ResourceRouteCollectionInterface::class)
            ->disableOriginalConstructor()
            ->getMock();

        $this->companyBusinessUnitsOrdersResourceRoutePlugin = new CompanyBusinessUnitsOrdersResourceRoutePlugin();
    }

    /**
     * @return void
     */
    public function testGetResourceType(): void
    {
        $this->assertEquals(
            CompanyBusinessUnitsOrdersRestApiConfig::RESOURCE_COMPANY_BUSINESS_UNIT_ORDERS,
            $this->companyBusinessUnitsOrdersResourceRoutePlugin->getResourceType()
        );
    }

    /**
     * @return void
     */
    public function testConfigure(): void
    {
        $this->resourceRouteCollectionMock->expects($this->atLeastOnce())
            ->method('addGet')
            ->with('get');

        $this->assertEquals(
            $this->resourceRouteCollectionMock,
            $this->companyBusinessUnitsOrdersResourceRoutePlugin->configure($this->resourceRouteCollectionMock)
        );
    }

    /**
     * @return void
     */
    public function testGetController(): void
    {
        $this->assertEquals(
            CompanyBusinessUnitsOrdersRestApiConfig::CONTROLLER_COMPANY_BUSINESS_UNITS_ORDERS,
            $this->companyBusinessUnitsOrdersResourceRoutePlugin->getController()
        );
    }

    /**
     * @return void
     */
    public function testGetResourceAttributesClassName(): void
    {
        $this->assertEquals(
            RestOrdersAttributesTransfer::class,
            $this->companyBusinessUnitsOrdersResourceRoutePlugin->getResourceAttributesClassName()
        );
    }

    /**
     * @return void
     */
    public function testGetParentResourceType(): void
    {
        $this->assertEquals(
            CompanyBusinessUnitsOrdersRestApiConfig::PARENT_RESOURCE_COMPANY_BUSINESS_UNITS,
            $this->companyBusinessUnitsOrdersResourceRoutePlugin->getParentResourceType()
        );
    }
}
