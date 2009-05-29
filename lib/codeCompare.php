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


define('TMP_PATH', '/tmp/apiCompare');

/**
 * Code comparator class
 */
class codeCompare
{    
    /**
     * Contains all the folders that should be parsed
     * @var Array 
     */    
    private static $_folders = array();

    /**
     * Contains all the classes and their matching filename 
     * @param Array  
     */    
    private static $_classes = array(); 

    /**
     * Parse folder and extract information from classes
     * 
     * @param String $folder Folder to process
     * @return Array Array containing all the classes found along and infos
     */
    public static function parseFolder($folder)
    {
        $results = array();
        $files = new RecursiveIteratorIterator(new RecursiveDirectoryIterator($folder));

        foreach ($files as $file)
        {
            if (!$file->isFile() || '.php' !== substr($file->getFilename(), -4))
                continue;

            if($classNames = self::getClassesFromFile($file->getPathname()))
            {
                $results = array_merge($results, $classNames);
            }
        }    
        return $results;
    }       

    /**
     * Extract the classname and extra information contained inside the php file
     *
     * @param String $file Filename to process
     * @return Array Array of classname(s) and interface(s) found in the file
     */
    private static function getClassesFromFile($file)
    {
        $classes = array();
        $tokens = token_get_all(file_get_contents($file));
        $nbtokens = count($tokens);

        $classCpt = 0;

        for($i = 0 ; $i < $nbtokens ; $i++)
        {
            switch($tokens[$i][0])
            {
                // Retrieve methods
                case T_FUNCTION:
                    $i+=2;
                    $classes[$currentClass]['methods'][$tokens[$i][1]]['params'] = array();
                    $currentFunction = $tokens[$i][1];
                    while(')' != $tokens[$i])
                    {
                        // Retrive method parameters
                        if(T_VARIABLE == $tokens[$i][0])
                        {
                            $classes[$currentClass]['methods'][$currentFunction]['params'][] = $tokens[$i][1];
                        }

                        ++$i;
                    }
                    break;

                // Retrieve classes and interfaces
                case T_INTERFACE:
                case T_CLASS:
                    $i+=2;
                    ++$classCpt;
                    $classes[$tokens[$i][1]]['fileName'] = $file;
                    $classes[$tokens[$i][1]]['methods'] = array();

                    $currentClass = $tokens[$i][1];
                    break;
            }
        }

        return $classes;
    }
}
