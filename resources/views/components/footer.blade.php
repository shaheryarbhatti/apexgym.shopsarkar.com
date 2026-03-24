<!-- footer start-->
<footer class="footer mt-auto py-3 bg-white border-top">
    <div class="container-fluid">
        <div class="row align-items-center">
            <div class="col-md-6 text-center text-md-start">
                <p class="mb-0 text-muted">
                    &copy; {!! \App\Models\Setting::get('footer_text', 'Copyright ' . date('Y') . ' <strong> © Sky Fitness Gym</strong>.') !!}.
                    Developed with excellence by
                    <a href="https://www.linkedin.com/in/shaheryar-bhatti-383553110/"
                       target="_blank"
                       class="text-primary text-decoration-none fw-semibold">
                       Shaheryar Bhatti
                    </a>
                </p>
            </div>

            <div class="col-md-6 text-center text-md-end mt-2 mt-md-0">
                <p class="mb-0 text-muted d-flex align-items-center justify-content-center justify-content-md-end">
                    <span>Handcrafted with</span>
                    <span class="mx-1">
                        <i class="fa-solid fa-heart"></i>
                    </span>
                    <span>for better fitness</span>
                </p>
            </div>
        </div>
    </div>
</footer>
</div>
</div>

<!-- latest jquery-->
<script src="{{asset('public/assets/js/jquery.min.js')}}"></script>
<!-- Bootstrap js-->
<script src="{{asset('public/assets/js/bootstrap/bootstrap.bundle.min.js')}}"></script>
<!-- feather icon js-->
<script src="{{asset('public/assets/js/icons/feather-icon/feather.min.js')}}"></script>
<script src="{{asset('public/assets/js/icons/feather-icon/feather-icon.js')}}"></script>
<!-- scrollbar js-->
<script src="{{asset('public/assets/js/scrollbar/simplebar.js')}}"></script>
<script src="{{asset('public/assets/js/scrollbar/custom.js')}}"></script>
<!-- Sidebar jquery-->
<script src="{{asset('public/assets/js/config.js')}}"></script>
<!-- Plugins JS start-->
<script src="{{asset('public/assets/js/sidebar-menu.js')}}"></script>
<script src="{{asset('public/assets/js/sidebar-pin.js')}}"></script>
<script src="{{asset('public/assets/js/slick/slick.min.js')}}"></script>
<script src="{{asset('public/assets/js/slick/slick.js')}}"></script>
<script src="{{asset('public/assets/js/header-slick.js')}}"></script>
<script src="{{asset('public/assets/js/chart/morris-chart/raphael.js')}}"></script>
<script src="{{asset('public/assets/js/chart/morris-chart/morris.js')}}"> </script>
<script src="{{asset('public/assets/js/chart/morris-chart/prettify.min.js')}}"></script>
<script src="{{asset('public/assets/js/chart/apex-chart/apex-chart.js')}}"></script>
<script src="{{asset('public/assets/js/chart/apex-chart/stock-prices.js')}}"></script>
<script src="{{asset('public/assets/js/chart/apex-chart/moment.min.js')}}"></script>
<script src="{{asset('public/assets/js/notify/bootstrap-notify.min.js')}}"></script>
<script src="{{asset('public/assets/js/dashboard/default.js')}}"></script>
<script src="{{asset('public/assets/js/notify/index.js')}}"></script>
<script src="{{asset('public/assets/js/datatable/datatables/jquery.dataTables.min.js')}}"></script>
<script src="{{asset('public/assets/js/datatable/datatables/datatable.custom.js')}}"></script>
<script src="{{asset('public/assets/js/datatable/datatables/datatable.custom1.js')}}"></script>
<script src="{{asset('public/assets/js/owlcarousel/owl.carousel.js')}}"></script>
<script src="{{asset('public/assets/js/owlcarousel/owl-custom.js')}}"></script>
<script src="{{asset('public/assets/js/typeahead/handlebars.js')}}"></script>
<script src="{{asset('public/assets/js/typeahead/typeahead.bundle.js')}}"></script>
<script src="{{asset('public/assets/js/typeahead/typeahead.custom.js')}}"></script>
<script src="{{asset('public/assets/js/typeahead-search/handlebars.js')}}"></script>
<script src="{{asset('public/assets/js/typeahead-search/typeahead-custom.js')}}"></script>
<script src="{{asset('public/assets/js/height-equal.js')}}"></script>
<script src="{{asset('public/assets/js/flat-pickr/flatpickr.js')}}"></script>
<script src="{{asset('public/assets/js/flat-pickr/custom-flatpickr.js')}}"></script>
<!-- Plugins JS Ends-->
<!-- Theme js-->
<script src="{{asset('public/assets/js/script.js')}}"></script>
<!-- <script src="{{asset('public/assets/js/theme-customizer/customizer.js')}}"></script> -->
<!-- Plugin used-->
@stack('styles')
@stack('scripts')
</body>

<!-- Mirrored from admin.pixelstrap.net/zono/template/index.html by HTTrack Website Copier/3.x [XR&CO'2014], Mon, 04 Aug 2025 09:07:20 GMT -->

</html>
