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
namespace Nbml\Component;
use \Nbml\Component;

/**
 * @author: Sel <s@finalclass.net>
 * @date: 10.04.12
 * @time: 13:00
 */
class Application extends Component
{

    /**
     * @var Application
     */
    static protected $instance = null;

    public function __construct()
    {
        static::$instance = $this;
    }

    /**
     * @static
     * @return Application
     */
    static public function getInstance()
    {
        if (!static::$instance) {
            $class = get_called_class();
            static::$instance = new $class();
        }
        return static::$instance;
    }

    public function body($value = null)
    {
        if ($value) {
            $this->options['body'] = $value;
            return $this;
        }
        if (!isset($this->options['body'])) {
            return '';
        }
        return $this->options['body'];
    }

    public function title($value = null)
    {
        if ($value) {
            $this->options['title'] = (string)$value;
            return $this;
        }
        return @(string)$this->options['title'];
    }

    public function scripts($value = null)
    {
        if ($value) {
            $this->options['scripts'] = $value;
            return $this;
        }
        if (!isset($this->options['scripts'])) {
            $this->options['scripts'] = new \Nbml\Collection();
        }
        return $this->options['scripts'];
    }

    /**
     * @param null $value
     * @return Application|\Nbml\Collection
     */
    public function styleSheets($value = null)
    {
        if ($value) {
            $this->options['style_sheets'] = $value;
            return $this;
        }
        if (!isset($this->options['style_sheets'])) {
            $this->options['style_sheets'] = new \Nbml\Collection();
        }
        return $this->options['style_sheets'];
    }

    public function charset($value = null)
    {
        if ($value) {
            $this->options['charset'] = $value;
            return $this;
        }
        if (!isset($this->options['charset'])) {
            $this->options['charset'] = 'utf-8';
        }
        return @(string)$this->options['charset'];
    }

    public function __toString()
    {
        ob_start();
        ?>
    <!DOCTYPE>
    <html>
    <head>
        <title><?php echo $this->title(); ?></title>
        <meta charset="<?php echo $this->charset(); ?>"/>
        <META http-equiv="Content-Type" content="text/html; charset=<?php echo $this->charset(); ?>">
        <?php foreach ($this->scripts() as $script): ?>
        <script type="text/javascript" src="<?php echo $script; ?>"></script>
        <?php endforeach; ?>
        <?php foreach ($this->styleSheets() as $link): ?>
        <link rel="stylesheet" href="<?php echo $link; ?>"/>
        <?php endforeach; ?>
    </head>
    <body>
        <?php echo $this->__invoke()->text; ?>
    </body>
    </html>
    <?php
        return ob_get_clean();
    }

    public function __invoke()
    {
        $this->text = (string)$this->body();
        return $this;
    }

}