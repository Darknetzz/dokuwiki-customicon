<?php
if(!defined('DOKU_INC')) die();

class syntax_plugin_customicon extends DokuWiki_Syntax_Plugin {
    public function getType() { return 'substition'; }
    public function getPType() { return 'normal'; }
    public function getSort() { return 155; }

    public function connectTo($mode) {
        $this->Lexer->addSpecialPattern('\{\{customicon>[^}]+\}\}', $mode, 'plugin_customicon');
    }

    public function handle($match, $state, $pos, Doku_Handler $handler) {
        $icon = substr($match, 13, -2); // '{{customicon>' is 13 chars
        return array($icon); // This array is what $data becomes in render()
    }

    /**
     * Get icon HTML directly (helper function for use in PHP blocks)
     * @param string $icon Icon name
     * @return string HTML for the icon
     */
    public function getIconHTML($icon) {
        // Sanitize the input
        $icon = trim($icon);
        $icon = preg_replace('/[^a-zA-Z0-9_-]/', '', $icon);
        if(empty($icon)) {
            return '';
        }
        
        // Get configuration with fallback to defaults
        $base_url      = $this->getConf('icon_base_url');
        $ext           = $this->getConf('icon_extension');
        $fallback_icon = $this->getConf('fallback_icon');
        $icon_class    = $this->getConf('icon_class');
        $icon_size     = $this->getConf('icon_size');
        $icon_title    = $this->getConf('icon_title');
        $lazy_load     = $this->getConf('lazy_load');
        
        // Use defaults if config is empty
        if(empty($base_url)) {
            $base_url = 'https://assets.kriss.run/icons/silk/png/';
        }
        if(empty($ext)) {
            $ext = '.png';
        }
        if(empty($fallback_icon)) {
            $fallback_icon = 'help';
        }
        if(empty($icon_class)) {
            $icon_class = 'plugin_customicon';
        }
        
        // Build icon URL
        $url = $base_url . $icon . $ext;
        $url_escaped = hsc($url);
        $icon_escaped = hsc($icon);
        
        // Build fallback URL
        $fallback_url = hsc($base_url . $fallback_icon . $ext);
        
        // Build HTML attributes
        $attrs = array();
        $attrs[] = 'src="' . $url_escaped . '"';
        $attrs[] = 'alt="' . $icon_escaped . '"';
        $attrs[] = 'class="' . hsc($icon_class) . '"';
        
        // Add size if configured
        if(!empty($icon_size) && is_numeric($icon_size)) {
            $size_escaped = hsc($icon_size);
            $attrs[] = 'width="' . $size_escaped . '"';
            $attrs[] = 'height="' . $size_escaped . '"';
        }
        
        // Add title attribute if enabled
        if($icon_title) {
            $attrs[] = 'title="' . $icon_escaped . '"';
        }
        
        // Add lazy loading if enabled
        if($lazy_load) {
            $attrs[] = 'loading="lazy"';
        }
        
        // Add error handler for fallback
        $attrs[] = 'onerror="this.src=\'' . $fallback_url . '\'; this.onerror=null;"';
        
        return '<img ' . implode(' ', $attrs) . ' />';
    }

    public function render($mode, Doku_Renderer $renderer, $data) {
        if($mode === 'xhtml') {
            if(!is_array($data) || empty($data)) {
                return false;
            }
            list($icon) = $data;
            
            // Use the helper function
            $html = $this->getIconHTML($icon);
            if(empty($html)) {
                return false;
            }
            
            $renderer->doc .= $html;
            return true;
        }
        return false;
    }
}