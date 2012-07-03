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
namespace Nbml\ClassBuilder;

use \Nbml\Reflector\Variable;
use \Nbml\MetadataTag;
use \Nbml\Reflector\MetadataTagDefinition;
use \Nbml\Exception\MetadataTagNotExists;
use \Nbml\Reflector;

/**
 * @author: Sel <s@finalclass.net>
 * @date: 02.04.12
 * @time: 16:21
 */
class VariableBuilder
{

    /**
     * @var \Nbml\Reflector\Variable
     */
    private $reflection;

    /**
     * @var \Nbml\MetadataTag\MetadataTag[]
     */
    private $metadataTags = array();

    /**
     * @var string[]
     */
    private $allMetadataTagClasses = array();

    /**
     * @var string
     */
    private $className;

    private $classReflection;

    private $filePath;

    public function __construct(Variable $variableReflection, Reflector $classReflection, $filePath, $allMetadataTagClasses = array())
    {
        $this->reflection = $variableReflection;
        $this->filePath = $filePath;
        $this->allMetadataTagClasses = $allMetadataTagClasses;
        $this->classReflection = $classReflection;
        $this->className = $classReflection->getClassName();
        foreach ($this->reflection->getMetadataTags() as $tag) {
            $this->metadataTags[] = $this->createTagProcessor($tag);
        }
    }

    /**
     * @param \Nbml\Reflector\MetadataTagDefinition $tag
     * @return \Nbml\MetadataTag
     * @throws \Nbml\Exception\MetadataTagNotExists
     */
    private function createTagProcessor(MetadataTagDefinition $tag)
    {
        $processorClassName = @$this->allMetadataTagClasses[$tag->getTagName()];
        if (!$processorClassName || !class_exists($processorClassName)) {
            throw new MetadataTagNotExists('Tag ' . $tag->getTagName() . ' does not exists
			or cannot load class ' . $processorClassName);
        }
        return new $processorClassName($this->reflection, $tag, $this->classReflection);
    }

    public function getInitializationCode()
    {
        $tag = $this->getTagByHasFunction('hasInitializationCode');
        if (!$tag) {
            if ($this->reflection->isSimpleType()) {
                //@TODO initialization for simple types
                return '';
            } else {
                if ($this->getReflection()->getName() == 'this') {
                    return '';
                }
                return '$this->options[\'' . $this->reflection->getNameUnderscored() . '\']'
                        . ' = new ' . $this->reflection->getType()
                        . '(' . $this->reflection->getDefaultValue() . ');'
                        . PHP_EOL;
            }
        }

        $out = '';
        foreach ($this->metadataTags as $tag) {
            $out .= $tag->getInitializationCode();
        }
        return $out;
    }

    public function getGetter()
    {
        $tag = $this->getTagByHasFunction('hasGetter');
        if (!$tag) {
            return '';
        }
        return $tag->getGetterMethodDefinition();
    }

    public function getSetter()
    {
        $tag = $this->getTagByHasFunction('hasSetter');
        if (!$tag) {
            return '';
        }
        return $tag->getSetterMethodDefinition();
    }

    public function getGetterAndSetter()
    {
        $getterTag = $this->getTagByHasFunction('hasGetter');
        $setterTag = $this->getTagByHasFunction('hasSetter');

        if ($setterTag && $getterTag) {
            return $this->renderPhtml('getter_and_setter');
        } else if (!$setterTag && $getterTag) {
            return $this->renderPhtml('getter_no_setter');
        } else if ($setterTag && !$getterTag) {
            return $this->renderPhtml('setter_no_getter');
        } else {
            return '';
        }

    }

    public function getReflection()
    {
        return $this->reflection;
    }

    private function renderPhtml($file)
    {
        ob_start();
        include __DIR__ . DIRECTORY_SEPARATOR . $file . '.phtml';
        return ob_get_clean();
    }

    /**
     * @param $hasFunctionName string for example: hasInitializationCode
     * @return \Nbml\MetadataTag|null
     */
    private function getTagByHasFunction($hasFunctionName)
    {
        foreach ($this->metadataTags as $tag) {
            if ($tag->$hasFunctionName()) {
                return $tag;
            }
        }
        return null;
    }

    public function getBeforeRenderRetrieveCode()
    {
        $tag = $this->getTagByHasFunction('hasBeforeRenderRetrievalCode');
        if (!$tag) {
            if ($this->getReflection()->getName() == 'this') {
                return '';
            }

            return '$' . $this->reflection->getName() . ' = $this->options[\''
                    . $this->reflection->getNameUnderscored()
                    . '\'];' . PHP_EOL;
        }

        return $tag->getBeforeRenderRetrieveCode();
    }

    public function getClassName()
    {
        return $this->className;
    }

    public function getFilePath()
    {
        return $this->filePath;
    }

}
