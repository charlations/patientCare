@extends('layouts.app')

@section('content')
<div class="container">
	<div class="row justify-content-center">
		<div class="col-md-8">
			<div class="card">
				<div class="card-header">{{ __('patientcare.edit') }} {{ __('patientcare.user') }}</div>

				<div class="card-body">
					<form method="POST" action="/user/{{ $user->id }}">
						@csrf
						@method("PATCH")
						<div class="form-group row">
							<label for="name" class="col-md-4 col-form-label text-md-right">{{ __('patientcare.name') }}</label>

							<div class="col-md-6">
								<input id="name" type="text" class="form-control{{ $errors->has('name') ? ' is-invalid' : '' }}" name="name" value="{{ $user->name }}" required autofocus>

								@if ($errors->has('name'))
									<span class="invalid-feedback" role="alert">
										<strong>{{ $errors->first('name') }}</strong>
									</span>
								@endif
							</div>
						</div>
						<div class="form-group row">
							<label for="lastNames" class="col-md-4 col-form-label text-md-right">{{ __('patientcare.lastNames') }}</label>

							<div class="col-md-6">
								<input id="lastNames" type="text" class="form-control{{ $errors->has('lastNames') ? ' is-invalid' : '' }}" name="lastNames" value="{{ $user->lastNames }}" autofocus>

								@if ($errors->has('lastNames'))
									<span class="invalid-feedback" role="alert">
										<strong>{{ $errors->first('lastNames') }}</strong>
									</span>
								@endif
							</div>
						</div>
						<div class="form-group row">
							<label for="email" class="col-md-4 col-form-label text-md-right">{{ __('patientcare.email') }}</label>

							<div class="col-md-6">
								<input id="email" type="email" class="form-control{{ $errors->has('email') ? ' is-invalid' : '' }}" name="email" value="{{ $user->email }}" required>

								@if ($errors->has('email'))
									<span class="invalid-feedback" role="alert">
										<strong>{{ $errors->first('email') }}</strong>
									</span>
								@endif
							</div>
						</div>
						<div class="form-group row">
							<label for="role" class="col-md-4 col-form-label text-md-right">{{ __('patientcare.role') }}</label>

							<div class="col-md-6">
								@foreach ($userRoles as $uRole)
								<div class="-input--inline">
									<select class="-btn-circle--1 form-control{{ $errors->has($uRole->id) ? ' is-invalid' : '' }}{{ ($loop->last && !($userRoles->count() < $roles->count())) ? '' : ' multiple-inputs' }}" id="{{ $uRole->id }}" name="{{ $uRole->id }}" onchange="changeValue('user{{ $uRole->id }}', this.value)" required>
										<option>{{ __('patientcare.select') }}</option>
										@foreach ($roles as $role)
										<option value="{{ $role->id }}" {{ $uRole->idRole == $role->id ? 'selected' : ''}}>{{ __('patientcare.role'.$role->roleName) }}</option>
										@endforeach
									</select>
									<button type="button" class="btn btn-danger btn-icon btn-circle pull-right"
									data-toggle="modal" 
									data-target="#deleteRoleModal"
									data-roleid="{{ $uRole->id }}"
									data-userid="{{ $user->id }}" ><i class="fas fa-trash-alt"></i></button>
								</div>
								@endforeach
								@if ($userRoles->count() < $roles->count())
								<button type="button" class="btn btn-light btn-icon btn-circle pull-right" data-toggle="modal" data-target="#addRoleModal"><i class="fas fa-plus"></i></button>
								@endif

								@if ($errors->has('role'))
									<span class="invalid-feedback" role="alert">
										<strong>{{ $errors->first('role') }}</strong>
									</span>
								@endif
							</div>
						</div>

						<div class="form-group row mb-0">
							<div class="col-md-6 offset-md-4">
								<a href="/user"><button type="button" class="btn btn-secondary">{{ __('patientcare.cancel') }}</button></a>
								<button type="submit" class="btn btn-primary">
									{{ __('patientcare.edit') }}
								</button>
							</div>
						</div>
					</form>
				</div>
			</div>
		</div>
	</div>
</div>
<!-- CREATE ROLE MODAL -->
<div class="modal" id="addRoleModal" tabindex="-1" role="dialog">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="modalTitle">{{ __('patientcare.assign') }} {{ __('patientcare.new') }} {{ __('patientcare.role') }}</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
			<form method="POST" action="/user/{{ $user->id }}/roles" id="insuranceForm">
      	<div class="modal-body">
					@csrf
					<div style="display: none;">
						<input id="idUser" name="idUser" type="text" value="{{ $user->id }}">
						<input id="username" name="name" type="text" value="{{ $user->name }}">
						<input id="userlastNames" name="lastNames" type="text" value="{{ $user->lastNames }}">
						<input id="useremail" name="email" type="text" value="{{ $user->email }}">
						@foreach ($userRoles as $uRole)
						<input id="user{{ $uRole->id }}" name="{{ $uRole->id }}" type="text" value="{{ $uRole->idRole }}">
						@endforeach
					</div>
					<div class="form-group row">
						<label for="idRole" class="col-md-4 col-form-label text-md-right">{{ __('patientcare.role') }}</label>

						<div class="col-md-6">
							<select class="form-control{{ $errors->has('idRole') ? ' is-invalid' : '' }}" id="idRole" name="idRole" required>
								<option>{{ __('patientcare.select') }}</option>
								@foreach ($roles as $role)
								@if ( in_array($role->id, $idUsRoles) )
									@continue
								@endif
								<option value="{{ $role->id }}" {{ old('idRole') == $role->id ? 'selected' : ''}}>{{ __('patientcare.role'.$role->roleName) }}</option>
								@endforeach
							</select>

							@if ($errors->has('idRole'))
								<span class="invalid-feedback" role="alert">
									<strong>{{ $errors->first('idRole') }}</strong>
								</span>
							@endif
						</div>
					</div>

					<div class="form-group row">
						<label for="notes" class="col-md-4 col-form-label text-md-right">{{ __('patientcare.notes') }}</label>

						<div class="col-md-6">
							<textarea id="notes" type="text" class="form-control{{ $errors->has('notes') ? ' is-invalid' : '' }}" name="notes" autofocus>{{ old('notes') }}</textarea>

							@if ($errors->has('notes'))
								<span class="invalid-feedback" role="alert">
									<strong>{{ $errors->first('notes') }}</strong>
								</span>
							@endif
						</div>
					</div>
				</div>
				<div class="modal-footer">
					<button type="button" class="btn btn-secondary" data-dismiss="modal">{{ __('patientcare.cancel') }}</button>
					<button type="submit" class="btn btn-primary" id="submitButton">{{ __('patientcare.add') }}</button>
				</div>
			</form>
    </div>
  </div>
</div>
<!-- DELETE ROLE MODAL -->
<div class="modal" id="deleteRoleModal" tabindex="-1" role="dialog">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="modalTitle">{{ __('patientcare.unassign') }} {{ __('patientcare.role') }}</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
			<form method="POST" action="/user/{{ $user->id}}/roles/" id="userroleDeleteForm">
				@csrf
				@method("DELETE")
				<div class="modal-body">
					<h3>{{ __('patientcare.¿') }}{{ __('patientcare.areYouSure') }}?</h3>
					<h5>{{ __('patientcare.¿') }}{{ __('patientcare.unassign') }} {{ $user->name }} {{ __('patientcare.fromThis') }} {{ __('patientcare.role') }}?
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
	$('#name').change(function() {
    $('#username').val($(this).val());
	});
	$('#lastNames').change(function() {
    $('#userlastNames').val($(this).val());
	});
	$('#email').change(function() {
    $('#useremail').val($(this).val());
	});
	function changeValue($id, $value) {
		console.log("Changing " + $id + " to " + $value);
		document.getElementById($id).value = $value;
	}
	$(document).on("show.bs.modal", '#deleteRoleModal', function (e) {
		var roleid = $(e.relatedTarget).data('roleid');
		var userid = $(e.relatedTarget).data('userid');
		$('#userroleDeleteForm').attr('action', '/user/'+userid+'/roles/'+roleid);
		console.log("user " + userid + " - role " + roleid)
	});
</script>
@endsection
