<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

//Library generates links for styles and script tags based on config: application/config/asset_manager.php
class ciam{
    
    
    
    //Codeigniter Instance
    private $ci;
    
    //Assets Manager Config
    private $amc;
    private $amc_css;
    private $amc_js;
    
    //Main assets folder
    private $css_folder;
    private $js_folder;
    private $favicon_folder;
    
    
    
    public function __construct(){
        
        
        //CodeIgniter Instance
        $this->ci = get_instance();
        
        //Load helpers
        $this->ci->load->helper(array('url', 'html'));
        
        
        
        //Load config data
        $this->ci->config->load('ciam');
        
        //Set main assets folder
        $this->css_folder = $this->ci->config->item('css_folder') . '/'; //Extra slash to compensate for additions to the URL
        $this->js_folder = $this->ci->config->item('js_folder') . '/'; //Extra slash to compensate for additions to the URL
        $this->favicon_folder = $this->ci->config->item('favicon_folder') . '/'; //Extra slash to compensate for additions to the URL
        
        //Get CSS items
        $this->amc_css = $this->ci->config->item('css');
        
        //Get JS items
        $this->amc_js = $this->ci->config->item('js');

        
    }
    

    //Outputs CSS based on they key name that has the links
    //Base URL is automatically added
    function css($assets_keys){
        
        return $this->generate_html('css', $assets_keys);
        
    }
    
    //Outputs JS based on they key name that has the links
    //Base URL is automatically added
    //[js][homepage] = array('source1.js', 'source2.js')
    function js($assets_keys){      //e.g. array('homepage', 'article')
        
        return $this->generate_html('js', $assets_keys);
        
    }
    
    //Outputs Favicons with all the properties
    //Base URL is automatically added to href
    function fav($fav){
        
        return $this->generate_html('favicon', $fav);
        
    }
    
    //Outputs Favicons with all the properties
    //Base URL is automatically added only to msapplication-TileImage 
    //Uses $this->favicon_folder as the base
    function meta($meta){
        return $this->generate_html('meta', $meta);
    }
    
    
    
    private function generate_html($link_type, $assets_keys){ //Generate HTML for js or css link type
        $links = '';     //HTML for the links
        
        if(is_array($assets_keys)):
            //For each widget
            foreach ($assets_keys as $asset_list):
                $assets = $this->ci->config->item($link_type);
                foreach ($assets as $link):
                    if($link_type == 'js'):
                        $links .= '<script type="text/javascript" src="' . base_url($this->js_folder . $link) . '"></script>';      //Building link HTML
                    elseif($link_type == 'css'):
                        $links .= link_tag($this->css_folder . $link);
                    elseif ($link_type == 'favicon'):
                        $links .= $this->generate_favicon($link);
                    elseif ($link_type == 'meta'):
                        $links .= $this->generate_meta($link);
                    endif;
                endforeach;
            endforeach;
        else:
            $single_asset = $this->ci->config->item($link_type);
            if(array_key_exists($assets_keys, $single_asset)):
                foreach ($single_asset[$assets_keys] as $s_link):
                    if($link_type == 'js'):
                        $links .= '<script type="text/javascript" src="' . base_url($this->js_folder . $s_link) . '"></script>' . PHP_EOL;
                    elseif($link_type == 'css'):
                        $links .= link_tag($this->css_folder . $s_link);
                    elseif ($link_type == 'favicon'):
                        $links .= $this->generate_favicon($s_link);
                    elseif ($link_type == 'meta'):
                        $links .= $this->generate_meta($s_link);
                    endif;
                endforeach;
            endif;
        endif;
        
        return $links;
    }
    
    function generate_favicon($favicon_props){
        
        $favicon_html = '<link';
            
        if (count($favicon_props) > 1):
            foreach ($favicon_props as $key => $value):
                if($key != 'href'):
                    $favicon_html .= ' ' . $key . '="' . $value . '"';
                endif;
            endforeach;
        endif;
        
        $favicon_html .= (array_key_exists('href', $favicon_props))?' href="' . base_url($this->favicon_folder . $favicon_props['href']) . '"':'';
        
        $favicon_html .= ' />' . PHP_EOL;
        
        return $favicon_html;
        
    }
    
    function generate_meta($meta_props){
        
        $meta_link = '<meta ';
        
        $meta_name_exists = array_key_exists('name', $meta_props);
        $meta_link .= (array_key_exists('name', $meta_props))?' name="' . $meta_props['name'] . '"':'';
        
        if($meta_name_exists && $meta_props['name'] == 'msapplication-TileImage'):
            $meta_link .= (array_key_exists('content', $meta_props))?' content="' . base_url($this->favicon_folder . $meta_props['content']) . '"':'';
        else:
            $meta_link .= (array_key_exists('content', $meta_props))?' content="' . $meta_props['content'] . '"':'';
        endif;
        
        if (count($meta_props) > 2):
            foreach ($meta_props as $key => $value):
                if($key != 'name' || $key != 'content'):
                    $meta_link .= ' ' . $key . '="' . $value . '"';
                endif;
            endforeach;
        endif;
        
        return $meta_link . ' />' . PHP_EOL;
        
    }
    
    
}