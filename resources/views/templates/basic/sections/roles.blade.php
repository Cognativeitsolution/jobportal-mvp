@php
    $roleContent = getContent('roles.content', true);
    $roles = App\Models\Role::active()->whereHasJobs()->withJobCount()->orderbyDesc('jobs_count')->limit('24')->get();
@endphp
<div class="container">
    <div class="role-section ">
        <div class="role-wrapper  wow fadeInUp" data-wow-duration="2s">
            <x-shape shapeClass="role-wrapper__shape" fileName="r-1" />
            <div class="role-wrapper__content">
                <h2 class="role-wrapper__title wow fadeInRight" data-wow-duration="2s">
                    @php echo styleSelectedWord(@$roleContent->data_values->heading ?? '', 3); @endphp
                </h2>
                <p class="role-wrapper__desc wow fadeInUp" data-wow-duration="2s">
                    {{ __(@$roleContent->data_values->subheading) }}
                </p>
            </div>
            <div class="role-wrapper__slider">
                @if ($roles->count())
                    <div class="content-wrapper  wow fadeInLeft" data-wow-duration="2s">
                        @php
                            $start = 0;
                            $end = 8;
                        @endphp
                        @for ($i = 1; $i <= 3; $i++)
                            <div>
                                <div class="row gy-4 justify-content-center">
                                    @for ($j = $start; $j < $end; $j++)
                                        <div class="col-sm-6">
                                            <a href="{{ route('job.role', @$roles[$j]->id) }}" class="job-list-item">
                                                <div class="job-list-item__thumb">
                                                    <img src="{{ getImage(getFilePath('role') . '/' . @$roles[$j]->image, getFileSize('role')) }}"
                                                         alt="role-image">
                                                </div>
                                                <div class="job-list-item__content">
                                                    <p class="job-list-item__title">{{ __(@$roles[$j]->name) }}</p>
                                                    <span class="job-list-item__text">
                                                        {{ @$roles[$j]->jobs_count }} @lang('jobs')
                                                        <span class="job-list-item__icon">
                                                            <i class="las la-angle-right"></i>
                                                        </span>
                                                    </span>
                                                </div>
                                            </a>
                                        </div>
                                        @php
                                            if (!@$roles[$j + 1]) {
                                                $flag = true;
                                                break;
                                            }
                                        @endphp
                                    @endfor
                                    @php
                                        if (@$flag) {
                                            break;
                                        }
                                        $start = $end;
                                        $end += 8;
                                    @endphp
                                </div>
                            </div>
                        @endfor
                    </div>
                @endif
            </div>
        </div>
    </div>
</div>
