@extends('layouts.app')

@section('content')
<div class="container">
	<div class="row justify-content-center">
		<div class="col-md-8">
			<div class="card">
				<div class="card-header">
					<div class="pull-left">
						<h5><strong>{{ __('patientcare.appointment') }}</strong></h5>
						<strong><a style="color: #000;" href="/patient/{{ $patient->id }}">{{ $patient->name }} {{ $patient->lastNames }}</a></strong>
						<h6><strong>{{ $appointment->diagnosis }}</strong> - {{ date('d/m/Y', strtotime($appointment->created_at)) }}</h6>
					</div>
					<div class="pull-right">
						@if (Auth::user()->hasPermission('appointment_edit'))
						<a href="/patient/{{ $patient->id }}/appointment/{{ $appointment->id }}/edit">
							<button type="button" class="btn btn-primary btn-icon" data-toggle="tooltip" data-placement="top" title="{{ __('patientcare.edit') }} {{ __('patientcare.appointment') }}">
								<i class="fas fa-edit"></i>
							</button>
						</a>
						@endif
						@if (Auth::user()->hasPermission('appointment_delete'))
						<span data-toggle="tooltip" data-placement="top" title="{{ __('patientcare.delete') }} {{ __('patientcare.appointment') }}">
							<button 
								type="button" 
								class="btn btn-danger btn-icon"
								data-toggle="modal"
								data-target="#appointDeleteModal">
								<i class="fas fa-trash-alt"></i>
							</button>
						</span>
						@endif
					</div>
				</div>

				<div class="card-body">
					<p class="card-text underline appointment-subtitle">{{ __('patientcare.symptoms') }}</p>
					<p class="card-text appointment-text">{{ $appointment->symptoms }}</p>

					<p class="card-text underline appointment-subtitle">{{ __('patientcare.exploration') }}</p>
					<p class="card-text appointment-text">{{ __('patientcare.heartrate') }}: {{ $appointment->heartrate }}</p>
					<p class="card-text appointment-text">{{ __('patientcare.bloodpressure') }}: {{ $appointment->bloodpressure }}</p>
					<p class="card-text appointment-text">{{ __('patientcare.temp') }}: {{ $appointment->temp }}°{{ __('patientcare.tempUnit') }}</p>
					<p class="card-text appointment-text">{{ __('patientcare.weight') }}: {{ $appointment->weight }} {{ __('patientcare.weightUnit') }}</p>
					<p class="card-text appointment-text">{{ __('patientcare.height') }}: {{ $appointment->height }} {{ __('patientcare.heightUnit') }}</p>
					<p class="card-text appointment-text">{{ __('patientcare.bmi') }}: {{-- $appointment->bmi --}}</p>
					<p class="card-text appointment-text">{{ $appointment->exploration }}</p>

					<p class="card-text underline appointment-subtitle">{{ __('patientcare.prevStudies') }}</p>
					<p class="card-text appointment-text">{{ $appointment->prevStudies }}</p>

					<p class="card-text underline appointment-subtitle">{{ __('patientcare.diagnosis') }}</p>
					<p class="card-text appointment-text">{{ $appointment->diagnosis }}</p>

					<p class="card-text underline appointment-subtitle">{{ __('patientcare.treatment') }}</p>
					<p class="card-text appointment-text">{{ $appointment->treatment }}</p>
				</div>
			</div>
		</div>
	</div>
</div>
<!-- DELETE MODAL -->
<div class="modal" id="appointDeleteModal" tabindex="-1" role="dialog">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="modalTitle">{{ __('patientcare.delete') }} {{ __('patientcare.appointment') }}</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
			<form method="POST" action="/patient/{{ $patient->id }}/appointment/{{ $appointment->id }}" id="appointDeleteForm">
				@csrf
				@method("DELETE")
				<div class="modal-body">
					<h3>{{ __('patientcare.¿') }}{{ __('patientcare.areYouSure') }}?</h3>
					<h5>{{ __('patientcare.¿') }}{{ __('patientcare.delete') }} {{ __('patientcare.appointment') }}?
				</div>
				<div class="modal-footer">
					<button type="button" class="btn btn-secondary" data-dismiss="modal">{{ __('patientcare.cancel') }}</button>
					<button type="submit" class="btn btn-danger" tabindex="0">{{ __('patientcare.delete') }}</button>
				</div>
			</form>
    </div>
  </div>
</div>
@stop
@section('script')
<script>
</script>
@endsection