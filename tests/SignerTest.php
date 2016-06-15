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

namespace Mizmoz\API\Tests;

use Mizmoz\API\EmailList\Email\Create;
use Mizmoz\API\Signer;

class SignerTest extends TestCase
{
    private $timestamp = 1395878400;
    private $authKey = 'xzy';

    private $emailListId = 234;
    private $email = 'support@mizmoz.com';

    /**
     * Test the param normalisation
     */
    public function testNormaliser()
    {
        // test sorting & normalisation
        $params = Signer::normaliseParams([
            'a' => 1,
            'c' => 3,
            'd' => [
                'e' => 5,
                'a' => 1,
                'b' => 2
            ],
            'b' => 2
        ]);

        $this->assertSame([
            'a' => 1,
            'b' => 2,
            'c' => 3,
            'd' => [
                'a' => 1,
                'b' => 2,
                'e' => 5
            ]
        ], $params);

        // test again with different data
        $params = Signer::normaliseParams([
            'a' => 1,
            'c' => 3,
            'd' => [
                'e' => 5,
                'a' => 1,
                'b' => [
                    'a' => 1,
                    'b' => 2
                ]
            ],
            'b' => 2
        ]);

        $this->assertSame([
            'a' => 1,
            'b' => 2,
            'c' => 3,
            'd' => [
                'a' => 1,
                'b' => [
                    'a' => 1,
                    'b' => 2
                ],
                'e' => 5
            ]
        ], $params);
    }

    /**
     * Test email creation
     */
    public function testSigning()
    {
        $create = new Create($this->emailListId, $this->email);

        $this->assertSame(
            '147b861878241cd0040fa9297c3db54e03b93382:' . $this->timestamp,
            Signer::sign($create, $this->authKey, $this->timestamp)
        );
    }

    /**
     * Test the checking works
     */
    public function testCheck()
    {
        $create = new Create($this->emailListId, $this->email);

        $this->assertTrue(
            Signer::check(
                '147b861878241cd0040fa9297c3db54e03b93382:' . $this->timestamp,
                $this->authKey,
                $create->getRequestUrl(),
                $create->getRequestData()
            )
        );
    }
}
