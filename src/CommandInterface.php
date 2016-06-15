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

namespace Mizmoz\API;

interface CommandInterface
{
    /**
     * Get the HTTP method type for the request
     *
     * @return string
     */
    public function getRequestMethod();

    /**
     * Get the request content type
     *
     * @return string
     */
    public function getContentType();

    /**
     * Get the API url to be called
     *
     * @return string
     */
    public function getRequestUrl();

    /**
     * Get the request data
     *
     * @return array
     */
    public function getRequestData();

    /**
     * Get the request data as a JSON string
     *
     * @return string
     */
    public function getRequestJson();
}
