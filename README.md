# AcmeShipping module
AcmeShipping provides table rate shipping method, based on 
- country_code
- postcode
- website

on store view basis

## Architecture

### Services
#### Onestic\AcmeShipping\Api\Service\Rule\MatchRulesServiceInterface
Provides shipping rules search result by `Magento\Quote\Model\Quote\Address\RateRequest` 

#### Onestic\AcmeShipping\Api\Service\CollectRatesServiceInterface
Provides shipping methods search result by `Magento\Quote\Model\Quote\Address\RateRequest`

### Repositories
#### Onestic\AcmeShipping\Api\RuleRepositoryInterface
Provides CRUD operations with shipping rules  

### Data Models
#### Onestic\AcmeShipping\Api\Data\RuleInterface
Data Model for module shipping rules

### Logic Entry Point:
#### Onestic\AcmeShipping\Model\Carrier\Acme::collectRates
Entry point for collect AcmeShipping rates logic

## Configurations
Module configurations located in `Sales > Delivery Methods` section

Possible config settings:
- Enable module - Yes/No
- Default Carrier Title
- Default Method Name
- Default Shipping Cost
- Allowed countries: (All / Selected)
- Show method if not applicable (Yes/No)
- Sort Order

## Run Integration tests
1. Move to dev/tests/integration directory
2. Run Next commands:
`
   ../../../vendor/bin/phpunit ../../../app/code/Onestic/AcmeShipping/Test/Integration/Service/Rule/MatchRulesServiceTest.php
   ../../../vendor/bin/phpunit ../../../app/code/Onestic/AcmeShipping/Test/Integration/Service/CollectRatesServiceTest.php
`
