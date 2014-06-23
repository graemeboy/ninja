myMarkdownSettings = {
    nameSpace:          'markdown', // Useful to prevent multi-instances CSS conflict
    previewParserPath:  '~/sets/markdown/preview.php',
    onShiftEnter:       {keepDefault:false, openWith:'\n\n'},
    markupSet: [
        {name:'First Level Heading', key:"1", HTMLContent: 'H1', placeHolder:'Your title here...', closeWith:function(markItUp) { return miu.markdownTitle(markItUp, '=') } },
        {name:'Second Level Heading', key:"2", HTMLContent: 'H2', placeHolder:'Your title here...', closeWith:function(markItUp) { return miu.markdownTitle(markItUp, '-') } },
        {name:'Heading 3', key:"3", openWith:'### ', HTMLContent: 'H3', placeHolder:'Your title here...' },
        {name:'Heading 4', key:"4", openWith:'#### ', HTMLContent: 'H4', placeHolder:'Your title here...' },
        {name:'Bold"', key:"B", HTMLContent: '<i class="fa fa-bold"></i>', openWith:'**', closeWith:'**'},
        {name:'Italic', key:"I", openWith:'_', HTMLContent: '<i class="fa fa-italic"></i>', closeWith:'_'},
        {name:'Bulleted List', HTMLContent: '<i class="fa fa-list"></i>', openWith:'- ' },
        {name:'Numeric List', HTMLContent: '<i class="fa fa-list-ol"></i>', openWith:function(markItUp) {
            return markItUp.line+'. ';
        }},
        {name:'Picture', key:"P", HTMLContent: '<i class="fa fa-picture-o"></i>', replaceWith:'![[![Alternative text]!]]([![Url:!:http://]!] "[![Title]!]")'},
        {name:'Link', HTMLContent: '<i class="fa fa-chain"></i>',  key:"L", openWith:'[', closeWith:']([![Url:!:http://]!] "[![Title]!]")', placeHolder:'Your text to link here...' },
        {name:'Quotes', HTMLContent: '<i class="fa fa-quote-left"></i>',  openWith:'> '},
        {name:'Code Block / Code', openWith:'(!(\t|!|`)!)', HTMLContent: '<i class="fa fa-code"></i>', closeWith:'(!(`)!)'},
    ]
}

// mIu nameSpace to avoid conflict.
miu = {
    markdownTitle: function(markItUp, char) {
        heading = '';
        n = $.trim(markItUp.selection||markItUp.placeHolder).length;
        for(i = 0; i < n; i++) {
            heading += char;
        }
        return '\n'+heading+'\n';
    }
}