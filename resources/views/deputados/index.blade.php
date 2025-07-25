<!DOCTYPE html>
<html>

<head>
    <title>Deputados e Despesas</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="{{ asset('css/deputados.css') }}">
</head>

{{-- Colocar FAVICON --}}

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
        </form>

        <a href="{{ route('deputados.sincronizar') }}" class="btn btn-success mb-3">Sincronizar deputados</a>

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
