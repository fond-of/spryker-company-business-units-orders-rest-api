<?php

namespace FondOfSpryker\Zed\CompanyBusinessUnitsOrdersRestApi\Business\Model;

use Generated\Shared\Transfer\CompanyBusinessUnitOrderListRequestTransfer;
use Generated\Shared\Transfer\RestCompanyBusinessUnitOrderListTransfer;

class RestCompanyBusinessUnitOrderListMapper implements RestCompanyBusinessUnitOrderListMapperInterface
{
    /**
     * @param \Generated\Shared\Transfer\RestCompanyBusinessUnitOrderListTransfer $restCompanyBusinessUnitOrderListTransfer
     *
     * @return \Generated\Shared\Transfer\CompanyBusinessUnitOrderListRequestTransfer
     */
    public function mapToCompanyBusinessUnitOrderListRequestTransfer(
        RestCompanyBusinessUnitOrderListTransfer $restCompanyBusinessUnitOrderListTransfer
    ): CompanyBusinessUnitOrderListRequestTransfer {
        return (new CompanyBusinessUnitOrderListRequestTransfer())
            ->fromArray($restCompanyBusinessUnitOrderListTransfer->toArray(), true);
    }
}
