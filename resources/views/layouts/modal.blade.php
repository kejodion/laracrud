<div class="modal" tabindex="-1" role="dialog" data-backdrop="static" data-ajax-modal>
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">@yield('title')</h5>
                <button type="button" class="close" data-dismiss="modal">&times;</button>
            </div>
            @yield('content')
        </div>
    </div>
</div>