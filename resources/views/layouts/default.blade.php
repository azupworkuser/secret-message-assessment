<html>

<head>
    <title>@yield('title')</title>
    @vite(['resources/sass/main.scss', 'resources/js/app.js'])
</head>

<body class="container bg-light py-4">
    <div id="main_content">
        @yield('content')
    </div>
    <x-main-footer />
    <script type="text/javascript">
        var forms = document.querySelectorAll('.needs-validation')

        Array.prototype.slice.call(forms)
            .forEach(function(form) {
                form.addEventListener('submit', function(event) {
                    if (!form.checkValidity()) {
                        event.preventDefault()
                        event.stopPropagation()
                    }

                    form.classList.add('was-validated')
                }, false)
            });
    </script>
    @stack('scripts')
</body>

</html>