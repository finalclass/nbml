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

use \Nbml\Exception\ReadViewFileException;
use \Nbml\Reflector;
use \Nbml\ClassBuilder;

/**
 * Facade
 *
 * @author: Sel <s@finalclass.net>
 * @date: 30.03.12
 * @time: 12:32
 */
class Compiler
{

  /**
   * Hash of MetadataTag class names. Keys are the tag names
   *
   * @var string[]
   */
  private $tagProcessors = array();

  /**
   * @param $className
   * @param $filePath
   * @return string
   * @throws \Nbml\Exception\ReadViewFileException
   */
  public function compile($className, $filePath)
  {
    $reflection = $this->reflectClass($className, $filePath);

    $builder = new ClassBuilder($filePath, $reflection, $this->tagProcessors);
    return $builder->build();
  }

  public function reflectClass($className, $filePath)
  {
    $content = @file_get_contents($filePath);
    if ($content === false) {
      throw new ReadViewFileException('File ' . $filePath . ' does not exists ' . $filePath);
    }
    return new Reflector($className, $content);
  }

  public function compileDir($inputDir, $outputDir, $ns)
  {
    $files = $this->findNbmlFiles($inputDir, $ns);
    foreach ($files as $className => $filePath) {
      $classContent = $this->compile($className, $filePath);
      $this->saveClass($outputDir, $className, $classContent);
    }
    return $this;
  }

  private function findNbmlFiles($includePath, $ns)
  {
    $files = array();
    $includePathLength = strlen($includePath);
    $dirPath = $includePath
        . str_replace(array('\\', '/'), DIRECTORY_SEPARATOR, $ns)
        . DIRECTORY_SEPARATOR;

    $dirIterator = new \RecursiveDirectoryIterator($dirPath);
    $iterator = new \RecursiveIteratorIterator($dirIterator);
    $regexIterator = new \RegexIterator($iterator, '/^.+\.nbml$/i',
      \RecursiveRegexIterator::GET_MATCH);

    foreach ($regexIterator as $match) {
      $path = $match[0];
      $className = $this->pathToClassName($path, $includePathLength);
      $files[$className] = $path;
    }
    return $files;
  }

  private function pathToClassName($path, $offset)
  {
    $className = substr($path, $offset, strlen($path) - $offset - 5);
    $className = str_replace(
      array(DIRECTORY_SEPARATOR, '/', '\\'), '\\', $className);
    $classNameExploded = array_values(array_filter(explode('\\', $className)));
    $count = count($classNameExploded);

    if (!isset($classNameExploded[$count - 1]) || !isset($classNameExploded[$count - 2])) {
      return $className;
    }

    $lastElement = $classNameExploded[$count - 1];
    $beforeLastElement = $classNameExploded[$count - 2];
    if ($lastElement == $beforeLastElement) {
      unset($classNameExploded[$count - 1]);
    }
    return '\\' . join('\\', $classNameExploded);
  }

  private function saveClass($outputDir, $fullClassName, $classTextContent)
  {
    $fullClassNameExploded = explode('\\', $fullClassName);
    $className = end($fullClassNameExploded);
    $classNameDirNotation = str_replace('\\', DIRECTORY_SEPARATOR, $fullClassName);
    $dir = $outputDir
        . DIRECTORY_SEPARATOR
        . $classNameDirNotation;

    $filePath = $dir . DIRECTORY_SEPARATOR . $className . '.php';
    @mkdir($dir, 0777, true);
    return file_put_contents($filePath, $classTextContent);
  }

  public function addTagProcessor($className)
  {
    $tagName = call_user_func(array($className, 'getMetadataTagName'));
    $this->tagProcessors[$tagName] = $className;
    return $this;
  }

}
