<?php

namespace FondOfSpryker\Client\CompanyBusinessUnitsOrdersRestApi;

use Generated\Shared\Transfer\CompanyBusinessUnitOrderListTransfer;
use Generated\Shared\Transfer\RestCompanyBusinessUnitOrderListTransfer;
use Spryker\Client\Kernel\AbstractClient;

/**
 * @method \FondOfSpryker\Client\CompanyBusinessUnitsOrdersRestApi\CompanyBusinessUnitsOrdersRestApiFactory getFactory()
 */
class CompanyBusinessUnitsOrdersRestApiClient extends AbstractClient implements CompanyBusinessUnitsOrdersRestApiClientInterface
{
    /**
     * {@inheritDoc}
     *
     * @api
     *
     * @param \Generated\Shared\Transfer\RestCompanyBusinessUnitOrderListTransfer $restCompanyBusinessUnitOrderListTransfer
     *
     * @return \Generated\Shared\Transfer\CompanyBusinessUnitOrderListTransfer
     */
    public function findOrders(
        RestCompanyBusinessUnitOrderListTransfer $restCompanyBusinessUnitOrderListTransfer
    ): CompanyBusinessUnitOrderListTransfer {
        return $this->getFactory()
            ->createCompanyBusinessUnitsOrdersRestApiZedStub()
            ->findOrders($restCompanyBusinessUnitOrderListTransfer);
    }
}
