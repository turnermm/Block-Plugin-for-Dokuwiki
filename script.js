   /** 
    * Add toolbar item for block plugin
    * @author Myron Turner <turnermm02@shaw.ca>
  */
                        
  if(toolbar){
     var url = encodeURI('lib/plugins/block/exe/block.php?');      
     toolbar[toolbar.length] = {"type":"mediapopup", "title":"block utility", "key":"",
                                "icon": "../../plugins/block/images/block.png",                          
                                "url":   url,
                                'name': 'block',
                                'options': 'width=700,height=620,left=25,top=25,scrollbars=yes,resizable=yes'                             
                              };
  }

var saveSelectionObj;
var wikiTextArea;
var pluginDisplayDiv;

function initialize(dispDivId) {

    pluginDisplayDiv = dispDivId;
    wikiTextArea = document.getElementById('wiki__text');
    return wikiTextArea;
}

function setIdObj(id,w) {
      return w.document.getElementById(id);
}

function show_text_entry(el) {

    if(typeof window.getSelection != 'undefined'  && typeof  window.getSelection.getText !='undefined') {
        saveSelectionObj = getSelection(wikiTextArea);
    }
    else  saveSelectionObj =  DWgetSelection(wikiTextArea); 
    var text = saveSelectionObj.getText();
    if(text) {
        el.innerHTML=text;
         
    }
   
   return saveSelectionObj;
}

function createBlock(styles) {
	if(jQuery) {
	insertTags('wiki__text','<block ' + styles + '>', '</block>', 'abc') ;
	}
	else {
	   insertTags(wikiTextArea,'<block ' + styles + '>', '</block>', 'abc') ;
	}
}

function getfnarray() {
 var FontNamesArray = Array(
'Arial',
'Arial Black',
'Arial Narrow',
'Arial Rounded MT Bold',
'Baskerville',
'Baskerville Old Face',
'Bauhaus 93',
'Comic Sans MS',
'Copperplate',
'Copperplate Gothic Bold',
'Courier',
'Courier New',
'Futura',
'Futura Md BT',
'Georgia',
'Garamond',
'Helvetica',
'Impact',
'Sans-serif',
'Microsoft Sans Serif',
'Serif',
'Palatino',
'Palatino Linotype',
'Papyrus',
'Tahoma',
'Times New Roman',
'Trebuchet MS',
'Verdana'
);

    return FontNamesArray;
}
    var Block_plugin_options;
    var getBlockOptions = function() {         
         jQuery.ajax(
          DOKU_BASE + 'lib/exe/ajax.php',
          {
            data:
              {
                call: 'block__opts'
              },
            type: "POST",
            async: true,
            dataType: 'json',
            success: function(data, textStatus, jqXHR)
            {         
                  Block_plugin_options = data;
             },
            error: function(jqXHR, textStatus, errorThrown )
              {
                alert(textStatus);
                alert(errorThrown);
              }
          }
        );
    };
    

jQuery(document).ready(function() {
  
  if(JSINFO['block'] && JSINFO['act']) {     
     getBlockOptions();      
   }
});

function block_supports_canvas() {
    return !!document.createElement('canvas').getContext;
}
function doesFontExist(fontName) {
    // creating our in-memory Canvas element where the magic happens
    var canvas = document.createElement("canvas");
    var context = canvas.getContext("2d");
     
    // the text whose final pixel size I want to measure
    var text = "abcdefghijklmnopqrstuvwxyz0123456789";
     
    // specifying the baseline font
    context.font = "72px monospace";
     
    // checking the size of the baseline text
    var baselineSize = context.measureText(text).width;
     
    // specifying the font whose existence we want to check
    context.font = "72px '" + fontName + "', monospace";
     
    // checking the size of the font we want to check
    var newSize = context.measureText(text).width;
     
    // removing the Canvas element we created
    delete canvas;
     
    //
    // If the size of the two text instances is the same, the font does not exist because it is being rendered
    // using the default sans-serif font
    //
    if (newSize == baselineSize) {
        return false;
    } else {
        return true;
    }
}

function getJQy() { 
  return jQuery;
}