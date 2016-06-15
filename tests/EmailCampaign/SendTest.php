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

namespace Mizmoz\API\Tests\EmailCampaign;

use Mizmoz\API\Client;
use Mizmoz\API\EmailCampaign\Send;
use Mizmoz\API\Tests\TestCase;

class SendTest extends TestCase
{
    private $emailCampaignId = 123;
    private $emailListId = 234;
    private $emailId = 345;
    private $email = 'support@mizmoz.com';

    private $variables = [
        'name' => 'Bob',
    ];

    /**
     * Test basic setup
     */
    public function testSetup()
    {
        $send = new Send($this->emailCampaignId, $this->emailListId, $this->emailId);

        // check HTTP method
        $this->assertSame('POST', $send->getRequestMethod());

        // check url
        $this->assertSame(
            'email-campaign/' . $this->emailCampaignId . '/send',
            $send->getRequestUrl()
        );
    }

    /**
     * Send using just ids for the params
     */
    public function testIdBasedSendCreation()
    {
        $send = new Send($this->emailCampaignId, $this->emailListId, $this->emailId);

        // check payload
        $this->assertSame([
            'emailListId' => $this->emailListId,
            'emailId' => $this->emailId,
            'variables' => []
        ], $send->getRequestData());
    }

    /**
     * Send using email address
     */
    public function testEmailBasedSendCreation()
    {
        $send = new Send($this->emailCampaignId, $this->emailListId, $this->email);

        // check payload
        $this->assertSame([
            'emailListId' => $this->emailListId,
            'emailId' => $this->email,
            'variables' => []
        ], $send->getRequestData());
    }

    /**
     * Send using email address and extra details
     */
    public function testEmailAndExtraDataBasedSendCreation()
    {
        $data = [
            'emailAddress' => $this->email,
            'emailFirstname' => 'Dave',
        ];

        $send = new Send($this->emailCampaignId, $this->emailListId, $data);

        // check payload
        $this->assertSame([
            'emailListId' => $this->emailListId,
            'emailId' => $data,
            'variables' => []
        ], $send->getRequestData());
    }

    /**
     * Send using email id and extra variables
     */
    public function testEmailWithExtraVariables()
    {
        $send = new Send($this->emailCampaignId, $this->emailListId, $this->emailId, $this->variables);

        // check payload
        $this->assertSame([
            'emailListId' => $this->emailListId,
            'emailId' => $this->emailId,
            'variables' => $this->variables
        ], $send->getRequestData());
    }
}
