<?php

namespace FondOfSpryker\Glue\CompanyBusinessUnitsOrdersRestApi;

use FondOfSpryker\Glue\CompanyBusinessUnitsOrdersRestApi\Processor\Mapper\OrderMapper;
use FondOfSpryker\Glue\CompanyBusinessUnitsOrdersRestApi\Processor\Mapper\OrderMapperInterface;
use FondOfSpryker\Glue\CompanyBusinessUnitsOrdersRestApi\Processor\Mapper\OrderShipmentMapper;
use FondOfSpryker\Glue\CompanyBusinessUnitsOrdersRestApi\Processor\Mapper\OrderShipmentMapperInterface;
use FondOfSpryker\Glue\CompanyBusinessUnitsOrdersRestApi\Processor\Order\OrderReader;
use FondOfSpryker\Glue\CompanyBusinessUnitsOrdersRestApi\Processor\Order\OrderReaderInterface;
use FondOfSpryker\Glue\CompanyBusinessUnitsOrdersRestApi\Processor\RestResponseBuilder\OrderRestResponseBuilder;
use FondOfSpryker\Glue\CompanyBusinessUnitsOrdersRestApi\Processor\RestResponseBuilder\OrderRestResponseBuilderInterface;
use Spryker\Glue\Kernel\AbstractFactory;

/**
 * @method \FondOfSpryker\Client\CompanyBusinessUnitsOrdersRestApi\CompanyBusinessUnitsOrdersRestApiClientInterface getClient()
 */
class CompanyBusinessUnitsOrdersRestApiFactory extends AbstractFactory
{
    /**
     * @return \FondOfSpryker\Glue\CompanyBusinessUnitsOrdersRestApi\Processor\Order\OrderReaderInterface
     */
    public function createOrderReader(): OrderReaderInterface
    {
        return new OrderReader(
            $this->getClient(),
            $this->createOrderRestResponseBuilder()
        );
    }

    /**
     * @return \FondOfSpryker\Glue\CompanyBusinessUnitsOrdersRestApi\Processor\RestResponseBuilder\OrderRestResponseBuilderInterface
     */
    protected function createOrderRestResponseBuilder(): OrderRestResponseBuilderInterface
    {
        return new OrderRestResponseBuilder(
            $this->getResourceBuilder(),
            $this->createOrderMapper()
        );
    }

    /**
     * @return \FondOfSpryker\Glue\CompanyBusinessUnitsOrdersRestApi\Processor\Mapper\OrderMapperInterface
     */
    protected function createOrderMapper(): OrderMapperInterface
    {
        return new OrderMapper($this->createOrderShipmentMapper());
    }

    /**
     * @return \FondOfSpryker\Glue\CompanyBusinessUnitsOrdersRestApi\Processor\Mapper\OrderShipmentMapperInterface
     */
    protected function createOrderShipmentMapper(): OrderShipmentMapperInterface
    {
        return new OrderShipmentMapper();
    }
}
