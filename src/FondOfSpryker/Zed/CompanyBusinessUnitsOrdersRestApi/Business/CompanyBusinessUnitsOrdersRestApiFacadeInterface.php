<?php

namespace FondOfSpryker\Zed\CompanyBusinessUnitsOrdersRestApi\Business;

use Generated\Shared\Transfer\CompanyBusinessUnitOrderListTransfer;
use Generated\Shared\Transfer\RestCompanyBusinessUnitOrderListTransfer;

interface CompanyBusinessUnitsOrdersRestApiFacadeInterface
{
    /**
     * Specifications:
     * - Returns a list of orders
     *
     * @api
     *
     * @param \Generated\Shared\Transfer\RestCompanyBusinessUnitOrderListTransfer $restCompanyBusinessUnitOrderListTransfer
     *
     * @return \Generated\Shared\Transfer\CompanyBusinessUnitOrderListTransfer
     */
    public function findOrders(
        RestCompanyBusinessUnitOrderListTransfer $restCompanyBusinessUnitOrderListTransfer
    ): CompanyBusinessUnitOrderListTransfer;
}
