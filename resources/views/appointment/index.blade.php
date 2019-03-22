@extends('layouts.app')

@section('content')
<div class="container">
	<div class="row justify-content-center">
		<div class="col-md-8">
			<div class="card">
				<div class="card-header">
					<div class="pull-left">
						@if (isset($patient))
						<strong>{{ __('patientcare.appointments') }}</strong>
						<span> - <a href="/patient/{{ $patient->id }}" style="color:#000;">{{ $patient->name }} {{ $patient->lastNames }}</a></span>
						@else
						{{ __('patientcare.appointments') }}
						@endif
					</div>
					<div class="pull-right">
						@if (Auth::user()->hasPermission('appointment_create'))
						<a href="/appointment/create">
							<button type="button" class="btn btn-primary btn-icon" data-toggle="tooltip" data-placement="top" title="{{ __('patientcare.create') }} {{ __('patientcare.appointment') }}">
								<i class="fas fa-plus"></i>
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
						<button type="button" class="btn btn-light btn-icon open-button" data-toggle="tooltip" data-placement="top" title="{{ __('patientcare.viewAll') }} {{ __('patientcare.appointments') }}">
							<i class="far fa-eye"></i>
						</button>
						<button type="button" class="btn btn-light btn-icon close-button" data-toggle="tooltip" data-placement="top" title="{{ __('patientcare.closeAll') }} {{ __('patientcare.appointments') }}">
							<i class="far fa-eye-slash"></i>
						</button>
					</div>
				</div>

				<div class="card-body">
					@foreach ($appointments as $appoint)
					<p class="card-text appointment-title index-appointment-title" id="heading{{ $appoint->id }}" data-toggle="collapse" data-target="#collapse{{ $appoint->id }}" aria-expanded="true" aria-controls="{{ $appoint->id }}">
						<strong>{{ $appoint->diagnosis }} - {{ date('d/m/Y', strtotime($appoint->created_at)) }}</strong>
						<span class="pull-right">
							@if (Auth::user()->hasPermission('appointment_view'))
							<a href="/patient/{{ $appoint->idPatient }}/appointment/{{ $appoint->id }}" data-toggle="tooltip" data-placement="top" title="{{ __('patientcare.view') }} {{ __('patientcare.appointment') }}">
								<i class="fas fa-external-link-alt"></i>
							</a> <span style="margin-right: 5px"></span>
							@endif
							@if (Auth::user()->hasPermission('appointment_edit'))
							<a href="/patient/{{ $appoint->idPatient }}/appointment/{{ $appoint->id }}/edit" data-toggle="tooltip" data-placement="top" title="{{ __('patientcare.edit') }} {{ __('patientcare.appointment') }}">
								<i class="fas fa-edit"></i>
							</a> <span style="margin-right: 5px"></span>
							@endif
							@if (Auth::user()->hasPermission('appointment_delete'))
							<span data-toggle="tooltip" data-placement="top" title="{{ __('patientcare.delete') }} {{ __('patientcare.appointment') }}">
								<a
									href="#"
									data-toggle="modal"
									data-target="#appointDeleteModal"
									data-pid="{{ $appoint->idPatient }}"
									data-aid="{{ $appoint->id }}">
									<i class="fas fa-trash-alt"></i>
								</a>
							</span>
							@endif
						</span>
					</p>
					<div id="collapse{{ $appoint->id }}" class="collapse show }}" aria-labelledby="heading{{ $appoint->id }}">
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
				</div>
				{{ $appointments->links() }}
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
			<form method="POST" action="/patient/id/appointment/" id="appointDeleteForm">
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
	$(document).on("show.bs.modal", '#appointDeleteModal', function (e) {
		var pid = $(e.relatedTarget).data('pid');
		var aid = $(e.relatedTarget).data('aid');
		$('#appointDeleteForm').attr('action', '/patient/'+pid+'/appointment/'+aid);
	});
</script>
@endsection