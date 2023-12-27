@if(env('APP_ENV') == 'production'  && optional(auth()->user())->id != 1)
<!-- Global site tag (gtag.js) - Google Analytics -->

@endif
