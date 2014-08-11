<?php
/**
 * AttwFramework
 *
 * @author Gabriel Jacinto <gamjj74@hotmail.com>
 * @license MIT License
 * @link http://attwframework.github.io
*/

namespace Attw\DB\SQL\MySQL\Operator;

use Attw\DB\SQL\AbstractOperatorThatAcceptArray;
use \LogicException;

class OrOperator extends AbstractOperatorThatAcceptArray
{
    const OPERATOR = 'OR';
    protected $operator = 'OR';
}