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

use \Nbml\Reflector\Variable;


/**
 * @author: Sel <s@finalclass.net>
 * @date: 30.03.12
 * @time: 14:40
 */
class Reflector
{

    /**
     * @var string
     */
    private $namespace = '';

	/**
	 * @var string
	 */
	private $className = '';

	/**
	 * The type of parent class
	 * @var string
	 */
	private $context = '\NetCore\Configurable\OptionsAbstract';

	/**
	 * Variable definitions
	 *
	 * @var Variable[]
	 */
	private $variables = array();

	/**
	 * Text content if reflected file
	 *
	 * @var string
	 */
	private $content = '';

	/**
	 * All PHPDoc text found in $content
	 *
	 * @var string
	 */
	private $definitionContent = '';

	public function __construct($viewClassName, $viewTextContent)
	{
        $classNameExploded = explode('\\', $viewClassName);
        $this->className = array_pop($classNameExploded);
        $this->namespace = ltrim(join('\\', $classNameExploded), '\\');
		$this->content = $viewTextContent;
		$this->initDefinitionContent();
		$this->initContext();
		$this->initVariables();
	}

	private function initContext()
	{
		$matches = array();
		preg_match_all('#\@var\s*\$this\s*(.*)#', $this->definitionContent, $matches);
		if(isset($matches[1]) && isset($matches[1][0])) {
			$this->context = $matches[1][0];
		}
	}

	private function initDefinitionContent()
	{
		$matches = array();
	    preg_match_all('#/\*\*(.*)\*/#msU', $this->content, $matches);

	    if (!empty($matches[1])) {
		    $lines = explode(PHP_EOL, $matches[1][0]);
		    $strippedLines = array();
		    foreach($lines as $line) {
			    $line = ltrim($line, " \n\t\r\0\x0B*");
			    if(!empty($line)) {
				    $strippedLines[] = $line;
			    }
		    }

	        $this->definitionContent = join(PHP_EOL, $strippedLines );
	    }
	}

	private function initVariables()
	{
		$lines = explode(PHP_EOL, $this->definitionContent);
		$buffer = array();
		foreach($lines as $line) {
			$buffer[] = $line;

			if(preg_match('#\@var\s*\$this#', $line)) {
				//if found string like that: "@var $this"
				$buffer = array();
				continue;
			}

			if(preg_match('#\@var\s*\$#', $line)) {
				//if found string like that: "@var $varName"
				$this->variables[] = new Variable(join(PHP_EOL, $buffer));
				$buffer = array();
			}
		}
	}

	public function getContext()
	{
		return $this->context;
	}

	public function getClassName()
	{
		return $this->className;
	}


	/**
	 * @return \Nbml\ViewReflection\Variable[]
	 */
	public function getVariables()
	{
		return $this->variables;
	}

    public function getNamespace()
    {
        return $this->namespace;
    }

    /**
     * Returns class name with namespace
     * @return string
     */
    public function getFullClassName()
    {
        return '\\' . ltrim('\\' . $this->namespace . '\\' . $this->className, '\\');
    }

    public function getContent()
    {
        return $this->content;
    }

}
