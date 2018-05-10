@extends('layout')
@section('content')
<div class="hero-body justify-center">
  <div class="field">
    <a class="button is-primary is-outlined" href="{{ route('dashboard') }}">
      <i class="fa fa-arrow-left" aria-hidden="true"></i>&nbsp;Back to Dashboard
    </a>
  </div>
    @foreach(App\Country::get() as $cr)
        <collapse-box title="{{ $cr->name }}" icon="Co" :count="{{ $cr->programmes_count }}">
            @foreach($cr->programmes as $p)
                <collapse-box title="{{ $p->name }}" icon="Pr" :count="{{ $p->modules_count }}">
                    @foreach($p->modules as $m)
                        <collapse-box title="{{ $m->name }}" icon="Mo" :count="{{ $m->criterias_count }}">
                            @foreach($m->criterias()->with('links')->get() as $c)
                                <collapse-box title="{{ $c->description }}" icon="Cr" :count="{{ $c->links()->count() }}">
                                    @if($c->links->isNotEmpty()) Linked Criteria:
                                    @else
                                    No Connected Links
                                    @endif
                                    <ul>
                                        @foreach($c->links as $lc)
                                            <li> {{ $lc->description }} - <b>({{ $lc->module->name }})</b> </li>
                                        @endforeach
                                    </ul>
                                </collapse-box>
                            @endforeach
                        </collapse-box>
                    @endforeach
                </collapse-box>
            @endforeach
        </collapse-box>
    @endforeach
</div>
@endsection 