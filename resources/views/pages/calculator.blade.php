@extends('layouts.app', ['activePage' => 'calculator', 'titlePage' => __('Calculator')])

@section('content')
    <div class="content" id="application-vue">
        <div class="container">
            <calculator-form></calculator-form>

            <h3>Ціна за відправку: <b>0 грн.</b></h3>
        </div>
    </div>
@endsection