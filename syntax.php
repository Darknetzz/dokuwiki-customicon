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
        $base_url = $this->getConf('icon_base_url');
        $ext = $this->getConf('icon_extension');
        
        // Use defaults if config is empty
        if(empty($base_url)) {
            $base_url = 'https://assets.kriss.run/icons/silk/png/';
        }
        if(empty($ext)) {
            $ext = '.png';
        }
        
        $url = $base_url . $icon . $ext;
        $url_escaped = hsc($url);
        $icon_escaped = hsc($icon);
        $fallback_url = hsc('https://assets.kriss.run/icons/silk/png/help.png');
        
        return '<img src="' . $url_escaped . '" ' .
               'alt="' . $icon_escaped . '" ' .
               'class="plugin_customicon" ' .
               'onerror="this.src=\'' . $fallback_url . '\'; this.onerror=null;" ' .
               '/>';
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