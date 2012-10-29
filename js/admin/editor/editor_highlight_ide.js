fu// =============================================================================
// File: ide.js
// Version: 1.0
// 
// Initializes editor_highlight IDE.
// =============================================================================

var editor_highlight_IDE_EDITOR_DEFAULT_HEIGHT = 432;
var editor_highlight_IDE_TABS_DEFAULT_HEIGHT = 25;
var editor_highlight_IDE_HEIGHT_DIFFERENCE = 43;

/**
 * Fullscreen on/off flag
 */
var editor_highlightIDE_fullscreen = false;

// =================================================== Clipboard Functions =====

/**
 * File clipboard [filepath,mode]
 */
var editor_highlightIDE_clipboard = false;

/**
 * Performs file clipboard copy
 */
function editor_highlightIDE_clipboard_copy(filepath) {
    var filename = filepath.split('/').pop();
    editor_highlightIDE_clipboard = {
        filepath : filepath,
        mode : "copy"
    };
    if(filename == "") editor_highlight_showMessage('Directory copied', 1500);
    else editor_highlight_showMessage('File ' + filename+' copied', 1500);
}

/**
 * Performs file clipboard cut
 */
function editor_highlightIDE_clipboard_cut(filepath) {
    var filename = filepath.split('/').pop();
    editor_highlightIDE_clipboard = {
        filepath : filepath,
        mode : "cut"
    };
    if(filename == "") editor_highlight_showMessage('Directory cut', 1500);
    else editor_highlight_showMessage('File ' + filename+' cut', 1500);
}

/**
 * Performs file clipboard paste
 */
function editor_highlightIDE_clipboard_paste(file) {
    if(!editor_highlightIDE_clipboard) return;
    editor_highlight_showLoadingMessage('Copying');
    editor_highlight_call('paste_file', 
        {
            source:editor_highlightIDE_clipboard.filepath,
            mode:editor_highlightIDE_clipboard.mode,
            file:file.attr('rel')
        },
        function(response){
            if(response.status == 0) {
                editor_highlight_hideMessage(function(){
                    editor_highlight_showMessage(response.error,2000);
                });
                return;
            }
            editor_highlight_hideMessage(function(){
                editor_highlight_showMessage("Done.",1500);
                editor_highlightIDE_sidebar_refresh('paste', function(){
                    editor_highlightIDE_clipboard = false;
                });                
            });
        }
    );
}

// ========================================================= Tab Functions =====

/**
 * An array of opened tabs
 */
var editor_highlightIDE_tabs = [];

/**
 * Focused tab
 */
var editor_highlightIDE_focusedTab = false;

/**
 * Saves the index of the tab being moved
 */
var editor_highlightIDE_tabs_sortStartIndex = -1;

/**
 * Class editor_highlightIDETab
 * 
 * Vars: id,file,focused,loading,changed,name,extension,fullName,tab,editor
 * Methods: close,unfocus,focus,loadingStart,loadingStop,change,clearChange
 */
function editor_highlightIDE_tab(file) {
    var self = {};
    
    self.id = "tab_" + Math.floor(Math.random()*1000000);
    self.file = file;
    self.focused = false;
    self.loading = false;
    self.changed = false;
    self.name = file.split('/').pop();
    self.extension = self.name.split('.').pop();
    self.fullName = file.replace(editor_highlight_editor_root,"");
    self.tab = $('<div class="tab"></div>');
    self.editor = $('<div rel="'+self.id+'" class="editor_highlight_ide_file"></div>');    
    
    self.close = function(forceClose) {
        // check if to save
        if(!forceClose && self.changed) {
            var save = confirm("Save changes to '"+self.name+"'?");
            if(!save) {
                self.close(true);
                return false;
            }
            editor_highlight_showLoadingMessage('Saving ' + self.name);
            self.editor.save(
                function(){
                    editor_highlight_hideMessage(function(){
                        editor_highlight_showMessage('File ' + self.name + ' saved.',1500);
                        self.close(true);
                    });
                },
                function(){
                    editor_highlight_hideMessage(function(){
                        editor_highlight_showMessage('Error: file ' + self.name + ' not saved.',1500);
                    });
                }
            );
        }
        
        self.editor.remove();
        self.tab.remove();
        
        for(var i=0; i<editor_highlightIDE_tabs.length; i++) {
            if(editor_highlightIDE_tabs[i].id == self.id) {
                editor_highlightIDE_tabs.splice(i,1);
                if(self.focused && editor_highlightIDE_tabs.length > 0) editor_highlightIDE_tabs[0].focus();
                break;
            }
        }
        
        editor_highlightIDE_tabs_update();
        
        return false;
    }
    
    self.unfocus = function() {
        editor_highlightIDE_focusedTab = false;
        self.tab.removeClass('focused');
        self.editor.hide();
        self.focused = false;
    }
    
    self.focus = function(callback) {
        for(var i=0; i<editor_highlightIDE_tabs.length; i++) if(editor_highlightIDE_tabs[i].focused) editor_highlightIDE_tabs[i].unfocus();
        editor_highlightIDE_focusedTab = self;
        self.tab.addClass('focused');
        self.editor.show();
        self.focused = true;
        if(callback && typeof(callback) == 'function') callback();
        editor_highlightIDE_tabs_update();
        return false;
    }
    
    self.loadingStart = function(text) {
        if(!text) text = "loading"
        self.loading = $("<div style='width: 100%; margin-top: 40px; text-align:center'>"
            +'<img src="'+editor_highlight_path+'img/loading_white.gif" /><br />'+text+'..'+
        "</div>");
        self.editor.after(self.loading);
        self.editor.hide();
    }
    
    self.loadingStop = function(callback) {
        self.loading.remove();
        self.editor.show();
        self.loading = false;
        if(callback && typeof(callback) == 'function') callback();
    }
    
    self.change = function() {
        self.changed = true;
        self.tab.addClass('changed');
    }
    
    self.clearChange = function() {
        self.changed = false;
        self.tab.removeClass('changed');
    }
    
    // append to tabs
    editor_highlightIDE_tabs[editor_highlightIDE_tabs.length] = self;
    $("#editor_highlight_ide_tabs").append(self.tab);
    
    // determine file icon
    var file_img = editor_highlight_path+'img/files/'+self.extension+'.png';
    
    // create and append tab link
    $('<a class="file_link" style="background-image:url('+file_img+')" href="#" title="File: '+self.fullName+'">'+self.name+'</a>')
        .click(function(e){
            if (!e.which && e.button) {
                if (e.button & 1) e.which = 1;
                else if (e.button & 4) e.which = 2; // Middle
                else if (e.button & 2) e.which = 3;
            }
            if(e.which == 2) self.close();
            else self.focus();
            return false;
        })
        .dblclick(function(e){
            if (!e.which && e.button) {
                if (e.button & 1) e.which = 1;
                else if (e.button & 4) e.which = 2; // Middle
                else if (e.button & 2) e.which = 3;
            }
            if(e.which == 1) editor_highlightIDE_editor_action('fullscreen');
            return false;
        })
        .appendTo(self.tab);
    $('<a href="#" title="Close"></a>')
        .append('<img border="0" src="'+editor_highlight_path+'img/ide/close.png" />')
        .click(self.close)
        .appendTo(self.tab);
    $("#editor_highlight_ide_editor").append(self.editor);
    
    // focus and load document
    self.focus(function(){
        self.loadingStart("opening file");
        editor_highlight_call('get_file_contents', {file:file}, function(response) {
            if(response.status == 0) {
                self.loadingStop(function(){
                    editor_highlight_showMessage(response.error,1500);
                    self.close();
                });
                return;
            }
            var file_contents = response.result.contents;
            if(!file_contents) {
                self.loadingStop(function(){
                    editor_highlight_showMessage("Unable to open \""+self.name+"\"!",1500);
                    self.close();
                });
                return;
            }
            // check if file is image
            if(response.result.file_is_image) {
                self.editor.html(file_contents).addClass('image_preview');
                self.loadingStop();
            }
            else {
                $("<textarea></textarea>").appendTo(self.editor).text(file_contents);
                self.loadingStop(function(){
                    self.editor = self.editor.editor_highlight(self.file,self.change,self,function(){
                        // enable context menu hiding on focus
                        $("#jqContextMenu").hide().next('div').hide();
                    });
                    // init line numbers tooltip
                    var line_numbers = self.editor.find('.CodeMirror-gutter-text pre');
                    line_numbers.attr('title','Highligt line').tooltip();
                });
            }
        });
    });
    
    // init context menu
    self.tab.contextMenu('editor_highlight_ide_tabs_menu', {
        onShowMenu: function(event,menu) {
            editor_highlightIDE_sidebar_select($(event.currentTarget));
            return menu;
        },
        bindings: {
            'editor_highlight_tabs_close': function() {
                self.close();
            },
            'editor_highlight_tabs_close_other': function() {
                editor_highlightIDE_tabs_closeAll(self);
            },
            'editor_highlight_tabs_close_all': function() {
                editor_highlightIDE_tabs_closeAll();
            },
            'editor_highlight_tabs_close_delete': function() {
                // TODO
                alert('Delete not implemented yet');
            },
            'editor_highlight_tabs_close_download': function() {
                // TODO
                alert('Download not implemented yet');
            }
        }
    });
    
}

/**
 * Closes all tabs
 * 
 * @param exception if set this tab will not be closed
 */
function editor_highlightIDE_tabs_closeAll(exception) {
    var i = 0;
    var tabs = [];
    for(i in editor_highlightIDE_tabs) tabs[tabs.length] = editor_highlightIDE_tabs[i];
    i = 0;
    for(i in tabs) {
        if(exception && tabs[i].id == exception.id) continue;
        tabs[i].close();
    }
}

/**
 * Opens a new tab with document to edit. If the document is already opened the
 * tab will gain focus.
 */
function editor_highlightIDE_openTab(file) {
    // check if file already opened
    for(var i=0; i<editor_highlightIDE_tabs.length; i++) {
        if(editor_highlightIDE_tabs[i].file == file) {
            editor_highlightIDE_tabs[i].focus();
            return;
        }
    }
    editor_highlightIDE_tab(file);
}

/**
 * Handles tabs updated event
 * 1 - serializes tabs positions
 * 2 - handles tabs holder height
 */
function editor_highlightIDE_tabs_update() {
    // 1 --> serialize tab positions
    var files = [];
    for(var i=0; i<editor_highlightIDE_tabs.length; i++) files[files.length] = editor_highlightIDE_tabs[i].file;
    editor_highlight_call('serialize_tabs', {files:files,mode:editor_highlight_editor_mode});
    
    // 2 --> handle tabs holder height
    var tab_holder = $("#editor_highlight_ide_tabs");
    var tabs = tab_holder.find(".tab");
    // calcluate tabs width
    var width = 0;
    tabs.each(function(){width += $(this).width() + 3;});
    if(width < tab_holder.width()) {
        // set default height
        tab_holder.height(editor_highlight_IDE_TABS_DEFAULT_HEIGHT + "px");
    }
    else {
        // calculate new height
        var diff = Math.floor(width / tab_holder.width()) + 1;
        tab_holder.height((diff*editor_highlight_IDE_TABS_DEFAULT_HEIGHT) + "px");
    }
    // update entire IDE height
    editor_highlightIDE_updateHeight();    
}

/**
 * Returns a tab with a certain id
 * 
 * @param tab_id
 * @return tab or false if no tab with given id exists
 */
function editor_highlightIDE_tabs_getById(tab_id) {
    for(var i=0; i<editor_highlightIDE_tabs.length; i++) if(editor_highlightIDE_tabs[i].id == tab_id) return editor_highlightIDE_tabs[i];
    return false;
}

/**
 * Implements Shift-Tab functionality
 */
function editor_highlightIDE_tabs_switch() {
    for(var i=0; i<editor_highlightIDE_tabs.length; i++) {
        if(!editor_highlightIDE_tabs[i].focused) continue;
        if(i == editor_highlightIDE_tabs.length-1) {
            if(editor_highlightIDE_tabs.length == 1) return;
            editor_highlightIDE_tabs[i].unfocus();
            editor_highlightIDE_tabs[0].focus();
            return;
        }
        editor_highlightIDE_tabs[i].unfocus();
        editor_highlightIDE_tabs[i+1].focus();
        return;
    }
}

// ====================================================== Editor Functions =====

/**
 * Performs Editor action
 * 
 * @param action to perform
 */
function editor_highlightIDE_editor_action(action) {
    var tab = editor_highlightIDE_focusedTab;
    switch(action) {
        case 'autocomplete':
            if(tab.editor.autocomplete) tab.editor.autocomplete(tab.editor.eitor);
            break;
        case 'save_all':
            editor_highlight_showLoadingMessage('Saving all files.');
            var changed = []; var i=0;
            for(i=0; i<editor_highlightIDE_tabs.length; i++) 
                if(editor_highlightIDE_tabs[i].changed) changed[changed.length] = editor_highlightIDE_tabs[i];
            if(changed.length == 0) {
                editor_highlight_hideMessage(); // [4.3 fix]
                return;
            }
            var saved_count = 0;
            var unsaved_count = 0;
            // start saving
            for(i=0; i<changed.length; i++) {
                changed[i].editor.save(
                    function(owner){saved_count++;owner.clearChange();},
                    function(){unsaved_count++;}
                );
            }
            // wait for save to end
            var ticker = function(){
                if(saved_count + unsaved_count == changed.length) {
                    editor_highlight_hideMessage(function(){
                        editor_highlight_showMessage('Saved ' + saved_count + '/' + changed.length,2000);
                    });
                    return;
                }
                setTimeout(ticker,100);
            };
            ticker();
        case 'save':
            if(!tab) return;
            if(tab.editor.savingInProgress) return;
            editor_highlight_showLoadingMessage('Saving ' + tab.name);
            tab.editor.save(
                function(){
                    editor_highlight_hideMessage(function(){
                        editor_highlight_showMessage('File ' + tab.name + ' saved.',1500);
                        tab.clearChange();
                    });
                },
                function(){
                    editor_highlight_hideMessage(function(){
                        editor_highlight_showMessage('Error: file ' + tab.name + ' not saved.',1500);
                    });
                }
            );
            break;
        case 'find_prev':
            if(!tab) return;
            CodeMirror.commands.findPrev(tab.editor.editor);
            break;
        case 'search':
            if(!tab) return;
            CodeMirror.commands.find(tab.editor.editor);
            break;
        case 'find_next':
            if(!tab) return;
            CodeMirror.commands.findNext(tab.editor.editor);
            break;
        case 'search_replace':
            if(!tab) return;
            CodeMirror.commands.replaceAll(tab.editor.editor);
            break;
        case 'indent_left':
            if(!tab) return;
            tab.editor.editor.indentSelection('subtract');
            break;
        case 'format':
            if(!tab) return;
            tab.editor.editor.indentSelection('smart');
            break;
        case 'indent_right':
            if(!tab) return;
            tab.editor.editor.indentSelection('add'); 
            break;
        case 'undo':
            if(!tab) return;
            tab.editor.editor.undo();
            break;
        case 'redo':
            if(!tab) return;
            tab.editor.editor.redo();
            break;
        case 'goto':
            if(!tab) return;
            tab.editor.gotoLine();  
            break;
        case 'fullscreen':
            var ide = $('#editor_highlight_ide');
            if(editor_highlightIDE_fullscreen) {
                $("#editor_highlight_ide_editor").css('height','434px');
                $("#editor_highlight_ide_sidebar").css('height','434px');
                ide.removeClass('fullscreen');
                editor_highlightIDE_fullscreen = false;
                $("#wpadminbar").show();
                editor_highlightIDE_tabs_update();
            }
            else {
                $("#wpadminbar").hide();
                ide.addClass('fullscreen');
                editor_highlightIDE_fullscreen = true;
                editor_highlightIDE_tabs_update();
            }
            break;
        default:alert("["+action+"] not yet implemented!");
    }
}

/**
 * Updates entire IDE height
 */
function editor_highlightIDE_updateHeight() {
    if(editor_highlightIDE_fullscreen) {
        var ide_height = $("#editor_highlight_ide").height();
        var tabs_height = $("#editor_highlight_ide_tabs").height();
        $("#editor_highlight_ide_editor").css('height',(ide_height-editor_highlight_IDE_HEIGHT_DIFFERENCE-tabs_height)+'px');
        $("#editor_highlight_ide_sidebar").css('height',(ide_height-editor_highlight_IDE_HEIGHT_DIFFERENCE-tabs_height)+'px');
    }
}

// ===================================================== Sidebar Functions =====

/**
 * Reinits the sidebar but attempts to display the same view as before
 * 
 * @param action (string) name of the action that triggered the refresh
 * @param callback (function) perform after refresh
 */
function editor_highlightIDE_sidebar_refresh(action,callback) {
    // get selected file/folder
    var file = editor_highlightIDE_getSelectedFile();
    var li = file.parent();
    
    if(!callback) callback = false;
    
    switch(action) {
        case 'delete':
            if(li.parent().find('li').length == 1) {
                // only file/folder in parent folder
                li.parent().parent().find('a:first').dblclick();
            }
            else li.remove();
            // check if file opened and close the tab
            for(var i in editor_highlightIDE_tabs) {
                if(editor_highlightIDE_tabs[i].file == file.attr('rel')) {
                    editor_highlightIDE_tabs[i].close(true);
                    break;
                }
            }
            break;
        case 'new_file': case 'new_folder':
            var parent = (li.hasClass('directory')) ? li : li.parent().parent();
            if(parent.hasClass('directory')) {
                if(parent.hasClass('expanded')) parent.find('a:first').dblclick();
                parent.find('a:first').dblclick();
            }
            break;
        case 'paste':
            // check if delete must happen
            if(editor_highlightIDE_clipboard.mode == 'cut') {
                // check if file/folder is displayed
                var source_li = $("#editor_highlight_ide_sidebar").find("a[rel $= '"+editor_highlightIDE_clipboard.filepath.replace(editor_highlight_editor_root,'')+"']");
                if(source_li.length != 0) {
                    source_li = source_li.parent();
                    if(source_li.parent().find('li').length == 1) {
                        // only file/folder in parent folder
                        source_li.parent().parent().find('a:first').dblclick();
                    }
                    else source_li.remove();
                    // check if file opened and close the tab
                    for(var i in editor_highlightIDE_tabs) {
                        if(editor_highlightIDE_tabs[i].file == editor_highlightIDE_clipboard.filepath) {
                            editor_highlightIDE_tabs[i].close(true);
                            break;
                        }
                    }
                }
            }
            editor_highlightIDE_sidebar_refresh('new_file',callback);
            return;
    }
    
    if(callback) callback();
}

/**
 * Selects a file in the sidebar
 * 
 * @param link to the file to select
 * @param closeMenu flag to determine if to close the menu after selecting
 */
function editor_highlightIDE_sidebar_select(link,closeMenu) {
    $("#editor_highlight_ide_sidebar a").removeClass('selected');
    link.addClass('selected');
    $("#editor_highlight_ide_sidebar_filesize").text('File size: '+link.attr('filesize'));
    if(closeMenu) $("#jqContextMenu").hide().next('div').hide();
}

/**
 * Perorms Sidebar action
 * 
 * @param action
 */
function editor_highlightIDE_sidebar_action(action) {
    var file = editor_highlightIDE_getSelectedFile();
    switch(action) {
        case 'new_file':
            if(!file) {editor_highlight_showMessage('You must select a directory.', 1500);return;}
            var filename = prompt('Enter filename:', 'newfile.txt');
            if(!filename || filename == "") return;
            editor_highlight_showLoadingMessage('Creating file ' + filename);
            editor_highlight_call('create_file', {file:file.attr('rel'),filename:filename}, function(response){
                if(response.status == 0) {
                    editor_highlight_hideMessage(function(){
                        editor_highlight_showMessage(response.error,2000);
                    });
                    return;
                }
                editor_highlight_hideMessage(function(){
                    editor_highlight_showMessage(filename + ' created.',1500);
                    editor_highlightIDE_sidebar_refresh(action);
                });
            });
            break;
        case 'new_folder':
            if(!file) {editor_highlight_showMessage('You must select a directory.', 1500);return;}
            var dirname = prompt('Enter folder name:', 'newfolder');
            if(!dirname || dirname == "") return;
            editor_highlight_showLoadingMessage('Creating folder ' + dirname);
            editor_highlight_call('create_folder', {file:file.attr('rel'),dirname:dirname}, function(response){
                if(response.status == 0) {
                    editor_highlight_hideMessage(function(){
                        editor_highlight_showMessage(response.error,2000);
                    });
                    return;
                }
                editor_highlight_hideMessage(function(){
                    editor_highlight_showMessage(dirname + ' created.',1500);
                    editor_highlightIDE_sidebar_refresh(action);
                });
            });
            break;
        case 'delete':
            if(!file) {editor_highlight_showMessage('Select a file/dir to delete.', 1500);return;}
            var filepath = file.attr('rel');
            var filename = filepath.split('/').pop();
            if(filename == "") filename = "folder with all files and subfolders";
            if(!confirm('Delete '+filename+'?')) return;
            editor_highlight_showLoadingMessage('Deleting ' + filename);
            editor_highlight_call('delete_file', {filename:filepath}, function(response){
                if(response.status == 0) {
                    editor_highlight_hideMessage(function(){
                        editor_highlight_showMessage(response.error,2000);
                    });
                    return;
                }
                editor_highlight_hideMessage(function(){
                    editor_highlight_showMessage(filename + ' deleted.',1500)
                    editor_highlightIDE_sidebar_refresh(action);
                });
            });
            break;
        case 'cut':
            if(!file) {editor_highlight_showMessage('Select a file/dir to cut.', 1500);return;}
            editor_highlightIDE_clipboard_cut(file.attr('rel'));
            break;
        case 'copy':
            if(!file) {editor_highlight_showMessage('Select a file/dir to copy.', 1500);return;}
            editor_highlightIDE_clipboard_copy(file.attr('rel'));
            break;
        case 'paste':
            if(!file) {editor_highlight_showMessage('You must select where to paste.', 1500);return;}
            editor_highlightIDE_clipboard_paste(file);
            break;
        case 'upload':
            if(!file) {editor_highlight_showMessage('You must select where to upload.', 1500);return;}
            // TODO: implement
            alert("Not yet implemented!");
            break;
        case 'download':
            if(!file) {editor_highlight_showMessage('Select a file/dir to download.', 1500);return;}
            // TODO: implement
            alert("Not yet implemented!");
            break;
        default:editor_highlight_showMessage('Unknown control.', 1500);
    }
}

/**
 * Returns the anchor element of the file selected in the Sidebar 
 * 
 * @return file_link or false if no files are selected
 */
function editor_highlightIDE_getSelectedFile() {
    var selected = $("#editor_highlight_ide_sidebar a.selected");
    if(selected.length == 0) return false;
    return selected;
}

// ======================================================== Init Functions =====

/**
 * Checks if there are unsaved changed documents in the Editor and asks the 
 * user if he wants to exit without saving.
 * 
 * @return question_text or null
 */
function editor_highlightIDE_checkBeforeExit(event) {
    var changed = 0;
    for(var i=0; i<editor_highlightIDE_tabs.length; i++) if(editor_highlightIDE_tabs[i].changed) changed++;
    if(changed > 0) return "Exit without saving?";
    return null;
}

/**
 * Initializes editor_highlight file browsing Sidebar
 * - initializes jqueryFileTree script to render file browsing
 * - initializes contextmenu script to render menus
 */
function editor_highlightIDE_initSidebar(initCallback) {
    $("#editor_highlight_ide_sidebar").fileTree({
        root: editor_highlight_editor_root,
        script: editor_highlight_path+"php/tree.php",
        folderEvent: "dblclick",
        selectCallback : editor_highlightIDE_sidebar_select,
        linkBinding: function(link) {
            link.attr("id","sidebar_link_" + Math.floor(Math.random()*1000000));
            link.contextMenu('editor_highlight_ide_sidebar_menu', {
                onShowMenu: function(event,menu) {
                    editor_highlightIDE_sidebar_select($(event.currentTarget));
                    return menu;
                },
                bindings: {
                    'editor_highlight_sidebar_new_file': function() {
                        editor_highlightIDE_sidebar_action('new_file');
                    },
                    'editor_highlight_sidebar_new_folder': function() {
                        editor_highlightIDE_sidebar_action('new_folder');
                    },
                    'editor_highlight_sidebar_delete': function() {
                        editor_highlightIDE_sidebar_action('delete');
                    },
                    'editor_highlight_sidebar_cut': function() {
                        editor_highlightIDE_sidebar_action('cut');
                    },
                    'editor_highlight_sidebar_copy': function() {
                        editor_highlightIDE_sidebar_action('copy');
                    },
                    'editor_highlight_sidebar_paste': function() {
                        editor_highlightIDE_sidebar_action('paste');
                    },
                    'editor_highlight_sidebar_upload': function() {
                        editor_highlightIDE_sidebar_action('upload');
                    },
                    'editor_highlight_sidebar_download': function() {
                        editor_highlightIDE_sidebar_action('download');
                    }
                }
            });
        }
    }, 
    editor_highlightIDE_openTab, (initCallback) ? initCallback : false);
}

/**
 * Initializes all editor_highlight keyboard bindings
 * - key bindings for editors
 * - key bindings for the file browsing Sidebar
 */
function editor_highlightIDE_initKeyBindings() {
    
    // editor key bindings
    var bindings = {
        'Ctrl+Space' : function(event){ 
            editor_highlightIDE_editor_action('autocomplete'); 
        },
        'Ctrl+s' : function(event){ 
            editor_highlightIDE_editor_action('save'); 
        },
        'Ctrl+Shift+s' : function(event){ 
            editor_highlightIDE_editor_action('save_all'); 
        },
        'Ctrl+f' : function(event){ 
            editor_highlightIDE_editor_action('search'); 
        },
        'Ctrl+r' : function(event){ 
            editor_highlightIDE_editor_action('search_replace'); 
        },
        'Ctrl+left' : function(event){ 
            editor_highlightIDE_editor_action('find_prev'); 
        },
        'Ctrl+right' : function(event){ 
            editor_highlightIDE_editor_action('find_next'); 
        },
        'Alt+Shift+left' : function(event){ 
            editor_highlightIDE_editor_action('indent_left'); 
        },
        'Alt+Shift+right' : function(event){ 
            editor_highlightIDE_editor_action('indent_right'); 
        },
        'Alt+Shift+f' : function(event){ 
            editor_highlightIDE_editor_action('format'); 
        },
        'Ctrl+z' : function(event){ 
            editor_highlightIDE_editor_action('undo'); 
        },
        'Ctrl+y' : function(event){ 
            editor_highlightIDE_editor_action('redo'); 
        },
        'Ctrl+g' : function(event){ 
            editor_highlightIDE_editor_action('goto'); 
        },
        'Alt+return' : function(event){ 
            editor_highlightIDE_editor_action('fullscreen'); 
        },
        'Shift+Tab' : editor_highlightIDE_tabs_switch
    };
    for(var index in bindings) shortcut.add(index,bindings[index]);
    
    // sidebar key bindings
    $("#editor_highlight_ide_sidebar")
        .hover(function() {this.focus();}, function() {this.blur();})
        .live('keyup',function(e){
        var file = editor_highlightIDE_getSelectedFile();if(!file) return;
        var keycode = e ? e.which : window.event.keyCode;
        switch(keycode) {
            case $.ui.keyCode.ENTER:
                file.dblclick();
                break;
            case $.ui.keyCode.DELETE:
                editor_highlightIDE_sidebar_action('delete');
                break;
            case $.ui.keyCode.UP:
                var prev = file.parent().prev();
                if(prev.length == 0) {
                    var parent = file.parent().parent().parent();
                    if(parent.is('li')) editor_highlightIDE_sidebar_select(parent.find('a:first'),true);
                    return;
                }
                if(prev.hasClass('directory') && prev.hasClass('expanded')) {
                    var link = prev.find('ul li:last a');
                    if(link.length != 0) editor_highlightIDE_sidebar_select(link,true);
                }
                else editor_highlightIDE_sidebar_select(prev.find('a:first'),true);
                break;
            case $.ui.keyCode.DOWN:
                if(file.parent().hasClass('directory') && file.parent().hasClass('expanded')) {
                    var link = file.parent().find('ul li:first a');
                    if(link.length != 0) {
                        editor_highlightIDE_sidebar_select(link,true);
                        return;
                    }
                }
                var next = file.parent().next();
                if(next.length == 0) {
                    var next_folder = file.parent('li').parent('ul').parent('li').next('li');
                    if(next_folder.length == 0) return;
                    editor_highlightIDE_sidebar_select(next_folder.find('a:first'),true);
                    return;
                }
                editor_highlightIDE_sidebar_select(next.find('a:first'),true);
                break;
            case $.ui.keyCode.HOME:
                editor_highlightIDE_sidebar_select(file.parent().parent().find("li:first a"),true);
                break;
            case $.ui.keyCode.END:
                editor_highlightIDE_sidebar_select(file.parent().parent().find("li:last a"),true);
                break;
            case $.ui.keyCode.LEFT:
                if(file.parent().hasClass('directory')) {
                    if(file.parent().hasClass('expanded')) {
                        file.dblclick();
                        return;
                    }
                }
                var parent = file.parent().parent().parent();
                if(parent.is('li')) {
                    var link = parent.find('a:first');
                    link.dblclick();
                    editor_highlightIDE_sidebar_select(link,true);
                }
                break;
            case $.ui.keyCode.RIGHT:
                if(file.parent().hasClass('directory') && file.parent().hasClass('collapsed')) file.dblclick();
                break;
        }
    });
}

/**
 * Initializes editor_highlight editor tabs
 * - makes tabs sortable
 * - performs deserialization for previously opened documents
 */
function editor_highlightIDE_initTabs() {
    // make tabs sortable
    $('#editor_highlight_ide_tabs').sortable({
        cursor: "move",
        start: function(event, ui) {
            var tab = $(ui.item);
            editor_highlightIDE_tabs_sortStartIndex = $('#editor_highlight_ide_tabs .tab').index(tab);
        },
        update: function(event, ui){
            var tab = $(ui.item);
            var new_index = $('#editor_highlight_ide_tabs .tab').index(tab);
            var old_index = editor_highlightIDE_tabs_sortStartIndex;
            if(new_index != old_index) {
                var saved_tabs = editor_highlightIDE_tabs.splice(old_index, 1);
                editor_highlightIDE_tabs.splice(new_index,0,saved_tabs[0]);
            }
            tab.find('.file_link').click();
        }
    }).disableSelection();
    
    // handle serialized tabs
    if(editor_highlight_serialized_tabs && editor_highlight_serialized_tabs.length != 0) 
    for(var i=0; i<editor_highlight_serialized_tabs.length; i++) {
        var tab = editor_highlight_serialized_tabs[i];
        setTimeout('editor_highlightIDE_openTab("'+tab+'")',i*400);
        // when last tab is opened, focus on first [4.3 fix]
        if(i == editor_highlight_serialized_tabs.length-1) setTimeout(function(){
            editor_highlightIDE_tabs[0].focus();
        },i*401);
    }
}

/**
 * Initializes editor_highlight IDE
 * - calls editor_highlight service to render the IDE
 * - initalizes file browsing Sidebar
 * - binds window exit and resize events, keyboard events
 */
function editor_highlightIDE_init() {
    // bind checking for opened documents before exit
    window.onbeforeunload = editor_highlightIDE_checkBeforeExit;
    
    // bind resize to IDE editor
    $(window).resize(editor_highlightIDE_tabs_update);
    
    // bind click events to line numbers
    $('.CodeMirror-gutter-text pre').live('click',function(){
        var line = Number($.trim($(this).text()))-1;
        var tab = editor_highlightIDE_tabs_getById($(this).parents('.editor_highlight_ide_file:first').attr('rel'));
        if(!tab) return;
        if(!tab.editor.editor.getLineHandle(line)) return;
        tab.editor.editor.setCursor(line,0);
        tab.editor.editor.setSelection(
            {line:line, ch:0},
            {line:line+1, ch:0}
        );
        tab.editor.editor.focus();
    });
    
    // load editor_highlight IDE
    editor_highlight_showLoadingMessage('Initializing editor_highlight IDE');
    editor_highlight_call('get_ide', {editor_mode: editor_highlight_editor_mode}, function(response){
        if(response.status == 0) {
            editor_highlight_hideMessage(function(){
                editor_highlight_showMessage('Unable to load editor_highlight IDE: ' + response.error,2000);
            });
            return;
        }
        // append HTML
        $(".wrap").append(response.result);
        editor_highlight_hideMessage(function(){
            editor_highlightIDE_initSidebar();
            editor_highlightIDE_initKeyBindings();
            editor_highlightIDE_initTabs();
        });
    });
}

// ================================================ On Load Initialization =====

$(function(){
    // set context menu defaults
    $.contextMenu.defaults({
        itemStyle : {
            "border" : "none",
            "font-size": "10px",
            "cursor": "pointer"
        },
        itemHoverStyle : {
            "background-color" : "#BDF",
            "border" : "none"
        },
        shadow: true
    });
    
    // remove WordPress components
    $("#template").remove();
    $("#templateside").remove();
    $(".wrap .fileedit-sub").remove();
    
    // init editor_highlight IDE
    editor_highlightIDE_init();
});