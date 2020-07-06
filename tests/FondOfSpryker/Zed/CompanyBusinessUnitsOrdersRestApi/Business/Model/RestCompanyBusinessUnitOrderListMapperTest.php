<?php

namespace FondOfSpryker\Zed\CompanyBusinessUnitsOrdersRestApi\Business\Model;

use Codeception\Test\Unit;
use Generated\Shared\Transfer\RestCompanyBusinessUnitOrderListTransfer;

class RestCompanyBusinessUnitOrderListMapperTest extends Unit
{
    /**
     * @var \PHPUnit\Framework\MockObject\MockObject|\Generated\Shared\Transfer\RestCompanyBusinessUnitOrderListTransfer
     */
    protected $restCompanyBusinessUnitOrderListTransferMock;

    /**
     * @var \FondOfSpryker\Zed\CompanyBusinessUnitsOrdersRestApi\Business\Model\RestCompanyBusinessUnitOrderListMapper
     */
    protected $restCompanyBusinessUnitOrderListMapper;

    /**
     * @return void
     */
    protected function _before(): void
    {
        parent::_before();

        $this->restCompanyBusinessUnitOrderListTransferMock = $this->getMockBuilder(RestCompanyBusinessUnitOrderListTransfer::class)
            ->disableOriginalConstructor()
            ->getMock();

        $this->restCompanyBusinessUnitOrderListMapper = new RestCompanyBusinessUnitOrderListMapper();
    }

    /**
     * @return void
     */
    public function testMapToCompanyBusinessUnitOrderListRequestTransfer(): void
    {
        $data = [
            'idCustomer' => 1,
            'idCompanyBusinessUnit' => 1,
            'filter' => [
                'limit' => 10,
                'offset' => 0,
            ],
        ];

        $this->restCompanyBusinessUnitOrderListTransferMock->expects($this->atLeastOnce())
            ->method('toArray')
            ->willReturn($data);

        $companyBusinessUnitOrderListRequestTransfer = $this->restCompanyBusinessUnitOrderListMapper
            ->mapToCompanyBusinessUnitOrderListRequestTransfer($this->restCompanyBusinessUnitOrderListTransferMock);

        $this->assertEquals($data['idCustomer'], $companyBusinessUnitOrderListRequestTransfer->getIdCustomer());
        $this->assertEquals($data['idCompanyBusinessUnit'], $companyBusinessUnitOrderListRequestTransfer->getIdCompanyBusinessUnit());
        $this->assertEquals($data['filter']['limit'], $companyBusinessUnitOrderListRequestTransfer->getFilter()->getLimit());
        $this->assertEquals($data['filter']['offset'], $companyBusinessUnitOrderListRequestTransfer->getFilter()->getOffset());
    }
}
