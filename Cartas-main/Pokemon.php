<?php

class Pokemon{

    public $name;
    public $tipo;
    public $experiencia;
    public $vida;
    public $ataque;
    public $defensa;

    

    function batalha($pokemons){


        $p = readline("O pokemon que deseja utilizar para a batalha: ");
        $poke = $pokemons[$p];

        $resultado = rand(0, 1);
        if($resultado == 1){
            echo "Você ganhou a batalha com o pokemon " . $poke->name . "!\n";
            $this->evoluir($poke);
        } else {
            echo "Você perdeu a batalha com o pokemon " . $poke->name . "!\n";
        }
    }

    function evoluir($pokemons){

        
        $pokemons->vida += rand(1, 15);
        $pokemons->ataque += rand(1, 10);
        $pokemons->defensa += rand(1, 10);
        $pokemons->experiencia += rand(1, 5);
        echo "O pokemon " . $pokemons->name . " evoluiu! Vida: " . $pokemons->vida . ", Ataque: " . $pokemons->ataque . ", Defesa: " . $pokemons->defensa . ", Experiência: " . $pokemons->experiencia . "\n";

    }

    function pokedex($pokemons){
        if (empty($pokemons[1]) && empty($pokemons[2])) {
            echo "Nenhum pokemon capturado ainda.\n";
            return;
        }

        for ($i = 1; $i <= 2; $i++) {
            echo $i."º Pokemon:\n";
            if (empty($pokemons[$i])) {
                echo "Nenhum pokemon salvo nesta posição.\n\n";
                continue;
            }

            $pokemon = $pokemons[$i]; 
            echo "Nome: " . $pokemon->name . "\n";
            echo "Tipo: " . $pokemon->tipo . "\n";
            echo "Experiência: " . $pokemon->experiencia . "\n";
            echo "Vida: " . $pokemon->vida . "\n";
            echo "Ataque: " . $pokemon->ataque . "\n";
            echo "Defesa: " . $pokemon->defensa . "\n\n";
        }
    }

    function cacar(){

        $selecionar = readline("Digite em qual posição você deseja salvar o pokemon (1 ou 2): "); 

        if ($selecionar != 1 && $selecionar != 2) {
            echo "Posição inválida. Use 1 ou 2.\n";
            return null;
        }

        $novoPokemon = new Pokemon();
        $novoPokemon->experiencia = 1;
        $novoPokemon->vida = rand(20, 50);
        $novoPokemon->ataque = rand(5, 25);
        $novoPokemon->defensa = rand(5, 15);

        $novoPokemon->name = readline("Digite o nome do pokemon: ");
        $novoPokemon->tipo = readline("Digite o tipo do pokemon: ");

        echo "Pokemon capturado: " . $novoPokemon->name . "\n";
        return [
            'slot' => $selecionar,
            'pokemon' => $novoPokemon,
        ];
    }

}

$pokemon = new Pokemon();
$pokemons = [1 => null, 2 => null];

do{

    print("!------------------MENU------------------!\n");
    print("1 - Cacar pokemon\n");
    print("2 - Ver pokedex\n");
    print("3 - Batalhar\n");
    print("4 - Sair\n");
    print("!----------------------------------------!\n");
    $opcao = readline("Digite a opção desejada: ");

    switch($opcao){
        case 1:
            $resultado = $pokemon->cacar();
            if (!empty($resultado) && isset($resultado['slot'])) {
                $pokemons[$resultado['slot']] = $resultado['pokemon'];
            }
            break;
        case 2:
            $pokemon->pokedex($pokemons);
            break;
        case 3:
            if (!empty($pokemons[1]) || !empty($pokemons[2])) {
                $pokemon->batalha($pokemons);
            } else {
                echo "Nenhum pokemon capturado para batalhar.\n";
            }
            break;
        case 4:
            echo "Saindo ...";
            break;
        default:
            echo "Opção inválida! Digite novamente.\n";
    }
}while($opcao != 4);