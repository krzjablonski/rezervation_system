{{-- Include header with nav --}}
@include('partials._admin_header')

{{-- Include message box userd by $errors and flash session messages --}}
@include('partials._admin_msg')

{{-- Main content of the page --}}
@yield('content')

{{-- Sidebar --}}
@yield('sidebar')

{{-- Include footer --}}
@include('partials._admin_footer')
