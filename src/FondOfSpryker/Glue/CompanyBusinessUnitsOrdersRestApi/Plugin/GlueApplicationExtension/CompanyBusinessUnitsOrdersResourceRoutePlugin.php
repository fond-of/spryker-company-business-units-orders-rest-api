<?php

namespace FondOfSpryker\Glue\CompanyBusinessUnitsOrdersRestApi\Plugin\GlueApplicationExtension;

use FondOfSpryker\Glue\CompanyBusinessUnitsOrdersRestApi\CompanyBusinessUnitsOrdersRestApiConfig;
use Generated\Shared\Transfer\RestOrdersAttributesTransfer;
use Spryker\Glue\GlueApplicationExtension\Dependency\Plugin\ResourceRouteCollectionInterface;
use Spryker\Glue\GlueApplicationExtension\Dependency\Plugin\ResourceRoutePluginInterface;
use Spryker\Glue\GlueApplicationExtension\Dependency\Plugin\ResourceWithParentPluginInterface;
use Spryker\Glue\Kernel\AbstractPlugin;

class CompanyBusinessUnitsOrdersResourceRoutePlugin extends AbstractPlugin implements ResourceRoutePluginInterface, ResourceWithParentPluginInterface
{
    /**
     * @param \Spryker\Glue\GlueApplicationExtension\Dependency\Plugin\ResourceRouteCollectionInterface $resourceRouteCollection
     *
     * @return \Spryker\Glue\GlueApplicationExtension\Dependency\Plugin\ResourceRouteCollectionInterface
     */
    public function configure(ResourceRouteCollectionInterface $resourceRouteCollection): ResourceRouteCollectionInterface
    {
        $resourceRouteCollection
            ->addGet('get');

        return $resourceRouteCollection;
    }

    /**
     * @return string
     */
    public function getResourceType(): string
    {
        return CompanyBusinessUnitsOrdersRestApiConfig::RESOURCE_COMPANY_BUSINESS_UNIT_ORDERS;
    }

    /**
     * @return string
     */
    public function getController(): string
    {
        return CompanyBusinessUnitsOrdersRestApiConfig::CONTROLLER_COMPANY_BUSINESS_UNITS_ORDERS;
    }

    /**
     * @return string
     */
    public function getResourceAttributesClassName(): string
    {
        return RestOrdersAttributesTransfer::class;
    }

    /**
     * @return string
     */
    public function getParentResourceType(): string
    {
        return CompanyBusinessUnitsOrdersRestApiConfig::PARENT_RESOURCE_COMPANY_BUSINESS_UNITS;
    }
}
