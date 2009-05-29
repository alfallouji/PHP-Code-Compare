<?php
/**
 * phpApiCompare
 *
 * Copyright (c) 2009, Bashar Al-Fallouji <bashar@alfallouji.com>
 * All rights reserved.
 *
 * Redistribution and use in source and binary forms, with or without
 * modification, are permitted provided that the following conditions
 * are met:
 *
 *   * Redistributions of source code must retain the above copyright
 *     notice, this list of conditions and the following disclaimer.
 *
 *   * Redistributions in binary form must reproduce the above copyright
 *     notice, this list of conditions and the following disclaimer in
 *     the documentation and/or other materials provided with the
 *     distribution.
 *
 *   * Neither the name of Bashar Al-Fallouji nor the names of his
 *     contributors may be used to endorse or promote products derived
 *     from this software without specific prior written permission.
 *
 * THIS SOFTWARE IS PROVIDED BY THE COPYRIGHT HOLDERS AND CONTRIBUTORS
 * "AS IS" AND ANY EXPRESS OR IMPLIED WARRANTIES, INCLUDING, BUT NOT
 * LIMITED TO, THE IMPLIED WARRANTIES OF MERCHANTABILITY AND FITNESS
 * FOR A PARTICULAR PURPOSE ARE DISCLAIMED. IN NO EVENT SHALL THE
 * COPYRIGHT OWNER OR CONTRIBUTORS BE LIABLE FOR ANY DIRECT, INDIRECT,
 * INCIDENTAL, SPECIAL, EXEMPLARY, OR CONSEQUENTIAL DAMAGES (INCLUDING,
 * BUT NOT LIMITED TO, PROCUREMENT OF SUBSTITUTE GOODS OR SERVICES;
 * LOSS OF USE, DATA, OR PROFITS; OR BUSINESS INTERRUPTION) HOWEVER
 * CAUSED AND ON ANY THEORY OF LIABILITY, WHETHER IN CONTRACT, STRICT
 * LIABILITY, OR TORT (INCLUDING NEGLIGENCE OR OTHERWISE) ARISING IN
 * ANY WAY OUT OF THE USE OF THIS SOFTWARE, EVEN IF ADVISED OF THE
 * POSSIBILITY OF SUCH DAMAGE.
 *
 * @package   phpApiCompare
 * @author    Bashar Al-Fallouji <bashar@alfallouji.com>
 * @copyright 2009 Bashar Al-Fallouji <bashar@alfallouji.com>
 * @license   http://www.opensource.org/licenses/bsd-license.php  BSD License
 * @since     File available since Release 1.0.0
 */

/**
 * Simple textUI class
 */
class textUI
{
    const COLOR_GREEN       = "\033[1;32m";
    const COLOR_RED         = "\033[1;31m";
    const COLOR_RED_NORMAL  = "\033[0;31m";
    const COLOR_NORMAL      = "\033[0;39m";
    const COLOR_BOLD        = "\033[1;39m";

    const POS_END           = "\033[60G";
    const POS_START         = "\033[0G";

    const SCREEN_WIDTH      = 80;

    public static function displayHelp()
    {
        echo self::COLOR_BOLD;
        print <<<EOF

Usage: php compare.php oldFolder newFolder [-c] [-m] [-a] [-h]
  
  -c, --classes             Compare classes
  -m, --methods             Compare methods
  -a, --all                 Compare all
  -h, --help                print a summary of the options

Example: php compare.php /var/www/cms1.0/api /var/www/cms2.0/api -a 


EOF;
        echo self::COLOR_NORMAL;
    }

    public static function displayHeader()
    {
        echo `clear`;
        echo PHP_EOL . self::COLOR_BOLD . 'Code Comparator ver1.0 by Bashar Al-Fallouji' . PHP_EOL . self::COLOR_NORMAL;
    }
}
