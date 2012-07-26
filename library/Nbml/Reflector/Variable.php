<?php
/**

Copyright (C) Szymon Wygnanski (s@finalclass.net)

Permission is hereby granted, free of charge, to any person obtaining a copy of
this software and associated documentation files (the "Software"), to deal in
the Software without restriction, including without limitation the rights to
use, copy, modify, merge, publish, distribute, sublicense, and/or sell copies
of the Software, and to permit persons to whom the Software is furnished to do
so, subject to the following conditions:

The above copyright notice and this permission notice shall be included in all
copies or substantial portions of the Software.

THE SOFTWARE IS PROVIDED "AS IS", WITHOUT WARRANTY OF ANY KIND, EXPRESS OR
IMPLIED, INCLUDING BUT NOT LIMITED TO THE WARRANTIES OF MERCHANTABILITY,
FITNESS FOR A PARTICULAR PURPOSE AND NONINFRINGEMENT. IN NO EVENT SHALL THE
AUTHORS OR COPYRIGHT HOLDERS BE LIABLE FOR ANY CLAIM, DAMAGES OR OTHER
LIABILITY, WHETHER IN AN ACTION OF CONTRACT, TORT OR OTHERWISE, ARISING FROM,
OUT OF OR IN CONNECTION WITH THE SOFTWARE OR THE USE OR OTHER DEALINGS IN THE
SOFTWARE.
 */
namespace Nbml\Reflector;
use \Nbml\Reflector\MetadataTagDefinition;

/**
 * @author: Sel <s@finalclass.net>
 * @date: 30.03.12
 * @time: 14:45
 */
class Variable
{

    static public $SIMPLE_TYPES = array(
        'string', 'int', 'integer',
        'boolean', 'array', 'object',
        'float', 'double', 'number',
        'null', 'mixed', 'resource',
        'callback');

    private $name;
    private $type;
    private $defaultValue;
    private $metadataTags = array();

    private $definitionString;
    private $definitionStringLength;

    public function __construct($stringDefinition)
    {
        $this->definitionString = $stringDefinition;
        $this->definitionStringLength = strlen($stringDefinition);
        $this->parseDefinition();
    }

    private function parseDefinition()
    {
        for ($i = 0; $i < $this->definitionStringLength; $i++) {
            $char = $this->definitionString[$i];
            if ($char == '[') {
                $i = $this->readTagDefinition($i);
                continue;
            }
            if ($char == '@') {
                $i = $this->readVarDeclaration($i);
                continue;
            }
        }
    }

    private function readVarDeclaration($pos)
    {
        $buffer = array();
        $varName = '';
        $type = '';
        $default = '';

        $readingVarName = false;
        $readingType = false;
        $readingDefault = false;
        $varNameRead = false;

        for ($i = $pos; $i < $this->definitionStringLength; $i++) {
            $char = $this->definitionString[$i];

            if ($char == '$') {
                $readingVarName = true;
                $readingType = false;
                $readingDefault = false;
                continue;
            }

            if ($char == '(') {
                $readingDefault = true;
                $readingType = false;
                $readingVarName = false;
            }

            if ($varNameRead && !$readingDefault) {
                $readingType = true;
                $readingDefault = false;
                $readingVarName = false;
            }

            if ($char == "\n" || $char == "\n\r" || $char == "\r") {
                break;
            }

            if ($readingVarName) {
                if ($char == ' ') {
                    $varNameRead = true;
                    $readingVarName = false;
                    continue;
                }
                $varName .= $char;
            }

            if ($readingType) {
                $type .= $char;
            }

            if ($readingDefault) {
                $default .= $char;
            }
        }

        //Filter default value:
        $default = trim($default);
        $defLength = strlen($default);
        if ($defLength > 1) {
            if (@$default[0] == '(' && @$default[$defLength - 1] == ')') {
                $default = substr($default, 1, $defLength - 2);
            }
            $this->defaultValue = $default;
        }

        //Assign to object properties:
        $this->name = $varName;
        $this->type = $type;
        return $pos;
    }

    private function readTagDefinition($pos)
    {
        $tagName = '';
        $propertiesString = '';
        $defaultProperty = '';
        $properties = array();
        $buffer = array();
        for ($i = $pos; $i < $this->definitionStringLength; $i++) {
            $char = $this->definitionString[$i];

            if ($char == '(' || $char == ']') {
                $tagName = join('', $buffer);
                $buffer = array();
                if ($char == ']') {
                    break;
                } else {
                    continue;
                }
            }

            if ($char == ')') {
                $propertiesString = join('', $buffer);
                $buffer = array();
                break;
            }

            $buffer[] = $char;

        }

        $tagName = trim($tagName, " \n\t\r\0\x0B[]");

        //Now the properties

        if (strpos($propertiesString, '=') === false) {
            $defaultProperty = trim($propertiesString, " \n\t\r\0\x0B\"'");
        } else {
            $keyValPairs = explode(',', $propertiesString);
            foreach ($keyValPairs as $keyValPair) {
                list($key, $val) = explode('=', $keyValPair);
                $properties[$key] = trim($val, " \n\t\r\0\x0B\"'");
            }
        }

        $tagDefinition = new MetadataTagDefinition($tagName, $properties, $defaultProperty);
        $this->metadataTags[] = $tagDefinition;
        return $i;
    }

    public function getDefaultValue()
    {
        if($this->getType() == 'array') {
            if (!$this->defaultValue) {
                $this->defaultValue = '';
            }
            return 'array(' . $this->defaultValue . ')';
        }

        return $this->defaultValue;
    }

    /**
     * @return \Nbml\Reflector\MetadataTagDefinition
     */
    public function getMetadataTags()
    {
        return $this->metadataTags;
    }

    public function getName()
    {
        return $this->name;
    }

    public function getNameUnderscored()
    {
        return strtolower(preg_replace('/([a-z])([A-Z])/', '$1_$2', $this->name));
    }

    public function getType()
    {
        return $this->type;
    }

    public function isSimpleType()
    {
        return array_search($this->type, self::$SIMPLE_TYPES) !== false;
    }
}
