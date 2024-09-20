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
// sales
function increaseSoup(data){
      soup = document.querySelector('#soup-' + data);
      var value = parseInt(soup.value, 10);
      value = isNaN(value) ? 0 : value;
      value++;
      soup.value = value;
}

function decreaseSoup(data){
      soup = document.querySelector('#soup-' + data);
      var value = parseInt(soup.value, 10);
      value = isNaN(value) ? 0 : value;
      value < 1 ? value = 1 : '';
      value--;
      soup.value = value;
}
</script>

<script>
// 
function increaseSwallow(data) {
      swallow = document.querySelector('#swallow-' + data);
      var value = parseInt(swallow.value, 10);
      value = isNaN(value) ? 0 : value;
      value++;
      swallow.value = value;
}

function decreaseSwallow(data) {
      swallow = document.querySelector('#swallow-' + data);
      var value = parseInt(swallow.value, 10);
      value = isNaN(value) ? 0 : value;
      value < 1 ? value = 1 : '';
      value--;
      swallow.value = value;
}
</script>

<script>
function increaseProtein(data) {
      protein = document.querySelector('#protein-' + data);
      var value = parseInt(protein.value, 10);
      value = isNaN(value) ? 0 : value;
      value++;
      protein.value = value;
}

function decreaseProtein(data) {
      protein = document.querySelector('#protein-' + data);
      var value = parseInt(protein.value, 10);
      value = isNaN(value) ? 0 : value;
      value < 1 ? value = 1 : '';
      value--;
      protein.value = value;
}
</script>

<script>
// 
function increaseOthers(data) {
      others = document.querySelector('#others-' + data);
      var value = parseInt(others.value, 10);
      value = isNaN(value) ? 0 : value;
      value++;
      others.value = value;
}

function decreaseOthers(data) {
      others = document.querySelector('#others-' + data);
      var value = parseInt(others.value, 10);
      value = isNaN(value) ? 0 : value;
      value < 1 ? value = 1 : '';
      value--;
      others.value = value;
}
</script>

<script>
// parent vendor send supplies to outlet
function increaseSupply(data){
      soup = document.querySelector('#supply-' + data);
      var value = parseInt(soup.value, 10);
      value = isNaN(value) ? 0 : value;
      value++;
      soup.value = value;

}

function decreaseSupply(data){
      soup = document.querySelector('#supply-' + data);
      var value = parseInt(soup.value, 10);
      value = isNaN(value) ? 0 : value;
      value < 1 ? value = 1 : '';
      value--;
      soup.value = value;

}
</script>


