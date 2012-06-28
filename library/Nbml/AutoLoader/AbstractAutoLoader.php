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

namespace Nbml\AutoLoader;

/**
 * @author: Sel <s@finalclass.net>
 * @date: 30.03.12
 * @time: 10:56
 */
abstract class AbstractAutoLoader
{

	private $paths = array();

    /**
     * @param $path
     * @return \Nbml\AutoLoader\AbstractAutoLoader
     */
	public function addIncludePath($path)
	{
        $path = str_replace(array('/', '\\'), DIRECTORY_SEPARATOR, $path);
		$this->paths[$path] = true;
		return $this;
	}

	/**
	 * @param $path
	 * @return AbstractAutoLoader
	 */
	public function removeIncludePath($path)
	{
		unset($this->paths[$path]);
		return $this;
	}

	/**
	 * @return array
	 */
	public function getIncludePaths()
	{
		return $this->paths;
	}

	/**
	 * @return AbstractAutoLoader
	 */
	public function register()
	{
		\spl_autoload_register(array($this, 'autoload'));
		return $this;
	}

	/**
	 * @return AbstractAutoLoader
	 */
	public function unregister()
	{
		\spl_autoload_unregister(array($this, 'autoload'));
		return $this;
	}

	/**
	 * @abstract
	 * @param $className
	 * @return boolean
	 */
	abstract public function autoload($className);

}
