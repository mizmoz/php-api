<?php
/**
 * All rights reserved. No part of this code may be reproduced, modified,
 * amended or retransmitted in any form or by any means for any purpose without
 * prior written consent of Mizmoz Limited.
 * You must ensure that this copyright notice remains intact at all times
 *
 * @package Mizmoz
 * @copyright Copyright (c) Mizmoz Limited 2016. All rights reserved.
 */

namespace Mizmoz\API\EmailCampaign;

use Mizmoz\API\Client;
use Mizmoz\API\CommandAbstract;

/**
 * Class Send
 * @package Mizmoz\API\EmailCampaign
 *
 * Example usages:
 *
 * // send using ids for each item
 * $send = new Send(1, 2, 3);
 *
 * // send using ids except for email
 * $send = new Send(1, 2, 'support@mizmoz.com');
 *
 * // send using ids except for email with extra details
 * $send = new Send(1, 2, ['emailAddress' => 'support@mizmoz.com', 'emailFirstname' => 'Support']);
 */
class Send extends CommandAbstract
{
    /**
     * @var int
     */
    private $emailCampaignId;

    /**
     * @var int
     */
    private $emailListId;

    /**
     * @var mixed
     */
    private $email;

    /**
     * @var array
     */
    private $variables = [];

    /**
     * Send constructor.
     * @param int $emailCampaignId
     * @param int $emailListId
     * @param mixed $email Can be either the emailId or the email address of the recipient
     * @param array $variables Set additional {{live.*}} variables for the campaign
     */
    public function __construct($emailCampaignId, $emailListId, $email, array $variables = [])
    {
        $this->emailCampaignId = $emailCampaignId;
        $this->emailListId = $emailListId;
        $this->email = $email;
        $this->variables = $variables;
    }

    /**
     * @inheritdoc
     */
    public function getRequestMethod()
    {
        return Client::METHOD_POST;
    }

    /**
     * @inheritdoc
     */
    public function getRequestUrl()
    {
        return 'email-campaign/' . $this->emailCampaignId . '/send';
    }

    /**
     * @inheritdoc
     */
    public function getRequestData()
    {
        return [
            'emailListId' => $this->emailListId,
            'emailId' => $this->email,
            'variables' => $this->variables
        ];
    }
}
