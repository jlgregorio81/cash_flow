<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace core\util;

/**
 * Description of Session
 *
 * @author jlgregorio81
 */
class Session {

    public static function createSession($nome, $obj) {
        if (!isset($_SESSION))
            session_start();
        $_SESSION[$nome] = $obj;
    }

    public static function getSession($nome = null) {
        if (!isset($_SESSION))
            session_start();
        if ($nome) {
            return isset($_SESSION[$nome]) ? $_SESSION[$nome] : NULL;
        } else {
            return $_SESSION;
        }
    }

    public static function destroySession($nome = NULL) {
        if (!isset($_SESSION))
            session_start();
        if (is_null($nome))
            session_destroy();
        else
            unset($_SESSION[$nome]);
    }

}
