    
    <div id="js-var" style="visibility:none;" 
        data-toastr-position="{{config('config.notification_position')}}"
        data-something-error-message="{{trans('messages.something_wrong')}}"
        data-character-remaining="{{trans('messages.character_remaining')}}"
        data-textarea-limit="{{config('config.textarea_limit')}}"
        data-processing-messsage="{{trans('messages.processing_message')}}"
        data-redirecting-messsage="{{trans('messages.redirecting_message')}}"
        data-show-error-message="{{config('config.show_error_messages')}}"
        data-action-confirm-message="{{trans('messages.action_confirm_message')}}"
        data-menu="{{isset($menu) ? $menu : ''}}"
        data-calendar-language="{!! config('localization.'.session('localization').'.calendar') !!}" 
        data-datepicker-language="{!! config('localization.'.session('localization').'.datepicker') !!}" 
        data-datatable-language="/vendor/datatables/locale/{!! config('localization.'.session('localization').'.datatable') !!}.json" 
        data-row-deleted="{{trans('messages.row_deleted')}}"
        data-row-cannot-delete="{{trans('messages.row_cannot_delete')}}"
        @if(config('config.enable_stripe_payment'))
            data-stripe-publishable-key = "{{config('config.stripe_publishable_key')}}"
        @endif
        @if(config('config.enable_tco_payment'))
            data-tco-mode = "{{config('config.tco_mode')}}"
            data-tco-seller-id = "{{config('config.tco_seller_id')}}"
            data-tco-publishable-key = "{{config('config.tco_publishable_key')}}"
        @endif
    ></div>

    {!! Html::script('js/jquery.min.js') !!}
    {!! Html::script('js/bootstrap.min.js') !!}
    {!! Html::script('js/sidebar.js') !!}
    {!! HTML::script('vendor/jquery-ui/jquery-ui.min.js') !!}
    {!! Html::script('vendor/slimscroll/jquery.slimscroll.min.js') !!}
    {!! Html::script('vendor/sortable/sortable.min.js') !!}
    {!! Html::script('vendor/select/js/bootstrap-select.min.js') !!}
    {!! HTML::script('vendor/toastr/toastr.min.js') !!}
    @include('global.toastr_notification')
    {!! Html::script('vendor/page/page.min.js') !!}
    @if(isset($assets) && in_array('summernote',$assets))
        {!! Html::script('vendor/summernote/summernote.js') !!}
    @endif
    {!! Html::script('vendor/password/password.js') !!}
    {!! Html::script('vendor/input/bootstrap.file-input.js') !!}
    {!! Html::script('vendor/switch/bootstrap-switch.min.js') !!}
    {!! Html::script('vendor/datepicker/js/bootstrap-datepicker.js') !!}
    @if(session('localization') != 'en')
        {!! Html::script('vendor/datepicker/locales/bootstrap-datepicker.'.config('localization.'.session('localization').'.datepicker').'.min.js') !!}
    @endif
    @if(isset($assets) && in_array('datatable',$assets))
        {!! Html::script('vendor/datatables/datatables.min.js') !!}
    @endif
    @if(isset($assets) && in_array('calendar',$assets))
        {!! Html::script('vendor/calendar/moment.min.js') !!}
        {!! Html::script('vendor/calendar/fullcalendar.min.js') !!}
        {!! Html::script('vendor/calendar/locale-all.js') !!}
    @endif
    @if(isset($assets) && in_array('recaptcha',$assets) && config('config.enable_recaptcha'))
        <script src='https://www.google.com/recaptcha/api.js'></script>
    @endif
    @if(isset($assets) && in_array('tags',$assets))
        {!! Html::script('vendor/tags/tags.min.js') !!}
    @endif
    @if(isset($assets) && in_array('redactor',$assets))
        {!! Html::script('vendor/redactor/redactor.min.js') !!}
    @endif
    @if(isset($assets) && in_array('form-wizard',$assets))
        {!! HTML::script('vendor/wizard/jquery.snippet.js') !!}
        {!! HTML::script('vendor/wizard/jquery.easyWizard.js') !!}
    @endif
    {!! Html::script('js/bootbox.js') !!}
    {!! Html::script('vendor/icheck/icheck.min.js') !!}

    @if(isset($assets) && in_array('graph',$assets))
        {!! Html::script('js/echarts-all.js') !!}
        {!! Html::script('js/chart.min.js') !!}
    @endif
    
    @if(isset($assets) && in_array('stripe',$assets) && config('config.enable_stripe_payment'))
        {!! HTML::script('https://js.stripe.com/v2/') !!}
    @endif
    @if(isset($assets) && in_array('tco',$assets) && config('config.enable_tco_payment'))
        {!! HTML::script('https://www.2checkout.com/checkout/api/2co.min.js') !!}
    @endif
    {!! Html::script('js/upload.js') !!}
    {!! Html::script('js/wmlab.js') !!}
    @include('global.misc')
    </body>
</html>