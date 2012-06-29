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
namespace Nbml\MetadataTag;
use \Nbml\MetadataTag\AbstractMetadataTag;
/**
 * @author: Sel <s@finalclass.net>
 * @date: 29.06.12
 * @time: 19:18
 */
class CssMetadataTag extends AbstractMetadataTag
{
    /**
     * Returns [TagName] of the metadata tag
     *
     * @return string
     */
    static function getMetadataTagName()
    {
        return 'Css';
    }

    public function getRequiredProperties()
    {
        return array('file');
    }

    public function getDefaultPropertyName()
    {
        return 'file';
    }

    public function getInitializationCode()
    {
        $css = trim($this->definition->getDefaultProperty());
        if(isset($css[0]) && $css[0] != '/') {
            $css = str_replace('\\', '/', $this->classReflection->getFullClassName())
                    . '/' . $css;
        }
        ob_start();
        ?>

            \Nbml\Component\Application::getInstance()
                ->styleSheets()->add('<?php echo $css;?>');

        <?php
        return ob_get_clean();
    }

}
