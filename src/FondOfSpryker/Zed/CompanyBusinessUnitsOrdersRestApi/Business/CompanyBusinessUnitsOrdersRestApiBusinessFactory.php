<?php

namespace FondOfSpryker\Zed\CompanyBusinessUnitsOrdersRestApi\Business;

use FondOfSpryker\Zed\CompanyBusinessUnitsOrdersRestApi\Business\Model\CompanyBusinessUnitReader;
use FondOfSpryker\Zed\CompanyBusinessUnitsOrdersRestApi\Business\Model\CompanyBusinessUnitReaderInterface;
use FondOfSpryker\Zed\CompanyBusinessUnitsOrdersRestApi\Business\Model\OrderReader;
use FondOfSpryker\Zed\CompanyBusinessUnitsOrdersRestApi\Business\Model\OrderReaderInterface;
use FondOfSpryker\Zed\CompanyBusinessUnitsOrdersRestApi\Business\Model\RestCompanyBusinessUnitOrderListMapper;
use FondOfSpryker\Zed\CompanyBusinessUnitsOrdersRestApi\Business\Model\RestCompanyBusinessUnitOrderListMapperInterface;
use FondOfSpryker\Zed\CompanyBusinessUnitsOrdersRestApi\CompanyBusinessUnitsOrdersRestApiDependencyProvider;
use FondOfSpryker\Zed\CompanyBusinessUnitsOrdersRestApi\Dependency\Facade\CompanyBusinessUnitsOrdersRestApiToCompanyBusinessUnitFacadeInterface;
use FondOfSpryker\Zed\CompanyBusinessUnitsOrdersRestApi\Dependency\Facade\CompanyBusinessUnitsOrdersRestApiToCompanyBusinessUnitSalesFacadeInterface;
use Spryker\Zed\Kernel\Business\AbstractBusinessFactory;

class CompanyBusinessUnitsOrdersRestApiBusinessFactory extends AbstractBusinessFactory
{
    /**
     * @return \FondOfSpryker\Zed\CompanyBusinessUnitsOrdersRestApi\Business\Model\OrderReaderInterface
     */
    public function createOrderReader(): OrderReaderInterface
    {
        return new OrderReader(
            $this->createCompanyBusinessUnitReader(),
            $this->getCompanyBusinessUnitSalesFacade(),
            $this->createRestCompanyBusinessUnitOrderListMapper()
        );
    }

    /**
     * @return \FondOfSpryker\Zed\CompanyBusinessUnitsOrdersRestApi\Business\Model\RestCompanyBusinessUnitOrderListMapperInterface
     */
    protected function createRestCompanyBusinessUnitOrderListMapper(): RestCompanyBusinessUnitOrderListMapperInterface
    {
        return new RestCompanyBusinessUnitOrderListMapper();
    }

    /**
     * @return \FondOfSpryker\Zed\CompanyBusinessUnitsOrdersRestApi\Business\Model\CompanyBusinessUnitReaderInterface
     */
    protected function createCompanyBusinessUnitReader(): CompanyBusinessUnitReaderInterface
    {
        return new CompanyBusinessUnitReader($this->getCompanyBusinessUnitFacade());
    }

    /**
     * @return \FondOfSpryker\Zed\CompanyBusinessUnitsOrdersRestApi\Dependency\Facade\CompanyBusinessUnitsOrdersRestApiToCompanyBusinessUnitFacadeInterface
     */
    protected function getCompanyBusinessUnitFacade(): CompanyBusinessUnitsOrdersRestApiToCompanyBusinessUnitFacadeInterface
    {
        return $this->getProvidedDependency(
            CompanyBusinessUnitsOrdersRestApiDependencyProvider::FACADE_COMPANY_BUSINESS_UNIT
        );
    }

    /**
     * @return \FondOfSpryker\Zed\CompanyBusinessUnitsOrdersRestApi\Dependency\Facade\CompanyBusinessUnitsOrdersRestApiToCompanyBusinessUnitSalesFacadeInterface
     */
    protected function getCompanyBusinessUnitSalesFacade(): CompanyBusinessUnitsOrdersRestApiToCompanyBusinessUnitSalesFacadeInterface
    {
        return $this->getProvidedDependency(
            CompanyBusinessUnitsOrdersRestApiDependencyProvider::FACADE_COMPANY_BUSINESS_UNIT_SALES
        );
    }
}
