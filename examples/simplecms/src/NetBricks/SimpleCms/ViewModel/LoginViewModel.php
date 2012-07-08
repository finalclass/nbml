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
 * @time: 03:28
 */
class LoginViewModel
{

    /** @var string */
    public $username;

    /** @var string */
    public $password;

    public $errorMessages = array();

    public function __construct()
    {
        $this->username = isset($_POST['username']) ? $_POST['username'] : '';
        $this->password = isset($_POST['password']) ? $_POST['password'] : '';

        //If post
        if(isset($_POST['username'])) {
            $this->login();
        }
    }

    public function login()
    {
        if($this->username != 'admin') {
            $this->errorMessages[] = 'Username or password invalid';
            return;
        }
        $secret = file_get_contents(Di::secretFilePath());
        if(md5($this->password) != $secret) {
            $this->errorMessages[] = 'Username or password invalid';
            return;
        }

        Di::isLogged(true);
        header('Location: /admin');
    }

}
