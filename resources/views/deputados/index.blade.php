<!DOCTYPE html>
<html>

<head>
    <title>Deputados e Despesas</title>

    <!-- Bootstrap -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">

    <!-- Estilo customizado -->
    <link rel="stylesheet" href="{{ asset('css/deputados.css') }}">

    <!-- Favicon padrão -->
    <link rel="icon" href="{{ asset('icon/favicon.ico') }}" type="image/x-icon">

    <!-- Favicon PNGs para navegadores modernos -->
    <link rel="icon" type="image/png" sizes="16x16" href="{{ asset('icon/favicon-16x16.png') }}">
    <link rel="icon" type="image/png" sizes="32x32" href="{{ asset('icon/favicon-32x32.png') }}">
    <link rel="icon" type="image/png" sizes="48x48" href="{{ asset('icon/favicon-48x48.png') }}">
    <link rel="icon" type="image/png" sizes="64x64" href="{{ asset('icon/favicon-64x64.png') }}">
    <link rel="icon" type="image/png" sizes="128x128" href="{{ asset('icon/favicon-128x128.png') }}">
    <link rel="icon" type="image/png" sizes="256x256" href="{{ asset('icon/favicon-256x256.png') }}">

    <!-- Apple / Android -->
    <link rel="apple-touch-icon" sizes="180x180" href="{{ asset('icon/apple-touch-icon.png') }}">
    <link rel="manifest" href="{{ asset('icon/site.webmanifest') }}">
</head>

<body>
    <div class="container mt-4">

        <h1>Deputados</h1>

        @if (session('status'))
            <div class="alert alert-success">{{ session('status') }}</div>
        @endif

        <form method="GET" action="{{ route('deputados.index') }}" class="mb-4">
            <input type="text" name="nome" placeholder="Buscar deputado" value="{{ request('nome') }}"
                class="form-control" />
            <button type="submit" class="btn btn-primary mt-2">Buscar</button>

            {{-- <a href="{{ route('deputados.sincronizar') }}" class="btn btn-success mb-3 mt-4">Sincronizar deputados</a> --}}
        </form>

        @foreach ($deputados as $dep)
            <div class="card mb-3 shadow-sm border-0">
                <div class="card-header bg-light d-flex align-items-center border-bottom">
                    @if ($dep->url_foto)
                        <img src="{{ asset('img/' . $dep->url_foto) }}" alt="{{ $dep->nome }}" class="deputado-img"
                            onerror="this.style.display='none'">
                    @endif

                    {{-- Nome deputado --}}
                    <div>
                        <p>
                            {{ $dep->sigla_sexo === 'F' ? 'Deputada ' : 'Deputado ' }} {{ $dep->nome }}
                        </p>

                        <span class="badge bg-primary">{{ $dep->sigla_partido }}</span>
                        <span class="badge bg-secondary">{{ $dep->sigla_uf }}</span>
                        <br>
                        <!-- Botão Ver Mais -->

                        <a href="{{ route('deputados.show', $dep->id) }}" class="botaoVerMais">Ver Mais</a>
                    </div>
                </div>

                <div class="card-body">
                    <h5 class="mb-2">Despesas:</h5>
                    <ul class="mb-3">
                        @foreach ($dep->despesas as $despesa)
                            <li>
                                {{ \Carbon\Carbon::parse($despesa->data_despesa)->format('d/m/Y') }} -
                                {{ $despesa->tipo_despesa }} -
                                R$ {{ number_format($despesa->valor, 2, ',', '.') }}
                                (Fornecedor: {{ $despesa->fornecedor }})
                            </li>
                        @endforeach
                    </ul>
                </div>
            </div>
        @endforeach

        {{ $deputados->links() }}
    </div>
</body>

</html>
