<?php

namespace FondOfSpryker\Glue\CompanyBusinessUnitsOrdersRestApi;

use Spryker\Glue\Kernel\AbstractBundleConfig;

class CompanyBusinessUnitsOrdersRestApiConfig extends AbstractBundleConfig
{
    public const PARENT_RESOURCE_COMPANY_BUSINESS_UNITS = 'company-business-units';
    public const RESOURCE_COMPANY_BUSINESS_UNIT_ORDERS = 'company-business-unit-orders';
    public const CONTROLLER_COMPANY_BUSINESS_UNITS_ORDERS = 'company-business-units-orders-resource';

    public const RESPONSE_CODE_COMPANY_BUSINESS_UNIT_IDENTIFIER_MISSING = '2000';
    public const RESPONSE_CODE_CANT_FIND_ORDER = '2001';
    public const EXCEPTION_MESSAGE_CANT_FIND_ORDER = 'Can\'t find order by the given order reference';
    public const EXCEPTION_MESSAGE_COMPANY_BUSINESS_UNIT_IDENTIFIER_MISSING = 'Company business unit uuid is missing.';
}
