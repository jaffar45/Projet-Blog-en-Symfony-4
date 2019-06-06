<?php


namespace App\Service;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;



class Slugify
{
    public function generate(string $input) : string
    {
        setlocale(LC_ALL, 'fr_FR.UTF8');
        $result = iconv('UTF-8', 'ASCII//TRANSLIT//IGNORE', $input);
        $result= preg_replace('/[^A-Za-z0-9\-]/', '', $result);
        $result= str_replace('-', ' ', $result);
        return $result;
    }
}