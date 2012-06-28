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
namespace Nbml\MetadataTag\OnDemandMetadataTag;
/**
 * @author: Sel <s@finalclass.net>
 * @date: 28.06.12
 * @time: 01:02
 */
class OnDemandFactory
{

    private $className = '';
    private $constructorArgument = '';
    private $instance = null;

    public function __construct($className, $constructorArgument = '')
    {
        $this->className = $className;
        $this->constructorArgument = $constructorArgument;
    }

    private function getInstance()
    {
        if (!$this->instance) {
            $class = $this->className;
            $this->instance = new $class($this->constructorArgument);
        }
        return $this->instance;
    }

    public function __toString()
    {
        return (string)$this->getInstance();
    }

    public function __call($name, $arguments)
    {
        return call_user_func_array(array($this->getInstance(), $name), $arguments);
    }

    public function __get($name)
    {
        return $this->getInstance()->$name;
    }

    public function __set($name, $value)
    {
        $this->getInstance()->$name = $value;
    }

    public function __invoke()
    {
        /** @var $instance callback */
        $instance = $this->getInstance();
        if(is_callable($instance)) {
            return $instance();
        }
        return null;
    }


}
