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
								<select class="form-control{{ $errors->has($uRole->id) ? ' is-invalid' : '' }}{{ ($loop->last && !($userRoles->count() < $roles->count())) ? '' : ' multiple-inputs' }}" id="{{ $uRole->id }}" name="{{ $uRole->id }}" required>
									<option>{{ __('patientcare.select') }}</option>
									@foreach ($roles as $role)
									<option value="{{ $role->id }}" {{ $uRole->idRole == $role->id ? 'selected' : ''}}>{{ __('patientcare.role'.$role->roleName) }}</option>
									@endforeach
								</select>
								@endforeach
								@if ($userRoles->count() < $roles->count())
								<button type="button" class="btn btn-light btn-icon btn-circle pull-right"><i class="fas fa-plus"></i></button>
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
        <h5 class="modal-title" id="modalTitle">{{ __('patientcare.userRole') }}</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
			<form method="POST" action="/insurance" id="insuranceForm">
      	<div class="modal-body">
					@csrf
					<div style="display: none;">
					<input id="patientname" name="name" type="text" value="{{ $patient->name }}">
					<input id="patientlastNames" name="lastNames" type="text" value="{{ $patient->lastNames }}">
					<input id="patientbirthdate" name="birthdate" type="text" value="{{ $patient->birthdate }}">
					<input id="patientgender" name="gender" type="text" value="{{ $patient->gender }}">
					<input id="patientemail" name="email" type="text" value="{{ $patient->email }}">
					</div>
					<div class="form-group row">
						<label for="insuranceName" class="col-md-4 col-form-label text-md-right">{{ __('patientcare.insuranceName') }}</label>

						<div class="col-md-6">
							<input id="insuranceName" type="text" class="form-control{{ $errors->has('insuranceName') ? ' is-invalid' : '' }}" name="insuranceName" value="{{ old('insuranceName') }}" required autofocus>

							@if ($errors->has('insuranceName'))
								<span class="invalid-feedback" role="alert">
									<strong>{{ $errors->first('insuranceName') }}</strong>
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
					<button type="submit" class="btn btn-primary" id="submitButton">{{ __('patientcare.create') }}</button>
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
