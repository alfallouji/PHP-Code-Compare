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

class appController
{
    /**
     * parseParameters 
     * 
     * @param array $array 
     * @return void
     */
    public static function parseParameters(array $array = array())
    {
        $result = array();

        // Check what options were called
        $cpt = 3;
        while(isset($array[$cpt]))
        {
            switch($array[$cpt])
            {        
                case '-m':
                case '--methods':
                    $results['methods'] = true;
                    break;

                case '-c':
                case '--classes':
                    $results['classes'] = true;
                    break;

                case '-a':
                case '--all':
                    $results['methods'] = true;
                    $results['classes'] = true;
                    $results['all'] = true;
                    break;

                case '-h':
                case '--help':
                    textUI::displayHelp();
                    die();
                    break;
            }

            ++$cpt;
        }

        return $results;
    }

    /**
     * compareAll 
     * 
     * @param mixed $results 
     * @return void
     */
    public static function compareAll($results)
    {
        foreach($results as $result)
        {
            echo PHP_EOL . "Parsing "  . PHP_EOL;

            foreach($result as $className => $classInfo)
            {
                echo PHP_EOL . PHP_EOL . "\tFound class " . str_pad($className, 30, '.') . " @ " . $classInfo['fileName'] . PHP_EOL;
                echo "\t" . str_pad('', 120, '_') . PHP_EOL . PHP_EOL;

                foreach($classInfo['methods'] as $methodName => $value)
                {
                    echo "\tFound method " . str_pad($methodName, 30, '.') . PHP_EOL;
                }
            }
        }
    }

    /**
     * compareMethods 
     * 
     * @param mixed $results 
     * @param mixed $path1 
     * @param mixed $path2 
     * @return void
     */
    public static function compareMethods($results, $path1, $path2)
    {
        $changed = array();

        echo 'Comparing methods between V1:"' . $path1 . '" and V2:"' . $path2 . '"' . PHP_EOL;
        foreach($results[0] as $className => $classInfo)
        {
            $msg = true;
            foreach($classInfo['methods'] as $method => $params)
            {
                if(!isset($results[1][$className]['methods'][$method]))
                {
                    if(true === $msg)
                    {
                        echo textUI::COLOR_BOLD;

                        if(!isset($results[1][$className]))
                        {
                            echo textUI::COLOR_RED; 
                        }

                        echo PHP_EOL;
                        echo "Class " . str_pad($className, 20, '.') . " @ " . $results[0][$className]['fileName'];

                        // In that case, the class itself doesnt exist
                        if(!isset($results[1][$className]))
                        {
                            echo ' (class doesn\'t exist)' . textUI::COLOR_RED_NORMAL;
                        }
                        else
                        {
                            echo textUI::COLOR_NORMAL; 
                        }
                        echo  PHP_EOL;

                        $msg = false;
                    }

                    echo "\tMethod " . $method . '() doesn\'t exist.' . PHP_EOL;
                }
                else
                {
                    if($params != $results[1][$className]['methods'][$method])
                    {
                        if(empty($params['params']))
                            $strParamsV1 = '';
                        else
                            $strParamsV1 = implode(', ', $params['params']);

                        $strParamsV2 = implode(', ', $results[1][$className]['methods'][$method]['params']);

                        $changed[] = "\tParameters for method " . $method . ' may have changed' . PHP_EOL .
                            "\t\t V1: " . $strParamsV1 . PHP_EOL . 
                            "\t\t V2: " . $strParamsV2 . PHP_EOL . PHP_EOL;
                    }
                }

                if(true === $msg && !empty($changed))
                {
                    echo textUI::COLOR_BOLD;
                    echo PHP_EOL;
                    echo "Class " . str_pad($className, 20, '.') . " @ " . $results[0][$className]['fileName'];
                    echo textUI::COLOR_NORMAL; 
                    echo  PHP_EOL;
                    $msg = false;
                }

                foreach($changed as $change)
                {
                    echo $change;
                }
                $changed = array();
            }
            echo textUI::COLOR_NORMAL;
        }
    }

    /**
     * compareClasses 
     * 
     * @param mixed $results 
     * @return void
     */
    public static function compareClasses($results)
    {
        echo PHP_EOL . textUI::COLOR_RED . 'Classes that dont exist anymore...' . PHP_EOL . textUI::COLOR_RED_NORMAL;
        foreach($results[0] as $className => $classInfo)
        {
            if(!isset($results[1][$className]))
            {
                echo "\tClass " . str_pad($className, 40, '.') . ' @ ' . $classInfo['fileName'] . PHP_EOL;
            }
        }

        echo PHP_EOL . textUI::COLOR_BOLD . 'New classes ...' . PHP_EOL . textUI::COLOR_NORMAL;
        foreach($results[1] as $className => $classInfo)
        {
            if(!isset($results[0][$className]))
            {
                echo "\tClass " . str_pad($className, 40, '.') . ' @ ' . $classInfo['fileName'] . PHP_EOL;
            }
        }
    }
}
