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

namespace Mizmoz\API\EmailList\Email;

use Mizmoz\API\Client;
use Mizmoz\API\CommandAbstract;

class Create extends CommandAbstract
{
    /**
     * @var int
     */
    private $emailListId;

    /**
     * @var string
     */
    private $email;

    /**
     * @var string
     */
    private $firstName;

    /**
     * @var array
     */
    private $data = [];

    /**
     * @var array
     */
    private $meta = [];

    /**
     * Send constructor.
     * @param int $emailListId
     * @param string $email
     * @param string $firstName
     */
    public function __construct($emailListId, $email, $firstName = '')
    {
        $this->emailListId = $emailListId;
        $this->email = $email;
        $this->firstName = $firstName;
    }

    /**
     * Set the contact title
     *
     * @param $title
     * @return $this
     */
    public function setTitle($title)
    {
        $this->data['emailTitle'] = $title;
        return $this;
    }

    /**
     * Set the contacts las name
     *
     * @param string $lastName
     * @return $this
     */
    public function setLastName($lastName)
    {
        $this->data['emailLastname'] = $lastName;
        return $this;
    }

    /**
     * Set the created date for the contact
     *
     * @param \DateTime $created
     * @return $this
     */
    public function setCreated(\DateTime $created)
    {
        $this->data['emailCreated'] = $created->format('Y-m-d H:i:s');
        return $this;
    }

    /**
     * Set the contact source
     *
     * @param string $source
     * @return $this
     */
    public function setSource($source)
    {
        $this->meta['source'] = $source;
        return $this;
    }

    /**
     * Set additional data for the contact record. Make sure to have setup the additional fields for the email
     * list before sending over extra data otherwise it won't get stored.
     *
     * @param $name
     * @param $value
     * @return $this
     */
    public function setMeta($name, $value)
    {
        $this->meta[$name] = $value;
        return $this;
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
        return 'email-list/' . $this->emailListId . '/email';
    }

    /**
     * @inheritdoc
     */
    public function getRequestData()
    {
        return array_merge([
            'emailAddress' => $this->email,
            'emailFirstname' => $this->firstName,
        ], $this->data, ['meta' => $this->meta]);
    }
}
