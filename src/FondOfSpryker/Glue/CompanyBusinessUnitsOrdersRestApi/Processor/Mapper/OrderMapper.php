<?php

namespace FondOfSpryker\Glue\CompanyBusinessUnitsOrdersRestApi\Processor\Mapper;

use ArrayObject;
use Generated\Shared\Transfer\CountryTransfer;
use Generated\Shared\Transfer\ItemTransfer;
use Generated\Shared\Transfer\OrderTransfer;
use Generated\Shared\Transfer\RestOrderDetailsAttributesTransfer;
use Generated\Shared\Transfer\RestOrderItemsAttributesTransfer;

class OrderMapper implements OrderMapperInterface
{
    /**
     * @var \FondOfSpryker\Glue\CompanyBusinessUnitsOrdersRestApi\Processor\Mapper\OrderShipmentMapperInterface
     */
    protected $orderShipmentMapper;

    /**
     * @param \FondOfSpryker\Glue\CompanyBusinessUnitsOrdersRestApi\Processor\Mapper\OrderShipmentMapperInterface $orderShipmentMapper
     */
    public function __construct(OrderShipmentMapperInterface $orderShipmentMapper)
    {
        $this->orderShipmentMapper = $orderShipmentMapper;
    }

    /**
     * @param \Generated\Shared\Transfer\OrderTransfer $orderTransfer
     *
     * @return \Generated\Shared\Transfer\RestOrderDetailsAttributesTransfer
     */
    public function mapOrderTransferToRestOrderDetailsAttributesTransfer(
        OrderTransfer $orderTransfer
    ): RestOrderDetailsAttributesTransfer {
        $orderTransfer->requireTotals();
        $orderTransfer->getTotals()->requireTaxTotal();

        $restOrderDetailsAttributesTransfer = (new RestOrderDetailsAttributesTransfer())
            ->fromArray($orderTransfer->toArray(), true);

        $restOrderDetailsAttributesTransfer->getTotals()->setTaxTotal($orderTransfer->getTotals()->getTaxTotal()->getAmount());
        $restOrderDetailsAttributesTransfer->getBillingAddress()->setCountry($orderTransfer->getBillingAddress()->getCountry()->getName());
        $restOrderDetailsAttributesTransfer->getBillingAddress()->setIso2Code($orderTransfer->getBillingAddress()->getCountry()->getIso2Code());

        $restOrderDetailsAttributesTransfer = $this->mapOrderShippingAddressTransferToRestOrderDetailsAttributesTransfer($orderTransfer, $restOrderDetailsAttributesTransfer);

        $restOrderItemsAttributesTransfers = [];
        foreach ($orderTransfer->getItems() as $itemTransfer) {
            $restOrderItemsAttributesTransfers[] = $this->mapItemTransferToRestOrderItemsAttributesTransfer(
                $itemTransfer,
                new RestOrderItemsAttributesTransfer()
            );
        }

        $restOrderDetailsAttributesTransfer->setItems(new ArrayObject($restOrderItemsAttributesTransfers));

        return $restOrderDetailsAttributesTransfer;
    }

    /**
     * @param \Generated\Shared\Transfer\ItemTransfer $itemTransfer
     * @param \Generated\Shared\Transfer\RestOrderItemsAttributesTransfer $restOrderItemsAttributesTransfer
     *
     * @return \Generated\Shared\Transfer\RestOrderItemsAttributesTransfer
     */
    public function mapItemTransferToRestOrderItemsAttributesTransfer(
        ItemTransfer $itemTransfer,
        RestOrderItemsAttributesTransfer $restOrderItemsAttributesTransfer
    ): RestOrderItemsAttributesTransfer {
        $restOrderItemsAttributesTransfer = $restOrderItemsAttributesTransfer->fromArray(
            $itemTransfer->toArray(),
            true
        );

        return $restOrderItemsAttributesTransfer;
    }

    /**
     * @param \Generated\Shared\Transfer\OrderTransfer $orderTransfer
     * @param \Generated\Shared\Transfer\RestOrderDetailsAttributesTransfer $restOrderDetailsAttributesTransfer
     *
     * @return \Generated\Shared\Transfer\RestOrderDetailsAttributesTransfer
     */
    public function mapOrderShippingAddressTransferToRestOrderDetailsAttributesTransfer(
        OrderTransfer $orderTransfer,
        RestOrderDetailsAttributesTransfer $restOrderDetailsAttributesTransfer
    ): RestOrderDetailsAttributesTransfer {
        $countryTransfer = $this->findItemLevelShippingAddressCountry($orderTransfer);
        $countryName = $countryTransfer ? $countryTransfer->getName() : null;
        $countryIso2Code = $countryTransfer ? $countryTransfer->getIso2Code() : null;

        $restOrderDetailsAttributesTransfer->getShippingAddress()->setCountry($countryName);
        $restOrderDetailsAttributesTransfer->getShippingAddress()->setIso2Code($countryIso2Code);

        $restOrderDetailsAttributesTransfer->setShipments(
            $this->orderShipmentMapper->mapOrderTransferToRestOrderShipmentTransfers($orderTransfer, new ArrayObject())
        );

        return $restOrderDetailsAttributesTransfer;
    }

    /**
     * @param \Generated\Shared\Transfer\OrderTransfer $orderTransfer
     *
     * @return \Generated\Shared\Transfer\CountryTransfer|null
     */
    protected function findItemLevelShippingAddressCountry(OrderTransfer $orderTransfer): ?CountryTransfer
    {
        if ($orderTransfer->getItems()->count() === 0) {
            return null;
        }

        /** @var \Generated\Shared\Transfer\ItemTransfer $firstItemTransfer */
        $firstItemTransfer = $orderTransfer->getItems()->getIterator()->current();
        if (
            $firstItemTransfer->getShipment() === null
            || $firstItemTransfer->getShipment()->getShippingAddress() === null
        ) {
            return null;
        }

        return $firstItemTransfer->getShipment()
            ->getShippingAddress()
            ->getCountry();
    }
}
