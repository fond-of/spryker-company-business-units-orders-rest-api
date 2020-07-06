<?php

namespace FondOfSpryker\Glue\CompanyBusinessUnitsOrdersRestApi\Processor\Mapper;

use ArrayObject;
use Generated\Shared\Transfer\OrderTransfer;

interface OrderShipmentMapperInterface
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
    ): ArrayObject;
}
