<?php
//Fonction pour génerer un token d'authentification
function getToken(): string
{
    return bin2hex(random_bytes(16));
}