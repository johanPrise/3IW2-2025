<?php
// En php, il errive sovent que deux classes differentes aient le meme nom, donc il faut, dans chaque fichier de declaration de ces classes, preciser le namespace
// En PHP, le controle d'existence des classes et des fonctions ainsi que des fichiers lors des importations ne se fait pas automatiquement, donc les etapes de creation et d'utilisation de la classe PHP sont :
// 0. Verification de l'existence du fichier de declaration de la classe
// Ob. Verification de l'existence de la class dans le fichier
// 1. Declaration de la class
// 2. Importation de la class
// 3. Creation d'instance de la class
// verficiation de l'existence des méthodes de la class
// 4. Appel des methodes de la class
namespace Controllers;

class Auth
{
    public function login(): void
    {
        echo "Auth login";
    }

    public function register(): void
    {
        echo "Auth register";
    }

    public function logout(): void
    {
        echo "Auth logout";
    }


}