<?php

namespace FondOfSpryker\Zed\CompanyBusinessUnitsOrdersRestApi\Business\Model;

use FondOfSpryker\Zed\CompanyBusinessUnitsOrdersRestApi\Dependency\Facade\CompanyBusinessUnitsOrdersRestApiToCompanyBusinessUnitSalesFacadeInterface;
use Generated\Shared\Transfer\CompanyBusinessUnitOrderListTransfer;
use Generated\Shared\Transfer\RestCompanyBusinessUnitOrderListTransfer;

class OrderReader implements OrderReaderInterface
{
    /**
     * @var \FondOfSpryker\Zed\CompanyBusinessUnitsOrdersRestApi\Business\Model\CompanyBusinessUnitReaderInterface
     */
    protected $companyBusinessUnitReader;

    /**
     * @var \FondOfSpryker\Zed\CompanyBusinessUnitsOrdersRestApi\Dependency\Facade\CompanyBusinessUnitsOrdersRestApiToCompanyBusinessUnitSalesFacadeInterface
     */
    protected $companyBusinessUnitSalesFacade;

    /**
     * @var \FondOfSpryker\Zed\CompanyBusinessUnitsOrdersRestApi\Business\Model\RestCompanyBusinessUnitOrderListMapperInterface
     */
    protected $restCompanyBusinessUnitOrderListMapper;

    /**
     * @param \FondOfSpryker\Zed\CompanyBusinessUnitsOrdersRestApi\Business\Model\CompanyBusinessUnitReaderInterface $companyBusinessUnitReader
     * @param \FondOfSpryker\Zed\CompanyBusinessUnitsOrdersRestApi\Dependency\Facade\CompanyBusinessUnitsOrdersRestApiToCompanyBusinessUnitSalesFacadeInterface $companyBusinessUnitSalesFacade
     * @param \FondOfSpryker\Zed\CompanyBusinessUnitsOrdersRestApi\Business\Model\RestCompanyBusinessUnitOrderListMapperInterface $restCompanyBusinessUnitOrderListMapper
     */
    public function __construct(
        CompanyBusinessUnitReaderInterface $companyBusinessUnitReader,
        CompanyBusinessUnitsOrdersRestApiToCompanyBusinessUnitSalesFacadeInterface $companyBusinessUnitSalesFacade,
        RestCompanyBusinessUnitOrderListMapperInterface $restCompanyBusinessUnitOrderListMapper
    ) {
        $this->companyBusinessUnitReader = $companyBusinessUnitReader;
        $this->companyBusinessUnitSalesFacade = $companyBusinessUnitSalesFacade;
        $this->restCompanyBusinessUnitOrderListMapper = $restCompanyBusinessUnitOrderListMapper;
    }

    /**
     * @param \Generated\Shared\Transfer\RestCompanyBusinessUnitOrderListTransfer $restCompanyBusinessUnitOrderListTransfer
     *
     * @return \Generated\Shared\Transfer\CompanyBusinessUnitOrderListTransfer
     */
    public function find(
        RestCompanyBusinessUnitOrderListTransfer $restCompanyBusinessUnitOrderListTransfer
    ): CompanyBusinessUnitOrderListTransfer {
        $companyBusinessUnitOrderListRequestTransfer = $this->restCompanyBusinessUnitOrderListMapper
            ->mapToCompanyBusinessUnitOrderListRequestTransfer($restCompanyBusinessUnitOrderListTransfer);

        $companyBusinessUnitTransfer = $this->companyBusinessUnitReader->getByRestCompanyBusinessUnitOrderList(
            $restCompanyBusinessUnitOrderListTransfer
        );

        if ($companyBusinessUnitTransfer !== null) {
            $companyBusinessUnitOrderListRequestTransfer->setIdCompanyBusinessUnit(
                $companyBusinessUnitTransfer->getIdCompanyBusinessUnit()
            );
        }

        return $this->companyBusinessUnitSalesFacade->findOrders($companyBusinessUnitOrderListRequestTransfer);
    }
}
