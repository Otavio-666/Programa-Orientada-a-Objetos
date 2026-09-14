<?php

class Carta
{

    private $numero;
    private $nome;
    private $dica;
    private $nome_jogador;

    public function __construct($numero, $nome, $dica)
    {
        $this->numero = $numero;
        $this->nome = $nome;
        $this->dica = $dica;
    }

    public function setNomeJogador($nome_jogador)
    {
        $this->nome_jogador = $nome_jogador;
    }

    public function getNomeJogador()
    {
        return $this->nome_jogador;
    }

    public function getNumero()
    {
        return $this->numero;
    }

    public function getNome()
    {
        return $this->nome;
    }

    public function getDica()
    {
        return $this->dica;
    }
}

$baralho1 = [
    new Carta(1, "Ás de Copas", "É a carta do amor e o começo de tudo."),
    new Carta(2, "Dois de Paus", "Representa planejamento e encruzilhadas."),
    new Carta(5, "Cinco de Espadas", "Uma carta que lembra conflitos ou desafios."),
    new Carta(7, "Sete de Ouros", "Tem forte ligação com a colheita e finanças."),
    new Carta(8, "Oito de Copas", "Significa seguir em frente e deixar algo para trás."),
    new Carta(10, "Dez de Paus", "Representa grandes responsabilidades ou fardos."),
    new Carta(13, "Rei de Ouros", "O ápice do sucesso material e estabilidade.")
];

$baralho2 = [
    new Carta(25, "Pikachu", "É do tipo Elétrico e o companheiro de Ash."),
    new Carta(4, "Charmander", "É do tipo Fogo e tem uma chama na cauda."),
    new Carta(1, "Bulbasaur", "É do tipo Planta e tem um bulbo nas costas."),
    new Carta(7, "Squirtle", "É do tipo Água e se parece com uma tartaruga."),
    new Carta(133, "Eevee", "Tem o DNA instável e várias evoluções."),
    new Carta(150, "Mewtwo", "Um Pokémon lendário criado em laboratório."),
    new Carta(39, "Jigglypuff", "Adora cantar e faz todo mundo dormir.")
];

$pontuação = 100;
$tentativas = 0;
$jogando = true;
$vitorias = [];
$soma = 0;
$proximaAcao = null;
$baralhos = [$baralho1, $baralho2];


while ($jogando) {

    if ($proximaAcao == null) {
        echo "\033[H\033[J";
        menu();
        $opcao = readline(false);
        echo "\033[H\033[J";// Limpa a tela, apartir do código ANSI(codigo para formatar e colorir textos no terminal), o \033[H move o cursor para a posição inicial da tela e o \033[J limpa a tela a partir da posição atual do cursor.
        telaDeCarregamento(4);
        echo "\033[H\033[J";
        $i = readline("Com qual baralho você deseja jogar? (1 para o baralho normal, 2 para o baralho especial): ");
        $cartaSecreta = $baralhos[$i - 1][array_rand($baralhos[$i - 1])];
        escreverDevagar("Digite seu nome para começar o jogo: ");
        $nomeJogador = trim(fgets(STDIN));// Trim é usado para remover espaços em branco no início e no final do nome do jogador, FGETS é usado para ler a entrada do usuário a partir do terminal e o STDIN é um recurso que representa a entrada padrão do terminal.
        $cartaSecreta->setNomeJogador($nomeJogador);
        echo "\033[H\033[J";// Limpa a tela, apartir do código ANSI(codigo para formatar e colorir textos no terminal), o \033[H move o cursor para a posição inicial da tela e o \033[J limpa a tela a partir da posição atual do cursor.
        telaDeCarregamento(4);
    } else {
        $opcao = $proximaAcao;
        $proximaAcao = null; 
    }

    switch ($opcao) {
        case 1:
            echo "\033[H\033[J";// Limpa a tela, apartir do código ANSI(codigo para formatar e colorir textos no terminal), o \033[H move o cursor para a posição inicial da tela e o \033[J limpa a tela a partir da posição atual do cursor.
            jogar();
            $palpite = (int)readline(false);
            $proximaAcao = resultado($palpite);
            break;

        case 2:
            echo "\033[H\033[J";// Limpa a tela, apartir do código ANSI(codigo para formatar e colorir textos no terminal), o \033[H move o cursor para a posição inicial da tela e o \033[J limpa a tela a partir da posição atual do cursor.
            explicacao();
            echo "\033[H\033[J";// Limpa a tela, apartir do código ANSI(codigo para formatar e colorir textos no terminal), o \033[H move o cursor para a posição inicial da tela e o \033[J limpa a tela a partir da posição atual do cursor.
            telaDeCarregamento(4);
            break;

        case 3:
            echo "\033[H\033[J";// Limpa a tela, apartir do código ANSI(codigo para formatar e colorir textos no terminal), o \033[H move o cursor para a posição inicial da tela e o \033[J limpa a tela a partir da posição atual do cursor.
            telaDeCarregamento(4);
            echo "\033[H\033[J";// Limpa a tela, apartir do código ANSI(codigo para formatar e colorir textos no terminal), o \033[H move o cursor para a posição inicial da tela e o \033[J limpa a tela a partir da posição atual do cursor.
            echo "Obrigado por entrar no Menu do nosso jogo!\n";
            $jogando = false;
            break;
    }
}

function resultado($palpite)
{
    global $cartaSecreta, $pontuação, $jogando, $tentativas, $soma, $vitorias, $i;

    if ($palpite == 0) {
        
        escreverDevagar("Você desistiu do jogo. A carta secreta era: " . $cartaSecreta->getNome() . " (Número: " . $cartaSecreta->getNumero() . ")\n");
        sleep(2);// Codigo para fazer uma pausa de 2 segundos antes de limpar a tela e mostrar a pontuação final.
        echo "\033[H\033[J";// Limpa a tela, apartir do código ANSI(codigo para formatar e colorir textos no terminal), o \033[H move o cursor para a posição inicial da tela e o \033[J limpa a tela a partir da posição atual do cursor.
        escreverDevagar("Pontuação final acumulada do jogador " . $cartaSecreta->getNomeJogador() . ": $soma pontos\n");
        listar();
        escreverDevagar("Obrigado por jogar! Até a próxima.\n");
        $jogando = false;
    }


    if ($palpite === $cartaSecreta->getNumero()) {
        echo "Parabéns! Você acertou a carta secreta: " . $cartaSecreta->getNome() . " (Número: " . $cartaSecreta->getNumero() . ")\n";
        echo "Sua pontuação final é: $pontuação pontos\n";
        $vitorias[] = $pontuação;
        $soma += $pontuação;

        echo "Deseja jogar novamente? (s/n): ";
        $resposta = strtolower(trim(readline(false)));// strtolower é usado para converter a resposta do usuário para minúsculas, garantindo que a comparação seja case-insensitive, e trim é usado para remover espaços em branco no início e no final da resposta do usuário.
        if ($resposta === 's') {
            $tentativas = 0;
            $pontuação = 100;
           
            $cartaSecreta = $GLOBALS['baralhos'][$i - 1][array_rand($GLOBALS['baralhos'][$i - 1])];

            return 1;
        } else {
            sleep(2);
            echo "\033[H\033[J";// Limpa a tela, apartir do código ANSI(codigo para formatar e colorir textos no terminal), o \033[H move o cursor para a posição inicial da tela e o \033[J limpa a tela a partir da posição atual do cursor.
            echo "Pontuação final acumulada do jogador " . $cartaSecreta->getNomeJogador() . ": $soma pontos\n";
            listar();
            escreverDevagar("Obrigado por jogar! Até a próxima.\n");
            $jogando = false;

        }
    } else {
        echo "Ops! Você errou. Tente novamente.\n";
        $pontuação -= 10;
        if ($pontuação <= 0) {
            echo "Sua pontuação chegou a zero. O jogo acabou!\n";
            echo "A carta secreta era: " . $cartaSecreta->getNome() . " (Número: " . $cartaSecreta->getNumero() . ")\n";
            escreverDevagar("Obrigado por jogar! Até a próxima.\n");
            $jogando = false;
            
        }
        
        escreverDevagar("Pressione Enter para tentar novamente...");
        readline(false);
        return 1;
    }
}

function explicacao()
{
    telaDeCarregamento(4);
    echo "\033[H\033[J";
    echo "==================================================\n";
    echo "                 EXPLICAÇÃO DO JOGO               \n";
    echo "==================================================\n";
    echo "1. O objetivo do jogo é adivinhar qual carta foi sorteada.\n";
    echo "2. Temos 2 baralhos de 7 cartas cada, o primeiro é um baralho normal e o segundo é um baralho especial.\n";
    echo "3. Você terá dicas após a primeira tentativa.\n";
    echo "4. Cada tentativa errada reduz sua pontuação em 10 pontos, se chegar a zero, o jogo termina.\n";
    echo "5. Você pode desistir a qualquer momento digitando um número maior que 13.\n";
    echo "6. A pontuação final é acumulada se você decidir jogar novamente.\n";
    echo "7. Boa sorte!\n\n";

    escreverDevagar("Pressione Enter para voltar ao menu...");
    readline(false);
}

function jogar()
{

    global $tentativas, $cartaSecreta, $pontuação, $baralhos, $i;
    $tentativas++;

    echo "\033[H\033[J";

    echo "==================================================\n";
    escreverDevagar("    BEM-VINDO AO JOGO DE ADIVINHAÇÃO DA CARTA!    \n");
    echo "==================================================\n";
    echo "Tente adivinhar qual carta eu sorteei.\n\n";

    if ($tentativas > 1) {
        echo "\n💡 DICA: " . $cartaSecreta->getDica() . "\n";
    }

    echo "--------------------------------------------------\n";
    echo "Cartas disponíveis no baralho:\n";

    foreach ($baralhos[$i - 1] as $carta) {
        echo "[Número: " . $carta->getNumero() . "] - " . $carta->getNome() . "\n";
    }

    echo "--------------------------------------------------\n";
    echo "Pontuação Atual: $pontuação pontos\n";
    echo "Digite o número da carta que você acha que é a carta secreta(se desejar sair digite o número 0): ";
}

function menu()
{
    echo "\033[H\033[J";
    echo "==================================================\n";
    echo "    BEM-VINDO AO JOGO DE ADIVINHAÇÃO DE CARTAS!    \n";
    echo "==================================================\n";

    echo "                1. Jogar\n";
    echo "                2. Explicação\n";
    echo "                3. Sair\n";
    echo "--------------------------------------------------\n";
    
}

function listar(){

    global $vitorias;
    
    echo "Vitórias e pontuações acumuladas:\n";
    foreach ($vitorias as $index => $pontuacao) {
        echo "Jogo " . ($index + 1) . ": " . $pontuacao . " pontos\n";
    }

}

function telaDeCarregamento($segundos = 4) 
{
    $tamanhoBarra = 20;
    $passos = 100;
    $intervalo = ($segundos * 1000000) / $passos;

    for ($i = 0; $i <= $passos; $i++) {
        $porcentagem = $i;
        $preenchido = (int)($tamanhoBarra * $i / $passos);
        
        $barra = str_repeat("█", $preenchido) . str_repeat("-", $tamanhoBarra - $preenchido);
        
        echo "\rCarregando: [{$barra}] {$porcentagem}%";
        flush();// flush() é usado para forçar a saída do buffer, garantindo que o progresso seja exibido em tempo real.
        
        usleep($intervalo);// usleep() é usado para pausar a execução do script por um determinado número de microssegundos, permitindo que o progresso seja exibido de forma gradual.
    }

}

function escreverDevagar($texto, $velocidade = 50000) 
{
    $tamanho = strlen($texto);
    for ($i = 0; $i < $tamanho; $i++) {
        echo $texto[$i];
        flush();// flush() é usado para forçar a saída do buffer, garantindo que o texto seja exibido em tempo real.
        usleep($velocidade);// usleep() é usado para pausar a execução do script por um determinado número de microssegundos, permitindo que o texto seja exibido de forma gradual.
    }
    echo "\n";
}
