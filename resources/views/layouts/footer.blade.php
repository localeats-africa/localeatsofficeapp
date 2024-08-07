<footer class="footer">
      <div class="d-sm-flex justify-content-center justify-content-sm-between" style="display:none;">
            <span class="text-danger text-center text-sm-left d-block d-sm-inline-block">Copyright ©
                  LocalEats Africa {{ date('Y')}} </a>. All rights
                  reserved.</span>
            <span class="float-none float-sm-right d-block mt-1 mt-sm-0 text-center"><i
                        class="mdi mdi-heart text-danger"></i></span>
      </div>
</footer>
<!-- partial -->
</div>
<!-- main-panel ends -->
</div>
</div>

<script src="{{ asset('assets/vendors/js/vendor.bundle.base.js')}}"></script>
<!-- endinject -->
<!-- Plugin js for this page -->
<script src="{{ asset('assets/vendors/chart.js/chart.umd.js')}}"></script>
<script src="{{ asset('assets/vendors/bootstrap-datepicker/bootstrap-datepicker.min.js')}}"></script>
<!-- End plugin js for this page -->
<script src="{{ asset('assets/vendors/select2/select2.min.js')}}"></script>
<script src="{{ asset('assets/vendors/typeahead.js/typeahead.bundle.min.js')}}"></script>

<!-- inject:js -->
<script src="{{ asset('assets/js/off-canvas.js')}}"></script>
<script src="{{ asset('assets/js/misc.js')}}"></script>
<script src="{{ asset('assets/js/settings.js')}}"></script>
<script src="{{ asset('assets/js/todolist.js')}}"></script>
<script src="{{ asset('assets/js/jquery.cookie.js')}}"></script>
<!-- endinject -->
<script src="{{ asset('assets/js/file-upload.js')}}"></script>
<script src="{{ asset('assets/js/typeahead.js')}}"></script>
<script src="{{ asset('assets/js/select2.js')}}"></script>
<!-- Custom js for this page -->
<!-- <script src="{{ asset('assets/js/dashboard.js"></script> -->
<!-- End custom js for this page -->
<script>
// loan type maximum duration
function increaseMax() {
      var value = parseInt(document.getElementById('max').value, 10);
      value = isNaN(value) ? 0 : value;
      value++;
      document.getElementById('max').value = value;
}

function decreaseMax() {
      var value = parseInt(document.getElementById('max').value, 10);
      value = isNaN(value) ? 0 : value;
      value < 1 ? value = 1 : '';
      value--;
      document.getElementById('max').value = value;
}
</script>

<script>
// loan type minimum duration
function increaseMin() {
      var value = parseInt(document.getElementById('min').value, 10);
      value = isNaN(value) ? 0 : value;
      value++;
      document.getElementById('min').value = value;
}

function decreaseMin() {
      var value = parseInt(document.getElementById('min').value, 10);
      value = isNaN(value) ? 0 : value;
      value < 1 ? value = 1 : '';
      value--;
      document.getElementById('min').value = value;
}
</script>