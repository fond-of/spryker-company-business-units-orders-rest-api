<?php

namespace FondOfSpryker\Glue\CompanyBusinessUnitsOrdersRestApi\Processor\Mapper;

use ArrayObject;
use Codeception\Test\Unit;
use Generated\Shared\Transfer\ExpenseTransfer;
use Generated\Shared\Transfer\OrderTransfer;
use Generated\Shared\Transfer\ShipmentMethodTransfer;

class OrderShipmentMapperTest extends Unit
{
    /**
     * @var \PHPUnit\Framework\MockObject\MockObject|\Generated\Shared\Transfer\OrderTransfer
     */
    protected $orderTransferMock;

    /**
     * @var \PHPUnit\Framework\MockObject\MockObject|\Generated\Shared\Transfer\ShipmentMethodTransfer
     */
    protected $shipmentMethodTransferMock;

    /**
     * @var \PHPUnit\Framework\MockObject\MockObject|\Generated\Shared\Transfer\ExpenseTransfer
     */
    protected $expenseTransferMock;

    /**
     * @var string
     */
    protected $shipmentMethodName;

    /**
     * @var string
     */
    protected $currencyIsoCode;

    /**
     * @var int
     */
    protected $sumGrossPrice;

    /**
     * @var int
     */
    protected $sumNetPrice;

    /**
     * @var int
     */
    protected $idSalesExpense;

    /**
     * @var \FondOfSpryker\Glue\CompanyBusinessUnitsOrdersRestApi\Processor\Mapper\OrderShipmentMapper
     */
    protected $orderShipmentMapper;

    /**
     * @Override
     *
     * @return void
     */
    protected function _before(): void
    {
        parent::_before();

        $this->orderTransferMock = $this->getMockBuilder(OrderTransfer::class)
            ->disableOriginalConstructor()
            ->getMock();

        $this->shipmentMethodTransferMock = $this->getMockBuilder(ShipmentMethodTransfer::class)
            ->disableOriginalConstructor()
            ->getMock();

        $this->expenseTransferMock = $this->getMockBuilder(ExpenseTransfer::class)
            ->disableOriginalConstructor()
            ->getMock();

        $this->shipmentMethodName = 'Shipment Method Name';
        $this->currencyIsoCode = 'EUR';
        $this->sumGrossPrice = 11900;
        $this->sumNetPrice = 10000;
        $this->idSalesExpense = 1;

        $this->orderShipmentMapper = new OrderShipmentMapper();
    }

    /**
     * @return void
     */
    public function testMapOrderTransferToRestOrderShipmentTransfers(): void
    {
        $this->orderTransferMock->expects($this->atLeastOnce())
            ->method('getShipmentMethods')
            ->willReturn(new ArrayObject([$this->shipmentMethodTransferMock]));

        $this->orderTransferMock->expects($this->atLeastOnce())
            ->method('getExpenses')
            ->willReturn(new ArrayObject([$this->expenseTransferMock]));

        $this->orderTransferMock->expects($this->atLeastOnce())
            ->method('getCurrencyIsoCode')
            ->willReturn($this->currencyIsoCode);

        $this->shipmentMethodTransferMock->expects($this->atLeastOnce())
            ->method('toArray')
            ->willReturn([]);

        $this->shipmentMethodTransferMock->expects($this->atLeastOnce())
            ->method('getName')
            ->willReturn($this->shipmentMethodName);

        $this->shipmentMethodTransferMock->expects($this->atLeastOnce())
            ->method('getFkSalesExpense')
            ->willReturn($this->idSalesExpense);

        $this->expenseTransferMock->expects($this->atLeastOnce())
            ->method('getIdSalesExpense')
            ->willReturn($this->idSalesExpense);

        $this->expenseTransferMock->expects($this->atLeastOnce())
            ->method('getSumNetPrice')
            ->willReturn($this->sumNetPrice);

        $this->expenseTransferMock->expects($this->atLeastOnce())
            ->method('getSumGrossPrice')
            ->willReturn($this->sumGrossPrice);

        $restOrderShipmentTransfers = $this->orderShipmentMapper->mapOrderTransferToRestOrderShipmentTransfers(
            $this->orderTransferMock,
            new ArrayObject()
        );

        $this->assertCount(1, $restOrderShipmentTransfers);
    }
}
