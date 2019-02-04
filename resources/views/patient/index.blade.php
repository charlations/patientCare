@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">
									{{ __('patientcare.patients') }}
									<div class="pull-right">
										<a href="/patient/create">
											<button type="button" class="btn btn-primary btn-icon">
												<i class="fas fa-plus"></i>
											</button>
										</a>
									</div>
								</div>
								

                <div class="card-body">
									<table style="width:100%">
										<thead>
											<tr>
												<th>{{ __('patientcare.patient') }}</th>
												<th>{{ __('patientcare.email') }}</th>
												<th>{{ __('patientcare.action') }}</th>
											</tr>
										</thead>
										<tbody>
										@foreach ($patients as $patient)
											<tr> 
												<td><a href="/patient/{{ $patient->id }}">{{ $patient->name }} {{ $patient->lastNames }}</a></td>
												<td>{{ $patient->email}}</td>
												<td> 
													<div class="btn-group" role="group" aria-label="Basic example">
														@if (Auth::user()->hasPermission('patient_edit'))
														<a href="/patient/{{ $patient->id }}/edit">
															<button 
																type="button" 
																class="btn btn-info btn-icon">
																<i class="fas fa-edit"></i>
															</button>
														</a>
														@endif
														@if (Auth::user()->hasPermission('patient_delete'))
														<button 
															type="button" 
															class="btn btn-danger btn-icon"
															data-toggle="modal"
															data-target="#patientDeleteModal"
															data-name="{{ $patient->name }}"
															data-id="{{ $patient->id }}" >
															<i class="fas fa-trash-alt"></i>
														</button>
														@endif
													</div>
												</td>
											</tr>
										@endforeach
										</tbody>
									</table>
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
					<button type="submit" class="swal-button swal-button--confirm swal-button--danger" tabindex="0">{{ __('patientcare.delete') }}</button>
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
</script>
@endsection