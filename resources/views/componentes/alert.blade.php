<div class="alert alert-{{Str::before(Session::get('style'), '|')}}"> <i class="mdi mdi-{{Str::after(Session::get('style'), '|')}}"></i> {{ Session::get('message') }}
    <button type="button" class="close" data-dismiss="alert" aria-label="Close"> <span aria-hidden="true">&times;</span> </button>
</div>