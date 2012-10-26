<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN"
        "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">

<HTML>
<HEAD>

		<script type="text/javascript">
//<![CDATA[

var wikiTextArea;
var selectionObj;
var pluginDisplayDiv;
var activeColorElement;
var backgroundColor = false;
var borderColor = false;
var foregroundColor=false;
var panels = new Array('BlockBorder','MainPanel','ColorChart', 'FontSelection');
var FontOptions;

var blockSettings = {
  block_width: '80',
  bg: 'white',  
  fg: 'black', 
  border_color: 'black', 
  border_style: 'solid',
  border_width: '4px', 
  font_family: 'arial,sans-serif', 
  font_size: '9pt;',
  block_align: '0',
  corners: ''
};

var FontNamesArray = Array(
'Arial',
'Arial Black',
'Arial Narrow',
'Arial Rounded MT Bold',
'Baskerville, Baskerville Old Face',
'Bauhaus 93',
'Comic Sans MS',
'Copperplate, Copperplate Gothic Bold',
'Courier',
'Courier New',
'Futura, Futura Md BT',
'Georgia',
'Garamond',
'Helvetica',
'Impact',
'Sans-serif',
'Microsoft Sans Serif',
'Serif',
'Palatino, Palatino Linotype',
'Papyrus',
'Tahoma',
'Times New Roman',
'Trebuchet MS',
'Verdana'
);

function _dom(id) {
   return document.getElementById(id); 
}

window.onload = function() {
   pluginDisplayDiv = document.getElementById('user_block');
   wikiTextArea = window.opener.initialize(pluginDisplayDiv);
   selectionObj = window.opener.show_text_entry(pluginDisplayDiv);  
  
   FontOptions = document.getElementById('fonts_styles');
   FontOptions.options[0] = new Option('Select Type Face', 'none',true,false);
   for(var i=0; i < FontNamesArray.length; i++) {
       FontOptions.options[FontOptions.options.length] = new Option(FontNamesArray[i],FontNamesArray[i],false,false);
   }
   FontOptions.options[FontOptions.options.length] = new Option('Default type face','auto',false,false);
 
   window.focus();
}


function setBorderWidth() {
  var width = _dom('border_width').value + 'px';
  _dom('user_block').style.borderWidth = width;
  blockSettings['border_width'] = width;
}

function setBorderStyle(s) {
  _dom('user_block').style.borderStyle = s;
  blockSettings['border_style'] = s;
 
}

function setBorderColor(el) {
  var backgroundColor = false;
  foregroundColor=false;
  borderColor = true;
  activeColorElement = _dom(el);
  panelDisplay('ColorChart');
}


function panelDisplay(id) {
  for(var i=0; i<panels.length; i++) {
    _dom(panels[i]).style.display='none';
  }
  _dom(id).style.display='block';
}

function setActiveFGElement(el) {
  backgroundColor = false;
  borderColor = false;
  foregroundColor=true;
  activeColorElement = _dom(el);
}

function setActiveBGElement(el) {
  backgroundColor = true;
  foregroundColor=false;
  borderColor = false;
  activeColorElement = _dom(el);
 
}

function colorsAll(color) {
  color = '#' + color;
  if(backgroundColor) {
    activeColorElement.style.backgroundColor = color;
    blockSettings['bg'] = color;
  }
  else if(borderColor) {
    activeColorElement.style.borderColor = color;
       blockSettings['border_color'] = color;
  }
  else if(foregroundColor) {
   activeColorElement.style.color = color;
   blockSettings['fg'] = color; 
  }
}

function setFontSize() {
    var form = _dom('fontSel');
    var types = form['font_size_type'];
    var type = 'pt';
    for(var i = 0; i < types.length; i++) {
        if(types[i].checked) {
            type = types[i].value;
            break;
        }
    }
   var size = form['font_size'].value + type;
   _dom('user_block').style.fontSize = size;
   blockSettings['font_size'] = size;
}

function setFont() {
    var select = _dom('fonts_styles');
    var font = FontOptions.options[select.selectedIndex].value;
    _dom('user_block').style.fontFamily = font;
    blockSettings['font_family'] = font;

}

function setBlockWidth() {
   var width = _dom('block_width').value + '%';
   blockSettings['block_width'] = width;
  _dom('user_block').style.width = width;
}

function setBlockAlignLeft() {
 var left = _dom('block_align_left').value;
 _dom('user_block').style.marginLeft = left  + 'px';  
  blockSettings['block_align'] = left ;
}

function setBlockAlign(align) {

  if(align == 'c') {
     _dom('user_block').style.margin = 'auto';

  }
  else if (align == 'r'){
     _dom('user_block').style.float = 'right';  
  }

  _dom('block_align_left').value = '';
  _dom('user_block').style.marginLeft = '';  
  blockSettings['block_align'] = align;
  
}

function setCorners() {
	var dom = document.getElementById('rounded');
	if(dom.checked) {
		blockSettings['corners'] = 'rounded';
	}
	else {
		blockSettings['corners'] = '';
		}
}	

function createBock() {
/*   Example:  
    80:0:rgb(102, 51, 255);rgb(255, 255, 153);2px dashed rgb(255, 102, 255);Comic Sans MS /10pt 
*/
 var styles = 
  blockSettings['block_width'] + ':' +
  blockSettings['block_align'] + ':' +
  blockSettings['bg'] + ';' +
  blockSettings['fg'] + ';' +
  blockSettings['border_width'] + ' ' + blockSettings['border_style'] + ' '
                        + blockSettings['border_color'] + ';' +
  blockSettings['font_family'] + '/' + blockSettings['font_size'];
  
 styles+=  blockSettings['corners'];
window.opener.createBlock(styles);
window.close();

}

//]]>
		</script>
<Title></Title>
</HEAD>
<BODY>

<!--?php

? -->
<style type="text/css">
#block_display { padding: 1em; margin:auto; border: 4px #bbbbbb inset; height: 350px; width: 500px; overflow:auto;}
#user_block {  border:1px gray dashed;  margin:auto; width: 90%; height: 90%;}
a.close { color: gray; font-size: 8pt; font-weight:bold; text-decoration:none; }
body, button, input { font-size: 9pt; }
#BlockBorder, #ColorChart, #FontSelection { display: none; }
#MainPanel,#BlockBorder,#ColorChart,#FontSelection { padding: 1em; }
input.eightpoint { font-size: 8pt; }
td.colorchart
{
   width:16px;
   height:12px;
}
</style>



<div id="block_display">
<div id='user_block' >
</div>
</div>

    <div id="MainPanel">

    <form>
    <table width="90%" cellpadding="4px" border="0" align="center">
    <tr>
    <td>
    <input type='button' class="eightpoint"  value = "Border Style" 
       onclick="panelDisplay('BlockBorder')" >
    </td>
    <td align="center"><input type='button' class="eightpoint" value = "Text Color" 
       onclick="panelDisplay('ColorChart');setActiveFGElement('user_block');" >
    </td>
    <td align="left"><input type='button' class="eightpoint" value = "Background Color" 
       onclick="panelDisplay('ColorChart');setActiveBGElement('user_block');" >
   </td>
   <td align="left"><input type='button' class="eightpoint" value = "Font Selection" 
       onclick="panelDisplay('FontSelection');" >
   </td>
   </tr>
    <tr>
     <th>Block Width: </th>
     <td ><input type='text' size = "2" value='80' id = 'block_width' onchange="setBlockWidth();"
               name = 'block_width'> % of window
     </td>
	 <th>Rounded Corners:
	      <input type='checkbox' name='rounded' id='rounded' onchange="setCorners()">
	 </th>
	 <td></td>
   </tr>
   
    <tr>

    <th>Alignment: </th>   
     <td nowrap><input type='text' size = "2" value='10' id = 'block_align_left' 
                 onchange="setBlockAlignLeft();"
                 name = 'block_align_left'> px from left 
     <td><input  type="radio" id = 'block_center' onclick="setBlockAlign('c');"
                   name = 'block_align'> center
     <td><input type="radio" id = 'block_right' onclick="setBlockAlign('r');"
                  name = 'block_align'> right
    
     <tr> <td>
     <input type="button" class="eightpoint" value = "OK" onclick="createBock();">
     </td>     
     <td>
      <input type="button" class="eightpoint" value = "Cancel" onclick="window.close();">
     </td>
     </tr>
    </table>
    </form>
    </div>

    
    <div id="FontSelection">

    <form id='fontSel' name="fontSel" >
    <table width="100%" cellpadding="8px"><tr><th align="left" style="font-size:9pt;">Font Selection
    <td alight="right"><a href="javascript:  panelDisplay('MainPanel'); void 0;"
             class='close' class='close'>close</a>
    </table>

     <input type='text' size = "2" value='9' id = 'font_size' name = 'font_size' 
            onchange= "setFontSize()">&nbsp;&nbsp;&nbsp;
     <input type='radio' value='pt' id = 'font_pt' onclick= "setFontSize()"
                   name = 'font_size_type' checked> pt&nbsp;&nbsp;&nbsp;
     <input type='radio' value='px' id = 'font_px' onclick= "setFontSize()"
                    name = 'font_size_type'> px&nbsp;&nbsp;&nbsp;
     <input type='radio' value='em' id = 'font_em' onclick= "setFontSize()"
                    name = 'font_size_type'> em     
<p>
			<select id="fonts_styles" name="fonts_styles" onchange="setFont();">
            <option value="none">
           </select>
</p>

    </form>
    </div>


    <div id="BlockBorder">
    <form>
  
    <div id="heading">
    <table width="100%" cellpadding="8px"><tr><th align="left" style="font-size:9pt;">Border Attributes
    <td alight="right"><a href="javascript:  panelDisplay('MainPanel'); void 0;"
             class='close' class='close'>close</a>
    </table>
    </div>  <!--  End of heading -->

      
    &nbsp;Width:&nbsp; 
            <input type='text' size = "2" value='4' id = 'border_width' onchange = "setBorderWidth();"               
             name = 'border_width'> px
    &nbsp;&nbsp;&nbsp;&nbsp;
            <input type='button' name='border_color' value = "Color" class="eightpoint" 
            onclick="setBorderColor('user_block');" >

    &nbsp;&nbsp;&nbsp;&nbsp; <input type='radio' name = 'border_style'  onclick="setBorderStyle('none')"  value='solid'> remove border

    <table cellspacing="8">
    <td style='border-top: #3B3B1F solid 2px; color #3B3B1F;'>
       <input type='radio' name = 'border_style'  onclick="setBorderStyle('solid')"  value='solid'> solid 
    <td style='border-top: #3B3B1F dotted 2px; color #3B3B1F;'>
       <input type='radio' name = 'border_style' id = 'dotted' onclick="setBorderStyle('dotted')" value='dotted'> dotted
    <td style='border-top: #3B3B1F dashed 2px; color #3B3B1F;'>
        <input type='radio' name = 'border_style' id = 'dashed' onclick="setBorderStyle('dashed')" value='dashed'> dashed 
    <td style='border-top: #3B3B1F double 6px; color #3B3B1F;'>
       <input type='radio' name = 'border_style' id = 'double' onclick="setBorderStyle('double')" value='double'>  double    
    </tr>

    <tr>    
    <td style='border-bottom: #cccccc groove 8px; color #3B3B1F;'>
        <input type='radio' name = 'border_style' onclick="setBorderStyle('groove')" value='groove'>  groove 
    <td style='border: #cccccc inset 4px; color #3B3B1F;'>
        <input type='radio' name = 'border_style' onclick="setBorderStyle('inset')" value='inset'> inset
    <td style='border: #cccccc outset 4px; color #3B3B1F;'>
        <input type='radio' name = 'border_style' onclick="setBorderStyle('outset')" value='outset'> outset 
    <td style='border-bottom: #cccccc ridge 8px; color #3B3B1F;'>
        <input type='radio' name = 'border_style' onclick="setBorderStyle('ridge')" value='ridge'> ridge
    </tr></table>
   
   
   </form>
    </div>  <!-- End BlockBorder -->

<div id="ColorChart">
    <div id="c_heading">
    <table width="100%" cellpadding="8px"><tr><th align="left" style="font-size:9pt;">Color Charts
    <td alight="right"><a href="javascript:  panelDisplay('MainPanel'); void 0;"
             class='close' class='close'>close</a>
    </table>
    </div>  <!--  End of c_heading -->
<table cellspacing="1" align="center" cellpadding="0" style="margin-top:6px;margin-bottom:0px;background-color:#444444;">
<tr>
<td class="colorchart" style="background-color:#330000" onClick="colorsAll('330000')" title="330000"></td>
<td class="colorchart" style="background-color:#333300" onClick="colorsAll('333300')" title="333300"></td>

<td class="colorchart" style="background-color:#336600" onClick="colorsAll('336600')" title="336600"></td>
<td class="colorchart" style="background-color:#339900" onClick="colorsAll('339900')" title="339900"></td>
<td class="colorchart" style="background-color:#33CC00" onClick="colorsAll('33CC00')" title="33CC00"></td>
<td class="colorchart" style="background-color:#33FF00" onClick="colorsAll('33FF00')" title="33FF00"></td>
<td class="colorchart" style="background-color:#66FF00" onClick="colorsAll('66FF00')" title="66FF00"></td>
<td class="colorchart" style="background-color:#66CC00" onClick="colorsAll('66CC00')" title="66CC00"></td>
<td class="colorchart" style="background-color:#669900" onClick="colorsAll('669900')" title="669900"></td>
<td class="colorchart" style="background-color:#666600" onClick="colorsAll('666600')" title="666600"></td>
<td class="colorchart" style="background-color:#663300" onClick="colorsAll('663300')" title="663300"></td>
<td class="colorchart" style="background-color:#660000" onClick="colorsAll('660000')" title="660000"></td>
<td class="colorchart" style="background-color:#FF0000" onClick="colorsAll('FF0000')" title="FF0000"></td>
<td class="colorchart" style="background-color:#FF3300" onClick="colorsAll('FF3300')" title="FF3300"></td>
<td class="colorchart" style="background-color:#FF6600" onClick="colorsAll('FF6600')" title="FF6600"></td>
<td class="colorchart" style="background-color:#FF9900" onClick="colorsAll('FF9900')" title="FF9900"></td>
<td class="colorchart" style="background-color:#FFCC00" onClick="colorsAll('FFCC00')" title="FFCC00"></td>
<td class="colorchart" style="background-color:#FFFF00" onClick="colorsAll('FFFF00')" title="FFFF00"></td>
</tr><tr>
<td class="colorchart" style="background-color:#330033" onClick="colorsAll('330033')" title="330033"></td>
<td class="colorchart" style="background-color:#333333" onClick="colorsAll('333333')" title="333333"></td>
<td class="colorchart" style="background-color:#336633" onClick="colorsAll('336633')" title="336633"></td>
<td class="colorchart" style="background-color:#339933" onClick="colorsAll('339933')" title="339933"></td>
<td class="colorchart" style="background-color:#33CC33" onClick="colorsAll('33CC33')" title="33CC33"></td>
<td class="colorchart" style="background-color:#33FF33" onClick="colorsAll('33FF33')" title="33FF33"></td>
<td class="colorchart" style="background-color:#66FF33" onClick="colorsAll('66FF33')" title="66FF33"></td>
<td class="colorchart" style="background-color:#66CC33" onClick="colorsAll('66CC33')" title="66CC33"></td>
<td class="colorchart" style="background-color:#669933" onClick="colorsAll('669933')" title="669933"></td>
<td class="colorchart" style="background-color:#666633" onClick="colorsAll('666633')" title="666633"></td>
<td class="colorchart" style="background-color:#663333" onClick="colorsAll('663333')" title="663333"></td>
<td class="colorchart" style="background-color:#660033" onClick="colorsAll('660033')" title="660033"></td>
<td class="colorchart" style="background-color:#FF0033" onClick="colorsAll('FF0033')" title="FF0033"></td>
<td class="colorchart" style="background-color:#FF3333" onClick="colorsAll('FF3333')" title="FF3333"></td>
<td class="colorchart" style="background-color:#FF6633" onClick="colorsAll('FF6633')" title="FF6633"></td>
<td class="colorchart" style="background-color:#FF9933" onClick="colorsAll('FF9933')" title="FF9933"></td>
<td class="colorchart" style="background-color:#FFCC33" onClick="colorsAll('FFCC33')" title="FFCC33"></td>
<td class="colorchart" style="background-color:#FFFF33" onClick="colorsAll('FFFF33')" title="FFFF33"></td>
</tr><tr>
<td class="colorchart" style="background-color:#330066" onClick="colorsAll('330066')" title="330066"></td>
<td class="colorchart" style="background-color:#333366" onClick="colorsAll('333366')" title="333366"></td>
<td class="colorchart" style="background-color:#336666" onClick="colorsAll('336666')" title="336666"></td>
<td class="colorchart" style="background-color:#339966" onClick="colorsAll('339966')" title="339966"></td>
<td class="colorchart" style="background-color:#33CC66" onClick="colorsAll('33CC66')" title="33CC66"></td>
<td class="colorchart" style="background-color:#33FF66" onClick="colorsAll('33FF66')" title="33FF66"></td>
<td class="colorchart" style="background-color:#66FF66" onClick="colorsAll('66FF66')" title="66FF66"></td>
<td class="colorchart" style="background-color:#66CC66" onClick="colorsAll('66CC66')" title="66CC66"></td>
<td class="colorchart" style="background-color:#669966" onClick="colorsAll('669966')" title="669966"></td>
<td class="colorchart" style="background-color:#666666" onClick="colorsAll('666666')" title="666666"></td>
<td class="colorchart" style="background-color:#663366" onClick="colorsAll('663366')" title="663366"></td>
<td class="colorchart" style="background-color:#660066" onClick="colorsAll('660066')" title="660066"></td>
<td class="colorchart" style="background-color:#FF0066" onClick="colorsAll('FF0066')" title="FF0066"></td>
<td class="colorchart" style="background-color:#FF3366" onClick="colorsAll('FF3366')" title="FF3366"></td>
<td class="colorchart" style="background-color:#FF6666" onClick="colorsAll('FF6666')" title="FF6666"></td>
<td class="colorchart" style="background-color:#FF9966" onClick="colorsAll('FF9966')" title="FF9966"></td>
<td class="colorchart" style="background-color:#FFCC66" onClick="colorsAll('FFCC66')" title="FFCC66"></td>
<td class="colorchart" style="background-color:#FFFF66" onClick="colorsAll('FFFF66')" title="FFFF66"></td>
</tr><tr>
<td class="colorchart" style="background-color:#330099" onClick="colorsAll('330099')" title="330099"></td>
<td class="colorchart" style="background-color:#333399" onClick="colorsAll('333399')" title="333399"></td>
<td class="colorchart" style="background-color:#336699" onClick="colorsAll('336699')" title="336699"></td>
<td class="colorchart" style="background-color:#339999" onClick="colorsAll('339999')" title="339999"></td>
<td class="colorchart" style="background-color:#33CC99" onClick="colorsAll('33CC99')" title="33CC99"></td>
<td class="colorchart" style="background-color:#33FF99" onClick="colorsAll('33FF99')" title="33FF99"></td>
<td class="colorchart" style="background-color:#66FF99" onClick="colorsAll('66FF99')" title="66FF99"></td>
<td class="colorchart" style="background-color:#66CC99" onClick="colorsAll('66CC99')" title="66CC99"></td>
<td class="colorchart" style="background-color:#669999" onClick="colorsAll('669999')" title="669999"></td>
<td class="colorchart" style="background-color:#666699" onClick="colorsAll('666699')" title="666699"></td>
<td class="colorchart" style="background-color:#663399" onClick="colorsAll('663399')" title="663399"></td>
<td class="colorchart" style="background-color:#660099" onClick="colorsAll('660099')" title="660099"></td>
<td class="colorchart" style="background-color:#FF0099" onClick="colorsAll('FF0099')" title="FF0099"></td>
<td class="colorchart" style="background-color:#FF3399" onClick="colorsAll('FF3399')" title="FF3399"></td>
<td class="colorchart" style="background-color:#FF6699" onClick="colorsAll('FF6699')" title="FF6699"></td>
<td class="colorchart" style="background-color:#FF9999" onClick="colorsAll('FF9999')" title="FF9999"></td>
<td class="colorchart" style="background-color:#FFCC99" onClick="colorsAll('FFCC99')" title="FFCC99"></td>
<td class="colorchart" style="background-color:#FFFF99" onClick="colorsAll('FFFF99')" title="FFFF99"></td>
</tr><tr>
<td class="colorchart" style="background-color:#3300CC" onClick="colorsAll('3300CC')" title="3300CC"></td>
<td class="colorchart" style="background-color:#3333CC" onClick="colorsAll('3333CC')" title="3333CC"></td>
<td class="colorchart" style="background-color:#3366CC" onClick="colorsAll('3366CC')" title="3366CC"></td>
<td class="colorchart" style="background-color:#3399CC" onClick="colorsAll('3399CC')" title="3399CC"></td>
<td class="colorchart" style="background-color:#33CCCC" onClick="colorsAll('33CCCC')" title="33CCCC"></td>
<td class="colorchart" style="background-color:#33FFCC" onClick="colorsAll('33FFCC')" title="33FFCC"></td>
<td class="colorchart" style="background-color:#66FFCC" onClick="colorsAll('66FFCC')" title="66FFCC"></td>
<td class="colorchart" style="background-color:#66CCCC" onClick="colorsAll('66CCCC')" title="66CCCC"></td>
<td class="colorchart" style="background-color:#6699CC" onClick="colorsAll('6699CC')" title="6699CC"></td>
<td class="colorchart" style="background-color:#6666CC" onClick="colorsAll('6666CC')" title="6666CC"></td>
<td class="colorchart" style="background-color:#6633CC" onClick="colorsAll('6633CC')" title="6633CC"></td>
<td class="colorchart" style="background-color:#6600CC" onClick="colorsAll('6600CC')" title="6600CC"></td>
<td class="colorchart" style="background-color:#FF00CC" onClick="colorsAll('FF00CC')" title="FF00CC"></td>
<td class="colorchart" style="background-color:#FF33CC" onClick="colorsAll('FF33CC')" title="FF33CC"></td>
<td class="colorchart" style="background-color:#FF66CC" onClick="colorsAll('FF66CC')" title="FF66CC"></td>
<td class="colorchart" style="background-color:#FF99CC" onClick="colorsAll('FF99CC')" title="FF99CC"></td>
<td class="colorchart" style="background-color:#FFCCCC" onClick="colorsAll('FFCCCC')" title="FFCCCC"></td>
<td class="colorchart" style="background-color:#FFFFCC" onClick="colorsAll('FFFFCC')" title="FFFFCC"></td>
</tr><tr>
<td class="colorchart" style="background-color:#3300FF" onClick="colorsAll('3300FF')" title="3300FF"></td>
<td class="colorchart" style="background-color:#3333FF" onClick="colorsAll('3333FF')" title="3333FF"></td>
<td class="colorchart" style="background-color:#3366FF" onClick="colorsAll('3366FF')" title="3366FF"></td>
<td class="colorchart" style="background-color:#3399FF" onClick="colorsAll('3399FF')" title="3399FF"></td>
<td class="colorchart" style="background-color:#33CCFF" onClick="colorsAll('33CCFF')" title="33CCFF"></td>
<td class="colorchart" style="background-color:#33FFFF" onClick="colorsAll('33FFFF')" title="33FFFF"></td>
<td class="colorchart" style="background-color:#66FFFF" onClick="colorsAll('66FFFF')" title="66FFFF"></td>
<td class="colorchart" style="background-color:#66CCFF" onClick="colorsAll('66CCFF')" title="66CCFF"></td>
<td class="colorchart" style="background-color:#6699FF" onClick="colorsAll('6699FF')" title="6699FF"></td>
<td class="colorchart" style="background-color:#6666FF" onClick="colorsAll('6666FF')" title="6666FF"></td>
<td class="colorchart" style="background-color:#6633FF" onClick="colorsAll('6633FF')" title="6633FF"></td>
<td class="colorchart" style="background-color:#6600FF" onClick="colorsAll('6600FF')" title="6600FF"></td>
<td class="colorchart" style="background-color:#FF00FF" onClick="colorsAll('FF00FF')" title="FF00FF"></td>
<td class="colorchart" style="background-color:#FF33FF" onClick="colorsAll('FF33FF')" title="FF33FF"></td>
<td class="colorchart" style="background-color:#FF66FF" onClick="colorsAll('FF66FF')" title="FF66FF"></td>
<td class="colorchart" style="background-color:#FF99FF" onClick="colorsAll('FF99FF')" title="FF99FF"></td>
<td class="colorchart" style="background-color:#FFCCFF" onClick="colorsAll('FFCCFF')" title="FFCCFF"></td>
<td class="colorchart" style="background-color:#FFFFFF" onClick="colorsAll('FFFFFF')" title="FFFFFF"></td>
</tr><tr>
<td class="colorchart" style="background-color:#0000FF" onClick="colorsAll('0000FF')" title="0000FF"></td>
<td class="colorchart" style="background-color:#0033FF" onClick="colorsAll('0033FF')" title="0033FF"></td>
<td class="colorchart" style="background-color:#0066FF" onClick="colorsAll('0066FF')" title="0066FF"></td>
<td class="colorchart" style="background-color:#0099FF" onClick="colorsAll('0099FF')" title="0099FF"></td>
<td class="colorchart" style="background-color:#00CCFF" onClick="colorsAll('00CCFF')" title="00CCFF"></td>
<td class="colorchart" style="background-color:#00FFFF" onClick="colorsAll('00FFFF')" title="00FFFF"></td>
<td class="colorchart" style="background-color:#99FFFF" onClick="colorsAll('99FFFF')" title="99FFFF"></td>
<td class="colorchart" style="background-color:#99CCFF" onClick="colorsAll('99CCFF')" title="99CCFF"></td>
<td class="colorchart" style="background-color:#9999FF" onClick="colorsAll('9999FF')" title="9999FF"></td>
<td class="colorchart" style="background-color:#9966FF" onClick="colorsAll('9966FF')" title="9966FF"></td>
<td class="colorchart" style="background-color:#9933FF" onClick="colorsAll('9933FF')" title="9933FF"></td>
<td class="colorchart" style="background-color:#9900FF" onClick="colorsAll('9900FF')" title="9900FF"></td>
<td class="colorchart" style="background-color:#CC00FF" onClick="colorsAll('CC00FF')" title="CC00FF"></td>
<td class="colorchart" style="background-color:#CC33FF" onClick="colorsAll('CC33FF')" title="CC33FF"></td>
<td class="colorchart" style="background-color:#CC66FF" onClick="colorsAll('CC66FF')" title="CC66FF"></td>
<td class="colorchart" style="background-color:#CC99FF" onClick="colorsAll('CC99FF')" title="CC99FF"></td>
<td class="colorchart" style="background-color:#CCCCFF" onClick="colorsAll('CCCCFF')" title="CCCCFF"></td>
<td class="colorchart" style="background-color:#CCFFFF" onClick="colorsAll('CCFFFF')" title="CCFFFF"></td>
</tr><tr>
<td class="colorchart" style="background-color:#0000CC" onClick="colorsAll('0000CC')" title="0000CC"></td>
<td class="colorchart" style="background-color:#0033CC" onClick="colorsAll('0033CC')" title="0033CC"></td>
<td class="colorchart" style="background-color:#0066CC" onClick="colorsAll('0066CC')" title="0066CC"></td>
<td class="colorchart" style="background-color:#0099CC" onClick="colorsAll('0099CC')" title="0099CC"></td>
<td class="colorchart" style="background-color:#00CCCC" onClick="colorsAll('00CCCC')" title="00CCCC"></td>
<td class="colorchart" style="background-color:#00FFCC" onClick="colorsAll('00FFCC')" title="00FFCC"></td>
<td class="colorchart" style="background-color:#99FFCC" onClick="colorsAll('99FFCC')" title="99FFCC"></td>
<td class="colorchart" style="background-color:#99CCCC" onClick="colorsAll('99CCCC')" title="99CCCC"></td>
<td class="colorchart" style="background-color:#9999CC" onClick="colorsAll('9999CC')" title="9999CC"></td>
<td class="colorchart" style="background-color:#9966CC" onClick="colorsAll('9966CC')" title="9966CC"></td>
<td class="colorchart" style="background-color:#9933CC" onClick="colorsAll('9933CC')" title="9933CC"></td>
<td class="colorchart" style="background-color:#9900CC" onClick="colorsAll('9900CC')" title="9900CC"></td>
<td class="colorchart" style="background-color:#CC00CC" onClick="colorsAll('CC00CC')" title="CC00CC"></td>
<td class="colorchart" style="background-color:#CC33CC" onClick="colorsAll('CC33CC')" title="CC33CC"></td>
<td class="colorchart" style="background-color:#CC66CC" onClick="colorsAll('CC66CC')" title="CC66CC"></td>
<td class="colorchart" style="background-color:#CC99CC" onClick="colorsAll('CC99CC')" title="CC99CC"></td>
<td class="colorchart" style="background-color:#CCCCCC" onClick="colorsAll('CCCCCC')" title="CCCCCC"></td>
<td class="colorchart" style="background-color:#CCFFCC" onClick="colorsAll('CCFFCC')" title="CCFFCC"></td>
</tr><tr>
<td class="colorchart" style="background-color:#000099" onClick="colorsAll('000099')" title="000099"></td>
<td class="colorchart" style="background-color:#003399" onClick="colorsAll('003399')" title="003399"></td>
<td class="colorchart" style="background-color:#006699" onClick="colorsAll('006699')" title="006699"></td>
<td class="colorchart" style="background-color:#009999" onClick="colorsAll('009999')" title="009999"></td>
<td class="colorchart" style="background-color:#00CC99" onClick="colorsAll('00CC99')" title="00CC99"></td>
<td class="colorchart" style="background-color:#00FF99" onClick="colorsAll('00FF99')" title="00FF99"></td>
<td class="colorchart" style="background-color:#99FF99" onClick="colorsAll('99FF99')" title="99FF99"></td>
<td class="colorchart" style="background-color:#99CC99" onClick="colorsAll('99CC99')" title="99CC99"></td>
<td class="colorchart" style="background-color:#999999" onClick="colorsAll('999999')" title="999999"></td>
<td class="colorchart" style="background-color:#996699" onClick="colorsAll('996699')" title="996699"></td>
<td class="colorchart" style="background-color:#993399" onClick="colorsAll('993399')" title="993399"></td>
<td class="colorchart" style="background-color:#990099" onClick="colorsAll('990099')" title="990099"></td>
<td class="colorchart" style="background-color:#CC0099" onClick="colorsAll('CC0099')" title="CC0099"></td>
<td class="colorchart" style="background-color:#CC3399" onClick="colorsAll('CC3399')" title="CC3399"></td>
<td class="colorchart" style="background-color:#CC6699" onClick="colorsAll('CC6699')" title="CC6699"></td>
<td class="colorchart" style="background-color:#CC9999" onClick="colorsAll('CC9999')" title="CC9999"></td>
<td class="colorchart" style="background-color:#CCCC99" onClick="colorsAll('CCCC99')" title="CCCC99"></td>
<td class="colorchart" style="background-color:#CCFF99" onClick="colorsAll('CCFF99')" title="CCFF99"></td>
</tr><tr>
<td class="colorchart" style="background-color:#000066" onClick="colorsAll('000066')" title="000066"></td>
<td class="colorchart" style="background-color:#003366" onClick="colorsAll('003366')" title="003366"></td>
<td class="colorchart" style="background-color:#006666" onClick="colorsAll('006666')" title="006666"></td>
<td class="colorchart" style="background-color:#009966" onClick="colorsAll('009966')" title="009966"></td>
<td class="colorchart" style="background-color:#00CC66" onClick="colorsAll('00CC66')" title="00CC66"></td>
<td class="colorchart" style="background-color:#00FF66" onClick="colorsAll('00FF66')" title="00FF66"></td>
<td class="colorchart" style="background-color:#99FF66" onClick="colorsAll('99FF66')" title="99FF66"></td>
<td class="colorchart" style="background-color:#99CC66" onClick="colorsAll('99CC66')" title="99CC66"></td>
<td class="colorchart" style="background-color:#999966" onClick="colorsAll('999966')" title="999966"></td>
<td class="colorchart" style="background-color:#996666" onClick="colorsAll('996666')" title="996666"></td>
<td class="colorchart" style="background-color:#993366" onClick="colorsAll('993366')" title="993366"></td>
<td class="colorchart" style="background-color:#990066" onClick="colorsAll('990066')" title="990066"></td>
<td class="colorchart" style="background-color:#CC0066" onClick="colorsAll('CC0066')" title="CC0066"></td>
<td class="colorchart" style="background-color:#CC3366" onClick="colorsAll('CC3366')" title="CC3366"></td>
<td class="colorchart" style="background-color:#CC6666" onClick="colorsAll('CC6666')" title="CC6666"></td>
<td class="colorchart" style="background-color:#CC9966" onClick="colorsAll('CC9966')" title="CC9966"></td>
<td class="colorchart" style="background-color:#CCCC66" onClick="colorsAll('CCCC66')" title="CCCC66"></td>
<td class="colorchart" style="background-color:#CCFF66" onClick="colorsAll('CCFF66')" title="CCFF66"></td>
</tr><tr>
<td class="colorchart" style="background-color:#000033" onClick="colorsAll('000033')" title="000033"></td>
<td class="colorchart" style="background-color:#003333" onClick="colorsAll('003333')" title="003333"></td>
<td class="colorchart" style="background-color:#006633" onClick="colorsAll('006633')" title="006633"></td>
<td class="colorchart" style="background-color:#009933" onClick="colorsAll('009933')" title="009933"></td>
<td class="colorchart" style="background-color:#00CC33" onClick="colorsAll('00CC33')" title="00CC33"></td>
<td class="colorchart" style="background-color:#00FF33" onClick="colorsAll('00FF33')" title="00FF33"></td>
<td class="colorchart" style="background-color:#99FF33" onClick="colorsAll('99FF33')" title="99FF33"></td>
<td class="colorchart" style="background-color:#99CC33" onClick="colorsAll('99CC33')" title="99CC33"></td>
<td class="colorchart" style="background-color:#999933" onClick="colorsAll('999933')" title="999933"></td>
<td class="colorchart" style="background-color:#996633" onClick="colorsAll('996633')" title="996633"></td>
<td class="colorchart" style="background-color:#993333" onClick="colorsAll('993333')" title="993333"></td>
<td class="colorchart" style="background-color:#990033" onClick="colorsAll('990033')" title="990033"></td>
<td class="colorchart" style="background-color:#CC0033" onClick="colorsAll('CC0033')" title="CC0033"></td>
<td class="colorchart" style="background-color:#CC3333" onClick="colorsAll('CC3333')" title="CC3333"></td>
<td class="colorchart" style="background-color:#CC6633" onClick="colorsAll('CC6633')" title="CC6633"></td>
<td class="colorchart" style="background-color:#CC9933" onClick="colorsAll('CC9933')" title="CC9933"></td>
<td class="colorchart" style="background-color:#CCCC33" onClick="colorsAll('CCCC33')" title="CCCC33"></td>
<td class="colorchart" style="background-color:#CCFF33" onClick="colorsAll('CCFF33')" title="CCFF33"></td>
</tr><tr>
<td class="colorchart" style="background-color:#000000" onClick="colorsAll('000000')" title="000000"></td>
<td class="colorchart" style="background-color:#003300" onClick="colorsAll('003300')" title="003300"></td>
<td class="colorchart" style="background-color:#006600" onClick="colorsAll('006600')" title="006600"></td>
<td class="colorchart" style="background-color:#009900" onClick="colorsAll('009900')" title="009900"></td>
<td class="colorchart" style="background-color:#00CC00" onClick="colorsAll('00CC00')" title="00CC00"></td>
<td class="colorchart" style="background-color:#00FF00" onClick="colorsAll('00FF00')" title="00FF00"></td>
<td class="colorchart" style="background-color:#99FF00" onClick="colorsAll('99FF00')" title="99FF00"></td>
<td class="colorchart" style="background-color:#99CC00" onClick="colorsAll('99CC00')" title="99CC00"></td>
<td class="colorchart" style="background-color:#999900" onClick="colorsAll('999900')" title="999900"></td>
<td class="colorchart" style="background-color:#996600" onClick="colorsAll('996600')" title="996600"></td>
<td class="colorchart" style="background-color:#993300" onClick="colorsAll('993300')" title="993300"></td>
<td class="colorchart" style="background-color:#990000" onClick="colorsAll('990000')" title="990000"></td>
<td class="colorchart" style="background-color:#CC0000" onClick="colorsAll('CC0000')" title="CC0000"></td>
<td class="colorchart" style="background-color:#CC3300" onClick="colorsAll('CC3300')" title="CC3300"></td>
<td class="colorchart" style="background-color:#CC6600" onClick="colorsAll('CC6600')" title="CC6600"></td>
<td class="colorchart" style="background-color:#CC9900" onClick="colorsAll('CC9900')" title="CC9900"></td>
<td class="colorchart" style="background-color:#CCCC00" onClick="colorsAll('CCCC00')" title="CCCC00"></td>
<td class="colorchart" style="background-color:#CCFF00" onClick="colorsAll('CCFF00')" title="CCFF00"></td>
</tr><tr>
<td class="colorchart" style="background-color:#000000" onClick="colorsAll('000000')" title="000000"></td>
<td class="colorchart" style="background-color:#111111" onClick="colorsAll('111111')" title="111111"></td>
<td class="colorchart" style="background-color:#222222" onClick="colorsAll('222222')" title="222222"></td>
<td class="colorchart" style="background-color:#333333" onClick="colorsAll('333333')" title="333333"></td>
<td class="colorchart" style="background-color:#444444" onClick="colorsAll('444444')" title="444444"></td>
<td class="colorchart" style="background-color:#555555" onClick="colorsAll('555555')" title="555555"></td>
<td class="colorchart" style="background-color:#666666" onClick="colorsAll('666666')" title="666666"></td>
<td class="colorchart" style="background-color:#777777" onClick="colorsAll('777777')" title="777777"></td>
<td class="colorchart" style="background-color:#888888" onClick="colorsAll('888888')" title="888888"></td>
<td class="colorchart" style="background-color:#999999" onClick="colorsAll('999999')" title="999999"></td>
<td class="colorchart" style="background-color:#AAAAAA" onClick="colorsAll('AAAAAA')" title="AAAAAA"></td>
<td class="colorchart" style="background-color:#BBBBBB" onClick="colorsAll('BBBBBB')" title="BBBBBB"></td>
<td class="colorchart" style="background-color:#CCCCCC" onClick="colorsAll('CCCCCC')" title="CCCCCC"></td>
<td class="colorchart" style="background-color:#DDDDDD" onClick="colorsAll('DDDDDD')" title="DDDDDD"></td>
<td class="colorchart" style="background-color:#EEEEEE" onClick="colorsAll('EEEEEE')" title="EEEEEE"></td>
<td class="colorchart" style="background-color:#FFFFFF" onClick="colorsAll('FFFFFF')" title="FFFFFF"></td>
<td class="colorchart" style="background-color:#444444"></td>
<td class="colorchart" style="background-color:#444444"></td>
</tr>
</table>



<table cellspacing="1" align="center" cellpadding="0" style="margin-top:6px;margin-bottom:0px;background-color:#444444;">
<tr><td class="colorchart" style="background-color:#FF4848" onClick="colorsAll('FF4848')" title="#FF4848"></td>
<td class="colorchart" style="background-color:#FF68DD" onClick="colorsAll('FF68DD')" title="#FF68DD"></td>
<td class="colorchart" style="background-color:#FF62B0" onClick="colorsAll('FF62B0')" title="#FF62B0"></td>
<td class="colorchart" style="background-color:#FE67EB" onClick="colorsAll('FE67EB')" title="#FE67EB"></td>
<td class="colorchart" style="background-color:#E469FE" onClick="colorsAll('E469FE')" title="#E469FE"></td>
<td class="colorchart" style="background-color:#D568FD" onClick="colorsAll('D568FD')" title="#D568FD"></td>
<td class="colorchart" style="background-color:#9669FE" onClick="colorsAll('9669FE')" title="#9669FE"></td>
<td class="colorchart" style="background-color:#FF7575" onClick="colorsAll('FF7575')" title="#FF7575"></td>
<td class="colorchart" style="background-color:#FF79E1" onClick="colorsAll('FF79E1')" title="#FF79E1"></td>
<td class="colorchart" style="background-color:#FF73B9" onClick="colorsAll('FF73B9')" title="#FF73B9"></td>
<td class="colorchart" style="background-color:#FE67EB" onClick="colorsAll('FE67EB')" title="#FE67EB"></td>
<td class="colorchart" style="background-color:#E77AFE" onClick="colorsAll('E77AFE')" title="#E77AFE"></td>
<td class="colorchart" style="background-color:#D97BFD" onClick="colorsAll('D97BFD')" title="#D97BFD"></td>
<td class="colorchart" style="background-color:#A27AFE" onClick="colorsAll('A27AFE')" title="#A27AFE"></td>
<td class="colorchart" style="background-color:#FF8A8A" onClick="colorsAll('FF8A8A')" title="#FF8A8A"></td>
<td class="colorchart" style="background-color:#FF86E3" onClick="colorsAll('FF86E3')" title="#FF86E3"></td>
<td class="colorchart" style="background-color:#FF86C2" onClick="colorsAll('FF86C2')" title="#FF86C2"></td>
<td class="colorchart" style="background-color:#FE8BF0" onClick="colorsAll('FE8BF0')" title="#FE8BF0"></td>
<TR>
<td class="colorchart" style="background-color:#EA8DFE" onClick="colorsAll('EA8DFE')" title="#EA8DFE"></td>
<td class="colorchart" style="background-color:#DD88FD" onClick="colorsAll('DD88FD')" title="#DD88FD"></td>
<td class="colorchart" style="background-color:#AD8BFE" onClick="colorsAll('AD8BFE')" title="#AD8BFE"></td>
<td class="colorchart" style="background-color:#FF9797" onClick="colorsAll('FF9797')" title="#FF9797"></td>
<td class="colorchart" style="background-color:#FF97E8" onClick="colorsAll('FF97E8')" title="#FF97E8"></td>
<td class="colorchart" style="background-color:#FF97CB" onClick="colorsAll('FF97CB')" title="#FF97CB"></td>
<td class="colorchart" style="background-color:#FE98F1" onClick="colorsAll('FE98F1')" title="#FE98F1"></td>
<td class="colorchart" style="background-color:#ED9EFE" onClick="colorsAll('ED9EFE')" title="#ED9EFE"></td>
<td class="colorchart" style="background-color:#E29BFD" onClick="colorsAll('E29BFD')" title="#E29BFD"></td>
<td class="colorchart" style="background-color:#B89AFE" onClick="colorsAll('B89AFE')" title="#B89AFE"></td>
<td class="colorchart" style="background-color:#FFA8A8" onClick="colorsAll('FFA8A8')" title="#FFA8A8"></td>
<td class="colorchart" style="background-color:#FFACEC" onClick="colorsAll('FFACEC')" title="#FFACEC"></td>
<td class="colorchart" style="background-color:#FFA8D3" onClick="colorsAll('FFA8D3')" title="#FFA8D3"></td>
<td class="colorchart" style="background-color:#FEA9F3" onClick="colorsAll('FEA9F3')" title="#FEA9F3"></td>
<td class="colorchart" style="background-color:#EFA9FE" onClick="colorsAll('EFA9FE')" title="#EFA9FE"></td>
<td class="colorchart" style="background-color:#E7A9FE" onClick="colorsAll('E7A9FE')" title="#E7A9FE"></td>
<td class="colorchart" style="background-color:#C4ABFE" onClick="colorsAll('C4ABFE')" title="#C4ABFE"></td>
<td class="colorchart" style="background-color:#FFBBBB" onClick="colorsAll('FFBBBB')" title="#FFBBBB"></td>
<TR>
<td class="colorchart" style="background-color:#FFACEC" onClick="colorsAll('FFACEC')" title="#FFACEC"></td>
<td class="colorchart" style="background-color:#FFBBDD" onClick="colorsAll('FFBBDD')" title="#FFBBDD"></td>
<td class="colorchart" style="background-color:#FFBBF7" onClick="colorsAll('FFBBF7')" title="#FFBBF7"></td>
<td class="colorchart" style="background-color:#F2BCFE" onClick="colorsAll('F2BCFE')" title="#F2BCFE"></td>
<td class="colorchart" style="background-color:#EDBEFE" onClick="colorsAll('EDBEFE')" title="#EDBEFE"></td>
<td class="colorchart" style="background-color:#D0BCFE" onClick="colorsAll('D0BCFE')" title="#D0BCFE"></td>
<td class="colorchart" style="background-color:#FFCECE" onClick="colorsAll('FFCECE')" title="#FFCECE"></td>
<td class="colorchart" style="background-color:#FFC8F2" onClick="colorsAll('FFC8F2')" title="#FFC8F2"></td>
<td class="colorchart" style="background-color:#FFC8E3" onClick="colorsAll('FFC8E3')" title="#FFC8E3"></td>
<td class="colorchart" style="background-color:#FFCAF9" onClick="colorsAll('FFCAF9')" title="#FFCAF9"></td>
<td class="colorchart" style="background-color:#F5CAFF" onClick="colorsAll('F5CAFF')" title="#F5CAFF"></td>
<td class="colorchart" style="background-color:#F0CBFE" onClick="colorsAll('F0CBFE')" title="#F0CBFE"></td>
<td class="colorchart" style="background-color:#DDCEFF" onClick="colorsAll('DDCEFF')" title="#DDCEFF"></td>
<td class="colorchart" style="background-color:#FFDFDF" onClick="colorsAll('FFDFDF')" title="#FFDFDF"></td>
<td class="colorchart" style="background-color:#FFDFF8" onClick="colorsAll('FFDFF8')" title="#FFDFF8"></td>
<td class="colorchart" style="background-color:#FFDFEF" onClick="colorsAll('FFDFEF')" title="#FFDFEF"></td>
<td class="colorchart" style="background-color:#FFDBFB" onClick="colorsAll('FFDBFB')" title="#FFDBFB"></td>
<td class="colorchart" style="background-color:#F9D9FF" onClick="colorsAll('F9D9FF')" title="#F9D9FF"></td>
<TR>
<td class="colorchart" style="background-color:#F4DCFE" onClick="colorsAll('F4DCFE')" title="#F4DCFE"></td>
<td class="colorchart" style="background-color:#E6DBFF" onClick="colorsAll('E6DBFF')" title="#E6DBFF"></td>
<td class="colorchart" style="background-color:#FFECEC" onClick="colorsAll('FFECEC')" title="#FFECEC"></td>
<td class="colorchart" style="background-color:#FFEEFB" onClick="colorsAll('FFEEFB')" title="#FFEEFB"></td>
<td class="colorchart" style="background-color:#FFECF5" onClick="colorsAll('FFECF5')" title="#FFECF5"></td>
<td class="colorchart" style="background-color:#FFEEFD" onClick="colorsAll('FFEEFD')" title="#FFEEFD"></td>
<td class="colorchart" style="background-color:#FDF2FF" onClick="colorsAll('FDF2FF')" title="#FDF2FF"></td>
<td class="colorchart" style="background-color:#FAECFF" onClick="colorsAll('FAECFF')" title="#FAECFF"></td>
<td class="colorchart" style="background-color:#F1ECFF" onClick="colorsAll('F1ECFF')" title="#F1ECFF"></td>
<td class="colorchart" style="background-color:#FFF2F2" onClick="colorsAll('FFF2F2')" title="#FFF2F2"></td>
<td class="colorchart" style="background-color:#FFFEFB" onClick="colorsAll('FFFEFB')" title="#FFFEFB"></td>
<td class="colorchart" style="background-color:#FFF9FC" onClick="colorsAll('FFF9FC')" title="#FFF9FC"></td>
<td class="colorchart" style="background-color:#FFF9FE" onClick="colorsAll('FFF9FE')" title="#FFF9FE"></td>
<td class="colorchart" style="background-color:#FFFDFF" onClick="colorsAll('FFFDFF')" title="#FFFDFF"></td>
<td class="colorchart" style="background-color:#FDF9FF" onClick="colorsAll('FDF9FF')" title="#FDF9FF"></td>
<td class="colorchart" style="background-color:#FBF9FF" onClick="colorsAll('FBF9FF')" title="#FBF9FF"></td>
<td class="colorchart" style="background-color:#800080" onClick="colorsAll('800080')" title="#800080"></td>
<td class="colorchart" style="background-color:#872187" onClick="colorsAll('872187')" title="#872187"></td>
<TR>
<td class="colorchart" style="background-color:#9A03FE" onClick="colorsAll('9A03FE')" title="#9A03FE"></td>
<td class="colorchart" style="background-color:#892EE4" onClick="colorsAll('892EE4')" title="#892EE4"></td>
<td class="colorchart" style="background-color:#3923D6" onClick="colorsAll('3923D6')" title="#3923D6"></td>
<td class="colorchart" style="background-color:#2966B8" onClick="colorsAll('2966B8')" title="#2966B8"></td>
<td class="colorchart" style="background-color:#23819C" onClick="colorsAll('23819C')" title="#23819C"></td>
<td class="colorchart" style="background-color:#BF00BF" onClick="colorsAll('BF00BF')" title="#BF00BF"></td>
<td class="colorchart" style="background-color:#BC2EBC" onClick="colorsAll('BC2EBC')" title="#BC2EBC"></td>
<td class="colorchart" style="background-color:#A827FE" onClick="colorsAll('A827FE')" title="#A827FE"></td>
<td class="colorchart" style="background-color:#9B4EE9" onClick="colorsAll('9B4EE9')" title="#9B4EE9"></td>
<td class="colorchart" style="background-color:#6755E3" onClick="colorsAll('6755E3')" title="#6755E3"></td>
<td class="colorchart" style="background-color:#2F74D0" onClick="colorsAll('2F74D0')" title="#2F74D0"></td>
<td class="colorchart" style="background-color:#2897B7" onClick="colorsAll('2897B7')" title="#2897B7"></td>
<td class="colorchart" style="background-color:#DB00DB" onClick="colorsAll('DB00DB')" title="#DB00DB"></td>
<td class="colorchart" style="background-color:#D54FD5" onClick="colorsAll('D54FD5')" title="#D54FD5"></td>
<td class="colorchart" style="background-color:#B445FE" onClick="colorsAll('B445FE')" title="#B445FE"></td>
<td class="colorchart" style="background-color:#A55FEB" onClick="colorsAll('A55FEB')" title="#A55FEB"></td>
<td class="colorchart" style="background-color:#8678E9" onClick="colorsAll('8678E9')" title="#8678E9"></td>
<td class="colorchart" style="background-color:#4985D6" onClick="colorsAll('4985D6')" title="#4985D6"></td>
<TR>
<td class="colorchart" style="background-color:#2FAACE" onClick="colorsAll('2FAACE')" title="#2FAACE"></td>
<td class="colorchart" style="background-color:#F900F9" onClick="colorsAll('F900F9')" title="#F900F9"></td>
<td class="colorchart" style="background-color:#DD75DD" onClick="colorsAll('DD75DD')" title="#DD75DD"></td>
<td class="colorchart" style="background-color:#BD5CFE" onClick="colorsAll('BD5CFE')" title="#BD5CFE"></td>
<td class="colorchart" style="background-color:#AE70ED" onClick="colorsAll('AE70ED')" title="#AE70ED"></td>
<td class="colorchart" style="background-color:#9588EC" onClick="colorsAll('9588EC')" title="#9588EC"></td>
<td class="colorchart" style="background-color:#6094DB" onClick="colorsAll('6094DB')" title="#6094DB"></td>
<td class="colorchart" style="background-color:#44B4D5" onClick="colorsAll('44B4D5')" title="#44B4D5"></td>
<td class="colorchart" style="background-color:#FF4AFF" onClick="colorsAll('FF4AFF')" title="#FF4AFF"></td>
<td class="colorchart" style="background-color:#DD75DD" onClick="colorsAll('DD75DD')" title="#DD75DD"></td>
<td class="colorchart" style="background-color:#C269FE" onClick="colorsAll('C269FE')" title="#C269FE"></td>
<td class="colorchart" style="background-color:#AE70ED" onClick="colorsAll('AE70ED')" title="#AE70ED"></td>
<td class="colorchart" style="background-color:#A095EE" onClick="colorsAll('A095EE')" title="#A095EE"></td>
<td class="colorchart" style="background-color:#7BA7E1" onClick="colorsAll('7BA7E1')" title="#7BA7E1"></td>
<td class="colorchart" style="background-color:#57BCD9" onClick="colorsAll('57BCD9')" title="#57BCD9"></td>
<td class="colorchart" style="background-color:#FF86FF" onClick="colorsAll('FF86FF')" title="#FF86FF"></td>
<td class="colorchart" style="background-color:#E697E6" onClick="colorsAll('E697E6')" title="#E697E6"></td>
<td class="colorchart" style="background-color:#CD85FE" onClick="colorsAll('CD85FE')" title="#CD85FE"></td>
<TR>
<td class="colorchart" style="background-color:#C79BF2" onClick="colorsAll('C79BF2')" title="#C79BF2"></td>
<td class="colorchart" style="background-color:#B0A7F1" onClick="colorsAll('B0A7F1')" title="#B0A7F1"></td>
<td class="colorchart" style="background-color:#8EB4E6" onClick="colorsAll('8EB4E6')" title="#8EB4E6"></td>
<td class="colorchart" style="background-color:#7BCAE1" onClick="colorsAll('7BCAE1')" title="#7BCAE1"></td>
<td class="colorchart" style="background-color:#FFA4FF" onClick="colorsAll('FFA4FF')" title="#FFA4FF"></td>
<td class="colorchart" style="background-color:#EAA6EA" onClick="colorsAll('EAA6EA')" title="#EAA6EA"></td>
<td class="colorchart" style="background-color:#D698FE" onClick="colorsAll('D698FE')" title="#D698FE"></td>
<td class="colorchart" style="background-color:#CEA8F4" onClick="colorsAll('CEA8F4')" title="#CEA8F4"></td>
<td class="colorchart" style="background-color:#BCB4F3" onClick="colorsAll('BCB4F3')" title="#BCB4F3"></td>
<td class="colorchart" style="background-color:#A9C5EB" onClick="colorsAll('A9C5EB')" title="#A9C5EB"></td>
<td class="colorchart" style="background-color:#8CD1E6" onClick="colorsAll('8CD1E6')" title="#8CD1E6"></td>
<td class="colorchart" style="background-color:#FFBBFF" onClick="colorsAll('FFBBFF')" title="#FFBBFF"></td>
<td class="colorchart" style="background-color:#EEBBEE" onClick="colorsAll('EEBBEE')" title="#EEBBEE"></td>
<td class="colorchart" style="background-color:#DFB0FF" onClick="colorsAll('DFB0FF')" title="#DFB0FF"></td>
<td class="colorchart" style="background-color:#DBBFF7" onClick="colorsAll('DBBFF7')" title="#DBBFF7"></td>
<td class="colorchart" style="background-color:#CBC5F5" onClick="colorsAll('CBC5F5')" title="#CBC5F5"></td>
<td class="colorchart" style="background-color:#BAD0EF" onClick="colorsAll('BAD0EF')" title="#BAD0EF"></td>
<td class="colorchart" style="background-color:#A5DBEB" onClick="colorsAll('A5DBEB')" title="#A5DBEB"></td>
<TR>
<td class="colorchart" style="background-color:#FFCEFF" onClick="colorsAll('FFCEFF')" title="#FFCEFF"></td>
<td class="colorchart" style="background-color:#F0C4F0" onClick="colorsAll('F0C4F0')" title="#F0C4F0"></td>
<td class="colorchart" style="background-color:#E8C6FF" onClick="colorsAll('E8C6FF')" title="#E8C6FF"></td>
<td class="colorchart" style="background-color:#E1CAF9" onClick="colorsAll('E1CAF9')" title="#E1CAF9"></td>
<td class="colorchart" style="background-color:#D7D1F8" onClick="colorsAll('D7D1F8')" title="#D7D1F8"></td>
<td class="colorchart" style="background-color:#CEDEF4" onClick="colorsAll('CEDEF4')" title="#CEDEF4"></td>
<td class="colorchart" style="background-color:#B8E2EF" onClick="colorsAll('B8E2EF')" title="#B8E2EF"></td>
<td class="colorchart" style="background-color:#FFDFFF" onClick="colorsAll('FFDFFF')" title="#FFDFFF"></td>
<td class="colorchart" style="background-color:#F4D2F4" onClick="colorsAll('F4D2F4')" title="#F4D2F4"></td>
<td class="colorchart" style="background-color:#EFD7FF" onClick="colorsAll('EFD7FF')" title="#EFD7FF"></td>
<td class="colorchart" style="background-color:#EDDFFB" onClick="colorsAll('EDDFFB')" title="#EDDFFB"></td>
<td class="colorchart" style="background-color:#E3E0FA" onClick="colorsAll('E3E0FA')" title="#E3E0FA"></td>
<td class="colorchart" style="background-color:#E0EAF8" onClick="colorsAll('E0EAF8')" title="#E0EAF8"></td>
<td class="colorchart" style="background-color:#C9EAF3" onClick="colorsAll('C9EAF3')" title="#C9EAF3"></td>
<td class="colorchart" style="background-color:#FFECFF" onClick="colorsAll('FFECFF')" title="#FFECFF"></td>
<td class="colorchart" style="background-color:#F4D2F4" onClick="colorsAll('F4D2F4')" title="#F4D2F4"></td>
<td class="colorchart" style="background-color:#F9EEFF" onClick="colorsAll('F9EEFF')" title="#F9EEFF"></td>
<td class="colorchart" style="background-color:#F5EEFD" onClick="colorsAll('F5EEFD')" title="#F5EEFD"></td>
<TR>
<td class="colorchart" style="background-color:#EFEDFC" onClick="colorsAll('EFEDFC')" title="#EFEDFC"></td>
<td class="colorchart" style="background-color:#EAF1FB" onClick="colorsAll('EAF1FB')" title="#EAF1FB"></td>
<td class="colorchart" style="background-color:#DBF0F7" onClick="colorsAll('DBF0F7')" title="#DBF0F7"></td>
<td class="colorchart" style="background-color:#FFF9FF" onClick="colorsAll('FFF9FF')" title="#FFF9FF"></td>
<td class="colorchart" style="background-color:#FDF9FD" onClick="colorsAll('FDF9FD')" title="#FDF9FD"></td>
<td class="colorchart" style="background-color:#FEFDFF" onClick="colorsAll('FEFDFF')" title="#FEFDFF"></td>
<td class="colorchart" style="background-color:#FEFDFF" onClick="colorsAll('FEFDFF')" title="#FEFDFF"></td>
<td class="colorchart" style="background-color:#F7F5FE" onClick="colorsAll('F7F5FE')" title="#F7F5FE"></td>
<td class="colorchart" style="background-color:#F8FBFE" onClick="colorsAll('F8FBFE')" title="#F8FBFE"></td>
<td class="colorchart" style="background-color:#EAF7FB" onClick="colorsAll('EAF7FB')" title="#EAF7FB"></td>
<td class="colorchart" style="background-color:#5757FF" onClick="colorsAll('5757FF')" title="#5757FF"></td>
<td class="colorchart" style="background-color:#62A9FF" onClick="colorsAll('62A9FF')" title="#62A9FF"></td>
<td class="colorchart" style="background-color:#62D0FF" onClick="colorsAll('62D0FF')" title="#62D0FF"></td>
<td class="colorchart" style="background-color:#06DCFB" onClick="colorsAll('06DCFB')" title="#06DCFB"></td>
<td class="colorchart" style="background-color:#01FCEF" onClick="colorsAll('01FCEF')" title="#01FCEF"></td>
<td class="colorchart" style="background-color:#03EBA6" onClick="colorsAll('03EBA6')" title="#03EBA6"></td>
<td class="colorchart" style="background-color:#01F33E" onClick="colorsAll('01F33E')" title="#01F33E"></td>
<td class="colorchart" style="background-color:#6A6AFF" onClick="colorsAll('6A6AFF')" title="#6A6AFF"></td>
<TR>
<td class="colorchart" style="background-color:#75B4FF" onClick="colorsAll('75B4FF')" title="#75B4FF"></td>
<td class="colorchart" style="background-color:#75D6FF" onClick="colorsAll('75D6FF')" title="#75D6FF"></td>
<td class="colorchart" style="background-color:#24E0FB" onClick="colorsAll('24E0FB')" title="#24E0FB"></td>
<td class="colorchart" style="background-color:#1FFEF3" onClick="colorsAll('1FFEF3')" title="#1FFEF3"></td>
<td class="colorchart" style="background-color:#03F3AB" onClick="colorsAll('03F3AB')" title="#03F3AB"></td>
<td class="colorchart" style="background-color:#0AFE47" onClick="colorsAll('0AFE47')" title="#0AFE47"></td>
<td class="colorchart" style="background-color:#7979FF" onClick="colorsAll('7979FF')" title="#7979FF"></td>
<td class="colorchart" style="background-color:#86BCFF" onClick="colorsAll('86BCFF')" title="#86BCFF"></td>
<td class="colorchart" style="background-color:#8ADCFF" onClick="colorsAll('8ADCFF')" title="#8ADCFF"></td>
<td class="colorchart" style="background-color:#3DE4FC" onClick="colorsAll('3DE4FC')" title="#3DE4FC"></td>
<td class="colorchart" style="background-color:#5FFEF7" onClick="colorsAll('5FFEF7')" title="#5FFEF7"></td>
<td class="colorchart" style="background-color:#33FDC0" onClick="colorsAll('33FDC0')" title="#33FDC0"></td>
<td class="colorchart" style="background-color:#4BFE78" onClick="colorsAll('4BFE78')" title="#4BFE78"></td>
<td class="colorchart" style="background-color:#8C8CFF" onClick="colorsAll('8C8CFF')" title="#8C8CFF"></td>
<td class="colorchart" style="background-color:#99C7FF" onClick="colorsAll('99C7FF')" title="#99C7FF"></td>
<td class="colorchart" style="background-color:#99E0FF" onClick="colorsAll('99E0FF')" title="#99E0FF"></td>
<td class="colorchart" style="background-color:#63E9FC" onClick="colorsAll('63E9FC')" title="#63E9FC"></td>
<td class="colorchart" style="background-color:#74FEF8" onClick="colorsAll('74FEF8')" title="#74FEF8"></td>
<TR>
<td class="colorchart" style="background-color:#62FDCE" onClick="colorsAll('62FDCE')" title="#62FDCE"></td>
<td class="colorchart" style="background-color:#72FE95" onClick="colorsAll('72FE95')" title="#72FE95"></td>
<td class="colorchart" style="background-color:#9999FF" onClick="colorsAll('9999FF')" title="#9999FF"></td>
<td class="colorchart" style="background-color:#99C7FF" onClick="colorsAll('99C7FF')" title="#99C7FF"></td>
<td class="colorchart" style="background-color:#A8E4FF" onClick="colorsAll('A8E4FF')" title="#A8E4FF"></td>
<td class="colorchart" style="background-color:#75ECFD" onClick="colorsAll('75ECFD')" title="#75ECFD"></td>
<td class="colorchart" style="background-color:#92FEF9" onClick="colorsAll('92FEF9')" title="#92FEF9"></td>
<td class="colorchart" style="background-color:#7DFDD7" onClick="colorsAll('7DFDD7')" title="#7DFDD7"></td>
<td class="colorchart" style="background-color:#8BFEA8" onClick="colorsAll('8BFEA8')" title="#8BFEA8"></td>
<td class="colorchart" style="background-color:#AAAAFF" onClick="colorsAll('AAAAFF')" title="#AAAAFF"></td>
<td class="colorchart" style="background-color:#A8CFFF" onClick="colorsAll('A8CFFF')" title="#A8CFFF"></td>
<td class="colorchart" style="background-color:#BBEBFF" onClick="colorsAll('BBEBFF')" title="#BBEBFF"></td>
<td class="colorchart" style="background-color:#8CEFFD" onClick="colorsAll('8CEFFD')" title="#8CEFFD"></td>
<td class="colorchart" style="background-color:#A5FEFA" onClick="colorsAll('A5FEFA')" title="#A5FEFA"></td>
<td class="colorchart" style="background-color:#8FFEDD" onClick="colorsAll('8FFEDD')" title="#8FFEDD"></td>
<td class="colorchart" style="background-color:#A3FEBA" onClick="colorsAll('A3FEBA')" title="#A3FEBA"></td>
<td class="colorchart" style="background-color:#BBBBFF" onClick="colorsAll('BBBBFF')" title="#BBBBFF"></td>
<td class="colorchart" style="background-color:#BBDAFF" onClick="colorsAll('BBDAFF')" title="#BBDAFF"></td>
<TR>
<td class="colorchart" style="background-color:#CEF0FF" onClick="colorsAll('CEF0FF')" title="#CEF0FF"></td>
<td class="colorchart" style="background-color:#ACF3FD" onClick="colorsAll('ACF3FD')" title="#ACF3FD"></td>
<td class="colorchart" style="background-color:#B5FFFC" onClick="colorsAll('B5FFFC')" title="#B5FFFC"></td>
<td class="colorchart" style="background-color:#A5FEE3" onClick="colorsAll('A5FEE3')" title="#A5FEE3"></td>
<td class="colorchart" style="background-color:#B5FFC8" onClick="colorsAll('B5FFC8')" title="#B5FFC8"></td>
<td class="colorchart" style="background-color:#CACAFF" onClick="colorsAll('CACAFF')" title="#CACAFF"></td>
<td class="colorchart" style="background-color:#D0E6FF" onClick="colorsAll('D0E6FF')" title="#D0E6FF"></td>
<td class="colorchart" style="background-color:#D9F3FF" onClick="colorsAll('D9F3FF')" title="#D9F3FF"></td>
<td class="colorchart" style="background-color:#C0F7FE" onClick="colorsAll('C0F7FE')" title="#C0F7FE"></td>
<td class="colorchart" style="background-color:#CEFFFD" onClick="colorsAll('CEFFFD')" title="#CEFFFD"></td>
<td class="colorchart" style="background-color:#BEFEEB" onClick="colorsAll('BEFEEB')" title="#BEFEEB"></td>
<td class="colorchart" style="background-color:#CAFFD8" onClick="colorsAll('CAFFD8')" title="#CAFFD8"></td>
<td class="colorchart" style="background-color:#E1E1FF" onClick="colorsAll('E1E1FF')" title="#E1E1FF"></td>
<td class="colorchart" style="background-color:#DBEBFF" onClick="colorsAll('DBEBFF')" title="#DBEBFF"></td>
<td class="colorchart" style="background-color:#ECFAFF" onClick="colorsAll('ECFAFF')" title="#ECFAFF"></td>
<td class="colorchart" style="background-color:#C0F7FE" onClick="colorsAll('C0F7FE')" title="#C0F7FE"></td>
<td class="colorchart" style="background-color:#E1FFFE" onClick="colorsAll('E1FFFE')" title="#E1FFFE"></td>
<td class="colorchart" style="background-color:#BDFFEA" onClick="colorsAll('BDFFEA')" title="#BDFFEA"></td>
<TR>
<td class="colorchart" style="background-color:#EAFFEF" onClick="colorsAll('EAFFEF')" title="#EAFFEF"></td>
<td class="colorchart" style="background-color:#EEEEFF" onClick="colorsAll('EEEEFF')" title="#EEEEFF"></td>
<td class="colorchart" style="background-color:#ECF4FF" onClick="colorsAll('ECF4FF')" title="#ECF4FF"></td>
<td class="colorchart" style="background-color:#F9FDFF" onClick="colorsAll('F9FDFF')" title="#F9FDFF"></td>
<td class="colorchart" style="background-color:#E6FCFF" onClick="colorsAll('E6FCFF')" title="#E6FCFF"></td>
<td class="colorchart" style="background-color:#F2FFFE" onClick="colorsAll('F2FFFE')" title="#F2FFFE"></td>
<td class="colorchart" style="background-color:#CFFEF0" onClick="colorsAll('CFFEF0')" title="#CFFEF0"></td>
<td class="colorchart" style="background-color:#EAFFEF" onClick="colorsAll('EAFFEF')" title="#EAFFEF"></td>
<td class="colorchart" style="background-color:#F9F9FF" onClick="colorsAll('F9F9FF')" title="#F9F9FF"></td>
<td class="colorchart" style="background-color:#F9FCFF" onClick="colorsAll('F9FCFF')" title="#F9FCFF"></td>
<td class="colorchart" style="background-color:#FDFEFF" onClick="colorsAll('FDFEFF')" title="#FDFEFF"></td>
<td class="colorchart" style="background-color:#F9FEFF" onClick="colorsAll('F9FEFF')" title="#F9FEFF"></td>
<td class="colorchart" style="background-color:#FDFFFF" onClick="colorsAll('FDFFFF')" title="#FDFFFF"></td>
<td class="colorchart" style="background-color:#F7FFFD" onClick="colorsAll('F7FFFD')" title="#F7FFFD"></td>
<td class="colorchart" style="background-color:#F9FFFB" onClick="colorsAll('F9FFFB')" title="#F9FFFB"></td>
<td class="colorchart" style="background-color:#1FCB4A" onClick="colorsAll('1FCB4A')" title="#1FCB4A"></td>
<td class="colorchart" style="background-color:#59955C" onClick="colorsAll('59955C')" title="#59955C"></td>
<td class="colorchart" style="background-color:#48FB0D" onClick="colorsAll('48FB0D')" title="#48FB0D"></td>
<TR>
<td class="colorchart" style="background-color:#2DC800" onClick="colorsAll('2DC800')" title="#2DC800"></td>
<td class="colorchart" style="background-color:#59DF00" onClick="colorsAll('59DF00')" title="#59DF00"></td>
<td class="colorchart" style="background-color:#9D9D00" onClick="colorsAll('9D9D00')" title="#9D9D00"></td>
<td class="colorchart" style="background-color:#B6BA18" onClick="colorsAll('B6BA18')" title="#B6BA18"></td>
<td class="colorchart" style="background-color:#27DE55" onClick="colorsAll('27DE55')" title="#27DE55"></td>
<td class="colorchart" style="background-color:#6CA870" onClick="colorsAll('6CA870')" title="#6CA870"></td>
<td class="colorchart" style="background-color:#79FC4E" onClick="colorsAll('79FC4E')" title="#79FC4E"></td>
<td class="colorchart" style="background-color:#32DF00" onClick="colorsAll('32DF00')" title="#32DF00"></td>
<td class="colorchart" style="background-color:#61F200" onClick="colorsAll('61F200')" title="#61F200"></td>
<td class="colorchart" style="background-color:#C8C800" onClick="colorsAll('C8C800')" title="#C8C800"></td>
<td class="colorchart" style="background-color:#CDD11B" onClick="colorsAll('CDD11B')" title="#CDD11B"></td>
<td class="colorchart" style="background-color:#4AE371" onClick="colorsAll('4AE371')" title="#4AE371"></td>
<td class="colorchart" style="background-color:#80B584" onClick="colorsAll('80B584')" title="#80B584"></td>
<td class="colorchart" style="background-color:#89FC63" onClick="colorsAll('89FC63')" title="#89FC63"></td>
<td class="colorchart" style="background-color:#36F200" onClick="colorsAll('36F200')" title="#36F200"></td>
<td class="colorchart" style="background-color:#66FF00" onClick="colorsAll('66FF00')" title="#66FF00"></td>
<td class="colorchart" style="background-color:#DFDF00" onClick="colorsAll('DFDF00')" title="#DFDF00"></td>
<td class="colorchart" style="background-color:#DFE32D" onClick="colorsAll('DFE32D')" title="#DFE32D"></td>
<TR>
<td class="colorchart" style="background-color:#7CEB98" onClick="colorsAll('7CEB98')" title="#7CEB98"></td>
<td class="colorchart" style="background-color:#93BF96" onClick="colorsAll('93BF96')" title="#93BF96"></td>
<td class="colorchart" style="background-color:#99FD77" onClick="colorsAll('99FD77')" title="#99FD77"></td>
<td class="colorchart" style="background-color:#52FF20" onClick="colorsAll('52FF20')" title="#52FF20"></td>
<td class="colorchart" style="background-color:#95FF4F" onClick="colorsAll('95FF4F')" title="#95FF4F"></td>
<td class="colorchart" style="background-color:#FFFFAA" onClick="colorsAll('FFFFAA')" title="#FFFFAA"></td>
<td class="colorchart" style="background-color:#EDEF85" onClick="colorsAll('EDEF85')" title="#EDEF85"></td>
<td class="colorchart" style="background-color:#93EEAA" onClick="colorsAll('93EEAA')" title="#93EEAA"></td>
<td class="colorchart" style="background-color:#A6CAA9" onClick="colorsAll('A6CAA9')" title="#A6CAA9"></td>
<td class="colorchart" style="background-color:#AAFD8E" onClick="colorsAll('AAFD8E')" title="#AAFD8E"></td>
<td class="colorchart" style="background-color:#6FFF44" onClick="colorsAll('6FFF44')" title="#6FFF44"></td>
<td class="colorchart" style="background-color:#ABFF73" onClick="colorsAll('ABFF73')" title="#ABFF73"></td>
<td class="colorchart" style="background-color:#FFFF84" onClick="colorsAll('FFFF84')" title="#FFFF84"></td>
<td class="colorchart" style="background-color:#EEF093" onClick="colorsAll('EEF093')" title="#EEF093"></td>
<td class="colorchart" style="background-color:#A4F0B7" onClick="colorsAll('A4F0B7')" title="#A4F0B7"></td>
<td class="colorchart" style="background-color:#B4D1B6" onClick="colorsAll('B4D1B6')" title="#B4D1B6"></td>
<td class="colorchart" style="background-color:#BAFEA3" onClick="colorsAll('BAFEA3')" title="#BAFEA3"></td>
<td class="colorchart" style="background-color:#8FFF6F" onClick="colorsAll('8FFF6F')" title="#8FFF6F"></td>
<TR>
<td class="colorchart" style="background-color:#C0FF97" onClick="colorsAll('C0FF97')" title="#C0FF97"></td>
<td class="colorchart" style="background-color:#FFFF99" onClick="colorsAll('FFFF99')" title="#FFFF99"></td>
<td class="colorchart" style="background-color:#F2F4B3" onClick="colorsAll('F2F4B3')" title="#F2F4B3"></td>
<td class="colorchart" style="background-color:#BDF4CB" onClick="colorsAll('BDF4CB')" title="#BDF4CB"></td>
<td class="colorchart" style="background-color:#C9DECB" onClick="colorsAll('C9DECB')" title="#C9DECB"></td>
<td class="colorchart" style="background-color:#CAFEB8" onClick="colorsAll('CAFEB8')" title="#CAFEB8"></td>
<td class="colorchart" style="background-color:#A5FF8A" onClick="colorsAll('A5FF8A')" title="#A5FF8A"></td>
<td class="colorchart" style="background-color:#D1FFB3" onClick="colorsAll('D1FFB3')" title="#D1FFB3"></td>
<td class="colorchart" style="background-color:#FFFFB5" onClick="colorsAll('FFFFB5')" title="#FFFFB5"></td>
<td class="colorchart" style="background-color:#F5F7C4" onClick="colorsAll('F5F7C4')" title="#F5F7C4"></td>
<td class="colorchart" style="background-color:#D6F8DE" onClick="colorsAll('D6F8DE')" title="#D6F8DE"></td>
<td class="colorchart" style="background-color:#DBEADC" onClick="colorsAll('DBEADC')" title="#DBEADC"></td>
<td class="colorchart" style="background-color:#DDFED1" onClick="colorsAll('DDFED1')" title="#DDFED1"></td>
<td class="colorchart" style="background-color:#B3FF99" onClick="colorsAll('B3FF99')" title="#B3FF99"></td>
<td class="colorchart" style="background-color:#DFFFCA" onClick="colorsAll('DFFFCA')" title="#DFFFCA"></td>
<td class="colorchart" style="background-color:#FFFFC8" onClick="colorsAll('FFFFC8')" title="#FFFFC8"></td>
<td class="colorchart" style="background-color:#F7F9D0" onClick="colorsAll('F7F9D0')" title="#F7F9D0"></td>
<td class="colorchart" style="background-color:#E3FBE9" onClick="colorsAll('E3FBE9')" title="#E3FBE9"></td>
<TR>
<td class="colorchart" style="background-color:#E9F1EA" onClick="colorsAll('E9F1EA')" title="#E9F1EA"></td>
<td class="colorchart" style="background-color:#EAFEE2" onClick="colorsAll('EAFEE2')" title="#EAFEE2"></td>
<td class="colorchart" style="background-color:#D2FFC4" onClick="colorsAll('D2FFC4')" title="#D2FFC4"></td>
<td class="colorchart" style="background-color:#E8FFD9" onClick="colorsAll('E8FFD9')" title="#E8FFD9"></td>
<td class="colorchart" style="background-color:#FFFFD7" onClick="colorsAll('FFFFD7')" title="#FFFFD7"></td>
<td class="colorchart" style="background-color:#FAFBDF" onClick="colorsAll('FAFBDF')" title="#FAFBDF"></td>
<td class="colorchart" style="background-color:#E3FBE9" onClick="colorsAll('E3FBE9')" title="#E3FBE9"></td>
<td class="colorchart" style="background-color:#F3F8F4" onClick="colorsAll('F3F8F4')" title="#F3F8F4"></td>
<td class="colorchart" style="background-color:#F1FEED" onClick="colorsAll('F1FEED')" title="#F1FEED"></td>
<td class="colorchart" style="background-color:#E7FFDF" onClick="colorsAll('E7FFDF')" title="#E7FFDF"></td>
<td class="colorchart" style="background-color:#F2FFEA" onClick="colorsAll('F2FFEA')" title="#F2FFEA"></td>
<td class="colorchart" style="background-color:#FFFFE3" onClick="colorsAll('FFFFE3')" title="#FFFFE3"></td>
<td class="colorchart" style="background-color:#FCFCE9" onClick="colorsAll('FCFCE9')" title="#FCFCE9"></td>
<td class="colorchart" style="background-color:#FAFEFB" onClick="colorsAll('FAFEFB')" title="#FAFEFB"></td>
<td class="colorchart" style="background-color:#FBFDFB" onClick="colorsAll('FBFDFB')" title="#FBFDFB"></td>
<td class="colorchart" style="background-color:#FDFFFD" onClick="colorsAll('FDFFFD')" title="#FDFFFD"></td>
<td class="colorchart" style="background-color:#F5FFF2" onClick="colorsAll('F5FFF2')" title="#F5FFF2"></td>
<td class="colorchart" style="background-color:#FAFFF7" onClick="colorsAll('FAFFF7')" title="#FAFFF7"></td>
<TR>
<td class="colorchart" style="background-color:#FFFFFD" onClick="colorsAll('FFFFFD')" title="#FFFFFD"></td>
<td class="colorchart" style="background-color:#FDFDF0" onClick="colorsAll('FDFDF0')" title="#FDFDF0"></td>
<td class="colorchart" style="background-color:#BABA21" onClick="colorsAll('BABA21')" title="#BABA21"></td>
<td class="colorchart" style="background-color:#C8B400" onClick="colorsAll('C8B400')" title="#C8B400"></td>
<td class="colorchart" style="background-color:#DFA800" onClick="colorsAll('DFA800')" title="#DFA800"></td>
<td class="colorchart" style="background-color:#DB9900" onClick="colorsAll('DB9900')" title="#DB9900"></td>
<td class="colorchart" style="background-color:#FFB428" onClick="colorsAll('FFB428')" title="#FFB428"></td>
<td class="colorchart" style="background-color:#FF9331" onClick="colorsAll('FF9331')" title="#FF9331"></td>
<td class="colorchart" style="background-color:#FF800D" onClick="colorsAll('FF800D')" title="#FF800D"></td>
<td class="colorchart" style="background-color:#E0E04E" onClick="colorsAll('E0E04E')" title="#E0E04E"></td>
<td class="colorchart" style="background-color:#D9C400" onClick="colorsAll('D9C400')" title="#D9C400"></td>
<td class="colorchart" style="background-color:#F9BB00" onClick="colorsAll('F9BB00')" title="#F9BB00"></td>
<td class="colorchart" style="background-color:#EAA400" onClick="colorsAll('EAA400')" title="#EAA400"></td>
<td class="colorchart" style="background-color:#FFBF48" onClick="colorsAll('FFBF48')" title="#FFBF48"></td>
<td class="colorchart" style="background-color:#FFA04A" onClick="colorsAll('FFA04A')" title="#FFA04A"></td>
<td class="colorchart" style="background-color:#FF9C42" onClick="colorsAll('FF9C42')" title="#FF9C42"></td>
<td class="colorchart" style="background-color:#E6E671" onClick="colorsAll('E6E671')" title="#E6E671"></td>
<td class="colorchart" style="background-color:#E6CE00" onClick="colorsAll('E6CE00')" title="#E6CE00"></td>
<TR>
<td class="colorchart" style="background-color:#FFCB2F" onClick="colorsAll('FFCB2F')" title="#FFCB2F"></td>
<td class="colorchart" style="background-color:#FFB60B" onClick="colorsAll('FFB60B')" title="#FFB60B"></td>
<td class="colorchart" style="background-color:#FFC65B" onClick="colorsAll('FFC65B')" title="#FFC65B"></td>
<td class="colorchart" style="background-color:#FFAB60" onClick="colorsAll('FFAB60')" title="#FFAB60"></td>
<td class="colorchart" style="background-color:#FFAC62" onClick="colorsAll('FFAC62')" title="#FFAC62"></td>
<td class="colorchart" style="background-color:#EAEA8A" onClick="colorsAll('EAEA8A')" title="#EAEA8A"></td>
<td class="colorchart" style="background-color:#F7DE00" onClick="colorsAll('F7DE00')" title="#F7DE00"></td>
<td class="colorchart" style="background-color:#FFD34F" onClick="colorsAll('FFD34F')" title="#FFD34F"></td>
<td class="colorchart" style="background-color:#FFBE28" onClick="colorsAll('FFBE28')" title="#FFBE28"></td>
<td class="colorchart" style="background-color:#FFCE73" onClick="colorsAll('FFCE73')" title="#FFCE73"></td>
<td class="colorchart" style="background-color:#FFBB7D" onClick="colorsAll('FFBB7D')" title="#FFBB7D"></td>
<td class="colorchart" style="background-color:#FFBD82" onClick="colorsAll('FFBD82')" title="#FFBD82"></td>
<td class="colorchart" style="background-color:#EEEEA2" onClick="colorsAll('EEEEA2')" title="#EEEEA2"></td>
<td class="colorchart" style="background-color:#FFE920" onClick="colorsAll('FFE920')" title="#FFE920"></td>
<td class="colorchart" style="background-color:#FFDD75" onClick="colorsAll('FFDD75')" title="#FFDD75"></td>
<td class="colorchart" style="background-color:#FFC848" onClick="colorsAll('FFC848')" title="#FFC848"></td>
<td class="colorchart" style="background-color:#FFD586" onClick="colorsAll('FFD586')" title="#FFD586"></td>
<td class="colorchart" style="background-color:#FFC48E" onClick="colorsAll('FFC48E')" title="#FFC48E"></td>
<TR>
<td class="colorchart" style="background-color:#FFC895" onClick="colorsAll('FFC895')" title="#FFC895"></td>
<td class="colorchart" style="background-color:#F1F1B1" onClick="colorsAll('F1F1B1')" title="#F1F1B1"></td>
<td class="colorchart" style="background-color:#FFF06A" onClick="colorsAll('FFF06A')" title="#FFF06A"></td>
<td class="colorchart" style="background-color:#FFE699" onClick="colorsAll('FFE699')" title="#FFE699"></td>
<td class="colorchart" style="background-color:#FFD062" onClick="colorsAll('FFD062')" title="#FFD062"></td>
<td class="colorchart" style="background-color:#FFDEA2" onClick="colorsAll('FFDEA2')" title="#FFDEA2"></td>
<td class="colorchart" style="background-color:#FFCFA4" onClick="colorsAll('FFCFA4')" title="#FFCFA4"></td>
<td class="colorchart" style="background-color:#FFCEA2" onClick="colorsAll('FFCEA2')" title="#FFCEA2"></td>
<td class="colorchart" style="background-color:#F4F4BF" onClick="colorsAll('F4F4BF')" title="#F4F4BF"></td>
<td class="colorchart" style="background-color:#FFF284" onClick="colorsAll('FFF284')" title="#FFF284"></td>
<td class="colorchart" style="background-color:#FFECB0" onClick="colorsAll('FFECB0')" title="#FFECB0"></td>
<td class="colorchart" style="background-color:#FFE099" onClick="colorsAll('FFE099')" title="#FFE099"></td>
<td class="colorchart" style="background-color:#FFE6B5" onClick="colorsAll('FFE6B5')" title="#FFE6B5"></td>
<td class="colorchart" style="background-color:#FFD9B7" onClick="colorsAll('FFD9B7')" title="#FFD9B7"></td>
<td class="colorchart" style="background-color:#FFD7B3" onClick="colorsAll('FFD7B3')" title="#FFD7B3"></td>
<td class="colorchart" style="background-color:#F7F7CE" onClick="colorsAll('F7F7CE')" title="#F7F7CE"></td>
<td class="colorchart" style="background-color:#FFF7B7" onClick="colorsAll('FFF7B7')" title="#FFF7B7"></td>
<td class="colorchart" style="background-color:#FFF1C6" onClick="colorsAll('FFF1C6')" title="#FFF1C6"></td>
<TR>
<td class="colorchart" style="background-color:#FFEAB7" onClick="colorsAll('FFEAB7')" title="#FFEAB7"></td>
<td class="colorchart" style="background-color:#FFEAC4" onClick="colorsAll('FFEAC4')" title="#FFEAC4"></td>
<td class="colorchart" style="background-color:#FFE1C6" onClick="colorsAll('FFE1C6')" title="#FFE1C6"></td>
<td class="colorchart" style="background-color:#FFE2C8" onClick="colorsAll('FFE2C8')" title="#FFE2C8"></td>
<td class="colorchart" style="background-color:#F9F9DD" onClick="colorsAll('F9F9DD')" title="#F9F9DD"></td>
<td class="colorchart" style="background-color:#FFF9CE" onClick="colorsAll('FFF9CE')" title="#FFF9CE"></td>
<td class="colorchart" style="background-color:#FFF5D7" onClick="colorsAll('FFF5D7')" title="#FFF5D7"></td>
<td class="colorchart" style="background-color:#FFF2D2" onClick="colorsAll('FFF2D2')" title="#FFF2D2"></td>
<td class="colorchart" style="background-color:#FFF2D9" onClick="colorsAll('FFF2D9')" title="#FFF2D9"></td>
<td class="colorchart" style="background-color:#FFEBD9" onClick="colorsAll('FFEBD9')" title="#FFEBD9"></td>
<td class="colorchart" style="background-color:#FFE6D0" onClick="colorsAll('FFE6D0')" title="#FFE6D0"></td>
<td class="colorchart" style="background-color:#FBFBE8" onClick="colorsAll('FBFBE8')" title="#FBFBE8"></td>
<td class="colorchart" style="background-color:#FFFBDF" onClick="colorsAll('FFFBDF')" title="#FFFBDF"></td>
<td class="colorchart" style="background-color:#FFFAEA" onClick="colorsAll('FFFAEA')" title="#FFFAEA"></td>
<td class="colorchart" style="background-color:#FFF9EA" onClick="colorsAll('FFF9EA')" title="#FFF9EA"></td>
<td class="colorchart" style="background-color:#FFF7E6" onClick="colorsAll('FFF7E6')" title="#FFF7E6"></td>
<td class="colorchart" style="background-color:#FFF4EA" onClick="colorsAll('FFF4EA')" title="#FFF4EA"></td>
<td class="colorchart" style="background-color:#FFF1E6" onClick="colorsAll('FFF1E6')" title="#FFF1E6"></td>
<TR>
<td class="colorchart" style="background-color:#FEFEFA" onClick="colorsAll('FEFEFA')" title="#FEFEFA"></td>
<td class="colorchart" style="background-color:#FFFEF7" onClick="colorsAll('FFFEF7')" title="#FFFEF7"></td>
<td class="colorchart" style="background-color:#FFFDF7" onClick="colorsAll('FFFDF7')" title="#FFFDF7"></td>
<td class="colorchart" style="background-color:#FFFDF9" onClick="colorsAll('FFFDF9')" title="#FFFDF9"></td>
<td class="colorchart" style="background-color:#FFFDF9" onClick="colorsAll('FFFDF9')" title="#FFFDF9"></td>
<td class="colorchart" style="background-color:#FFFEFD" onClick="colorsAll('FFFEFD')" title="#FFFEFD"></td>
<td class="colorchart" style="background-color:#FFF9F4" onClick="colorsAll('FFF9F4')" title="#FFF9F4"></td>
<td class="colorchart" style="background-color:#D1D17A" onClick="colorsAll('D1D17A')" title="#D1D17A"></td>
<td class="colorchart" style="background-color:#C0A545" onClick="colorsAll('C0A545')" title="#C0A545"></td>
<td class="colorchart" style="background-color:#C27E3A" onClick="colorsAll('C27E3A')" title="#C27E3A"></td>
<td class="colorchart" style="background-color:#C47557" onClick="colorsAll('C47557')" title="#C47557"></td>
<td class="colorchart" style="background-color:#B05F3C" onClick="colorsAll('B05F3C')" title="#B05F3C"></td>
<td class="colorchart" style="background-color:#C17753" onClick="colorsAll('C17753')" title="#C17753"></td>
<td class="colorchart" style="background-color:#B96F6F" onClick="colorsAll('B96F6F')" title="#B96F6F"></td>
<td class="colorchart" style="background-color:#D7D78A" onClick="colorsAll('D7D78A')" title="#D7D78A"></td>
<td class="colorchart" style="background-color:#CEB86C" onClick="colorsAll('CEB86C')" title="#CEB86C"></td>
<td class="colorchart" style="background-color:#C98A4B" onClick="colorsAll('C98A4B')" title="#C98A4B"></td>
<td class="colorchart" style="background-color:#CB876D" onClick="colorsAll('CB876D')" title="#CB876D"></td>
<TR>
<td class="colorchart" style="background-color:#C06A45" onClick="colorsAll('C06A45')" title="#C06A45"></td>
<td class="colorchart" style="background-color:#C98767" onClick="colorsAll('C98767')" title="#C98767"></td>
<td class="colorchart" style="background-color:#C48484" onClick="colorsAll('C48484')" title="#C48484"></td>
<td class="colorchart" style="background-color:#DBDB97" onClick="colorsAll('DBDB97')" title="#DBDB97"></td>
<td class="colorchart" style="background-color:#D6C485" onClick="colorsAll('D6C485')" title="#D6C485"></td>
<td class="colorchart" style="background-color:#D19C67" onClick="colorsAll('D19C67')" title="#D19C67"></td>
<td class="colorchart" style="background-color:#D29680" onClick="colorsAll('D29680')" title="#D29680"></td>
<td class="colorchart" style="background-color:#C87C5B" onClick="colorsAll('C87C5B')" title="#C87C5B"></td>
<td class="colorchart" style="background-color:#D0977B" onClick="colorsAll('D0977B')" title="#D0977B"></td>
<td class="colorchart" style="background-color:#C88E8E" onClick="colorsAll('C88E8E')" title="#C88E8E"></td>
<td class="colorchart" style="background-color:#E1E1A8" onClick="colorsAll('E1E1A8')" title="#E1E1A8"></td>
<td class="colorchart" style="background-color:#DECF9C" onClick="colorsAll('DECF9C')" title="#DECF9C"></td>
<td class="colorchart" style="background-color:#DAAF85" onClick="colorsAll('DAAF85')" title="#DAAF85"></td>
<td class="colorchart" style="background-color:#DAA794" onClick="colorsAll('DAA794')" title="#DAA794"></td>
<td class="colorchart" style="background-color:#CF8D72" onClick="colorsAll('CF8D72')" title="#CF8D72"></td>
<td class="colorchart" style="background-color:#DAAC96" onClick="colorsAll('DAAC96')" title="#DAAC96"></td>
<td class="colorchart" style="background-color:#D1A0A0" onClick="colorsAll('D1A0A0')" title="#D1A0A0"></td>
<td class="colorchart" style="background-color:#E9E9BE" onClick="colorsAll('E9E9BE')" title="#E9E9BE"></td>
<TR>
<td class="colorchart" style="background-color:#E3D6AA" onClick="colorsAll('E3D6AA')" title="#E3D6AA"></td>
<td class="colorchart" style="background-color:#DDB791" onClick="colorsAll('DDB791')" title="#DDB791"></td>
<td class="colorchart" style="background-color:#DFB4A4" onClick="colorsAll('DFB4A4')" title="#DFB4A4"></td>
<td class="colorchart" style="background-color:#D69E87" onClick="colorsAll('D69E87')" title="#D69E87"></td>
<td class="colorchart" style="background-color:#E0BBA9" onClick="colorsAll('E0BBA9')" title="#E0BBA9"></td>
<td class="colorchart" style="background-color:#D7ACAC" onClick="colorsAll('D7ACAC')" title="#D7ACAC"></td>
<td class="colorchart" style="background-color:#EEEECE" onClick="colorsAll('EEEECE')" title="#EEEECE"></td>
<td class="colorchart" style="background-color:#EADFBF" onClick="colorsAll('EADFBF')" title="#EADFBF"></td>
<td class="colorchart" style="background-color:#E4C6A7" onClick="colorsAll('E4C6A7')" title="#E4C6A7"></td>
<td class="colorchart" style="background-color:#E6C5B9" onClick="colorsAll('E6C5B9')" title="#E6C5B9"></td>
<td class="colorchart" style="background-color:#DEB19E" onClick="colorsAll('DEB19E')" title="#DEB19E"></td>
<td class="colorchart" style="background-color:#E8CCBF" onClick="colorsAll('E8CCBF')" title="#E8CCBF"></td>
<td class="colorchart" style="background-color:#DDB9B9" onClick="colorsAll('DDB9B9')" title="#DDB9B9"></td>
<td class="colorchart" style="background-color:#E9E9C0" onClick="colorsAll('E9E9C0')" title="#E9E9C0"></td>
<td class="colorchart" style="background-color:#EDE4C9" onClick="colorsAll('EDE4C9')" title="#EDE4C9"></td>
<td class="colorchart" style="background-color:#E9D0B6" onClick="colorsAll('E9D0B6')" title="#E9D0B6"></td>
<td class="colorchart" style="background-color:#EBD0C7" onClick="colorsAll('EBD0C7')" title="#EBD0C7"></td>
<td class="colorchart" style="background-color:#E4C0B1" onClick="colorsAll('E4C0B1')" title="#E4C0B1"></td>
<TR>
<td class="colorchart" style="background-color:#ECD5CA" onClick="colorsAll('ECD5CA')" title="#ECD5CA"></td>
<td class="colorchart" style="background-color:#E6CCCC" onClick="colorsAll('E6CCCC')" title="#E6CCCC"></td>
<td class="colorchart" style="background-color:#EEEECE" onClick="colorsAll('EEEECE')" title="#EEEECE"></td>
<td class="colorchart" style="background-color:#EFE7CF" onClick="colorsAll('EFE7CF')" title="#EFE7CF"></td>
<td class="colorchart" style="background-color:#EEDCC8" onClick="colorsAll('EEDCC8')" title="#EEDCC8"></td>
<td class="colorchart" style="background-color:#F0DCD5" onClick="colorsAll('F0DCD5')" title="#F0DCD5"></td>
<td class="colorchart" style="background-color:#EACDC1" onClick="colorsAll('EACDC1')" title="#EACDC1"></td>
<td class="colorchart" style="background-color:#F0DDD5" onClick="colorsAll('F0DDD5')" title="#F0DDD5"></td>
<td class="colorchart" style="background-color:#ECD9D9" onClick="colorsAll('ECD9D9')" title="#ECD9D9"></td>
<td class="colorchart" style="background-color:#F1F1D6" onClick="colorsAll('F1F1D6')" title="#F1F1D6"></td>
<td class="colorchart" style="background-color:#F5EFE0" onClick="colorsAll('F5EFE0')" title="#F5EFE0"></td>
<td class="colorchart" style="background-color:#F2E4D5" onClick="colorsAll('F2E4D5')" title="#F2E4D5"></td>
<td class="colorchart" style="background-color:#F5E7E2" onClick="colorsAll('F5E7E2')" title="#F5E7E2"></td>
<td class="colorchart" style="background-color:#F0DDD5" onClick="colorsAll('F0DDD5')" title="#F0DDD5"></td>
<td class="colorchart" style="background-color:#F5E8E2" onClick="colorsAll('F5E8E2')" title="#F5E8E2"></td>
<td class="colorchart" style="background-color:#F3E7E7" onClick="colorsAll('F3E7E7')" title="#F3E7E7"></td>
<td class="colorchart" style="background-color:#F5F5E2" onClick="colorsAll('F5F5E2')" title="#F5F5E2"></td>
<td class="colorchart" style="background-color:#F9F5EC" onClick="colorsAll('F9F5EC')" title="#F9F5EC"></td>
<TR>
<td class="colorchart" style="background-color:#F9F3EC" onClick="colorsAll('F9F3EC')" title="#F9F3EC"></td>
<td class="colorchart" style="background-color:#F9EFEC" onClick="colorsAll('F9EFEC')" title="#F9EFEC"></td>
<td class="colorchart" style="background-color:#F5E8E2" onClick="colorsAll('F5E8E2')" title="#F5E8E2"></td>
<td class="colorchart" style="background-color:#FAF2EF" onClick="colorsAll('FAF2EF')" title="#FAF2EF"></td>
<td class="colorchart" style="background-color:#F8F1F1" onClick="colorsAll('F8F1F1')" title="#F8F1F1"></td>
<td class="colorchart" style="background-color:#FDFDF9" onClick="colorsAll('FDFDF9')" title="#FDFDF9"></td>
<td class="colorchart" style="background-color:#FDFCF9" onClick="colorsAll('FDFCF9')" title="#FDFCF9"></td>
<td class="colorchart" style="background-color:#FCF9F5" onClick="colorsAll('FCF9F5')" title="#FCF9F5"></td>
<td class="colorchart" style="background-color:#FDFAF9" onClick="colorsAll('FDFAF9')" title="#FDFAF9"></td>
<td class="colorchart" style="background-color:#FDFAF9" onClick="colorsAll('FDFAF9')" title="#FDFAF9"></td>
<td class="colorchart" style="background-color:#FCF7F5" onClick="colorsAll('FCF7F5')" title="#FCF7F5"></td>
<td class="colorchart" style="background-color:#FDFBFB" onClick="colorsAll('FDFBFB')" title="#FDFBFB"></td>
<td class="colorchart" style="background-color:#F70000" onClick="colorsAll('F70000')" title="#F70000"></td>
<td class="colorchart" style="background-color:#B9264F" onClick="colorsAll('B9264F')" title="#B9264F"></td>
<td class="colorchart" style="background-color:#990099" onClick="colorsAll('990099')" title="#990099"></td>
<td class="colorchart" style="background-color:#74138C" onClick="colorsAll('74138C')" title="#74138C"></td>
<td class="colorchart" style="background-color:#0000CE" onClick="colorsAll('0000CE')" title="#0000CE"></td>
<td class="colorchart" style="background-color:#1F88A7" onClick="colorsAll('1F88A7')" title="#1F88A7"></td>
<TR>
<td class="colorchart" style="background-color:#4A9586" onClick="colorsAll('4A9586')" title="#4A9586"></td>
<td class="colorchart" style="background-color:#FF2626" onClick="colorsAll('FF2626')" title="#FF2626"></td>
<td class="colorchart" style="background-color:#D73E68" onClick="colorsAll('D73E68')" title="#D73E68"></td>
<td class="colorchart" style="background-color:#B300B3" onClick="colorsAll('B300B3')" title="#B300B3"></td>
<td class="colorchart" style="background-color:#8D18AB" onClick="colorsAll('8D18AB')" title="#8D18AB"></td>
<td class="colorchart" style="background-color:#5B5BFF" onClick="colorsAll('5B5BFF')" title="#5B5BFF"></td>
<td class="colorchart" style="background-color:#25A0C5" onClick="colorsAll('25A0C5')" title="#25A0C5"></td>
<td class="colorchart" style="background-color:#5EAE9E" onClick="colorsAll('5EAE9E')" title="#5EAE9E"></td>
<td class="colorchart" style="background-color:#FF5353" onClick="colorsAll('FF5353')" title="#FF5353"></td>
<td class="colorchart" style="background-color:#DD597D" onClick="colorsAll('DD597D')" title="#DD597D"></td>
<td class="colorchart" style="background-color:#CA00CA" onClick="colorsAll('CA00CA')" title="#CA00CA"></td>
<td class="colorchart" style="background-color:#A41CC6" onClick="colorsAll('A41CC6')" title="#A41CC6"></td>
<td class="colorchart" style="background-color:#7373FF" onClick="colorsAll('7373FF')" title="#7373FF"></td>
<td class="colorchart" style="background-color:#29AFD6" onClick="colorsAll('29AFD6')" title="#29AFD6"></td>
<td class="colorchart" style="background-color:#74BAAC" onClick="colorsAll('74BAAC')" title="#74BAAC"></td>
<td class="colorchart" style="background-color:#FF7373" onClick="colorsAll('FF7373')" title="#FF7373"></td>
<td class="colorchart" style="background-color:#E37795" onClick="colorsAll('E37795')" title="#E37795"></td>
<td class="colorchart" style="background-color:#D900D9" onClick="colorsAll('D900D9')" title="#D900D9"></td>
<TR>
<td class="colorchart" style="background-color:#BA21E0" onClick="colorsAll('BA21E0')" title="#BA21E0"></td>
<td class="colorchart" style="background-color:#8282FF" onClick="colorsAll('8282FF')" title="#8282FF"></td>
<td class="colorchart" style="background-color:#4FBDDD" onClick="colorsAll('4FBDDD')" title="#4FBDDD"></td>
<td class="colorchart" style="background-color:#8DC7BB" onClick="colorsAll('8DC7BB')" title="#8DC7BB"></td>
<td class="colorchart" style="background-color:#FF8E8E" onClick="colorsAll('FF8E8E')" title="#FF8E8E"></td>
<td class="colorchart" style="background-color:#E994AB" onClick="colorsAll('E994AB')" title="#E994AB"></td>
<td class="colorchart" style="background-color:#FF2DFF" onClick="colorsAll('FF2DFF')" title="#FF2DFF"></td>
<td class="colorchart" style="background-color:#CB59E8" onClick="colorsAll('CB59E8')" title="#CB59E8"></td>
<td class="colorchart" style="background-color:#9191FF" onClick="colorsAll('9191FF')" title="#9191FF"></td>
<td class="colorchart" style="background-color:#67C7E2" onClick="colorsAll('67C7E2')" title="#67C7E2"></td>
<td class="colorchart" style="background-color:#A5D3CA" onClick="colorsAll('A5D3CA')" title="#A5D3CA"></td>
<td class="colorchart" style="background-color:#FFA4A4" onClick="colorsAll('FFA4A4')" title="#FFA4A4"></td>
<td class="colorchart" style="background-color:#EDA9BC" onClick="colorsAll('EDA9BC')" title="#EDA9BC"></td>
<td class="colorchart" style="background-color:#F206FF" onClick="colorsAll('F206FF')" title="#F206FF"></td>
<td class="colorchart" style="background-color:#CB59E8" onClick="colorsAll('CB59E8')" title="#CB59E8"></td>
<td class="colorchart" style="background-color:#A8A8FF" onClick="colorsAll('A8A8FF')" title="#A8A8FF"></td>
<td class="colorchart" style="background-color:#8ED6EA" onClick="colorsAll('8ED6EA')" title="#8ED6EA"></td>
<td class="colorchart" style="background-color:#C0E0DA" onClick="colorsAll('C0E0DA')" title="#C0E0DA"></td>
<TR>
<td class="colorchart" style="background-color:#FFB5B5" onClick="colorsAll('FFB5B5')" title="#FFB5B5"></td>
<td class="colorchart" style="background-color:#F0B9C8" onClick="colorsAll('F0B9C8')" title="#F0B9C8"></td>
<td class="colorchart" style="background-color:#FF7DFF" onClick="colorsAll('FF7DFF')" title="#FF7DFF"></td>
<td class="colorchart" style="background-color:#D881ED" onClick="colorsAll('D881ED')" title="#D881ED"></td>
<td class="colorchart" style="background-color:#B7B7FF" onClick="colorsAll('B7B7FF')" title="#B7B7FF"></td>
<td class="colorchart" style="background-color:#A6DEEE" onClick="colorsAll('A6DEEE')" title="#A6DEEE"></td>
<td class="colorchart" style="background-color:#CFE7E2" onClick="colorsAll('CFE7E2')" title="#CFE7E2"></td>
<td class="colorchart" style="background-color:#FFC8C8" onClick="colorsAll('FFC8C8')" title="#FFC8C8"></td>
<td class="colorchart" style="background-color:#F4CAD6" onClick="colorsAll('F4CAD6')" title="#F4CAD6"></td>
<td class="colorchart" style="background-color:#FFA8FF" onClick="colorsAll('FFA8FF')" title="#FFA8FF"></td>
<td class="colorchart" style="background-color:#EFCDF8" onClick="colorsAll('EFCDF8')" title="#EFCDF8"></td>
<td class="colorchart" style="background-color:#C6C6FF" onClick="colorsAll('C6C6FF')" title="#C6C6FF"></td>
<td class="colorchart" style="background-color:#C0E7F3" onClick="colorsAll('C0E7F3')" title="#C0E7F3"></td>
<td class="colorchart" style="background-color:#DCEDEA" onClick="colorsAll('DCEDEA')" title="#DCEDEA"></td>
<td class="colorchart" style="background-color:#FFEAEA" onClick="colorsAll('FFEAEA')" title="#FFEAEA"></td>
<td class="colorchart" style="background-color:#F8DAE2" onClick="colorsAll('F8DAE2')" title="#F8DAE2"></td>
<td class="colorchart" style="background-color:#FFC4FF" onClick="colorsAll('FFC4FF')" title="#FFC4FF"></td>
<td class="colorchart" style="background-color:#EFCDF8" onClick="colorsAll('EFCDF8')" title="#EFCDF8"></td>
<TR>
<td class="colorchart" style="background-color:#DBDBFF" onClick="colorsAll('DBDBFF')" title="#DBDBFF"></td>
<td class="colorchart" style="background-color:#D8F0F8" onClick="colorsAll('D8F0F8')" title="#D8F0F8"></td>
<td class="colorchart" style="background-color:#E7F3F1" onClick="colorsAll('E7F3F1')" title="#E7F3F1"></td>
<td class="colorchart" style="background-color:#FFEAEA" onClick="colorsAll('FFEAEA')" title="#FFEAEA"></td>
<td class="colorchart" style="background-color:#FAE7EC" onClick="colorsAll('FAE7EC')" title="#FAE7EC"></td>
<td class="colorchart" style="background-color:#FFE3FF" onClick="colorsAll('FFE3FF')" title="#FFE3FF"></td>
<td class="colorchart" style="background-color:#F8E9FC" onClick="colorsAll('F8E9FC')" title="#F8E9FC"></td>
<td class="colorchart" style="background-color:#EEEEFF" onClick="colorsAll('EEEEFF')" title="#EEEEFF"></td>
<td class="colorchart" style="background-color:#EFF9FC" onClick="colorsAll('EFF9FC')" title="#EFF9FC"></td>
<td class="colorchart" style="background-color:#F2F9F8" onClick="colorsAll('F2F9F8')" title="#F2F9F8"></td>
<td class="colorchart" style="background-color:#FFFDFD" onClick="colorsAll('FFFDFD')" title="#FFFDFD"></td>
<td class="colorchart" style="background-color:#FEFAFB" onClick="colorsAll('FEFAFB')" title="#FEFAFB"></td>
<td class="colorchart" style="background-color:#FFFDFF" onClick="colorsAll('FFFDFF')" title="#FFFDFF"></td>
<td class="colorchart" style="background-color:#FFFFFF" onClick="colorsAll('FFFFFF')" title="#FFFFFF"></td>
<td class="colorchart" style="background-color:#FDFDFF" onClick="colorsAll('FDFDFF')" title="#FDFDFF"></td>
<td class="colorchart" style="background-color:#FAFDFE" onClick="colorsAll('FAFDFE')" title="#FAFDFE"></td>
<td class="colorchart" style="background-color:#F7FBFA" onClick="colorsAll('F7FBFA')" title="#F7FBFA"></td>
</TABLE>
</div>
</BODY>
</HTML>
