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
 * @time: 00:52
 */
class OnStateMetadataTag extends AbstractMetadataTag
{
    /**
     * Returns [TagName] of the metadata tag
     *
     * @return string
     */
    static function getMetadataTagName()
    {
        return 'OnState';
    }

    public function getRequiredProperties()
    {
        return array('name');
    }

    public function getDefaultPropertyName()
    {
        return 'name';
    }


    public function getBeforeRenderRetrieveCode()
    {
        $state = $this->definition->getDefaultProperty();
        $name_und = $this->variable->getNameUnderscored();
        $nameCamel = $this->variable->getName();
        $type = $this->variable->getType();
        $default = $this->variable->getDefaultValue();

        ob_start();
?>
        <?php echo '$' . $nameCamel?> = '';
        if(@$this->options['current_state'] == '<?php echo $state; ?>') {
            if(@$this->options['<?php echo $name_und ?>']) {
                <?php echo '$' . $nameCamel?> = $this->options['<?php echo $name_und?>'];
            } else {
                <?php if($this->variable->isSimpleType()): ?>
                    <?php echo '$' . $nameCamel?> = <?php echo $default?>;
                <?php else: ?>
                    <?php echo '$' . $nameCamel?> = new <?php echo $type . '(' . $default; ?>);
                <?php endif; ?>
            }
        }
<?php
        return ob_get_clean();
    }

}
