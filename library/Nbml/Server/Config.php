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
use \Nbml\Collection;

/**
 * @author: Sel <s@finalclass.net>
 * @date: 09.04.12
 * @time: 11:22
 */
class Config
{

    /**
     * @var string
     */
    private $cacheDir;

    /**
     * @var string
     */
    private $includePath;

    /**
     * @var \Nbml\Collection
     */
    private $namespaces;

    /**
     * @var \Nbml\Collection
     */
    private $metadataTags = array();

    public function __construct($options = array())
    {
        foreach ($options as $key => $val) {
            $this->$key($val);
        }
    }


    /**
     * @param null $dir
     * @return \Nbml\Server\Config|string
     */
    public function cacheDir($dir = null)
    {
        if ($dir) {
            $this->cacheDir = $this->toPath($dir);
            return $this;
        }
        return $this->cacheDir;
    }

    private function toPath($string)
    {
        return str_replace(array('\\', '/'), DIRECTORY_SEPARATOR, $string);
    }

    /**
     * @param null $dir
     * @return \Nbml\Server\Config|string
     */
    public function includePath($dir = null)
    {
        if ($dir) {
            $this->includePath = $this->toPath($dir);
            return $this;
        }
        return $this->includePath;
    }

    /**
     * @param null $ns
     * @return \Nbml\Collection|\Nbml\Server\Config
     */
    public function namespaces($ns = null)
    {
        if (is_array($ns)) {
            $this->namespaces = new Collection($ns);
            return $this;
        }
        if (!isset($this->namespaces)) {
            $this->namespaces = new Collection();
        }
        return $this->namespaces;
    }

    public function metadataTags()
    {
        if (!$this->metadataTags) {
            $this->metadataTags = new Collection();
        }
        return $this->metadataTags;
    }

}
