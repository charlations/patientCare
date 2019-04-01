@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">
									@if (Auth::user()->id == $user->id)
									{{ __('patientcare.myProfile') }}
									@else
									{{ __('patientcare.users') }}
									@endif
									<div class="pull-right">
										@if (Auth::user()->hasPermission('user_edit') || Auth::user()->id == $user->id)
										<a href="/user/{{ $user->id }}/edit">
											<button 
												type="button" 
												class="btn btn-info btn-icon">
												<i class="fas fa-edit"></i>
											</button>
										</a>
										@endif
										@if (Auth::user()->hasPermission('user_delete') && Auth::user()->id != $user->id)
										<button 
											type="button" 
											class="btn btn-danger btn-icon"
											data-toggle="modal"
											data-target="#userDeleteModal"
											data-name="{{ $user->name }}"
											data-id="{{ $user->id }}" >
											<i class="fas fa-trash-alt"></i>
										</button>
										@endif
									</div>
								</div>
								

                <div class="card-body">
								<div class="list-group">
									<li class="list-group-item">
										<strong>{{ __('patientcare.name') }}: </strong>{{ $user->name }} {{ $user->lastNames }}
									</li>
									<li class="list-group-item">
										<strong>{{ __('patientcare.email') }}: </strong>{{ $user->email }}
									</li>
									<li class="list-group-item">
										<strong>{{ __('patientcare.role') }}(s): </strong>
										@foreach($userRoles as $role)
										{{ __('patientcare.role'.$role->roleName) }}
										@if (!$loop->last)
										, 
										@endif
										@endforeach
									</li>
									<li class="list-group-item list-group-item-action">
										<strong>{{ __('patientcare.futureAppointments') }}</strong><span class="badge badge-primary badge-pill pull-right">2</span>
									</li>
								</div>
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
			<form method="POST" action="/user/{{ $user->id }}" id="insuranceDeleteForm">
				@csrf
				@method("DELETE")
				<div class="modal-body">
					<h3>{{ __('patientcare.¿') }}{{ __('patientcare.areYouSure') }}?</h3>
					<h5>{{ __('patientcare.¿') }}{{ __('patientcare.delete') }} {{ $user->name }} {{ $user->lastNames }}?
				</div>
				<div class="modal-footer">
					<button type="button" class="btn btn-secondary" data-dismiss="modal">{{ __('patientcare.cancel') }}</button>
					<button type="submit" class="btn btn-danger" tabindex="0">{{ __('patientcare.delete') }}</button>
				</div>
			</form>
    </div>
  </div>
</div>
@endsection