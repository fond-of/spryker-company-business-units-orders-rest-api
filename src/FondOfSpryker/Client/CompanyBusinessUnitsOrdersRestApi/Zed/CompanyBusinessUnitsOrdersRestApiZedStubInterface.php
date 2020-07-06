<?php

namespace FondOfSpryker\Client\CompanyBusinessUnitsOrdersRestApi\Zed;

use Generated\Shared\Transfer\CompanyBusinessUnitOrderListTransfer;
use Generated\Shared\Transfer\RestCompanyBusinessUnitOrderListTransfer;

interface CompanyBusinessUnitsOrdersRestApiZedStubInterface
{
    /**
     * @param \Generated\Shared\Transfer\RestCompanyBusinessUnitOrderListTransfer $restCompanyBusinessUnitOrderListTransfer
     *
     * @return \Generated\Shared\Transfer\CompanyBusinessUnitOrderListTransfer
     */
    public function findOrders(
        RestCompanyBusinessUnitOrderListTransfer $restCompanyBusinessUnitOrderListTransfer
    ): CompanyBusinessUnitOrderListTransfer;
}
