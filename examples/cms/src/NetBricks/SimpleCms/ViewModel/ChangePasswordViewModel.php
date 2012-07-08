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
 * @time: 04:08
 */
class ChangePasswordViewModel
{

    public $currentInputClass = '';
    public $currentError = '';

    public $newPasswordInputClass = '';
    public $newPasswordError = '';

    public $retypePasswordInputClass = '';
    public $retypePasswordError = '';

    public $success = false;
    
    public function __construct()
    {
        if(isset($_POST['new_password'])) {
            $this->changePassword();
        }
    }

    private function changePassword()
    {
        if($this->isValid()) {
            $newPassword = md5($_POST['new_password']);
            file_put_contents(Di::secretFilePath(), $newPassword);
            $this->success = true;
        }
    }

    private function isValid()
    {
        $hasErrors = false;
        $secret = file_get_contents(Di::secretFilePath());
        if(md5($_POST['current']) !== $secret) {
            $this->currentError = 'Current password invalid.';
            $this->currentInputClass = 'warning';
            $hasErrors = true;
        }

        if(strlen($_POST['new_password']) < 5) {
            $this->newPasswordError = 'New password too short. Type at least 5 characters.';
            $this->newPasswordInputClass = 'warning';
            $hasErrors = true;
        }

        if($_POST['new_password'] != $_POST['retype_password']) {
            $this->retypePasswordError = 'Password is not the same.';
            $this->retypePasswordInputClass = 'warning';
            $hasErrors = true;
        }

        return !$hasErrors;
    }

}
