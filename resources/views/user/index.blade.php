@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">
									{{ __('patientcare.users') }}
									<div class="pull-right">
										<a href="/user/create">
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
												<th>{{ __('patientcare.user') }}</th>
												<th>{{ __('patientcare.email') }}</th>
												<th>{{ __('patientcare.actions') }}</th>
											</tr>
										</thead>
										<tbody>
										@foreach ($users as $user)
											<tr> 
												<td>{{ $user->name }} {{ $user->lastNames }}</td>
												<td>{{ $user->email}}</td>
												<td> 
													<div class="btn-group" role="group" aria-label="Basic example">
														<a href="/user/{{ $user->id }}/edit">
															<button 
																type="button" 
																class="btn btn-info btn-icon">
																<i class="fas fa-edit"></i>
															</button>
														</a>
														<button 
															type="button" 
															class="btn btn-danger btn-icon"
															data-toggle="modal"
															data-target="#userDeleteModal"
															data-name="{{ $user->name }}"
															data-id="{{ $user->id }}" >
															<i class="fas fa-trash-alt"></i>
														</button>
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
<div class="modal" id="userDeleteModal" tabindex="-1" role="dialog">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="modalTitle">{{ __('patientcare.delete') }} {{ __('patientcare.user') }}</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
			<form method="POST" action="/user" id="insuranceDeleteForm">
				@csrf
				@method("DELETE")
				<div class="modal-body">
					<h3>{{ __('patientcare.¿') }}{{ __('patientcare.areYouSure') }}?</h3>
					<h5>{{ __('patientcare.¿') }}{{ __('patientcare.delete') }} <span id="userDeleteName"></span>?
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
	$(document).on("show.bs.modal", '#userDeleteModal', function (e) {
		var id = $(e.relatedTarget).data('id');
		$('#insuranceDeleteForm').attr('action', '/user/'+id);
		$("#userDeleteName").html($(e.relatedTarget).data('name'));
		console.log(id+" - "+$(e.relatedTarget).data('name'))
	});
</script>
@endsection