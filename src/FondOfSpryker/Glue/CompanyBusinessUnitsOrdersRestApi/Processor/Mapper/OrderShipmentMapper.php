<?php

namespace FondOfSpryker\Glue\CompanyBusinessUnitsOrdersRestApi\Processor\Mapper;

use ArrayObject;
use Generated\Shared\Transfer\OrderTransfer;
use Generated\Shared\Transfer\RestOrderShipmentTransfer;
use Generated\Shared\Transfer\ShipmentMethodTransfer;

class OrderShipmentMapper implements OrderShipmentMapperInterface
{
    /**
     * @param \Generated\Shared\Transfer\OrderTransfer $orderTransfer
     * @param \ArrayObject $restOrderShipmentTransfers
     *
     * @return \ArrayObject|\Generated\Shared\Transfer\RestOrderShipmentTransfer[]
     */
    public function mapOrderTransferToRestOrderShipmentTransfers(
        OrderTransfer $orderTransfer,
        ArrayObject $restOrderShipmentTransfers
    ): ArrayObject {
        foreach ($orderTransfer->getShipmentMethods() as $shipmentMethodTransfer) {
            $restOrderShipmentTransfers->append(
                $this->createRestShipmentMethodTransfer(
                    $shipmentMethodTransfer,
                    $orderTransfer->getExpenses(),
                    $orderTransfer->getCurrencyIsoCode()
                )
            );
        }

        return $restOrderShipmentTransfers;
    }

    /**
     * @param \Generated\Shared\Transfer\ShipmentMethodTransfer $shipmentMethodTransfer
     * @param \ArrayObject|\Generated\Shared\Transfer\ExpenseTransfer[] $expenseTransfers
     * @param string $currencyIsoCode
     *
     * @return \Generated\Shared\Transfer\RestOrderShipmentTransfer
     */
    protected function createRestShipmentMethodTransfer(
        ShipmentMethodTransfer $shipmentMethodTransfer,
        ArrayObject $expenseTransfers,
        string $currencyIsoCode
    ): RestOrderShipmentTransfer {
        $restOrderShipmentTransfer = new RestOrderShipmentTransfer();
        $restOrderShipmentTransfer->fromArray($shipmentMethodTransfer->toArray(), true);
        $restOrderShipmentTransfer->setShipmentMethodName($shipmentMethodTransfer->getName());
        $restOrderShipmentTransfer->setCurrencyIsoCode($currencyIsoCode);

        foreach ($expenseTransfers as $expenseTransfer) {
            if ($expenseTransfer->getIdSalesExpense() === $shipmentMethodTransfer->getFkSalesExpense()) {
                $restOrderShipmentTransfer
                    ->setDefaultNetPrice($expenseTransfer->getSumNetPrice())
                    ->setDefaultGrossPrice($expenseTransfer->getSumGrossPrice());
            }
        }

        return $restOrderShipmentTransfer;
    }
}