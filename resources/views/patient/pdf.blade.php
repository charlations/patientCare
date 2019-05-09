@extends('layouts.print')

@section('content')
<div class="container">
	<div class="row justify-content-center">
		<div class="col-md-8">
			<div class="card">
				<div class="card-header">
					<div class="pull-left">
						<h6><strong>{{ $data['patient']->name }} {{ $data['patient']->lastNames }}</strong></h6>
						<strong>{{ __('patientcare.age') }}: </strong>
						{{ $data['patientAge'] }}
					</div>
				</div>
				<div class="card-body">
					<h5 class="card-title">{{ __('patientcare.medicalHistory') }}</h5>
					@foreach ($data['medHistory'] as $medListItem)
					<p class="card-text">
						<!-- TODO: change to 'eng_name' when in english -->
						@if (App::isLocale('es'))
							<strong>{{ $medListItem->name }} </strong>
						@elseif (App::isLocale('en'))
							<strong>{{ $medListItem->eng_name }} </strong>
						@endif
						{{ $medListItem->histRecord }}
					</p>
					@endforeach
				</div>
				<div class="card-body" id="appointmentAccordion">
					<h5 class="card-title">
						{{ __('patientcare.appointments') }}
					</h5>
					<div>
						@foreach ($data['appointments'] as $appoint)
						<p class="card-text appointment-title" id="heading{{ $appoint->id }}">
							<strong>{{ $appoint->diagnosis }} - {{ date('d/m/Y', strtotime($appoint->created_at)) }}</strong>
						</p>
						<div>
							<p class="card-text underline appointment-subtitle">{{ __('patientcare.symptoms') }}</p>
							<p class="card-text appointment-text">{{ $appoint->symptoms }}</p>

							<p class="card-text underline appointment-subtitle">{{ __('patientcare.exploration') }}</p>
							<p class="card-text appointment-text">{{ __('patientcare.heartrate') }}: {{ $appoint->heartrate }}</p>
							<p class="card-text appointment-text">{{ __('patientcare.bloodpressure') }}: {{ $appoint->bloodpressure }}</p>
							<p class="card-text appointment-text">{{ __('patientcare.temp') }}: {{ $appoint->temp }}°{{ __('patientcare.tempUnit') }}</p>
							<p class="card-text appointment-text">{{ __('patientcare.weight') }}: {{ $appoint->weight }} {{ __('patientcare.weightUnit') }}</p>
							<p class="card-text appointment-text">{{ __('patientcare.height') }}: {{ $appoint->height }} {{ __('patientcare.heightUnit') }}</p>
							<p class="card-text appointment-text">{{ __('patientcare.bmi') }}: {{-- $appoint->bmi --}}</p>
							<p class="card-text appointment-text">{{ $appoint->exploration }}</p>

							<p class="card-text underline appointment-subtitle">{{ __('patientcare.prevStudies') }}</p>
							<p class="card-text appointment-text">{{ $appoint->prevStudies }}</p>

							<p class="card-text underline appointment-subtitle">{{ __('patientcare.diagnosis') }}</p>
							<p class="card-text appointment-text">{{ $appoint->diagnosis }}</p>

							<p class="card-text underline appointment-subtitle">{{ __('patientcare.treatment') }}</p>
							<p class="card-text appointment-text">{{ $appoint->treatment }}</p>
						</div>
						@endforeach
					</div> <!-- id="appointmentAccordion" -->
				</div>
			</div>
		</div>
	</div>
</div>
@endsection