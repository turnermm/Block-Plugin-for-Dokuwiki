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

   saveSelectionObj = getSelection(wikiTextArea);
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
