// =============================================================================
// File: editor_highlight_eeditor.js
// Version: 1.1
// 
// Enables editor_highlight editor for articles
// =============================================================================

var editor_highlight_editor = false;
var editor_highlight_fullscreen = false;
var editor_highlight_controls = { original : null, editor_highlight : null }

/**
 * Performs a editor_highlight control action
 *
 * @param control string control name
 */
function editor_highlight_Control(control) {
    switch(control) {
        case 'search':
            CodeMirror.commands.find(editor_highlight_editor.editor);
            break;
        case 'find_prev':
            CodeMirror.commands.findPrev(editor_highlight_editor.editor);
            break;
        case 'find_next':
            CodeMirror.commands.findNext(editor_highlight_editor.editor);
            break;
        case 'search_replace':
            CodeMirror.commands.replaceAll(editor_highlight_editor.editor);
            break;
        case 'undo':
            editor_highlight_editor.editor.undo();
            break;
        case 'redo':
            editor_highlight_editor.editor.redo();
            break;
        case 'goto':
            editor_highlight_editor.gotoLine();
            break;
        case 'format':
            editor_highlight_editor.editor.indentSelection('smart');
            break;
        case 'indent_left':
            editor_highlight_editor.editor.indentSelection('subtract');
            break;
        case 'indent_right':
            editor_highlight_editor.editor.indentSelection('add'); 
            break;
        case 'fullscreen':
            var container = $('#wp-content-editor-container');
            if(container.hasClass('editor_highlight_fullscreen')) {
                container.removeClass('editor_highlight_fullscreen');
                editor_highlight_fullscreen = false;
            }
            else {
                container.addClass('editor_highlight_fullscreen');
                editor_highlight_fullscreen = true;
                editor_highlight_editor.focus();
            }
            break;
    }
}

/**
 * Checks if TinyMCE is being used
 * 
 * @return true if TinyMCE is being used
 */
function editor_highlight_isTinyMCE() {
    var tinymce = $("#content-tmce");
    return tinymce.length != 0;
}

/**
 * Initializes article editor with syntax highlight
 * 
 * @param editor_area jQuery wrapped textarea object
 */
function editor_highlight_initArticleEditor(editor_area) {
    // swich to HTML editor if TinyMCE is being used
    if(editor_highlight_isTinyMCE()) switchEditors.switchto($("#content-html").get(0));
    
    editor_highlight_call('get_editor_controls', {}, function(response) {
        // handle the controls menu
        editor_highlight_controls.original = $("#ed_toolbar").clone(true);
        editor_highlight_controls.editor_highlight = response.result;
        editor_highlight_controls.parent = $("#ed_toolbar").parent();
        
        // init the editor
        editor_highlight_editor = editor_area.parent().editor_highlight('file.html');
        
        // swap controls
        $("#ed_toolbar").remove();
        
        editor_highlight_controls.parent.prepend(editor_highlight_controls.editor_highlight);
        
        // handle TinyMCE
        if(editor_highlight_isTinyMCE()) {
            
            $("#content-tmce").click(function(){
                // revert to textarea
                if(editor_highlight_editor) {
                    editor_highlight_editor.editor.toTextArea(); 
                    editor_highlight_editor = false;
                    // swap controls
                    editor_highlight_controls.editor_highlight = $("#ed_toolbar").clone(true);
                    $("#ed_toolbar").remove();
                    editor_highlight_controls.parent.prepend(editor_highlight_controls.original);
                }
                // default behaviour
                switchEditors.switchto($(this).get(0));
                return false;
            }); 

            $("#content-html").click(function(){
                if( $('.CodeMirror-wrap').size() ) {
                    return;
                }                
                // default behaviour
                switchEditors.switchto($(this).get(0));
                // re-init article editor
                editor_highlight_editor = $("#content").parent().editor_highlight('file.html').addClass("init");
              // swap controls
                editor_highlight_controls.original = $("#ed_toolbar").clone(true);
                $("#ed_toolbar").remove();
                editor_highlight_controls.parent.prepend(editor_highlight_controls.editor_highlight);

                $('#wp-content-wrap').addClass('html-editor-initialized');
                return false; 
            });
        }
        
        // bind key shortcuts
        var bindings = {
            'Ctrl+f' : function(event){ 
                if(editor_highlight_editor) editor_highlight_Control('search'); 
            },
            'Ctrl+r' : function(event){ 
                if(editor_highlight_editor) editor_highlight_Control('search_replace'); 
            },
            'Ctrl+left' : function(event){ 
                if(editor_highlight_editor) editor_highlight_Control('find_prev'); 
            },
            'Ctrl+right' : function(event){ 
                if(editor_highlight_editor) editor_highlight_Control('find_next'); 
            },
            'Alt+Shift+left' : function(event){ 
                if(editor_highlight_editor) editor_highlight_Control('indent_left'); 
            },
            'Alt+Shift+right' : function(event){ 
                if(editor_highlight_editor) editor_highlight_Control('indent_right'); 
            },
            'Alt+Shift+f' : function(event){ 
                if(editor_highlight_editor) editor_highlight_Control('format'); 
            },
            'Ctrl+z' : function(event){ 
                if(editor_highlight_editor) editor_highlight_Control('undo'); 
            },
            'Ctrl+y' : function(event){ 
                if(editor_highlight_editor) editor_highlight_Control('redo'); 
            },
            'Ctrl+g' : function(event){ 
                if(editor_highlight_editor) editor_highlight_Control('goto'); 
            },
            'Alt+return' : function(event){ 
                if(editor_highlight_editor) editor_highlight_Control('fullscreen'); 
            }
        };
        for(var index in bindings) shortcut.add(index,bindings[index]);
    });
}

// On Load
$(function(){
    var editor_area = $("#content");
    if(editor_area.length != 0) editor_highlight_initArticleEditor(editor_area);
    // bind click events to line numbers
    $('.CodeMirror-gutter-text pre').live('click',function(){
        if(!editor_highlight_editor) return;
        var line = Number($.trim($(this).text()))-1;
        if(!editor_highlight_editor.editor.getLineHandle(line)) return;
        editor_highlight_editor.editor.setCursor(line,0);
        editor_highlight_editor.editor.setSelection(
            {line:line, ch:0},
            {line:line+1, ch:0}
        );
        editor_highlight_editor.editor.focus();
    });
});