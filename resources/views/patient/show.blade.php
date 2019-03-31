@extends('layouts.app')

@section('content')
<div class="container">
	<div class="row justify-content-center">
		<div class="col-md-8">
			<div class="card">
				<div class="card-header">
					<div class="pull-left">
						<h6><strong>{{ $patient->name }} {{ $patient->lastNames }}</strong></h6>
						<strong>{{ __('patientcare.age') }}: </strong>
						{{ $patientAge }}
					</div>
					<div class="pull-right">
						@if (Auth::user()->hasPermission('patient_edit'))
						<a href="/patient/{{ $patient->id }}/edit">
							<button type="button" class="btn btn-info btn-icon" data-toggle="tooltip" data-placement="top" title="{{ __('patientcare.edit') }} {{ __('patientcare.patient') }}">
								<i class="fas fa-edit"></i>
							</button>
						</a>
						@endif
						@if (Auth::user()->hasPermission('patient_delete'))
						<span data-toggle="tooltip" data-placement="top" title="{{ __('patientcare.delete') }} {{ __('patientcare.patient') }}">
							<button 
								type="button" 
								class="btn btn-danger btn-icon"
								data-toggle="modal"
								data-target="#patientDeleteModal"
								data-name="{{ $patient->name }}"
								data-id="{{ $patient->id }}">
								<i class="fas fa-trash-alt"></i>
							</button>
						</span>
						@endif
						<a href="/patient/{{ $patient->id }}/appointment/create">
							<button type="button" class="btn btn-primary btn-icon" data-toggle="tooltip" data-placement="top" title="{{ __('patientcare.newAppointment') }}">
								<i class="fas fa-notes-medical"></i>
							</button>
						</a>
					</div>
				</div>
				<div class="card-body">
					<h5 class="card-title">{{ __('patientcare.medicalHistory') }}</h5>
					@if($medHistRegisters)
					@foreach ($medHistList as $medListItem)
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
					@else
					<div class="align-center">
						<p class="card-text info-text">
							{{ __('patientcare.noMedicalHistory', ['name' => $patient->name]) }}
						</p>
						@if (Auth::user()->hasPermission('patient_edit'))
						<a href="/patient/{{ $patient->id }}/edit">
							<button type="button" class="btn btn-info">
								<i class="fas fa-edit"></i> {{ __('patientcare.create') }} {{ __('patientcare.medicalHistory') }}
							</button>
						</a>
						@endif
					</div>
					@endif
				</div>
				<div class="card-body" id="appointmentAccordion">
					<h5 class="card-title">
						{{ __('patientcare.appointments') }}
						<span class="pull-right">
							<button type="button" class="btn btn-light btn-icon open-button" data-toggle="tooltip" data-placement="top" title="{{ __('patientcare.viewAll') }} {{ __('patientcare.appointments') }}">
								<i class="far fa-eye"></i>
							</button>
							<button type="button" class="btn btn-light btn-icon close-button" data-toggle="tooltip" data-placement="top" title="{{ __('patientcare.closeAll') }} {{ __('patientcare.appointments') }}">
								<i class="far fa-eye-slash"></i>
							</button>
						</span>
					</h5>
					<div>
						@foreach ($appointments as $appoint)
						<p class="card-text appointment-title" id="heading{{ $appoint->id }}" data-toggle="collapse" data-target="#collapse{{ $appoint->id }}" aria-expanded="{{ $loop->first ? 'true' : 'false' }}" aria-controls="{{ $appoint->id }}">
							<strong>{{ $appoint->diagnosis }} - {{ date('d/m/Y', strtotime($appoint->created_at)) }}</strong>
							@if (Auth::user()->hasPermission('appointment_edit'))
							<span class="pull-right">
								<a href="/patient/{{ $patient->id }}/appointment/{{ $appoint->id }}/edit" data-toggle="tooltip" data-placement="top" title="{{ __('patientcare.edit') }} {{ __('patientcare.appointment') }}">
									<i class="fas fa-edit"></i>
								</a>
							</span>
							@endif
						</p>
						<div id="collapse{{ $appoint->id }}" class="collapse {{ $loop->first ? 'show' : '' }}" aria-labelledby="heading{{ $appoint->id }}">
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
						<!-- Example -->
						<p class="card-text appointment-title" id="headingExample" data-toggle="collapse" data-target="#collapseExample" aria-expanded="true" aria-controls="Example">
							<strong>Ejemplo - 17/01/2019</strong>
						</p>
						<div id="collapseExample" class="collapse" aria-labelledby="headingExample">
							<p class="card-text underline">{{ __('patientcare.symptoms') }}</p>
							<p class="card-text appointment-text">Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit anim id est laborum.</p>
							<p class="card-text underline">{{ __('patientcare.exploration') }}</p>
							<p class="card-text appointment-text">{{ __('patientcare.heartrate') }}: 80</p>
							<p class="card-text appointment-text">{{ __('patientcare.bloodpressure') }}: 90/120</p>
							<p class="card-text appointment-text">{{ __('patientcare.temp') }}: 36.3°C</p>
							<p class="card-text appointment-text">{{ __('patientcare.weight') }}: 63 kg</p>
							<p class="card-text appointment-text">{{ __('patientcare.height') }}: 164 cm</p>
							<p class="card-text appointment-text">{{ __('patientcare.bmi') }}: </p>
							<p class="card-text appointment-text">Sed ut perspiciatis unde omnis iste natus error sit voluptatem accusantium doloremque laudantium, totam rem aperiam, eaque ipsa quae ab illo inventore veritatis et quasi architecto beatae vitae dicta sunt explicabo. Nemo enim ipsam voluptatem quia voluptas sit aspernatur aut odit aut fugit, sed quia consequuntur magni dolores eos qui ratione voluptatem sequi nesciunt. Neque porro quisquam est, qui dolorem ipsum quia dolor sit amet, consectetur, adipisci velit, sed quia non numquam eius modi tempora incidunt ut labore et dolore magnam aliquam quaerat voluptatem. Ut enim ad minima veniam, quis nostrum exercitationem ullam corporis suscipit laboriosam, nisi ut aliquid ex ea commodi consequatur? Quis autem vel eum iure reprehenderit qui in ea voluptate velit esse quam nihil molestiae consequatur, vel illum qui dolorem eum fugiat quo voluptas nulla pariatur?</p>
							<p class="card-text underline">{{ __('patientcare.prevStudies') }}</p>
							<p class="card-text appointment-text">At vero eos et accusamus et iusto odio dignissimos ducimus qui blanditiis praesentium voluptatum deleniti atque corrupti quos dolores et quas molestias excepturi sint occaecati cupiditate non provident, similique sunt in culpa qui officia deserunt mollitia animi, id est laborum et dolorum fuga. Et harum quidem rerum facilis est et expedita distinctio. Nam libero tempore, cum soluta nobis est eligendi optio cumque nihil impedit quo minus id quod maxime placeat facere possimus, omnis voluptas assumenda est, omnis dolor repellendus. Temporibus autem quibusdam et aut officiis debitis aut rerum necessitatibus saepe eveniet ut et voluptates repudiandae sint et molestiae non recusandae. Itaque earum rerum hic tenetur a sapiente delectus, ut aut reiciendis voluptatibus maiores alias consequatur aut perferendis doloribus asperiores repellat.</p>
							<p class="card-text underline">{{ __('patientcare.diagnosis') }}</p>
							<p class="card-text appointment-text">Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit anim id est laborum.</p>
							<p class="card-text underline">{{ __('patientcare.treatment') }}</p>
							<p class="card-text appointment-text">Sed ut perspiciatis unde omnis iste natus error sit voluptatem accusantium doloremque laudantium, totam rem aperiam, eaque ipsa quae ab illo inventore veritatis et quasi architecto beatae vitae dicta sunt explicabo. Nemo enim ipsam voluptatem quia voluptas sit aspernatur aut odit aut fugit, sed quia consequuntur magni dolores eos qui ratione voluptatem sequi nesciunt. Neque porro quisquam est, qui dolorem ipsum quia dolor sit amet, consectetur, adipisci velit, sed quia non numquam eius modi tempora incidunt ut labore et dolore magnam aliquam quaerat voluptatem. Ut enim ad minima veniam, quis nostrum exercitationem ullam corporis suscipit laboriosam, nisi ut aliquid ex ea commodi consequatur? Quis autem vel eum iure reprehenderit qui in ea voluptate velit esse quam nihil molestiae consequatur, vel illum qui dolorem eum fugiat quo voluptas nulla pariatur?</p>
						</div>
						<!-- /Example -->
					</div> <!-- id="appointmentAccordion" -->
				</div>
			</div>
		</div>
	</div>
</div>
<!-- DELETE MODAL -->
<div class="modal" id="patientDeleteModal" tabindex="-1" role="dialog">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="modalTitle">{{ __('patientcare.delete') }} {{ __('patientcare.patient') }}</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
			<form method="POST" action="/patient" id="insuranceDeleteForm">
				@csrf
				@method("DELETE")
				<div class="modal-body">
					<h3>{{ __('patientcare.¿') }}{{ __('patientcare.areYouSure') }}?</h3>
					<h5>{{ __('patientcare.¿') }}{{ __('patientcare.delete') }} <span id="patientDeleteName"></span>?
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
	$(document).on("show.bs.modal", '#insuranceModal', function (e) {
		var id = $(e.relatedTarget).data('id');
		if(id != undefined) {
			$('#insuranceForm').attr('action', '/patient/'+id);
			$("#formMethod").html('{{ method_field("PATCH") }}');
			$("#submitButton").html('{{ __("Update") }}');
		}
		var button = $(e.relatedTarget)
		var id = button.data('id');
		var name = button.data('name');
		var notes = button.data('notes');
		console.log(id + " - " + name + ": " + notes);
		$("#insuranceName").val($(e.relatedTarget).data('name'));
		$("#notes").html($(e.relatedTarget).data('notes'));
	});
	$(document).on("show.bs.modal", '#patientDeleteModal', function (e) {
		var id = $(e.relatedTarget).data('id');
		$('#insuranceDeleteForm').attr('action', '/patient/'+id);
		$("#patientDeleteName").html($(e.relatedTarget).data('name'));
		console.log(id+" - "+$(e.relatedTarget).data('name'))
	});
	/* Open/Close all patient appointments - https://codepen.io/martinkrulltott/pen/mejmmj */
	$(".open-button").on("click", function() {
		$(this).closest('#appointmentAccordion').find('.collapse').collapse('show');
	});

	$(".close-button").on("click", function() {
		$(this).closest('#appointmentAccordion').find('.collapse').collapse('hide');
	});
</script>
@endsection