<?php

namespace App\Http\Controllers;

use App\Models\News;
use Illuminate\Http\Request;

class NewsController extends Controller
{
    public function index()
    {
        $news = News::all();
        return view('news.index', compact('news'));
    }

    public function create()
    {
        return view('rrhh.news.create');
    }

    public function store(Request $request)
    {
        //dd($request);
        try {
            News::create([
                'tittle' => $request['tittle'],
                'description' => $request['description'],
                'user_id' => $request['id_user'],
            ]);
            //activity('news')->withProperties(['class' => __CLASS__,'function' => __METHOD__])->log('SUCCESS');
        } catch (\Exception $e) {
            activity()
                ->withProperties(['tittle' => $request['tittle'],
                                  'description' => $request['description'],
                                  'class' => __CLASS__,
                                  'function' => __METHOD__
                                  ])
                ->log('ERROR: ' . $e->getMessage());
        }
        return redirect()->route('rrhh.index_news');
    }

    public function show(News $news)
    {
        return view('news.show', compact('news'));
    }

    public function edit(News $news)
    {
        return view('rrhh.news.edit', compact('news'));
    }

    public function update(Request $request, News $news)
    {
        $news->update([
            'tittle' => $request['tittle'],
            'description' => $request['description'],
        ]);

        return redirect()->route('rrhh.index_news');
    }

    public function destroy(News $news)
    {
        $news->delete();

        return redirect()->route('rrhh.index_news');
    }
}
