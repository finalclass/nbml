<?php

namespace Nbml\Exception;

use \Nbml\Exception as NbmlException;

/**
 * Author: Sel <s@finalclass.net>
 * Date: 27.11.11
 * Time: 15:44
 */
class NotAllowed extends \BadMethodCallException implements NbmlException
{

    public function __construct ($message = 'user is not allowed to create this class'
        , $code = 0, $previous = null)
    {
        parent::__construct($message, $code, $previous);
    }

}
