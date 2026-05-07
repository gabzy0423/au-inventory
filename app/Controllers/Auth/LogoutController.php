<?php

namespace App\Controllers\Auth;
use App\Controllers\BaseController;

class LogoutController extends BaseController
{
    public function destroy() {
        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }
        session_unset();
        session_destroy();
        $this->redirect('/');
    }

}
