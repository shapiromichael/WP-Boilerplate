// =============================================================================
// File: synchi.js
// Version: 1.0
// 
// Synchi global
// =============================================================================

if(!synchi_settings) synchi_settings = {
    fontSize: "14",
    lineNumbers: true,
    lineWrapping: true,
    matchBrackets: true,
    indentUnit: 4,
    indentWithTabs: false,
    theme: "default"
};

// enable concat function for JSON objects
if (!$.concat) $.extend({
    concat: function(a, b) { 
        var merged = {};
        for (var attr_a in a) merged[attr_a] = a[attr_a];
        for (var attr_b in b) merged[attr_b] = b[attr_b];
        return merged;
    }
});

// enable merge function for arrays
if (!$.merge) $.extend({
    marge: function(a, b) { 
        var merged = [];
        for (var attr_a in a) merged[merged.length] = a[attr_a];
        for (var attr_b in b) merged[merged.length] = b[attr_b];
        return merged;
    }
});


// calls an ajax synchi action
function synchi_call(action,params,onSuccess,onError,noJSON) {
    params = $.concat(params,{synchi_action:action});
    if(!onError) onError = function(){
        // TODO: handle error
    };
    $.ajax({
        type: 'POST',
        url: "admin.php",
        data: params,
        dataType: (noJSON) ? "text/html" : "json",
        success: onSuccess,
        error: onError
    });
}

/**
 * Shows a floating transparent message
 * 
 * @param text message text
 * @param timeout time to wait and hide (if null, message stays)
 */
function synchi_showMessage(text,timeout) {
    var message = $('<div class="synchi_mesageBox"><span>'+text+'</span></div>');
    $('body').append(message);
    if(timeout) setTimeout(synchi_hideMessage,timeout);
}


/**
 * Shows a floating transparent message with loading image
 * 
 * @param text message text
 * @param timeout time to wait and hide (if null, message stays)
 */
function synchi_showLoadingMessage(text,timeout) {
    text = '<img src="'+synchi_path+'img/loading.gif" border="0" /><br />' + text;
    if(!timeout) timeout = false;
    synchi_showMessage(text,timeout)
}

/**
 * Hides the floating transparent message
 * 
 * @param callback perform after hiding
 */
function synchi_hideMessage(callback) {
    var message = $('.synchi_mesageBox');
    if(message.length == 0) return;
    message.fadeOut(300, function(){ 
        message.remove();
        if(callback) callback();
    });
}


$(function(){
    
    $.fn.synchi = function(file,onChange,owner,onFocus) {
        // define self
        var self = $(this); 
        self.owner = (owner) ? owner : {};
        
        // check textarea exists
        if(self.find('textarea').length == 0) return false;
        
        // init self
        self.textarea = self.find('textarea').get(0);
        self.file = file;
        self.mode = 'unknown';
        self.savingInProgress = false;
        self.line = null;
        self.message = null;
        self.onChange = (onChange) ? onChange : function(){};
        
        // init CodeMirror
        var extension = $(self.file.split('.')).last().get(0);
        switch(extension) {
            case 'css':self.mode = 'css';break;
            case 'js':self.mode = 'javascript';break;
            case 'html': case 'htm':self.mode = 'text/html';break;
            case 'sql':self.mode = 'mysql';break;
            case 'php':self.mode = 'application/x-httpd-php';break;
            case 'xml':self.mode = 'xml';break;
            case 'txt':self.mode = 'txt';break;
            default:return false;
        }
        self.editor =  CodeMirror.fromTextArea(self.textarea,$.concat(synchi_settings,{
            mode: self.mode,
            tabMode: "indent",
            onCursorActivity: function() {
//                self.editor.setLineClass(self.line, null, null);
//                self.line = self.editor.setLineClass(
//                    self.editor.getCursor().line, 
//                    null, "synchi_activeline"
//                );
                // self.editor.matchHighlight("CodeMirror-searching");
            },
            onChange: function(){
                self.editor.save();
                self.onChange();
            },
            onFocus : (onFocus) ? onFocus : function() {}
        }));
        
        // set first line active line
        self.line = self.editor.setLineClass(0, "synchi_activeline");
        
        self.save = function(success_callback,error_callback) {
            if(self.savingInProgress) return false;
            self.savingInProgress = true;
            $(self.textarea).text(self.editor.getValue());
            synchi_call('save_file', {'file' : self.file, 'contents': self.editor.getValue()}, 
                function() { self.savingInProgress = false; success_callback(self.owner); },
                function() { self.savingInProgress = false; error_callback(self.owner); }
            );
            return true;
        }
        
        self.gotoLine = function() {
            self.editor.openDialog('Go to line: <input type="text" style="width: 10em"/>',
                function(line){
                    if(!line) return;
                    line = Number(line-1);
                    if(!self.editor.getLineHandle(line)) return;
                    self.editor.setCursor(line,0);
                    self.editor.setSelection(
                        {line:line, ch:0},
                        {line:line+1, ch:0}
                    );
                    self.editor.focus();
                }); 
        };
        
        // handle autoformat functions
        switch(self.mode) {
            case 'javascript':
                self.autocomplete = function(cm) {
                    CodeMirror.simpleHint(self.editor, CodeMirror.javascriptHint);
                }
                break;
            case 'application/x-httpd-php':
                self.autocomplete = function(cm) {
                    CodeMirror.simpleHint(self.editor, CodeMirror.phpHint);
                }
                break;
        }
        
        return self;
    }
    
});