/**
 * Form Builder Process Javascript
 *
 * JS used by the ProcessFormBuilder module
 *
 * Copyright (C) 2020 by Ryan Cramer 
 *
 * PLEASE DO NOT DISTRIBUTE
 *
 */

function ProcessFormBuilder() {
	
	var $ = jQuery;

	// may be form editor form or field editor form
	var $formEditor = $('#ProcessFormBuilder'); 

	// the asmSelect holding the list of form fields, present only when editing a form
	var $formFields = $('#form_fields');
	
	// whether or not we are in the form editor
	var isEditForm = $formFields.length > 0;

	// whether or not we are in the init/setup stage
	var inSetup = true;
	
	/**
	 * Form Editor: Setup modal editing of fields
	 * 
	 */
	function setupModalFieldEditor() {

		var $asmEditItem = null; // item clicked on to edit
		var allowCloseDialog = true;

		$(document).on('mousedown', '#wrap_form_fields .asmListItem a', function() {
			$asmEditItem = $(this).closest('li');
			allowCloseDialog = false;
			// console.log('editing: ' + $li.find('.asmListItemLabel').text());
		});

		// if the window close "x" is clicked on then don't block it
		$(document).on('mousedown', '.ui-dialog-titlebar-close', function() {
			allowCloseDialog = true;
		});

		// determine if any errors occur in follow-up load before allowing dialog to close
		$(document).on("dialogbeforeclose", function(event, ui) {

			var $iframe = $(event.target);
			var $contents = $iframe.contents();

			// abort if no edit item was clicked on 
			if(!$asmEditItem || !$asmEditItem.length) return;

			// abort if in some dialog other than field editor
			if($contents.find("#ProcessFormBuilder").length	< 1) return;

			if(allowCloseDialog) {
			
				var $columnWidth = $contents.find("#columnWidth");
				var columnWidth = $columnWidth.length ? parseInt($columnWidth.val()) : 0;
				var fieldName = $contents.find("#field_name").val();
				var fieldType = $contents.find("#Inputfield_field_type").val();
				var fieldLabel = $contents.find("#Inputfield_field_label").val();
				var required = $contents.find('#Inputfield_required').is(':checked') ? '*': '';
				var $requiredIf = $contents.find('#Inputfield_requiredIf'); 
				
				if(required.length && $requiredIf.length && $requiredIf.val().length) required += '*';
				required = "<span class='inputRequired'>" + required + "</span>";
				
				//var $showIf = $contents.find('#Inputfield_showIf');
				//if($showIf.length && $showIf.val().length) required += '‡';
				
				if(columnWidth > 99 || columnWidth < 1) columnWidth = 100;
				columnWidth = "<span class='columnWidth ui-priority-secondary' data-was='" + columnWidth + "'>" + columnWidth + "%</span>";
				
				fieldType = fieldType.replace('FormBuilder', ''); 
				fieldType = fieldType.replace(/([A-Z][^A-Z])/g, ' $1'); 
				fieldType = "<span class='inputType'>" + fieldType + "</span>";
				
				$asmEditItem.find(".asmListItemStatus").html(required + fieldType + ' ' + columnWidth);
				$asmEditItem.find(".asmListItemDesc > a").text(fieldLabel);
				$asmEditItem.find(".asmListItemLabel > a").text(fieldName);
			}

			$iframe.load(function() {
				// after submit, check for errors
				$contents = $iframe.contents();
				// errors, don't allow close
				if($contents.find(".NoticeError").length) return;
				// if here, then no errors occurred so we can close the dialog
				allowCloseDialog = true;
				$(".ui-dialog-content").dialog("close");
			});

			if(!allowCloseDialog) return false;
		});
	}

	/**
	 * Form Editor: Setup the Preview Viewport
	 * 
	 * Called every time the Preview tab is clicked on
	 * 
 	 * @param id
	 * 
	 */
	function setupPreviewViewport(id) {

		var formName = $("#form_name").val();
		var $wrapper = $('#' + id);
		var viewportID = 'FormBuilderViewport_' + formName;
		var $iframe = $('#' + viewportID);
		var $spinner = $("<p style='text-align:center'><i class='fa fa-spin fa-2x fa-spinner'></i></p>");
		var href = $wrapper.find('a').attr('href');

		if($iframe.length > 0) {
			// if already present, force it to reload
			$iframe.contents().find('body').html('<p>&nbsp;</p>');
			var src = $iframe.attr('src');
			var test = src.indexOf('&rand=');
			if(test > 0) src = src.substring(0, test);
			src += '&rand=' + ((Math.random() * 10) + 1);
			$iframe.attr('src', src); 
			
		} else {
			$iframe = $("<iframe />")
				.attr('frameborder', '0')
				.attr('class', 'FormBuilderViewport')
				.attr('id', viewportID)
				.attr('data-name', formName)
				.attr('src', href);

			$wrapper.css('margin-top', '1px').prepend($iframe).find(".InputfieldContent, .ui-widget-content").remove();
		}

		$iframe.before($spinner);
		$iframe.width('100%');
		$iframe.load(function() {
			$spinner.remove();
		});
	}
	
	/**
	 * Form Editor: Change event to handle fieldgroup indentation
	 * 
	 */
	function formFieldsChangeEvent() {
		var $ol = $formFields.prev('ol.asmList');
		$ol.find('span.asmFieldsetIndent').remove();
		$ol.children('li').children('span.asmListItemLabel').children("a:contains('_END')").each(function() {
			var label = $(this).text();
			if(label.substring(label.length-4) != '_END') return;
			label = label.substring(0, label.length-4);
			var $li = $(this).parents('li.asmListItem');
			$li.addClass('asmFieldset asmFieldsetEnd');
			while(1) {
				$li = $li.prev('li.asmListItem');
				if($li.length < 1) break;
				var $span = $li.children('span.asmListItemLabel');
				var label2 = $span.text();
				if(label2 == label) {
					$li.addClass('asmFieldset asmFieldsetStart');
					break;
				}
				$span.prepend($('<span class="asmFieldsetIndent"></span>'));
			}
		});
	}

	/**
	 * Form Editor: Change event handler for save flags on "Actions" tab
	 * 
	 */
	function saveFlagsChangeEvent() {
		if($("#Inputfield_form_saveFlags_1").is(":checked")) $("#fieldsetEntries").slideDown('fast');
			else $("#fieldsetEntries").hide();
		if($("#Inputfield_form_saveFlags_2").is(":checked")) $("#fieldsetEmail").slideDown('fast');
			else $("#fieldsetEmail").hide();
		if($("#Inputfield_form_saveFlags_4").is(":checked")) $("#fieldset3rdParty").slideDown('fast');
			else $("#fieldset3rdParty").hide();
		if($("#Inputfield_form_saveFlags_8").is(":checked")) $("#fieldsetSavePage").slideDown('fast');
			else $("#fieldsetSavePage").hide();
		if($("#Inputfield_form_saveFlags_32").is(":checked")) $("#fieldsetSpam").slideDown('fast');
			else $("#fieldsetSpam").hide();
		if($("#Inputfield_form_saveFlags_64").is(":checked")) $("#fieldsetResponder").slideDown('fast');
			else $("#fieldsetResponder").hide();
		if($("#Inputfield_form_saveFlags_128").is(":checked")) $("#fieldsetGoogleSheets").slideDown('fast');
			else $("#fieldsetGoogleSheets").hide();

		if($("#Inputfield_form_saveFlags_16").is(":checked")) {
			$("#fieldsetSubmitTo").slideDown('fast');
			$("#fieldsetEntries").hide();
			$("#fieldsetEmail").hide();
			$("#fieldsetResponder").hide();
			$("#fieldsetGoogleSheets").hide();
			$("#fieldset3rdParty").hide();
			$("#fieldsetSavePage").hide();
			$("#fieldsetSpam").hide();
			$("#wrap_Inputfield_form_saveFlags").find("input[value!=16]").each(function() {
				$(this).removeAttr('checked').attr('disabled', 'disabled');
			});
		} else {
			$("#fieldsetSubmitTo").hide();
			//$("#fieldsetSpam").show();
			$("#wrap_Inputfield_form_saveFlags").find('input:disabled').removeAttr('disabled');
		}
	}

	/**
	 * Take pageBreak classes from <option> elements and add them to the corresponding <li> elements
	 * 
	 */
	function setupListFieldsPageBreaks() {
		$('#form_fields').find('option.pageBreak').each(function() {
			var $option = $(this);
			var id = $option.attr('id');
			var $li = $option.closest('.InputfieldContent').find('li[rel="' + id + '"]');
			$li.addClass($option.attr('class'));
		});
	}

	/**
	 * Identify asmSelect <li> items with classes that indicate how they contribute to Inputfield width rows
	 * 
	 * - "rowItem" class is added all items that contribute to a row 
	 * - "rowStart" class is added to items that begin a row
	 * - "rowStop" class is added to items that stop/finish a row
	 * - "rowError" class is also added to items that stop a row but row does not add up to 100%
	 * 
	 * This method should be called at init, as well as after any sorting or other changes to the asmSelect.
	 * Return value is integer containing the quantity of rows that use columnWidth.
	 * 
	 */
	function setupListFieldsColumnWidthRows() {
	
		var $inputfield = $('#wrap_form_fields');
		var $item = $inputfield.find('.asmListItem:eq(0)');
		var $lastItem = null;
		var lastItemWidth = 0;
		var total = 0;
		var numRows = 0;
		
		do {
			$item.removeClass('rowItem rowStart rowStop rowError');
			var w = parseInt($item.find('.columnWidth').text());
			if(w === 100) {
				// new 100% item
				if(total > 0 && total < 100 && lastItemWidth > 0 && lastItemWidth < 100) {
					// last total was under 100, so last item didn't finish a row
					$lastItem.addClass('rowError');
					if(!$lastItem.hasClass('rowStart')) $lastItem.addClass('rowStop');
				}
				// start new total
				total = 0;
			} else {
				// new partial width item
				if(!total) {
					$item.addClass('rowStart'); // starting a new row
					numRows++;
				}
				$item.addClass('rowItem');
				if(total + w > 100) {
					// existing total plus this item makes it exceed 100% width
					if($lastItem && lastItemWidth < 100) {
						if($lastItem.hasClass('rowStart')) {
							// last item started a single-item row under 100%
							$lastItem.addClass('rowError');
						} else {
							// last item finished a multi-item row that didn't reach 100%
							$lastItem.addClass('rowStop rowError');
						}
					}
					// start our new row
					$item.addClass('rowStart');
					numRows++;
					total = w;
				} else if(total + w == 100) {
					// this item plus previous item(s) add up to a 100% row
					$item.addClass('rowStop');
					total = 0; // new row will start on next iteration
				} else {
					// partial width item in the middle of a row
					total += w;
				}
			}
			$lastItem = $item;
			lastItemWidth = w;
			$item = $item.next('.asmListItem');
		} while($item.length);

		if($lastItem.length && lastItemWidth < 100) {
			$lastItem.addClass('rowStop');
			if(total > 0 && total < 100) {
				$lastItem.addClass('rowError');
			} else {
				$lastItem.removeClass('rowError');
			}
		}
		
		return numRows;
	}

	/**
	 * Setup the inline column-width adjustment feature in asmList <li> items
	 * 
	 */
	function setupListFieldsColumnWidthAdjust() {
		
		var $percentElement = null;
		var currentPct = 0; 
		var lastPageX = 0;
		var lastPageY = 0;
		var mousingActive = false;
		var isDblClick = false;
		var snapWithin = 9;
		var snapWidth = 0;
		
		function asmListItem($item) {
			if(!$item.hasClass('asmListItem')) $item = $item.closest('.asmListItem');
			return $item;
		}
		
		function columnWidthItem($item) {
			if($item.hasClass('columnWidth')) return $item;
			return $item.find('.columnWidth');
		}
		
		function getColumnWidth($item) {
			$item = columnWidthItem($item);
			return parseInt($item.text());
		}
		
		function getSnapWidth($item) {
			$item = asmListItem($item);
			var rowWidth = getRowWidth($item);
			var itemWidth = getColumnWidth($item);
			var snap; 
			if(rowWidth == 100) {
				snap = itemWidth;
			} else {
				snap = 100 - (rowWidth - itemWidth);
			}
			return snap;
		}
		
		function getRowStartItem($item) {
			$item = asmListItem($item);
			if(!$item.hasClass('rowItem') || $item.hasClass('rowStart')) return $item;
			var $prevItem = $item;
			do {
				$prevItem = $prevItem.prev('.rowItem');
			} while($prevItem.length && !$prevItem.hasClass('rowStart')); 
			return $prevItem.length ? $prevItem : $item;
		}
		
		function getRowStopItem($item) {
			$item = asmListItem($item);
			if(!item.hasClass('rowItem') || $item.hasClass('rowStop')) return $item;
			var $nextItem = $item;
			do {
				$nextItem = $nextItem.next('.rowItem');
			} while($nextItem.length && !$nextItem.hasClass('rowStop'));
			return $nextItem.length ? $nextItem : $item;
		}
		
		function getRowWidth($item) {
			if(!$item.hasClass('rowItem')) return 100;
			$item = getRowStartItem($item);
			var total = getColumnWidth($item);
			var $nextItem = $item;
			var w = 0;
			do { 
				$nextItem = $nextItem.next('.rowItem');
				if(!$nextItem.length || $nextItem.hasClass('rowStart')) break;
				w = getColumnWidth($nextItem);
				if(total + w > 100) break;
				total += w;
			} while(total < 100 && !$nextItem.hasClass('rowStop'));
			return total;	
		}
		
		function setColumnWidth($item, columnWidth) {
			var $parent;
			if($item.hasClass('columnWidth')) {
				$parent = $item.closest('.asmListItem');
			} else {
				$parent = $item;
				$item = $item.find('.columnWidth');
			}
			if(snapWidth > 0) {
				if(columnWidth > snapWidth && columnWidth - snapWidth <= snapWithin) {
					columnWidth = snapWidth;
				} else if(columnWidth < snapWidth && snapWidth - columnWidth <= snapWithin) {
					columnWidth = snapWidth;
				}
			}
			var pct = parseInt(columnWidth) + '%';
			$item.text(pct); 
			var $columnWidthBar = $parent.find('.columnWidthBar');
			var $columnWidthBarPct = $columnWidthBar.children('.columnWidthBarPct');
			$columnWidthBar.css('width', columnWidth + '%')
			if(columnWidth >= 90) {
				$columnWidthBarPct.text('');
			} else {
				$columnWidthBarPct.text(pct);
			}
		}
		
		function saveColumnWidth($item) {
			var columnWidth = getColumnWidth($item);
			var $li = $item.hasClass('asmListItem') ? $item : $item.closest('.asmListItem');
			var $a = $li.find('.asmListItemEdit:eq(0)').children('a');
			var url = $a.attr('href');
			var data = {
				save_property: 'columnWidth',
				columnWidth: columnWidth
			};
			
			$.post(url, data, function(result) {
				if(result.success) {
					if(result.value != columnWidth) setColumnWidth($item, result.value);
				}
			}, 'json'); 
		}
		
		function startColumnWidthBar($item) {
			if(!$item.hasClass('asmListItem')) $item = $item.closest('.asmListItem');
			if(isDblClick || !mousingActive) return;
			var $columnWidthBar = $item.find('.columnWidthBar');
			if($columnWidthBar.length) $columnWidthBar.remove();
			var pct = getColumnWidth($item) + '%';
			var $columnWidthBarPct = $("<span />").addClass('columnWidthBarPct').text(pct);
			$columnWidthBar = $('<div />').addClass('columnWidthBar').append($columnWidthBarPct);
			$columnWidthBar.appendTo($item);
			$columnWidthBar.css('width', pct);
		}
		
		function stopColumnWidthBar($item) {
			if(!$item.hasClass('asmListItem')) $item = $item.closest('.asmListItem');
			var $columnWidthBar = $item.find('.columnWidthBar');
			if(!$columnWidthBar.length) return;
			$columnWidthBar.remove();
		}
		
		function setActive($item, active) {
			var $list = $item.closest('.ui-sortable');
			if(!$item.hasClass('columnWidth')) $item = $item.find('.columnWidth');
			var $parent = $item.closest('.asmListItem');
			
			if(active) {
				if(mousingActive) return;
				mousingActive = true;
				$item.addClass('columnWidthActive');
				$('body').addClass('columnWidthActive');
				$item.siblings('.inputType, .inputInfo').css('opacity', 0.3);
				$list.sortable('disable');
				snapWidth = getSnapWidth($parent);
				startColumnWidthBar($item);
			} else {
				if(!mousingActive) return;
				mousingActive = false;
				stopColumnWidthBar($item);
				snapWidth = 0;
				$item.removeClass('columnWidthActive');
				$('body').removeClass('columnWidthActive');
				$item.siblings('.inputType, .inputInfo').css('opacity', 1.0);
				$list.sortable('enable');
			}
		}
		
		var mouseMove = function(e) {
			if(lastPageX && lastPageY) {
				var diffX = e.pageX - lastPageX;
				var diffY = e.pageY - lastPageY;
				var diff = Math.abs(diffX) >= Math.abs(diffY) ? diffX : (diffY * -1);
				if(diff === 0) return;
				var pct = currentPct;
				if(diff > 0 && pct < 100) pct++;
				if(diff < 0 && pct > 10) pct--;
				if(pct != currentPct) {
					setColumnWidth($percentElement, pct);
					currentPct = pct;
				}
			}
			lastPageX = e.pageX;
			lastPageY = e.pageY;
		};

		var mouseUp = function() {
			$(document).off('mouseup', mouseUp);
			$(document).off('mousemove', mouseMove);
			saveColumnWidth($percentElement);
			setActive($percentElement, false);
			setupListFieldsColumnWidthRows();
		};
		
		var mouseDown = function(e) {
			$percentElement = $(this);
			setActive($percentElement, true); 
			currentPct = getColumnWidth($percentElement);
			$(document).on('mouseup', mouseUp);
			$(document).on('mousemove', mouseMove);
		};
		
		var mouseOut = function(e) {
			if(mousingActive) return;
			$(this).closest('.ui-sortable').sortable('enable');
		};
		
		var mouseOver = function(e) {
			if(mousingActive) return;
			$(this).closest('.ui-sortable').sortable('disable');
		};
		
		var dblClick = function(e) {
			var $t = $(this);
			isDblClick = true;
			snapWidth = getSnapWidth($t);
			if(snapWidth) {
				setColumnWidth($t, snapWidth);
				setupListFieldsColumnWidthRows()
				saveColumnWidth($t);
			}
			isDblClick = false;
		};
		
		var toggleRequired = function() {
			console.log('toggleRequired');
			var $li = $(this).closest('.asmListItem');
			var $a = $li.find('.asmListItemEdit:eq(0)').children('a');
			var url = $a.attr('href');
			var $inputRequired = $li.find('.inputRequired');
			var value = $inputRequired.text();
			var data = {
				save_property: 'required',
				required: (value.indexOf('*') > -1 ? 0 : 1)
			};
			$inputRequired.html("<i class='fa fa-spin fa-spinner fa-fw'></i>"); 

			$.post(url, data, function(result) {
				$inputRequired.text('');
				if(result.success) {
					$inputRequired.text(result.value);
				}
			}, 'json'); 
		}; 
	
		var $inputfield = $('#wrap_form_fields'); // Inputfield wrapping element
		var $select = $('#form_fields'); // original (hidden) select
		
		$inputfield
			.on('mousedown', '.columnWidth', mouseDown)
			.on('mouseover', '.columnWidth', mouseOver)
			.on('mouseout', '.columnWidth', mouseOut)
			.on('dblclick', '.columnWidth', dblClick)
			.on('dblclick', '.inputType', toggleRequired)
			.on('asm-ready', function() {
				// triggered by manual inline call to ProcessFormBuilderInitFields() method
				setupListFieldsPageBreaks();
				setupListFieldsColumnWidthRows()
			});
		
		$select.on('change', function(e, eventData) {
			
			// eventData is provided by a change event triggered from asmSelect plugin after a sort or select event
			if(typeof eventData == "undefined") return;
			if(typeof eventData.type == "undefined") return;
			if(eventData.type != 'sort') return;
			
			// update row identifications after any changes
			setupListFieldsColumnWidthRows();
	
			var value = $(this).val();
			var url = '../saveForm/';
			var data = {
				form_id: $('#form_id').val(),
				save_property: 'form_fields',
				form_fields: value
			};
			
			$.post(url, data, function(result) {
				// we just silently post
			}, 'json'); 
		}); 
	}

	/**
	 * Form Editor: Initialize the form editor
	 * 
	 */
	function setupEditForm() {

		$("#_ProcessFormBuilderView").click(function(e) {
			setupPreviewViewport('ProcessFormBuilderView');
			return false;
		});

		$("#_ProcessFormBuilderEntries").attr('href', '../listEntries/?id=' + $('#form_id').attr('value'));

		$formFields.change(formFieldsChangeEvent).bind('init', formFieldsChangeEvent);

		$("#_ProcessFormBuilderEmbed").click(function() {
			$.get("../embedForm?id=" + $("#form_id").val(), function(data) {
				$("#ProcessFormBuilderEmbedMarkup").html(data);
				$(".ProcessFormBuilderAccordion").accordion({autoHeight: false, heightStyle: 'content'});
			});
		});

		$("#_ProcessFormBuilderExport").click(function() {
			$.get("../exportForm?id=" + $("#form_id").val(), function(data) {
				$("#ProcessFormBuilderExportJSON").val(data).click(function() {
					$(this).select()
				});
			});
		});
		
		var $columnWidth = $("#columnWidth");
		if($columnWidth.length > 0 && parseInt($columnWidth.val()) < 1) $columnWidth.val('100');

		// submit/save settings
		if($("#fieldsetActions").length > 0) {
			$("#wrap_Inputfield_form_saveFlags").find('input').change(saveFlagsChangeEvent);
			saveFlagsChangeEvent();
		}

		setupModalFieldEditor();
		setupListFieldsColumnWidthAdjust();
	}
	

	/**
	 * Field Editor: Setup the form field editor
	 * 
	 */
	function setupEditField() {
	}

	/**
	 * Entries: Setup the entries list/editor
	 * 
	 */
	function setupEntries() {
		// listing or editing entries
		$("#check_all").click(function() {
			var $checkboxes = $("input[type=checkbox].delete");
			if($(this).is(":checked")) {
				$checkboxes.prop('checked', true);
			} else {
				$checkboxes.prop('checked', false);
			}
		});

		$(document).on('click', '#submit_delete_entries, #submit_resend_entries, #submit_page_entries', function() {
			var $button = $(this);
			if($button.hasClass('delete-confirmed')) return true;
			ProcessWire.confirm($(this).val(), function() {
				$button.addClass('delete-confirmed').click();
			});
			return false;
		});
		
		var $closeLink = $('.pwfb-close-in-modal');
		if($closeLink.length) {
			$closeLink.click(function() {
				var $entryID = $('#pwfb-entry-id');
				var entryID = $entryID.length ? parseInt($entryID.attr('value')) : 0;
				window.parent.jQuery('.ui-dialog-content').dialog('close');
				if(entryID) {
					setTimeout(function() {
						var loc = '' + window.parent.location;
						loc = loc.replace(/&refresh=[0-9.]+/g, '');
						window.parent.location = loc + '&refresh=' + entryID + '.' + Math.floor(Math.random() * Math.floor(9999999));
					}, 250);
				}
				return false;
			});
			if($closeLink.hasClass('pwfb-close-now')) $closeLink.click();
		}
	
		$('#Inputfield_sort').on('change', function() {
			var val = $(this).val();
			var $notes = $('#wrap_dateFrom .notes, #wrap_dateTo .notes');
			if(val == 'modified' || val == '-modified') {
				$notes.show();
			} else {
				$notes.hide();
			}
		}).change();
	}

	/**
	 * Entries: Setup the search/filter functions
	 * 
	 */
	function setupEntriesSearch() {
		
		var $opWrap = $('#wrap_qo');
		var $mainWrap = $('#wrap_qv');
		var $mainContent = $mainWrap.find('.pwfb-entries-qv-main-content');
		var $mainInput = $mainContent.find(':input');
		var $filterForm = $('#filter_form');
		var $filterFieldset = $('#filter_fieldset');

		/*
		function updateEntriesList() {
			jQuery.ajax({
				url: './',
				method: 'GET',
				data: $('#filter_form').serialize() + '&submit_filter=1&entries_only=1'
			}).done(function(response) {
				var html = $(response).find('#entries_list_table').html();
				$("#entries_list_table").html(html);
			}).fail(function() {
				// error
			});
		}
		*/

		$filterFieldset.on('opened', function(e, a) {
			if($(e.target).prop('id') != $filterFieldset.prop('id')) return;
			$('#submit_delete_entries_copy').fadeOut('fast', function() {
				$('#submit_filter_results_copy').fadeIn('fast');
			});
		}).on('closed', function(e) {
			if($(e.target).prop('id') != $filterFieldset.prop('id')) return;
			$('#submit_filter_results_copy').fadeOut('fast', function() {
				$('#submit_delete_entries_copy').fadeIn('fast');
			});
		});
	
		setTimeout(function() {
			if($filterFieldset.hasClass('InputfieldStateCollapsed')) {
				$('#submit_delete_entries_copy').fadeIn('fast');
			} else {
				$('#submit_filter_results_copy').fadeIn('fast');
			}
		}, 500);
		
		$(document).on('change', '.pwfb-entries-qv-field-input', function() {
			// populate selection to the main input
			// console.log('Setting value to: ' + $(this).val());
			$mainInput.val($(this).val());
		}); 

		$('#qf').on('change', function() {
			
			var name = $(this).val();
			var $prevContent = $mainWrap.find('.pwfb-entries-qv-field-content');
			var $fieldInput = $('#qv_' + name); 
			var showMain = false; // show main qv input?
			var showOperator = '';
			var searchAnyField = name.length === 0;
			var isSelect = $fieldInput.length && $fieldInput.is('select');
		
			if($prevContent.length) {
				// move back to its home
				var inputId = $prevContent.find(':input').prop('id');
				var $fieldWrap = $('#wrap_' + inputId); 
				$fieldWrap.append($prevContent);
			}
		
			if($fieldInput.length) {
				// custom input available for selected qf/field
				var $fieldContent = $fieldInput.closest('.pwfb-entries-qv-field-content');
				$mainContent.hide();
				$fieldContent.insertBefore($mainContent);
			} else {
				// no custom input/select available
				showMain = true;
				$mainContent.show();
				// if(!inSetup) $mainInput.val('');
			}
			
			if(inSetup & $fieldInput.length) {
				// populate value from main input into field input during init only
				$fieldInput.val($mainInput.val()); 
				// $mainInput.val('');
			}
			
			$opWrap.find('option').each(function() {
				var $option = $(this);
				var val = $option.attr('value');
				if(val.indexOf('~') > -1 || val.indexOf('*') > -1 || val.indexOf('%') > -1) {
					// disable or enable text-only search operators 
					// depending on whether or not we are showing our main search input
					$option.prop('disabled', !showMain);
				} else if(searchAnyField) {
					$option.prop('disabled', true);
				} else if(isSelect) {
					$option.prop('disabled', val !== '=' && val !== '!='); 
				} else {
					$option.prop('disabled', showMain && val !== '=' && val !== '!=');
				}
			});
			
			showOperator = showMain ? '*=' : '=';
			
			if(showOperator.length && !inSetup) {
				$opWrap.find('option:selected').prop('selected', false);
				$opWrap.find('option[value="' + showOperator + '"]').prop('selected', true);
			}
		}).change();
	
		$('.pwfb-th-sort').on('click', function() {
			window.location.href = $(this).attr('data-url'); 
		}); 
		
		$("#wrap_cols").find('select').on('change', function() {
			$("#wrap_cols").addClass('InputfieldStateChanged');
		}); 
	
	}

	/**
	 * Setup ProcessFormBuilder 
	 * 
	 */
	function setup() {

		// if editing a form or form field then initialize WireTabs
		if($formEditor.length) {
			$formEditor.find("script").remove();
			$formEditor.WireTabs({items: $('.WireTab')});
		}

		if(isEditForm) {
			// editing a form
			setupEditForm();
		} else if($formEditor.length) {
			// editing a form field 
			setupEditField();
		} else {
			// listing or editing entries
			setupEntries();
			setupEntriesSearch();
		}

		inSetup = false;
	}
	
	setup();
}
/**
 * Form Editor: Initialize the asmSelect list of fields
 *
 */
function ProcessFormBuilderInitFields() {
	// $('#form_fields').find('option.pageBreakAfter, option.pageBreakBefore').each(function() {
	$('#wrap_form_fields').trigger('asm-ready');
}

jQuery(document).ready(function($) {
	ProcessFormBuilder();	
}); 

