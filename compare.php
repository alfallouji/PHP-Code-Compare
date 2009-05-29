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

include "lib/codeCompare.php";
include "lib/textUI.php";
include "lib/appController.php";

// Display header message
textUI::displayHeader();

// Check if enough parameters were passed
if($_SERVER['argc'] < 3)
{
    textUI::displayHelp();
    die();
}

$params = appController::parseParameters($_SERVER['argv']);

// Parse folders
$results[] = codeCompare::parseFolder($_SERVER['argv'][1]);
$results[] = codeCompare::parseFolder($_SERVER['argv'][2]);

// Verbose mode, display everything
if(isset($params['all']))
{
    appController::compareAll($results);
}

// Compare classes from FolderA with FolderB
if(isset($params['classes']))
{
    appController::compareClasses($results);
}

// Compare methods and parameters
if(isset($params['methods']))
{
    appController::compareMethods($results, $_SERVER['argv'][1], $_SERVER['argv'][2]);
}
