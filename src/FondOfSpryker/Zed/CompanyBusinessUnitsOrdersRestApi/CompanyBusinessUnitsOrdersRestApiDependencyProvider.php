<?php

namespace FondOfSpryker\Zed\CompanyBusinessUnitsOrdersRestApi;

use FondOfSpryker\Zed\CompanyBusinessUnitsOrdersRestApi\Dependency\Facade\CompanyBusinessUnitsOrdersRestApiToCompanyBusinessUnitFacadeBridge;
use FondOfSpryker\Zed\CompanyBusinessUnitsOrdersRestApi\Dependency\Facade\CompanyBusinessUnitsOrdersRestApiToCompanyBusinessUnitSalesFacadeBridge;
use Spryker\Zed\Kernel\AbstractBundleDependencyProvider;
use Spryker\Zed\Kernel\Container;

class CompanyBusinessUnitsOrdersRestApiDependencyProvider extends AbstractBundleDependencyProvider
{
    public const FACADE_COMPANY_BUSINESS_UNIT = 'FACADE_COMPANY_BUSINESS_UNIT';
    public const FACADE_COMPANY_BUSINESS_UNIT_SALES = 'FACADE_COMPANY_BUSINESS_UNIT_SALES';

    /**
     * @param \Spryker\Zed\Kernel\Container $container
     *
     * @return \Spryker\Zed\Kernel\Container
     */
    public function provideBusinessLayerDependencies(Container $container): Container
    {
        $container = parent::provideBusinessLayerDependencies($container);

        $container = $this->addCompanyBusinessUnitFacade($container);
        $container = $this->addCompanyBusinessUnitSalesFacade($container);

        return $container;
    }

    /**
     * @param \Spryker\Zed\Kernel\Container $container
     *
     * @return \Spryker\Zed\Kernel\Container
     */
    protected function addCompanyBusinessUnitFacade(Container $container): Container
    {
        $container[static::FACADE_COMPANY_BUSINESS_UNIT] = static function (Container $container) {
            return new CompanyBusinessUnitsOrdersRestApiToCompanyBusinessUnitFacadeBridge(
                $container->getLocator()->companyBusinessUnit()->facade()
            );
        };

        return $container;
    }

    /**
     * @param \Spryker\Zed\Kernel\Container $container
     *
     * @return \Spryker\Zed\Kernel\Container
     */
    protected function addCompanyBusinessUnitSalesFacade(Container $container): Container
    {
        $container[static::FACADE_COMPANY_BUSINESS_UNIT_SALES] = static function (Container $container) {
            return new CompanyBusinessUnitsOrdersRestApiToCompanyBusinessUnitSalesFacadeBridge(
                $container->getLocator()->companyBusinessUnitSales()->facade()
            );
        };

        return $container;
    }
}
