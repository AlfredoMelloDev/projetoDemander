{{--
    Arquivo: deputado-detalhe.blade.php
    Descrição: Exibe detalhes de um deputado, incluindo foto, redes sociais e seções de dados pessoais, contato e mandato.
--}}
<!DOCTYPE html>
<html lang="pt-BR">

<head>
    {{-- Seção de metadados e título --}}
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>{{ $deputado->nome }}</title>

    {{-- Link para CSS personalizado --}}
    <link rel="stylesheet" href="{{ asset('css/deputado-detalhe.css') }}">
    {{-- FontAwesome para ícones --}}
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" />
</head>

<body>
    {{-- Início da seção principal do deputado --}}
    <section class="deputado">

        {{-- Bloco de foto do deputado e redes sociais --}}
        <div class="foto">
            {{-- Exibe a foto armazenada --}}
            <img src="{{ asset('img/' . $deputado->url_foto) }}" alt="Foto de {{ $deputado->nome }}" />

            {{-- Função para processar e exibir redes sociais --}}
            <div class="ConteinerRedesSociais">
                @php
                    // Decodifica o JSON de redes sociais e inicializa array de URLs
                    $redes = json_decode($deputado->rede_social, true) ?: [];
                    $urls = [];

                    // Monta URL do Instagram se existir
                    if (!empty($redes['instagram'])) {
                        $urls['instagram'] = 'https://instagram.com/' . ltrim($redes['instagram'], '@');
                    }
                    // Monta URL do Twitter se existir
                    if (!empty($redes['twitter'])) {
                        $urls['twitter'] = 'https://twitter.com/' . ltrim($redes['twitter'], '@');
                    }
                @endphp

                @if (count($urls))
                    {{-- Exibe cada rede social em seu próprio item --}}
                    <div class="social-networks" aria-label="Redes sociais">
                        {{-- Instagram --}}
                        @if (!empty($urls['instagram']))
                            <div class="social-item instagram">
                                <i class="fab fa-instagram"></i>
                                <a href="{{ $urls['instagram'] }}" target="_blank" rel="noopener">
                                    {{ '@' . ltrim($redes['instagram'], '@') }}
                                </a>
                            </div>
                        @endif

                        {{-- Twitter --}}
                        @if (!empty($urls['twitter']))
                            <div class="social-item twitter">
                                <i class="fab fa-twitter"></i>
                                <a href="{{ $urls['twitter'] }}" target="_blank" rel="noopener">
                                    {{ '@' . ltrim($redes['twitter'], '@') }}
                                </a>
                            </div>
                        @endif
                    </div>
                @endif
            </div>

            <a href="#" class="btn" onclick="history.back(); return false;">
                Voltar
            </a>
        </div>

        {{-- Bloco de dados do deputado --}}
        <div class="dados">
            {{-- Exibe o nome completo do deputado --}}
            <h2> {{ $deputado->sigla_sexo === 'F' ? 'Deputada ' : 'Deputado ' }} {{ $deputado->nome }}</h2>

            {{-- Seção: Dados Pessoais --}}
            <h3 class="subtitulo">Dados Pessoais</h3>
            {{-- Sexo --}}
            <p><i class="fas fa-venus-mars"></i> <strong>Sexo:</strong>
                {{ $deputado->sigla_sexo === 'F' ? 'Feminino' : 'Masculino' }}
            </p>
            {{-- Data de Nascimento --}}
            @if ($deputado->data_nascimento)
                <p><i class="fas fa-birthday-cake"></i> <strong>Nascimento:</strong>
                    {{ \Carbon\Carbon::parse($deputado->data_nascimento)->format('d/m/Y') }}
                </p>
            @endif
            {{-- UF de Nascimento --}}
            @if ($deputado->uf_nascimento)
                <p><i class="fas fa-map-pin"></i> <strong>UF Nasc.:</strong> {{ $deputado->uf_nascimento }}</p>
            @endif
            {{-- Município de Nascimento --}}
            @if ($deputado->municipio_nascimento)
                <p><i class="fas fa-city"></i> <strong>Município Nasc.:</strong> {{ $deputado->municipio_nascimento }}
                </p>
            @endif

            {{-- Seção: Contato --}}
            <h3 class="subtitulo">Contato</h3>
            <p><i class="fas fa-phone-alt"></i> <strong>Telefone:</strong> {{ $deputado->telefone }}</p>
            <p><i class="fas fa-envelope"></i> <strong>Email:</strong> {{ $deputado->email }}</p>
            {{-- Website --}}
            @if ($deputado->url_website)
                <p><i class="fas fa-globe"></i> <strong>Website:</strong>
                    <a href="{{ $deputado->url_website }}" target="_blank"
                        rel="noopener">{{ $deputado->url_website }}</a>
                </p>
            @endif
            {{-- URI oficial --}}
            @if ($deputado->uri)
                <p><i class="fas fa-external-link-alt"></i> <strong>URI:</strong>
                    <a href="{{ $deputado->uri }}" target="_blank" rel="noopener">{{ $deputado->uri }}</a>
                </p>
            @endif

            {{-- Seção: Mandato --}}
            <h3 class="subtitulo">Mandato</h3>
            <p><i class="fas fa-flag"></i> <strong>Partido:</strong> {{ $deputado->sigla_partido }}</p>
            <p><i class="fas fa-map-marker-alt"></i> <strong>Estado:</strong> {{ $deputado->sigla_uf }}</p>
            <p><i class="fas fa-id-badge"></i> <strong>ID Legislativo:</strong> {{ $deputado->deputado_id }}</p>
            <p><i class="fas fa-calendar-alt"></i> <strong>Início:</strong>
                {{ \Carbon\Carbon::parse($deputado->data_inicio)->format('d/m/Y') }}
            </p>
            <p><i class="fas fa-calendar-check"></i> <strong>Fim:</strong>
                {{ \Carbon\Carbon::parse($deputado->data_fim)->format('d/m/Y') }}
            </p>
            {{-- Condição Eleitoral --}}
            @if ($deputado->condicao_eleitoral)
                <p><i class="fas fa-user-check"></i> <strong>Condição Eleitoral:</strong>
                    {{ $deputado->condicao_eleitoral }}</p>
            @endif
            {{-- Situação --}}
            @if ($deputado->situacao)
                <p><i class="fas fa-user-clock"></i> <strong>Situação:</strong> {{ $deputado->situacao }}</p>
            @endif
            {{-- Descrição do Status --}}
            @if ($deputado->descricao_status)
                <p><i class="fas fa-info-circle"></i> <strong>Status:</strong> {{ $deputado->descricao_status }}</p>
            @endif
        </div>
    </section>
</body>

</html>
