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
        
        return $this->generate_html('css', $assets_keys);
        
    }
    
    
    //[js][homepage] = array('source1.js', 'source2.js')
    function js($assets_keys){      //e.g. array('homepage', 'article')
        
        return $this->generate_html('js', $assets_keys);
        
    }
    
    private function generate_html($link_type, $assets_keys){ //Generate HTML for js or css link type
        $links = '';     //HTML for the links
        
        if(is_array($assets_keys)):
            //For each widget
            foreach ($assets_keys as $asset_list):
                $assets = ($link_type == 'css')? $this->amc_css[$asset_list]:$this->amc_js[$asset_list];
                foreach ($assets as $link):
                    if($link_type == 'js'):
                        $links .= '<script type="text/javascript" src="' . base_url($this->assets_folder . $link) . '"></script>';      //Building link HTML
                    elseif($link_type == 'css'):
                        $links .= link_tag($this->assets_folder . $link);
                    endif;
                endforeach;
            endforeach;
        else:
            $single_asset = ($link_type == 'css')? $this->amc_css : $this->amc_js;
            if(array_key_exists($assets_keys, $single_asset)):
                foreach ($single_asset[$assets_keys] as $s_link):
                    if($link_type == 'js'):
                        $links .= '<script type="text/javascript" src="' . base_url($this->assets_folder . $s_link) . '"></script>' . PHP_EOL;
                    elseif($link_type == 'css'):
                        $links .= link_tag($this->assets_folder . $s_link);
                    endif;
                endforeach;
            endif;
        endif;
        
        return $links;
    }
    
    
}