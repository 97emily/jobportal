<!-- start sidebar-block -->
<div class="sidebar-block">
    <div class="sidebar-title">MANAGE</div>
    <ul class="list-unstyled sidebar-content">

        <!-- Job Listings Menu -->
        <li class="sidebar-item">
            <a href="#manage-menu" data-bs-toggle="collapse"
                aria-expanded="{{ Request::is('admin/jobs*') || Request::is('admin/categories*') || Request::is('admin/tags*') || Request::is('admin/salary_ranges*') || Request::is('admin/locations*') ? 'true' : 'false' }}"
                class="dropdown-toggle {{ Request::is('admin/jobs*') || Request::is('admin/categories*') || Request::is('admin/tags*') || Request::is('admin/salary_ranges*') || Request::is('admin/locations*') ? '' : 'collapsed' }}">
                <i class="fa-solid fa-layer-group"></i>
                <span>Job Listings</span>
            </a>

            <ul class="sidebar-second-level collapse list-unstyled {{ Request::is('admin/jobs*') || Request::is('admin/categories*') || Request::is('admin/tags*') || Request::is('admin/salary_ranges*') || Request::is('admin/locations*') ? 'show' : '' }}"
                id="manage-menu" data-parent="#left-sidebar">

                @can('job-list')
                    <li class="{{ Request::is('admin/jobs*') ? 'active' : '' }}">
                        <x-nav-link :href="route('jobs.index')" :active="Request::is('admin/jobs*')">
                            {{ __('Manage Jobs') }}
                        </x-nav-link>
                    </li>
                @endcan

                @can('category-list')
                    <li class="{{ Request::is('admin/categories*') ? 'active' : '' }}">
                        <x-nav-link :href="route('categories.index')" :active="Request::is('admin/categories*')">
                            {{ __('Manage Category') }}
                        </x-nav-link>
                    </li>
                @endcan

                @can('tag-list')
                    <li class="{{ Request::is('admin/tags*') ? 'active' : '' }}">
                        <x-nav-link :href="route('tags.index')" :active="Request::is('admin/tags*')">
                            {{ __('Manage Tags') }}
                        </x-nav-link>
                    </li>
                @endcan

                @can('salary-list')
                    <li class="{{ Request::is('admin/salary_ranges*') ? 'active' : '' }}">
                        <x-nav-link :href="route('salary_ranges.index')" :active="Request::is('admin/salary_ranges*')">
                            {{ __('Manage Salary Ranges') }}
                        </x-nav-link>
                    </li>
                @endcan

                @can('location-list')
                    <li class="{{ Request::is('admin/locations*') ? 'active' : '' }}">
                        <x-nav-link :href="route('locations.index')" :active="Request::is('admin/locations*')">
                            {{ __('Manage Locations') }}
                        </x-nav-link>
                    </li>
                @endcan

                @include('layouts.admin.partials.left-sidebar.generator')
            </ul>
        </li>
        <!-- Assessment Tests Menu -->
        <li class="sidebar-item">
            <a href="#assessment-menu" data-bs-toggle="collapse"
                aria-expanded="{{ Request::is('admin/assessments*') || Request::is('admin/assessments*') || Request::is('admin/questions*') ? 'true' : 'false' }}"
                class="dropdown-toggle {{ Request::is('admin/assessments*') || Request::is('admin/assessments*') || Request::is('admin/questions*') ? '' : 'collapsed' }}">
                <i class="fa-solid fa-book"></i>
                <span>Assessment Tests</span>
            </a>
            <ul class="sidebar-second-level collapse list-unstyled {{ Request::is('admin/assessments*') || Request::is('admin/assessments*') || Request::is('admin/questions*') ? 'show' : '' }}"
                id="assessment-menu" data-parent="#left-sidebar">

                @can('assessment-list')
                    <li class="{{ Request::is('admin/assessments*') ? 'active' : '' }}">
                        <x-nav-link :href="route('assessments.index')" :active="Request::is('admin/assessments*')">
                            {{ __('Manage Assessments') }}
                        </x-nav-link>
                    </li>
                @endcan

                @can('question-list')
                    <li class="{{ Request::is('admin/questions*') ? 'active' : '' }}">
                        <x-nav-link :href="route('questions.index')" :active="Request::is('admin/questions*')">
                            {{ __('Manage MCQ Questions') }}
                        </x-nav-link>
                    </li>
                @endcan

                @can('assessment-list')
                <li class="{{ Request::is('admin/practical_tests*') ? 'active' : '' }}">
                    <x-nav-link :href="route('practical_tests.index')" :active="Request::is('admin/practical_tests*')">
                        {{ __('Manage Practical Tests') }}
                    </x-nav-link>
                </li>
            @endcan
            @can('question-list')
                <li class="{{ Request::is('admin/practical_questions*') ? 'active' : '' }}">
                    <x-nav-link :href="route('practical_questions.index')" :active="Request::is('admin/practical_questions*')">
                        {{ __('Manage Practical Questions') }}
                    </x-nav-link>
                </li>
            @endcan

            </ul>
        </li>

        <!-- Shortlisted Applicants -->
        <li class="sidebar-item">
            <a href="#applicants-menu" data-bs-toggle="collapse"
                aria-expanded="{{ Request::is('admin/applicants*')  ? 'true' : 'false' }}"
                class="dropdown-toggle {{ Request::is('admin/applicants*')  ? '' : 'collapsed' }}">
                <i class="fa-solid fa-users"></i>
                <span>Job Applicants</span>
            </a>
            <ul class="sidebar-second-level collapse list-unstyled {{ Request::is('admin/applicants*')  ? 'show' : '' }}"
                id="applicants-menu" data-parent="#left-sidebar">

                @can('job-list')
                    <li class="{{ Request::is('admin/applicants*') ? 'active' : '' }}">
                        <x-nav-link :href="route('applicants.index')" :active="Request::is('admin/applicants*')">
                            {{ __('Manage applicants') }}
                        </x-nav-link>
                    </li>
                @endcan
            </ul>
        </li>

        <!-- Interviews -->
        <li class="sidebar-item">
            <a href="#interviews-menu" data-bs-toggle="collapse"
                aria-expanded="{{ Request::is('admin/interview*') || Request::is('admin/interview*') || Request::is('admin/questions*') ? 'true' : 'false' }}"
                class="dropdown-toggle {{ Request::is('admin/interview*') || Request::is('admin/interview*') || Request::is('admin/questions*') ? '' : 'collapsed' }}">
                <i class="fa-solid fa-briefcase"></i>
                <span>Interviews</span>
            </a>
            <ul class="sidebar-second-level collapse list-unstyled {{ Request::is('admin/interview*') || Request::is('admin/interview*') || Request::is('admin/questions*') ? 'show' : '' }}"
                id="interviews-menu" data-parent="#left-sidebar">
                @can('assessment-list')
                    <li class="{{ Request::is('admin/interview*') ? 'active' : '' }}">
                        <x-nav-link :href="route('interviews.index')" :active="Request::is('admin/interview*')">
                            {{ __('Interviews & Shortlist') }}
                        </x-nav-link>
                    </li>
                @endcan
                {{-- @can('question-list')
                    <li class="{{ Request::is('admin/questions*') ? 'active' : '' }}">
                        <x-nav-link :href="route('questions.index')" :active="Request::is('admin/questions*')">
                            {{ __('Manage Questions') }}
                        </x-nav-link>
                    </li>
                @endcan --}}
            </ul>
        </li>

        <!-- User and Permission Menu -->
        <li class="sidebar-item">
            <a href="#user-menu" data-bs-toggle="collapse"
                aria-expanded="{{ Request::is('admin/users*') || Request::is('admin/roles*') ? 'true' : 'false' }}"
                class="dropdown-toggle {{ Request::is('admin/users*') || Request::is('admin/roles*') ? '' : 'collapsed' }}">
                <i class="fa-solid fa-person"></i>
                <span>User and Permission</span>
            </a>
            <ul class="sidebar-second-level collapse list-unstyled {{ Request::is('admin/users*') || Request::is('admin/roles*') ? 'show' : '' }}"
                id="user-menu" data-parent="#left-sidebar">

                @can('user-list')
                    <li class="{{ Request::is('admin/users*') ? 'active' : '' }}">
                        <x-nav-link :href="route('users.index')" :active="Request::is('admin/users*')">
                            {{ __('Manage Users') }}
                        </x-nav-link>
                    </li>
                @endcan

                @can('role-list')
                    <li class="{{ Request::is('admin/roles*') ? 'active' : '' }}">
                        <x-nav-link :href="route('roles.index')" :active="Request::is('admin/roles*')">
                            {{ __('Manage Roles') }}
                        </x-nav-link>
                    </li>
                @endcan

            </ul>
        </li>

    </ul>
</div>
<!-- end sidebar-block -->
