jQuery(document).ready(function($){
	'use strict';

	$('.thmc-rgba-colorpicker input[type=text]').thmcWpColorPicker();

	$('.thmc-date-picker input[type=text]').datepicker({
		dateFormat: "yy-mm-dd"
	});
	$('.customize-control-select select').select2();
	$('.thmc-multi-select select').select2({
		tags: true
	});

	$('.thmc-multi-select select').on('change', function () {
		var settingId = $(this).data('customize-setting-link'),
			setting = wp.customize.control(settingId);

		if ($(this).val() == null) {
			setting.setting._value = [];
			setting.previewer.refresh();
		} else {
			setting.setting._value = $(this).val();
			setting.previewer.refresh();
		}
	});

	$('.thmc-switch-button').on('click', '.thmc-switch-ui', function (e) {
		e.preventDefault();

		var currentValue = $(this).parent().find('input:checked').val(),
			settingId = $(this).parent().find('input:checked').data('customize-setting-link'),
			setting = wp.customize.control(settingId);

		$(this).parent().find('input:checked').attr('checked', false);

		if (currentValue == 'on') {
			$(this).parent().find('input[value=off]').attr('checked', true).trigger( 'change' );
			// setting.setting._value = 'off';
			// setting.previewer.refresh();
		} else {
			$(this).parent().find('input[value=on]').attr('checked', true).trigger( 'change' );
			// setting.setting._value = 'on';
			// setting.previewer.refresh();
		}
	});

	$( '.thmc-multi-checkbox input[type="checkbox"]' ).on('change', function () {
		var checkboxValues = $( this ).parents( '.thmc-multi-checkbox' ).find( 'input[type="checkbox"]:checked' ).map(function() { return this.value; }).get().join( ',' );

		$( this ).parents( '.customize-control' ).find( 'input[type=hidden]' ).val( checkboxValues ).trigger( 'change' );
	});

});