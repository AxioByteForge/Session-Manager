<?php

namespace Axio\Session\Traits;

/**
 * Trait SessionTrait
 *
 * A trait providing common session-related functionalities.
 *
 * @package Axio\Session\Traits
 */
trait SessionTrait
{
    /**
     * Validates a session key.
     *
     * Implement additional validation logic if required for session keys.
     *
     * @param string $key The session key to validate.
     *
     * @return bool Returns true if the key is considered valid; otherwise, false.
     */
    protected function validateKey(string $key): bool
    {
        return true;
    }
}
