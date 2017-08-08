<?php
/**
 *
 * @license GPL 2 http://www.gnu.org/licenses/gpl-2.0.html
 * @author  Andreas Valder <valder@isf.rwth-aachen.de>
 */

// must be run within Dokuwiki
if(!defined('DOKU_INC')) die();
class action_plugin_block extends DokuWiki_Action_Plugin {
    /**
     * Registers a callback function for a given event
     *
     * @param Doku_Event_Handler $controller DokuWiki's event controller object
     * @return void
     */
    public function register(Doku_Event_Handler $controller) {

       $controller->register_hook('AJAX_CALL_UNKNOWN', 'BEFORE', $this, 'handle_ajax_call_unknown');
       $controller->register_hook(DOKUWIKI_STARTED, 'BEFORE', $this, 'handle_started');
    }

    /**
     * @param Doku_Event $event  event object by reference
     * @param mixed      $param  [the parameters passed as fifth argument to register_hook() when this
     *                           handler was registered]
     * @return void
     */

    public function handle_ajax_call_unknown(Doku_Event &$event, $param) {
      if ($event->data !== 'block__opts') {
        return;
      }
      $event->stopPropagation();
      $event->preventDefault();
      $ar = array('block_width'=>'','bg'=>"",'fg'=>"",'border_color'=>"",'border_style'=>"",'border_width'=> "",'font_family'=> "",'font_size'=> "",'block_align'=> "");
      $ar_keys = array_keys($ar);
      foreach($ar_keys as $k) {
          $ar[$k] = trim($this -> getConf($k));
      }
         
         echo  json_encode($ar);
    }
    
    public function handle_started(Doku_Event &$event, $param) {
        global $ACT,$JSINFO;
        $JSINFO['block'] = 'block';
        $JSINFO['act'] = $ACT;
    }
}