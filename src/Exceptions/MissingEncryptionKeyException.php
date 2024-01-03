<?php

namespace Axio\Session\Exceptions;

use Exception;

class MissingEncryptionKeyException extends Exception {
    public function __construct($message = 'Encryption key not set for session handling', $code = 0, Exception $previous = null) {
        parent::__construct($message, $code, $previous);
    }
}

?>
