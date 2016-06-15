# php-api
Mizmoz API for PHP


# Basic Usage

```php
use Mizmoz\API\Client;
use Mizmoz\API\EmailCampaign\Send;

$client = new Client($apiId, $apiKey);

// set the email campaign id, email list id and email - this can be either emailId, and email address or array of details
// ['emailAddress' => 'my@email.com', 'emailFirstname' => 'Me']
$send = new Send($emailCampaignId, $emailListId, $emailId, [
   // This will be usable in the template with: {{live.message}}
   'message' => 'Just something to show variables being passed in to a template'
]);

$response = $client->execute($send);

var_dump($response);
```