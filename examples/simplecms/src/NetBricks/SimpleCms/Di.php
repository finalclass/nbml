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
namespace NetBricks\SimpleCms;
/**
 * @author: Sel <s@finalclass.net>
 * @date: 08.07.12
 * @time: 02:25
 */
class Di
{

    /**
     * @static
     * @return \PDO
     */
    static public function db()
    {
        static $db;
        if (!$db) {
            $db = new \PDO('sqlite:' . self::sqLiteFilePath());
            $db->setAttribute(\PDO::ATTR_ERRMODE, \PDO::ERRMODE_EXCEPTION);
        }
        return $db;
    }

    static public function sqLiteFilePath($value = null)
    {
        static $sqLiteFilePath;
        if ($value !== null) {
            $sqLiteFilePath = $value;
        }
        return (string)$sqLiteFilePath;
    }

    static public function secretFilePath($value = null)
    {
        static $secretFilePath;
        if ($value !== null) {
            $secretFilePath = $value;
        }
        return (string)$secretFilePath;
    }

    static public function isLogged($value = null)
    {
        if ($value === null) {
            return isset($_SESSION['is_logged']);
        }
        if ($value) {
            $_SESSION['is_logged'] = true;
        } else {
            unset($_SESSION['is_logged']);
        }
    }

}
