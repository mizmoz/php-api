# PHP API for [Mizmoz.com](https://www.mizmoz.com/)

PHP Library for the Mizmoz API v2.0

## Requirements 

PHP 5.6+

## Installation using Composer

Add mizmoz/php-api to your project

```
# composer require mizmoz/php-api
```

Or manually add mizmoz/php-api to your composer.json file

```
"require": {
  "mizmoz/php-api": "dev-master"
}
```

Then update your project with composer

```
# composer update
```

# Basic Usage

### Initialise the Client
```php
use Mizmoz\API\Client;

// Use the apiId and apiKey provided in the admin interface 
// Mizmoz.com > Admin > Access > API Access
$client = new Client($apiId, $apiKey);
```

### Create update a subscriber

```php
use Mizmoz\API\EmailList\Email\Create;

// Set the emailListId (required), email (required) and first name 
$create = new Create($emailListId, $email, $firstName);

// Optionally you can set the title
$create->setTitle('Miss');

// Last name
$create->setLastName('Chadwick');

// Email source, this gives you a way of identifying where the subscriber came from.
// For example, website, facebook, xmas-campaign
$create->setSource('website');

// Set the subscriber created date, by default the current time and date will be used
// this can be useful if you're doing batch additions after a few days. Always be careful adding
// old data though, we want to keep our lists in good helth!
$create->setCreated(new \DateTime('2016-01-26 09:00:00'));

// You can set additional info with the subscriber by using the subscriber meta store
// Before you can set extra data please add the extra columns to the email list
// Mizmoz.com > Email Lists > Settings >Add Fields in the Merge fields section
$create->setMeta('customerId', '12345');

// Execute the create command 
$response = $client->execute($create);

var_dump($response);
```

### Send an transactional email campaign to a new or existing subscriber
```php
use Mizmoz\API\EmailCampaign\Send;

// Set the email campaign id, email list id and email - this can be either emailId, and 
// email address or array of details
// ['emailAddress' => 'my@email.com', 'emailFirstname' => 'Me']
$send = new Send($emailCampaignId, $emailListId, $emailId, [
   // This will be usable in the template with: {{live.message}}
   'message' => 'Just something to show variables being passed in to a template'
]);

$response = $client->execute($send);

var_dump($response);
```