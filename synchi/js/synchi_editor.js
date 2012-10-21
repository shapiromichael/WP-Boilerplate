// =============================================================================
// File: synchi_eeditor.js
// Version: 1.1
// 
// Enables synchi editor for articles
// =============================================================================

var synchi_editor = false;
var synchi_fullscreen = false;
var synchi_controls = { original : null, synchi : null }

/**
 * Performs a synchi control action
 *
 * @param control string control name
 */
function synchi_Control(control) {
    switch(control) {
        case 'search':
            CodeMirror.commands.find(synchi_editor.editor);
            break;
        case 'find_prev':
            CodeMirror.commands.findPrev(synchi_editor.editor);
            break;
        case 'find_next':
            CodeMirror.commands.findNext(synchi_editor.editor);
            break;
        case 'search_replace':
            CodeMirror.commands.replaceAll(synchi_editor.editor);
            break;
        case 'undo':
            synchi_editor.editor.undo();
            break;
        case 'redo':
            synchi_editor.editor.redo();
            break;
        case 'goto':
            synchi_editor.gotoLine();
            break;
        case 'format':
            synchi_editor.editor.indentSelection('smart');
            break;
        case 'indent_left':
            synchi_editor.editor.indentSelection('subtract');
            break;
        case 'indent_right':
            synchi_editor.editor.indentSelection('add'); 
            break;
        case 'fullscreen':
            var container = $('#wp-content-editor-container');
            if(container.hasClass('synchi_fullscreen')) {
                container.removeClass('synchi_fullscreen');
                synchi_fullscreen = false;
            }
            else {
                container.addClass('synchi_fullscreen');
                synchi_fullscreen = true;
                synchi_editor.focus();
            }
            break;
    }
}

/**
 * Checks if TinyMCE is being used
 * 
 * @return true if TinyMCE is being used
 */
function synchi_isTinyMCE() {
    var tinymce = $("#content-tmce");
    return tinymce.length != 0;
}

/**
 * Initializes article editor with syntax highlight
 * 
 * @param editor_area jQuery wrapped textarea object
 */
function synchi_initArticleEditor(editor_area) {
    // swich to HTML editor if TinyMCE is being used
    if(synchi_isTinyMCE()) switchEditors.switchto($("#content-html").get(0));
    
    synchi_call('get_editor_controls', {}, function(response) {
        // handle the controls menu
        synchi_controls.original = $("#ed_toolbar").clone(true);
        synchi_controls.synchi = response.result;
        synchi_controls.parent = $("#ed_toolbar").parent();
        
        // init the editor
        synchi_editor = editor_area.parent().synchi('file.html');
        
        // swap controls
        $("#ed_toolbar").remove();
        
        synchi_controls.parent.prepend(synchi_controls.synchi);
        
        // handle TinyMCE
        if(synchi_isTinyMCE()) {
            $("#content-tmce").click(function(){
                // revert to textarea
                if(synchi_editor) {
                    synchi_editor.editor.toTextArea();
                    synchi_editor = false;
                    // swap controls
                    synchi_controls.synchi = $("#ed_toolbar").clone(true);
                    $("#ed_toolbar").remove();
                    synchi_controls.parent.prepend(synchi_controls.original);
                }
                // default behaviour
                switchEditors.switchto($(this).get(0));
                return false;
            });
            $("#content-html").click(function(){
                // default behaviour
                switchEditors.switchto($(this).get(0));
                // re-init article editor
                synchi_editor = $("#content").parent().synchi('file.html');
                // swap controls
                synchi_controls.original = $("#ed_toolbar").clone(true);
                $("#ed_toolbar").remove();
                synchi_controls.parent.prepend(synchi_controls.synchi);
                return false;
            });
        }
        
        // bind key shortcuts
        var bindings = {
            'Ctrl+f' : function(event){ 
                if(synchi_editor) synchi_Control('search'); 
            },
            'Ctrl+r' : function(event){ 
                if(synchi_editor) synchi_Control('search_replace'); 
            },
            'Ctrl+left' : function(event){ 
                if(synchi_editor) synchi_Control('find_prev'); 
            },
            'Ctrl+right' : function(event){ 
                if(synchi_editor) synchi_Control('find_next'); 
            },
            'Alt+Shift+left' : function(event){ 
                if(synchi_editor) synchi_Control('indent_left'); 
            },
            'Alt+Shift+right' : function(event){ 
                if(synchi_editor) synchi_Control('indent_right'); 
            },
            'Alt+Shift+f' : function(event){ 
                if(synchi_editor) synchi_Control('format'); 
            },
            'Ctrl+z' : function(event){ 
                if(synchi_editor) synchi_Control('undo'); 
            },
            'Ctrl+y' : function(event){ 
                if(synchi_editor) synchi_Control('redo'); 
            },
            'Ctrl+g' : function(event){ 
                if(synchi_editor) synchi_Control('goto'); 
            },
            'Alt+return' : function(event){ 
                if(synchi_editor) synchi_Control('fullscreen'); 
            }
        };
        for(var index in bindings) shortcut.add(index,bindings[index]);
    });
}

// On Load
$(function(){
    var editor_area = $("#content");
    if(editor_area.length != 0) synchi_initArticleEditor(editor_area);
    // bind click events to line numbers
    $('.CodeMirror-gutter-text pre').live('click',function(){
        if(!synchi_editor) return;
        var line = Number($.trim($(this).text()))-1;
        if(!synchi_editor.editor.getLineHandle(line)) return;
        synchi_editor.editor.setCursor(line,0);
        synchi_editor.editor.setSelection(
            {line:line, ch:0},
            {line:line+1, ch:0}
        );
        synchi_editor.editor.focus();
    });
});