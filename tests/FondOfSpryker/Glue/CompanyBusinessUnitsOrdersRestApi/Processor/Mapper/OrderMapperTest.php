<?php

namespace FondOfSpryker\Glue\CompanyBusinessUnitsOrdersRestApi\Processor\Mapper;

use ArrayObject;
use Codeception\Test\Unit;
use Generated\Shared\Transfer\AddressTransfer;
use Generated\Shared\Transfer\CountryTransfer;
use Generated\Shared\Transfer\ItemTransfer;
use Generated\Shared\Transfer\OrderTransfer;
use Generated\Shared\Transfer\ShipmentTransfer;
use Generated\Shared\Transfer\TaxTotalTransfer;
use Generated\Shared\Transfer\TotalsTransfer;

class OrderMapperTest extends Unit
{
    /**
     * @var \PHPUnit\Framework\MockObject\MockObject|\Generated\Shared\Transfer\OrderTransfer
     */
    protected $orderTransferMock;

    /**
     * @var \PHPUnit\Framework\MockObject\MockObject|\Generated\Shared\Transfer\TotalsTransfer
     */
    protected $totalsTransferMock;

    /**
     * @var \PHPUnit\Framework\MockObject\MockObject|\Generated\Shared\Transfer\TaxTotalTransfer
     */
    protected $taxTotalTransferMock;

    /**
     * @var \PHPUnit\Framework\MockObject\MockObject|\Generated\Shared\Transfer\AddressTransfer
     */
    protected $addressTransferMock;

    /**
     * @var \PHPUnit\Framework\MockObject\MockObject|\Generated\Shared\Transfer\ItemTransfer
     */
    protected $itemTransferMock;

    /**
     * @var \PHPUnit\Framework\MockObject\MockObject|\Generated\Shared\Transfer\CountryTransfer
     */
    protected $countryTransferMock;

    /**
     * @var \PHPUnit\Framework\MockObject\MockObject|\Generated\Shared\Transfer\ShipmentTransfer
     */
    protected $shipmentTransferMock;

    /**
     * @var \PHPUnit\Framework\MockObject\MockObject|\FondOfSpryker\Glue\CompanyBusinessUnitsOrdersRestApi\Processor\Mapper\OrderShipmentMapperInterface
     */
    protected $orderShipmentMapperMock;

    /**
     * @var string
     */
    protected $countryIso2Code;

    /**
     * @var string
     */
    protected $countryName;

    /**
     * @var \FondOfSpryker\Glue\CompanyBusinessUnitsOrdersRestApi\Processor\Mapper\OrderMapper
     */
    protected $orderMapper;

    /**
     * @return void
     */
    protected function _before(): void
    {
        parent::_before();

        $this->orderTransferMock = $this->getMockBuilder(OrderTransfer::class)
            ->disableOriginalConstructor()
            ->getMock();

        $this->totalsTransferMock = $this->getMockBuilder(TotalsTransfer::class)
            ->disableOriginalConstructor()
            ->getMock();

        $this->taxTotalTransferMock = $this->getMockBuilder(TaxTotalTransfer::class)
            ->disableOriginalConstructor()
            ->getMock();

        $this->addressTransferMock = $this->getMockBuilder(AddressTransfer::class)
            ->disableOriginalConstructor()
            ->getMock();

        $this->itemTransferMock = $this->getMockBuilder(ItemTransfer::class)
            ->disableOriginalConstructor()
            ->getMock();

        $this->shipmentTransferMock = $this->getMockBuilder(ShipmentTransfer::class)
            ->disableOriginalConstructor()
            ->getMock();

        $this->countryTransferMock = $this->getMockBuilder(CountryTransfer::class)
            ->disableOriginalConstructor()
            ->getMock();

        $this->orderShipmentMapperMock = $this->getMockBuilder(OrderShipmentMapperInterface::class)
            ->disableOriginalConstructor()
            ->getMock();

        $this->countryIso2Code = 'DE';
        $this->countryName = 'Germany';

        $this->orderMapper = new OrderMapper($this->orderShipmentMapperMock);
    }

    /**
     * @return void
     */
    public function testMapOrderTransferToRestOrderDetailsAttributesTransfer(): void
    {
        $this->orderTransferMock->expects($this->atLeastOnce())
            ->method('requireTotals')
            ->willReturn($this->orderTransferMock);

        $this->orderTransferMock->expects($this->atLeastOnce())
            ->method('getTotals')
            ->willReturn($this->totalsTransferMock);

        $this->totalsTransferMock->expects($this->atLeastOnce())
            ->method('requireTaxTotal')
            ->willReturn($this->totalsTransferMock);

        $this->orderTransferMock->expects($this->atLeastOnce())
            ->method('toArray')
            ->willReturn([
                'billingAddress' => [],
                'shippingAddress' => [],
                'totals' => [],
            ]);

        $this->totalsTransferMock->expects($this->atLeastOnce())
            ->method('getTaxTotal')
            ->willReturn($this->taxTotalTransferMock);

        $this->taxTotalTransferMock->expects($this->atLeastOnce())
            ->method('getAmount')
            ->willReturn(10000);

        $this->orderTransferMock->expects($this->atLeastOnce())
        ->method('getBillingAddress')
        ->willReturn($this->addressTransferMock);

        $this->addressTransferMock->expects($this->atLeastOnce())
            ->method('getCountry')
            ->willReturn($this->countryTransferMock);

        $this->countryTransferMock->expects($this->atLeastOnce())
            ->method('getName')
            ->willReturn($this->countryName);

        $this->countryTransferMock->expects($this->atLeastOnce())
            ->method('getIso2Code')
            ->willReturn($this->countryIso2Code);

        $this->orderTransferMock->expects($this->atLeastOnce())
            ->method('getItems')
            ->willReturn(new ArrayObject([$this->itemTransferMock]));

        $this->itemTransferMock->expects($this->atLeastOnce())
            ->method('getShipment')
            ->willReturn($this->shipmentTransferMock);

        $this->shipmentTransferMock->expects($this->atLeastOnce())
            ->method('getShippingAddress')
            ->willReturn($this->addressTransferMock);

        $this->itemTransferMock->expects($this->atLeastOnce())
            ->method('toArray')
            ->willReturn([]);

        $this->orderShipmentMapperMock->expects($this->atLeastOnce())
            ->method('mapOrderTransferToRestOrderShipmentTransfers')
            ->with($this->orderTransferMock, new ArrayObject())
            ->willReturn(new ArrayObject());

        $restOrderDetailsAttributesTransfer = $this->orderMapper->mapOrderTransferToRestOrderDetailsAttributesTransfer(
            $this->orderTransferMock
        );

        $this->assertEquals($this->countryName, $restOrderDetailsAttributesTransfer->getBillingAddress()->getCountry());
        $this->assertEquals($this->countryName, $restOrderDetailsAttributesTransfer->getShippingAddress()->getCountry());
        $this->assertEquals($this->countryIso2Code, $restOrderDetailsAttributesTransfer->getBillingAddress()->getIso2Code());
        $this->assertEquals($this->countryIso2Code, $restOrderDetailsAttributesTransfer->getShippingAddress()->getIso2Code());
    }

    /**
     * @return void
     */
    public function testMapOrderTransferToRestOrderDetailsAttributesTransferWithItemCountZero(): void
    {
        $this->orderTransferMock->expects($this->atLeastOnce())
            ->method('requireTotals')
            ->willReturn($this->orderTransferMock);

        $this->orderTransferMock->expects($this->atLeastOnce())
            ->method('getTotals')
            ->willReturn($this->totalsTransferMock);

        $this->totalsTransferMock->expects($this->atLeastOnce())
            ->method('requireTaxTotal')
            ->willReturn($this->totalsTransferMock);

        $this->orderTransferMock->expects($this->atLeastOnce())
            ->method('toArray')
            ->willReturn([
                'billingAddress' => [],
                'shippingAddress' => [],
                'totals' => [],
            ]);

        $this->totalsTransferMock->expects($this->atLeastOnce())
            ->method('getTaxTotal')
            ->willReturn($this->taxTotalTransferMock);

        $this->taxTotalTransferMock->expects($this->atLeastOnce())
            ->method('getAmount')
            ->willReturn(10000);

        $this->orderTransferMock->expects($this->atLeastOnce())
            ->method('getBillingAddress')
            ->willReturn($this->addressTransferMock);

        $this->addressTransferMock->expects($this->atLeastOnce())
            ->method('getCountry')
            ->willReturn($this->countryTransferMock);

        $this->countryTransferMock->expects($this->atLeastOnce())
            ->method('getName')
            ->willReturn($this->countryName);

        $this->countryTransferMock->expects($this->atLeastOnce())
            ->method('getIso2Code')
            ->willReturn($this->countryIso2Code);

        $this->orderTransferMock->expects($this->atLeastOnce())
            ->method('getItems')
            ->willReturn(new ArrayObject([]));

        $this->orderShipmentMapperMock->expects($this->atLeastOnce())
            ->method('mapOrderTransferToRestOrderShipmentTransfers')
            ->with($this->orderTransferMock, new ArrayObject())
            ->willReturn(new ArrayObject());

        $restOrderDetailsAttributesTransfer = $this->orderMapper->mapOrderTransferToRestOrderDetailsAttributesTransfer(
            $this->orderTransferMock
        );

        $this->assertEquals($this->countryName, $restOrderDetailsAttributesTransfer->getBillingAddress()->getCountry());
        $this->assertEquals(null, $restOrderDetailsAttributesTransfer->getShippingAddress()->getCountry());
        $this->assertEquals($this->countryIso2Code, $restOrderDetailsAttributesTransfer->getBillingAddress()->getIso2Code());
        $this->assertEquals(null, $restOrderDetailsAttributesTransfer->getShippingAddress()->getIso2Code());
    }

    /**
     * @return void
     */
    public function testMapOrderTransferToRestOrderDetailsAttributesTransferWithoutShippableItems(): void
    {
        $this->orderTransferMock->expects($this->atLeastOnce())
            ->method('requireTotals')
            ->willReturn($this->orderTransferMock);

        $this->orderTransferMock->expects($this->atLeastOnce())
            ->method('getTotals')
            ->willReturn($this->totalsTransferMock);

        $this->totalsTransferMock->expects($this->atLeastOnce())
            ->method('requireTaxTotal')
            ->willReturn($this->totalsTransferMock);

        $this->orderTransferMock->expects($this->atLeastOnce())
            ->method('toArray')
            ->willReturn([
                'billingAddress' => [],
                'shippingAddress' => [],
                'totals' => [],
            ]);

        $this->totalsTransferMock->expects($this->atLeastOnce())
            ->method('getTaxTotal')
            ->willReturn($this->taxTotalTransferMock);

        $this->taxTotalTransferMock->expects($this->atLeastOnce())
            ->method('getAmount')
            ->willReturn(10000);

        $this->orderTransferMock->expects($this->atLeastOnce())
            ->method('getBillingAddress')
            ->willReturn($this->addressTransferMock);

        $this->addressTransferMock->expects($this->atLeastOnce())
            ->method('getCountry')
            ->willReturn($this->countryTransferMock);

        $this->countryTransferMock->expects($this->atLeastOnce())
            ->method('getName')
            ->willReturn($this->countryName);

        $this->countryTransferMock->expects($this->atLeastOnce())
            ->method('getIso2Code')
            ->willReturn($this->countryIso2Code);

        $this->orderTransferMock->expects($this->atLeastOnce())
            ->method('getItems')
            ->willReturn(new ArrayObject([$this->itemTransferMock]));

        $this->itemTransferMock->expects($this->atLeastOnce())
            ->method('getShipment')
            ->willReturn(null);

        $this->itemTransferMock->expects($this->atLeastOnce())
            ->method('toArray')
            ->willReturn([]);

        $this->orderShipmentMapperMock->expects($this->atLeastOnce())
            ->method('mapOrderTransferToRestOrderShipmentTransfers')
            ->with($this->orderTransferMock, new ArrayObject())
            ->willReturn(new ArrayObject());

        $restOrderDetailsAttributesTransfer = $this->orderMapper->mapOrderTransferToRestOrderDetailsAttributesTransfer(
            $this->orderTransferMock
        );

        $this->assertEquals($this->countryName, $restOrderDetailsAttributesTransfer->getBillingAddress()->getCountry());
        $this->assertEquals(null, $restOrderDetailsAttributesTransfer->getShippingAddress()->getCountry());
        $this->assertEquals($this->countryIso2Code, $restOrderDetailsAttributesTransfer->getBillingAddress()->getIso2Code());
        $this->assertEquals(null, $restOrderDetailsAttributesTransfer->getShippingAddress()->getIso2Code());
    }
}
