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

class Signer
{
    /**
     * Create the signature from the command
     *
     * @param CommandInterface $command
     * @param string $authKey
     * @param int $timestamp Unix timestamp
     * @return string
     */
    public static function sign(CommandInterface $command, $authKey, $timestamp = null)
    {
        return static::createSignature(
            $authKey,
            $command->getRequestUrl(),
            $command->getRequestData(),
            $timestamp
        );
    }

    /**
     * Check the signature
     *
     * @param string $signature
     * @param string $authKey
     * @param string $url
     * @param array $params
     * @return bool
     */
    public static function check($signature, $authKey, $url, array $params = [])
    {
        $timestamp = explode(':', $signature)[1];

        return ($signature === static::createSignature(
            $authKey,
            $url,
            $params,
            $timestamp
        ));
    }

    /**
     * Create the signature
     *
     * @param string $authKey
     * @param string $url
     * @param array $params
     * @param null $timestamp
     * @return string
     */
    public static function createSignature($authKey, $url, array $params = [], $timestamp = null)
    {
        $token = http_build_query([
            'url' => $url,
            'data' => static::normaliseParams($params),
        ]);

        $timestamp = ($timestamp ? $timestamp : time());

        return sha1($token . $timestamp . $authKey) . ':' . $timestamp;
    }

    /**
     * Normalise the params
     *
     * @param array $params
     * @return array
     */
    public static function normaliseParams(array $params)
    {
        $sorted = [];
        ksort($params);

        foreach ($params as $key => $value) {
            if (is_array($value)) {
                $value = static::normaliseParams($value);
            }

            $sorted[$key] = $value;
        }

        return $sorted;
    }
}
