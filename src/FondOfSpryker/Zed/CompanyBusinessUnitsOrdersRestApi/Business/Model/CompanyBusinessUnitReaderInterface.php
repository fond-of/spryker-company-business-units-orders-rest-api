<?php

namespace FondOfSpryker\Zed\CompanyBusinessUnitsOrdersRestApi\Business\Model;

use Generated\Shared\Transfer\CompanyBusinessUnitOrderListRequestTransfer;
use Generated\Shared\Transfer\CompanyBusinessUnitTransfer;
use Generated\Shared\Transfer\RestCompanyBusinessUnitOrderListTransfer;

interface CompanyBusinessUnitReaderInterface
{
    /**
     * @param \Generated\Shared\Transfer\RestCompanyBusinessUnitOrderListTransfer $restCompanyBusinessUnitOrderListTransfer
     *
     * @return \Generated\Shared\Transfer\CompanyBusinessUnitTransfer|null
     */
    public function getByRestCompanyBusinessUnitOrderList(
        RestCompanyBusinessUnitOrderListTransfer $restCompanyBusinessUnitOrderListTransfer
    ): ?CompanyBusinessUnitTransfer;
}
