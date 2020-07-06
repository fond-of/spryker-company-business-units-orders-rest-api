<?php

namespace FondOfSpryker\Zed\CompanyBusinessUnitsOrdersRestApi\Dependency\Facade;

use FondOfSpryker\Zed\CompanyBusinessUnitSales\Business\CompanyBusinessUnitSalesFacadeInterface;
use Generated\Shared\Transfer\CompanyBusinessUnitOrderListRequestTransfer;
use Generated\Shared\Transfer\CompanyBusinessUnitOrderListTransfer;

class CompanyBusinessUnitsOrdersRestApiToCompanyBusinessUnitSalesFacadeBridge implements CompanyBusinessUnitsOrdersRestApiToCompanyBusinessUnitSalesFacadeInterface
{
    /**
     * @var \FondOfSpryker\Zed\CompanyBusinessUnitSales\Business\CompanyBusinessUnitSalesFacadeInterface
     */
    protected $companyBusinessUnitSalesFacade;

    /**
     * @param \FondOfSpryker\Zed\CompanyBusinessUnitSales\Business\CompanyBusinessUnitSalesFacadeInterface $companyBusinessUnitSalesFacade
     */
    public function __construct(CompanyBusinessUnitSalesFacadeInterface $companyBusinessUnitSalesFacade)
    {
        $this->companyBusinessUnitSalesFacade = $companyBusinessUnitSalesFacade;
    }

    /**
     * @param \Generated\Shared\Transfer\CompanyBusinessUnitOrderListRequestTransfer $companyBusinessUnitOrderListRequestTransfer
     *
     * @return \Generated\Shared\Transfer\CompanyBusinessUnitOrderListTransfer
     */
    public function findOrders(
        CompanyBusinessUnitOrderListRequestTransfer $companyBusinessUnitOrderListRequestTransfer
    ): CompanyBusinessUnitOrderListTransfer {
        return $this->companyBusinessUnitSalesFacade->findOrders($companyBusinessUnitOrderListRequestTransfer);
    }
}
