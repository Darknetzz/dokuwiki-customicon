<?php
if(!defined('DOKU_INC')) die();

class syntax_plugin_customicon extends DokuWiki_Syntax_Plugin {
    public function getType() { return 'substitution'; }
    public function getPType() { return 'normal'; }
    public function getSort() { return 155; }

    public function connectTo($mode) {
        $this->Lexer->addSpecialPattern('\{\{customicon>[^}]+\}\}', $mode, 'plugin_customicon');
    }

    public function handle($match, $state, $pos, Doku_Handler $handler) {
        $icon = substr($match, 13, -2); 
        return array($icon);
    }

    public function render($mode, Doku_Renderer $renderer, $data) {
        if($mode == 'xhtml') {
            list($icon) = $data;
            
            // Pulling from the config we just created
            $base_url = $this->getConf('icon_base_url');
            $ext = $this->getConf('icon_extension');
            
            $url = $base_url . $renderer->_xmlEntities($icon) . $ext;
            
            $renderer->doc .= '<img src="' . $url . '" alt="' . $renderer->_xmlEntities($icon) . '" />';
            return true;
        }
        return false;
    }
}