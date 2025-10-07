@php
    $topCompaniesContent = getContent('top_companies.content', true);
    $topCompanyIndustries = App\Models\Industry::active()
        ->withWhereHas('employers', function ($q) {
            $q->active()
                ->whereHas('jobs', function ($query) {
                    $query->approved();
                })
                ->limit(4);
        })
        ->withCount([
            'jobs as total_industry_jobs' => function ($q) {
                $q->where('jobs.status', Status::JOB_APPROVED);
            },
        ])
        ->orderByDesc('total_industry_jobs')
        ->take(8)
        ->get();
@endphp
<div class="industry-section my-120">
    <div class="container">
        <div class="industry-wrapper  wow fadeInUp" data-wow-duration="2s">
            <div class="row">
                <div class="col-lg-12">
                    <div
                         class="section-heading style-left d-flex justify-content-between align-items-center flex-wrap gap-2">
                        <h3 class="section-heading__title wow fadeInUp" data-wow-duration="2s">
                            @php echo styleSelectedWord(@$topCompaniesContent->data_values->heading ?? '', 2); @endphp
                        </h3>
                        <a href="{{ route('company.list') }}" class="section-button wow fadeInUp" data-wow-duration="2s">
                            @lang('Show All')
                            <span class="section-button__icon"><i class="fa-solid fa-arrow-right-long"></i></span>
                        </a>
                    </div>
                </div>
            </div>
            <div class="row gy-4">
                @foreach ($topCompanyIndustries ?? [] as $industry)
                    <div class="col-xl-3 col-lg-4 col-sm-6 col-xsm-6  wow fadeInUp" data-wow-duration="2s">
                        <div class="industry-item">
                            <h5 class="industry-item__name">
                                <a href="{{ route('company.list.industry', $industry->id) }}">
                                    {{ __($industry->name) }}
                                </a>
                            </h5>
                            <span class="industry-item__text fs-14">
                                <strong>{{ $industry->total_industry_jobs }}</strong> @lang('Jobs Available')
                            </span>
                            <div class="industry-logo-list">
                                @foreach ($industry->employers as $employer)
                                    <a href="{{ route('company.profile', $employer->slug) }}"
                                       class="industry-logo flex-grow-1">
                                        <img src="{{ getImage(getFilePath('employer') . '/' . $employer->image, getFileSize('employer')) }}" alt="image">
                                    </a>
                                @endforeach
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
    </div>
</div>
