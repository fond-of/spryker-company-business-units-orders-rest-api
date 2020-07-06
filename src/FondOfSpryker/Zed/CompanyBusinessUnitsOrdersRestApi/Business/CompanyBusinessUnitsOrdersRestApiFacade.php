<?php

namespace FondOfSpryker\Zed\CompanyBusinessUnitsOrdersRestApi\Business;

use Generated\Shared\Transfer\CompanyBusinessUnitOrderListTransfer;
use Generated\Shared\Transfer\RestCompanyBusinessUnitOrderListTransfer;
use Spryker\Zed\Kernel\Business\AbstractFacade;

/**
 * @method \FondOfSpryker\Zed\CompanyBusinessUnitsOrdersRestApi\Business\CompanyBusinessUnitsOrdersRestApiBusinessFactory getFactory()
 */
class CompanyBusinessUnitsOrdersRestApiFacade extends AbstractFacade implements CompanyBusinessUnitsOrdersRestApiFacadeInterface
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
        return $this->getFactory()->createOrderReader()->find($restCompanyBusinessUnitOrderListTransfer);
    }
}
