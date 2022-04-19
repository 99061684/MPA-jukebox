<?php

namespace App\Http\Controllers;

use App\Models\Song;
use App\Models\Genre;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;

class SongController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function overviewAll()
    {
        $genres = Genre::all();
        $songs = Song::all();
        return view('Song.index', [
            'songs' => $songs,
            'genres' => $genres
        ]);
    }

    public function overview($genreid)
    {
        $genres = Genre::all();
        $songs = Song::where('genre_id', $genreid)->get();
        return view('Song.index', [
            'songs' => $songs,
            'genres' => $genres,
            'genreid' => $genreid
        ]);
    }

    public function sortandsearch(Request $request)
    {
        if ($request->has('search')) {
            Session::put('sortandsearch.search', $request->input('search'));
        } else if (!Session::has('sortandsearch.search')) {
            Session::put('sortandsearch.search', '');
        }
        if ($request->has('genreid')) {
            Session::put('sortandsearch.genreid', $request->input('genreid'));
        } else if (!Session::has('sortandsearch.genreid')) {
            Session::put('sortandsearch.genreid', null);
        }
        if ($request->has('sort')) {
            Session::put('sortandsearch.sort', $request->input('sort'));
        } else if (!Session::has('sortandsearch.sort')) {
            Session::put('sortandsearch.sort', 'name');
        }
        if ($request->has('order')) {
            Session::put('sortandsearch.sort', $request->input('order'));
        } else if (!Session::has('sortandsearch.order')) {
            Session::put('sortandsearch.order', 'asc');
        }

        $searchstring = Session::get('sortandsearch.search');
        $search = explode(' ', $searchstring);
        $genreid = Session::get('sortandsearch.genreid');
        $sort = Session::get('sortandsearch.sort');
        $order = Session::get('sortandsearch.order');
        $songs = Song::when($searchstring !== '' && $searchstring !== null, function ($query) use ($search) {
                foreach ($search as $word) {
                    if(strlen($word) > 2) {
                        $query->orWhere('name', 'like', '%' . $word . '%');
                        $query->orWhere('artist', 'like', '%' . $word . '%');
                        $query->orWhere('band', 'like', '%' . $word . '%');
                        $query->orWhere('album', 'like', '%' . $word . '%');
                    }
                }
            })->when($genreid !== null, function ($query, $genreid) {
                return $query->where('genre_id', $genreid);
            })
            ->orderBy($sort, $order)
            ->get();
        $genres = Genre::all();
        return view('Song.index', [
            'songs' => $songs,
            'genres' => $genres,
            'genreid' => $genreid,
            'search' => $search,
            'sort' => $sort,
            'order' => $order
        ]);
    }

    public function sort(Request $request)
    {
        Session::put('sortandsearch.sort',$request->sort);
        Session::put('sortandsearch.order',$request->order);
        $genres = Genre::all();
        if ($request->has('sort') && $request->has('order') && $request->has('genreid') && $request->genreid !== null) {
            $songs = Song::where('genre_id', $request->genreid)->orderBy($request->sort, $request->order)->get();
        } else if ($request->has('sort') && $request->has('order')) {
            $songs = Song::orderBy($request->sort, $request->order)->get();
        }  else if ($request->has('sort') && !$request->has('order')) {
            $songs = Song::orderBy($request->sort, 'asc')->get();
        } else {
            $songs = Song::all();
        }
        return view('Song.index', [
            'songs' => $songs,
            'genres' => $genres,
            'genreid' => $request->genreid,
            'sort' => $request->sort,
            'order' => $request->order
        ]);
    }

    public function search(Request $request)
    {
        Session::put('sortandsearch.search',$request->search);
        Session::put('sortandsearch.genreid',$request->genreid);
        $genres = Genre::all();
        if ($request->has('search') && $request->has('genreid') && $request->genreid !== null) {
            $search = explode(' ', $request->search);
            $songs = Song::where('genre_id', $request->genreid)->where(function ($query) use ($search) {
                foreach ($search as $word) {
                    if(strlen($word) > 2) {
                        $query->orWhere('name', 'like', '%' . $word . '%');
                        $query->orWhere('artist', 'like', '%' . $word . '%');
                        $query->orWhere('band', 'like', '%' . $word . '%');
                        $query->orWhere('album', 'like', '%' . $word . '%');
                    }
                }
            })->get();
        } else if ($request->has('search')) {
            $search = explode(' ', $request->search);
            $songs = Song::where(function ($query) use ($search) {
                foreach ($search as $word) {
                    $query->orWhere('name', 'like', '%' . $word . '%');
                    $query->orWhere('artist', 'like', '%' . $word . '%');
                    $query->orWhere('band', 'like', '%' . $word . '%');
                    $query->orWhere('album', 'like', '%' . $word . '%');
                }
            })->get();
        } else if ($request->has('genreid') && $request->genreid !== null) {
            $songs = Song::where('genre_id', $request->genreid)->get();
        } else {
            $songs = Song::all();
        }
        return view('Song.index', [
            'songs' => $songs,
            'genres' => $genres,
            'genreid' => $request->genreid,
            'search' => $request->search
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {

        return view('Song.show', [
            'song' => Song::find($id)
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
