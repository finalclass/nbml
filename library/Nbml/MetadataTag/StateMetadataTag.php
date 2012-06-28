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
use Nbml\MetadataTag\AbstractMetadataTag;

/**
 * @author: Sel <s@finalclass.net>
 * @date: 28.06.12
 * @time: 00:14
 */
class StateMetadataTag extends AbstractMetadataTag
{
    /**
     * Returns [TagName] of the metadata tag
     *
     * @return string
     */
    static function getMetadataTagName()
    {
        return 'State';
    }

    public function getInitializationCode()
    {
        if($this->variable->getDefaultValue() == 'true') {
            return '$this->options[\'current_state\'] = '
                    . '\'' . $this->variable->getName() . '\';' . PHP_EOL;
        }
    }

    public function getGetterMethodDefinition()
    {
        return 'return @$this->options[\'current_state\'] == '
                . '\'' . $this->variable->getName() . '\';' . PHP_EOL;
    }

    public function getSetterMethodDefinition()
    {
        ob_start();
        ?>
    if($value) {
    $this->options['current_state'] = '<?php echo $this->variable->getName(); ?>';
    } else if($this->options['current_state'] == '<?php echo $this->variable->getName(); ?>'){
    $this->options['current_state'] = '';
    }
    <?php
        return ob_get_clean();
    }

    public function getBeforeRenderRetrieveCode()
    {
        $nameCamel = $this->variable->getName();
        return '$' . $nameCamel . ' = $this->' . $nameCamel . '();' . PHP_EOL;
    }


}
