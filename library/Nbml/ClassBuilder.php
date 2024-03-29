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

use \Nbml\ClassBuilder\VariableBuilder;

/**
 * Internal class
 *
 * @internal
 * @author: Sel <s@finalclass.net>
 * @date: 02.04.12
 * @time: 10:33
 */
class ClassBuilder
{

    /** @var \Nbml\Reflector */
    private $reflection;

    /**
     * @var \Nbml\ClassBuilder\VariableBuilder[]
     */
    private $variableBuilders = array();

    /** @var string[] */
    private $tagProcessors = array();

    /** @var string */
    private $filePath = '';

    public function __construct($filePath, Reflector $reflection, $tagProcessors = array())
    {
        $this->filePath = $filePath;
        $this->reflection = $reflection;
        $this->tagProcessors = $tagProcessors;
        foreach ($this->reflection->getVariables() as $var) {
            $this->variableBuilders[$var->getName()] =
                    new VariableBuilder(
                        $var,
                        $this->getReflection(),
                        $filePath,
                        $this->tagProcessors
                        );
        }

        $thisVar = $this->reflection->getThisVariable();
        $this->variableBuilders['this'] = new VariableBuilder(
            $thisVar,
            $this->getReflection(),
            $filePath,
            $this->tagProcessors
        );
    }

    public function build()
    {
        return $this->renderPhtml('class');
    }

    private function renderPhtml($file)
    {
        ob_start();
        include __DIR__
                . DIRECTORY_SEPARATOR . 'ClassBuilder'
                . DIRECTORY_SEPARATOR . $file . '.phtml';
        return ob_get_clean();
    }

    public function getNamespaceDeclaration()
    {
        $ns = $this->reflection->getNamespace();
        if ($ns) {
            return 'namespace ' . $this->reflection->getNamespace() . ';';
        }
        return '';
    }

    /**
     * @return \Nbml\Reflector
     */
    public function getReflection()
    {
        return $this->reflection;
    }

    /**
     * @return \Nbml\ClassBuilder\VariableBuilder[]
     */
    public function getVariableBuilders()
    {
        return $this->variableBuilders;
    }

    public function getFilePath()
    {
        return $this->filePath;
    }

}
