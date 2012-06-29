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
use \Nbml\Exception\WrongServerConfig;
use \Nbml\Server\Config;
use \Nbml\Collection;
use \Nbml\Server\BeanProvider;

/**
 * @author: Sel <s@finalclass.net>
 * @date: 09.04.12
 * @time: 11:13
 */
class Server
{

    /**
     * @var \Nbml\Server\Config
     */
    protected $config;

    private $url;

    private $params;

    /** @var \Nbml\Server\BeanProvider */
    protected $beanProvider;

    /** @var \Nbml\Server */
    static private $lastInstance = null;

    public function __construct($url = '/', $params = array())
    {
        $this->beanProvider = new BeanProvider();
        $this->beanProvider
                ->add(new \Nbml\Server\Bean(new \Nbml\Component\Application(), 'application'));
        self::$lastInstance = $this;
        $this->url = $url;
        $this->params = $params;
    }

    /**
     * @static
     * @return \Nbml\Server
     */
    static public function lastInstance()
    {
        return self::$lastInstance;
    }

    public function config($config = null)
    {
        if ($config) {
            if (is_array($config)) {
                $this->config = new Config($config);
            } else if ($config instanceof Config) {
                $this->config = $config;
            } else {
                throw new WrongServerConfig('Type of constructor parameter is wrong.
                        Please provide array or \Nbml\Server\Config instance');
            }
        }
        if (!$this->config) {
            $this->config = new Config();
            $this->initConfig($this->config);
        }
        return $this->config;
    }

    public function __toString()
    {
        try {
            $this->compile();
            $loader = new Loader();
            $loader->find($this->url);
            if ($loader->isStaticResource()) {
                return $loader->sendToClient();
            }
            $component = $loader->create();
            $app = $this->beanProvider()->find('\Nbml\Component\Application');
            //First let's render the body so that all the js and css files will be added to
            //Application instance
            $app->body((string)$component);
            //And finally render the app
            return (string)$app;
        } catch (Exception $e) {
            var_dump($e);
        }
        return '';

    }

    public function addBeanProvider(BeanProvider $beanProvider)
    {
        $this->beanProvider->merge($beanProvider);
        return $this;
    }

    public function beanProvider()
    {
        return $this->beanProvider;
    }

    private function compile()
    {
        $compiler = new Compiler();
        foreach ($this->config()->metadataTags() as $tag) {
            $compiler->addTagProcessor($tag);
        }
        $includePath = $this->config()->includePath();
        $cacheDir = $this->config()->cacheDir();
        foreach ($this->config()->namespaces() as $ns) {
            $compiler->compileDir($includePath, $cacheDir, $ns);
        }
    }

}
