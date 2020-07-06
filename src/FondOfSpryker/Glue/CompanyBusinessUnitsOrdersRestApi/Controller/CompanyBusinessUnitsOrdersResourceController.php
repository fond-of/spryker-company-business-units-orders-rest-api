<?php

namespace FondOfSpryker\Glue\CompanyBusinessUnitsOrdersRestApi\Controller;

use Spryker\Glue\GlueApplication\Rest\JsonApi\RestResponseInterface;
use Spryker\Glue\GlueApplication\Rest\Request\Data\RestRequestInterface;
use Spryker\Glue\Kernel\Controller\AbstractController;

/**
 * @method \FondOfSpryker\Glue\CompanyBusinessUnitsOrdersRestApi\CompanyBusinessUnitsOrdersRestApiFactory getFactory()
 */
class CompanyBusinessUnitsOrdersResourceController extends AbstractController
{
    /**
     * @Glue({
     *     "getResourceById": {
     *          "path": "/company-business-units/{companyBusinessUnitId}/company-business-unit-orders/{companyBusinessUnitOrderId}",
     *          "summary": [
     *              "Retrieves order by id."
     *          ],
     *          "parameters": [{
     *              "ref": "acceptLanguage"
     *          }],
     *          "responseAttributesClassName": "Generated\\Shared\\Transfer\\RestOrderDetailsAttributesTransfer",
     *          "responses": {
     *              "403": "Unauthorized request.",
     *              "404": "Order not found."
     *          }
     *     },
     *     "getCollection": {
     *          "path": "/company-business-units/{companyBusinessUnitId}/company-business-unit-orders/
     *          "summary": [
     *              "Retrieves list of orders."
     *          ],
     *          "parameters": [{
     *              "ref": "acceptLanguage"
     *          }],
     *          "responses": {
     *              "400": "Company business unit identifier is missing."
     *              "403": "Unauthorized request."
     *          }
     *     }
     * })
     *
     * @param \Spryker\Glue\GlueApplication\Rest\Request\Data\RestRequestInterface $restRequest
     *
     * @return \Spryker\Glue\GlueApplication\Rest\JsonApi\RestResponseInterface
     */
    public function getAction(RestRequestInterface $restRequest): RestResponseInterface
    {
        return $this->getFactory()->createOrderReader()
            ->findOrders($restRequest);
    }
}
