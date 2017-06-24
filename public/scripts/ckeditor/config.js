/**
 * @license Copyright (c) 2003-2015, CKSource - Frederico Knabben. All rights reserved.
 * For licensing, see LICENSE.md or http://ckeditor.com/license
 */

CKEDITOR.editorConfig = function( config ) {
	// Define changes to default configuration here. For example:
	// config.language = 'fr';
	// config.uiColor = '#AADC6E';

	config.resize_dir = 'vertical';
	config.contentsCss = 'http://'+window.location.host +'/scripts/ckeditor/contents.css';
	config.enterMode = CKEDITOR.ENTER_BR;
	config.font_defaultLabel = 'Arial';
	config.fontSize_defaultLabel = '12px';   
};
