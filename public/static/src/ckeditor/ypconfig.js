var baseUrl = '/static/';

CKEDITOR.editorConfig = function (config) {
    config.language = 'zh-cn';
    config.filebrowserUploadUrl = '/api/ckupload';
	// Toolbar


	config.extraPlugins ='codesnippet';
	config.codeSnippet_theme = 'monokai_sublime';
	config.height="360";


};