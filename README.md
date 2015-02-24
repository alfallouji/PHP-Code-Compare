## phpApiCompare 

Copyright (c) 2009, Bashar Al-Fallouji <bashar@alfallouji.com>
All rights reserved.

Redistribution and use in source and binary forms, with or without
modification, are permitted provided that the following conditions
are met:

 Redistributions of source code must retain the above copyright
    notice, this list of conditions and the following disclaimer.

 Redistributions in binary form must reproduce the above copyright
    notice, this list of conditions and the following disclaimer in
    the documentation and/or other materials provided with the
    distribution.

 Neither the name of Bashar Al-Fallouji nor the names of his
    contributors may be used to endorse or promote products derived
    from this software without specific prior written permission.

THIS SOFTWARE IS PROVIDED BY THE COPYRIGHT HOLDERS AND CONTRIBUTORS
"AS IS" AND ANY EXPRESS OR IMPLIED WARRANTIES, INCLUDING, BUT NOT
LIMITED TO, THE IMPLIED WARRANTIES OF MERCHANTABILITY AND FITNESS
FOR A PARTICULAR PURPOSE ARE DISCLAIMED. IN NO EVENT SHALL THE
COPYRIGHT OWNER OR CONTRIBUTORS BE LIABLE FOR ANY DIRECT, INDIRECT,
INCIDENTAL, SPECIAL, EXEMPLARY, OR CONSEQUENTIAL DAMAGES (INCLUDING,
BUT NOT LIMITED TO, PROCUREMENT OF SUBSTITUTE GOODS OR SERVICES;
LOSS OF USE, DATA, OR PROFITS; OR BUSINESS INTERRUPTION) HOWEVER
CAUSED AND ON ANY THEORY OF LIABILITY, WHETHER IN CONTRACT, STRICT
LIABILITY, OR TORT (INCLUDING NEGLIGENCE OR OTHERWISE) ARISING IN
ANY WAY OUT OF THE USE OF THIS SOFTWARE, EVEN IF ADVISED OF THE
POSSIBILITY OF SUCH DAMAGE.

@package   phpApiCompare
@author    Bashar Al-Fallouji <bashar@alfallouji.com>
@copyright 2009 Bashar Al-Fallouji <bashar@alfallouji.com>
@license   http://www.opensource.org/licenses/bsd-license.php  BSD License
@since     File available since Release 1.0.0


PHP Code Comparator is Command Line Script allowing to compare different 
versions of a library, framework or package and detect changes in terms 
of class existence or method definitions.

If you ever wanted to have a way to quickly identify what classes have 
been altered or methods have been changed between two different versions 
of the same package, PHP Code Comparator might be the tool you were looking
for.

Instead of using a diff tool, you can simply use this PHP command line script. 
It will basically parse a folder recursively, detect any defined classes and 
extract the various methods and parameters. This will then be performed on 
the second version of your library. Then, a summary will be displayed showing 
the differences that have been detected.

The parsing is using the PHP tokenizer (www.php.net/tokenizer) and it will detect
classes, interfaces, methods and parameters.

Also, this tool will detect if a class has been removed, if new classes have been 
added, if methods have been removed or added and also if the signature of a 
method has changed.


Where can I download it ?
=========================

You can browse the code and download it from github.com.

http://github.com/alfallouji/PHP-Code-Comparator/

You can also directly get the source code from the git repository.

git clone git://github.com/alfallouji/PHP-Code-Comparator.git


How can I use it ?
==================

This tool is a simple Command Line Script. Therefore, it can be used by just using the php interpreter.

    Usage: php compare.php oldFolder newFolder [-c] [-m] [-a] [-h]

    -c, --classes Compare classes
    -m, --methods Compare methods
    -a, --all Compare all
    -h, --help print a summary of the options

    Example: php compare.php /var/www/cms1.0/api /var/www/cms2.0/api -a 


Comparing the classes of two different version of a project
-----------------------------------------------------------

The following command will compare the classes of version 1.6 and 1.7 of Wordpress.

    php compare.php ../compare/wordpress1.6/ ../compare/wordpress1.7/ -c 



Here is the result of the comparison.
-------------------------------------

    Code Comparator ver1.0 by Bashar Al-Fallouji

    Classes that dont exist anymore…
    None…

    New classes …
    Class OPML_Import @ ../compare/wordpress1.7/wp-admin/import/opml.php
    Class WP_Filesystem_SSH2 @ ../compare/wordpress1.7/wp-admin/includes/class-wp-filesystem-ssh2.php
    Class WP_Http @ ../compare/wordpress1.7/wp-includes/http.php
    Class WP_Http_Fsockopen @ ../compare/wordpress1.7/wp-includes/http.php
    Class WP_Http_Fopen @ ../compare/wordpress1.7/wp-includes/http.php
    Class WP_Http_Streams @ ../compare/wordpress1.7/wp-includes/http.php
    Class WP_Http_ExtHTTP @ ../compare/wordpress1.7/wp-includes/http.php
    Class WP_Http_Curl @ ../compare/wordpress1.7/wp-includes/http.php
    Class EnchantSpell @ ../compare/wordpress1.7/wp-includes/js/tinymce/plugins/spellchecker/classes/EnchantSpell.php
    Class Walker_Comment @ ../compare/wordpress1.7/wp-includes/comment-template.php 


Comparing the methods of two different version of a project
-----------------------------------------------------------

The following command will compare the methods of version 1.6 and 1.7 of Wordpress.

    php compare.php /var/www/perso/compare/wordpress1.6/ /var/www/perso/compare/wordpress1.7/ -m 



Here is the result of the comparison.
-------------------------------------

```
    Code Comparator ver1.0 by Bashar Al-Fallouji
    Comparing methods between V1:”/var/www/perso/compare/wordpress1.6/” and V2:”/var/www/perso/compare/wordpress1.7/”

    Class Walker_Category_Checklist @ /var/www/perso/compare/wordpress1.6/wp-admin/includes/template.php
    Parameters for method _wp_get_comment_list may have changed
    V1: $status, $s, $start, $num
    V2: $status, $s, $start, $num, $post, $type

    Parameters for method _wp_comment_row may have changed
    V1: $comment_id, $mode, $comment_status, $checkbox
    V2: $comment_id, $mode, $comment_status, $checkbox, $from_ajax

    Parameters for method touch_time may have changed
    V1: $edit, $for_post, $tab_index
    V2: $edit, $for_post, $tab_index, $mult

    Class PHPMailer @ /var/www/perso/compare/wordpress1.6/wp-includes/class-phpmailer.php
    Parameters for method EncodeQP may have changed
    V1: $str
    V2: $input, $line_max, $space_conv

    Class Walker_Page @ /var/www/perso/compare/wordpress1.6/wp-includes/classes.php
    Parameters for method start_el may have changed
    V1: $output, $page, $depth, $current_page, $args
    V2: $output, $page, $depth, $args, $current_page
```	
