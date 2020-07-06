<?php

namespace FondOfSpryker\Client\CompanyBusinessUnitsOrdersRestApi\Zed;

use FondOfSpryker\Client\CompanyBusinessUnitsOrdersRestApi\Dependency\Client\CompanyBusinessUnitsOrdersRestApiToZedRequestClientInterface;
use Generated\Shared\Transfer\CompanyBusinessUnitOrderListTransfer;
use Generated\Shared\Transfer\RestCompanyBusinessUnitOrderListTransfer;

class CompanyBusinessUnitsOrdersRestApiZedStub implements CompanyBusinessUnitsOrdersRestApiZedStubInterface
{
    /**
     * @var \FondOfSpryker\Client\CompanyBusinessUnitsOrdersRestApi\Dependency\Client\CompanyBusinessUnitsOrdersRestApiToZedRequestClientInterface
     */
    protected $zedRequestClient;

    /**
     * @param \FondOfSpryker\Client\CompanyBusinessUnitsOrdersRestApi\Dependency\Client\CompanyBusinessUnitsOrdersRestApiToZedRequestClientInterface $zedRequestClient
     */
    public function __construct(CompanyBusinessUnitsOrdersRestApiToZedRequestClientInterface $zedRequestClient)
    {
        $this->zedRequestClient = $zedRequestClient;
    }

    /**
     * @param \Generated\Shared\Transfer\RestCompanyBusinessUnitOrderListTransfer $restCompanyBusinessUnitOrderListTransfer
     *
     * @return \Generated\Shared\Transfer\CompanyBusinessUnitOrderListTransfer
     */
    public function findOrders(
        RestCompanyBusinessUnitOrderListTransfer $restCompanyBusinessUnitOrderListTransfer
    ): CompanyBusinessUnitOrderListTransfer {
        /** @var \Generated\Shared\Transfer\CompanyBusinessUnitOrderListTransfer $companyBusinessUnitOrderListTransfer */
        $companyBusinessUnitOrderListTransfer = $this->zedRequestClient->call(
            '/company-business-units-orders-rest-api/gateway/find-orders',
            $restCompanyBusinessUnitOrderListTransfer
        );

        return $companyBusinessUnitOrderListTransfer;
    }
}
