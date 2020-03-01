@extends('layouts.app')

@push('styles')
<style type="text/css">
    @keyframes rotate {
        from {
            transform: rotate( 0deg );
        } to {
            transform: rotate( 360deg );
        }
    }

    .refresh {
        animation: rotate 1.5s linear infinite;
    }
</style>
@endpush

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">Game</div>

                <div class="card-body">

                    <div class="text-center">
                        <img id="circle" width="250" height="250" src="{{ asset( 'img/circle.png' ) }}">
                    </div>

                    <p id="winner" class="display-1 d-none text-primary">10</p>

                </div>

                <hr>

                <div class="text-center">

                    <label class="font-weight-bold h5">Your bet</label>
                    <select id="bet" class="custom-select col-auto">
                        <option selected>Not in</option>
                        @foreach( range( 1, 12 ) as $number )
                            <option>{{ $number }}</option>
                        @endforeach
                    </select>

                    <hr>

                    <p class="font-weight-bold h5">Remaining Time</p>
                    <p id="timer" class="h5 text-danger">Waiting to start</p>

                    <hr>

                    <p id="result" class="h1 text-center"></p>

                </div>

            </div>
        </div>
    </div>
</div>
@endsection

@push( 'scripts' )
<script type="text/javascript">
    
    const circleElement = document.querySelector( '#circle' );
    const timerElement = document.querySelector( '#timer' );
    const winnerElement = document.querySelector( '#winner' );
    const betElement = document.querySelector( '#bet' );
    const resultElement = document.querySelector( '#result' );

    Echo.channel( 'game' )
        .listen( 'RemainingTimeChanged', (e) => {
            
            timerElement.innerText = e.time;
            
            circleElement.classList.add( 'refresh' );

            winnerElement.classList.add( 'd-none' );

            resultElement.innerText = '';

            resultElement.classList.remove( 'text-success' );
            resultElement.classList.remove( 'text-danger' );

        })
        .listen( 'WinnerNumberGenerated', (e) => {
            
            circleElement.classList.remove( 'refresh' );
            
            let winner = e.number;

            winnerElement.innerText = winner;

            winnerElement.classList.remove( 'd-none' );

            let bet = betElement[ betElement.selectedIndex ].innerText;

            if ( bet == winner ) {
                resultElement.innerText = 'You Win';
                resultElement.classList.add( 'text-success' );
            } else {
                resultElement.innerText = 'You Lose';
                resultElement.classList.add( 'text-danger' );
            }

        })

</script>
@endpush