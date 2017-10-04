 @if ($flash = session('message'))
  <div class="alert alert-success notification">
    {{ $flash }}
  </div>
  @endif
 