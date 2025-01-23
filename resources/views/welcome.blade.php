<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Rizer Tickets</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
</head>

<body>
    <div class="container mt-5">
        <div class="container text-center">
            <div class="row align-items-start">
                <div class="col">
                    <img src="https://rizer.com.br/img/rizer-sistemas.svg" alt="">
                </div>
                <div class="col">
                    <button type="button" onclick="window.location.href='{{ route('login') }}'"
                        class="btn btn-primary">Entrar</button>
                </div>
            </div>
        </div>
    </div>
    <div class="container mt-5">
        <div class="row flex-lg-row-reverse align-items-center g-5 py-5">
            <div class="col-10 col-sm-8 col-lg-6">
                <img src="{{ asset('images/crie-seu-sistema-do-zero.webp') }}" class="d-block mx-lg-auto img-fluid"
                    alt="Rizer" width="700" height="500" loading="lazy">
            </div>
            <div class="col-lg-6">
                <h1 class="display-5 fw-bold text-body-emphasis lh-1 mb-3">Sistema de ticker Rizer</h1>
                <p class="lead">Conte com o apoio do nosso time para construir o melhor sistema para seu negócio. 100%
                    na nuvem.</p>
                <div class="d-grid d-md-flex justify-content-md-start gap-2">
                    <button type="button" class="btn btn-primary btn-lg me-md-2 px-4">Dúvidas</button>
                    <button type="button" class="btn btn-outline-secondary btn-lg px-4">Contato</button>
                </div>
            </div>
        </div>
    </div>


    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous">
    </script>
</body>

</html>
