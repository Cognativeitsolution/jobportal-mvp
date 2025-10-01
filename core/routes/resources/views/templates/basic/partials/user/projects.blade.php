<div class="main-body__top">
    <div id="scrollspyHeading7">
        <div class="profile-dashboard-item m-0 wow fadeInUp" data-wow-duration="2s">
            <div class="profile-dashboard-item__top">
                <h6 class="title">@lang('Projects')</h6>
                <button class="text--base projectBtn" data-action="{{ route('user.project.store') }}" data-project="" data-title="@lang('Add Project')">
                    @lang('Add Project')
                </button>
            </div>
            @if (@$user->userProjects->count() > 0)
                <div class="card-item__inner">
                    <table class="table table--responsive--xl mt-2">
                        <thead>
                            <tr>
                                <th>@lang('Title')</th>
                                <th>@lang('Duration')</th>
                                <th>@lang('Status')</th>
                                <th>@lang('Action')</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($user->userProjects as $userProject)
                                <tr>
                                    <td>{{ __($userProject->title) }}</td>
                                    <td>{{ getAmount($userProject->duration) }} @lang('Month')</td>
                                    <td>@php echo $userProject->statusBadge; @endphp </td>
                                    <td>
                                        <div class="action-btn-wrapper">
                                            <div class="action-buttons">
                                                <button class="action-btn projectBtn" data-bs-toggle="tooltip"
                                                        data-bs-placement="top" data-bs-title="Edit"
                                                        data-action="{{ route('user.project.store', $userProject->id) }}"
                                                        data-project="{{ $userProject }}" data-title="@lang('Edit Project')">
                                                    <i class="las la-pen"></i>
                                                </button>
                                                <button class="action-btn text--danger customConfirmationBtn"
                                                        data-bs-toggle="tooltip" data-bs-placement="top"
                                                        data-bs-title="Delete"
                                                        data-action="{{ route('user.project.delete', $userProject->id) }}"
                                                        data-question="@lang('Are You sure to delete this project?')">
                                                    <i class="las la-trash-alt"></i>
                                                </button>
                                            </div>
                                        </div>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            @else
                <p class="profile-dashboard-item__text">
                    @lang('Stand out to employers by adding details about projects that you have done so far.')
                </p>
            @endif
        </div>
    </div>
</div>

@include('Template::partials.modal.user.project_modal')
