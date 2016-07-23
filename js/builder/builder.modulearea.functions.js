/**
 * Functions powering Module Areas functionality
 *
 * = AREAS ( MODULE AREAS ) =
 *
 * - Actions/Events (Duplicate, Change Width, Delete, ...)
 * - dslc_modules_area_add ( Adds a new modules area )
 * - dslc_modules_area_delete ( Deletes modules area )
 * - dslc_modules_area_width_set ( Sets specific width to the modules area )
 * - dslc_copy_modules_area ( Copies modules area )
 *
 */

'use strict';

/**
 * Module Area Actions (Duplicate, Change Width, Delete, ...)
 *
 * Attach these actions once the editing iFrame loaded.
 */

;jQuery(document).on('editorFrameLoaded', function(){

	function init_sortables() {

		var el = jQuery('.dslc-modules-area', DSLC.Editor.frame); // Groups that can hold modules

		jQuery(el).each(function (i,e) {

			new DSLC.Editor.CModuleArea(e);
		});
	}

	/**
	 * Action - Automatically Add a Row if Empty
	 */
	if ( ! jQuery( '#dslc-main .dslc-modules-section', DSLC.Editor.frame).length && ! jQuery( '#dslca-tut-page', DSLC.Editor.frame).length ) {

		dslc_row_add().then(function(row){

			init_sortables();
		});
	} else {

		init_sortables();
	}

	/**
	 * Hook - Copy Module Area
	 */
	DSLC.Editor.frame.on( 'click', '.dslca-copy-modules-area-hook', function(e){

		e.preventDefault();

		if ( ! jQuery(this).hasClass('dslca-action-disabled') ) {

			var modulesArea = jQuery(this).closest('.dslc-modules-area');
			dslc_copy_modules_area( modulesArea );
		}
	});

	/**
	 * Hook - Delete Module Area
	 */
	DSLC.Editor.frame.on( 'click', '.dslca-delete-modules-area-hook', function(e){

		e.preventDefault();

		if ( ! jQuery(this).hasClass('dslca-action-disabled') ) {

			// Check if current modules area is empty.
			var modulesAreaEmpty = jQuery(this).closest('.dslc-modules-area').hasClass('dslc-modules-area-empty');

			if ( ! modulesAreaEmpty ) {

				// Show confirmation modal only if the module area isn't empty.
				dslc_js_confirm( 'delete_modules_area', '<span class="dslca-prompt-modal-title">' + DSLCString.str_del_area_title +
					'</span><span class="dslca-prompt-modal-descr">' + DSLCString.str_del_area_descr + '</span>', jQuery(this) );
			} else {

				var modulesArea = jQuery(this).closest('.dslc-modules-area');
				// Delete module area without asking anything.
				dslc_delete_modules_area( modulesArea );
			}
		}
	});

	/**
	 * Hook - Set Width of the Module Area
	 */
	DSLC.Editor.frame.on( 'click', '.dslca-change-width-modules-area-options span', function(){

		if ( ! jQuery(this).hasClass('dslca-action-disabled') ) {
			dslc_modules_area_width_set( jQuery(this).closest('.dslc-modules-area'), jQuery(this).data('size') );
		}

	});

	/**
	 * Action - Show/Hide Width Options for the Module Area
	 */
	DSLC.Editor.frame.on( 'click', '.dslca-change-width-modules-area-hook', function(e){

		e.preventDefault();

		if ( ! jQuery(this).hasClass('dslca-action-disabled') ) {

			// Is visible
			if ( jQuery('.dslca-change-width-modules-area-options:visible', this).length ) {

				// Hide
				jQuery('.dslca-change-width-modules-area-options', this).hide();

			// Is hidden
			} else {

				// Set active
				jQuery('.dslca-change-width-modules-area-options .dslca-active-width', DSLC.Editor.frame).removeClass('dslca-active-width');
				var currSize = jQuery(this).closest('.dslc-modules-area').data('size');
				jQuery('.dslca-change-width-modules-area-options span[data-size="' + currSize + '"]', DSLC.Editor.frame).addClass('dslca-active-width');

				// Show
				jQuery('.dslca-change-width-modules-area-options', this).show();
			}
		}
	});

	/**
	 * Hook - Add Modules Area
	 * TODO: Where we use it? Delete maybe?
	 */
	DSLC.Editor.frame.on( 'click', '.dslca-add-modules-area-hook', function(e){

		e.preventDefault();

		dslc_modules_area_add( jQuery(this).closest('.dslc-modules-section').find('.dslc-modules-section-inner') );
	});

});

/**
 * AREAS - Add New
 */

function dslc_modules_area_add( row ) {

	if ( dslcDebug ) console.log( 'dslc_add_modules_area' );

	// Add class to body so we know it's in progress
	// jQuery('body', DSLC.Editor.frame).addClass('dslca-anim-in-progress');

	var output = '<div class="dslc-modules-area dslc-col dslc-12-col dslc-modules-area-empty " data-size="12">'+
	'<div class="dslca-modules-area-manage"> <div class="dslca-modules-area-manage-inner">'+
	'<span class="dslca-manage-action dslca-copy-modules-area-hook" title="Duplicate" ><span class="dslca-icon dslc-icon-copy">'+
	'</span></span> <span class="dslca-manage-action dslca-move-modules-area-hook" title="Drag to move" >'+
	'<span class="dslca-icon dslc-icon-move"></span></span>'+
	'<span class="dslca-manage-action dslca-change-width-modules-area-hook" title="Change width" >'+
	'<span class="dslca-icon dslc-icon-columns"></span> <div class="dslca-change-width-modules-area-options">'+
	'<span>Container Width</span><span data-size="1">1/12</span><span data-size="2">2/12</span>'+
	'<span data-size="3">3/12</span><span data-size="4">4/12</span> <span data-size="5">5/12</span><span data-size="6">6/12</span>'+
	'<span data-size="7">7/12</span><span data-size="8">8/12</span> <span data-size="9">9/12</span><span data-size="10">10/12</span>'+
	'<span data-size="11">11/12</span><span data-size="12">12/12</span> </div> </span>'+
	'<span class="dslca-manage-action dslca-delete-modules-area-hook" title="Delete" ><span class="dslca-icon dslc-icon-remove"></span></span> </div> </div>'+
	'</div>';


	// Append new area and animate
	jQuery( output ).appendTo( row ).css({ height : 0 }).animate({
		height : 99
	}, 300, function(){
		jQuery(this).css({ height : 'auto' });
	}).addClass('dslca-init-animation');


	// Re-initialize all the empty areas on the page
	var emptyModuleAreas = jQuery('.dslc-modules-area-empty', DSLC.Editor.frame);

	jQuery(emptyModuleAreas).each(function (i,e) {

		new DSLC.Editor.CModuleArea(e);
	});

	// Call other functions
	dslc_drag_and_drop();
	dslc_generate_code();
	dslc_show_publish_button();

	// Remove class from body so we know it's done
	// jQuery('body', DSLC.Editor.frame).removeClass('dslca-anim-in-progress');
}

/**
 * AREAS - Delete
 */

function dslc_modules_area_delete( area ) {

	if ( dslcDebug ) console.log( 'dslc_delete_modules_area' );

	// Vars
	var modulesSection = area.closest('.dslc-modules-section').find('.dslc-modules-section-inner'),
	dslcDeleteSectionToo = false;

	// Add a class to the area so we know it's being deleted
	area.addClass('dslca-modules-area-being-deleted');

	// If it's the last area in the row delete section as well
	if ( modulesSection.find('.dslc-modules-area').length < 2 ) {
		dslcDeleteSectionToo = true;
	}

	// If a module in the area is being edited
	if ( area.find('.dslca-module-being-edited').length ) {

		// Hide the filter hooks
		jQuery('.dslca-header .dslca-options-filter-hook', DSLC.Editor.frame).hide();

		// Hide the save/cancel actions
		jQuery('.dslca-module-edit-actions', DSLC.Editor.frame).hide();

		// Show the section hooks
		jQuery('.dslca-header .dslca-go-to-section-hook', DSLC.Editor.frame).show();

		// Show the modules listing
		dslc_show_section('.dslca-modules');

	}

	// Set a timeout so we handle deletion after animation ends
	setTimeout( function(){

		// Delete section if no more module areas inside.
		if ( dslcDeleteSectionToo ) {

			var parentSectionContainer = area.closest('.dslc-modules-section-inner');
			// dslc_modules_area_add( modulesSection );

			// Don't delete latest module area in the latest section on the page
			if (2 <= area.closest('#dslc-main').find('.dslc-modules-section').length ) {

				dslc_row_delete( area.closest('.dslc-modules-section') );
			} else {

				// Remove the area
				area.remove();
				// Create new empty area in current module section
				dslc_modules_area_add( modulesSection );
			}
		}

		// Remove the area
		area.remove();


		// Call other functions
		dslc_generate_code();
		dslc_show_publish_button();
	}, 900 );

	// Animation
	area.css({
		'-webkit-animation-name' : 'dslcBounceOut',
		'-moz-animation-name' : 'dslcBounceOut',
		'animation-name' : 'dslcBounceOut',
		'animation-duration' : '0.6s',
		'-webkit-animation-duration' : '0.6s',
		'overflow' : 'hidden'
	}).animate({
		opacity : 0
	}, 600).animate({
		height : 0,
		marginBottom : 0
	}, 300, function(){
		area.remove();
		dslc_generate_code();
		dslc_show_publish_button();
	});
}

/**
 * AREAS - Copy
 */

function dslc_modules_area_copy( area ) {

	if ( dslcDebug ) console.log( 'dslc_copy_modules_area' );

	// Vars
	var dslcModuleID,
	modulesSection = area.closest('.dslc-modules-section').find('.dslc-modules-section-inner');

	// Copy the area and append to the row
	var dslcModulesAreaCloned = area.clone().appendTo(modulesSection);

	new DSLC.Editor.CModuleArea(dslcModulesAreaCloned[0]);

	// Trigger mouseleave ( so the actions that show on hover go away )
	dslcModulesAreaCloned.find('.dslca-modules-area-manage').trigger('mouseleave');

	// Apply correct data size and get rid of animations
	dslcModulesAreaCloned.data('size', area.data('size') ).find('.dslc-module-front').css({
		'-webkit-animation-name' : 'none',
		'-moz-animation-name' : 'none',
		'animation-name' : 'none',
		'animation-duration' : '0',
		'-webkit-animation-duration' : '0',
		opacity : 0

	// Go through each module in the area
	}).each(function(){

		var dslcModule = jQuery(this);

		// Reguest new ID
		jQuery.ajax({
			type: 'POST',
			method: 'POST',
			url: DSLCAjax.ajaxurl,
			data: { action : 'dslc-ajax-get-new-module-id' },
			async: false
		}).done(function( response ) {

			// Remove being edited class
			jQuery('.dslca-module-being-edited', DSLC.Editor.frame).removeClass('dslca-module-being-edited');

			// Store the new ID
			dslcModuleID = response.output;

			// Apply the new ID and add being edited class
			dslcModule.data( 'module-id', dslcModuleID ).attr( 'id', 'dslc-module-' + dslcModuleID ).addClass('dslca-module-being-edited');

			// Reload the module
			dslc_module_output_altered( function(){

				// Remove being edited class and show the module
				jQuery('.dslca-module-being-edited', DSLC.Editor.frame).removeClass('dslca-module-being-edited').animate({
					opacity : 1
				}, 300);

			});

		});

	});

	// Call other functions
	dslc_drag_and_drop();
	dslc_generate_code();
	dslc_show_publish_button();

}

/**
 * AREAS - Set Width
 */
function dslc_modules_area_width_set( area, newWidth ) {

	if ( dslcDebug ) console.log( 'dslc_modules_area_width_set' );

	// Generate new class based on width
	var newClass = 'dslc-' + newWidth + '-col';

	// Remove width classes, add new width class and set the data-size attr
	area
		.removeClass('dslc-1-col dslc-2-col dslc-3-col dslc-4-col dslc-5-col dslc-6-col dslc-7-col dslc-8-col dslc-9-col dslc-10-col dslc-11-col dslc-12-col')
		.addClass(newClass)
		.data('size', newWidth);

	// Call other functions
	dslc_generate_code();
	dslc_show_publish_button();
	DSLC.Editor.frameContext.dslc_masonry();

}

/**
 * Deprecated Functions and Fallbacks
 */

function dslc_add_modules_area( row ) { dslc_modules_area_add( row ); }
function dslc_delete_modules_area( area ) { dslc_modules_area_delete( area ); }
function dslc_copy_modules_area( area ) { dslc_modules_area_copy( area ); }