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
namespace NetBricks\SimpleCms\Model;
use \NetBricks\SimpleCms\Di;
use \NetBricks\SimpleCms\Model;

/**
 * @author: Sel <s@finalclass.net>
 * @date: 08.07.12
 * @time: 02:31
 */
class Article extends Model
{

    public $id = '';
    public $title = '';
    public $body = '';

    static public function initDb()
    {
        $query = 'CREATE TABLE IF NOT EXISTS article(
            id INTEGER PRIMARY KEY,
            title char(255),
            body text
        );';
        Di::db()->query($query);
    }

    /**
     * @static
     * @return Article[]
     */
    static public function all()
    {
        return static::fetch(Di::db()->query('select * from article'));
    }

    /**
     * @static
     * @param $id
     * @return Article
     */
    static public function find($id)
    {
        $id = (int)$id;
        $stmt = Di::db()->prepare('select * from article where id=:id');
        $stmt->execute(array(':id' => $id));
        $records = static::fetch($stmt);
        return reset($records);
    }

    public function save()
    {
        if ($this->id) {
            Di::db()
                    ->prepare('
                          update article
                          set title=:title, body=:body
                          where id=:id')
                    ->execute(
                        array(
                            ':id' => $this->id,
                            ':title' => $this->title,
                            ':body' => $this->body
                        )
                    );
            return $this->id;
        } else {
            Di::db()
                    ->prepare('
                          insert into article(title, body)
                          values(:title, :body)')
                    ->execute(array(':title' => $this->title, ':body' => $this->body));
        }
        return Di::db()->lastInsertId();
    }

    static public function remove($id)
    {
        $stmt = Di::db()->prepare('delete from article where id=:id');
        $stmt->execute(array(':id' => (int)$id));
    }

}
