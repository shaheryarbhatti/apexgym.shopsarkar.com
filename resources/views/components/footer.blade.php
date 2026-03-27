<!-- footer start-->
<footer class="footer mt-auto py-3 bg-white border-top">
    <div class="container-fluid">
        <div class="row align-items-center">
            <div class="col-md-6 text-center text-md-start">
                <p class="mb-0 text-muted">
                    &copy; {!! \App\Models\Setting::get('footer_text', 'Copyright ' . date('Y') . ' <strong> © Sky Fitness Gym</strong>.') !!}.
                    Developed with excellence by
                    <a href="javascript:void(0)"
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
@if (session('guest_mode_block'))
    <div class="position-fixed top-0 end-0 p-3" style="z-index: 1080;">
        <div class="alert alert-warning alert-dismissible fade show shadow-sm mb-0">
            {{ session('guest_mode_block') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    </div>
@endif
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
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<!-- Theme js-->
<script src="{{asset('public/assets/js/script.js')}}"></script>
<!-- <script src="{{asset('public/assets/js/theme-customizer/customizer.js')}}"></script> -->
<!-- Plugin used-->
<script>
    (function () {
        const deleteCopy = {
            title: @json(__('confirm_delete_title')),
            text: @json(__('confirm_delete_text')),
            confirm: @json(__('confirm_delete_confirm')),
            cancel: @json(__('confirm_delete_cancel')),
        };

        const getThemeColor = () => {
            const css = getComputedStyle(document.documentElement);
            return (css.getPropertyValue('--theme-default') || '#7367f0').trim();
        };

        document.addEventListener('submit', function (event) {
            const form = event.target;
            if (!form || !form.classList.contains('js-confirm-delete')) return;
            if (form.dataset.confirmed === 'true') return;
            event.preventDefault();

            const gapClass = form.dataset.btnGap === 'true' ? 'mx-1' : '';

            Swal.fire({
                title: form.dataset.title || deleteCopy.title,
                text: form.dataset.text || deleteCopy.text,
                icon: 'warning',
                showCancelButton: true,
                confirmButtonText: deleteCopy.confirm,
                cancelButtonText: deleteCopy.cancel,
                confirmButtonColor: getThemeColor(),
                cancelButtonColor: '#e2e8f0',
                reverseButtons: true,
                focusCancel: true,
                customClass: {
                    popup: 'rounded-4',
                    confirmButton: `btn btn-primary fw-bold ${gapClass}`.trim(),
                    cancelButton: `btn btn-light fw-bold ${gapClass}`.trim(),
                },
                buttonsStyling: false,
            }).then((result) => {
                if (result.isConfirmed) {
                    form.dataset.confirmed = 'true';
                    form.submit();
                }
            });
        });
    })();
</script>
@stack('styles')
@stack('scripts')
</body>

<!-- Mirrored from admin.pixelstrap.net/zono/template/index.html by HTTrack Website Copier/3.x [XR&CO'2014], Mon, 04 Aug 2025 09:07:20 GMT -->

</html>
