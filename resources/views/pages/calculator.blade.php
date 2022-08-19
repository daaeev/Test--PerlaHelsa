@extends('layouts.app', ['activePage' => 'calculator', 'titlePage' => __('Calculator')])

@section('content')
    <div class="content" id="application-vue">
        <div class="container">
            <calculator-form></calculator-form>
        </div>
    </div>
@endsection