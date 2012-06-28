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
namespace Nbml\Server;
use \Nbml\Server\Bean;
use \Nbml\Exception\BeanNotFound;
/**
 * @author: Sel <s@finalclass.net>
 * @date: 10.04.12
 * @time: 14:25
 */
class BeanProvider
{

    protected $beans = array();
    protected $beansByType = array();
    protected $beansByName = array();

    public function add(Bean $bean)
    {
        $this->beans[] = $bean;
        $this->beansByName[$bean->name()] = $bean;
        $type = '\\' . ltrim(get_class($bean->source()), '\\');
        $this->beansByType[$type] = $bean;
        return $this;
    }

    public function fromArray($beans)
    {
        foreach($beans as $bean) {
            $this->add($bean);
        }
    }

    public function toArray()
    {
        return $this->beans;
    }

    public function merge($beans)
    {
        $beans = $beans instanceof BeanProvider ? $beans->toArray() : $beans;
        foreach($beans as $bean) {
            $this->add($bean);
        }
        return $this;
    }

    public function find($type, $name = null)
    {
        $bean = @$this->beansByName[@(string)$name];
        if(!$bean) {
            $bean = @$this->beansByType[$type];
        }

        if(!$bean) {
            throw new BeanNotFound('Bean ' . $name . ' ' . $type . ' not found');
        }
        return $bean->source();
    }

}
