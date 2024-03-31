<?php

namespace App\Http\Controllers;

use App\Models\Article;
use GuzzleHttp\Client;
use Illuminate\Http\Request;

class NewsController extends Controller
{
    public function fetchAndSaveNews()
    {
        // Verificar si hay información y eliminarla si existe
        if (Article::count() > 0) {
            Article::truncate(); // Eliminar todos los registros
        }

        // Ejecutar el script adaptado a Laravel y guardar los datos
        $client = new Client();
        $rapidKey = env('RAPIDKEY');

        $response = $client->request('GET', 'https://tank01-fantasy-stats.p.rapidapi.com/getNBANews?recentNews=true&maxItems=10', [
            'headers' => [
                'X-RapidAPI-Host' => 'tank01-fantasy-stats.p.rapidapi.com',
                'X-RapidAPI-Key' =>  $rapidKey,
            ],
        ]);

        $data = json_decode($response->getBody(), true);

        // Guardar los datos en la base de datos
        foreach ($data['body'] as $newsItem) {
            Article::create([
                'link' => $newsItem['link'],
                'image' => $newsItem['image'],
                'title' => $newsItem['title'],
            ]);
        }

        return response()->json(['message' => 'Datos guardados exitosamente en la base de datos']);
    }

    public function getNewsAll()
    {
        $news = Article::all();
        return response()->json($news);
    }
}
