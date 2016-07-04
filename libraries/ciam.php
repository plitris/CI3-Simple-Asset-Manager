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
    private $assets_folder;
    
    
    
    public function __construct(){
        
        
        //CodeIgniter Instance
        $this->ci = get_instance();
        
        //Load helpers
        $this->ci->load->helper(array('url', 'html'));
        
        
        
        //Load config data
        $this->ci->config->load('ciam');
        
        //Set main assets folder
        $this->assets_folder = $this->ci->config->item('assets_folder') . '/'; //Extra slash to compensate for additions to the URL
        
        //Get CSS items
        $this->amc_css = $this->ci->config->item('css');
        
        //Get JS items
        $this->amc_js = $this->ci->config->item('js');

        
    }
    

    
    function css($assets_keys){
        
        $css_links = '';    //HTML for the links
        
        if(is_array($assets_keys)):
        //For each widget
        foreach ($assets_keys as $css_asset_list):
            $css_assets = $this->amc_css[$css_asset_list];
            foreach ($css_assets as $css_link):
                $css_links .= link_tag($this->assets_folder . $css_link);      //Building link HTML
            endforeach;
        endforeach;
        else:
            if(array_key_exists($assets_keys, $this->amc_css)):
                foreach ($this->amc_css[$assets_keys] as $s_css):
                    $css_links .= link_tag($this->assets_folder . $s_css);
                endforeach;
            endif;
        endif;
        return $css_links;
    }
    
    
    //[js][homepage] = array('source1.js', 'source2.js')
    function js($assets_keys){      //e.g. array('homepage', 'article')
        
        $js_links = '';     //HTML for the links
        
        if(is_array($assets_keys)):
        //For each widget
        foreach ($assets_keys as $js_asset_list):
            $js_assets = $this->amc_js[$js_asset_list];
            foreach ($js_assets as $js_link):
                $js_links .= '<script type="text/javascript" src="' . base_url($this->assets_folder . $js_link) . '"></script>';      //Building link HTML
            endforeach;
        endforeach;
        else:
            if(array_key_exists($assets_keys, $this->amc_js)):
                foreach ($this->amc_js[$assets_keys] as $s_js):
                    $js_links .= '<script type="text/javascript" src="' . base_url($this->assets_folder . $s_js) . '"></script>' . PHP_EOL;
                endforeach;
            endif;
        endif;
        
        return $js_links;
    }
    
    
}