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

use \Nbml\AutoLoader\AbstractAutoLoader;
use \Nbml\Compiler;
use \Nbml\AutoLoader\Exception\NoViewCompilerSpecified;

require_once __DIR__ . '/AbstractAutoLoader.php';

/**
 * @author: Sel <s@finalclass.net>
 * @date: 30.03.12
 * @time: 10:55
 */
class ViewAutoLoader extends AbstractAutoLoader
{

	/** @var \Nbml\Compiler */
	private $viewCompiler;

    private $alwaysCompile = false;

    private $compilerDefaultDestinationDir = '';

	public function autoload($className)
	{
		$classNameDirNotation = str_replace(array('\\', '_'), DIRECTORY_SEPARATOR, $className);
        $classNameExploded = explode('\\', $className);
        $classShortName = end($classNameExploded);
        $defaultDestinationDir = $this->getCompilerDefaultDestinationDir();
        $defaultDestinationDir = str_replace(array('\\', '/'), DIRECTORY_SEPARATOR, $defaultDestinationDir);
		foreach ($this->getIncludePaths() as $dir => $bool) {
            $dir = str_replace(array('\\', '/'), DIRECTORY_SEPARATOR, $dir);
			$noExtensionPath = $dir . DIRECTORY_SEPARATOR . $classNameDirNotation;
            $noExtensionPathCompiled = $defaultDestinationDir
                    ? $defaultDestinationDir . DIRECTORY_SEPARATOR . $classNameDirNotation
                    : $noExtensionPath;

            if(is_dir($noExtensionPath)) {
                $viewPath = $noExtensionPath . DIRECTORY_SEPARATOR . $classShortName . '.nbml';
            } else {
                $viewPath = $noExtensionPath . '.nbml';
            }
            $compiledPath = $noExtensionPathCompiled . DIRECTORY_SEPARATOR . $classShortName . '.php';

			$lastViewModification = @filemtime($viewPath); //false is return if file does not exists
			$lastCompiledModification = @filemtime($compiledPath); //false is return if file does not exists

			if (!$this->alwaysCompile && $lastCompiledModification > $lastViewModification) {
				//here is hidden condition: this will only occure if compiled file exists
				require_once $compiledPath;
				return true;
			}

			if ($lastViewModification !== false) { //this means: if view file exists
				$this->compile($className, $viewPath, $compiledPath);
				require_once $compiledPath;
				return true;
			}
		}
		return false;
	}

	/**
	 * @param \Nbml\Compiler $value
	 * @return \Nbml\AutoLoader\ViewAutoLoader
	 */
	public function setViewCompiler(Compiler $value)
	{
	    $this->viewCompiler = $value;
	    return $this;
	}

	/**
	 * @return \Nbml\Compiler
	 */
	public function getViewCompiler()
	{
	    return $this->viewCompiler;
	}

	private function compile($className, $inFilePath, $outFilePath)
	{
		$viewCompiler = $this->getViewCompiler();
		if(!$viewCompiler) {
            require_once 'Exception/NoViewCompilerSpecified.php';
			throw new NoViewCompilerSpecified('No view compiler specified! ' . $className);
		}
		$viewClassContent = $viewCompiler->compile($className, $inFilePath);
		$dir = dirname($outFilePath);
		$out = @mkdir($dir, 0777, true);
		file_put_contents($outFilePath, $viewClassContent);
	}

    /**
     * @param boolean $value
     * @return \Nbml\AutoLoader\ViewAutoLoader
     */
    public function setAlwaysCompile($value)
    {
        $this->alwaysCompile = (boolean)$value;
        return $this;
    }

    /**
     * @return boolean
     */
    public function getAlwaysCompile()
    {
        return (boolean)$this->alwaysCompile;
    }

    /**
     * @param string $value
     * @return \Nbml\AutoLoader\ViewAutoLoader
     */
    public function setCompilerDefaultDestinationDir($value)
    {
        if($this->compilerDefaultDestinationDir) {
            $this->removeIncludePath($this->compilerDefaultDestinationDir);
        }
        $this->compilerDefaultDestinationDir = (string)$value;
        $this->addIncludePath($this->compilerDefaultDestinationDir);
        return $this;
    }

    /**
     * @return string
     */
    public function getCompilerDefaultDestinationDir()
    {
        return (string)@$this->compilerDefaultDestinationDir;
    }
}
