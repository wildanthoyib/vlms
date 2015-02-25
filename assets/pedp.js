/**
 * Arie Nugraha <dicarve@gmail.com> 2014
 * PEDP core javascript functions
 */
function reg_event_progress() {
  $('.progress_select').bind('change', function() {
	var progSelect = $(this);
	var selected = progSelect.val();
	if ((selected > 19 && selected < 23) || (selected > 24)) {
	  progSelect.parents('tr').next('.table-contract').show();
	  $('body').trigger('newFormLoaded');
	  reg_ui_event_after_ajax();

	  $('.contract_date').bind('change', function(evt) {
	    var contract_date = $(this);
	    var contract_date_val = contract_date.val();
	    $(this).parents('table').parents('tr').siblings('tr').find('.prog_date').val(contract_date_val);
      });
	  
	} else {
	  progSelect.parents('tr').next('.table-contract').hide();
	}
  })

  $('.btn-simpan-progress').bind('click', function(evt) {
	evt.preventDefault();
	var btn = $(this);
	var actionURL = btn.attr('href');
	var formParent = btn.parents('.table-progress');
	var dataToSend = formParent.find('input,select,textarea').serialize();
	// alert(dataToSend); return;
	var addConfirm = confirm('Tambah progress untuk implementasi ini?');
	if (addConfirm) {
	  var req = $.ajax({
	    url: actionURL,
	    type: "POST",
	    data: dataToSend,
	    dataType: "html"
	  });

	  req.done(function( msg ) {
		alert('Data detail progress sudah disimpan');
	    btn.parents('.impl_row').find('.btn-show-progress').trigger('click');
	  });
	  
	  req.fail(function( jqXHR, textStatus ) {
	    alert( "Request failed to " + actionURL + ": " + textStatus );
	  });
	}
  });
  
  $('.btn-hapus-progress').bind('click', function(evt) {
	evt.preventDefault();
	var btn = $(this);
	var actionURL = btn.attr('href');
	var dataToSend = 'progid='+btn.attr('progid');
	// alert(dataToSend); return;
	var addConfirm = confirm('Hapus progress untuk implementasi ini?');
	if (addConfirm) {
	  var req = $.ajax({
	    url: actionURL,
	    type: "POST",
	    data: dataToSend,
	    dataType: "html"
	  });

	  req.done(function( msg ) {
		alert('Data detail progress sudah dihapus');
	    btn.parents('.impl_row').find('.btn-show-progress').trigger('click');
	  });
	  
	  req.fail(function( jqXHR, textStatus ) {
	    alert( "Request failed to " + actionURL + ": " + textStatus );
	  });
	}
  });
  
  $('.prog_date').bind('change', function(evt) {
	var prog_date = $(this);
	var prog_date_val = prog_date.val();
	$(this).parents('tr').siblings('tr').find('.contract_date').val(prog_date_val);
  });
  
  $(document).trigger('newFormLoaded');
  // reg_ui_event_after_ajax();
}

function reg_ui_event_after_ajax() {
  $('.datepicker').each(function() {
  	var $this = $(this);
  	var dataDateFormat = $this.attr('data-dateformat') || 'dd-mm-yyyy';
  
  	$this.datepicker({
  		dateFormat : dataDateFormat,
  		prevText : '<i class="fa fa-chevron-left"></i>',
  		nextText : '<i class="fa fa-chevron-right"></i>',
  	});
  });

  $('.select2').each(function() {
  	var select = $(this);
  	var width = select.attr('data-select-width') || '100%';
  	var href = select.attr('href') || null;
  	select.select2({
  	  //showSearchInput : _showSearchInput,
  	  allowClear : true,
  	  width : width
  	});
  });
}

$(document).ready(function() {
    /*    
  var pilihan = {"tahun_anggaran" : "tahun-filterable",
    "komp_pembiayaan" : "komp-filterable",
    "subkomp_pembiayaan" : "subkomp-filterable",
    "sumber_pembiayaan" : "sumber-filterable"};
    
  $.each( pilihan, function( key, value ) {

    $('#'+key+'_pilih').bind('change', function() {
        var select = $(this);
        var sel_val = select.val();
        if (sel_val != '0') {
          $('#tabel-form-g1 .'+ value).hide();
          $('#'+key+'_all').val(sel_val);
          $('#tabel-form-g1 .' + value + ' select').each(function() {
            $(this).find('option').each(function () {
              if ($(this).val() == sel_val) {
                this.selected = true;
              }
            });
          });
        } else {
          $('#tabel-form-g1 .'+value).show();
          $('#'+key+'_all').val('0');
        }
      });
    
  });
    */
    
  pageSetUp();
  
  // tombol tambah transaksi
  $('.add-transaction').bind('click', function() {
    var tmbl = $(this);
    var transcTable = tmbl.prev('.table-sp2d-detail');
    transcTable.find('tbody').append(rowSelect2);
	$('body').trigger('newFormLoaded');
  });

  // tombol tambah detail
  $('.add-rppdetail').bind('click', function() {
    var tmbl = $(this);
    var tableToAdd = $('#tabel-form-rppdetail');
    tableToAdd.find('tbody').append(rowSelect2);
    $('body').trigger('newFormLoaded');
  });

  $('.rm-current-row').bind('click', function() {
    var btn = $(this);
    var trToRm = $(btn.parents('tr')[0]);
    trToRm.fadeOut(200);
  });
  
  $('.show-opsi-form').bind('click', function() {
	var btn = $(this);
	btn.parent('form').parent('.panel-body').find('.form-group').slideDown('fast');
  });

  $('.show-opsi-form').bind('click', function() {
	var btn = $(this);
	btn.parent('form').parent('.panel-body').find('.form-group').slideDown('fast');
  });
  
  $('.btn-show-progress').bind('click', function(evt) {
	evt.preventDefault();
	var btn = $(this);
	var prog_container = btn.next();
	// tampilkan loading
	prog_container.html('<div class="alert alert-warning">loading...</div>');
	
	var actionURL = btn.attr('href');
	var req = $.ajax({
	  url: actionURL,
	  type: "POST",
	  dataType: "html"
	});

	req.done(function( msg ) {
	  prog_container.html(msg);
	  reg_event_progress();
	});
	
	req.fail(function( jqXHR, textStatus ) {
	  alert( "Request failed to " + actionURL + ": " + textStatus );
	});
  });
  
  // register event progress
  reg_event_progress();
  
  $('.btn-hapus-data').bind('click', function(evt) {
	evt.preventDefault();
	var btnHapus = $(this);
	var urlHapus = btnHapus.attr('href');
	var formToProc = $('.form-table');
	var toDeletes = formToProc.find('[name^="chbox"]').filter(':checked');
	if (toDeletes.length < 1) {
	  alert('Harap pilih terlebih dahulu data yang akan dihapus');
	  return false;
	}
	var delConfirm = confirm('Apakah anda yakin akan menghapus data terpilih?');
	if (delConfirm && toDeletes.length > 0) {
	  var req = $.ajax({
	    url: urlHapus,
	    type: "POST",
	    data: toDeletes.serialize(),
	    dataType: "html"
	  });

	  req.done(function( msg ) {
	    location.reload();
	  });
	  
	  req.fail(function( jqXHR, textStatus ) {
	    alert( "Request failed: " + textStatus );
	  });
	}
  });
  
  $(document).bind('newFormLoaded', function() {
    reg_ui_event_after_ajax();
    $('.rm-current-row').bind('click', function() {
      var btn = $(this);
      var trToRm = $(btn.parents('tr')[0]);
      trToRm.fadeOut(200);
    });
  });
    
});