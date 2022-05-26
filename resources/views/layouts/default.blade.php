<!doctype html>
<html>
<head>
   @include('includes.head')
   @livewireStyles
</head>
<body class="d-flex flex-column h-100">
    @include('includes.header')
    <main class="flex-shrink-0" style="min-height:calc(100vh - 56px);">
      <div class="container mt-5">
        @yield('content')
      </div>
    </main>
    @include('includes.footer')
    @livewireScripts
</body>
</html>
