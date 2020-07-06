<?php

namespace FondOfSpryker\Client\CompanyBusinessUnitsOrdersRestApi;

use FondOfSpryker\Client\CompanyBusinessUnitsOrdersRestApi\Dependency\Client\CompanyBusinessUnitsOrdersRestApiToZedRequestClientInterface;
use FondOfSpryker\Client\CompanyBusinessUnitsOrdersRestApi\Zed\CompanyBusinessUnitsOrdersRestApiZedStub;
use FondOfSpryker\Client\CompanyBusinessUnitsOrdersRestApi\Zed\CompanyBusinessUnitsOrdersRestApiZedStubInterface;
use Spryker\Client\Kernel\AbstractFactory;

class CompanyBusinessUnitsOrdersRestApiFactory extends AbstractFactory
{
    /**
     * @return \FondOfSpryker\Client\CompanyBusinessUnitsOrdersRestApi\Zed\CompanyBusinessUnitsOrdersRestApiZedStubInterface
     */
    public function createCompanyBusinessUnitsOrdersRestApiZedStub(): CompanyBusinessUnitsOrdersRestApiZedStubInterface
    {
        return new CompanyBusinessUnitsOrdersRestApiZedStub($this->getZedRequestClient());
    }

    /**
     * @return \FondOfSpryker\Client\CompanyBusinessUnitsOrdersRestApi\Dependency\Client\CompanyBusinessUnitsOrdersRestApiToZedRequestClientInterface
     */
    protected function getZedRequestClient(): CompanyBusinessUnitsOrdersRestApiToZedRequestClientInterface
    {
        return $this->getProvidedDependency(CompanyBusinessUnitsOrdersRestApiDependencyProvider::CLIENT_ZED_REQUEST);
    }
}
