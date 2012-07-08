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
use \NetBricks\SimpleCms\Model\Article;
/**
 * @author: Sel <s@finalclass.net>
 * @date: 08.07.12
 * @time: 04:39
 */
class ArticlesFormViewModel
{

    /** @var \NetBricks\SimpleCms\Model\Article */
    public $article;

    public $titleInputClassName = '';
    public $titleError = '';

    public $bodyTextareaClassName = '';
    public $bodyError = '';

    public function __construct()
    {
        $id = '';
        if(isset($_POST['id'])) {
            $id = $_POST['id'];
        }
        else if(isset($_GET['id'])) {
            $id = $_GET['id'];
        }

        if($id) {
            $this->article = Article::find($id);
        } else {
            $this->article = new Article();
        }

        if(isset($_POST['title'])) {
            $this->article->title = $_POST['title'];
            $this->article->body = $_POST['body'];
            $this->save();
        }
    }

    private function save()
    {
        if($this->isValid()) {
            $this->article->save();
            header('Location: /admin/articles');
        }
    }

    private function isValid()
    {
        $valid = true;
        if(strlen($this->article->title) < 3) {
            $this->titleError = 'Title must have at least 3 characters';
            $this->titleInputClassName = 'warning';
            $valid = false;
        }
        if(strlen($this->article->body) < 3) {
            $this->bodyError = 'Body must have at least 3 characters';
            $this->bodyTextareaClassName = 'warning';
            $valid = false;
        }
        return $valid;
    }
}
