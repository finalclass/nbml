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
namespace NetBricks\SimpleCms\ViewModel;
use \NetBricks\SimpleCms\Di;
/**
 * @author: Sel <s@finalclass.net>
 * @date: 08.07.12
 * @time: 04:02
 */
class BackViewModel
{

    protected $content;

    public function __construct()
    {
        $uri = $_SERVER['REQUEST_URI'];
        if(strpos($uri, '/admin/password') === 0) {
            $this->content = new \NetBricks\SimpleCms\View\Back\ChangePassword();
        } else if(strpos($uri, '/admin/articles') === 0) {
            $this->content = new \NetBricks\SimpleCms\View\Back\Articles();
        } else {
            $this->content = new \NetBricks\SimpleCms\View\Back\Dashboard();
        }
    }

    public function getContent()
    {
        return $this->content;
    }

}
