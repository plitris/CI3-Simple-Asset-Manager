CodeIgniter 3 Simple Asset Manager
==============================

I've tried few asset managers for CI, which didn't prove themselves for my purpose or are over complicated for simple use. 

This library might save the hassle to keep track of where CSS and JS files appear.

General purpose is to load multiple files by referencing a widget name that uses those files.

Usage
=====

 1. Paste the files into CodeIgniter
 2. Auto load in **config.php** `$config['libraries'] = array('ciam');` or use on demand with $this->load->library('ciam');
 3. Go to **application/config/ciam.php** and specify CSS/JS files for each one of your widgets/features (examples in the file)
 4. For CSS use in your view: `<?=$this->ciam->css(array('welcome, 'messages'));?>`
 5. For JS, use in view:  `<?=$this->ciam->js(array('jquery, 'mobileux'));?>`

>Or use the returned value:
>`$styles = $this->ciam->css(array('welcome, 'messages'));`
>You can use either arrays or strings to specify which batch of assets to load.



