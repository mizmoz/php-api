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

namespace Mizmoz\API\Tests\EmailList\Email;

use Mizmoz\API\Client;
use Mizmoz\API\EmailList\Email\Create;
use Mizmoz\API\Tests\TestCase;

class CreateTest extends TestCase
{
    private $emailListId = 234;
    private $email = 'support@mizmoz.com';

    /**
     * Test email creation
     */
    public function testSetup()
    {
        $create = new Create($this->emailListId, $this->email);

        // check HTTP method
        $this->assertSame('POST', $create->getRequestMethod());

        // check url
        $this->assertSame(
            'email-list/' . $this->emailListId . '/email',
            $create->getRequestUrl()
        );
    }
}
