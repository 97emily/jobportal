<!-- start sidebar-block -->
<div class="sidebar-block">
    <div class="sidebar-title">MANAGE</div>
    <ul class="list-unstyled sidebar-content">

      <!-- Job Listings Menu -->
      <li class="sidebar-item">
        <a href="#manage-menu" data-bs-toggle="collapse" aria-expanded="{{ Request::is('admin/jobs*') || Request::is('admin/categories*') || Request::is('admin/tags*') ? 'true' : 'false' }}" class="dropdown-toggle {{ Request::is('admin/jobs*') || Request::is('admin/categories*') || Request::is('admin/tags*') ? '' : 'collapsed' }}">
        <i class="fa-solid fa-layer-group"></i>
        <span>Job Listings</span>
        </a>
        <ul class="sidebar-second-level collapse list-unstyled {{ Request::is('admin/jobs*') || Request::is('admin/categories*') || Request::is('admin/tags*') ? 'show' : '' }}" id="manage-menu" data-parent="#left-sidebar">
          @can('product-list')
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
          @can('category-list')
          <li class="{{ Request::is('admin/categories*') ? 'active' : '' }}">
            <x-nav-link :href="route('categories.index')" :active="Request::is('admin/categories*')">
                {{ __('Manage Salary') }}
            </x-nav-link>
          </li>
        @endcan
        @can('category-list')
        <li class="{{ Request::is('admin/categories*') ? 'active' : '' }}">
          <x-nav-link :href="route('categories.index')" :active="Request::is('admin/categories*')">
              {{ __('Manage Location') }}
          </x-nav-link>
        </li>
      @endcan
          @include('layouts.admin.partials.left-sidebar.generator')
        </ul>
      </li>

      <!-- Assessment Tests Menu -->
      <li class="sidebar-item">
        <a href="#assessment-menu" data-bs-toggle="collapse" aria-expanded="{{ Request::is('admin/assessments*') || Request::is('admin/assessments*') ? 'true' : 'false' }}" class="dropdown-toggle {{ Request::is('admin/assessments*') || Request::is('admin/roles*') ? '' : 'collapsed' }}">
        <i class="fa-solid fa-book"></i>
        <span>Assessment Tests</span>
        </a>
        <ul class="sidebar-second-level collapse list-unstyled {{ Request::is('admin/assessments*') || Request::is('admin/assessments*') ? 'show' : '' }}" id="assessment-menu" data-parent="#left-sidebar">
          @can('assessment-list')
            <li class="{{ Request::is('admin/assessments*') ? 'active' : '' }}">
              <x-nav-link :href="route('assessments.index')" :active="Request::is('admin/assessments*')">
                  {{ __('Manage MCQ Tests') }}
              </x-nav-link>
            </li>
          @endcan
          @can('assessment-list')
            <li class="{{ Request::is('admin/assessments*') ? 'active' : '' }}">
              <x-nav-link :href="route('assessments.index')" :active="Request::is('admin/assessments*')">
                  {{ __('Manage Practicals') }}
              </x-nav-link>
            </li>
          @endcan
        </ul>
      </li>

      <!-- User and Permission Menu -->
      <li class="sidebar-item">
        <a href="#user-menu" data-bs-toggle="collapse" aria-expanded="{{ Request::is('admin/users*') || Request::is('admin/roles*') ? 'true' : 'false' }}" class="dropdown-toggle {{ Request::is('admin/users*') || Request::is('admin/roles*') ? '' : 'collapsed' }}">
        <i class="fa-solid fa-users"></i>
        <span>User and Permission</span>
        </a>
        <ul class="sidebar-second-level collapse list-unstyled {{ Request::is('admin/users*') || Request::is('admin/roles*') ? 'show' : '' }}" id="user-menu" data-parent="#left-sidebar">
          @can('user-list')
            <li class="{{ Request::is('admin/users*') ? 'active' : '' }}">
              <x-nav-link :href="route('users.index')" :active="Request::is('admin/users*')">
                  {{ __('Manage User') }}
              </x-nav-link>
            </li>
          @endcan
          @can('role-list')
            <li class="{{ Request::is('admin/roles*') ? 'active' : '' }}">
              <x-nav-link :href="route('roles.index')" :active="Request::is('admin/roles*')">
                  {{ __('Manage Role') }}
              </x-nav-link>
            </li>
          @endcan
        </ul>
      </li>

    </ul>
</div>
<!-- end sidebar-block -->
