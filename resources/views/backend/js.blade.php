<script src="{{asset('assets/js/jquery-3.7.0.min.js')}}"></script>
<script src="{{asset('assets/js/jquery-ui.min.js')}}"></script>
<script src="{{asset('assets/js/popper.js')}}"></script>
<script src="{{asset('assets/js/lightbox.min.js')}}"></script>
<script src="{{asset('assets/js/bootstrap.bundle.min.js')}}"></script>
<script src="{{asset('assets/js/chart.bundle.min.js')}}"></script>
<!-- Data table plugin-->
<script type="text/javascript" src="{{asset('assets/js/jquery.dataTables.min.js')}}"></script>
<!-- Custom Script -->
<script>
  var renderAsHtml = function (data, type, full) {
    return decHTMLifEnc(data);
  }; 
  var isEncHTML = function(str) {
      if(str.search(/&amp;/g) != -1 || str.search(/&lt;/g) != -1 || str.search(/&gt;/g) != -1)
          return true;
      else
          return false;
  };
  
  var decHTMLifEnc = function(str){
      if(isEncHTML(str))
          return str.replace(/&amp;/g, '&').replace(/&lt;/g, '<').replace(/&gt;/g, '>');
      return str;
  }
</script>
<script>
    $(function () {
    $(".alert").fadeOut(3000);
    });
    $("body").on("click", ".btn-hapus", function() {
        var x = jQuery(this).attr("data-id");
        var y = jQuery(this).attr("data-handler");
        var xy = x + '-' + y;
        event.preventDefault()
        Swal.fire({
            title: 'Hapus Data ?',
            text: "Data yang dihapus tidak dapat dikembalikan !",
            type: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Yes',
            cancelButtonText: 'Tidak'
        }).then((result) => {
            if (result.value) {
                Swal.fire(
                    'Data Dihapus!',
                    '',
                    'success'
                );
                document.getElementById('delete-form-' + xy).submit();
            }
        });
    })
    $("body").on("click", ".btn-reject", function() {
        var x = jQuery(this).attr("data-id");
        var y = jQuery(this).attr("data-handler");
        var xy = x + '-' + y;
        event.preventDefault()
        Swal.fire({
            title: 'Tolak Appointment ?',
            text: "Hubungi admin untuk perubahan data lebih lanjut !",
            type: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Yes',
            cancelButtonText: 'Tidak'
        }).then((result) => {
            if (result.value) {
                Swal.fire(
                    'Appointment Ditolak!',
                    '',
                    'success'
                );
                document.getElementById('reject-form-' + xy).submit();
            }
        });
    })
    $("body").on("click", ".btn-confirm", function() {
        var x = jQuery(this).attr("data-id");
        var y = jQuery(this).attr("data-handler");
        var xy = x + '-' + y;
        event.preventDefault()
        Swal.fire({
            title: 'Selesaikan Appointment ?',
            text: "Hubungi admin untuk perubahan data lebih lanjut !",
            type: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Yes',
            cancelButtonText: 'Tidak'
        }).then((result) => {
            if (result.value) {
                Swal.fire(
                    'Appointment Diterima!',
                    '',
                    'success'
                );
                document.getElementById('confirm-form-' + xy).submit();
            }
        });
    })
    function fetch_data(category, binding){
      $.ajax({
            url: '{{ url("get/data") }}/'+category,
            type: "GET",
            cache: false,
            dataType: 'json',
            success: function (dataResult) { 
                binding = dataResult;
            }
      });
    }
</script>
  