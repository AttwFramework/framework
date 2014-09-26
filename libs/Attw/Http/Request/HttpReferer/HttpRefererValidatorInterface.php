<?php
/**
 * AttwFramework
 *
 * @author Gabriel Jacinto <gamjj74@hotmail.com>
 * @license MIT License
 * @link http://attwframework.github.io
*/

namespace Attw\Http\Request\HttpReferer;

use Attw\Http\Request;

interface HttpRefererValidatorInterface
{
    /**
     * Validates the current HTTP referer
     *
     * @param \Attw\Http\Request $request
    */
    public function validate(Request $request);
}