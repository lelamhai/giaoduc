jQuery.fn.sneeitGrid = function(options) {
	this.each(function(){		
		var wrapper = jQuery(this);
		var sneeitGridOptions = wrapper.data('sneeitGridOptions');

		// in case reload
		if (typeof(options) == 'undefined' && typeof(sneeitGridOptions) != 'undefined') {
			options = Object.assign({}, sneeitGridOptions);
		}
		if (typeof(options) == 'undefined') {
			options = {};
		}	
		if (typeof(sneeitGridOptions) == 'undefined') {
			sneeitGridOptions = {};
		}



		// default options:
		options = jQuery.extend({		
			columnNumber : 1,
			columnClass: 'sneeit-grid-col',
			gapClass: 'sneeit-grid-gap',
			wrapperFinishClass: 'sneeit-grid',

			/* if after calculating, the width 
			 * of each col is smaller than min
			 * we will decrease the col number. 
			 * This is useful for responsive layout 
			 * 
			 * The unit is PIXEL
			 * */
			minColumnWidth: 150,

			/*
			 * The PERCENTAGE of gap width related to
			 * parent width. The gap will never
			 * larger than this width
			 * 
			 * The Unit is PERCENT
			 */
			maxGapSize: 6.25,

			/* fitRows, 
			 * default: masonry / fluid / flex
			 */
			layoutMode: '',

			/* space between items in PIXEL */
			gapSize: 0,		
		}, options);	

		// if wrapper have data attributes,
		// we will priority get from that
		jQuery.each(options, function(key, val){		
			var data_val = wrapper.attr('data-' + key);
			if (typeof(data_val) == 'undefined') {
				options[key] = val;
			}
		});

		// validate options		
		var items = wrapper.find('>*');
		if (items.first().is('.'+options.columnClass)) {
			items = items.find('>*');
		}
				

		if (!options.columnNumber) {
			options.columnNumber = 1;
		}
		
		if (options.columnNumber > items.length) {
			options.columnNumber = items.length;
		}

		if ('previousColumnNumber' in sneeitGridOptions) {
			options.previousColumnNumber = sneeitGridOptions.previousColumnNumber;
		}	
		if ('previousItemLength' in sneeitGridOptions) {
			options.previousItemLength = sneeitGridOptions.previousItemLength;
		}
		sneeitGridOptions = Object.assign({}, options);

		// save options
		wrapper.data('sneeitGridOptions', sneeitGridOptions);

		// short call			
		var wrapperWidth = wrapper.width();
		
		
		// validate gap size
		var gapInPercent = 100 * options.gapSize / wrapperWidth;
		if (gapInPercent > options.maxGapSize) {
			options.gapSize =  options.maxGapSize * wrapperWidth / 100;
		}

		// decrease number of column depending on 
		// the width of the parent

		var totalGapSize = (options.columnNumber - 1) * options.gapSize;
		if (options.columnNumber <= 1) {
			totalGapSize = 0;
		}
		var columnWidth = (wrapperWidth - totalGapSize) / options.columnNumber;	
		for (; options.columnNumber > 1 && columnWidth < options.minColumnWidth; options.columnNumber--) {		
			totalGapSize = (options.columnNumber - 1) * options.gapSize;
			if (options.columnNumber <= 1) {
				totalGapSize = 0;
			}
			columnWidth = wrapperWidth / options.columnNumber;
			if (options.columnNumber <= 1 || columnWidth >= options.minColumnWidth) {
				break;
			}
		}

		if (0 == options.columnNumber) {
			options.columnNumber = 1;
		}

		// we don't need to process again if we already did it
		// and nothing need to change in column number
		// this will prevent process a lot when browser resize
		if ('previousColumnNumber' in sneeitGridOptions &&
			sneeitGridOptions.previousColumnNumber == options.columnNumber 
			&& 'previousItemLength' in sneeitGridOptions &&
			sneeitGridOptions.previousItemLength == items.length ||
			items.length < options.columnNumber) {
			return;
		}
		sneeitGridOptions.previousColumnNumber = options.columnNumber;	
		wrapper.data('sneeitGridOptions', sneeitGridOptions);	

		// calculate everything in percent	
		var gapInPixel = options.gapSize;
		if (options.columnNumber > 1) {
			// total gap size first
			options.gapSize = options.gapSize * (options.columnNumber - 1)				
			// col width in percent
			columnWidth = (wrapperWidth - options.gapSize) / (options.columnNumber);
			options.gapSize = (100 * options.gapSize / wrapperWidth - 0.001) / (options.columnNumber - 1) + '%';
		} 
		// only one column, so simple
		else {
			options.gapSize = 0;
			gapInPixel = 0;
			columnWidth = wrapperWidth;
		}

		// percent
		var columnWidthInPercent = (100 * columnWidth / wrapperWidth - 0.001) + '%';

		// remove previous grid	
		if (wrapper.is('.sneeit-grid')) {
			var previousColumns = wrapper.find('.'+ options.columnClass);
			if (previousColumns.length) {
				var itemPrepend = new Array();
				var columnIndex = 0;
				previousColumns.each(function(){
					var itemIndex = columnIndex;				
					jQuery(this).find(items).each(function(){
						if (jQuery(this).is('.'+ options.gapClass)) {
							return;
						}					
						itemPrepend[itemIndex] = jQuery(this);
						itemIndex += Number(options.columnNumber);					
					});
					columnIndex++;
				});						
				for (var i = itemPrepend.length - 1; i >= 0; i--) {
					itemPrepend[i].prependTo(wrapper);
				}

				previousColumns.remove();
			}

			wrapper.find('.'+ options.gapClass).remove();				
		}

		// update item jquery object
		var items = wrapper.find('>*');

		if (1 == options.columnNumber) {
			return;
		}
		

		// make grid
		switch (options.layoutMode) {
			case 'fitRows': 
				// create cols
				var index = 0;
				items
					.css('width', columnWidthInPercent)
					.css('float', 'left');
				items.each(function(){
					var item = jQuery(this);				
					if (index && index % options.columnNumber != 0) {
						jQuery('<div class="'+options.gapClass+' ver"></div>').insertBefore(item);
					} else if (index) {
						jQuery('<div class="'+options.gapClass+' hor"></div>').insertBefore(item);
					}
					index++;
				});			

				break;

			/* flex / fluid / masonry*/
			default:			
				// add columns
				var html = '';
				for (var i = 0; i < options.columnNumber; i++) {
					html += '<div class="'+options.columnClass+' '+options.columnClass+'-'+i+'"></div>';
					if (!i || i % options.columnNumber != 0) {
						html += '<div class="'+options.gapClass+' ver"></div>';
					}
				}
				jQuery(html).prependTo(wrapper);
				
				var index = 0;				
				items.each(function(){
					var item = jQuery(this);				
					var dataIndex = item.attr('data-index');
					if (typeof(dataIndex) != 'undefined') {
						index = dataIndex;
					}
					var columnIndex = index % options.columnNumber;
					item.appendTo(wrapper.find('.'+options.columnClass+'-'+columnIndex));
					jQuery('<div class="'+options.gapClass+' hor"></div>').insertAfter(item);				
					index++;
				})
				break;
		}
		
		// add exact gap
		wrapper.find('.'+options.gapClass+'.ver')
			.css('width', options.gapSize)
			.css('height', '1px')
			.css('float', 'left');
		
		wrapper.find('.'+options.columnClass)
			.css('width', columnWidth)
			.css('float', 'left');

		wrapper.find('.'+options.gapClass+'.hor')
			.css('clear', 'both')
			.css('width', '100%')
			.css('height', gapInPixel + 'px');
		
		// remove last hor gap in masonry
		wrapper.find('.'+options.columnClass).each(function(){
			var lastHorGap = jQuery(this).find('.'+options.gapClass+'.hor').last();		
			if (!lastHorGap.length) {
				return;
			}
			lastHorGap.hide();
		});
		
		

		// add finish class
		wrapper.addClass(options.wrapperFinishClass);	
	});
};
