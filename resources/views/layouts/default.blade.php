<div class="container-fluid">
    <div class="row">
      <!-- Sidebar -->
      <div class="col-md-2">
        @include('components.menu')
      </div>

      <!-- Main Content -->
      <div class="col-md-10" style="padding-left: 20px; margin-left: 250px;">
        @include('components.header')
        <div class="app-content" style="margin-top: 80px;">
          @yield('content')
        </div>
      </div>
    </div>
  </div>
