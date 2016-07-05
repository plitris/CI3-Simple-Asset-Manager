<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

//Main folder of all the access files
$config['assets_folder'] = 'assets';

//Assets to be loaded by specific keys. Keys are reusable.
$config['css']['welcome'] = array(
                                  'css/bootstrap.min.css', 
                                  'css/welcome.css', 
                                  'css/welcome_theme.css'
                                  );
                                  
$config['css']['message'] = array(
                                  'css/post.css', 
                                  'css/message_style.css'
                                  );

/*
    With the current configuration if you run 
    
    <?=$this->ciam->css(array('welcome', 'message'));?>
    
    you will get the following echo:


        <link href="http://localhost/assets/css/bootstrap.min.css" rel="stylesheet" type="text/css" />
        <link href="http://localhost/assets/css/welcome.css" rel="stylesheet" type="text/css" />
        <link href="http://localhost/assets/css/welcome_theme.css" rel="stylesheet" type="text/css" />
        <link href="http://localhost/assets/css/post.css" rel="stylesheet" type="text/css" />
        <link href="http://localhost/assets/css/message_style.css" rel="stylesheet" type="text/css" />
*/

/*
    Same for JavaScript
*/
$config['js']['welcome'] = array('js/jquery.2.1.min.js','js/jquery.ui.js');

