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
namespace Nbml;
/**
 * @author: Sel <s@finalclass.net>
 * @date: 09.04.12
 * @time: 11:42
 */
class Collection implements \IteratorAggregate, \Countable
{
    private $data;
    private $length;

    public function __construct($source = array())
    {
        $this->data = $source;
        $this->length = count($source);
    }

    public function add($item, $position = null)
    {
        if ($position === null) {
            $this->data[$position] = $item;
        } else {
            $this->data[] = $item;
        }
        $this->length++;
        return $this;
    }

    public function indexOf($item)
    {
        foreach ($this->data as $key => $val) {
            if ($val == $item) {
                return $val;
            }
        }
        return null;
    }

    public function remove($item)
    {
        $index = $this->indexOf($item);
        if($index !== null) {
            $this->removeItemAt($index);
        }
        return $this;
    }

    public function removeItemAt($index)
    {
        if(isset($this->data[$index])) {
            unset($this->data[$index]);
            $this->length--;
        }
        return $this;
    }

    public function toArray()
    {
        return $this->data;
    }

    public function getIterator()
    {
        return new \ArrayIterator($this->data);
    }

    public function count()
    {
        return $this->length;
    }
}
