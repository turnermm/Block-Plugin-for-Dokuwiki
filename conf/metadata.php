<?php
$meta['block_width'] = array('string');
$meta['bg'] = array('string');
$meta['fg'] = array('string');
$meta['border_color'] = array('string');
$meta['border_style'] = array('multichoice','_choices' => array('solid','dotted','dashed','double'));
$meta['border_width'] = array('string');
$meta['font_family'] = array('multichoice','_choices' => array('sans-serif','Arial, Helvetica, sans-serif','Tahoma, Geneva, sans-serif','Verdana, Geneva, sans-serif',
'serif','Georgia, serif ','Palatino,"Palatino Linotype","Book Antiqua", serif ','"Times New Roman", Times, serif ', '"Lucida Sans Unicode","Lucida Grande", sans-serif',
'cursive','"Comic Sans MS", cursive, sans-serif','monospace','"Courier New", Courier, monospace','"Lucida Console", Monaco, monospace' ));
$meta['font_size'] = array('string');
$meta['block_align'] = array('string');
