<?php
/**
 * Plugin Block:  Create sized boxes with borders,font and color selection, and screen positoning
 * 
 * @license    GPL 2 (http://www.gnu.org/licenses/gpl.html)
 * @author     Myron Turner <turnermm02@shaw.ca>
 */


 
// must be run within Dokuwiki
if(!defined('DOKU_INC')) die();
 
if(!defined('DOKU_PLUGIN')) define('DOKU_PLUGIN',DOKU_INC.'lib/plugins/');
require_once(DOKU_PLUGIN.'syntax.php');
 
/**
 * All DokuWiki plugins to extend the parser/rendering mechanism
 * need to inherit from this class
 */

/*
 *  <block width:alignment:background-color,text-color;border;font-family/font-size>
 *   text
 *  </block>
 *   width:  percent of window size
 *   align:  number of pixels from left margin, (0 or 'c' centers block), 'r' floats right
 *   border: CSS style: width type color
 *   font-family:  font name
 *   font size: specify points or pixels
 *
 *   Example:  
 *  <block 80:0:rgb(102, 51, 255);rgb(255, 255, 153);2px dashed rgb(255, 102, 255);Comic Sans MS /10pt> 
 *
 *  This creates a block 80% of page width,centered on page, background of block is rgb(102, 51, 255),
 *  text-color is rgb(255, 255, 153); the box border is 2px wide, dashed, its color is rgb(255, 102, 255).
 *  The font is 10pt Comic Sans MS.
 *   
 *  Only width and alignment are required.  In this case, if alignment is 'c' or 'r', 
 *  then you must follow it with a colon:  'c:'
*/

class syntax_plugin_block extends DokuWiki_Syntax_Plugin {
 
    var $edit = false;

    function getType(){ return 'formatting'; }
    function getAllowedTypes() { return array('formatting','baseonly', 'substition','container', 'paragraphs'); }   
    function getSort(){ return 160; }
    function connectTo($mode) { $this->Lexer->addEntryPattern('<block.*?>(?=.*?</block>)',$mode,'plugin_block'); }
    function postConnect() { $this->Lexer->addExitPattern('</block>','plugin_block'); }
    function getPType() {  return "stack"; }
 
    /**
     * Handle the match
     */
    function handle($match, $state, $pos, &$handler){

        $padding = 0;
        $width = "100%";
        $margin = ' margin: auto ';
        $bgcolor = 'white';
        $text_color = "";
        $border = "";        
        $font = "";
        $face = "";
        $font_size = "";
        $rounded_corners = " class='blocks_round' ";
		$class = "";
        if( (isset($_REQUEST['do']) && $_REQUEST['do'] == 'edit') ) {
         $this->edit = true;     
       }
        switch ($state) {
          case DOKU_LEXER_ENTER :
                
                list($type, $val) = preg_split("/\s+/u", substr($match, 1, -1), 2);

                if(!isset($type)) return array($state, '');
                if(!isset($val)) {
                      $this->edit = false;   
                      return array($state, '<div>');
                }
				if(preg_match("/rounded\s*$/",$val)) {
					$val = preg_replace("/rounded\s*$/","",$val);
					$class = $rounded_corners;
				}	

                if(preg_match('/(\d+)\%?:(\d+|r|c):(.*)/',$val, $matches)) {
                   $width =   $matches[1] .'%';
                
                   if($matches[2] == 'r') { 
                        $margin = ' float: right ';
                   }
                    
                   elseif($matches[2]> 0) { 
                        $margin = ' margin-left: ' . $matches[2] . 'px'; 
                   }
                   $color = $matches[3];  

                   if($color) {               
                        list($bg,$fg,$border,$font) = explode(';',$color);                      
                        if($bg) $bgcolor = "$bg;";
                        if($fg) $text_color = "color: $fg;";
                        if($border) $border = "border: $border;";
                        if($font) {                        
                          list($face,$size) = explode('/',$font);
                          if($face) {
                             $face = " font-family: $face; "; 
                          }
                          if($size) {
                             $font_size =" font-size: $size; ";
                          }
                          $font = $face . $font_size;
                        }
                   }
                }
                elseif(preg_match('/(\d+)\%?:(\d+)/',$val, $matches)) {
                   $width = $matches[1] .'%';
                   if($matches[2]> 0) $margin = ' margin-left: ' . $matches[2] . 'px'; 
               }
                   

                  if($this->edit){
                    return array($state,
                     "<blockquote $class style='$border width:$width;display:block;padding:8px; $margin;"
                     . "  background-color:$bgcolor $text_color $font'>" );
                  }

                  return array($state,
                     "<div $class style='$border width:$width; padding:8px; $margin;"
                     . "  background-color:$bgcolor $text_color $font'>");
                
 
          return array($state, $match);

          case DOKU_LEXER_UNMATCHED :  return array($state, $match);
          case DOKU_LEXER_EXIT :       return array($state,$match);
        }
        return array();
    }
 
    /**
     * Create output
     */
    function render($mode, &$renderer, $data) {
        if($mode == 'xhtml'){
            list($state, $match) = $data;
           
            switch ($state) {
              case DOKU_LEXER_ENTER :      

                $renderer->doc .= $match; 
                break;
 
              case DOKU_LEXER_UNMATCHED :  $renderer->doc .= $renderer->_xmlEntities($match); break;
              case DOKU_LEXER_EXIT : 
                      if($this->edit){                    
                         $renderer->doc .= "</blockquote></br>";
                      }
                      else { 
                         $renderer->doc .= "</div><div  style=' padding: 4px; clear:both;'></div>";
                      }
                       break;
            }
            return true;
        }
        return false;
    }
 
     function _isValid($c) {
        $c = trim($c);
 
        $pattern = "/
            ([a-zA-z]+)|                                #colorname - not verified
            (\#([0-9a-fA-F]{3}|[0-9a-fA-F]{6}))|        #colorvalue
            (rgb\(([0-9]{1,3}%?,){2}[0-9]{1,3}%?\))     #rgb triplet
            /x";
 
        if (preg_match($pattern, $c)) return $c;
 
        return "";
    }

function write_debug($data) {

  if (!$handle = fopen('block_check.txt', 'a')) {
    return;
    }

    // Write $somecontent to our opened file.
    fwrite($handle, "$data\n");
    fclose($handle);
    
}
}
?>
